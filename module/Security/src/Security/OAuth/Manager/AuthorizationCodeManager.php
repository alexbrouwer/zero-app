<?php


namespace Security\OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Security\Entity\OAuth\AuthorizationCode;
use Security\Entity\OAuth\ClientInterface;

class AuthorizationCodeManager extends AbstractManager
{

    /**
     * @param string $code
     * @return AuthorizationCode|null
     */
    public function getByCode($code)
    {
        return $this->objectRepository->findOneBy(array('authorizationCode' => $code));
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
