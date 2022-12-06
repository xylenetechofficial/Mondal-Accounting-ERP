<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include_once('../includes/variables.php');
include_once('../includes/crud.php');
//include_once('verify-token.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$response = array();
/*
type:emp_joining_form
emp_id:2
family_count:2
family_name:Admin Mother,Admin Father
family_age:51,58
family_relation:Mother,Father
family_remark:Mother Remark,Father Remark

*/
if ((isset($_POST['type'])) && ($_POST['type'] == 'emp_joining_form')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");

    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($_POST['emp_id']) : "";

    $family_count = (isset($_POST['family_count'])) ? $db->escapeString($_POST['family_count']) : "";

    $family_name = (isset($_POST['family_name'])) ? $db->escapeString($_POST['family_name']) : "";
    //$family_name_arr = json_decode($family_name, 1);

    $family_age = (isset($_POST['family_age'])) ? $db->escapeString($_POST['family_age']) : "";
    //$family_age_arr = json_decode($family_age, 1);

    $family_relation = (isset($_POST['family_relation'])) ? $db->escapeString($_POST['family_relation']) : "";
    //$family_relation_arr = json_decode($family_relation, 1);

    $family_remark = (isset($_POST['family_remark'])) ? $db->escapeString($_POST['family_remark']) : "";
    //$family_remark_arr = json_decode($family_remark, 1);

    $family_name = explode(",", $family_name);
    $family_age = explode(",", $family_age);
    $family_relation = explode(",", $family_relation);
    $family_remark = explode(",", $family_remark);

    //$name = (isset($_POST['name'])) ? $db->escapeString($_POST['name']) : "";
    //$name = (isset($_POST['name'])) ? $db->escapeString($_POST['name']) : "";

    for ($i = 0; $i < $family_count; $i++) {
        //$emp_id = $res_emp_id[0]['id'];
        $family_data = array(); {
            $family_data = array(
                'emp_id' => $emp_id,
                'family_name' => $family_name[$i],
                'family_age' => $family_age[$i],
                'family_relation' => $family_relation[$i],
                'family_remark' => $family_remark[$i],
                'created_at' => $datetime,
            );
        }
        $db->insert('family', $family_data);
        $res = $db->getResult();

        $fam_data = array();
        $i = 0;

        $sql = "SELECT * from family WHERE emp_id = $emp_id ORDER BY id DESC";
        $db->sql($sql);
        $res_inner = $db->getResult();
        foreach ($res_inner as $row) {
            //$fam_data[$i] = $row;

            $fam_data[$i]['data'] = $row;
            $i++;
        }
        
    }

    $response["error"]   = false;
    $response["message"] = "Form Submitted Successfully";
    //$response["emp_data"]   = $data;
    //$response["salary"]   = $emp_sal;
    $response["family_data"]   = $fam_data;
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Form Not Submitted";
    echo json_encode($response);
}
