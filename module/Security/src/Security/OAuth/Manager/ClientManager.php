<?php


namespace Security\OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Security\Entity\OAuth\ClientInterface;
use Security\Entity\OAuth\UserInterface;
use ZF\OAuth2\Controller\Exception;

class ClientManager extends AbstractManager
{

    /**
     * @var string
     */
    private $identifierProperty = 'identifier';

    /**
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $objectRepository
     * @param array            $config
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $objectRepository, array $config = array())
    {
        parent::__construct($objectManager, $objectRepository);

        if (isset($config['identifier-property'])) {
            $this->identifierProperty = (string)$config['identifier-property'];
        }
    }

    /**
     * @param string $identifier
     * @return ClientInterface|null
     */
    public function getByIdentifier($identifier)
    {
        return $this->objectRepository->findOneBy(array($this->identifierProperty => $identifier));
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

        if (is_callable(array($client, 'getUser'))) {
            $user = $client->getUser();
            if ($user instanceof UserInterface) {
                $arr['user_id'] = $user->getUsername();
            }
        }

        return $arr;
    }
}
