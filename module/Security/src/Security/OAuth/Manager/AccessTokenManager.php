<?php


namespace Security\OAuth\Manager;

use Security\Entity\OAuth\AccessToken;
use Security\Entity\OAuth\ClientInterface;

class AccessTokenManager extends AbstractManager
{
    /**
     * @param string $token
     * @return AccessToken|null
     */
    public function getByToken($token)
    {
        return $this->objectRepository->findOneBy(array('token' => $token));
    }

    /**
     * @param string          $token
     * @param ClientInterface $client
     * @param string|null     $username
     * @param \DateTime       $expires
     * @param string|null     $scope
     */
    public function storeToken($token, ClientInterface $client, $username, \DateTime $expires, $scope)
    {
        $accessToken = $this->getByToken($token);
        if (!$accessToken) {
            $accessToken = new AccessToken();
            $accessToken->setToken($token);
        }

        $accessToken->setClientIdentifier($client->getIdentifier());
        $accessToken->setUsername($username);
        $accessToken->setExpires($expires);
        $accessToken->setScope($scope);

        $this->objectManager->persist($accessToken);
        $this->objectManager->flush();
    }

    public function castToArray(AccessToken $accessToken)
    {
        return array(
            'access_token' => $accessToken->getToken(),
            'client_id'    => $accessToken->getClientIdentifier(),
            'user_id'      => $accessToken->getUsername(),
            'expires'      => $accessToken->getExpires()->getTimestamp(),
            'scope'        => $accessToken->getScope(),
        );
    }
}
