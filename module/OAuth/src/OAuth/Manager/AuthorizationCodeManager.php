<?php


namespace OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use OAuth\Entity\AuthorizationCode;
use OAuth\Entity\ClientInterface;

class AuthorizationCodeManager
{

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $code
     * @return AuthorizationCode|null
     */
    public function getByCode($code)
    {
        $rep = $this->objectManager->getRepository('OAuth\Entity\AuthorizationCode');

        return $rep->findOneBy(array('authorizationCode' => $code));
    }

    /**
     * @param string          $code
     * @param ClientInterface $client
     * @param string|null     $username
     * @param  string         $redirectUri
     * @param \DateTime       $expires
     * @param null|string     $scope
     * @param null|string     $idToken
     */
    public function storeCode($code, ClientInterface $client, $username, $redirectUri, \DateTime $expires, $scope = null, $idToken = null)
    {
        $authorizationCode = $this->getByCode($code);
        if (!$authorizationCode) {
            $authorizationCode = new AuthorizationCode();
            $authorizationCode->setCode($code);
        }

        $authorizationCode->setClientIdentifier($client->getIdentifier());
        $authorizationCode->setUsername($username);
        $authorizationCode->setRedirectUri($redirectUri);
        $authorizationCode->setExpires($expires);
        $authorizationCode->setScope($scope);
        $authorizationCode->setIdToken($idToken);

        $this->objectManager->persist($authorizationCode);
        $this->objectManager->flush();
    }

    /**
     * @param string $code
     */
    public function removeCode($code)
    {
        $authorizationCode = $this->getByCode($code);
        if ($authorizationCode) {
            $this->objectManager->remove($authorizationCode);
            $this->objectManager->flush();
        }
    }

    /**
     * @param AuthorizationCode $authorizationCode
     * @return array
     */
    public function castToArray(AuthorizationCode $authorizationCode)
    {
        return array(
            'client_id'    => $authorizationCode->getClientIdentifier(),
            'user_id'      => $authorizationCode->getUsername(),
            'expires'      => $authorizationCode->getExpires()->getTimestamp(),
            'redirect_uri' => $authorizationCode->getRedirectUri(),
            'scope'        => $authorizationCode->getScope(),
            'id_token'     => $authorizationCode->getIdToken(),
        );
    }
}
