<?php
include_once('../includes/variables.php');
include_once('../includes/crud.php');
include_once('verify-token.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');

$response = array();

if ((isset($_POST['type'])) && ($_POST['type'] == 'test_form')) {
        if (!verify_token()) {
            return false;
        }
        $name = (isset($_POST['name'])) ? $db->escapeString($_POST['name']) : "";
        $email = (isset($_POST['email'])) ? $db->escapeString($_POST['email']) : "";
        $mobile = (isset($_POST['mobile'])) ? $db->escapeString($_POST['mobile']) : "";
        $age = (isset($_POST['age'])) ? $db->escapeString($_POST['age']) : "";
        $weight = (isset($_POST['weight'])) ? $db->escapeString($_POST['weight']) : "";
        $height = (isset($_POST['height'])) ? $db->escapeString($_POST['height']) : "";
        $address = (isset($_POST['address'])) ? $db->escapeString($_POST['address']) : "";
        $qualification = (isset($_POST['qualification'])) ? $db->escapeString($_POST['qualification']) : "";
        $gender = (isset($_POST['gender'])) ? $db->escapeString($_POST['gender']) : "";
        $created_at = (isset($_POST['created_at'])) ? $db->escapeString($_POST['created_at']) : "";

        $data = array();
        {
            $data = array(
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'age' => $age,
                'weight' => $weight,
                'height' => $height,
                'address' => $address,
                'qualification' => $qualification,
                'gender' => $gender,
                'created_at' => $created_at
            );
        }

        $db->insert('test_form', $data);
        $res = $db->getResult();

        $response["error"]   = false;
        $response["message"] = "Form Submitted Successfully";
        //$response["id"] = $res2[0]['id'];
        echo json_encode($response);
    } else {
        $response['error'] = "true";
        $response['message'] = "Form Not Submitted";
        echo json_encode($response);
    }