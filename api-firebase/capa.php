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

if ((isset($_POST['type'])) && ($_POST['type'] == 'capa')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $form_no = (isset($_POST['form_no'])) ? $db->escapeString($fn->xss_clean($_POST['form_no'])) : "";
    $format_no = (isset($_POST['format_no'])) ? $db->escapeString($fn->xss_clean($_POST['format_no'])) : "";
    $audit_date = (isset($_POST['audit_date'])) ? $db->escapeString($fn->xss_clean($_POST['audit_date'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $location = (isset($_POST['location'])) ? $db->escapeString($fn->xss_clean($_POST['location'])) : "";
    $root_cause = (isset($_POST['root_cause'])) ? $db->escapeString($fn->xss_clean($_POST['root_cause'])) : "";
    $corrective_action = (isset($_POST['corrective_action'])) ? $db->escapeString($fn->xss_clean($_POST['corrective_action'])) : "";
    $preventive_action = (isset($_POST['preventive_action'])) ? $db->escapeString($fn->xss_clean($_POST['preventive_action'])) : "";
    $consequence = (isset($_POST['consequence'])) ? $db->escapeString($fn->xss_clean($_POST['consequence'])) : "";
    $responsibility = (isset($_POST['responsibility'])) ? $db->escapeString($fn->xss_clean($_POST['responsibility'])) : "";
    $target_date = (isset($_POST['target_date'])) ? $db->escapeString($fn->xss_clean($_POST['target_date'])) : "";
    $status = (isset($_POST['status'])) ? $db->escapeString($fn->xss_clean($_POST['status'])) : "";

    $data = array(); {
        $data = array(
            'form_no' => $form_no,
            'format_no' => $format_no,
            'audit_date' => $audit_date,
            'department' => $department,
            'location' => $location,
            'root_cause' => $root_cause,
            'corrective_action' => $corrective_action,
            'preventive_action'=> $preventive_action,
            'consequence' => $consequence,
            'responsibility'=> $responsibility,
            'target_date' => $target_date,
            'status' => $status
        );
    }

    $db->insert('capa', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "CAPA Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "CAPA Not Submitted";
    echo json_encode($response);
}
