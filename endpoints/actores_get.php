<?php

include("services/actor.php");

$conditions = [];

foreach( $_GET as $key => $value )
    $conditions[] = $key . " = '" . $value . "'";

$service = new Actor();

$actor = $service->get( $conditions );

$response = [ 'data' => $actor ];
echo json_encode( $response );