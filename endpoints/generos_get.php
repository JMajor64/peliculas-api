<?php

include("services/genero.php");

$conditions = [];

foreach( $_GET as $key => $value )
    $conditions[] = $key . " = '" . $value . "'";

$service = new Genero();

$genero = $service->get( $conditions );

$response = [ 'data' => $genero ];
echo json_encode( $response );