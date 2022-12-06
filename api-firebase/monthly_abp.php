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

if ((isset($_POST['type'])) && ($_POST['type'] == 'monthly_abp')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $abp_id = (isset($_POST['abp_id'])) ? $db->escapeString($fn->xss_clean($_POST['abp_id'])) : "";
    $abp_name = (isset($_POST['abp_name'])) ? $db->escapeString($fn->xss_clean($_POST['abp_name'])) : "";
    $plan_date = (isset($_POST['plan_date'])) ? $db->escapeString($fn->xss_clean($_POST['plan_date'])) : "";
    $actual_date = (isset($_POST['actual_date'])) ? $db->escapeString($fn->xss_clean($_POST['actual_date'])) : "";
    $month = (isset($_POST['month'])) ? $db->escapeString($fn->xss_clean($_POST['month'])) : "";
    $year = (isset($_POST['year'])) ? $db->escapeString($fn->xss_clean($_POST['year'])) : "";
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
            'abp_id' => $abp_id,
            'abp_name' => $abp_name,
            'plan_date' => $plan_date,
            'actual_date' => $actual_date,
            'month' => $month,
            'year' => $year,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('monthly_abp', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Monthly ABP Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Monthly ABP Not Submitted";
    echo json_encode($response);
}
