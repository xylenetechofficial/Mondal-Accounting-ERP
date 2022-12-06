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

if ((isset($_POST['type'])) && ($_POST['type'] == 'houskeeping_process')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $contractor_name = (isset($_POST['contractor_name'])) ? $db->escapeString($fn->xss_clean($_POST['contractor_name'])) : "";
    $section = (isset($_POST['section'])) ? $db->escapeString($fn->xss_clean($_POST['section'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $review_subject  = (isset($_POST['review_subject'])) ? $db->escapeString($fn->xss_clean($_POST['review_subject'])) : "";
    $satisfactory_yes = (isset($_POST['satisfactory_yes'])) ? $db->escapeString($fn->xss_clean($_POST['satisfactory_yes'])) : "";
    $mom_satisfactory_no = (isset($_POST['mom_satisfactory_no'])) ? $db->escapeString($fn->xss_clean($_POST['mom_satisfactory_no'])) : "";
    $remark = (isset($_POST['remark'])) ? $db->escapeString($fn->xss_clean($_POST['remark'])) : "";
    $action = (isset($_POST['action'])) ? $db->escapeString($fn->xss_clean($_POST['action'])) : "";
    $additional_remark = (isset($_POST['additional_remark'])) ? $db->escapeString($fn->xss_clean($_POST['additional_remark'])) : "";
    $inspected_by = (isset($_POST['inspected_by'])) ? $db->escapeString($fn->xss_clean($_POST['inspected_by'])) : "";
    $verify_by = (isset($_POST['verify_by'])) ? $db->escapeString($fn->xss_clean($_POST['verify_by'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $data = array(); {
        $data = array(
            'contractor_name' => $contractor_name,
            'section' => $section,
            'department' => $department,
            'date' => $date,
            'review_subject' => $review_subject,
            'satisfactory_yes' => $satisfactory_yes,
            'mom_satisfactory_no' => $mom_satisfactory_no,
            'remark' => $remark,
            'action' => $action,
            'additional_remark' => $additional_remark,
            'inspected_by' => $inspected_by,
            'verify_by' => $verify_by,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('houskeeping_process', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Tools Checklist report Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Tools Checklist report Not Submitted";
    echo json_encode($response);
}
