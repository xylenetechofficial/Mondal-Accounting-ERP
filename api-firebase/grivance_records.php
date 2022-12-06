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

if ((isset($_POST['type'])) && ($_POST['type'] == 'grivance_records')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $grivance_open = (isset($_POST['grivance_open'])) ? $db->escapeString($fn->xss_clean($_POST['grivance_open'])) : "";
    $grivance_close = (isset($_POST['grivance_close'])) ? $db->escapeString($fn->xss_clean($_POST['grivance_close'])) : "";
    $month = (isset($_POST['month'])) ? $db->escapeString($fn->xss_clean($_POST['month'])) : "";
    $year = (isset($_POST['year'])) ? $db->escapeString($fn->xss_clean($_POST['year'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $prepared_by_name = (isset($_POST['prepared_by_name'])) ? $db->escapeString($fn->xss_clean($_POST['prepared_by_name'])) : "";
    $prepared_by_sign = (isset($_POST['prepared_by_sign'])) ? $db->escapeString($fn->xss_clean($_POST['prepared_by_sign'])) : "";
    $checked_by_name = (isset($_POST['checked_by_name'])) ? $db->escapeString($fn->xss_clean($_POST['checked_by_name'])) : "";
    $checked_by_sign = (isset($_POST['checked_by_sign'])) ? $db->escapeString($fn->xss_clean($_POST['checked_by_sign'])) : "";
    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);
    //$created_at = (isset($_POST['created_at'])) ? $db->escapeString($fn->xss_clean($_POST['created_at'])) : "";
    //$updated_at = (isset($_POST['updated_at'])) ? $db->escapeString($fn->xss_clean($_POST['updated_at'])) : "";
    $data = array(); {
        $data = array(
            //'abp_id' => $abp_id,
            //'topic' => $topic,
            'grivance_open' => $grivance_open,
            'grivance_close' => $grivance_close,
            'month' => $month,
            'year' => $year,
            'date' => $date,
            'prepared_by_name' => $prepared_by_name,
            'prepared_by_sign' => $prepared_by_sign,
            'checked_by_name' => $checked_by_name,
            'checked_by_sign' => $checked_by_sign,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    $response["error"]   = false;
    $response["message"] = "Grivance Records Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Grivance Records Not Submitted";
    echo json_encode($response);
}
