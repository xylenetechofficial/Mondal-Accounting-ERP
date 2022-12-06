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

if ((isset($_POST['type'])) && ($_POST['type'] == 'line_walk')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $line_walk_date = (isset($_POST['line_walk_date'])) ? $db->escapeString($fn->xss_clean($_POST['line_walk_date'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $present = (isset($_POST['present'])) ? $db->escapeString($fn->xss_clean($_POST['present'])) : "";
    $line_manager = (isset($_POST['line_manager'])) ? $db->escapeString($fn->xss_clean($_POST['line_manager'])) : "";
    $chaired_by = (isset($_POST['chaired_by'])) ? $db->escapeString($_POST['chaired_by']) : "";
    $observation = (isset($_POST['observation'])) ? $db->escapeString($fn->xss_clean($_POST['observation'])) : "";
    $action = (isset($_POST['action'])) ? $db->escapeString($fn->xss_clean($_POST['action'])) : "";
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";

    if (isset($_FILES['form_images']) && !empty($_FILES['form_images']) && $_FILES['form_images']['error'] == 0 && $_FILES['form_images']['size'] > 0) {
        $form_images = $db->escapeString($_FILES['form_images']['name']);
        if (!is_dir('../upload/form_images/')) {
            mkdir('../upload/form_images/', 0777, true);
        }
        $extension = pathinfo($_FILES["form_images"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["form_images"]);
        if ($result) {
            $response["error"]   = true;
            $response["message"] = "Image type must jpg, jpeg, gif, or png!";
            echo json_encode($response);
            return false;
        }
        $image1 = microtime(true) . '.' . strtolower($extension);
        $image = 'upload/form_images/' . "" . $image1;
        $full_path = '../upload/form_images/' . "" . $image1;
        if (!move_uploaded_file($_FILES["form_images"]["tmp_name"], $full_path)) {
            $response["error"]   = true;
            $response["message"] = "Invalid directory to load form_images!";
            echo json_encode($response);
            return false;
        }
    }

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $data = array(
        'doc_no' => $doc_no,
        'rev' => $rev,
        'date' => $date,
        'line_walk_date' => $line_walk_date,
        'location_id' => $location_id,
        'location' => $location,
        'department' => $department,
        'present' => $present,
        'line_manager' => $line_manager,
        'chaired_by' => $chaired_by,
        'observation' => $observation,
        'action' => $action,
        'image' => $image,
        'created_at' => $datetime,
        'updated_at' => $datetime
    );

    $db->insert('line_walk', $data);
    $res = $db->getResult();

    $response["error"]   = false;
    $response["message"] = "Line Walk Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Line Walk Not Submitted";
    echo json_encode($response);
}
