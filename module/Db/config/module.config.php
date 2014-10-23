<?php
return array(
    'doctrine' => [
        'driver' => [
            'db_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => [__DIR__ . '/doctrine'],
                'extension' => '.xml'
            ],
            'orm_default' => [
                'drivers' => [
                    'Db\Entity' => 'db_driver',
                ],
            ],
        ],
    ],
    'jsm_serializer' => array(
        'metadata' => array(
            'direcories' => array(
                'db' => array(
                    'namespace_prefix' => 'Db\Entity',
                    'path' => __DIR__ .'/serializer'
                )
            )
        )
    )
);
