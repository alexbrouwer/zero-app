<?php


namespace OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use OAuth\Entity\UserInterface;
use ZF\OAuth2\Controller\Exception;

class UserManager
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
    private $usernameProperty = 'username';

    /**
     * @param ObjectManager $objectManager
     * @param array         $config
     */
    public function __construct(ObjectManager $objectManager, array $config = array())
    {
        $this->objectManager = $objectManager;

        if (!isset($config['user']) || empty($config['user'])) {
            throw new Exception\RuntimeException('The user configuration [\'zf-oauth2\'][\'storage_settings\'][\'user\'] for OAuth2 is missing');
        }

        $refl = new \ReflectionClass($config['user']);
        if(!$refl->implementsInterface('OAuth\\Entity\\UserInterface')) {
            throw new Exception\RuntimeException('The class specified in [\'zf-oauth2\'][\'storage_settings\'][\'user\'] must implement \OAuth\Entity\UserInterface');
        }
        $this->entityClass = $config['user'];

        if (isset($config['usernameProperty'])) {
            $this->usernameProperty = (string)$config['usernameProperty'];
        }
    }

    /**
     * @param string $username
     * @return UserInterface|null
     */
    public function getByUsername($username)
    {
        $rep = $this->objectManager->getRepository($this->entityClass);

        return $rep->findOneBy(array($this->usernameProperty => $username));
    }

    /**
     * @param UserInterface $user
     * @return array
     */
    public function castToArray(UserInterface $user)
    {
        return array(
            'user_id' => $user->getUsername(),
            'scope'   => $user->getScope()
        );
    }
}
