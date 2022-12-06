<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header("Content-Type: application/json");
include_once('../includes/variables.php');
include_once('../includes/crud.php');
include '../includes/custom-functions.php';
$fn = new custom_functions;
$fn = new custom_functions();
$config = $fn->get_configurations();
//include_once('verify-token.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$response = array();

if ((isset($_POST['type'])) && ($_POST['type'] == 'attendance_out_time')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
    $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    $attendance = (isset($_POST['attendance'])) ? $db->escapeString($fn->xss_clean($_POST['attendance'])) : "";
    $out_time = (isset($_POST['out_time'])) ? $db->escapeString($fn->xss_clean($_POST['out_time'])) : "";
    $out_time_latitude = (isset($_POST['out_time_latitude'])) ? $db->escapeString($fn->xss_clean($_POST['out_time_latitude'])) : "";
    $out_time_longitude = (isset($_POST['out_time_longitude'])) ? $db->escapeString($fn->xss_clean($_POST['out_time_longitude'])) : "";
    $out_time_location = (isset($_POST['out_time_location'])) ? $db->escapeString($fn->xss_clean($_POST['out_time_location'])) : "";
    //$in_time = (isset($_POST['in_time'])) ? $db->escapeString($fn->xss_clean($_POST['in_time'])) : "";
    $is_logged_in = 'false';

    $sql = "SELECT in_time FROM emp_attendance WHERE emp_id = '$emp_id' AND date = '$date' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $emp_time = $db->getResult();
    $in_time = $emp_time[0]['in_time'];

    //$hours = round((strtotime($out_time) - strtotime($in_time))/3600, 1);
    //$hours = (strtotime($out_time) - strtotime($in_time))/3600;
    $minutes = (strtotime($out_time) - strtotime($in_time))/3600*60;
    $hours = floor($minutes/60);
    $ext_minutes = $minutes % 60;

    if ($ext_minutes > 50)
    {
        $ext_hours = 1;
    } else {
        $ext_hours = 0;
    }

    $tot_hours = $hours + $ext_hours;

    if ($tot_hours > 9)
    {
        $ot_hours = $tot_hours - 9;
        $hours = $tot_hours - $ot_hours;
    } else {
        $ot_hours = 0;
        $hours = $tot_hours;
    }

    $sql = "UPDATE `emp_attendance` SET `attendance`='$attendance',`out_time`='$out_time',`out_time_latitude`='$out_time_latitude',`out_time_longitude`='$out_time_longitude',`out_time_location`='$out_time_location',`hours`='$hours',`tot_hours`='$tot_hours',`ot_hours`='$ot_hours',`is_logged_in`='$is_logged_in',`updated_at`='$datetime' WHERE emp_id = '$emp_id' AND date = '$date' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $emp_atten = $db->getResult();

    $sql = "SELECT * FROM `emp_attendance` WHERE emp_id = '$emp_id' AND date = '$date' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res = $db->getResult();

    $response["message"] = "Out Time Submitted Successfully";
    //$response["data"] = $emp_atten;

    foreach ($res as $row) {
        $response['error']   = "false";
        $response['emp_id'] = $row['emp_id'];
        $response['emp_no'] = $row['emp_no'];
        $response['attendance'] = $row['attendance'];
        $response['in_time'] = $row['in_time'];
        $response['in_time_latitude'] = $row['in_time_latitude'];
        $response['in_time_longitude'] = $row['in_time_longitude'];
        $response['in_time_location'] = $row['in_time_location'];
        $response['out_time'] = $row['out_time'];
        $response['out_time_latitude'] = $row['out_time_latitude'];
        $response['out_time_longitude'] = $row['out_time_longitude'];
        $response['out_time_location'] = $row['out_time_location'];
        $response['tot_hours'] = $row['hours'];
        $response['ot_hours'] = $row['ot_hours'];
        $response['is_logged_in'] = $row['is_logged_in'];
        $response['date'] = $row['date'];
        $response['created_at'] = $row['created_at'];
        $response['updated_at'] = $row['updated_at'];
    }
    
    echo json_encode($response);

} else {
    $response['error'] = "true";
    $response['message'] = "Out Time Not Submitted";
    echo json_encode($response);
}
