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

if ((isset($_POST['type'])) && ($_POST['type'] == 'mass_meeting')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $meeting_no = (isset($_POST['meeting_no'])) ? $db->escapeString($fn->xss_clean($_POST['meeting_no'])) : "";
    $present = (isset($_POST['present'])) ? $db->escapeString($fn->xss_clean($_POST['present'])) : "";
    $safty_pause = (isset($_POST['safty_pause'])) ? $db->escapeString($_POST['safty_pause']) : "";
    $pomb_discuss = (isset($_POST['pomb_discuss'])) ? $db->escapeString($fn->xss_clean($_POST['pomb_discuss'])) : "";
    $count = (isset($_POST['count'])) ? $db->escapeString($_POST['count']) : "";
    $point = (isset($_POST['point'])) ? $db->escapeString($fn->xss_clean($_POST['point'])) : "";
    $action = (isset($_POST['action'])) ? $db->escapeString($fn->xss_clean($_POST['action'])) : "";
    $target = (isset($_POST['target'])) ? $db->escapeString($fn->xss_clean($_POST['target'])) : "";
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);


    $point = explode(",", $point);
    $action = explode(",", $action);
    $target = explode(",", $target);

    for ($i = 0; $i < $count; $i++) {

        $data = array(); {
            $data = array(
                'date' => $date,
                'meeting_no' => $meeting_no,
                'present' => $present,
                'safty_pause' => $safty_pause,
                'pomb_discuss' => $pomb_discuss,
                'point' => $point[$i],
                'action' => $action[$i],
                'target' => $target[$i],
                'doc_no' => $doc_no,
                'rev' => $rev,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('mass_meeting', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Mass Meeting Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Mass Meeting Not Submitted";
    echo json_encode($response);
}
