<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');
$db = new Database();
$db->connect();
include_once('../includes/variables.php');
include_once('verify-token.php');
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

$config = $fn->get_configurations();
$time_slot_config = $fn->time_slot_config();
$time_zone = $fn->set_timezone($config);
if (!$time_zone) {
    $response['error'] = true;
    $response['message'] = "Time Zone is not set.";
    print_r(json_encode($response));
    return false;
    exit();
}

/* 
1.emp_calendar_data.php
    accesskey:90336
    emp_id:1 
    emp_no:e123456
    M:september
    Y:2022
    limit:10    // {optional}
    offset:0    // {optional}
*/
/*
if (!verify_token()) {
    return false;
}*/
$limit = (isset($_POST['limit']) && !empty($_POST['limit']) && is_numeric($_POST['limit'])) ? $db->escapeString($fn->xss_clean($_POST['limit'])) : 10;
$offset = (isset($_POST['offset']) && !empty($_POST['offset']) && is_numeric($_POST['offset'])) ? $db->escapeString($fn->xss_clean($_POST['offset'])) : 0;
$emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
$emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
$M = (isset($_POST['month'])) ? $db->escapeString($fn->xss_clean($_POST['month'])) : "";
$Y = (isset($_POST['year'])) ? $db->escapeString($fn->xss_clean($_POST['year'])) : "";

$datetime = date("Y-m-d H:i:s");
//$date = date('Y-m-d');
$date = strtotime("$M $Y");

$start_date = date('Y-m-01', $date);
$end_date  = date('Y-m-t', $date);

if (isset($_POST['accesskey'])) {
    $access_key_received = $db->escapeString($fn->xss_clean($_POST['accesskey']));
    if ($access_key_received == $access_key) {

        $sql_query = "SELECT DISTINCT date, emp_no, attendance, in_time, out_time, hours, tot_hours, ot_hours FROM `emp_attendance` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND emp_id =" . $emp_id . " ORDER BY id ASC";
        $db->sql($sql_query);
        $res = $db->getResult();
        for ($i = 0; $i < count($res); $i++) {

            $date = $res[$i]['date'];
            $emp_no = $res[$i]['emp_no'];
            $in_time = $res[$i]['in_time'];
            $out_time = $res[$i]['out_time'];
            $tot_hours = $res[$i]['tot_hours'];
            $hours = $res[$i]['hours'];
            $ot_hours = $res[$i]['ot_hours'];
            $attendance = $res[$i]['attendance'];
            //$tmp = [];
        }

        if (!empty($res)) {

            //$res = $tmp;
            $response['error'] = false;
            $response['message'] = "Data Retrived Successfully!";
            //$response["month_year"]   = $date;
            $response["month"]   = $M;
            $response["year"]   = $Y;
            $response['start_date'] = $start_date;
            $response['end_date'] = $end_date;
            $response['data'] = $res;

            /*
            $response['date'] = $date;
            $response['emp_no'] = $emp_no;
            $response['attendance'] = $attendance;
            $response['in_time'] = $in_time;
            $response['out_time'] = $out_time;
            $response['hours'] = $hours;
            $response['tot_hours'] = $tot_hours;
            $response['ot_hours'] = $ot_hours;
            */
        } else {
            $response['error'] = true;
            $response['message'] = "No data found!";
        }
        print_r(json_encode($response));
    } else {
        $response['error'] = true;
        $response['message'] = "accesskey is incorrect.";
        print_r(json_encode($response));
    }
} else {
    $response['error'] = true;
    $response['message'] = "accesskey is required.";
    print_r(json_encode($response));
}
$db->disconnect();
