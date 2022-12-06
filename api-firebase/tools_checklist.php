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

if ((isset($_POST['type'])) && ($_POST['type'] == 'tools_checklist')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $tool_list = (isset($_POST['tool_list'])) ? $db->escapeString($fn->xss_clean($_POST['tool_list'])) : "";
    $inspection_date = (isset($_POST['inspection_date'])) ? $db->escapeString($fn->xss_clean($_POST['inspection_date'])) : "";
    $due_date = (isset($_POST['due_date'])) ? $db->escapeString($fn->xss_clean($_POST['due_date'])) : "";
    $remark = (isset($_POST['remark'])) ? $db->escapeString($fn->xss_clean($_POST['remark'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $data = array(); {
        $data = array(
            'tool_list' => $tool_list,
            'inspection_date' => $inspection_date,
            'due_date' => $due_date,
            'remark' => $remark,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('tools_checklist', $data);
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
