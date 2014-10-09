<?php


namespace Security\Authorization;

use Security\Authentication\Identity;
use Security\OAuth\Manager\UserManager;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use ZF\MvcAuth\MvcAuthEvent;

class RbacAuthorizationListener
{

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        /** @var \ZF\MvcAuth\Identity\IdentityInterface $identity */
        $identity = $mvcAuthEvent->getIdentity();

        if ($identity instanceof AuthenticatedIdentity) {
            $user = $this->userManager->getByUsername($identity->getName());
            $newId = new Identity($user);

            if (is_callable((array($user, 'getRoles')))) {
                foreach ($user->getRoles() as $child) {
                    $newId->addChild($child);
                }
            }
            $mvcAuthEvent->setIdentity($newId);
        }
    }
}
