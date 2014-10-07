<?php


namespace OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use OAuth\Entity\ClientInterface;
use OAuth\Entity\RefreshToken;

class RefreshTokenManager
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
     * @param string $token
     * @return RefreshToken|null
     */
    public function getByToken($token)
    {
        $rep = $this->objectManager->getRepository('OAuth\Entity\RefreshToken');

        return $rep->findOneBy(array('token' => $token));
    }

    /**
     * @param string      $token
     * @param ClientInterface      $client
     * @param string|null $username
     * @param \DateTime   $expires
     * @param string|null $scope
     */
    public function storeToken($token, ClientInterface $client, $username, \DateTime $expires, $scope)
    {
        $accessToken = $this->getByToken($token);
        if (!$accessToken) {
            $accessToken = new RefreshToken();
            $accessToken->setToken($token);
        }

        $accessToken->setClientIdentifier($client->getIdentifier());
        $accessToken->setUsername($username);
        $accessToken->setExpires($expires);
        $accessToken->setScope($scope);

        $this->objectManager->persist($accessToken);
        $this->objectManager->flush();
    }

    /**
     * @param string $token
     */
    public function removeToken($token)
    {
        $refreshToken = $this->getByToken($token);
        if ($refreshToken) {
            $this->objectManager->remove($refreshToken);
            $this->objectManager->flush();
        }
    }

    public function castToArray(RefreshToken $refreshToken)
    {
        return array(
            'refresh_token' => $refreshToken->getToken(),
            'client_id'     => $refreshToken->getClientIdentifier(),
            'user_id'       => $refreshToken->getUsername(),
            'expires'       => $refreshToken->getExpires()->getTimestamp(),
            'scope'         => $refreshToken->getScope()
        );
    }
}
