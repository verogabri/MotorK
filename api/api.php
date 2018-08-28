<?php
require_once __DIR__ . '/../src/bootstrap.php';

header("Content-Type:application/json");

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

$action = array_shift($request);

if ($action === 'search') {
    $car_objects = json_decode(file_get_contents(CONFIG_DATA_DIR . '/cars.json'));
    response(200, "Cars Found", $car_objects);
}

if ($action === 'detail') {
    $car_id = array_shift($request);
    $car_objects = json_decode(file_get_contents(CONFIG_DATA_DIR . '/cars.json'));
    $obj = array_filter($car_objects, function ($el) use ($car_id) {
        return $el->attrs->carId === $car_id;
    });

    if (!empty($obj)) {
        response(200, "Cars Found", current($obj));
    }
}

response(400, "Invalid Request", null);

function response($status, $status_message, $data)
{
    header("HTTP/1.1 " . $status);

    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;
    exit;
}