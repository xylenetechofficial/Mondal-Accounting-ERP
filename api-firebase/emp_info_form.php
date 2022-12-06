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
        $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
        $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
        $post_apply = (isset($_POST['post_apply'])) ? $db->escapeString($fn->xss_clean($_POST['post_apply'])) : "";
        $post_get = (isset($_POST['post_get'])) ? $db->escapeString($fn->xss_clean($_POST['post_get'])) : "";
        $dob = (isset($_POST['dob'])) ? $db->escapeString($fn->xss_clean($_POST['dob'])) : "";
        $email = (isset($_POST['email'])) ? $db->escapeString($fn->xss_clean($_POST['email'])) : "";
        $mobile = (isset($_POST['mobile'])) ? $db->escapeString($fn->xss_clean($_POST['mobile'])) : "";
        $alt_mobile = (isset($_POST['alt_mobile'])) ? $db->escapeString($fn->xss_clean($_POST['alt_mobile'])) : "";
        $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";
        $weight = (isset($_POST['weight'])) ? $db->escapeString($fn->xss_clean($_POST['weight'])) : "";
        $height = (isset($_POST['height'])) ? $db->escapeString($fn->xss_clean($_POST['height'])) : "";
        $address = (isset($_POST['address'])) ? $db->escapeString($fn->xss_clean($_POST['address'])) : "";
        $permanant_address = (isset($_POST['permanant_address'])) ? $db->escapeString($fn->xss_clean($_POST['permanant_address'])) : "";
        $qualification = (isset($_POST['qualification'])) ? $db->escapeString($fn->xss_clean($_POST['qualification'])) : "";
        $gender = (isset($_POST['gender'])) ? $db->escapeString($fn->xss_clean($_POST['gender'])) : "";
        $declaration_date = (isset($_POST['declaration_date'])) ? $db->escapeString($fn->xss_clean($_POST['declaration_date'])) : "";
        $declaration_place = (isset($_POST['declaration_place'])) ? $db->escapeString($fn->xss_clean($_POST['declaration_place'])) : "";
        
        $pri_interview_name = (isset($_POST['pri_interview_name'])) ? $db->escapeString($fn->xss_clean($_POST['pri_interview_name'])) : "";
        $pri_interview_designation = (isset($_POST['pri_interview_designation'])) ? $db->escapeString($fn->xss_clean($_POST['pri_interview_designation'])) : "";
        $pri_interview_remark = (isset($_POST['pri_interview_remark'])) ? $db->escapeString($fn->xss_clean($_POST['pri_interview_remark'])) : "";
        $pri_interview_date = (isset($_POST['pri_interview_date'])) ? $db->escapeString($fn->xss_clean($_POST['pri_interview_date'])) : "";

        $final_interview_name = (isset($_POST['final_interview_name'])) ? $db->escapeString($fn->xss_clean($_POST['final_interview_name'])) : "";
        $final_interview_designation = (isset($_POST['final_interview_designation'])) ? $db->escapeString($fn->xss_clean($_POST['final_interview_designation'])) : "";
        $final_interview_appointed_as = (isset($_POST['final_interview_appointed_as'])) ? $db->escapeString($fn->xss_clean($_POST['final_interview_appointed_as'])) : "";
        $final_interview_salary = (isset($_POST['final_interview_salary'])) ? $db->escapeString($fn->xss_clean($_POST['final_interview_salary'])) : "";
        $final_interview_date = (isset($_POST['final_interview_date'])) ? $db->escapeString($fn->xss_clean($_POST['final_interview_date'])) : "";
        
        $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";
        $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";
        $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";
        $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";
        $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";
        $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";

        $created_at = (isset($_POST['created_at'])) ? $db->escapeString($fn->xss_clean($_POST['created_at'])) : "";
        $updated_at = (isset($_POST['updated_at'])) ? $db->escapeString($fn->xss_clean($_POST['updated_at'])) : "";

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