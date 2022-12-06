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

if ((isset($_POST['type'])) && ($_POST['type'] == 'training_attandance_sheet')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $training_name = (isset($_POST['training_name'])) ? $db->escapeString($fn->xss_clean($_POST['training_name'])) : "";
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev_no = (isset($_POST['rev_no'])) ? $db->escapeString($fn->xss_clean($_POST['rev_no'])) : "";
    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $training_date = (isset($_POST['training_date'])) ? $db->escapeString($fn->xss_clean($_POST['training_date'])) : "";
    $emp_id = (isset($_POST['emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['emp_id'])) : "";
    $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    $emp_name = (isset($_POST['emp_name'])) ? $db->escapeString($fn->xss_clean($_POST['emp_name'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $mobile = (isset($_POST['mobile'])) ? $db->escapeString($fn->xss_clean($_POST['mobile'])) : "";
    $remark = (isset($_POST['remark'])) ? $db->escapeString($fn->xss_clean($_POST['remark'])) : "";
    $trainer_name = (isset($_POST['trainer_name'])) ? $db->escapeString($fn->xss_clean($_POST['trainer_name'])) : "";

    if (isset($_FILES['signature']) && !empty($_FILES['signature']) && $_FILES['signature']['error'] == 0 && $_FILES['signature']['size'] > 0) {
        $signature = $db->escapeString($fn->xss_clean($_FILES['signature']['name']));
        if (!is_dir('../upload/signature/')) {
            mkdir('../upload/signature/', 0777, true);
        }
        $extension = pathinfo($_FILES["signature"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["signature"]);
        if ($result) {
            $response["error"]   = true;
            $response["message"] = "Image type must jpg, jpeg, gif, or png!";
            echo json_encode($response);
            return false;
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = '../upload/signature/' . "" . $filename;
        if (!move_uploaded_file($_FILES["signature"]["tmp_name"], $full_path)) {
            $response["error"]   = true;
            $response["message"] = "Invalid directory to load signature!";
            echo json_encode($response);
            return false;
        }
    }
    //$created_at = (isset($_POST['created_at'])) ? $db->escapeString($fn->xss_clean($_POST['created_at'])) : "";
    //$updated_at = (isset($_POST['updated_at'])) ? $db->escapeString($fn->xss_clean($_POST['updated_at'])) : "";

    $data = array(); {
        $data = array(
            'training_name' => $training_name,
            'doc_no' => $doc_no,
            'rev_no' => $rev_no,
            'location_id' => $location_id,
            'location' => $location,
            'date' => $date,
            'training_date' => $training_date,
            'emp_id' => $emp_id,
            'emp_no' => $emp_no,
            'emp_name' => $emp_name,
            'department' => $department,
            'mobile' => $mobile,
            'remark' => $remark,
            'trainer_name' => $trainer_name,
            'signature' => $signature,
            'created_at' => $datetime,
            'updated_at' => $datetime
        );
    }

    $db->insert('training_attandance_sheet', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Training Attandance Sheet Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Training Attandance Sheet Not Submitted";
    echo json_encode($response);
}
