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
		if ( !empty($resourceId) && array_key_exists( $resourceId, $books ) ) {
			$json = file_get_contents( 'php://input' );
			
			$books[ $resourceId ] = json_decode( $json, true );

			echo $resourceId;
		}
		break;
	case 'DELETE':
		break;
	default:
		header( 'Status-Code: 404' );

		echo json_encode(
			[
				'error' => $method.' not yet implemented :(',
			]
		);

		break;
}