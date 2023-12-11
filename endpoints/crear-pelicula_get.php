<?php

use api\helpers\DateHelper;

include("services/pelicula.php");
include("helpers/DateHelper.php");

if( !isset( $_GET[ 'title' ] ) || !$_GET[ 'title' ] || !trim( $_GET[ 'title' ] ) )
{
    echo json_encode( [ 'error' => 'No se ha proporcionado el titúlo de la película' ] );
    http_response_code(401);
    exit;
}

if( !isset( $_GET[ 'genre' ] ) || !$_GET[ 'genre' ] )
{
    echo json_encode( [ 'error' => 'No se ha proporcionado el género de la película' ] );
    http_response_code(401);
    exit;
}

if( !isset( $_GET[ 'director' ] ) || !$_GET[ 'director' ]  )
{
    echo json_encode( [ 'error' => 'No se ha proporcionado el director de la película' ] );
    http_response_code(401);
    exit;
}

if( !isset( $_GET[ 'cast' ] ) || !$_GET[ 'cast' ] )
{
    echo json_encode( [ 'error' => 'No se ha proporcionado el reparto de la película' ] );
    http_response_code(401);
    exit;
}

$pelicula = [
    'title' => "'" . $_GET[ 'title' ] . "'",
    'genre' => $_GET[ 'genre' ],
    'director' => $_GET[ 'director' ],
    'cast' => $_GET[ 'cast' ],
    'description' => isset( $_GET[ 'description' ])? "'" . $_GET[ 'description' ] . "'" : 'NULL',
    'length' => isset( $_GET[ 'length' ])? $_GET[ 'length' ] : 'NULL',
    'release' => isset( $_GET[ 'release' ])? "'" . DateHelper::formatDB( $_GET[ 'release' ] ) . "'" : 'NULL',
];

$film = new Pelicula();
$film = $film->create( $pelicula );

$response = [ 'data' => $film ];
echo json_encode( $response );