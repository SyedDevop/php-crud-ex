<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

require_once 'db.php';


if ($method === 'GET') {
  $res =  get_all_todos();

  echo json_encode(array('status' => '200', 'message' => 'Lis of todos retrieved successfully.', 'data' => $res));
} else {
  http_response_code(400);
  $result['status'] = '400';
  $result['message'] = "Expected GET request, got $method";
  echo json_encode($result);
}
