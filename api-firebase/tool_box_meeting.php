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

if ((isset($_POST['type'])) && ($_POST['type'] == 'tool_box_meeting')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $authorised_by = (isset($_POST['authorised_by'])) ? $db->escapeString($fn->xss_clean($_POST['authorised_by'])) : "";
    $issue_no = (isset($_POST['issue_no'])) ? $db->escapeString($fn->xss_clean($_POST['issue_no'])) : "";
    $date1 = (isset($_POST['date1'])) ? $db->escapeString($fn->xss_clean($_POST['date1'])) : "";
    $form_no = (isset($_POST['form_no'])) ? $db->escapeString($fn->xss_clean($_POST['form_no'])) : "";
    $page = (isset($_POST['page'])) ? $db->escapeString($fn->xss_clean($_POST['page'])) : "";
    $revision = (isset($_POST['revision'])) ? $db->escapeString($fn->xss_clean($_POST['revision'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $effective_date = (isset($_POST['effective_date'])) ? $db->escapeString($fn->xss_clean($_POST['effective_date'])) : "";
    $project_name = (isset($_POST['project_name'])) ? $db->escapeString($fn->xss_clean($_POST['project_name'])) : "";
    $project_date = (isset($_POST['project_date'])) ? $db->escapeString($fn->xss_clean($_POST['project_date'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $time = (isset($_POST['time'])) ? $db->escapeString($fn->xss_clean($_POST['time'])) : "";
    $topic = (isset($_POST['topic'])) ? $db->escapeString($fn->xss_clean($_POST['topic'])) : "";
    $conducted_by = (isset($_POST['conducted_by'])) ? $db->escapeString($fn->xss_clean($_POST['conducted_by'])) : "";
    $tot_no = (isset($_POST['tot_no'])) ? $db->escapeString($fn->xss_clean($_POST['tot_no'])) : "";
    $emp_count = (isset($_POST['emp_count'])) ? $db->escapeString($_POST['emp_count']) : "";
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
    $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    $emp_name = (isset($_POST['emp_name'])) ? $db->escapeString($fn->xss_clean($_POST['emp_name'])) : "";
    $emp_designation = (isset($_POST['emp_designation'])) ? $db->escapeString($fn->xss_clean($_POST['emp_designation'])) : "";
    $attendance = (isset($_POST['attendance'])) ? $db->escapeString($fn->xss_clean($_POST['attendance'])) : "";
    $signature = (isset($_POST['signature'])) ? $db->escapeString($fn->xss_clean($_POST['signature'])) : "";
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";


    $emp_id = explode(",", $emp_id);
    $emp_no = explode(",", $emp_no);
    $emp_name = explode(",", $emp_name);
    $emp_designation = explode(",", $emp_designation);
    $attendance = explode(",", $attendance);
    $signature = explode(",", $signature);

    for ($i = 0; $i < $emp_count; $i++) {

        $data = array(); {
            $data = array(
                'authorised_by' => $authorised_by,
                'issue_no' => $issue_no,
                'date1' => $date1,
                'form_no' => $form_no,
                'page' => $page,
                'revision' => $revision,
                'date' => $date,
                'effective_date' => $effective_date,
                'project_name' => $project_name,
                'project_date' => $project_date,
                'location_id' => $location_id,
                'location' => $location,
                'time' => $time,
                'topic' => $topic,
                'conducted_by' => $conducted_by,
                'tot_no' => $tot_no,
                'emp_id' => $emp_id[$i],
                'emp_no' => $emp_no[$i],
                'emp_name' => $emp_name[$i],
                'emp_designation' => $emp_designation[$i],
                'attendance' => $attendance[$i],
                'signature' => $signature[$i],
                'doc_no' => $doc_no,
                'rev' => $rev,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('tool_box_meeting', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Tool Box Meeting Attandance Sheet Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Tool Box Meeting Attandance Sheet Not Submitted";
    echo json_encode($response);
}
