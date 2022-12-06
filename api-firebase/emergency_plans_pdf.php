<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include_once('../includes/variables.php');
include_once('../includes/crud.php');
include '../includes/custom-functions.php';
$fn = new custom_functions;
$fn = new custom_functions();
//include_once('verify-token.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$response = array();

if ((isset($_POST['type'])) && ($_POST['type'] == 'emergency_plans_pdf')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $response = array();
    $sql_query = "SELECT * FROM `emergency_plans_pdf` ORDER BY `id` DESC";
    $db->sql($sql_query);
    $result = $db->getResult();
    if (!empty($result)) {
        $response['error'] = "false";
        $response['data'] = $result;
        //$response['data'] = DOMAIN_URL .$result;
    } else {
        $response['error'] = "true";
        $response['message'] = "No data found!";
    }
    print_r(json_encode($response));
}
