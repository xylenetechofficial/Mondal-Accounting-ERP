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

if ((isset($_POST['type'])) && ($_POST['type'] == 'date')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $M = (isset($_POST['month'])) ? $db->escapeString($fn->xss_clean($_POST['month'])) : "";
    $Y = (isset($_POST['year'])) ? $db->escapeString($fn->xss_clean($_POST['year'])) : "";
    $datetime = date("Y-m-d H:i:s");
    //$date = date('Y-m-d');
    $date = strtotime("$M $Y");

    $start_date = date('Y-m-01', $date);
    $end_date  = date('Y-m-t', $date);

    $response["error"]   = false;
    $response["date"]   = $date;
    $response["start_date"]   = $start_date;
    $response["end_date"]   = $end_date;
    $response["message"] = "In Time Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "In Time Not Submitted";
    echo json_encode($response);
}
