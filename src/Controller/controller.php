<?php
// Esta línea carga un archivo data_handler.php que contiene la lógica de la aplicación para manejar los datos.
require_once __DIR__ . '/data_handler.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo get_method($_GET);
        break;
    case 'POST':
        echo post_method($_POST);
        break;
    default:
        echo json_encode(['error','Metodo de la peticion no aceptado']);
        break;
}


function post_method($params)
{
    switch ($params['action']) {
        case 'INSERT':
            $result = handler()->insert($params);
            return json_encode([$result]);
            break;
        case 'DELETE':
            $result = handler()->delete($params);
            return json_encode([$result]);
            break;
        case 'CALCULATE':
            $result = handler()->calculate($params);
            return json_encode([$result]);
        default:
            return json_encode(['error','Opcion Inexistente']);
            break;
    }
}

function get_method($params)
{
    $result = handler()->read();
    return json_encode([$result], JSON_UNESCAPED_UNICODE);
}


function handler()
{
    return $handler = new data_handler();
}