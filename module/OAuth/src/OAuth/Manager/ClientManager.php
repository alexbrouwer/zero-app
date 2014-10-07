<?php


namespace OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use OAuth\Entity\ClientInterface;
use OAuth\Entity\UserInterface;
use ZF\OAuth2\Controller\Exception;

class ClientManager
{

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var string
     */
    private $identifierProperty = 'identifier';

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager, array $config = array())
    {
        $this->objectManager = $objectManager;

        if (!isset($config['client']) || empty($config['client'])) {
            throw new Exception\RuntimeException( 'The client configuration [\'zf-oauth2\'][\'storage_settings\'][\'client\'] for OAuth2 is missing');
        }

        $refl = new \ReflectionClass($config['client']);
        if(!$refl->implementsInterface('OAuth\\Entity\\ClientInterface')) {
            throw new Exception\RuntimeException('The class specified in [\'zf-oauth2\'][\'storage_settings\'][\'client\'] must implement \OAuth\Entity\ClientInterface');
        }
        $this->entityClass = $config['client'];

        if (isset($config['usernameProperty'])) {
            $this->identifierProperty = (string)$config['identifierProperty'];
        }
    }

    /**
     * @param string $identifier
     * @return ClientInterface|null
     */
    public function getByIdentifier($identifier)
    {
        $rep = $this->objectManager->getRepository($this->entityClass);

        return $rep->findOneBy(array($this->identifierProperty => $identifier));
    }

    /**
     * @param ClientInterface $client
     * @return array
     */
    public function castToArray(ClientInterface $client)
    {
        $arr = array(
            'redirect_uri' => $client->getRedirectUri(),
            'client_id'    => $client->getIdentifier(),
            'grant_types'  => $client->getGrantTypes(),
            'user_id'      => null,
            'scope'        => $client->getScope(),
        );

        if(is_callable(array($client, 'getUser'))) {
            $user = $client->getUser();
            if($user instanceof UserInterface) {
                $arr['user_id'] = $user->getUsername();
            }
        }

        return $arr;
    }
}
