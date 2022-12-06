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

if ((isset($_POST['type'])) && ($_POST['type'] == 'apply_leave_labour')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    if (!empty($_POST['emp_id'])) {
        $datetime = date("Y-m-d H:i:s");
        $date = date("Y-m-d");
        $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
        $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
        $leave_type = (isset($_POST['leave_type'])) ? $db->escapeString($fn->xss_clean($_POST['leave_type'])) : "";
        $leave_to_date = (isset($_POST['leave_to_date'])) ? $db->escapeString($fn->xss_clean($_POST['leave_to_date'])) : "";
        $leave_from_date = (isset($_POST['leave_from_date'])) ? $db->escapeString($fn->xss_clean($_POST['leave_from_date'])) : "";
        $leave_dates = (isset($_POST['leave_dates'])) ? $db->escapeString($fn->xss_clean($_POST['leave_dates'])) : "";
        $leave_counts = (isset($_POST['leave_counts'])) ? $db->escapeString($fn->xss_clean($_POST['leave_counts'])) : "";
        $reason = (isset($_POST['reason'])) ? $db->escapeString($fn->xss_clean($_POST['reason'])) : "";
        $leave_status = 'pending';

        $data = array(); {
            $data = array(
                'emp_id' => $emp_id,
                'emp_no' => $emp_no,
                'leave_type' => $leave_type,
                'leave_to_date' => $leave_to_date,
                'leave_from_date' => $leave_from_date,
                'leave_dates' => $leave_dates,
                'leave_counts' => $leave_counts,
                'reason' => $reason,
                'leave_status' => $leave_status,
                'date' => $date,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('labour_leave', $data);
        $res = $db->getResult();

        $response["error"]   = false;
        $response["message"] = "Leave Request Submitted Successfully";
        //$response["id"] = $res2[0]['id'];
        echo json_encode($response);
    } else {
        $response['error'] = "true";
        $response['message'] = "Leave Request Not Submitted";
        echo json_encode($response);
    }
}

if ((isset($_POST['type'])) && ($_POST['type'] == 'apply_leave_staff')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    if (!empty($_POST['emp_id'])) {
        $datetime = date("Y-m-d H:i:s");
        $date = date("Y-m-d");
        $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
        $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
        $leave_type = (isset($_POST['leave_type'])) ? $db->escapeString($fn->xss_clean($_POST['leave_type'])) : "";
        $leave_to_date = (isset($_POST['leave_to_date'])) ? $db->escapeString($fn->xss_clean($_POST['leave_to_date'])) : "";
        $leave_from_date = (isset($_POST['leave_from_date'])) ? $db->escapeString($fn->xss_clean($_POST['leave_from_date'])) : "";
        $leave_dates = (isset($_POST['leave_dates'])) ? $db->escapeString($fn->xss_clean($_POST['leave_dates'])) : "";
        $leave_counts = (isset($_POST['leave_counts'])) ? $db->escapeString($fn->xss_clean($_POST['leave_counts'])) : "";
        $reason = (isset($_POST['reason'])) ? $db->escapeString($fn->xss_clean($_POST['reason'])) : "";
        $leave_status = 'pending';

        $data = array(); {
            $data = array(
                'emp_id' => $emp_id,
                'emp_no' => $emp_no,
                'leave_type' => $leave_type,
                'leave_to_date' => $leave_to_date,
                'leave_from_date' => $leave_from_date,
                'leave_dates' => $leave_dates,
                'leave_counts' => $leave_counts,
                'reason' => $reason,
                'leave_status' => $leave_status,
                'date' => $date,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('staff_leave', $data);
        $res = $db->getResult();

        $response["error"]   = false;
        $response["message"] = "Leave Request Submitted Successfully";
        //$response["id"] = $res2[0]['id'];
        echo json_encode($response);
    } else {
        $response['error'] = "true";
        $response['message'] = "Leave Request Not Submitted";
        echo json_encode($response);
    }
}
