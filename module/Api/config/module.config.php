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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api.rpc.ping',
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
        ),
        'accept_whitelist' => array(
            'Api\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Api\\V1\\Rpc\\Ping\\Controller' => array(
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
                        'GET' => true,
                        'POST' => false,
                        'PATCH' => false,
                        'PUT' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
        ),
    ),
);
