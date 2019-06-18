<?php

header( 'Content-Type: application/json' );

if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {

	die;
}

$url = 'http://'.$_SERVER['HTTP_HOST'].'/auth_server.php';

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_HTTPHEADER, [
	'X-Token' => $_SERVER['HTTP_X_TOKEN']
]);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$ret = curl_exec( $ch );

if ( $ret == 'false' ) {

	die;
}

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

$books = [
	1 => [
		'titulo' => 'Lo que el viento se llevo',
		'id_autor' => 2,
		'id_genero' => 2,
	],
	2 => [
		'titulo' => 'La Iliada',
		'id_autor' => 1,
		'id_genero' => 1,
	],
	3 => [
		'titulo' => 'La Odisea',
		'id_autor' => 1,
		'id_genero' => 1,
	],
];

$resourceId = array_key_exists('resource_id', $_GET ) ? $_GET['resource_id'] : '';
$method = $_SERVER['REQUEST_METHOD'];

switch ( strtoupper( $method ) ) {
	case 'GET':
		if ( "books" !== $resourceType ) {
			header( 'Status-Code: 404' );

			echo json_encode(
				[
					'error' => $resourceType.' not yet implemented :(',
				]
			);

			die;
		}

		if ( !empty( $resourceId ) ) {
			if ( array_key_exists( $resourceId, $books ) ) {
				echo json_encode(
					$books[ $resourceId ]
				);
			} else {
				header( 'Status-Code: 404' );

				echo json_encode(
					[
						'error' => 'Book '.$resourceId.' not found :(',
					]
				);
			}
		} else {
			echo json_encode(
				$books
			);
		}

		die;
		
		break;
	case 'POST':
		$json = file_get_contents( 'php://input' );

		$books[] = json_decode( $json );

		echo array_keys($books)[count($books)-1];
		break;
	case 'PUT':
	case 'DELETE':
	default:
		header( 'Status-Code: 404' );

		echo json_encode(
			[
				'error' => $method.' not yet implemented :(',
			]
		);

		break;
}