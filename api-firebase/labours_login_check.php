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
1.get-categories.php
    accesskey:90336 
    limit:10    // {optional}
    offset:0    // {optional}
*/
/*
if (!verify_token()) {
    return false;
}
*/
$date = date("Y-m-d");
$limit = (isset($_POST['limit']) && !empty($_POST['limit']) && is_numeric($_POST['limit'])) ? $db->escapeString($fn->xss_clean($_POST['limit'])) : 10;
$offset = (isset($_POST['offset']) && !empty($_POST['offset']) && is_numeric($_POST['offset'])) ? $db->escapeString($fn->xss_clean($_POST['offset'])) : 0;
$id = $db->escapeString($fn->xss_clean($_POST['id']));
if (isset($_POST['accesskey'])) {
    $access_key_received = $db->escapeString($fn->xss_clean($_POST['accesskey']));
    if ($access_key_received == $access_key) {
        $sql_query = "SELECT * FROM `emp_attendance` WHERE date = '$date' AND emp_id = '$id'";
        $db->sql($sql_query);
        $res = $db->getResult();
        $is_logged_in = $res[0]['is_logged_in'];
        if (!empty($res)) {
            if ($is_logged_in == 'true') {

                $response['error'] = false;
                $response['message'] = "Employee Already Logged in";
                //$response['data'] = $res;
            } else {
                $response['error'] = false;
                $response['message'] = "Employee Already Logged Out";
                //$response['data'] = $res;
            }
        } else {
            $response['error'] = false;
            $response['message'] = "Employee Not Logged in";
        }
        print_r(json_encode($response));
    } else {
        $response['error'] = true;
        $response['message'] = "accesskey is incorrect.";
        print_r(json_encode($response));
    }
} else {
    $response['error'] = true;
    $response['message'] = "accesskey is require.";
    print_r(json_encode($response));
}
$db->disconnect();
