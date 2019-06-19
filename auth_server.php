<?php

$method = strtoupper( $_SERVER['REQUEST_METHOD'] );

$token = "5d0937455b6744.68357201";

if ( $method === 'POST' ) {
    if ( !array_key_exists( 'HTTP_X_CLIENT_ID', $_SERVER ) || !array_key_exists( 'HTTP_X_SECRET', $_SERVER ) ) {
        http_response_code( 400 );

        die( 'Faltan parametros' );
    }

    $clientId = $_SERVER['HTTP_X_CLIENT_ID'];
    $secret = $_SERVER['HTTP_X_SECRET'];

    if ( $clientId !== '1' || $secret !== 'SuperSecreto!' ) {
        http_response_code( 403 );

        die ( "No autorizado");
    }

    echo "$token";
} elseif ( $method === 'GET' ) {
    if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {
        http_response_code( 400 );

        die ( 'Faltan parametros' );
    }

    if ( $_SERVER['HTTP_X_TOKEN'] == $token ) {
        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}