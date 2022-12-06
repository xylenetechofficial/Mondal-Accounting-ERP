<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$date = $_GET['date'];
$department = $_GET['department'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `work_permit` WHERE date = '$date' AND department = '$department' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $doc_no = $row['doc_no'];
$rev = $row['rev'];
$effective_date = $row['effective_date'];
$si_no = $row['si_no'];
$date = $row['date'];
$department = $row['department'];
$section = $row['section'];
$org_permit_valid_from = $row['org_permit_valid_from'];
$org_permit_valid_to = $row['org_permit_valid_to'];
$renewal_valid_from1 = $row['renewal_valid_from1'];
$renewal_valid_to1 = $row['renewal_valid_to1'];
$renewal_valid_from2 = $row['renewal_valid_from2'];
$renewal_valid_to2 = $row['renewal_valid_to2'];
$job_description = $row['job_description'];
$working_agency_name = $row['working_agency_name'];
$work_permit_area = $row['work_permit_area'];
$welding_gas_cutting = $row['welding_gas_cutting'];
$rigging_fitting = $row['rigging_fitting'];
$work_at_height = $row['work_at_height'];
$Hydraulic_Pneumatic = $row['Hydraulic_Pneumatic'];
$painting_cleaning = $row['painting_cleaning'];
$confined_space = $row['confined_space'];
$gas = $row['gas'];
$electrical = $row['electrical'];
$other = $row['other'];
$gas_hazard_permit_taken = $row['gas_hazard_permit_taken'];
$gas_hazard_permit_no = $row['gas_hazard_permit_no'];
$confined_space_permit_taken = $row['confined_space_permit_taken'];
$confined_space_permit_no = $row['confined_space_permit_no'];
$electrical_power_permit_taken = $row['electrical_power_permit_taken'];
$electrical_power_permit_no = $row['electrical_power_permit_no'];
$grounding_discharging_permit_taken = $row['grounding_discharging_permit_taken'];
$grounding_discharging_permit_no = $row['grounding_discharging_permit_no'];
$Hydraulic_Pneumatic_permit_taken = $row['Hydraulic_Pneumatic_permit_taken'];
$Hydraulic_Pneumatic_permit_no = $row['Hydraulic_Pneumatic_permit_no'];
$hot_work_permit_taken = $row['hot_work_permit_taken'];
$hot_work_permit_no = $row['hot_work_permit_no'];
$mechanized_grading_permit_taken = $row['mechanized_grading_permit_taken'];
$mechanized_grading_permit_no = $row['mechanized_grading_permit_no'];
$positive_isolation_permit_taken = $row['positive_isolation_permit_taken'];
$positive_isolation_permit_no = $row['positive_isolation_permit_no'];
$spl_instruction = $row['spl_instruction'];
$permit_org_name_req_by = $row['permit_org_name_req_by'];
$permit_org_name_issued_by = $row['permit_org_name_issued_by'];
$permit_org_name_taken_by_working = $row['permit_org_name_taken_by_working'];
$permit_org_name_taken_by_central = $row['permit_org_name_taken_by_central'];
$renewal1_name_req_by = $row['renewal1_name_req_by'];
$renewal1_name_issued_by = $row['renewal1_name_issued_by'];
$renewal1_name_taken_by_working = $row['renewal1_name_taken_by_working'];
$renewal1_name_taken_by_central = $row['renewal1_name_taken_by_central'];
$renewal2_name_req_by = $row['renewal2_name_req_by'];
$renewal2_name_issued_by = $row['renewal2_name_issued_by'];
$renewal2_name_taken_by_working = $row['renewal2_name_taken_by_working'];
$renewal2_name_taken_by_central = $row['renewal2_name_taken_by_central'];
$permit_org_designation_req_by = $row['permit_org_designation_req_by'];
$permit_org_designation_issued_by = $row['permit_org_designation_issued_by'];
$permit_org_designation_taken_by_working = $row['permit_org_designation_taken_by_working'];
$permit_org_designation_taken_by_central = $row['permit_org_designation_taken_by_central'];
$renewal1_designation_req_by = $row['renewal1_designation_req_by'];
$renewal1_designation_issued_by = $row['renewal1_designation_issued_by'];
$renewal1_designation_taken_by_working = $row['renewal1_designation_taken_by_working'];
$renewal1_designation_taken_by_central = $row['renewal1_designation_taken_by_central'];
$renewal2_designation_req_by = $row['renewal2_designation_req_by'];
$renewal2_designation_issued_by = $row['renewal2_designation_issued_by'];
$renewal2_designation_taken_by_working = $row['renewal2_designation_taken_by_working'];
$renewal2_designation_taken_by_central = $row['renewal2_designation_taken_by_central'];
$permit_org_signature_req_by = $row['permit_org_signature_req_by'];
$permit_org_signature_issued_by = $row['permit_org_signature_issued_by'];
$permit_org_signature_taken_by_working = $row['permit_org_signature_taken_by_working'];
$permit_org_signature_taken_by_central = $row['permit_org_signature_taken_by_central'];
$renewal1_signature_req_by = $row['renewal1_signature_req_by'];
$renewal1_signature_issued_by = $row['renewal1_signature_issued_by'];
$renewal1_signature_taken_by_working = $row['renewal1_signature_taken_by_working'];
$renewal1_signature_taken_by_central = $row['renewal1_signature_taken_by_central'];
$renewal2_signature_req_by = $row['renewal2_signature_req_by'];
$renewal2_signature_issued_by = $row['renewal2_signature_issued_by'];
$renewal2_signature_taken_by_working = $row['renewal2_signature_taken_by_working'];
$renewal2_signature_taken_by_central = $row['renewal2_signature_taken_by_central'];
$name_return_by_working_agency = $row['name_return_by_working_agency'];
$name_return_by_taken_by = $row['name_return_by_taken_by'];
$name_revived_by_executive = $row['name_revived_by_executive'];
$name_revived_by_owner = $row['name_revived_by_owner'];
$designation_return_by_working_agency = $row['designation_return_by_working_agency'];
$designation_return_by_taken_by = $row['designation_return_by_taken_by'];
$designation_revived_by_executive = $row['designation_revived_by_executive'];
$designation_revived_by_owner = $row['designation_revived_by_owner'];
$signature_return_by_working_agency = $row['signature_return_by_working_agency'];
$signature_return_by_taken_by = $row['signature_return_by_taken_by'];
$signature_revived_by_executive = $row['signature_revived_by_executive'];
$signature_revived_by_owner = $row['signature_revived_by_owner'];
$north_hazard = $row['north_hazard'];
$north_precautions = $row['north_precautions'];
$south_remark = $row['south_remark'];
$south_hazard = $row['south_hazard'];
$south_precautions = $row['south_precautions'];
$north_remark = $row['north_remark'];
$east_hazard = $row['east_hazard'];
$east_precautions = $row['east_precautions'];
$east_remark = $row['east_remark'];
$west_hazard = $row['west_hazard'];
$west_precautions = $row['west_precautions'];
$west_remark = $row['west_remark'];
$top_hazard = $row['top_hazard'];
$top_precautions = $row['top_precautions'];
$top_remark = $row['top_remark'];
$bottom_hazard = $row['bottom_hazard'];
$bottom_precautions = $row['bottom_precautions'];
$bottom_remark = $row['bottom_remark'];
$sign_permit_req_by = $row['sign_permit_req_by'];
$sop_made_approved = $row['sop_made_approved'];
$test_pass_certificate = $row['test_pass_certificate'];
$medically_fit = $row['medically_fit'];
$tools_condition_Certificate = $row['tools_condition_Certificate'];
$trained_on_sop = $row['trained_on_sop'];
$work_person_name = $row['work_person_name'];
$emp_no = $row['emp_no'];
$in_time = $row['in_time'];
$out_time = $row['out_time'];
$tool_box_talk = $row['tool_box_talk'];
$renewal1 = $row['renewal1'];
$renewal2 = $row['renewal2'];
$permit_receiver_sign = $row['permit_receiver_sign'];
$location_id = $row['location_id'];

$i = 1;

/*
$sql = "SELECT * FROM `jha_required` WHERE jha_type_id = '$ID' AND location_id= '$location_id' ORDER BY step DESC";
// Execute query
$db->sql($sql);
// store result 
$res3 = $db->getResult();
foreach ($res3 as $row3)

    $req_ppe = $row3['req_ppe'];
$req_tools = $row3['req_tools'];
$req_training = $row3['req_training'];
$emp_id = $row3['emp_name'];

*/

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content" style="background-color: white;">
    <!--<div class="row" style="margin-right: 80px;margin-left: 80px;">-->
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available; height: 250px;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div><br /><br />

                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-6" style="text-align-last: left;">
                                    <p>Doc No : <?php echo $doc_no; ?></p>
                                </div>
                                <div class="col-xs-6" style="text-align-last: right;">
                                    <p>SI No : <?php echo $rev; ?></p>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;">
                                    <p>Rev : <?php echo $effective_date; ?></p>
                                </div>
                                <div class="col-xs-6" style="text-align-last: right;">
                                    <p>Date : <?php echo $si_no; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Effective Date : <?php echo $date; ?></p>
                                </div>

                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <p><b>Reference Safty Standard 1. TSL/SS/GEN-25 (Work Permit System) & 2. TSL/SS/GEN-25 (Positive Isolation)<br />
                                            PERMIT TO WORK FOR INDIVIDUAL AGENCY</b> - To Be Filled in Triplicated. Original (Blue), Duplicate (White) & Triplicate (Yellow)</p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;border: 1px solid black;">
                                    <p><b>Permit To Work Format is Valid For Only Job in The Specific Area </b><br />
                                        For Routine / Non Routine Jobs, MSD Shut Down Jobs & Break Down Jobs (< 48 hrs Jobs) Permit Will Be Renewed After Every Shift.</p>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;">
                                    <p>Department : <?php echo $department; ?></p>
                                </div>
                                <div class="col-xs-6" style="text-align-last: right;">
                                    <p>Section : <?php echo $section; ?></p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left;">
                                    <p>Org Permit Valid </p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;">
                                    <p>From (Time & Date) : <?php echo $org_permit_valid_from; ?></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;">
                                    <p>To (Time & Date) : <?php echo $org_permit_valid_to; ?></p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left;">
                                    <p>1 St Renewal Valid</p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;">
                                    <p>From (Time & Date) : <?php echo $renewal_valid_from1; ?></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;">
                                    <p>To (Time & Date) : <?php echo $renewal_valid_to1; ?></p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left;">
                                    <p>2 Nd Renewal Valid</p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;">
                                    <p>From (Time & Date) : <?php echo $renewal_valid_from2; ?></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;">
                                    <p>To (Time & Date) : <?php echo $renewal_valid_to2; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <ol>
                                        <li>Name / Description Of Job : <?php echo $job_description; ?></li>
                                        <li>Name of Working Agency & Work Order No. : <?php echo $working_agency_name; ?></li>
                                        <li>Work Permitted Only For The Area / Equipment (Name/No.) : (Attach Extra Sheet if Required For Equipment)<br /><br />
                                            <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                                <p><?php echo $work_permit_area; ?></p>
                                            </div><br /><br />
                                        </li><br /><br />
                                        <li><b>Type Of Job (To Be Filled By Working Agency And Verified by Executing Agency) (Use Yes Or No As Appropriate):</b><br /><br />
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>a) Weilding / Gas Cutting </b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $welding_gas_cutting; ?></b></p>
                                            </div>
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>b) Rigging / Fitting</b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $rigging_fitting; ?></b></p>
                                            </div>
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>c) Working At Height</b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $work_at_height; ?></b></p>
                                            </div>
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>d) Hydraulic / Pneumatic</b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $Hydraulic_Pneumatic; ?></b></p>
                                            </div>
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>e) Painting / Cleaning</b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $painting_cleaning; ?></b></p>
                                            </div>
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>f) Confined Space</b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $confined_space; ?></b></p>
                                            </div>
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>g) Gas</b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $gas; ?></b></p>
                                            </div>
                                            <div class="col-xs-3" style="text-align-last: left;">
                                                <p><b>h) Electrical</b></p>
                                            </div>
                                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                                <p><b><?php echo $electrical; ?></b></p>
                                            </div>
                                            <div class="col-xs-4" style="text-align-last: left;">
                                                <p><b>Others (Specify) : <?php echo $other; ?></b></p>
                                            </div>
                                            <div class="col-xs-12" style="text-align-last: left;">
                                                <p>NOTE : For Instruction / Checklist on Above Job See Overleaf. Working Agency Must Verify All Requirments by Himself Before Applying Work Permit And Executing Agency Must Verify Before Issue of Work Permit.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <p><b>NECESSARY PRECAUTION / CONTROLS TAKEN FOR ABOVE JOB</b>(To Be Filled By Permit Issuer)(Use Yes or No Appropriate)</p>
                                            <ol type="a">
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Gas Hazards Permit Taken (TSL/SED/GPA/F-14), Permit No : <?php echo $gas_hazard_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $gas_hazard_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Confined Space Permit Taken (TSL/SED/CSE/F-12), Permit No : <?php echo $confined_space_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $confined_space_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Electrical Power Cutting For Category I Job Done (TSL/SED/EEI/F-07-E1), Permit No : <?php echo $electrical_power_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $electrical_power_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Grounding & Discharging For Category II Job Done (TSL/SED/EEI/F-07-E3), Permit No : <?php echo $grounding_discharging_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $grounding_discharging_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Hydraulic / Pneumatic Energy Isolation Permit Taken (TSL/SED/F-07-M1), Permit No : <?php echo $Hydraulic_Pneumatic_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $Hydraulic_Pneumatic_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Hot Work Permit Taken (TSL/SED/HW/F-27), Permit No : <?php echo $hot_work_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $hot_work_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Mechanised Excavation / Grading Clearance (TSL/SED/EW/F-13), Permit No : <?php echo $mechanized_grading_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $mechanized_grading_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <div class="col-xs-11" style="text-align-last: left;">
                                                        <p>Positive Isolation Done(Energy Isolated/released)(Positive Isolation Group Lock No & Personal Lock No)(TSL/SED/GPA/F-14), Permit No : <?php echo $positive_isolation_permit_taken; ?></p>
                                                    </div>
                                                    <div class="col-xs-1" style="text-align-last: center;border: 1px solid black;">
                                                        <p><?php echo $positive_isolation_permit_no; ?></p>
                                                    </div>
                                                </li><br />
                                                <li>
                                                    <p>
                                                        PTW For Working At Height (TSL/SED/RGW/F-06-R1)
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>
                                                        PTW For Radiography (TSL/SED/RGW/F15)
                                                    </p>
                                                </li><br />
                                            </ol>
                                        </li>
                                        <li>
                                            <div class="col-xs-5" style="text-align-last: left;">
                                                <p><b>Special Instruction, If Any (Owner Agency) : </b></p>
                                            </div>
                                            <div class="col-xs-7" style="text-align-last: center;border: 1px solid black;">
                                                <p><?php echo $spl_instruction; ?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col-xs-12" style="text-align-last: left;">
                                                <p>I Understand The Hazard Involved & Have Taken All Necessary Precautions For The Job</p>
                                            </div>
                                            <div class="col-xs-12" style="text-align-last: center;">
                                                <div class="box-body table-responsive" style="padding: 0px;">
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <th style="border: 1px solid black;"> </th>
                                                            <th colspan="4" style="border: 1px solid black;">Permit Original</th>
                                                            <th colspan="4" style="border: 1px solid black;">1st Renewal</th>
                                                            <th colspan="4" style="border: 1px solid black;">2nd Renewal</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="border: 1px solid black;"></th>
                                                            <th rowspan="2" style="border: 1px solid black;">Requested By(Exec. Agency)</th>
                                                            <th rowspan="2" style="border: 1px solid black;">Issued By (Owner Agency)</th>
                                                            <th colspan="2" style="border: 1px solid black;">Taken By (Working Agency)</th>
                                                            <th rowspan="2" style="border: 1px solid black;">Requested By(Exec. Agency)</th>
                                                            <th rowspan="2" style="border: 1px solid black;">Issued By (Owner Agency)</th>
                                                            <th colspan="2" style="border: 1px solid black;">Taken By (Working Agency)</th>
                                                            <th rowspan="2" style="border: 1px solid black;">Requested By(Exec. Agency)</th>
                                                            <th rowspan="2" style="border: 1px solid black;">Issued By (Owner Agency)</th>
                                                            <th colspan="2" style="border: 1px solid black;">Taken By (Working Agency)</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="border: 1px solid black;"> </th>
                                                            <th style="border: 1px solid black;"> </th>
                                                            <th style="border: 1px solid black;">For Central Agency</th>
                                                            <th style="border: 1px solid black;"> </th>
                                                            <th style="border: 1px solid black;">For Central Agency</th>
                                                            <th style="border: 1px solid black;"> </th>
                                                            <th style="border: 1px solid black;">For Central Agency</th>
                                                        </tr>
                                                        <tr>
                                                            <!--<td style="border: 1px solid black;"><?php echo $i;
                                                                                                        $i++; ?></td></td>-->
                                                            <td style="border: 1px solid black;">Name / P.N</td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_name_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_name_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_name_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_name_taken_by_central; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_name_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_name_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_name_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_name_taken_by_central; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_name_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_name_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_name_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_name_taken_by_central; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <!--<td style="border: 1px solid black;"><?php echo $i;
                                                                                                        $i++; ?></td></td>-->
                                                            <td style="border: 1px solid black;">Designation / Dept.</td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_designation_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_designation_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_designation_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_designation_taken_by_central; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_designation_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_designation_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_designation_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_designation_taken_by_central; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_designation_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_designation_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_designation_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_designation_taken_by_central; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <!--<td style="border: 1px solid black;"><?php echo $i;
                                                                                                        $i++; ?></td></td>-->
                                                            <td style="border: 1px solid black;">Sign / Date & Time</td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_signature_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_signature_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_signature_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $permit_org_signature_taken_by_central; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_signature_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_signature_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_signature_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal1_signature_taken_by_central; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_signature_req_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_signature_issued_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_signature_taken_by_working; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $renewal2_signature_taken_by_central; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </li><br />
                                        <li>
                                            <div class="col-xs-12" style="text-align-last: left;">
                                                <p><b>Return Of Permit : All Men / Material Removed After Job Completion. Now Area is Safe For Operation</b></p>
                                            </div>
                                            <div class="col-xs-12" style="text-align-last: center;">
                                                <div class="box-body table-responsive" style="padding: 0px;">
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <th style="border: 1px solid black;"> </th>
                                                            <th colspan="2" style="border: 1px solid black;">Return By (Working Agency or Taken By)</th>
                                                            <th style="border: 1px solid black;">Received By (Executing Agency or Requester)</th>
                                                            <th style="border: 1px solid black;">Received By (Owner Agency or Issuer)</th>
                                                        </tr>

                                                        <tr>
                                                            <!--<td style="border: 1px solid black;"><?php echo $i;
                                                                                                        $i++; ?></td></td>-->
                                                            <td style="border: 1px solid black;">Name / P.N</td>
                                                            <td style="border: 1px solid black;"><?php echo $name_return_by_working_agency; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $name_return_by_taken_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $name_revived_by_executive; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $name_revived_by_owner; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <!--<td style="border: 1px solid black;"><?php echo $i;
                                                                                                        $i++; ?></td></td>-->
                                                            <td style="border: 1px solid black;">Designation / Dept.</td>
                                                            <td style="border: 1px solid black;"><?php echo $designation_return_by_working_agency; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $designation_return_by_taken_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $designation_revived_by_executive; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $designation_revived_by_owner; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <!--<td style="border: 1px solid black;"><?php echo $i;
                                                                                                        $i++; ?></td></td>-->
                                                            <td style="border: 1px solid black;">Sign / Date & Time</td>
                                                            <td style="border: 1px solid black;"><?php echo $signature_return_by_working_agency; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $signature_return_by_taken_by; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $signature_revived_by_executive; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $signature_revived_by_owner; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <ol type="a">
                                                <li>Blue Color Copy To Be Retain By The Working Agency</li>
                                                <li>White Color Copy To Be Retain By The Owner Agency</li>
                                                <li>Yellow Color Copy To Be Retain By The Executing Agency</li>
                                            </ol>
                                        </li>
                                    </ol>
                                </div>

                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div><br />

                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <ol>
                                        <li>
                                            Permit To be Signed By Shift Incharge / Person Incharge Of The Job / Supervisor / Officer / Engg. / Any Other Person Authorised by Head / Chief of the Department.
                                        </li>
                                        <li>
                                            If The Job is Being Done Under Central Working Agency like Field Maintainance / Engg. Services, etc., Permit To Work Will Be Requested By The Department Under Whom The Job Will Be Carried Out.
                                        </li>
                                        <li>
                                            Contractor Should Provide One Site Safty Supervisor for 50 Contract Employee.
                                        </li>
                                        <li>
                                            Proximity / Six Direction Hazards Should Accessed & Filled By Executing Agency Before Starting Of Job & Communicate To Working Agency.
                                        </li>
                                    </ol>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p><b>SIX DIRECTIONAL HAZARD FORM (To Be Filled By Executing Agency)</b></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <div class="box-body table-responsive" style="padding: 0px;">
                                        <table class="table table-hover">
                                            <tr>
                                                <th style="border: 1px solid black;">Direction</th>
                                                <th style="border: 1px solid black;">Hazards Observed</th>
                                                <th style="border: 1px solid black;">Precautions / Measures to be Taken</th>
                                                <th style="border: 1px solid black;">Remarks</th>
                                            </tr>

                                            <tr>
                                                <td style="border: 1px solid black;">North</td>
                                                <td style="border: 1px solid black;"><?php echo $north_hazard; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $north_precautions; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $south_remark; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">South</td>
                                                <td style="border: 1px solid black;"><?php echo $south_hazard; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $south_precautions; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $north_remark; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">East</td>
                                                <td style="border: 1px solid black;"><?php echo $east_hazard; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $east_precautions; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $east_remark; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">West</td>
                                                <td style="border: 1px solid black;"><?php echo $west_hazard; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $west_precautions; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $west_remark; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">Top</td>
                                                <td style="border: 1px solid black;"><?php echo $top_hazard; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $top_precautions; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $top_remark; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">Bottom</td>
                                                <td style="border: 1px solid black;"><?php echo $bottom_hazard; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $bottom_precautions; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $bottom_remark; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xs-12" style="text-align-last: right;">
                                    <p><?php echo '<img src="' . DOMAIN_URL . 'upload/signature/' . $row['sign_permit_req_by'] . '" height="50">'; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: right;">
                                    <p><b>Sign. Of Permit Requested By</b></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <div class="box-body table-responsive" style="padding: 0px;">
                                        <table class="table table-hover">
                                            <tr>
                                                <th style="border: 1px solid black;">Check Points</th>
                                                <th style="border: 1px solid black;">(Checked by Working Agency)(Use Yes or No As Appropriate & NA For not Applicable)</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align-last: left;">1. Standard Operating Procedure Has Been Made & Approved.</td>
                                                <td style="border: 1px solid black;"><?php echo $sop_made_approved; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align-last: left;">2. Weilder / Gas Cutter / Rigger Must Have Trade Test Pass Certificate Fro ITI Or Any Certified Institute.</td>
                                                <td style="border: 1px solid black;"><?php echo $test_pass_certificate; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align-last: left;">3. All Persons Are Certified & Medically Fit.</td>
                                                <td style="border: 1px solid black;"><?php echo $medically_fit; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align-last: left;">All Lifting Tools & Tackles Are in Good ConditionWith Valid Test Certificate</td>
                                                <td style="border: 1px solid black;"><?php echo $tools_condition_Certificate; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;text-align-last: left;">All Persons Are Trained On Standard Operating Procedure (SOP)</td>
                                                <td style="border: 1px solid black;"><?php echo $trained_on_sop; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p><b>Details Of Working Persons</b></p>
                                </div>
                                <div class="col-xs-12" style="padding: 0px;">
                                    <div class="box">

                                        <!-- /.box-header -->
                                        <div class="box-body table-responsive" style="padding: 0px;">
                                            <table class="table table-hover">
                                                
                                                <tr>
                                                    <th style="border: 1px solid black;">S No.</th>
                                                    <th style="border: 1px solid black;">Name</th>
                                                    <th style="border: 1px solid black;">EMP No. / Gate Pass No.</th>
                                                    <th style="border: 1px solid black;">Incoming Time</th>
                                                    <th style="border: 1px solid black;">Outgoing Time</th>
                                                    <th style="border: 1px solid black;">Tool Box Talk (Y/N)</th>
                                                    <th style="border: 1px solid black;">1st Renewal(Yes/No)</th>
                                                    <th style="border: 1px solid black;">2nd Renewal(Yes/No)</th>
                                                </tr>
                                                <?php
                                                foreach ($res as $row) {
                                                ?>
                                                    <tr>
                                                        <!--<td style="border: 1px solid black;"><?php echo $row['id']; ?></td>-->
                                                        <td style="border: 1px solid black;"><?php echo $i;
                                                                                                $i++; ?></td>
                                                        <td style="border: 1px solid black;"><?php echo $row['work_person_name']; ?></td>
                                                        <td style="border: 1px solid black;"><?php echo $row['emp_no']; ?></td>
                                                        <td style="border: 1px solid black;"><?php echo $row['in_time']; ?></td>
                                                        <td style="border: 1px solid black;"><?php echo $row['out_time']; ?></td>
                                                        <td style="border: 1px solid black;"><?php echo $row['tool_box_talk']; ?></td>
                                                        <td style="border: 1px solid black;"><?php echo $row['renewal1']; ?></td>
                                                        <td style="border: 1px solid black;"><?php echo $row['renewal2']; ?></td>
                                                    </tr>
                                                <?php $row['id']++;
                                                } ?>

                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box -->
                                </div><br /><br />
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p><?php echo '<img src="' . DOMAIN_URL . 'upload/signature/' . $row['permit_receiver_sign'] . '" height="50">'; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p><b>Sign Of Permit Receiver(Working Agency)</b></p>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br />

                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div>
    </div>
    <div class="row no-print">
        <div class="col-xs-12">
            <form style="text-align: center;"><button type='button' value='Print this page' onclick='printpage();' class="btn btn-success"><i class="fa fa-print"></i> Print</button>
            </form>
            <script>
                function printpage() {
                    var is_chrome = function() {
                        return Boolean(window.chrome);
                    }
                    if (is_chrome) {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 100000);
                        //give them 10 seconds to print, then close
                    } else {
                        window.print();
                        window.close();
                    }
                }
            </script>
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script>
    //var can_submit = false;
    $('form').on('submit', function(e) {

        //var confirmation = confirm("Do you want to continue");

        //if (this.host !== window.location.host) {
        //if (confirmation) {
        if (window.confirm('Really Want To Submit?')) {
            window.location.href = "home.php";
            console.log("Clicked OK - submitting now ...");
            can_submit = true;
            window.location.href = "home.php";
            //console.location.href = "home.php";
            //console.location("home.php");
            echo(window.location = "home.php");

        } else {
            console.log("Clicked Cancel");
            //can_submit = false;
            return false;
        }
        //}
    });
</script>