<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $todo = $_POST["todo"];
    $id = $_POST["id"];
    // Check if decoding was successful
    if ($todo !== null) {
        // Now you can use the todo variable as needed
        echo json_encode(array('status' => '200',  'todo' => $todo,'id' => $id));
    } else {
        // If decoding fails, return an error response
        http_response_code(400);
        echo json_encode(array('status' => '400', 'message' => 'Invalid JSON data','data' =>$_POST));
    }
} else {
    http_response_code(400);
    $result['status'] = '400';
    $result['message'] = "Expected PUT request, got $method";
    echo json_encode($result);
}
?>
