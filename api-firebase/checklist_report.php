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

if ((isset($_POST['type'])) && ($_POST['type'] == 'checklist_report')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $goggle = (isset($_POST['goggle'])) ? $db->escapeString($fn->xss_clean($_POST['goggle'])) : "";
    $gloves = (isset($_POST['gloves'])) ? $db->escapeString($fn->xss_clean($_POST['gloves'])) : "";
    $jacket = (isset($_POST['jacket'])) ? $db->escapeString($fn->xss_clean($_POST['jacket'])) : "";
    $shoes = (isset($_POST['shoes'])) ? $db->escapeString($fn->xss_clean($_POST['shoes'])) : "";
    $helmet = (isset($_POST['helmet'])) ? $db->escapeString($fn->xss_clean($_POST['helmet'])) : "";
    $hand_sleevs = (isset($_POST['hand_sleevs'])) ? $db->escapeString($fn->xss_clean($_POST['hand_sleevs'])) : "";
    $leg_gaurd = (isset($_POST['leg_gaurd'])) ? $db->escapeString($fn->xss_clean($_POST['leg_gaurd'])) : "";
    $ear_plug = (isset($_POST['ear_plug'])) ? $db->escapeString($fn->xss_clean($_POST['ear_plug'])) : "";
    $remark = (isset($_POST['remark'])) ? $db->escapeString($fn->xss_clean($_POST['remark'])) : "";
    $sign = (isset($_POST['sign'])) ? $db->escapeString($fn->xss_clean($_POST['sign'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $data = array(); {
        $data = array(
            'name' => $name,
            'date' => $date,
            'goggle' => $goggle,
            'gloves' => $gloves,
            'jacket' => $jacket,
            'shoes' => $shoes,
            'helmet' => $helmet,
            'hand_sleevs' => $hand_sleevs,
            'leg_gaurd' => $leg_gaurd,
            'ear_plug' => $ear_plug,
            'remark' => $remark,
            'sign' => $sign,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('checklist_report', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Checklist report Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Checklist report Not Submitted";
    echo json_encode($response);
}
