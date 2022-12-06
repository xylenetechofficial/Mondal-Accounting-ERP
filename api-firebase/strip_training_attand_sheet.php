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

if ((isset($_POST['type'])) && ($_POST['type'] == 'strip_training_attand_sheet')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $format_no = (isset($_POST['format_no'])) ? $db->escapeString($fn->xss_clean($_POST['format_no'])) : "";
    $form_no = (isset($_POST['form_no'])) ? $db->escapeString($fn->xss_clean($_POST['form_no'])) : "";
    $page = (isset($_POST['page'])) ? $db->escapeString($fn->xss_clean($_POST['page'])) : "";
    $training_course = (isset($_POST['training_course'])) ? $db->escapeString($fn->xss_clean($_POST['training_course'])) : "";
    $trainer_name = (isset($_POST['trainer_name'])) ? $db->escapeString($fn->xss_clean($_POST['trainer_name'])) : "";
    $description = (isset($_POST['description'])) ? $db->escapeString($fn->xss_clean($_POST['description'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $trainer_signature = (isset($_POST['trainer_signature'])) ? $db->escapeString($fn->xss_clean($_POST['trainer_signature'])) : "";
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
    $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    $emp_name = (isset($_POST['emp_name'])) ? $db->escapeString($fn->xss_clean($_POST['emp_name'])) : "";
    $emp_sign = (isset($_POST['emp_sign'])) ? $db->escapeString($fn->xss_clean($_POST['emp_sign'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $emp_count = (isset($_POST['emp_count'])) ? $db->escapeString($_POST['emp_count']) : "";

    $emp_id = explode(",", $emp_id);
    $emp_no = explode(",", $emp_no);
    $emp_name = explode(",", $emp_name);
    $emp_sign = explode(",", $emp_sign);

    for ($i = 0; $i < $emp_count; $i++) {

        $data = array(); {
            $data = array(
                'format_no' => $format_no,
                'form_no' => $form_no,
                'page' => $page,
                'training_course' => $training_course,
                'trainer_name' => $trainer_name,
                'description' => $description,
                'date' => $date,
                'trainer_signature' => $trainer_signature,
                'emp_id' => $emp_id[$i],
                'emp_no' => $emp_no[$i],
                'emp_name' => $emp_name[$i],
                'emp_sign' => $emp_sign[$i],
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('strip_training_attand_sheet', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Strip Training Attandance Sheet Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Strip Training Attandance Sheet Not Submitted";
    echo json_encode($response);
}
