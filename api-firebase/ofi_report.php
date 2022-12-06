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

if ((isset($_POST['type'])) && ($_POST['type'] == 'ofi_report')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $document = (isset($_POST['document'])) ? $db->escapeString($fn->xss_clean($_POST['document'])) : "";
    $pl1 = (isset($_POST['pl1'])) ? $db->escapeString($fn->xss_clean($_POST['pl1'])) : "";
    $pl2 = (isset($_POST['pl2'])) ? $db->escapeString($fn->xss_clean($_POST['pl2'])) : "";
    $pl3 = (isset($_POST['pl3'])) ? $db->escapeString($fn->xss_clean($_POST['pl3'])) : "";
    $pl4 = (isset($_POST['pl4'])) ? $db->escapeString($fn->xss_clean($_POST['pl4'])) : "";
    $co1 = (isset($_POST['co1'])) ? $db->escapeString($fn->xss_clean($_POST['co1'])) : "";
    $co2 = (isset($_POST['co2'])) ? $db->escapeString($fn->xss_clean($_POST['co2'])) : "";
    $co3 = (isset($_POST['co3'])) ? $db->escapeString($fn->xss_clean($_POST['co3'])) : "";
    $co4 = (isset($_POST['co4'])) ? $db->escapeString($fn->xss_clean($_POST['co4'])) : "";
    $cl1 = (isset($_POST['cl1'])) ? $db->escapeString($fn->xss_clean($_POST['cl1'])) : "";
    $cl2 = (isset($_POST['cl2'])) ? $db->escapeString($fn->xss_clean($_POST['cl2'])) : "";
    $cl3 = (isset($_POST['cl3'])) ? $db->escapeString($fn->xss_clean($_POST['cl3'])) : "";
    $cl4 = (isset($_POST['cl4'])) ? $db->escapeString($fn->xss_clean($_POST['cl4'])) : "";
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
            'department' => $department,
            'document' => $document,
            'pl1' => $pl1,
            'pl2' => $pl2,
            'pl3' => $pl3,
            'pl4' => $pl4,
            'co1' => $co1,
            'co2' => $co2,
            'co3' => $co3,
            'co4' => $co4,
            'cl1' => $cl1,
            'cl2' => $cl2,
            'cl3' => $cl3,
            'cl4' => $cl4,
            'doc_no' => $doc_no,
            'rev_no' => $rev_no,
            'date' => $date,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('ofi_report', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "OFI Report Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "OFI Report Not Submitted";
    echo json_encode($response);
}
