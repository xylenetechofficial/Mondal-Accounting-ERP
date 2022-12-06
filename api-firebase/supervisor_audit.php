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

if ((isset($_POST['type'])) && ($_POST['type'] == 'supervisor_audit')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $section = (isset($_POST['section'])) ? $db->escapeString($fn->xss_clean($_POST['section'])) : "";
    $audit_date = (isset($_POST['audit_date'])) ? $db->escapeString($fn->xss_clean($_POST['audit_date'])) : "";
    $time = (isset($_POST['time'])) ? $db->escapeString($fn->xss_clean($_POST['time'])) : "";
    $dept_representative = (isset($_POST['dept_representative'])) ? $db->escapeString($fn->xss_clean($_POST['dept_representative'])) : "";
    $team_member1 = (isset($_POST['team_member1'])) ? $db->escapeString($_POST['team_member1']) : "";
    $team_member2 = (isset($_POST['team_member2'])) ? $db->escapeString($fn->xss_clean($_POST['team_member2'])) : "";
    $team_member3 = (isset($_POST['team_member3'])) ? $db->escapeString($fn->xss_clean($_POST['team_member3'])) : "";
    $team_member4 = (isset($_POST['team_member4'])) ? $db->escapeString($fn->xss_clean($_POST['team_member4'])) : "";
    $team_member5 = (isset($_POST['team_member5'])) ? $db->escapeString($fn->xss_clean($_POST['team_member5'])) : "";
    $team_member6 = (isset($_POST['team_member6'])) ? $db->escapeString($fn->xss_clean($_POST['team_member6'])) : "";
    $contract_name_vendor_code = (isset($_POST['contract_name_vendor_code'])) ? $db->escapeString($fn->xss_clean($_POST['contract_name_vendor_code'])) : "";
    $tot_contract_people_working = (isset($_POST['tot_contract_people_working'])) ? $db->escapeString($fn->xss_clean($_POST['tot_contract_people_working'])) : "";
    $description = (isset($_POST['description'])) ? $db->escapeString($fn->xss_clean($_POST['description'])) : "";
    $good_citizen = (isset($_POST['good_citizen'])) ? $db->escapeString($_POST['good_citizen']) : "";
    $violation_no = (isset($_POST['violation_no'])) ? $db->escapeString($fn->xss_clean($_POST['violation_no'])) : "";
    $severity = (isset($_POST['severity'])) ? $db->escapeString($fn->xss_clean($_POST['severity'])) : "";
    $violation_severity = (isset($_POST['violation_severity'])) ? $db->escapeString($fn->xss_clean($_POST['violation_severity'])) : "";
    $potential_fatality = (isset($_POST['potential_fatality'])) ? $db->escapeString($fn->xss_clean($_POST['potential_fatality'])) : "";
    $ua_uc = (isset($_POST['ua_uc'])) ? $db->escapeString($fn->xss_clean($_POST['ua_uc'])) : "";
    $violation_subtotal = (isset($_POST['violation_subtotal'])) ? $db->escapeString($fn->xss_clean($_POST['violation_subtotal'])) : "";
    $violation_severity_subtotal = (isset($_POST['violation_severity_subtotal'])) ? $db->escapeString($fn->xss_clean($_POST['violation_severity_subtotal'])) : "";
    $severity_index = (isset($_POST['severity_index'])) ? $db->escapeString($fn->xss_clean($_POST['severity_index'])) : "";
    $checked_by = (isset($_POST['checked_by'])) ? $db->escapeString($fn->xss_clean($_POST['checked_by'])) : "";
    $reviewed_by = (isset($_POST['reviewed_by'])) ? $db->escapeString($fn->xss_clean($_POST['reviewed_by'])) : "";
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $description_count = (isset($_POST['description_count'])) ? $db->escapeString($_POST['description_count']) : "";
    //$subtotal_count = (isset($_POST['subtotal_count'])) ? $db->escapeString($fn->xss_clean($_POST['subtotal_count'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $description = explode(",", $description);
    $good_citizen = explode(",", $good_citizen);
    $violation_no = explode(",", $violation_no);
    $severity = explode(",", $severity);
    $violation_severity = explode(",", $violation_severity);
    $potential_fatality = explode(",", $potential_fatality);
    $ua_uc = explode(",", $ua_uc);
    //$subtotal = explode(",", $subtotal);

    //for ($i = 0, $j = 0; $i < $description_count, $j < $subtotal_count; $i++, $j++) {
    for ($i = 0; $i < $description_count; $i++) {

        $data = array(
            'department' => $department,
            'section' => $section,
            'audit_date' => $audit_date,
            'time' => $time,
            'dept_representative' => $dept_representative,
            'team_member1' => $team_member1,
            'team_member2' => $team_member2,
            'team_member3' => $team_member3,
            'team_member4' => $team_member4,
            'team_member5' => $team_member5,
            'team_member6' => $team_member6,
            'contract_name_vendor_code' => $contract_name_vendor_code,
            'tot_contract_people_working' => $tot_contract_people_working,
            'description' => $description[$i],
            'good_citizen' => $good_citizen[$i],
            'violation_no' => $violation_no[$i],
            'severity' => $severity[$i],
            'violation_severity' => $violation_severity[$i],
            'potential_fatality' => $potential_fatality[$i],
            'ua_uc' => $ua_uc[$i],
            'violation_subtotal' => $violation_subtotal,
            'violation_severity_subtotal' => $violation_severity_subtotal,
            'severity_index' => $severity_index,
            'checked_by' => $checked_by,
            'reviewed_by' => $reviewed_by,
            'doc_no' => $doc_no,
            'rev' => $rev,
            'date' => $date,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );

        $db->insert('supervisor_audit', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Supervisor Audit Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Supervisor Audit Not Submitted";
    echo json_encode($response);
}
