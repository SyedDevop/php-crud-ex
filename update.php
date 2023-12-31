<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('db.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
  // Get the JSON data from the request body
  $json_data = file_get_contents("php://input");
  // Decode the JSON data
  $data = json_decode($json_data);


  if ($data !== null &&  isset($data->id)) {
    $id = $data->id;
    $state = $data->state;
    $toso = $data->todo;

    if (isset($state) && !isset($toso)) {
      $res = update_status($id, $state);
      http_response_code(200);
    } else if (isset($toso) && !isset($state)) {
      $res = update_todo($id, $toso);
    } else {
      http_response_code(400);
      echo json_encode(array('status' => '400', 'message' => 'Invalid JSON data', 'data' => $_POST));
    }
  } else {
    http_response_code(400);
    echo json_encode(array('status' => '400', 'message' => 'Invalid JSON data', 'data' => $_POST));
  }
} else {
  http_response_code(400);
  $result['status'] = '400';
  $result['message'] = "Expected PUT request, got $method";
  echo json_encode($result);
}
