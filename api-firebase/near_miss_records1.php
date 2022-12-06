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


    $image = $db->escapeString($fn->xss_clean($_FILES['injury_images']['name']));
    $image_error = $db->escapeString($fn->xss_clean($_FILES['injury_images']['error']));
    $image_type = $db->escapeString($fn->xss_clean($_FILES['injury_images']['type']));

    $allowedExts = array("gif", "jpeg", "jpg", "png");

    $error['injury_images'] = '';

    if (isset($_FILES["injury_images"]) && $_FILES["injury_images"]["error"] == 0) {
        for ($i = 0; $i < count($_FILES["injury_images"]["name"]); $i++) {
            if ($_FILES["injury_images"]["error"][$i] > 0) {
                $response['error'] = true;
                $response['message'] = "Other Images not uploaded!";
                print_r(json_encode($response));
                return false;
            } else {
                $result = $fn->validate_other_images($_FILES["injury_images"]["tmp_name"][$i], $_FILES["injury_images"]["type"][$i]);
                if ($result) {
                    $response['error'] = true;
                    $response['message'] = "other image type must jpg, jpeg, gif, or png!";
                    print_r(json_encode($response));
                    return false;
                }
            }
        }
    }

    $injury_images = '';

    if (isset($_FILES['injury_images']) && ($_FILES['injury_images']['size'][0] > 0)) {
        $file_data = array();
        $target_path = '../../upload/injury_images/';
        $target_path1 = 'upload/injury_images/';
        for ($i = 0; $i < count($_FILES["injury_images"]["name"]); $i++) {

            $filename = $_FILES["injury_images"]["name"][$i];
            $temp = explode('.', $filename);
            $filename = microtime(true) . '-' . rand(100, 999) . '.' . end($temp);
            $file_data[] = $target_path1 . '' . $filename;
            if (!move_uploaded_file($_FILES["injury_images"]["tmp_name"][$i], $target_path . '' . $filename)) {
                $response['error'] = true;
                $response['message'] = "Other Images not uploaded!";
                print_r(json_encode($response));
                return false;
            }
        }
        $injury_images = !empty($file_data) ? json_encode($file_data) : "";
    }

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

    $emp_count = (isset($_POST['emp_count'])) ? $db->escapeString($_POST['emp_count']) : "";

    $injured_person_name = explode(",", $injured_person_name);
    $injured_person_age = explode(",", $injured_person_age);
    $injured_person_sex = explode(",", $injured_person_sex);
    $injured_person_designation = explode(",", $injured_person_designation);
    $injured_person_injury_nature = explode(",", $injured_person_injury_nature);

    for ($i = 0; $i < $emp_count; $i++) {

        $data = array(); {
            $data = array(
                'approved_by' => $approved_by,
                'rev' => $rev,
                'project_name' => $project_name,
                'incident_no' => $incident_no,
                'project_manager' => $project_manager,
                'section_incharge' => $section_incharge,
                'site_manager' => $site_manager,
                'safty_officer' => $safty_officer,
                'date' => $date,
                'time' => $time,
                'subcontractor_involved' => $subcontractor_involved,
                'injured_person_name' => $injured_person_name[$i],
                'injured_person_age' => $injured_person_age[$i],
                'injured_person_sex' => $injured_person_sex[$i],
                'injured_person_designation' => $injured_person_designation[$i],
                'injured_person_injury_nature' => $injured_person_injury_nature[$i],
                'injury_location' => $injury_location,
                'incedent_description' => $incedent_description,
                'witness_name' => $witness_name,
                'injury_images' => $injury_images,
                'root_cause' => $root_cause,
                'corrective_action' => $corrective_action,
                'preventive_action' => $preventive_action,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('near_miss_records', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Near Miss Record Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Near Miss Record Not Submitted";
    echo json_encode($response);
}
