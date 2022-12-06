<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
include_once('includes/crud.php');
include_once('includes/variables.php');
$fn = new custom_functions;
$fn = new custom_functions();
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
//$datetime = date("Y-m-d H:i:s");
$date = date("Y-m-d");
//$effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($date)));
//print_r($effectiveDate);
?>
<?php
if (isset($_POST['btnAdd'])) {

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
        print_r($documents);
    }

    $sql = "INSERT INTO `emp_joining_form`(`emp_no`, `profile`, `name`, `father_name`, `dob`, `age`, `blood_group`, `mobile`, `alt_mobile`, `password`, `marital_status`, `qualification`, `experience`, `aadhar_no`, `pan_no`, `esic_no`, `uan_no`, `identification_mark`, `permanant_address`, `present_address`, `bank_name`, `acc_holder_name`, `acc_no`, `ifsc_code`, `place`, `date`, `emp_post`, `emp_skills`, `documents`, `probation_period`, `probation_period_start`, `probation_period_end`, `emp_type_id`, `emp_designation_id`, `emp_type_name`, `emp_designation_name`, `is_pf_allow`, `total_leaves`, `casual_leave`, `sick_leave`, `preliminary_leave`, `allow_probation_leave`, `salary`, `spl_allowance`, `signature`, `added_by`, `added_by_designation`, `family_count`, `created_at`, `updated_at`) VALUES ('$emp_no','$filename','$name','$father_name','$dob','$age','$blood_group','$mobile','$alt_mobile','$password','$marital_status','$qualification','$experience','$aadhar_no','$pan_no','$esic_no','$uan_no','$identification_mark','$permanant_address','$present_address','$bank_name','$acc_holder_name','$acc_no','$ifsc_code','$place','$date','$emp_post','$emp_skills','$documents','$probation_period','$probation_period_start','$probation_period_end','$emp_type_id','$emp_designation_id','$emp_type_name','$emp_designation_name','$is_pf_allow','$total_leaves','$casual_leave','$sick_leave','$preliminary_leave','$allow_probation_leave','$salary','$spl_allowance','$signature_filename','$added_by','$added_by_designation','$family_count','$datetime','$datetime')";
    $db->sql($sql);print_r($sql);
    $res = $db->getResult();print_r($res);
    
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

    $family_count = $db->escapeString($fn->xss_clean($_POST['family_count']));

    for ($i = 0; $i < $family_count; $i++) {

        $emp_id = $res_emp_id[0]['id'];

        $datetime = date("Y-m-d H:i:s");

        $fam_name = $_POST['family_name'][$i];
        $fam_age = $_POST['family_age'][$i];
        $fam_relation = $_POST['family_relation'][$i];
        $fam_remark = $_POST['family_remark'][$i];

        $sql = "INSERT INTO `family`(`emp_id`, `family_name`, `family_age`, `family_relation`, `family_remark`, `created_at`) VALUES ('$emp_id','$fam_name','$fam_age','$fam_relation','$fam_remark','$datetime')";
        $db->sql($sql);
        $res = $db->getResult();
    }

    $sql = "SELECT * from family WHERE emp_id = $emp_id ORDER BY id DESC";
    $db->sql($sql);
    $res_inner = $db->getResult();
    foreach ($res_inner as $row) {
        //$fam_data[$i] = $row;

        $fam_data[$i]['data'] = $row;
        //print_r($row);
        //print_r($fam_data);
        $i++;
    }
    /*
    if ($emp_type_id == '1') {

    } else {

    }*/
}

