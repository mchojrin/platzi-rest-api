<?php

header( 'Content-Type: application/json' );

switch ( strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
	case 'GET':

		break;
	case 'POST':

		break;

	case 'PUT':

		break;
	
	case 'DELETE':

		break;
}

echo json_encode( [
	'resource_type' => $_GET['resource_type'],
	'resource_id' => $_GET['resource_id'],
] );
