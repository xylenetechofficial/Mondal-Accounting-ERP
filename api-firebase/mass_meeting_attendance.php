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

if ((isset($_POST['type'])) && ($_POST['type'] == 'mass_meeting_attandance')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $time = (isset($_POST['time'])) ? $db->escapeString($fn->xss_clean($_POST['time'])) : "";
    $venue = (isset($_POST['venue'])) ? $db->escapeString($fn->xss_clean($_POST['venue'])) : "";
    $meeting_no = (isset($_POST['meeting_no'])) ? $db->escapeString($fn->xss_clean($_POST['meeting_no'])) : "";
    $chaired_by = (isset($_POST['chaired_by'])) ? $db->escapeString($fn->xss_clean($_POST['chaired_by'])) : "";
    $emp_count = (isset($_POST['emp_count'])) ? $db->escapeString($_POST['emp_count']) : "";
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
    $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    $emp_name = (isset($_POST['emp_name'])) ? $db->escapeString($fn->xss_clean($_POST['emp_name'])) : "";
    $attendance = (isset($_POST['attendance'])) ? $db->escapeString($fn->xss_clean($_POST['attendance'])) : "";
    $signature = (isset($_POST['signature'])) ? $db->escapeString($fn->xss_clean($_POST['signature'])) : "";
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);


    $emp_id = explode(",", $emp_id);
    $emp_no = explode(",", $emp_no);
    $emp_name = explode(",", $emp_name);
    $attendance = explode(",", $attendance);
    $signature = explode(",", $signature);

    for ($i = 0; $i < $emp_count; $i++) {

        $data = array(); {
            $data = array(
                'date' => $date,
                'time' => $time,
                'venue' => $venue,
                'meeting_no' => $meeting_no,
                'chaired_by' => $chaired_by,
                'emp_id' => $emp_id[$i],
                'emp_no' => $emp_no[$i],
                'emp_name' => $emp_name[$i],
                'attendance' => $attendance[$i],
                'signature' => $signature[$i],
                'doc_no' => $doc_no,
                'rev' => $rev,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('mass_meeting_attandance', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Mass Meeting Attandance Sheet Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Mass Meeting Attandance Sheet Not Submitted";
    echo json_encode($response);
}
