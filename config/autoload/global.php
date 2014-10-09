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
        'storage' => 'Security\\OAuth\\Adapter\\DoctrineAdapter',
        'object_manager' => 'doctrine.entitymanager.orm_default',
        'storage_settings' => array(
            'user_entity_class' => 'Db\Entity\User',
            'client_entity_class' => 'Db\Entity\Client'
        ),
        'db' => array(
            'dsn_type' => 'PDO',
            'dsn' => 'Doctrine',
        ),
    ),
);
