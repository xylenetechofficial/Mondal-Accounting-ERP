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

if ((isset($_POST['type'])) && ($_POST['type'] == 'houskeeping_checklist')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $form_no = (isset($_POST['form_no'])) ? $db->escapeString($fn->xss_clean($_POST['form_no'])) : "";
    $format_no = (isset($_POST['format_no'])) ? $db->escapeString($fn->xss_clean($_POST['format_no'])) : "";
    $audit_name = (isset($_POST['audit_name'])) ? $db->escapeString($fn->xss_clean($_POST['audit_name'])) : "";
    $audit_date = (isset($_POST['audit_date'])) ? $db->escapeString($fn->xss_clean($_POST['audit_date'])) : "";
    $member_present = (isset($_POST['member_present'])) ? $db->escapeString($fn->xss_clean($_POST['member_present'])) : "";
    $area  = (isset($_POST['area'])) ? $db->escapeString($fn->xss_clean($_POST['area'])) : "";
    $check_point_type1 = (isset($_POST['check_point_type1'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type1'])) : "";
    $check_point_action1 = (isset($_POST['check_point_action1'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action1'])) : "";
    $check_point_type2 = (isset($_POST['check_point_type2'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type2'])) : "";
    $check_point_action2 = (isset($_POST['check_point_action2'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action2'])) : "";
    $check_point_type3 = (isset($_POST['check_point_type3'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type3'])) : "";
    $check_point_action3 = (isset($_POST['check_point_action3'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action3'])) : "";
    $check_point_type4 = (isset($_POST['check_point_type4'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type4'])) : "";
    $check_point_action4 = (isset($_POST['check_point_action4'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action4'])) : "";
    $check_point_type5 = (isset($_POST['check_point_type5'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type5'])) : "";
    $check_point_action5 = (isset($_POST['check_point_action5'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action5'])) : "";
    $check_point_type6 = (isset($_POST['check_point_type6'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type6'])) : "";
    $check_point_action6  = (isset($_POST['check_point_action6'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action6'])) : "";
    $check_point_type7 = (isset($_POST['check_point_type7'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type7'])) : "";
    $check_point_action7 = (isset($_POST['check_point_action7'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action7'])) : "";
    $check_point_type8 = (isset($_POST['check_point_type8'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type8'])) : "";
    $check_point_action8 = (isset($_POST['check_point_action8'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action8'])) : "";
    $check_point_type9 = (isset($_POST['check_point_type9'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type9'])) : "";
    $check_point_action9 = (isset($_POST['check_point_action9'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action9'])) : "";
    $check_point_type10 = (isset($_POST['check_point_type10'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type10'])) : "";
    $check_point_action10 = (isset($_POST['check_point_action10'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action10'])) : "";
    $check_point_type11 = (isset($_POST['check_point_type11'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type11'])) : "";
    $check_point_action11 = (isset($_POST['check_point_action11'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action11'])) : "";
    $check_point_type12 = (isset($_POST['check_point_type12'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type12'])) : "";
    $check_point_action12  = (isset($_POST['check_point_action12'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action12'])) : "";
    $check_point_type13 = (isset($_POST['check_point_type13'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type13'])) : "";
    $check_point_action13 = (isset($_POST['check_point_action13'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action13'])) : "";
    $check_point_type14 = (isset($_POST['check_point_type14'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type14'])) : "";
    $check_point_action14 = (isset($_POST['check_point_action14'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action14'])) : "";
    $check_point_type15 = (isset($_POST['check_point_type15'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type15'])) : "";
    $check_point_action15 = (isset($_POST['check_point_action15'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action15'])) : "";
    $check_point_type16 = (isset($_POST['check_point_type16'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type16'])) : "";
    $check_point_action16 = (isset($_POST['check_point_action16'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action16'])) : "";
    $check_point_type17 = (isset($_POST['check_point_type17'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type17'])) : "";
    $check_point_action17 = (isset($_POST['check_point_action17'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action17'])) : "";
    $check_point_type18 = (isset($_POST['check_point_type18'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type18'])) : "";
    $check_point_action18  = (isset($_POST['check_point_action18'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action18'])) : "";
    $check_point_type19 = (isset($_POST['check_point_type19'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type19'])) : "";
    $check_point_action19 = (isset($_POST['check_point_action19'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action19'])) : "";
    $check_point_type20 = (isset($_POST['check_point_type20'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type20'])) : "";
    $check_point_action20 = (isset($_POST['check_point_action20'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action20'])) : "";
    $check_point_type21 = (isset($_POST['check_point_type21'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type21'])) : "";
    $check_point_action21 = (isset($_POST['check_point_action21'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action21'])) : "";
    $check_point_type22 = (isset($_POST['check_point_type22'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type22'])) : "";
    $check_point_action22 = (isset($_POST['check_point_action22'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action22'])) : "";
    $check_point_type23 = (isset($_POST['check_point_type23'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type23'])) : "";
    $check_point_action23 = (isset($_POST['check_point_action23'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action23'])) : "";
    $check_point_type24 = (isset($_POST['check_point_type24'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type24'])) : "";
    $check_point_action24  = (isset($_POST['check_point_action24'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action24'])) : "";
    $check_point_type25 = (isset($_POST['check_point_type25'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_type25'])) : "";
    $check_point_action25 = (isset($_POST['check_point_action25'])) ? $db->escapeString($fn->xss_clean($_POST['check_point_action25'])) : "";
    $audit_member_sign = (isset($_POST['audit_member_sign'])) ? $db->escapeString($fn->xss_clean($_POST['audit_member_sign'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $data = array(); {
        $data = array(
            'form_no' => $form_no,
            'format_no' => $format_no,
            'audit_name' => $audit_name,
            'audit_date' => $audit_date,
            'member_present' => $member_present,
            'area' => $area,
            'check_point_type1' => $check_point_type1,
            'check_point_action1' => $check_point_action1,
            'check_point_type2' => $check_point_type2,
            'check_point_action2' => $check_point_action2,
            'check_point_type3' => $check_point_type3,
            'check_point_action3' => $check_point_action3,
            'check_point_type4' => $check_point_type4,
            'check_point_action4' => $check_point_action4,
            'check_point_type5' => $check_point_type5,
            'check_point_action5' => $check_point_action5,
            'check_point_type6' => $check_point_type6,
            'check_point_action6' => $check_point_action6,
            'check_point_type7' => $check_point_type7,
            'check_point_action7' => $check_point_action7,
            'check_point_type8' => $check_point_type8,
            'check_point_action8' => $check_point_action8,
            'check_point_type9' => $check_point_type9,
            'check_point_action9' => $check_point_action9,
            'check_point_type10' => $check_point_type10,
            'check_point_action10' => $check_point_action10,
            'check_point_type11' => $check_point_type11,
            'check_point_action11' => $check_point_action11,
            'check_point_type12' => $check_point_type12,
            'check_point_action12' => $check_point_action12,
            'check_point_type13' => $check_point_type13,
            'check_point_action13' => $check_point_action13,
            'check_point_type14' => $check_point_type14,
            'check_point_action14' => $check_point_action14,
            'check_point_type15' => $check_point_type15,
            'check_point_action15' => $check_point_action15,
            'check_point_type16' => $check_point_type16,
            'check_point_action16' => $check_point_action16,
            'check_point_type17' => $check_point_type17,
            'check_point_action17' => $check_point_action17,
            'check_point_type18' => $check_point_type18,
            'check_point_action18' => $check_point_action18,
            'check_point_type19' => $check_point_type19,
            'check_point_action19' => $check_point_action19,
            'check_point_type20' => $check_point_type20,
            'check_point_action20' => $check_point_action20,
            'check_point_type21' => $check_point_type21,
            'check_point_action21' => $check_point_action21,
            'check_point_type22' => $check_point_type22,
            'check_point_action22' => $check_point_action22,
            'check_point_type23' => $check_point_type23,
            'check_point_action23' => $check_point_action23,
            'check_point_type24' => $check_point_type24,
            'check_point_action24' => $check_point_action24,
            'check_point_type25' => $check_point_type25,
            'check_point_action25' => $check_point_action25,
            'audit_member_sign' => $audit_member_sign,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('houskeeping_checklist', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Houskeeping Checklist report Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Houskeeping Checklist report Not Submitted";
    echo json_encode($response);
}
