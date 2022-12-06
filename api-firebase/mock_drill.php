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

if ((isset($_POST['type'])) && ($_POST['type'] == 'mock_drill')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $drill_date = (isset($_POST['drill_date'])) ? $db->escapeString($fn->xss_clean($_POST['drill_date'])) : "";
    $drill_type = (isset($_POST['drill_type'])) ? $db->escapeString($fn->xss_clean($_POST['drill_type'])) : "";
    $fire = (isset($_POST['fire'])) ? $db->escapeString($fn->xss_clean($_POST['fire'])) : "";
    $gas_leak = (isset($_POST['gas_leak'])) ? $db->escapeString($fn->xss_clean($_POST['gas_leak'])) : "";
    $fall_down = (isset($_POST['fall_down'])) ? $db->escapeString($fn->xss_clean($_POST['fall_down'])) : "";
    $other = (isset($_POST['other'])) ? $db->escapeString($fn->xss_clean($_POST['other'])) : "";
    $start_time = (isset($_POST['start_time'])) ? $db->escapeString($fn->xss_clean($_POST['start_time'])) : "";
    $end_time = (isset($_POST['end_time'])) ? $db->escapeString($fn->xss_clean($_POST['end_time'])) : "";
    $total_time = (isset($_POST['total_time'])) ? $db->escapeString($fn->xss_clean($_POST['total_time'])) : "";
    $alarm_worked = (isset($_POST['alarm_worked'])) ? $db->escapeString($fn->xss_clean($_POST['alarm_worked'])) : "";
    $describe_alarm = (isset($_POST['describe_alarm'])) ? $db->escapeString($fn->xss_clean($_POST['describe_alarm'])) : "";
    $describe_situation = (isset($_POST['describe_situation'])) ? $db->escapeString($fn->xss_clean($_POST['describe_situation'])) : "";
    $location = (isset($_POST['location'])) ? $db->escapeString($fn->xss_clean($_POST['location'])) : "";

    $data = array(); {
        $data = array(
            'drill_date' => $drill_date,
            'drill_type' => $drill_type,
            'fire' => $fire,
            'gas_leak' => $gas_leak,
            'fall_down' => $fall_down,
            'other' => $other,
            'start_time' => $start_time,
            'end_time'=> $end_time,
            'total_time' => $total_time,
            'alarm_worked'=> $alarm_worked,
            'describe_alarm' => $describe_alarm,
            'describe_situation' => $describe_situation,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('mock_drill', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Mock Drill Report Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Mock Drill Report Not Submitted";
    echo json_encode($response);
}
