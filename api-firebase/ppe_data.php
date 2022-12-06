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

if ((isset($_POST['type'])) && ($_POST['type'] == 'ppe_data')) {
    /*
    if (!verify_token()) {
        return false;
    }*/

    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";
    $effective_date = (isset($_POST['effective_date'])) ? $db->escapeString($fn->xss_clean($_POST['effective_date'])) : "";
    $month = (isset($_POST['month'])) ? $db->escapeString($fn->xss_clean($_POST['month'])) : "";
    $emp_name = (isset($_POST['emp_name'])) ? $db->escapeString($fn->xss_clean($_POST['emp_name'])) : "";
    $emp_code = (isset($_POST['emp_code'])) ? $db->escapeString($fn->xss_clean($_POST['emp_code'])) : "";
    $designation = (isset($_POST['designation'])) ? $db->escapeString($fn->xss_clean($_POST['designation'])) : "";
    $helmet = (isset($_POST['helmet'])) ? $db->escapeString($fn->xss_clean($_POST['helmet'])) : "";
    $safty_shoes = (isset($_POST['safty_shoes'])) ? $db->escapeString($fn->xss_clean($_POST['safty_shoes'])) : "";
    $visibility_vest = (isset($_POST['visibility_vest'])) ? $db->escapeString($fn->xss_clean($_POST['visibility_vest'])) : "";
    $safty_glases = (isset($_POST['safty_glases'])) ? $db->escapeString($fn->xss_clean($_POST['safty_glases'])) : "";
    $hand_gloves = (isset($_POST['hand_gloves'])) ? $db->escapeString($fn->xss_clean($_POST['hand_gloves'])) : "";
    $face_shield = (isset($_POST['face_shield'])) ? $db->escapeString($fn->xss_clean($_POST['face_shield'])) : "";
    $ear_plugs = (isset($_POST['ear_plugs'])) ? $db->escapeString($fn->xss_clean($_POST['ear_plugs'])) : "";
    $shin_guards = (isset($_POST['shin_guards'])) ? $db->escapeString($fn->xss_clean($_POST['shin_guards'])) : "";
    $dust_mask = (isset($_POST['dust_mask'])) ? $db->escapeString($fn->xss_clean($_POST['dust_mask'])) : "";
    $hand_sleeves = (isset($_POST['hand_sleeves'])) ? $db->escapeString($fn->xss_clean($_POST['hand_sleeves'])) : "";
    $leather_appron = (isset($_POST['leather_appron'])) ? $db->escapeString($fn->xss_clean($_POST['leather_appron'])) : "";
    $remarks = (isset($_POST['remarks'])) ? $db->escapeString($fn->xss_clean($_POST['remarks'])) : "";
    $checked_by = (isset($_POST['checked_by'])) ? $db->escapeString($fn->xss_clean($_POST['checked_by'])) : "";
    $reviewed_by = (isset($_POST['reviewed_by'])) ? $db->escapeString($fn->xss_clean($_POST['reviewed_by'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $emp_counts = (isset($_POST['emp_counts'])) ? $db->escapeString($fn->xss_clean($_POST['emp_counts'])) : "";

    $emp_name = explode(",", $emp_name);
    $emp_code = explode(",", $emp_code);
    $designation = explode(",", $designation);
    $helmet = explode(",", $helmet);
    $safty_shoes = explode(",", $safty_shoes);
    $visibility_vest = explode(",", $visibility_vest);
    $safty_glases = explode(",", $safty_glases);
    $hand_gloves = explode(",", $hand_gloves);
    $face_shield = explode(",", $face_shield);
    $ear_plugs = explode(",", $ear_plugs);
    $shin_guards = explode(",", $shin_guards);
    $dust_mask = explode(",", $dust_mask);
    $hand_sleeves = explode(",", $hand_sleeves);
    $leather_appron = explode(",", $leather_appron);
    $remarks = explode(",", $remarks);

    for ($i = 0; $i < $emp_counts; $i++) {

        $data = array(); {
            $data = array(
                'doc_no' => $doc_no,
                'rev' => $rev,
                'effective_date' => $effective_date,
                'month' => $month,
                'emp_name' =>  $emp_name[$i],
                'emp_code' => $emp_code[$i],
                'designation' => $designation[$i],
                'helmet' => $helmet[$i],
                'safty_shoes' => $safty_shoes[$i],
                'visibility_vest' => $visibility_vest[$i],
                'safty_glases' => $safty_glases[$i],
                'hand_gloves' => $hand_gloves[$i],
                'face_shield' => $face_shield[$i],
                'ear_plugs' => $ear_plugs[$i],
                'shin_guards' => $shin_guards[$i],
                'dust_mask' => $dust_mask[$i],
                'hand_sleeves' => $hand_sleeves[$i],
                'leather_appron' => $leather_appron[$i],
                'remarks' => $remarks[$i],
                'checked_by' => $checked_by,
                'reviewed_by' => $reviewed_by,
                'date' => $date,
                'location_id' =>  $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime

            );
        }
        $db->insert('ppe_data', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "PPES data Form Submitted Successfully";
    $response["data"]   = $data;
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "PPES data Form Not Submitted";
    echo json_encode($response);
}
