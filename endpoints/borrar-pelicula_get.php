<?php

include("services/pelicula.php");

if( !isset( $_GET[ 'id' ] ) || !$_GET[ 'id' ] )
{
    echo json_encode( [ 'error' => 'No se ha proporcionado el id de la película' ] );
    http_response_code(401);
    exit;
}

$film = new Pelicula();
$film = $film->delete( $_GET[ 'id' ] );

$response = [ 'data' => $film ];
echo json_encode( $response );