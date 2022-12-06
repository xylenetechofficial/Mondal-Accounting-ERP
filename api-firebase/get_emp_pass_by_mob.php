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
$limit = (isset($_POST['limit']) && !empty($_POST['limit']) && is_numeric($_POST['limit'])) ? $db->escapeString($fn->xss_clean($_POST['limit'])) : 10;
$offset = (isset($_POST['offset']) && !empty($_POST['offset']) && is_numeric($_POST['offset'])) ? $db->escapeString($fn->xss_clean($_POST['offset'])) : 0;
$mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
if (isset($_POST['accesskey'])) {
    $access_key_received = $db->escapeString($fn->xss_clean($_POST['accesskey']));
    if ($access_key_received == $access_key) {
        $sql_query = "SELECT password FROM emp_joining_form WHERE mobile = '$mobile' ORDER BY name ASC";
        $db->sql($sql_query);
        $res = $db->getResult();
        if (!empty($res)) {
            
            $response['error'] = false;
            $response['message'] = "Employees Password Retrived Successfully!";
            //$response['data'] = $res;
            $response['passowrd'] = $res[0]['password'];
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
    $response['message'] = "accesskey is require.";
    print_r(json_encode($response));
}
$db->disconnect();
