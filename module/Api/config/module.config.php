<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Api\\V1\\Rpc\\Ping\\Controller' => 'Api\\V1\\Rpc\\Ping\\PingControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api.rpc.ping' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ping',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rpc\\Ping\\Controller',
                        'action' => 'ping',
                    ),
                ),
            ),
            'api.rest.doctrine.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.userrole' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/userrole[/:userrole_id]',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rest\\Userrole\\Controller',
                    ),
                ),
            ),
            'api.rest.doctrine.userpermission' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/userpermission[/:userpermission_id]',
                    'defaults' => array(
                        'controller' => 'Api\\V1\\Rest\\Userpermission\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api.rpc.ping',
            1 => 'api.rest.doctrine.user',
            2 => 'api.rest.doctrine.userrole',
            3 => 'api.rest.doctrine.userpermission',
        ),
    ),
    'zf-rpc' => array(
        'Api\\V1\\Rpc\\Ping\\Controller' => array(
            'service_name' => 'Ping',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'api.rpc.ping',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Api\\V1\\Rpc\\Ping\\Controller' => 'Json',
            'Api\\V1\\Rest\\User\\Controller' => 'HalJson',
            'Api\\V1\\Rest\\Userrole\\Controller' => 'HalJson',
            'Api\\V1\\Rest\\Userpermission\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Api\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Api\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Api\\V1\\Rest\\Userrole\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Api\\V1\\Rest\\Userpermission\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Api\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'Api\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'Api\\V1\\Rest\\Userrole\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'Api\\V1\\Rest\\Userpermission\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Api\\V1\\Rpc\\Ping\\Controller' => array(
            'input_filter' => 'Api\\V1\\Rpc\\Ping\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Api\\V1\\Rpc\\Ping\\Validator' => array(
            0 => array(
                'name' => 'ack',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'Acknowledge the request with a timestamp',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Api\\V1\\Rpc\\Ping\\Controller' => array(
                'actions' => array(
                    'ping' => array(
                        'GET' => false,
                        'POST' => false,
                        'PATCH' => false,
                        'PUT' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
            'Api\\V1\\Rest\\User\\Controller' => array(
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PATCH' => false,
                    'PUT' => false,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
        ),
    ),
    'zf-rest' => array(
        'Api\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'Api\\V1\\Rest\\User\\UserResource',
            'route_name' => 'api.rest.doctrine.user',
            'route_identifier_name' => 'user_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'users',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'orderBy',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Db\\Entity\\User',
            'collection_class' => 'Api\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
        'Api\\V1\\Rest\\Userrole\\Controller' => array(
            'listener' => 'Api\\V1\\Rest\\Userrole\\UserroleResource',
            'route_name' => 'api.rest.doctrine.userrole',
            'route_identifier_name' => 'userrole_id',
            'collection_name' => 'userroles',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'orderBy',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Db\\Entity\\User\\Role',
            'collection_class' => 'Api\\V1\\Rest\\Userrole\\UserroleCollection',
            'service_name' => 'Userrole',
        ),
        'Api\\V1\\Rest\\Userpermission\\Controller' => array(
            'listener' => 'Api\\V1\\Rest\\Userpermission\\UserpermissionResource',
            'route_name' => 'api.rest.userpermission',
            'route_identifier_name' => 'userpermission_id',
            'collection_name' => 'userpermissions',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'orderBy',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Db\\Entity\\User\\Permission',
            'collection_class' => 'Api\\V1\\Rest\\Userpermission\\UserpermissionCollection',
            'service_name' => 'Userpermission',
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Db\\Entity\\User' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Db\\Entity\\UserHydrator',
            ),
            'Api\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user',
                'is_collection' => true,
            ),
            'Db\\Entity\\User\\Role' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.userrole',
                'route_identifier_name' => 'userrole_id',
                'hydrator' => 'Db\\Entity\\User\\RoleHydrator',
            ),
            'Api\\V1\\Rest\\Userrole\\UserroleCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.userrole',
                'route_identifier_name' => 'userrole_id',
                'is_collection' => true,
            ),
            'Db\\Entity\\User\\Permission' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.userpermission',
                'route_identifier_name' => 'userpermission_id',
                'hydrator' => 'Db\\Entity\\User\\PermissionHydrator',
            ),
            'Api\\V1\\Rest\\Userpermission\\UserpermissionCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.userpermission',
                'route_identifier_name' => 'userpermission_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-apigility' => array(
        'doctrine-connected' => array(
            'Api\\V1\\Rest\\User\\UserResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Db\\Entity\\UserHydrator',
            ),
            'Api\\V1\\Rest\\Userrole\\UserroleResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Db\\Entity\\User\\RoleHydrator',
            ),
            'Api\\V1\\Rest\\Userrole\\UserpermissionResource' => array(
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'Db\\Entity\\User\\PermissionHydrator',
            ),
        ),
    ),
    'doctrine-hydrator' => array(
        'Db\\Entity\\UserHydrator' => array(
            'entity_class' => 'Db\\Entity\\User',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(
                'roles' => 'ZF\\Apigility\\Doctrine\\Server\\Hydrator\\Strategy\\CollectionLink',
            ),
            'filters' => array(
                'exclude' => array(
                    0 => 'password',
                    1 => 'scope',
                ),
            ),
            'use_generated_hydrator' => false,
        ),
        'Db\\Entity\\User\\RoleHydrator' => array(
            'entity_class' => 'Db\\Entity\\User\\Role',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(
                'children' => 'ZF\\Apigility\\Doctrine\\Server\\Hydrator\\Strategy\\CollectionLink',
                'permissions' => 'ZF\\Apigility\\Doctrine\\Server\\Hydrator\\Strategy\\CollectionExtract',
            ),
            'use_generated_hydrator' => false,
        ),
        'Db\\Entity\\User\\PermissionHydrator' => array(
            'entity_class' => 'Db\\Entity\\User\\Permission',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => array(),
            'filters' => array(),
            'use_generated_hydrator' => false,
        ),
    ),
);
