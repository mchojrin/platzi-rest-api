<?php

header( 'Content-Type: application/json' );

$allowedResourceTypes = [
	'books',
	'authors',
	'genres',
];

$resourceType = $_GET['resource_type'];
if ( !in_array( $resourceType, $allowedResourceTypes ) ) {
	header( 'Status-Code: 400' );
	echo json_encode(
		[
			'error' => "$resourceType is un unkown",
		]
	);
	
	die;
}

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
	'resource_type' => $resourceType,
	'resource_id' => $_GET['resource_id'],
] );
