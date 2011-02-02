#!/usr/bin/php

<?php

require('FCGIClient.php');

$requests = array();

// Perform 4 parrallel requests.
for ($i = 0 ; $i < 4; $i++) {

    $client = new \framework\FCGIClient('10.1.1.163', '9000');

    $client->request(
        array(
            'GATEWAY_INTERFACE' => 'FastCGI/1.0',
            'REQUEST_METHOD' => 'GET',
            'SCRIPT_FILENAME' => '/var/www/html/public/index.php',
            'SERVER_SOFTWARE' => 'php/fcgiclient',
            'REMOTE_ADDR' => '10.1.1.163',
            'REMOTE_PORT' => '9000',
            'SERVER_ADDR' => '10.1.1.187',
            'SERVER_PORT' => '9000',
            'SERVER_NAME' => php_uname('n'),
            'SERVER_PROTOCOL' => 'HTTP/1.1'
        ),
        ''
    );

    $requests[] = $client;
}

// Collect the responses from the previous requests.
for ($i = 0; $i < 4; $i++) {
    $response = $requests[$i]->response();
    
    if (!empty($response)) {
        echo print_r($response, true);
    }
}

?>