if (isset($_POST['btnAdd'])) {
?>
    <script type="text/javascript">
        window.location = "emp-info.php";
    </script>
<?php
}

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>Add Customers Form</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <form id="add_product_form" role="form" method="post" enctype="multipart/form-data" action="add_emp_join.php">
                    <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Employee Number</label><?php echo isset($error['emp_no']) ? $error['emp_no'] : ''; ?>
                                <input type="text" name="emp_no" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">NAME</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Father NAME</label><?php echo isset($error['father_name']) ? $error['father_name'] : ''; ?>
                                <input type="text" name="father_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date Of Birth</label><?php echo isset($error['dob']) ? $error['dob'] : ''; ?>
                                <input type="date" name="dob" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">AGE</label><?php echo isset($error['age']) ? $error['age'] : ''; ?>
                                <input type="text" name="age" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Blood Group</label><?php echo isset($error['blood_group']) ? $error['blood_group'] : ''; ?>
                                <input type="text" name="blood_group" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mobile NO </label><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                <input type="text" class="form-control" name="mobile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Alternate Mob NO</label><?php echo isset($error['alt_mobile']) ? $error['alt_mobile'] : ''; ?>
                                <input type="text" class="form-control" name="alt_mobile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Marital Status</label><?php echo isset($error['marital_status']) ? $error['marital_status'] : ''; ?>
                                <input type="text" class="form-control" name="marital_status">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Qualification</label><?php echo isset($error['qualification']) ? $error['qualification'] : ''; ?>
                                <input type="text" class="form-control" name="qualification">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Experience</label><?php echo isset($error['experience']) ? $error['experience'] : ''; ?>
                                <input type="text" class="form-control" name="experience">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Aadhar No</label><?php echo isset($error['aadhar_no']) ? $error['aadhar_no'] : ''; ?>
                                <input type="text" class="form-control" name="aadhar_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pan No</label><?php echo isset($error['pan_no']) ? $error['pan_no'] : ''; ?>
                                <input type="text" class="form-control" name="pan_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">ESIC No</label><?php echo isset($error['esic_no']) ? $error['esic_no'] : ''; ?>
                                <input type="text" class="form-control" name="esic_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">UAN No</label><?php echo isset($error['uan_no']) ? $error['uan_no'] : ''; ?>
                                <input type="text" class="form-control" name="uan_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Identification Mark</label><?php echo isset($error['identification_mark']) ? $error['identification_mark'] : ''; ?>
                                <input type="text" class="form-control" name="identification_mark">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Permanant Address</label><?php echo isset($error['permanant_address']) ? $error['permanant_address'] : ''; ?>
                                <input type="text" class="form-control" name="permanant_address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Present Address</label><?php echo isset($error['present_address']) ? $error['present_address'] : ''; ?>
                                <input type="text" class="form-control" name="present_address">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Bank Name</label><?php echo isset($error['bank_name']) ? $error['bank_name'] : ''; ?>
                                <input type="text" class="form-control" name="bank_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Acc Holder Name</label><?php echo isset($error['acc_holder_name']) ? $error['acc_holder_name'] : ''; ?>
                                <input type="text" class="form-control" name="acc_holder_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account No.</label><?php echo isset($error['acc_no']) ? $error['acc_no'] : ''; ?>
                                <input type="text" class="form-control" name="acc_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">IFSC Code</label><?php echo isset($error['ifsc_code']) ? $error['ifsc_code'] : ''; ?>
                                <input type="text" class="form-control" name="ifsc_code">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Place</label><?php echo isset($error['place']) ? $error['place'] : ''; ?>
                                <input type="text" class="form-control" name="place">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date</label><?php echo isset($error['date']) ? $error['date'] : ''; ?>
                                <input type="date" class="form-control" name="date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Employee Skills</label><?php echo isset($error['emp_skills']) ? $error['emp_skills'] : ''; ?>
                                <input type="text" class="form-control" name="emp_skills">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Salary</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
                                <input type="text" class="form-control" name="salary">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Special Allowance</label><?php echo isset($error['spl_allowance']) ? $error['spl_allowance'] : ''; ?>
                                <input type="text" class="form-control" name="spl_allowance">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">P.F. Allowed</label><?php echo isset($error['is_pf_allow']) ? $error['is_pf_allow'] : ''; ?>
                                <select class="form-control" id="is_pf_allow" name="is_pf_allow" required>
                                    <option value="">
                                        <label>--Select--</label>
                                    </option>
                                    <option value="yes">
                                        <label>Yes</label>
                                    </option>
                                    <option value="no">
                                        <label>No</label>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Probation Period</label><?php echo isset($error['probation_period']) ? $error['probation_period'] : ''; ?>
                                <select class="form-control" id="probation_period" name="probation_period" required>
                                    <option value="">
                                        <label>--Select--</label>
                                    </option>
                                    <option value="+1 months">
                                        <label>1 Month</label>
                                    </option>
                                    <option value="+2 months">
                                        <label>2 Month</label>
                                    </option>
                                    <option value="+3 months">
                                        <label>3 Month</label>
                                    </option>
                                    <option value="+4 months">
                                        <label>4 Month</label>
                                    </option>
                                    <option value="+5 months">
                                        <label>5 Month</label>
                                    </option>
                                    <option value="+6 months">
                                        <label>6 Month</label>
                                    </option>
                                    <option value="+7 months">
                                        <label>7 Month</label>
                                    </option>
                                    <option value="+8 months">
                                        <label>8 Month</label>
                                    </option>
                                    <option value="+9 months">
                                        <label>9 Month</label>
                                    </option>
                                    <option value="+10 months">
                                        <label>10 Month</label>
                                    </option>
                                    <option value="+11 months">
                                        <label>11 Month</label>
                                    </option>
                                    <option value="+12 months">
                                        <label>12 Month</label>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Leave Allowed In Probation</label><?php echo isset($error['allow_probation_leave']) ? $error['allow_probation_leave'] : ''; ?>
                                <select class="form-control" id="allow_probation_leave" name="allow_probation_leave" required>
                                    <option value="">
                                        <label>--Select--</label>
                                    </option>
                                    <option value="yes">
                                        <label>Yes</label>
                                    </option>
                                    <option value="no">
                                        <label>No</label>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Total Leaves</label><?php echo isset($error['total_leaves']) ? $error['total_leaves'] : ''; ?>
                                <input type="number" min="0" step="1" class="form-control" name="total_leaves">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Preliminary Leaves</label><?php echo isset($error['preliminary_leave']) ? $error['preliminary_leave'] : ''; ?>
                                <input type="number" min="0" step="1" class="form-control" name="preliminary_leave">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Casual Leaves</label><?php echo isset($error['casual_leave']) ? $error['casual_leave'] : ''; ?>
                                <input type="number" min="0" step="1" class="form-control" name="casual_leave">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sick Leaves</label><?php echo isset($error['sick_leave']) ? $error['sick_leave'] : ''; ?>
                                <input type="number" min="0" step="1" class="form-control" name="sick_leave">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emp_type_id">Emp Type</label> <i class="text-danger asterik">*</i><?php echo isset($error['emp_type_id']) ? $error['emp_type_id'] : ''; ?>
                                <select name="emp_type_id" id="emp_type_id" class="form-control" required>
                                    <option value="">--Select Emp Type--</option>
                                    <?php
                                    if ($permissions['categories']['read'] == 1) {
                                        $sql = "SELECT * FROM emp_type";
                                        $db->sql($sql);
                                        $res = $db->getResult();
                                        foreach ($res as $emp_type) {
                                            echo "<option value='" . $emp_type['id'] . "'>" . $emp_type['emp_type_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <br />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emp_designation_id">Emp Post</label>
                                <select name="emp_designation_id" id="emp_designation_id" class="form-control">
                                    <option value="">--Select Emp Post--</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Total Family Members</label><?php echo isset($error['family_count']) ? $error['family_count'] : ''; ?>
                                <input type="text" class="form-control" name="family_count">
                            </div>
                        </div>

                        <div id="family_div">
                            <div class="row">
                                <div class="col-md-12" style="background-color: lavender;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Family Member Name</label><?php echo isset($error['family_name']) ? $error['family_name'] : ''; ?>
                                            <input type="text" class="form-control family_div" name="family_name[]" id="family_name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Family Member Age</label><?php echo isset($error['family_age']) ? $error['family_age'] : ''; ?>
                                            <input type="text" class="form-control family_div" name="family_age[]" id="family_age">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Family Member Relation</label><?php echo isset($error['family_relation']) ? $error['family_relation'] : ''; ?>
                                            <input type="text" class="form-control family_div" name="family_relation[]" id="family_relation">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Family Member Remark</label><?php echo isset($error['family_remark']) ? $error['family_remark'] : ''; ?>
                                            <input type="text" class="form-control family_div" name="family_remark[]" id="family_remark">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Add Member</label>
                                        <a id="add_family" title="Add Family Members" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="variations" style="background-color: lavender; padding-left: 15px; padding-right: 15px;">
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Upload Documents</label><?php echo isset($error['documents']) ? $error['documents'] : ''; ?>
                                <input type="file" class="form-control" name="documents[]" id="documents" multiple>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Upload Photo</label><?php echo isset($error['profile']) ? $error['profile'] : ''; ?>
                                <input type="file" class="form-control" name="profile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Upload Signature</label><?php echo isset($error['signature']) ? $error['signature'] : ''; ?>
                                <input type="file" class="form-control" name="signature">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Set Employee Password</label><?php echo isset($error['password']) ? $error['password'] : ''; ?>
                                <input type="text" class="form-control" name="password" multiple>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Added By</label><?php echo isset($error['added_by']) ? $error['added_by'] : ''; ?>
                                <input type="text" class="form-control" name="added_by">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Added By Designation</label><?php echo isset($error['added_by_designation']) ? $error['added_by_designation'] : ''; ?>
                                <input type="text" class="form-control" name="added_by_designation">
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label for="exampleInputEmail1">Invoice No</label><?php echo isset($error['invoice_no']) ? $error['invoice_no'] : ''; ?>
                            <input type="text" class="form-control" name="invoice_no">
                        </div>-->

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" name="btnAdd">
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="public/MultiSelect/multiselect.js"></script>

<script>
    var num = 2;
    var i = 1;

    $('#add_family').on('click', function() {
        html =
            '<div class="row"><div class="col-md-3"><div class="form-group family_div"><label for="family_name">Family Member Name</label> <i class="text-danger asterik">*</i>' +
            '<input type="text" step="any" min="0" class="form-control" name="family_name[]" required=""></div></div>' +
            '<div class="col-md-3"><div class="form-group family_div"><label for="family_age">Family Member Age</label>' +
            '<input type="text" step="any" min="0" class="form-control" name="family_age[]" /></div></div>' +
            '<div class="col-md-3"><div class="form-group family_div"><label for="family_relation">Family Member Relation</label> <i class="text-danger asterik">*</i>' +
            '<input type="text" step="any" min="0" class="form-control" name="family_relation[]" /></div></div>' +

            '<div class="col-md-2"><div class="form-group family_div"><label for="family_remark">Family Member Remark</label><input type="text" name="family_remark[]" class="form-control" required></div></div>' +
            '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove_variation text-danger" title="Remove variation of product" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>' +

            '</div>';

        $('#variations').append(html);
        //$('#add_product_form').validate();
    });
</script>
<script>
    $(document).on('click', '.remove_variation', function() {
        $(this).closest('.row').remove();
    });

    $(document).on('change', '#emp_type_id', function() {
        $.ajax({
            url: "public/db-operation.php",
            data: "emp_type_id=" + $('#emp_type_id').val() + "&change_emp_type=1",
            method: "POST",
            success: function(data) {
                $('#emp_designation_id').html("<option value=''>---Select Designation---</option>" + data);
            }
        });
    });
</script>
<script>
    //var can_submit = false;
    $('form').on('submit', function(e) {

        var confirmation = confirm("Do you want to continue");
        if (confirmation) {
            console.log("Clicked OK - submitting now ...");
            //can_submit = true;

        } else {
            console.log("Clicked Cancel");
            //can_submit = false;
            return false;
        }

    });
</script>