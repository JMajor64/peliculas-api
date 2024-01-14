<?php

include("services/director.php");

$conditions = [];

foreach( $_GET as $key => $value )
    $conditions[] = $key . " = '" . $value . "'";

$service = new Director();

$director = $service->get( $conditions );

$response = [ 'data' => $director ];
echo json_encode( $response );