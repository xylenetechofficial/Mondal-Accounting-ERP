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
/*
type:emp_joining_form
datetime:2022-08-10 12:25:03
emp_no:e123456
name:Admin
father_name:Father
dob:1995-05-07
age:27
blood_group:B +ve
mobile:1234567890
alt_mobile:0123456789
marital_status:Not Married
qualification:Engineering
experience:2 Years
aadhar_no:1234123412341234
pan_no:PAN1234
esic_no:ESIC1234
uan_no:UAN1234
identification_mark:Id Mark
permanant_address:Test Permanant Add
present_address:Test Present Add
bank_name:Axis
acc_holder_name:Admin
acc_no:123456789
ifsc_code:IFSC1234
place:Mambai
date:2022-08-10
is_pf_allow:yes
probation_period:+3 months
allow_probation_leave:yes
total_leaves:30
preliminary_leave:12
casual_leave:12
sick_leave:6
emp_type_id:1
emp_designation_id:2
emp_post:Engineer
salary:25000
spl_allowance:4000
family_name:Admin Mother,Admin Father
family_age:51,58
family_relation:Mother,Father
family_remark:Mother Remark,Father Remark
family_count:2
signature:
profile:
documents:
*/
if ((isset($_POST['type'])) && ($_POST['type'] == 'emp_joining_form')) {
    /*
    if (!verify_token()) {
        return false;
    }*/

    $datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $emp_no = $db->escapeString($fn->xss_clean($_POST['emp_no']));
    $name = $db->escapeString($fn->xss_clean($_POST['name']));
    $father_name = $db->escapeString($fn->xss_clean($_POST['father_name']));
    $dob = $db->escapeString($fn->xss_clean($_POST['dob']));
    $age = $db->escapeString($fn->xss_clean($_POST['age']));
    $blood_group = $db->escapeString($fn->xss_clean($_POST['blood_group']));
    $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
    $alt_mobile = $db->escapeString($fn->xss_clean($_POST['alt_mobile']));
    $password = $db->escapeString($fn->xss_clean($_POST['password']));
    $marital_status = $db->escapeString($fn->xss_clean($_POST['marital_status']));
    $qualification = $db->escapeString($fn->xss_clean($_POST['qualification']));
    $experience = $db->escapeString($fn->xss_clean($_POST['experience']));
    $aadhar_no = $db->escapeString($fn->xss_clean($_POST['aadhar_no']));
    $pan_no = $db->escapeString($fn->xss_clean($_POST['pan_no']));
    $esic_no = $db->escapeString($fn->xss_clean($_POST['esic_no']));
    $uan_no = $db->escapeString($fn->xss_clean($_POST['uan_no']));
    $identification_mark = $db->escapeString($fn->xss_clean($_POST['identification_mark']));
    $permanant_address = $db->escapeString($fn->xss_clean($_POST['permanant_address']));
    $present_address = $db->escapeString($fn->xss_clean($_POST['present_address']));
    $family_count = $db->escapeString($fn->xss_clean($_POST['family_count']));

    $bank_name = $db->escapeString($fn->xss_clean($_POST['bank_name']));
    $acc_holder_name = $db->escapeString($fn->xss_clean($_POST['acc_holder_name']));
    $acc_no = $db->escapeString($fn->xss_clean($_POST['acc_no']));
    $ifsc_code = $db->escapeString($fn->xss_clean($_POST['ifsc_code']));

    $is_pf_allow = $db->escapeString($fn->xss_clean($_POST['is_pf_allow']));
    $probation_period = $db->escapeString($fn->xss_clean($_POST['probation_period']));
    $probation_period_start = date("Y-m-d");;
    $probation_period_end = date('Y-m-d', strtotime("$probation_period", strtotime($probation_period_start)));
    $allow_probation_leave = $db->escapeString($fn->xss_clean($_POST['allow_probation_leave']));
    $total_leaves = $db->escapeString($fn->xss_clean($_POST['total_leaves']));
    $preliminary_leave = $db->escapeString($fn->xss_clean($_POST['preliminary_leave']));
    $casual_leave = $db->escapeString($fn->xss_clean($_POST['casual_leave']));
    $sick_leave = $db->escapeString($fn->xss_clean($_POST['sick_leave']));

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $emp_type_id = $db->escapeString($fn->xss_clean($_POST['emp_type_id']));
    //print_r($emp_type_id);
    $emp_designation_id = $db->escapeString($fn->xss_clean($_POST['emp_designation_id']));
    //print_r($emp_designation_id);

    $sql = "SELECT emp_type_name, designation_name FROM `emp_designation` WHERE id = '$emp_designation_id' AND emp_type_id = '$emp_type_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res_emp_type = $db->getResult();
    $emp_type_name = $res_emp_type[0]['emp_type_name'];
    //print_r($emp_type_name);
    $emp_designation_name = $res_emp_type[0]['designation_name'];
    //print_r($emp_designation_name);

    $place = $db->escapeString($fn->xss_clean($_POST['place']));
    $date = $db->escapeString($fn->xss_clean($_POST['date']));
    $emp_skills = $db->escapeString($fn->xss_clean($_POST['emp_skills']));
    //$emp_post = $db->escapeString($fn->xss_clean($_POST['emp_post']));
    $emp_post = $emp_designation_name;
    $salary = $db->escapeString($fn->xss_clean($_POST['salary']));
    $spl_allowance = $db->escapeString($fn->xss_clean($_POST['spl_allowance']));
    $added_by = $db->escapeString($fn->xss_clean($_POST['added_by']));
    $added_by_designation = $db->escapeString($fn->xss_clean($_POST['added_by_designation']));

    if (isset($_FILES['signature']) && !empty($_FILES['signature']) && $_FILES['signature']['error'] == 0 && $_FILES['signature']['size'] > 0) {
        $signature = $db->escapeString($_FILES['signature']['name']);
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
        $signature_filename1 = microtime(true) . '.' . strtolower($extension);
        $signature_filename = 'upload/signature/' . "" . $signature_filename1;
        $full_path = '../upload/signature/' . "" . $signature_filename1;
        if (!move_uploaded_file($_FILES["signature"]["tmp_name"], $full_path)) {
            $response["error"]   = true;
            $response["message"] = "Invalid directory to load signature!";
            echo json_encode($response);
            return false;
        }
    } else {
        $signature_filename1 = 'default_user_profile.png';
        $full_path = '../upload/signature/' . "" . $signature_filename1;
    }

    if (isset($_FILES['profile']) && !empty($_FILES['profile']) && $_FILES['profile']['error'] == 0 && $_FILES['profile']['size'] > 0) {
        $profile = $db->escapeString($_FILES['profile']['name']);
        if (!is_dir('../upload/profile/')) {
            mkdir('../upload/profile/', 0777, true);
        }
        $extension = pathinfo($_FILES["profile"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["profile"]);
        if ($result) {
            $response["error"]   = true;
            $response["message"] = "Image type must jpg, jpeg, gif, or png!";
            echo json_encode($response);
            return false;
        }
        $filename1 = microtime(true) . '.' . strtolower($extension);
        $filename = 'upload/profile/' . "" . $filename1;
        $full_path = '../upload/profile/' . "" . $filename1;
        if (!move_uploaded_file($_FILES["profile"]["tmp_name"], $full_path)) {
            $response["error"]   = true;
            $response["message"] = "Invalid directory to load profile!";
            echo json_encode($response);
            return false;
        }
    } else {
        $filename1 = 'default_user_profile.png';
        $full_path = '../upload/profile/' . "" . $filename1;
    }

    if (isset($_FILES['documents']) && ($_FILES['documents']['size'][0] > 0) && $_FILES['documents']['error'][0] == 0) {
        $string = '0123456789';
        $documents = '';
        $file_data = array();
        $target_path = 'upload/documents/';
        for ($i = 0; $i < count($_FILES["documents"]["name"]); $i++) {
            if ($_FILES["documents"]["error"][$i] > 0) {
                $error['documents'] = " <span class='label label-danger'>Images not uploaded!</span>";
            } else {
                $result = $fn->validate_other_images($_FILES["documents"]["tmp_name"][$i], $_FILES["documents"]["type"][$i]);
                if ($result) {
                    $error['documents'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
                }
            }

            $filename = $_FILES["documents"]["name"][$i];
            $temp = explode('.', $filename);
            $filename = microtime(true) . '-' . rand(100, 999) . '.' . end($temp);
            $file_data[] = $target_path . '' . $filename;
            if (!move_uploaded_file($_FILES["documents"]["tmp_name"][$i], $target_path . '' . $filename))
                echo "{$_FILES['image']['name'][$i]} not uploaded<br/>";
        }
        $documents = json_encode($file_data);
        //print_r($documents);
    }
    $data = array(); {
        $data = array(
            'emp_no' => $emp_no,
            'profile' =>  DOMAIN_URL . 'upload/profile/' . "" . $filename,
            'name' => $name,
            'father_name' => $father_name,
            'dob' => $dob,
            'age' => $age,
            'blood_group' => $blood_group,
            'mobile' => $mobile,
            'alt_mobile' => $alt_mobile,
            'password' => $password,
            'marital_status' => $marital_status,
            'qualification' => $qualification,
            'experience' => $experience,
            'aadhar_no' => $aadhar_no,
            'pan_no' => $pan_no,
            'esic_no' => $esic_no,
            'uan_no' => $uan_no,
            'identification_mark' => $identification_mark,
            'permanant_address' => $permanant_address,
            'present_address' => $present_address,
            'bank_name' => $bank_name,
            'acc_holder_name' => $acc_holder_name,
            'acc_no' => $acc_no,
            'ifsc_code' => $ifsc_code,
            'place' => $place,
            'date' => $date,
            'is_pf_allow' => $is_pf_allow,
            'probation_period' => $probation_period,
            'probation_period_start' => $probation_period_start,
            'probation_period_end' => $probation_period_end,
            'allow_probation_leave' => $allow_probation_leave,
            'total_leaves' => $total_leaves,
            'preliminary_leave' => $preliminary_leave,
            'casual_leave' => $casual_leave,
            'sick_leave' => $sick_leave,
            'emp_type_id' => $emp_type_id,
            'emp_designation_id' => $emp_designation_id,
            'emp_type_name' => $emp_type_name,
            'emp_designation_name' => $emp_designation_name,
            'emp_skills' => $emp_skills,
            'emp_post' => $emp_post,
            'salary' => $salary,
            'spl_allowance' => $spl_allowance,
            'signature' =>  DOMAIN_URL . 'upload/signature/' . "" . $signature_filename,
            //'documents' =>  $documents,
            'added_by' => $added_by,
            'added_by_designation' => $added_by_designation,
            'location_id' => $location_id,
            'location' => $location,
            'created_at' => $datetime,
            'updated_at' => $datetime

        );
    }
    $sql = "INSERT INTO `emp_joining_form`(`emp_no`, `profile`, `name`, `father_name`, `dob`, `age`, `blood_group`, `mobile`, `alt_mobile`, `password`, `marital_status`, `qualification`, `experience`, `aadhar_no`, `pan_no`, `esic_no`, `uan_no`, `identification_mark`, `permanant_address`, `present_address`, `bank_name`, `acc_holder_name`, `acc_no`, `ifsc_code`, `place`, `date`, `emp_post`, `emp_skills`, `documents`, `probation_period`, `probation_period_start`, `probation_period_end`, `emp_type_id`, `emp_designation_id`, `emp_type_name`, `emp_designation_name`, `is_pf_allow`, `total_leaves`, `casual_leave`, `sick_leave`, `preliminary_leave`, `allow_probation_leave`, `salary`, `spl_allowance`, `signature`, `added_by`, `added_by_designation`, `family_count`, `created_at`, `updated_at`) 
    VALUES ('$emp_no','$filename','$name','$father_name','$dob','$age','$blood_group','$mobile','$alt_mobile','$password','$marital_status','$qualification','$experience','$aadhar_no','$pan_no','$esic_no','$uan_no','$identification_mark','$permanant_address','$present_address','$bank_name','$acc_holder_name','$acc_no','$ifsc_code','$place','$date','$emp_post','$emp_skills','$documents','$probation_period','$probation_period_start','$probation_period_end','$emp_type_id','$emp_designation_id','$emp_type_name','$emp_designation_name','$is_pf_allow','$total_leaves','$casual_leave','$sick_leave','$preliminary_leave','$allow_probation_leave','$salary','$spl_allowance','$signature_filename','$added_by','$added_by_designation','$family_count','$datetime','$datetime')";
    $db->sql($sql); //print_r($sql);
    $res = $db->getResult(); //print_r($res);

    $sql = "SELECT id FROM emp_joining_form ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res_emp_id = $db->getResult();
    $emp_id = $res_emp_id[0]['id'];

    if ($is_pf_allow == 'yes') {

        $basic_salary = $salary / 26;
        $basic_spl_allowance = $spl_allowance / 26;
        $pf_wages = $basic_salary + $basic_spl_allowance;
        $hra = $pf_wages * 0.05 + 0.62;
        $gross_salary = $pf_wages + $hra;
        $pf = $pf_wages * 0.12;
        $esic = $gross_salary * 0.0075;
        $total_deduction = $pf + $esic;
        $net_salary = $gross_salary - $total_deduction;

        $emp_sal = array(); {
            $emp_sal = array(
                'emp_id' => $emp_id,
                'emp_post' => $emp_post,
                'basic_salary' => $basic_salary,
                'spl_allowance' => $basic_spl_allowance,
                'pf_wages' => $pf_wages,
                'hra' => $hra,
                'gross_salary' => $gross_salary,
                'pf' => $pf,
                'esic' => $esic,
                'total_deduction' => $total_deduction,
                'net_salary' => $net_salary,
                'created_at' => $datetime,
            );
        }
        $db->insert('salary', $emp_sal);
        $res = $db->getResult();
    } else {
        $basic_salary = $salary / 26;
        $basic_spl_allowance = $spl_allowance / 26;
        $pf_wages = $basic_salary + $basic_spl_allowance;
        $hra = $pf_wages * 0.05 + 0.62;
        $gross_salary = $pf_wages + $hra;
        //$pf = $pf_wages * 0.12;
        $pf = 0.00;
        $esic = $gross_salary * 0.0075;
        //$total_deduction = $pf + $esic;
        $total_deduction = $esic;
        $net_salary = $gross_salary - $total_deduction;

        $emp_sal = array(); {
            $emp_sal = array(
                'emp_id' => $emp_id,
                'emp_post' => $emp_post,
                'basic_salary' => $basic_salary,
                'spl_allowance' => $basic_spl_allowance,
                'pf_wages' => $pf_wages,
                'hra' => $hra,
                'gross_salary' => $gross_salary,
                'pf' => $pf,
                'esic' => $esic,
                'total_deduction' => $total_deduction,
                'net_salary' => $net_salary,
                'created_at' => $datetime,
            );
        }
        $db->insert('salary', $emp_sal);
        $res = $db->getResult();
    }

    $emp_id = $res_emp_id[0]['id'];

    $datetime = date("Y-m-d H:i:s");
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
    }
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

    $response["error"]   = false;
    $response["message"] = "Form Submitted Successfully";
    $response["emp_data"]   = $data;
    $response["documents"]   = $documents;
    $response["salary"]   = $emp_sal;
    $response["family_data"]   = $fam_data;
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Form Not Submitted";
    echo json_encode($response);
}
