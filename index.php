<?php
    // Permitir solicitudes desde cualquier origen
    header("Access-Control-Allow-Origin: *");

    // Permitir los métodos de solicitud que se van a usar
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    // Permitir ciertos encabezados HTTP
    header("Access-Control-Allow-Headers: Content-Type");

    // Establecer el tipo de contenido de la respuesta como JSON
    header("Content-Type: application/json");


    $request_method = $_SERVER['REQUEST_METHOD'];

    $url = $_SERVER['REQUEST_URI'] === '/' ? 'welcome' : $_SERVER['REQUEST_URI'] ;
    $parse = parse_url($url);
    $endpoint = $parse['path'];

    // Manejar la solicitud
    switch ($request_method) {
        case 'GET':
            include("endpoints/{$endpoint}_get.php");
        break;
        case 'POST':
            // var_dump( $_POST, $_FILES, $_SERVER, $_GET, $_REQUEST );die();
            include("endpoints/{$endpoint}_post.php");
        break;
        case 'OPTIONS':
            header("HTTP/1.1 200 OK");
        break;
        
        default:
            header("HTTP/1.1 405 Method Not Allowed");
        break;
    }
?>