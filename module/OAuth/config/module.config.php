<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'OAuth\Adapter\DoctrineAdapter'   => 'OAuth\Factory\DoctrineAdapterFactory',
        )
    ),
    'doctrine' => [
        'driver' => [
            'oauth_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => [__DIR__ . '/doctrine'],
                'extension' => '.xml'
            ],
            'orm_default' => [
                'drivers' => [
                    'OAuth\Entity' => 'oauth_driver',
                ],
            ],
        ],
    ],
);
