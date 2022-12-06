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

if ((isset($_POST['type'])) && ($_POST['type'] == 'performance_report')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $report_from = (isset($_POST['report_from'])) ? $db->escapeString($fn->xss_clean($_POST['report_from'])) : "";
    $report_to = (isset($_POST['report_to'])) ? $db->escapeString($fn->xss_clean($_POST['report_to'])) : "";
    $month_from = (isset($_POST['month_from'])) ? $db->escapeString($fn->xss_clean($_POST['month_from'])) : "";    
    $month_to = (isset($_POST['month_to'])) ? $db->escapeString($fn->xss_clean($_POST['month_to'])) : "";
    $objective = (isset($_POST['objective'])) ? $db->escapeString($fn->xss_clean($_POST['objective'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $past_perform = (isset($_POST['past_perform'])) ? $db->escapeString($fn->xss_clean($_POST['past_perform'])) : "";
    $forecast_perform = (isset($_POST['forecast_perform'])) ? $db->escapeString($fn->xss_clean($_POST['forecast_perform'])) : "";
    $actual_perform = (isset($_POST['actual_perform'])) ? $db->escapeString($fn->xss_clean($_POST['actual_perform'])) : "";
    $line_of_improve = (isset($_POST['line_of_improve'])) ? $db->escapeString($fn->xss_clean($_POST['line_of_improve'])) : "";
    $action_taken = (isset($_POST['action_taken'])) ? $db->escapeString($fn->xss_clean($_POST['action_taken'])) : "";
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev_no = (isset($_POST['rev_no'])) ? $db->escapeString($fn->xss_clean($_POST['rev_no'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $data = array(); {
        $data = array(
            'report_from' => $report_from,
            'report_to' => $report_to,
            'month_from' => $month_from,
            'month_to' => $month_to,
            'objective' => $objective,
            'department' => $department,
            'past_perform' => $past_perform,
            'forecast_perform' => $forecast_perform,
            'actual_perform' => $actual_perform,
            'line_of_improve' => $line_of_improve,
            'action_taken' => $action_taken,
            'doc_no' => $doc_no,
            'rev_no' => $rev_no,
            'date' => $date,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('performance_report', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Performance Report Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Performance Report Not Submitted";
    echo json_encode($response);
}
