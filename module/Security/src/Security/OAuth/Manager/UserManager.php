<?php


namespace Security\OAuth\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Security\Entity\OAuth\UserInterface;
use ZF\OAuth2\Controller\Exception;

class UserManager extends AbstractManager
{

    /**
     * @var string
     */
    private $usernameProperty = 'username';

    /**
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $objectRepository
     * @param array            $config
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $objectRepository, array $config = array())
    {
        parent::__construct($objectManager, $objectRepository);

        if (isset($config['username-property'])) {
            $this->usernameProperty = (string)$config['username-property'];
        }
    }

    /**
     * @param string $username
     * @return UserInterface|null
     */
    public function getByUsername($username)
    {
        return $this->objectRepository->findOneBy(array($this->usernameProperty => $username));
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
