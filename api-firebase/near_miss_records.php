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

if ((isset($_POST['type'])) && ($_POST['type'] == 'near_miss_records')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $approved_by = (isset($_POST['approved_by'])) ? $db->escapeString($fn->xss_clean($_POST['approved_by'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";
    $project_name = (isset($_POST['project_name'])) ? $db->escapeString($fn->xss_clean($_POST['project_name'])) : "";
    $incident_no = (isset($_POST['incident_no'])) ? $db->escapeString($fn->xss_clean($_POST['incident_no'])) : "";
    $project_manager = (isset($_POST['project_manager'])) ? $db->escapeString($fn->xss_clean($_POST['project_manager'])) : "";
    $section_incharge = (isset($_POST['section_incharge'])) ? $db->escapeString($fn->xss_clean($_POST['section_incharge'])) : "";
    $site_manager = (isset($_POST['site_manager'])) ? $db->escapeString($fn->xss_clean($_POST['site_manager'])) : "";
    $safty_officer = (isset($_POST['safty_officer'])) ? $db->escapeString($fn->xss_clean($_POST['safty_officer'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $time = (isset($_POST['time'])) ? $db->escapeString($fn->xss_clean($_POST['time'])) : "";
    $subcontractor_involved = (isset($_POST['subcontractor_involved'])) ? $db->escapeString($fn->xss_clean($_POST['subcontractor_involved'])) : "";
    $injured_person_name = (isset($_POST['injured_person_name'])) ? $db->escapeString($fn->xss_clean($_POST['injured_person_name'])) : "";
    $injured_person_age = (isset($_POST['injured_person_age'])) ? $db->escapeString($fn->xss_clean($_POST['injured_person_age'])) : "";
    $injured_person_sex = (isset($_POST['injured_person_sex'])) ? $db->escapeString($fn->xss_clean($_POST['injured_person_sex'])) : "";
    $injured_person_designation = (isset($_POST['injured_person_designation'])) ? $db->escapeString($fn->xss_clean($_POST['injured_person_designation'])) : "";
    $injured_person_injury_nature = (isset($_POST['injured_person_injury_nature'])) ? $db->escapeString($fn->xss_clean($_POST['injured_person_injury_nature'])) : "";
    $injury_location = (isset($_POST['injury_location'])) ? $db->escapeString($fn->xss_clean($_POST['injury_location'])) : "";
    $incedent_description = (isset($_POST['incedent_description'])) ? $db->escapeString($fn->xss_clean($_POST['incedent_description'])) : "";
    $witness_name = (isset($_POST['witness_name'])) ? $db->escapeString($fn->xss_clean($_POST['witness_name'])) : "";

    $error = array();
    $allowedExts = array("gif", "jpeg", "jpg", "png");

    $error['injury_images'] = '';
    /*
    if ($_FILES["injury_images"]["error"][0] == 0) {
        for ($i = 0; $i < count($_FILES["injury_images"]["name"]); $i++) {
            if ($_FILES["injury_images"]["error"][$i] > 0) {
                $error['injury_images'] = " <span class='label label-danger'>Images not uploaded!</span>";
            } else {
                $result = $fn->validate_other_images($_FILES["injury_images"]["tmp_name"][$i], $_FILES["injury_images"]["type"][$i]);
                if ($result) {
                    $error['injury_images'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
                }
            }
        }
    }
*/
    //$string = '0123456789';

    $injury_images = '';
    foreach($_FILES["injury_images"]["tmp_name"] as $key=>$tmp_name) {
        $file_name=$_FILES["injury_images"]["name"][$key];
        $file_tmp=$_FILES["injury_images"]["tmp_name"][$key];
        $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        $target_path = 'upload/injury_images/';
    
        if(in_array($ext,$extension)) {
            if(!file_exists( $target_path . '' . $filename)) {
                move_uploaded_file($file_tmp=$_FILES["injury_images"]["tmp_name"][$key], $target_path . '' . $filename);
            }
            else {
                $filename=basename($file_name,$ext);
                $newFileName=$filename.time().".".$ext;
                move_uploaded_file($file_tmp=$_FILES["injury_images"]["tmp_name"][$key], $target_path . '' .$newFileName);
            }
        }
        else {
            $injury_images = array_push($error,"$file_name, ");
        }
    }
    /*
    if (isset($_FILES['injury_images']) && ($_FILES["injury_images"]["error"][0] == 0) && ($_FILES['injury_images']['size'][0] > 0)) {
        $file_data = array();
        $target_path = 'upload/injury_images/';
        for ($i = 0; $i < count($_FILES["injury_images"]["name"]); $i++) {
            if ($_FILES["injury_images"]["error"][$i] > 0) {
                $response['error'] = true;
                $response['message'] = "Other Images not uploaded!";
                print_r(json_encode($response));
            } else {
                $result = $fn->validate_other_images($_FILES["injury_images"]["tmp_name"][$i], $_FILES["injury_images"]["type"][$i]);
                if ($result) {
                    $response['error'] = true;
                    $response['message'] = "Other image type must jpg, jpeg, gif, or png!";
                    print_r(json_encode($response));
                }
            }
            $filename = $_FILES["injury_images"]["name"][$i];
            $temp = explode('.', $filename);
            $filename = microtime(true) . '-' . rand(100, 999) . '.' . end($temp);
            $file_data[] = $target_path . '' . $filename;
            if (!move_uploaded_file($_FILES["injury_images"]["tmp_name"][$i], $target_path . '' . $filename))
                $response['error'] = true;
            $response['message'] = "Other Images not uploaded!";
            print_r(json_encode($response));
            return false;
        }
        $injury_images = !empty($file_data) ? json_encode($file_data) : "";
    }*/

    $root_cause = (isset($_POST['root_cause'])) ? $db->escapeString($fn->xss_clean($_POST['root_cause'])) : "";
    $corrective_action = (isset($_POST['corrective_action'])) ? $db->escapeString($fn->xss_clean($_POST['corrective_action'])) : "";
    $preventive_action = (isset($_POST['preventive_action'])) ? $db->escapeString($fn->xss_clean($_POST['preventive_action'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $sql = "INSERT INTO `near_miss_records`(`approved_by`, `rev`, `project_name`, `incident_no`, `project_manager`, `section_incharge`, `site_manager`, `safty_officer`, `date`, `time`, `subcontractor_involved`, `injured_person_name`, `injured_person_age`, `injured_person_sex`, `injured_person_designation`, `injured_person_injury_nature`, `injury_location`, `incedent_description`, `witness_name`, `injury_images`, `root_cause`, `corrective_action`, `preventive_action`, `location_id`, `location`, `created_at`, `updated_at`) 
                                    VALUES ('$approved_by','$rev','$project_name','$incident_no','$project_manager','$section_incharge','$site_manager','$safty_officer','$date','$time','$subcontractor_involved','$injured_person_name','$injured_person_age','$injured_person_sex','$injured_person_designation','$injured_person_injury_nature','$injury_location','$incedent_description','$witness_name','$injury_images','$root_cause','$corrective_action','$preventive_action','$location_id','$location','$datetime','$datetime')";
    $db->sql($sql); //print_r($sql);
    $res = $db->getResult(); //print_r($res);

    $response["error"]   = false;
    $response["message"] = "Near Miss Record Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Near Miss Record Not Submitted";
    echo json_encode($response);
}
