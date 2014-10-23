<?php
return array(
    'Api\\V1\\Rpc\\Ping\\Controller' => array(
        'GET' => array(
            'description' => 'Ping the API for availability and receive a timestamp for acknowledgement',
            'request' => null,
            'response' => '{
   "ack": "Acknowledge the request with a timestamp"
}',
        ),
        'description' => 'Ping the API for availability',
    ),
    'Api\\V1\\Rest\\User\\Controller' => array(
        'description' => 'Users',
    ),
);
