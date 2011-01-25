#!/usr/bin/php

<?php

require('FCGIClient.php');

$requests = array();

// Perform 4 parrallel requests.
for ($i = 0 ; $i < 4; $i++) {

    $client = new \framework\FCGIClient('localhost', '9000');

    $client->request(
        array(
            'GATEWAY_INTERFACE' => 'FastCGI/1.0',
            'REQUEST_METHOD' => 'GET',
            'SCRIPT_FILENAME' => '/var/www/html/public/index.php',
            'SERVER_SOFTWARE' => 'php/fcgiclient',
            'REMOTE_ADDR' => '127.0.0.1',
            'REMOTE_PORT' => '9985',
            'SERVER_ADDR' => '127.0.0.1',
            'SERVER_PORT' => '80',
            'SERVER_NAME' => php_uname('n'),
            'SERVER_PROTOCOL' => 'HTTP/1.1'
        ),
        ''
    );

    $requests[] = $client;
}

// Collect the responses from the previous requests.
for ($i = 0; $i < 4; $i++) {
    echo $requests[$i]->response();
}

?>
