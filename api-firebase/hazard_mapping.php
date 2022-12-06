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

if ((isset($_POST['type'])) && ($_POST['type'] == 'hazard')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $assesment_no = (isset($_POST['assesment_no'])) ? $db->escapeString($fn->xss_clean($_POST['assesment_no'])) : "";
    $company_name = (isset($_POST['company_name'])) ? $db->escapeString($fn->xss_clean($_POST['company_name'])) : "";
    $site_area = (isset($_POST['site_area'])) ? $db->escapeString($fn->xss_clean($_POST['site_area'])) : "";
    $revision = (isset($_POST['revision'])) ? $db->escapeString($fn->xss_clean($_POST['revision'])) : "";
    $prepared_by = (isset($_POST['prepared_by'])) ? $db->escapeString($fn->xss_clean($_POST['prepared_by'])) : "";
    $date1 = (isset($_POST['date1'])) ? $db->escapeString($fn->xss_clean($_POST['date1'])) : "";
    $sign1 = (isset($_POST['sign1'])) ? $db->escapeString($fn->xss_clean($_POST['sign1'])) : "";
    $dept = (isset($_POST['dept'])) ? $db->escapeString($fn->xss_clean($_POST['dept'])) : "";
    $date2 = (isset($_POST['date2'])) ? $db->escapeString($fn->xss_clean($_POST['date2'])) : "";
    $sign2 = (isset($_POST['sign2'])) ? $db->escapeString($fn->xss_clean($_POST['sign2'])) : "";
    $scope = (isset($_POST['scope'])) ? $db->escapeString($fn->xss_clean($_POST['scope'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $data = array(); {
        $data = array(
            'assesment_no' => $assesment_no,
            'company_name' => $company_name,
            'site_area' => $site_area,
            'revision' => $revision,
            'prepared_by' => $prepared_by,
            'date1' => $date1,
            'sign1' => $sign1,
            'dept' => $dept,
            'date2' => $date2,
            'sign2' => $sign2,
            'scope' => $scope,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('hazard', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Hazard Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Hazard Not Submitted";
    echo json_encode($response);
}
