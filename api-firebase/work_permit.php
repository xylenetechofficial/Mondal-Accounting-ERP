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
$accesskey = $db->escapeString($fn->xss_clean($_POST['accesskey']));

if ($access_key != $accesskey) {
    $response['error'] = true;
    $response['message'] = "invalid accesskey";
    print_r(json_encode($response));
    return false;
}

if ((isset($_POST['type'])) && ($_POST['type'] == 'work_permit')) {
    /*
    if (!verify_token()) {
        return false;
    }*/

    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";
    $effective_date = (isset($_POST['effective_date'])) ? $db->escapeString($fn->xss_clean($_POST['effective_date'])) : "";
    $si_no = (isset($_POST['si_no'])) ? $db->escapeString($fn->xss_clean($_POST['si_no'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $section = (isset($_POST['section'])) ? $db->escapeString($fn->xss_clean($_POST['section'])) : "";
    $org_permit_valid_from = (isset($_POST['org_permit_valid_from'])) ? $db->escapeString($fn->xss_clean($_POST['org_permit_valid_from'])) : "";
    $org_permit_valid_to = (isset($_POST['org_permit_valid_to'])) ? $db->escapeString($fn->xss_clean($_POST['org_permit_valid_to'])) : "";
    $renewal_valid_from1 = (isset($_POST['renewal_valid_from1'])) ? $db->escapeString($fn->xss_clean($_POST['renewal_valid_from1'])) : "";
    $renewal_valid_to1 = (isset($_POST['renewal_valid_to1'])) ? $db->escapeString($fn->xss_clean($_POST['renewal_valid_to1'])) : "";
    $renewal_valid_from2 = (isset($_POST['renewal_valid_from2'])) ? $db->escapeString($fn->xss_clean($_POST['renewal_valid_from2'])) : "";
    $renewal_valid_to2 = (isset($_POST['renewal_valid_to2'])) ? $db->escapeString($fn->xss_clean($_POST['renewal_valid_to2'])) : "";
    $job_description = (isset($_POST['job_description'])) ? $db->escapeString($fn->xss_clean($_POST['job_description'])) : "";
    $working_agency_name = (isset($_POST['working_agency_name'])) ? $db->escapeString($fn->xss_clean($_POST['working_agency_name'])) : "";
    $work_permit_area = (isset($_POST['work_permit_area'])) ? $db->escapeString($fn->xss_clean($_POST['work_permit_area'])) : "";
    $welding_gas_cutting = (isset($_POST['welding_gas_cutting'])) ? $db->escapeString($fn->xss_clean($_POST['welding_gas_cutting'])) : "";
    $rigging_fitting = (isset($_POST['rigging_fitting'])) ? $db->escapeString($fn->xss_clean($_POST['rigging_fitting'])) : "";
    $work_at_height = (isset($_POST['work_at_height'])) ? $db->escapeString($fn->xss_clean($_POST['work_at_height'])) : "";
    $Hydraulic_Pneumatic = (isset($_POST['Hydraulic_Pneumatic'])) ? $db->escapeString($fn->xss_clean($_POST['Hydraulic_Pneumatic'])) : "";
    $painting_cleaning = (isset($_POST['painting_cleaning'])) ? $db->escapeString($fn->xss_clean($_POST['painting_cleaning'])) : "";
    $confined_space = (isset($_POST['confined_space'])) ? $db->escapeString($fn->xss_clean($_POST['confined_space'])) : "";
    $gas = (isset($_POST['gas'])) ? $db->escapeString($fn->xss_clean($_POST['gas'])) : "";
    $electrical = (isset($_POST['electrical'])) ? $db->escapeString($fn->xss_clean($_POST['electrical'])) : "";
    $other = (isset($_POST['other'])) ? $db->escapeString($fn->xss_clean($_POST['other'])) : "";

    $gas_hazard_permit_taken = (isset($_POST['gas_hazard_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['gas_hazard_permit_taken'])) : ""; ///
    $gas_hazard_permit_no = (isset($_POST['gas_hazard_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['gas_hazard_permit_no'])) : "";
    $confined_space_permit_taken = (isset($_POST['confined_space_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['confined_space_permit_taken'])) : "";
    $confined_space_permit_no = (isset($_POST['confined_space_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['confined_space_permit_no'])) : "";
    $electrical_power_permit_taken = (isset($_POST['electrical_power_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['electrical_power_permit_taken'])) : "";
    $electrical_power_permit_no = (isset($_POST['electrical_power_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['electrical_power_permit_no'])) : "";
    $grounding_discharging_permit_taken = (isset($_POST['grounding_discharging_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['grounding_discharging_permit_taken'])) : "";
    $grounding_discharging_permit_no = (isset($_POST['grounding_discharging_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['grounding_discharging_permit_no'])) : "";
    $Hydraulic_Pneumatic_permit_taken = (isset($_POST['Hydraulic_Pneumatic_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['Hydraulic_Pneumatic_permit_taken'])) : "";
    $Hydraulic_Pneumatic_permit_no = (isset($_POST['Hydraulic_Pneumatic_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['Hydraulic_Pneumatic_permit_no'])) : "";
    $hot_work_permit_taken = (isset($_POST['hot_work_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['hot_work_permit_taken'])) : "";
    $hot_work_permit_no = (isset($_POST['hot_work_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['hot_work_permit_no'])) : "";
    $mechanized_grading_permit_taken = (isset($_POST['mechanized_grading_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['mechanized_grading_permit_taken'])) : "";
    $mechanized_grading_permit_no = (isset($_POST['mechanized_grading_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['mechanized_grading_permit_no'])) : "";
    $positive_isolation_permit_taken = (isset($_POST['positive_isolation_permit_taken'])) ? $db->escapeString($fn->xss_clean($_POST['positive_isolation_permit_taken'])) : "";
    $positive_isolation_permit_no = (isset($_POST['positive_isolation_permit_no'])) ? $db->escapeString($fn->xss_clean($_POST['positive_isolation_permit_no'])) : "";

    $spl_instruction = (isset($_POST['spl_instruction'])) ? $db->escapeString($fn->xss_clean($_POST['spl_instruction'])) : ""; ///

    $permit_org_name_req_by = (isset($_POST['permit_org_name_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_name_req_by'])) : ""; ///
    $permit_org_name_issued_by = (isset($_POST['permit_org_name_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_name_issued_by'])) : "";
    $permit_org_name_taken_by_working = (isset($_POST['permit_org_name_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_name_taken_by_working'])) : "";
    $permit_org_name_taken_by_central = (isset($_POST['permit_org_name_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_name_taken_by_central'])) : "";
    $renewal1_name_req_by = (isset($_POST['renewal1_name_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_name_req_by'])) : "";
    $renewal1_name_issued_by = (isset($_POST['renewal1_name_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_name_issued_by'])) : "";
    $renewal1_name_taken_by_working = (isset($_POST['renewal1_name_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_name_taken_by_working'])) : "";
    $renewal1_name_taken_by_central = (isset($_POST['renewal1_name_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_name_taken_by_central'])) : "";
    $renewal2_name_req_by = (isset($_POST['renewal2_name_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_name_req_by'])) : "";
    $renewal2_name_issued_by = (isset($_POST['renewal2_name_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_name_issued_by'])) : "";
    $renewal2_name_taken_by_working = (isset($_POST['renewal2_name_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_name_taken_by_working'])) : "";
    $renewal2_name_taken_by_central = (isset($_POST['renewal2_name_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_name_taken_by_central'])) : "";
    $permit_org_designation_req_by = (isset($_POST['permit_org_designation_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_designation_req_by'])) : "";
    $permit_org_designation_issued_by = (isset($_POST['permit_org_designation_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_designation_issued_by'])) : "";
    $permit_org_designation_taken_by_working = (isset($_POST['permit_org_designation_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_designation_taken_by_working'])) : "";
    $permit_org_designation_taken_by_central = (isset($_POST['permit_org_designation_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_designation_taken_by_central'])) : "";
    $renewal1_designation_req_by = (isset($_POST['renewal1_designation_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_designation_req_by'])) : "";
    $renewal1_designation_issued_by = (isset($_POST['renewal1_designation_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_designation_issued_by'])) : "";
    $renewal1_designation_taken_by_working = (isset($_POST['renewal1_designation_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_designation_taken_by_working'])) : "";
    $renewal1_designation_taken_by_central = (isset($_POST['renewal1_designation_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_designation_taken_by_central'])) : "";
    $renewal2_designation_req_by = (isset($_POST['renewal2_designation_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_designation_req_by'])) : "";
    $renewal2_designation_issued_by = (isset($_POST['renewal2_designation_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_designation_issued_by'])) : "";
    $renewal2_designation_taken_by_working = (isset($_POST['renewal2_designation_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_designation_taken_by_working'])) : "";
    $renewal2_designation_taken_by_central = (isset($_POST['renewal2_designation_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_designation_taken_by_central'])) : "";
    $permit_org_signature_req_by = (isset($_POST['permit_org_signature_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_signature_req_by'])) : "";
    $permit_org_signature_issued_by = (isset($_POST['permit_org_signature_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_signature_issued_by'])) : "";
    $permit_org_signature_taken_by_working = (isset($_POST['permit_org_signature_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_signature_taken_by_working'])) : "";
    $permit_org_signature_taken_by_central = (isset($_POST['permit_org_signature_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['permit_org_signature_taken_by_central'])) : "";
    $renewal1_signature_req_by = (isset($_POST['renewal1_signature_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_signature_req_by'])) : "";
    $renewal1_signature_issued_by = (isset($_POST['renewal1_signature_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_signature_issued_by'])) : "";
    $renewal1_signature_taken_by_working = (isset($_POST['renewal1_signature_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_signature_taken_by_working'])) : "";
    $renewal1_signature_taken_by_central = (isset($_POST['renewal1_signature_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1_signature_taken_by_central'])) : "";
    $renewal2_signature_req_by = (isset($_POST['renewal2_signature_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_signature_req_by'])) : "";
    $renewal2_signature_issued_by = (isset($_POST['renewal2_signature_issued_by'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_signature_issued_by'])) : "";
    $renewal2_signature_taken_by_working = (isset($_POST['renewal2_signature_taken_by_working'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_signature_taken_by_working'])) : "";
    $renewal2_signature_taken_by_central = (isset($_POST['renewal2_signature_taken_by_central'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2_signature_taken_by_central'])) : "";

    $name_return_by_working_agency = (isset($_POST['name_return_by_working_agency'])) ? $db->escapeString($fn->xss_clean($_POST['name_return_by_working_agency'])) : ""; ///
    $name_return_by_taken_by = (isset($_POST['name_return_by_taken_by'])) ? $db->escapeString($fn->xss_clean($_POST['name_return_by_taken_by'])) : "";
    $name_revived_by_executive = (isset($_POST['name_revived_by_executive'])) ? $db->escapeString($fn->xss_clean($_POST['name_revived_by_executive'])) : "";
    $name_revived_by_owner = (isset($_POST['name_revived_by_owner'])) ? $db->escapeString($fn->xss_clean($_POST['name_revived_by_owner'])) : "";
    $designation_return_by_working_agency = (isset($_POST['designation_return_by_working_agency'])) ? $db->escapeString($fn->xss_clean($_POST['designation_return_by_working_agency'])) : "";
    $designation_return_by_taken_by = (isset($_POST['designation_return_by_taken_by'])) ? $db->escapeString($fn->xss_clean($_POST['designation_return_by_taken_by'])) : "";
    $designation_revived_by_executive = (isset($_POST['designation_revived_by_executive'])) ? $db->escapeString($fn->xss_clean($_POST['designation_revived_by_executive'])) : "";
    $designation_revived_by_owner = (isset($_POST['designation_revived_by_owner'])) ? $db->escapeString($fn->xss_clean($_POST['designation_revived_by_owner'])) : "";
    $signature_return_by_working_agency = (isset($_POST['signature_return_by_working_agency'])) ? $db->escapeString($fn->xss_clean($_POST['signature_return_by_working_agency'])) : "";
    $signature_return_by_taken_by = (isset($_POST['signature_return_by_taken_by'])) ? $db->escapeString($fn->xss_clean($_POST['signature_return_by_taken_by'])) : "";
    $signature_revived_by_executive = (isset($_POST['signature_revived_by_executive'])) ? $db->escapeString($fn->xss_clean($_POST['signature_revived_by_executive'])) : "";
    $signature_revived_by_owner = (isset($_POST['signature_revived_by_owner'])) ? $db->escapeString($fn->xss_clean($_POST['signature_revived_by_owner'])) : "";

    $north_hazard = (isset($_POST['north_hazard'])) ? $db->escapeString($fn->xss_clean($_POST['north_hazard'])) : ""; ///
    $north_precautions = (isset($_POST['north_precautions'])) ? $db->escapeString($fn->xss_clean($_POST['north_precautions'])) : "";
    $south_remark = (isset($_POST['south_remark'])) ? $db->escapeString($fn->xss_clean($_POST['south_remark'])) : "";
    $south_hazard = (isset($_POST['south_hazard'])) ? $db->escapeString($fn->xss_clean($_POST['south_hazard'])) : "";
    $south_precautions = (isset($_POST['south_precautions'])) ? $db->escapeString($fn->xss_clean($_POST['south_precautions'])) : "";
    $north_remark = (isset($_POST['north_remark'])) ? $db->escapeString($fn->xss_clean($_POST['north_remark'])) : "";
    $east_hazard = (isset($_POST['east_hazard'])) ? $db->escapeString($fn->xss_clean($_POST['east_hazard'])) : "";
    $east_precautions = (isset($_POST['east_precautions'])) ? $db->escapeString($fn->xss_clean($_POST['east_precautions'])) : "";
    $east_remark = (isset($_POST['east_remark'])) ? $db->escapeString($fn->xss_clean($_POST['east_remark'])) : "";
    $west_hazard = (isset($_POST['west_hazard'])) ? $db->escapeString($fn->xss_clean($_POST['west_hazard'])) : "";
    $west_precautions = (isset($_POST['west_precautions'])) ? $db->escapeString($fn->xss_clean($_POST['west_precautions'])) : "";
    $west_remark = (isset($_POST['west_remark'])) ? $db->escapeString($fn->xss_clean($_POST['west_remark'])) : "";
    $top_hazard = (isset($_POST['top_hazard'])) ? $db->escapeString($fn->xss_clean($_POST['top_hazard'])) : "";
    $top_precautions = (isset($_POST['top_precautions'])) ? $db->escapeString($fn->xss_clean($_POST['top_precautions'])) : "";
    $top_remark = (isset($_POST['top_remark'])) ? $db->escapeString($fn->xss_clean($_POST['top_remark'])) : "";
    $bottom_hazard = (isset($_POST['bottom_hazard'])) ? $db->escapeString($fn->xss_clean($_POST['bottom_hazard'])) : "";
    $bottom_precautions = (isset($_POST['bottom_precautions'])) ? $db->escapeString($fn->xss_clean($_POST['bottom_precautions'])) : "";
    $bottom_remark = (isset($_POST['bottom_remark'])) ? $db->escapeString($fn->xss_clean($_POST['bottom_remark'])) : "";

    $sign_permit_req_by = (isset($_POST['sign_permit_req_by'])) ? $db->escapeString($fn->xss_clean($_POST['sign_permit_req_by'])) : ""; ///

    $sop_made_approved = (isset($_POST['sop_made_approved'])) ? $db->escapeString($fn->xss_clean($_POST['sop_made_approved'])) : ""; ///
    $test_pass_certificate = (isset($_POST['test_pass_certificate'])) ? $db->escapeString($fn->xss_clean($_POST['test_pass_certificate'])) : "";
    $medically_fit = (isset($_POST['medically_fit'])) ? $db->escapeString($fn->xss_clean($_POST['medically_fit'])) : "";
    $tools_condition_Certificate = (isset($_POST['tools_condition_Certificate'])) ? $db->escapeString($fn->xss_clean($_POST['tools_condition_Certificate'])) : "";
    $trained_on_sop = (isset($_POST['trained_on_sop'])) ? $db->escapeString($fn->xss_clean($_POST['trained_on_sop'])) : "";

    $work_person_count = (isset($_POST['work_person_count'])) ? $db->escapeString($fn->xss_clean($_POST['work_person_count'])) : "";
    $work_person_name = (isset($_POST['work_person_name'])) ? $db->escapeString($fn->xss_clean($_POST['work_person_name'])) : ""; ///
    $emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    $in_time = (isset($_POST['in_time'])) ? $db->escapeString($fn->xss_clean($_POST['in_time'])) : "";
    $out_time = (isset($_POST['out_time'])) ? $db->escapeString($fn->xss_clean($_POST['out_time'])) : "";
    $tool_box_talk = (isset($_POST['tool_box_talk'])) ? $db->escapeString($fn->xss_clean($_POST['tool_box_talk'])) : "";
    $renewal1 = (isset($_POST['renewal1'])) ? $db->escapeString($fn->xss_clean($_POST['renewal1'])) : "";
    $renewal2 = (isset($_POST['renewal2'])) ? $db->escapeString($fn->xss_clean($_POST['renewal2'])) : "";

    $work_person_name = explode(",", $work_person_name);
    $emp_no = explode(",", $emp_no);
    $in_time = explode(",", $in_time);
    $out_time = explode(",", $out_time);
    $tool_box_talk = explode(",", $tool_box_talk);
    $renewal1 = explode(",", $renewal1);
    $renewal2 = explode(",", $renewal2);

    $permit_receiver_sign = (isset($_POST['permit_receiver_sign'])) ? $db->escapeString($fn->xss_clean($_POST['permit_receiver_sign'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    for ($i = 0; $i < $work_person_count; $i++) {

        $data = array(); {
            $data = array(
                'doc_no' => $doc_no,
                'rev' => $rev,
                'effective_date' => $effective_date,
                'si_no' => $si_no,
                'date' =>  $date,
                'department' => $department,
                'section' => $section,
                'org_permit_valid_from' => $org_permit_valid_from,
                'org_permit_valid_to' => $org_permit_valid_to,
                'renewal_valid_from1' => $renewal_valid_from1,
                'renewal_valid_to1' => $renewal_valid_to1,
                'renewal_valid_from2' => $renewal_valid_from2,
                'renewal_valid_to2' => $renewal_valid_to2,
                'job_description' => $job_description,
                'working_agency_name' => $working_agency_name,
                'work_permit_area' => $work_permit_area,
                'welding_gas_cutting' => $welding_gas_cutting,
                'rigging_fitting' => $rigging_fitting,
                'work_at_height' => $work_at_height,
                'Hydraulic_Pneumatic' => $Hydraulic_Pneumatic,
                'painting_cleaning' => $painting_cleaning,
                'confined_space' => $confined_space,
                'gas' => $gas,
                'electrical' => $electrical,
                'other' => $other,
                'gas_hazard_permit_taken' => $gas_hazard_permit_taken,
                'gas_hazard_permit_no' => $gas_hazard_permit_no,
                'confined_space_permit_taken' => $confined_space_permit_taken,
                'confined_space_permit_no' => $confined_space_permit_no,
                'electrical_power_permit_taken' => $electrical_power_permit_taken,
                'electrical_power_permit_no' => $electrical_power_permit_no,
                'grounding_discharging_permit_taken' => $grounding_discharging_permit_taken,
                'grounding_discharging_permit_no' => $grounding_discharging_permit_no,
                'Hydraulic_Pneumatic_permit_taken' => $Hydraulic_Pneumatic_permit_taken,
                'Hydraulic_Pneumatic_permit_no' => $Hydraulic_Pneumatic_permit_no,
                'hot_work_permit_taken' => $hot_work_permit_taken,
                'hot_work_permit_no' => $hot_work_permit_no,
                'mechanized_grading_permit_taken' => $mechanized_grading_permit_taken,
                'mechanized_grading_permit_no' => $mechanized_grading_permit_no,
                'positive_isolation_permit_taken' => $positive_isolation_permit_taken,
                'positive_isolation_permit_no' => $positive_isolation_permit_no,
                'spl_instruction' => $spl_instruction,
                'permit_org_name_req_by' => $permit_org_name_req_by,
                'permit_org_name_issued_by' => $permit_org_name_issued_by,
                'permit_org_name_taken_by_working' => $permit_org_name_taken_by_working,
                'permit_org_name_taken_by_central' => $permit_org_name_taken_by_central,
                'renewal1_name_req_by' =>  $renewal1_name_req_by,
                'renewal1_name_issued_by' =>  $renewal1_name_issued_by,
                'renewal1_name_taken_by_working' => $renewal1_name_taken_by_working,
                'renewal1_name_taken_by_central' => $renewal1_name_taken_by_central,
                'renewal2_name_req_by' => $renewal2_name_req_by,
                'renewal2_name_issued_by' => $renewal2_name_issued_by,
                'renewal2_name_taken_by_working' => $renewal2_name_taken_by_working,
                'renewal2_name_taken_by_central' => $renewal2_name_taken_by_central,
                'permit_org_designation_req_by' =>  $permit_org_designation_req_by,
                'permit_org_designation_issued_by' => $permit_org_designation_issued_by,
                'permit_org_designation_taken_by_working' => $permit_org_designation_taken_by_working,
                'permit_org_designation_taken_by_central' => $permit_org_designation_taken_by_central,
                'renewal1_designation_req_by' => $renewal1_designation_req_by,
                'renewal1_designation_issued_by' => $renewal1_designation_issued_by,
                'renewal1_designation_taken_by_working' => $renewal1_designation_taken_by_working,
                'renewal1_designation_taken_by_central' => $renewal1_designation_taken_by_central,
                'renewal2_designation_req_by' => $renewal2_designation_req_by,
                'renewal2_designation_issued_by' => $renewal2_designation_issued_by,
                'renewal2_designation_taken_by_working' => $renewal2_designation_taken_by_working,
                'renewal2_designation_taken_by_central' => $renewal2_designation_taken_by_central,
                'permit_org_signature_req_by' => $permit_org_signature_req_by,
                'permit_org_signature_issued_by' => $permit_org_signature_issued_by,
                'permit_org_signature_taken_by_working' => $permit_org_signature_taken_by_working,
                'permit_org_signature_taken_by_central' => $permit_org_signature_taken_by_central,
                'renewal1_signature_req_by' => $renewal1_signature_req_by,
                'renewal1_signature_issued_by' => $renewal1_signature_issued_by,
                'renewal1_signature_taken_by_working' => $renewal1_signature_taken_by_working,
                'renewal1_signature_taken_by_central' => $renewal1_signature_taken_by_central,
                'renewal2_signature_req_by' => $renewal2_signature_req_by,
                'renewal2_signature_issued_by' => $renewal2_signature_issued_by,
                'renewal2_signature_taken_by_working' => $renewal2_signature_taken_by_working,
                'renewal2_signature_taken_by_central' => $renewal2_signature_taken_by_central,
                'name_return_by_working_agency' => $name_return_by_working_agency,
                'name_return_by_taken_by' => $name_return_by_taken_by,
                'name_revived_by_executive' => $name_revived_by_executive,
                'name_revived_by_owner' => $name_revived_by_owner,
                'designation_return_by_working_agency' => $designation_return_by_working_agency,
                'designation_return_by_taken_by' => $designation_return_by_taken_by,
                'designation_revived_by_executive' => $designation_revived_by_executive,
                'designation_revived_by_owner' => $designation_revived_by_owner,
                'signature_return_by_working_agency' => $signature_return_by_working_agency,
                'signature_return_by_taken_by' => $signature_return_by_taken_by,
                'signature_revived_by_executive' => $signature_revived_by_executive,
                'signature_revived_by_owner' => $signature_revived_by_owner,
                'north_hazard' => $north_hazard,
                'north_precautions' => $north_precautions,
                'south_remark' => $south_remark,
                'south_hazard' => $south_hazard,
                'south_precautions' => $south_precautions,
                'north_remark' => $north_remark,
                'east_hazard' =>  $east_hazard,
                'east_precautions' =>  $east_precautions,
                'east_remark' => $east_remark,
                'west_hazard' => $west_hazard,
                'west_precautions' => $west_precautions,
                'west_remark' => $west_remark,
                'top_hazard' => $top_hazard,
                'top_precautions' => $top_precautions,
                'top_remark' => $top_remark,
                'bottom_hazard' => $bottom_hazard,
                'bottom_precautions' => $bottom_precautions,
                'bottom_remark' => $bottom_remark,
                'sign_permit_req_by' => $sign_permit_req_by,
                'sop_made_approved' => $sop_made_approved,
                'test_pass_certificate' => $test_pass_certificate,
                'medically_fit' => $medically_fit,
                'tools_condition_Certificate' => $tools_condition_Certificate,
                'trained_on_sop' => $trained_on_sop,
                'work_person_name' => $work_person_name[$i],
                'emp_no' => $emp_no[$i],
                'in_time' =>  $in_time[$i],
                'out_time' =>  $out_time[$i],
                'tool_box_talk' => $tool_box_talk[$i],
                'renewal1' => $renewal1[$i],
                'renewal2' => $renewal2[$i],
                'permit_receiver_sign' => $permit_receiver_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime

            );
        }
        $db->insert('work_permit', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Form Submitted Successfully";
    $response["data"]   = $data;
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Form Not Submitted";
    echo json_encode($response);
}


if ((isset($_POST['type'])) && ($_POST['type'] == 'hot_job')) {
    /*
    if (!verify_token()) {
        return false;
    }*/

    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";
    $effective_date = (isset($_POST['effective_date'])) ? $db->escapeString($fn->xss_clean($_POST['effective_date'])) : "";
    $si_no = (isset($_POST['si_no'])) ? $db->escapeString($fn->xss_clean($_POST['si_no'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $clearance_time_from = (isset($_POST['clearance_time_from'])) ? $db->escapeString($fn->xss_clean($_POST['clearance_time_from'])) : "";
    $clearance_time_to = (isset($_POST['clearance_time_to'])) ? $db->escapeString($fn->xss_clean($_POST['clearance_time_to'])) : "";
    $clearance_date = (isset($_POST['clearance_date'])) ? $db->escapeString($fn->xss_clean($_POST['clearance_date'])) : "";
    $permission_given_to = (isset($_POST['permission_given_to'])) ? $db->escapeString($fn->xss_clean($_POST['permission_given_to'])) : "";
    $designation = (isset($_POST['designation'])) ? $db->escapeString($fn->xss_clean($_POST['designation'])) : "";
    $department = (isset($_POST['department'])) ? $db->escapeString($fn->xss_clean($_POST['department'])) : "";
    $to_take_job = (isset($_POST['to_take_job'])) ? $db->escapeString($fn->xss_clean($_POST['to_take_job'])) : "";
    $section_or_location = (isset($_POST['section_or_location'])) ? $db->escapeString($fn->xss_clean($_POST['section_or_location'])) : "";
    $job_description = (isset($_POST['job_description'])) ? $db->escapeString($fn->xss_clean($_POST['job_description'])) : "";
    $check_points = (isset($_POST['check_points'])) ? $db->escapeString($fn->xss_clean($_POST['check_points'])) : "";
    $marking = (isset($_POST['marking'])) ? $db->escapeString($fn->xss_clean($_POST['marking'])) : "";
    $reason_for_no = (isset($_POST['reason_for_no'])) ? $db->escapeString($fn->xss_clean($_POST['reason_for_no'])) : "";
    $executing_signature = (isset($_POST['executing_signature'])) ? $db->escapeString($fn->xss_clean($_POST['executing_signature'])) : "";
    $executing_agency = (isset($_POST['executing_agency'])) ? $db->escapeString($fn->xss_clean($_POST['executing_agency'])) : "";
    $executing_name = (isset($_POST['executing_name'])) ? $db->escapeString($fn->xss_clean($_POST['executing_name'])) : "";
    $executing_designation = (isset($_POST['executing_designation'])) ? $db->escapeString($fn->xss_clean($_POST['executing_designation'])) : "";
    $executing_department = (isset($_POST['executing_department'])) ? $db->escapeString($fn->xss_clean($_POST['executing_department'])) : "";
    $executing_date = (isset($_POST['executing_date'])) ? $db->escapeString($fn->xss_clean($_POST['executing_date'])) : "";
    $executing_time = (isset($_POST['executing_time'])) ? $db->escapeString($fn->xss_clean($_POST['executing_time'])) : "";
    $issuer_signature = (isset($_POST['issuer_signature'])) ? $db->escapeString($fn->xss_clean($_POST['issuer_signature'])) : "";
    $issuer_name = (isset($_POST['issuer_name'])) ? $db->escapeString($fn->xss_clean($_POST['issuer_name'])) : "";
    $issuer_designation = (isset($_POST['issuer_designation'])) ? $db->escapeString($fn->xss_clean($_POST['issuer_designation'])) : "";
    $issuer_department = (isset($_POST['issuer_department'])) ? $db->escapeString($fn->xss_clean($_POST['issuer_department'])) : "";
    $issuer_date = (isset($_POST['issuer_date'])) ? $db->escapeString($fn->xss_clean($_POST['issuer_date'])) : "";
    $issuer_time = (isset($_POST['issuer_time'])) ? $db->escapeString($fn->xss_clean($_POST['issuer_time'])) : "";
    $approver_signature = (isset($_POST['approver_signature'])) ? $db->escapeString($fn->xss_clean($_POST['approver_signature'])) : "";
    $approver_name = (isset($_POST['approver_name'])) ? $db->escapeString($fn->xss_clean($_POST['approver_name'])) : "";
    $approver_designation = (isset($_POST['approver_designation'])) ? $db->escapeString($fn->xss_clean($_POST['approver_designation'])) : "";
    $approver_department = (isset($_POST['approver_department'])) ? $db->escapeString($fn->xss_clean($_POST['approver_department'])) : "";
    $approver_date = (isset($_POST['approver_date'])) ? $db->escapeString($fn->xss_clean($_POST['approver_date'])) : "";
    $approver_time = (isset($_POST['approver_time'])) ? $db->escapeString($fn->xss_clean($_POST['approver_time'])) : "";
    $return_undertaking_to = (isset($_POST['return_undertaking_to'])) ? $db->escapeString($fn->xss_clean($_POST['return_undertaking_to'])) : "";
    $return_undertaking_job_descript = (isset($_POST['return_undertaking_job_descript'])) ? $db->escapeString($fn->xss_clean($_POST['return_undertaking_job_descript'])) : "";
    $return_undertaking_designation = (isset($_POST['return_undertaking_designation'])) ? $db->escapeString($fn->xss_clean($_POST['return_undertaking_designation'])) : "";
    $return_undertaking_department = (isset($_POST['return_undertaking_department'])) ? $db->escapeString($fn->xss_clean($_POST['return_undertaking_department'])) : "";
    $work_agency_date = (isset($_POST['work_agency_date'])) ? $db->escapeString($fn->xss_clean($_POST['work_agency_date'])) : "";
    $work_agency_sign = (isset($_POST['work_agency_sign'])) ? $db->escapeString($fn->xss_clean($_POST['work_agency_sign'])) : "";
    $work_agency_time = (isset($_POST['work_agency_time'])) ? $db->escapeString($fn->xss_clean($_POST['work_agency_time'])) : "";
    $work_agency_name = (isset($_POST['work_agency_name'])) ? $db->escapeString($fn->xss_clean($_POST['work_agency_name'])) : "";
    $work_agency_designation = (isset($_POST['work_agency_designation'])) ? $db->escapeString($fn->xss_clean($_POST['work_agency_designation'])) : "";
    $work_agency_department = (isset($_POST['work_agency_department'])) ? $db->escapeString($fn->xss_clean($_POST['work_agency_department'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $points_count = (isset($_POST['points_count'])) ? $db->escapeString($fn->xss_clean($_POST['points_count'])) : "";
    
    $check_points = explode(",", $check_points);
    $marking = explode(",", $marking);
    $reason_for_no = explode(",", $reason_for_no);


    for ($i = 0; $i < $points_count; $i++) {

        $data = array(); {
            $data = array(
                'doc_no' => $doc_no,
                'rev' => $rev,
                'effective_date' => $effective_date,
                'si_no' => $si_no,
                'date' =>  $date,
                'clearance_time_from' => $clearance_time_from,
                'clearance_time_to' => $clearance_time_to,
                'clearance_date' => $clearance_date,
                'permission_given_to' => $permission_given_to,
                'designation' => $designation,
                'department' => $department,
                'to_take_job' => $to_take_job,
                'section_or_location' => $section_or_location,
                'job_description' => $job_description,
                'check_points' => $check_points[$i],
                'marking' => $marking[$i],
                'reason_for_no' => $reason_for_no[$i],
                'executing_signature' => $executing_signature,
                'executing_agency' => $executing_agency,
                'executing_name' => $executing_name,
                'executing_designation' => $executing_designation,
                'executing_department' => $executing_department,
                'executing_date' => $executing_date,
                'executing_time' => $executing_time,
                'issuer_signature' => $issuer_signature,
                'issuer_name' => $issuer_name,
                'issuer_designation' => $issuer_designation,
                'issuer_department' => $issuer_department,
                'issuer_date' => $issuer_date,
                'issuer_time' => $issuer_time,
                'approver_signature' => $approver_signature,
                'approver_name' => $approver_name,
                'approver_designation' => $approver_designation,
                'approver_department' => $approver_department,
                'approver_date' => $approver_date,
                'approver_time' => $approver_time,
                'return_undertaking_to' => $return_undertaking_to,
                'return_undertaking_job_descript' => $return_undertaking_job_descript,
                'return_undertaking_designation' => $return_undertaking_designation,
                'return_undertaking_department' => $return_undertaking_department,
                'work_agency_date' => $work_agency_date,
                'work_agency_sign' => $work_agency_sign,
                'work_agency_time' => $work_agency_time,
                'work_agency_name' => $work_agency_name,
                'work_agency_designation' => $work_agency_designation,
                'work_agency_department' => $work_agency_department,
                'location_id' =>  $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime

            );
        }
        $db->insert('hot_job', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Hot Job Form Submitted Successfully";
    $response["data"]   = $data;
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Hot Job Form Not Submitted";
    echo json_encode($response);
}

if ((isset($_POST['type'])) && ($_POST['type'] == 'working_at_height')) {
    /*
    if (!verify_token()) {
        return false;
    }*/

    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    $doc_no = (isset($_POST['doc_no'])) ? $db->escapeString($fn->xss_clean($_POST['doc_no'])) : "";
    $ref_no = (isset($_POST['ref_no'])) ? $db->escapeString($fn->xss_clean($_POST['ref_no'])) : "";
    $rev = (isset($_POST['rev'])) ? $db->escapeString($fn->xss_clean($_POST['rev'])) : "";
    $si_no = (isset($_POST['si_no'])) ? $db->escapeString($fn->xss_clean($_POST['si_no'])) : "";
    $effective_date = (isset($_POST['effective_date'])) ? $db->escapeString($fn->xss_clean($_POST['effective_date'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $agency_name = (isset($_POST['agency_name'])) ? $db->escapeString($fn->xss_clean($_POST['agency_name'])) : "";
    $exact_location = (isset($_POST['exact_location'])) ? $db->escapeString($fn->xss_clean($_POST['exact_location'])) : "";
    $job_description = (isset($_POST['job_description'])) ? $db->escapeString($fn->xss_clean($_POST['job_description'])) : "";
    $duration_time_from = (isset($_POST['duration_time_from'])) ? $db->escapeString($fn->xss_clean($_POST['duration_time_from'])) : "";
    $duration_time_to = (isset($_POST['duration_time_to'])) ? $db->escapeString($fn->xss_clean($_POST['duration_time_to'])) : "";
    $commencement_date = (isset($_POST['commencement_date'])) ? $db->escapeString($fn->xss_clean($_POST['commencement_date'])) : "";
    $check_points = (isset($_POST['check_points'])) ? $db->escapeString($fn->xss_clean($_POST['check_points'])) : "";
    $marking = (isset($_POST['marking'])) ? $db->escapeString($fn->xss_clean($_POST['marking'])) : "";
    $site_engg_name = (isset($_POST['site_engg_name'])) ? $db->escapeString($fn->xss_clean($_POST['site_engg_name'])) : "";
    $site_engg_sign = (isset($_POST['site_engg_sign'])) ? $db->escapeString($fn->xss_clean($_POST['site_engg_sign'])) : "";
    $site_engg_date = (isset($_POST['site_engg_date'])) ? $db->escapeString($fn->xss_clean($_POST['site_engg_date'])) : "";
    $mandal_engg_name = (isset($_POST['mandal_engg_name'])) ? $db->escapeString($fn->xss_clean($_POST['mandal_engg_name'])) : "";
    $mandal_engg_sign = (isset($_POST['mandal_engg_sign'])) ? $db->escapeString($fn->xss_clean($_POST['mandal_engg_sign'])) : "";
    $mandal_engg_date = (isset($_POST['mandal_engg_date'])) ? $db->escapeString($fn->xss_clean($_POST['mandal_engg_date'])) : "";
    $hod_sign = (isset($_POST['hod_sign'])) ? $db->escapeString($fn->xss_clean($_POST['hod_sign'])) : "";

    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);

    $points_count = (isset($_POST['points_count'])) ? $db->escapeString($fn->xss_clean($_POST['points_count'])) : "";

    $check_points = explode(",", $check_points);
    $marking = explode(",", $marking);

    for ($i = 0; $i < $points_count; $i++) {

        $data = array(); {
            $data = array(
                'doc_no' => $doc_no,
                'ref_no' => $ref_no,
                'rev' => $rev,
                'si_no' => $si_no,
                'effective_date' =>  $effective_date,
                'date' => $date,
                'agency_name' => $agency_name,
                'exact_location' => $exact_location,
                'job_description' => $job_description,
                'duration_time_from' => $duration_time_from,
                'duration_time_to' => $duration_time_to,
                'commencement_date' => $commencement_date,
                'check_points' => $check_points[$i],
                'marking' => $marking[$i],
                'site_engg_name' => $site_engg_name,
                'site_engg_sign' => $site_engg_sign,
                'site_engg_date' => $site_engg_date,
                'mandal_engg_name' => $mandal_engg_name,
                'mandal_engg_sign' => $mandal_engg_sign,
                'mandal_engg_date' => $mandal_engg_date,
                'hod_sign' => $hod_sign,
                'location_id' =>  $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime

            );
        }
        $db->insert('working_at_height', $data);
        $res = $db->getResult();
    }
    $data = array();
    $i = 0;

    $response["error"]   = false;
    $response["message"] = "Working At Height Form Submitted Successfully";
    $response["data"]   = $data;
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Working At Height Form Not Submitted";
    echo json_encode($response);
}
