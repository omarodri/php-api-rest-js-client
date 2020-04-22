<?php

    $ch = curl_init( $argv[1] );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);

    $respose = curl_exec($ch);
    $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE);

    switch ($httpCode) {
        case 200:
            echo '200 ok';
            break;
        case 400:
            echo '400 Bad Request';
            break;
        case 404:
            echo '404 Not Found';
            break;
        case 500:
            echo 'Internal Server Error';
            break;
    }

?>