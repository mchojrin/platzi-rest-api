<?php

$method = strtoupper( $_SERVER['REQUEST_METHOD'] );

$token = "5d0937455b6744.68357201";

if ( $method === 'POST' ) {
    if ( !array_key_exists( 'HTTP_X_CLIENT_ID', $_SERVER ) || !array_key_exists( 'HTTP_X_SECRET', $_SERVER ) ) {
        header( 'Status-Code: 400');

        echo 'Faltan parametros';
        die;
    }

    $clientId = $_SERVER['HTTP_X_CLIENT_ID'];
    $secret = $_SERVER['HTTP_X_SECRET'];

    if ( $clientId !== '1' || $secret !== 'SuperSecreto!' ) {
        header( 'Status-Code: 403');

        echo "No autorizado";
        die;
    }

    echo "$token";
} elseif ( $method === 'GET' ) {
    if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {
        header( 'Status-Code: 400');

        echo 'Faltan parametros';

        die;
    }

    if ( $_SERVER['HTTP_X_TOKEN'] == $token ) {
        echo 'true';
    } else {
        echo 'false';
    }
} else {

    echo 'false';
}