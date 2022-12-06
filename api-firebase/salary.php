<?php
//header('Access-Control-Allow-Origin: *');
//header("Content-Type: application/json");
include_once('../includes/variables.php');
include_once('../includes/crud.php');
//include_once('verify-token.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$response = array();
/*

if (isset($_POST['accesskey']) && !empty($_POST['accesskey'])) {
        $accesskey = $db->escapeString($function->xss_clean($_POST['accesskey']));
    } else {
        $response['error'] = true;
        $response['message'] = "accesskey required";
        print_r(json_encode($response));
        return false;
    }
    if ($access_key != $accesskey) {
    $response['error'] = true;
    $response['message'] = "invalid accesskey";
    print_r(json_encode($response));
    return false;
}*/
if ((isset($_POST['type'])) && ($_POST['type'] == 'emp_joining_form')) {
    
    $datetime = date("Y-m-d H:i:s");
    
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($_POST['emp_id']) : "";
    $emp_post = (isset($_POST['emp_post'])) ? $db->escapeString($_POST['emp_post']) : "";
    $salary = (isset($_POST['salary'])) ? $db->escapeString($_POST['salary']) : "";
    $spl_allowance = (isset($_POST['spl_allowance'])) ? $db->escapeString($_POST['spl_allowance']) : "";

    $basic_salary = $salary / 26 ;
    $basic_spl_allowance = $spl_allowance / 26 ;
    $pf_wages = $basic_salary + $basic_spl_allowance;
    $hra = $pf_wages * 0.05 + 0.62;
    $gross_salary = $pf_wages + $hra;
    $pf = $pf_wages * 0.12;
    $esic = $gross_salary * 0.0075;
    $total_deduction = $pf + $esic;
    $net_salary = $gross_salary - $total_deduction;

    $sql = "INSERT INTO `salary`(`emp_id`, `emp_post`, `basic_salary`, `spl_allowance`, `pf_wages`, `hra`, `gross_salary`, `pf`, `esic`, `total_deduction`, `net_salary`, `created_at`) VALUES ('$emp_id','$emp_post','$basic_salary','$basic_spl_allowance','$pf_wages','$hra','$gross_salary','$pf','$esic','$total_deduction','$net_salary','$datetime')";
    $db->sql($sql);
    $emp_sal = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Form Submitted Successfully";
    //$response["emp_data"]   = $res_emp_id;
    $response["data"] = $emp_sal;
    //$response["family_data"]   = $family;
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Form Not Submitted";
    echo json_encode($response);
}
