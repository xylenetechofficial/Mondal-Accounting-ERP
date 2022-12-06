<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

session_start();
include_once '../includes/crud.php';
include_once('../includes/variables.php');
include_once('verify-token.php');
$db = new Database();
$db->connect();
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
1.login.php
    accesskey:90336
    type:labours or staff
    mobile:1234567890
    password:emp123
    status:1   // 1 - Active & 0 Deactive
*/

$accesskey = $db->escapeString($fn->xss_clean($_POST['accesskey']));

if ($access_key != $accesskey) {
    $response['error'] = true;
    $response['message'] = "invalid accesskey";
    print_r(json_encode($response));
    return false;
}
/*
if (!verify_token()) {
    return false;
}
*/
if (isset($_POST['type']) && $_POST['type'] != '' && $_POST['type'] == 'labours') {

    if (isset($_POST['mobile']) && $_POST['mobile'] != '' && isset($_POST['password']) && $_POST['password'] != '') {
        $mobile    = $db->escapeString($fn->xss_clean($_POST['mobile']));
        $password    = $db->escapeString($fn->xss_clean($_POST['password']));
        $response = array();
        if (!empty($mobile) && !empty($password)) {
            //$password  = md5($password);
            $sql_query = "SELECT * FROM `emp_joining_form` WHERE `mobile` = '" . $mobile . "' AND `password` ='" . $password . "' AND `emp_type_id` ='2'";
            $db->sql($sql_query);
            $result = $db->getResult();
            if ($db->numRows($result) > 0) {
                /*
            $fcm_id = (isset($_POST['fcm_id']) && !empty($_POST['fcm_id'])) ? $db->escapeString($fn->xss_clean($_POST['fcm_id'])) : "";
            if (!empty($fcm_id)) {
                $sql = "update `emp_joining_form` set `fcm_id` ='" . $fcm_id . "' where id = " . $result[0]['id'];
                $db->sql($sql);
            }
*/
                foreach ($result as $row) {
                    $response['error']     = false;
                    $response['message'] = "Successfully logged in!";
                    $response['emp_id'] = $row['id'];
                    $response['emp_no'] = $row['emp_no'];
                    $response['name'] = $row['name'];
                    $response['profile'] = $row['profile'];
                    $response['mobile'] = $row['mobile'];
                    $response['dob'] = $row['dob'];
                    $response['latitude'] = (!empty($row['latitude'])) ? $row['latitude'] : '0';
                    $response['longitude'] = (!empty($row['longitude'])) ? $row['longitude'] : '0';
                    $response['created_at'] = $row['created_at'];
                }
            } else {
                $response['error']     = true;
                $response['message']   = "Invalid mobile or password!";
            }
        }
        print_r(json_encode($response));
    } else {
        $response['message'] = "Mobile and password should be filled";
        print_r(json_encode($response));
    }
}
if (isset($_POST['type']) && $_POST['type'] != '' && $_POST['type'] == 'staff') {
    if (isset($_POST['mobile']) && $_POST['mobile'] != '' && isset($_POST['password']) && $_POST['password'] != '') {
        $mobile    = $db->escapeString($fn->xss_clean($_POST['mobile']));
        $password    = $db->escapeString($fn->xss_clean($_POST['password']));
        $response = array();
        if (!empty($mobile) && !empty($password)) {
            //$password  = md5($password);
            $sql_query = "SELECT * FROM `emp_joining_form` WHERE `mobile` = '" . $mobile . "' AND `password` ='" . $password . "' AND `emp_type_id` ='1'";
            $db->sql($sql_query);
            $result = $db->getResult();
            if ($db->numRows($result) > 0) {
                /*
            $fcm_id = (isset($_POST['fcm_id']) && !empty($_POST['fcm_id'])) ? $db->escapeString($fn->xss_clean($_POST['fcm_id'])) : "";
            if (!empty($fcm_id)) {
                $sql = "update `emp_joining_form` set `fcm_id` ='" . $fcm_id . "' where id = " . $result[0]['id'];
                $db->sql($sql);
            }
*/
                foreach ($result as $row) {
                    $response['error']     = false;
                    $response['message'] = "Successfully logged in!";
                    $response['emp_id'] = $row['id'];
                    $response['emp_no'] = $row['emp_no'];
                    $response['name'] = $row['name'];
                    $response['profile'] = $row['profile'];
                    $response['mobile'] = $row['mobile'];
                    $response['dob'] = $row['dob'];
                    $response['latitude'] = (!empty($row['latitude'])) ? $row['latitude'] : '0';
                    $response['longitude'] = (!empty($row['longitude'])) ? $row['longitude'] : '0';
                    $response['created_at'] = $row['created_at'];
                }
            } else {
                $response['error']     = true;
                $response['message']   = "Invalid mobile or password!";
            }
        }
        print_r(json_encode($response));
    } else {
        $response['message'] = "Mobile and password should be filled";
        print_r(json_encode($response));
    }
}
$db->disconnect();
