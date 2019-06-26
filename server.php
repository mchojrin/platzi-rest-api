<?php

header( 'Content-Type: application/json' );

if ( 
	!array_key_exists('HTTP_X_HASH', $_SERVER) || 
	!array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) || 
	!array_key_exists('HTTP_X_UID', $_SERVER)  
	) {
		header( 'Status-Code: 403' );
	
		echo json_encode(
			[
				'error' => "No autorizado",
			]
		);
		
		die;
	}

list( $hash, $uid, $timestamp ) = [ $_SERVER['HTTP_X_HASH'], $_SERVER['HTTP_X_UID'], $_SERVER['HTTP_X_TIMESTAMP'] ];
$secret = 'Sh!! No se lo cuentes a nadie!';
$newHash = sha1($uid.$timestamp.$secret);

if ( $newHash !== $hash ) {
	header( 'Status-Code: 403' );
	
		echo json_encode(
			[
				'error' => "No autorizado. Hash esperado: $newHash, hash recibido: $hash",
			]
		);
		
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
			'error' => "Resource type '$resourceType' is un unkown",
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