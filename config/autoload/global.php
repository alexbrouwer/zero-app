<?php
return array(
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'route' => '/api/oauth',
                ),
            ),
        ),
    ),
    'zf-oauth2' => array(
        'storage' => 'OAuth\\Adapter\\DoctrineAdapter',
        'object_manager' => 'doctrine.entitymanager.orm_default',
        'storage_settings' => array(
            'user' => 'Db\Entity\User',
            'client' => 'Db\Entity\Client'
        ),
        'db' => array(
            'dsn_type' => 'PDO',
            'dsn' => 'Doctrine',
        ),
    ),
);
