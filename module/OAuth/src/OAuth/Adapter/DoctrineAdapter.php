<?php


namespace OAuth\Adapter;

use OAuth\Entity\UserInterface;
use OAuth\Manager\AccessTokenManager;
use OAuth\Manager\AuthorizationCodeManager;
use OAuth\Manager\ClientManager;
use OAuth\Manager\RefreshTokenManager;
use OAuth\Manager\UserManager;
use OAuth2\Storage\AccessTokenInterface;
use OAuth2\Storage\AuthorizationCodeInterface;
use OAuth2\Storage\ClientCredentialsInterface;
use OAuth2\Storage\RefreshTokenInterface;
use OAuth2\Storage\UserCredentialsInterface;
use Zend\Crypt\Password\Bcrypt;

class DoctrineAdapter implements AuthorizationCodeInterface, AccessTokenInterface, ClientCredentialsInterface, UserCredentialsInterface, RefreshTokenInterface
{

    /**
     * @var AuthorizationCodeManager
     */
    private $authorizationCodeManager;

    /**
     * @var ClientManager
     */
    private $clientManager;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var AccessTokenManager
     */
    private $accessTokenManager;

    /**
     * @var RefreshTokenManager
     */
    private $refreshTokenManager;

    /**
     * @var int
     */
    protected $bcryptCost = 10;

    /**
     * @var Bcrypt
     */
    protected $bcrypt;

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        if (isset($config['bcrypt_cost'])) {
            $this->setBcryptCost($config['bcrypt_cost']);
        }
    }

    /**
     * Set AuthorizationCode manager
     *
     * @param AuthorizationCodeManager $authorizationCodeManager
     * @return $this
     */
    public function setAuthorizationManager(AuthorizationCodeManager $authorizationCodeManager)
    {
        $this->authorizationCodeManager = $authorizationCodeManager;

        return $this;
    }

    /**
     * Set client manager
     *
     * @param ClientManager $clientManager
     * @return $this
     */
    public function setClientManager(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;

        return $this;
    }

    /**
     * Set user manager
     *
     * @param UserManager $userManager
     * @return $this
     */
    public function setUserManager(UserManager $userManager)
    {
        $this->userManager = $userManager;

        return $this;
    }

    /**
     * Set accessToken manager
     *
     * @param AccessTokenManager $accessTokenManager
     * @return $this
     */
    public function setAccessTokenManager(AccessTokenManager $accessTokenManager)
    {
        $this->accessTokenManager = $accessTokenManager;

        return $this;
    }

    /**
     * Set refreshToken manager
     *
     * @param RefreshTokenManager $refreshTokenManager
     * @return $this
     */
    public function setRefreshTokenManager(RefreshTokenManager $refreshTokenManager)
    {
        $this->refreshTokenManager = $refreshTokenManager;

        return $this;
    }

    /**
     * @return Bcrypt
     */
    public function getBcrypt()
    {
        if (null === $this->bcrypt) {
            $this->bcrypt = new Bcrypt();
            $this->bcrypt->setCost($this->bcryptCost);
        }

        return $this->bcrypt;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setBcryptCost($value)
    {
        $this->bcryptCost = (int)$value;

        return $this;
    }

    /**
     * Check password using bcrypt
     *
     * @param UserInterface $user
     * @param string $password
     * @return bool
     */
    protected function checkPassword(UserInterface $user, $password)
    {
        return $this->verifyHash($password, $user->getPassword());
    }

    /**
     * @param $string
     */
    protected function createBcryptHash(&$string)
    {
        $string = $this->getBcrypt()->create($string);
    }

    /**
     * Check hash using bcrypt
     *
     * @param $hash
     * @param $check
     * @return bool
     */
    protected function verifyHash($check, $hash)
    {
        return $this->getBcrypt()->verify($check, $hash);
    }

    /**
     * @inheritdoc
     */
    public function getAuthorizationCode($code)
    {
        $code = $this->authorizationCodeManager->getByCode($code);
        if ($code) {
            return $this->authorizationCodeManager->castToArray($code);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = null)
    {
        // Convert some arguments to proper objects
        $expires = \DateTime::createFromFormat('U', $expires);
        $client = $this->clientManager->getByIdentifier($client_id);

        if (func_num_args() > 6) {
            $this->authorizationCodeManager->storeCode($code, $client, $user_id, $redirect_uri, $expires, $scope, func_get_arg(6));
        } else {
            $this->authorizationCodeManager->storeCode($code, $client, $user_id, $redirect_uri, $expires, $scope);
        }
    }

    /**
     * @inheritdoc
     */
    public function expireAuthorizationCode($code)
    {
        $this->authorizationCodeManager->removeCode($code);
    }

    /**
     * @inheritdoc
     */
    public function getAccessToken($oauth_token)
    {
        $token = $this->accessTokenManager->getByToken($oauth_token);
        if ($token) {
            return $this->accessTokenManager->castToArray($token);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null)
    {
        // Convert some arguments to proper objects
        $expires = \DateTime::createFromFormat('U', $expires);
        $client = $this->clientManager->getByIdentifier($client_id);

        $this->accessTokenManager->storeToken($oauth_token, $client, $user_id, $expires, $scope);
    }

    /**
     * @inheritdoc
     */
    public function checkClientCredentials($client_id, $client_secret = null)
    {
        $client = $this->clientManager->getByIdentifier($client_id);

        return $client && $this->verifyHash($client_secret, $client->getSecret());
    }

    /**
     * @inheritdoc
     */
    public function isPublicClient($client_id)
    {
        $client = $this->clientManager->getByIdentifier($client_id);

        if (!$client) {
            return false;
        }

        $secret = $client->getSecret();

        return empty($secret);
    }

    /**
     * @inheritdoc
     */
    public function getClientDetails($client_id)
    {
        $client = $this->clientManager->getByIdentifier($client_id);

        if (!$client) {
            return false;
        }

        return $this->clientManager->castToArray($client);
    }

    /**
     * @inheritdoc
     */
    public function getClientScope($client_id)
    {
        $client = $this->clientManager->getByIdentifier($client_id);

        if (!$client) {
            return false;
        }

        $scope = $client->getScope();
        if ($scope) {
            return $scope;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function checkRestrictedGrantType($client_id, $grant_type)
    {
        $client = $this->clientManager->getByIdentifier($client_id);

        if (!$client) {
            return false;
        }

        $grantTypes = $client->getGrantTypes();

        if (empty($grantTypes)) {
            return true;
        }

        return in_array($grant_type, $grantTypes);
    }

    /**
     * @inheritdoc
     */
    public function checkUserCredentials($username, $password)
    {
        if ($user = $this->userManager->getByUsername($username)) {
            return $this->checkPassword($user, $password);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getUserDetails($username)
    {
        if ($user = $this->userManager->getByUsername($username)) {
            return $this->userManager->castToArray($user);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getRefreshToken($refresh_token)
    {
        $token = $this->refreshTokenManager->getByToken($refresh_token);

        if (!$token) {
            return null;
        }

        return $this->refreshTokenManager->castToArray($token);
    }

    /**
     * @inheritdoc
     */
    public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null)
    {
        // Convert some arguments to proper objects
        $expires = \DateTime::createFromFormat('U', $expires);
        $client = $this->clientManager->getByIdentifier($client_id);

        $this->refreshTokenManager->storeToken($refresh_token, $client, $user_id, $expires, $scope);
    }

    /**
     * @inheritdoc
     */
    public function unsetRefreshToken($refresh_token)
    {
        $this->refreshTokenManager->removeToken($refresh_token);
    }
}
