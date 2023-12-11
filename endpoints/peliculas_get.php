<?php

include("services/pelicula.php");

$conditions = [];

foreach( $_GET as $key => $value )
    $conditions[] = $key . " = '" . $value . "'";

$service = new Pelicula();

$pelicula = $service->get( $conditions );

$response = [ 'data' => $pelicula ];
echo json_encode( $response );