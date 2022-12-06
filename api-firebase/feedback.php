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

if ((isset($_POST['type'])) && ($_POST['type'] == 'feedback')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $format_no = (isset($_POST['format_no'])) ? $db->escapeString($fn->xss_clean($_POST['format_no'])) : "";
    $form_no = (isset($_POST['form_no'])) ? $db->escapeString($fn->xss_clean($_POST['form_no'])) : "";
    $revision_no = (isset($_POST['revision_no'])) ? $db->escapeString($fn->xss_clean($_POST['revision_no'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $designation = (isset($_POST['designation'])) ? $db->escapeString($fn->xss_clean($_POST['designation'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $mobile = (isset($_POST['mobile'])) ? $db->escapeString($fn->xss_clean($_POST['mobile'])) : "";
    $statement = (isset($_POST['statement'])) ? $db->escapeString($fn->xss_clean($_POST['statement'])) : "";
    $agree = (isset($_POST['agree'])) ? $db->escapeString($fn->xss_clean($_POST['agree'])) : "";
    $neither_nor = (isset($_POST['neither_nor'])) ? $db->escapeString($fn->xss_clean($_POST['neither_nor'])) : "";
    $disagree = (isset($_POST['disagree'])) ? $db->escapeString($fn->xss_clean($_POST['disagree'])) : "";
    $remarks = (isset($_POST['remarks'])) ? $db->escapeString($fn->xss_clean($_POST['remarks'])) : "";
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
            'format_no' => $format_no,
            'form_no' => $form_no,
            'revision_no' => $revision_no,
            'name' => $name,
            'department' => $department,
            'designation' => $designation,
            'date' => $date,
            'mobile' => $mobile,
            'statement' => $statement,
            'agree' => $agree,
            'neither_nor' => $neither_nor,
            'disagree' => $disagree,
            'remarks' => $remarks,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('feedback', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Feedback Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Feedback Not Submitted";
    echo json_encode($response);
}
