<?php


namespace Security\OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Security\Entity\OAuth\ClientInterface;
use Security\Entity\OAuth\RefreshToken;

class RefreshTokenManager extends AbstractManager
{

    /**
     * @param string $token
     * @return RefreshToken|null
     */
    public function getByToken($token)
    {
        return $this->objectRepository->findOneBy(array('token' => $token));
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

    /**
     * @param RefreshToken $refreshToken
     * @return array
     */
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
