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

if ((isset($_POST['type'])) && ($_POST['type'] == 'attendance_in_time')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
    $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    $in_time = (isset($_POST['in_time'])) ? $db->escapeString($fn->xss_clean($_POST['in_time'])) : "";
    $in_time_latitude = (isset($_POST['in_time_latitude'])) ? $db->escapeString($fn->xss_clean($_POST['in_time_latitude'])) : "";
    $in_time_longitude = (isset($_POST['in_time_longitude'])) ? $db->escapeString($fn->xss_clean($_POST['in_time_longitude'])) : "";
    $in_time_location = (isset($_POST['in_time_location'])) ? $db->escapeString($fn->xss_clean($_POST['in_time_location'])) : "";
    $is_logged_in = 'true';

    $data = array(); {
        $data = array(
            'emp_id' => $emp_id,
            'emp_no' => $emp_no,
            'in_time' => $in_time,
            'in_time_latitude' => $in_time_latitude,
            'in_time_longitude' => $in_time_longitude,
            'in_time_location' => $in_time_location,
            'is_logged_in' => $is_logged_in,
            'date'=> $date,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('emp_attendance_staff', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "In Time Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "In Time Not Submitted";
    echo json_encode($response);
}
