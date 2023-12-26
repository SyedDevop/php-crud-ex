<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'DELETE') {
    // Get the raw data from the request body
    $data = file_get_contents("php://input");

    // Decode the JSON data
    $json_data = json_decode($data, true);

    // Check if decoding was successful
    if ($json_data !== null) {
        // Access the 'name' field
        $name = $json_data['name'];

        // Now you can use the $name variable as needed
        echo json_encode(array('status' => '200', 'message' => 'DELETE request received', 'name' => $name));
    } else {
        // If decoding fails, return an error response
        http_response_code(400);
        echo json_encode(array('status' => '400', 'message' => 'Invalid JSON data'));
    }
} else {
    http_response_code(404);
    $result['status'] = '404';
    $result['message'] = "Expected DELETE request, got $method";
    echo json_encode($result);
}
?>