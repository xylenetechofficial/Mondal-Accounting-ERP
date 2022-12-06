<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header("Content-Type: application/json");
include_once('../includes/variables.php');
include_once('../includes/crud.php');
include '../includes/custom-functions.php';
$fn = new custom_functions;
$fn = new custom_functions();
$config = $fn->get_configurations();
//include_once('verify-token.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$response = array();

if ((isset($_POST['type'])) && ($_POST['type'] == 'approve_leave')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    $today = date("Y-m-d");
    $id = (isset($_POST['id'])) ? $db->escapeString($fn->xss_clean($_POST['id'])) : "";
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";

    $sql = "SELECT * FROM `labour_leave` WHERE emp_id = '$emp_id' AND id = '$id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    $emp_no = $res1[0]['emp_no'];
    $leave_type = $res1[0]['leave_type'];

    $selectedValues = (isset($_POST['approved_dates'])) ? $db->escapeString($fn->xss_clean($_POST['approved_dates'])) : "";
    $approved_by_emp_name = (isset($_POST['approved_by_emp_name'])) ? $db->escapeString($fn->xss_clean($_POST['approved_by_emp_name'])) : "";
    $approved_by_emp_no = (isset($_POST['approved_by_emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['approved_by_emp_no'])) : "";
    $approved_by_remark = (isset($_POST['approved_by_remark'])) ? $db->escapeString($fn->xss_clean($_POST['approved_by_remark'])) : "";
    $leave_status = (isset($_POST['leave_status'])) ? $db->escapeString($fn->xss_clean($_POST['leave_status'])) : "";
    //$in_time = (isset($_POST['in_time'])) ? $db->escapeString($fn->xss_clean($_POST['in_time'])) : "";
    //$is_logged_in = 'false';

    $is_logged_in = 'false';
    $hours = '9';
    $ot_hours = '0';
    $tot_hours = '9';
    $in_time = '09:00:00';
    $out_time = '18:00:00';

    $dates = explode(', ', $selectedValues);

    if ($leave_status == 'approved') {

        foreach ($dates as $date) {

            $sql = "INSERT INTO `emp_attendance`(`emp_id`, `emp_no`, `attendance`, `in_time`, `out_time`, `hours`, `tot_hours`, `ot_hours`, `is_logged_in`, `date`, `created_at`, `updated_at`) VALUES ('$emp_id','$emp_no','$leave_type','$in_time','$out_time','$hours','$ot_hours','$tot_hours','$is_logged_in','$date','$datetime','$datetime')";
            $db->sql($sql);
            $emp_atten = $db->getResult();
            //print_r($sql);
        }
    }

    $sql = "UPDATE `labour_leave` SET `leave_status`='$leave_status',`approved_by_date`='$date',`approved_by_emp_name`='$approved_by_emp_name',`approved_by_emp_no`='$approved_by_emp_no',`approved_by_remark`='$approved_by_remark',`updated_at`='$datetime' WHERE id = '$id' AND emp_no = '$emp_no' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $emp_atten = $db->getResult();

    $sql = "SELECT labour_leave.*, emp_joining_form.mobile, emp_joining_form.name, emp_joining_form.profile FROM `labour_leave` INNER JOIN `emp_joining_form` ON emp_joining_form.id = labour_leave.emp_id  WHERE labour_leave.emp_no = '$emp_no' AND labour_leave.id = '$id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res = $db->getResult();

    $response["message"] = "Leave Approved Status Submitted Successfully";
    //$response["data"] = $emp_atten;

    foreach ($res as $row) {
        $response['error']   = "false";
        $response['leave_id'] = $row['id'];
        $response['emp_id'] = $row['emp_id'];
        $response['emp_no'] = $row['emp_no'];
        $response['name'] = $row['name'];
        $response['mobile'] = $row['mobile'];
        $response['profile'] = $row['profile'];
        $response['leave_type'] = $row['leave_type'];
        $response['leave_from_date'] = $row['leave_from_date'];
        $response['leave_to_date'] = $row['leave_to_date'];
        $response['leave_dates'] = $row['leave_dates'];
        $response['leave_counts'] = $row['leave_counts'];
        $response['reason'] = $row['reason'];
        $response['leave_status'] = $row['leave_status'];
        $response['date'] = $row['date'];
        $response['approved_dates'] = $row['approved_dates'];
        $response['approved_by_emp_name'] = $row['approved_by_emp_name'];
        $response['approved_by_emp_no'] = $row['approved_by_emp_no'];
        $response['approved_by_remark'] = $row['approved_by_remark'];
        $response['approved_by_date'] = $row['approved_by_date'];
        $response['created_at'] = $row['created_at'];
        $response['updated_at'] = $row['updated_at'];
    }
    
    echo json_encode($response);

} else {
    $response['error'] = "true";
    $response['message'] = "Leave Approved Status Not Update";
    echo json_encode($response);
}
