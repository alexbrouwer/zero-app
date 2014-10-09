<?php
return array(
    'service_manager' => array(
        'aliases'   => array(
            'ZF\MvcAuth\Authorization\AuthorizationInterface' => 'Security\Authorization\RbacAuthorization',
        ),
        'factories' => array(
            'Security\OAuth\Adapter\DoctrineAdapter'           => 'Security\OAuth\Factory\DoctrineAdapterFactory',
            'Security\OAuth\Manager\UserManager'               => 'Security\OAuth\Factory\UserManagerFactory',
            'Security\OAuth\Manager\ClientManager'             => 'Security\OAuth\Factory\ClientManagerFactory',
            'Security\OAuth\Manager\AccessTokenManager'        => 'Security\OAuth\Factory\AccessTokenManagerFactory',
            'Security\OAuth\Manager\AuthorizationCodeManager'  => 'Security\OAuth\Factory\AuthorizationCodeManagerFactory',
            'Security\OAuth\Manager\RefreshTokenManager'       => 'Security\OAuth\Factory\RefreshTokenManagerFactory',
            'Security\Authorization\RbacAuthorization'         => 'Security\Authorization\RbacAuthorizationFactory',
            'Security\Authorization\RbacAuthorizationListener' => 'Security\Authorization\RbacAuthorizationListenerFactory',
        )
    ),
    'doctrine'        => [
        'driver' => [
            'security_driver' => [
                'class'     => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths'     => [__DIR__ . '/doctrine'],
                'extension' => '.xml'
            ],
            'orm_default'     => [
                'drivers' => [
                    'Security\Entity' => 'security_driver',
                ],
            ],
        ],
    ],
);
