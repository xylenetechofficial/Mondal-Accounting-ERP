<?php
include_once('includes/crud.php');
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$ID = $_GET['id'];
//print_r($ID);

$sql = "SELECT * FROM `emergency_plans` WHERE id = '$ID' ORDER BY id DESC limit 1";
//$sql = "SELECT * FROM `coils` WHERE id = '1' ";
$db->sql($sql);
$res = $db->getResult();
foreach ($res as $row)
    $data = $row;

//print_r($row);

$emergency_date_prepared = $row['emergency_date_prepared'];
$manager_at_site = $row['manager_at_site'];
$manager_as = $row['manager_as'];
$manager_name = $row['manager_name'];
$manager_mobile = $row['manager_mobile'];
$coordinator_name = $row['coordinator_name'];
$coordinator_mobile = $row['coordinator_mobile'];
$area_monitor = $row['area_monitor'];
$area_monitor_name = $row['area_monitor_name'];
$area_monitor_mobile = $row['area_monitor_mobile'];
$floor_monitor = $row['floor_monitor'];
$floor_monitor_name = $row['floor_monitor_name'];
$floor_monitor_mobile = $row['floor_monitor_mobile'];
$assistants_to_phy_challanged_name1 = $row['assistants_to_phy_challanged_name1'];
$assistants_to_phy_challanged_mobile1 = $row['assistants_to_phy_challanged_mobile1'];
$assistants_to_phy_challanged_name2 = $row['assistants_to_phy_challanged_name2'];
$assistants_to_phy_challanged_mobile2 = $row['assistants_to_phy_challanged_mobile2'];
$emergency_date = $row['emergency_date'];
$emergency_fire_number = $row['emergency_fire_number'];
$emergency_ambulance_number = $row['emergency_ambulance_number'];
$emergency_police_number = $row['emergency_police_number'];
$emergency_security_number = $row['emergency_security_number'];
$emergency_factory_manager_number = $row['emergency_factory_manager_number'];
$utility_emergency_number_electric = $row['utility_emergency_number_electric'];
$utility_emergency_number_water = $row['utility_emergency_number_water'];
$utility_emergency_number_gas = $row['utility_emergency_number_gas'];
$utility_emergency_date = $row['utility_emergency_date'];
$other_type_emergency = $row['other_type_emergency'];
$med_emergency_call_paramedic = $row['med_emergency_call_paramedic'];
$med_emergency_call_ambulance = $row['med_emergency_call_ambulance'];
$med_emergency_call_fire = $row['med_emergency_call_fire'];
$med_emergency_call_other = $row['med_emergency_call_other'];
$med_emergency_name1 = $row['med_emergency_name1'];
$med_emergency_phone1 = $row['med_emergency_phone1'];
$med_emergency_name2 = $row['med_emergency_name2'];
$med_emergency_phone2 = $row['med_emergency_phone2'];
$med_emergency_date = $row['med_emergency_date'];
$fire_emergency_call = $row['fire_emergency_call'];
$fire_emergency_call_voice = $row['fire_emergency_call_voice'];
$fire_emergency_call_radio = $row['fire_emergency_call_radio'];
$fire_emergency_call_paging = $row['fire_emergency_call_paging'];
$fire_emergency_call_other = $row['fire_emergency_call_other'];
$fire_emergency_date = $row['fire_emergency_date'];
$chem_spill_equipment = $row['chem_spill_equipment'];
$chem_spill_ppe = $row['chem_spill_ppe'];
$chem_spill_msds = $row['chem_spill_msds'];
$chem_spill_cleanup_name = $row['chem_spill_cleanup_name'];
$chem_spill_cleanup_mobile = $row['chem_spill_cleanup_mobile'];
$chem_spill_date = $row['chem_spill_date'];
$struct_climb_descend_emergency_type_tower = $row['struct_climb_descend_emergency_type_tower'];
$struct_climb_descend_emergency_type_tower_location = $row['struct_climb_descend_emergency_type_tower_location'];
$struct_climb_descend_emergency_type_tower_org = $row['struct_climb_descend_emergency_type_tower_org'];
$struct_climb_descend_emergency_type_river = $row['struct_climb_descend_emergency_type_river'];
$struct_climb_descend_emergency_type_river_location = $row['struct_climb_descend_emergency_type_river_location'];
$struct_climb_descend_emergency_type_river_org = $row['struct_climb_descend_emergency_type_river_org'];
$struct_climb_descend_emergency_type_other = $row['struct_climb_descend_emergency_type_other'];
$struct_climb_descend_emergency_type_other_location = $row['struct_climb_descend_emergency_type_other_location'];
$struct_climb_descend_emergency_type_other_org = $row['struct_climb_descend_emergency_type_other_org'];
$critical_operation_area1 = $row['critical_operation_area1'];
$critical_operation_name1 = $row['critical_operation_name1'];
$critical_operation_job1 = $row['critical_operation_job1'];
$critical_operation_assignment1 = $row['critical_operation_assignment1'];
$critical_operation_area2 = $row['critical_operation_area2'];
$critical_operation_name2 = $row['critical_operation_name2'];
$critical_operation_job2 = $row['critical_operation_job2'];
$critical_operation_assignment2 = $row['critical_operation_assignment2'];
$critical_operation_area3 = $row['critical_operation_area3'];
$critical_operation_name3 = $row['critical_operation_name3'];
$critical_operation_job3 = $row['critical_operation_job3'];
$critical_operation_assignment3 = $row['critical_operation_assignment3'];
$critical_operation_offices = $row['critical_operation_offices'];
$critical_operation_manuals = $row['critical_operation_manuals'];
$critical_operation_contact_to_name1 = $row['critical_operation_contact_to_name1'];
$critical_operation_contact_to_location1 = $row['critical_operation_contact_to_location1'];
$critical_operation_contact_to_mobile1 = $row['critical_operation_contact_to_mobile1'];
$critical_operation_contact_to_name2 = $row['critical_operation_contact_to_name2'];
$critical_operation_contact_to_location2 = $row['critical_operation_contact_to_location2'];
$critical_operation_contact_to_mobile2 = $row['critical_operation_contact_to_mobile2'];
$critical_operation_contact_to_name3 = $row['critical_operation_contact_to_name3'];
$critical_operation_contact_to_location3 = $row['critical_operation_contact_to_location3'];
$critical_operation_contact_to_mobile3 = $row['critical_operation_contact_to_mobile3'];
$emergency_training_facility = $row['emergency_training_facility'];
$emergency_training_person_name = $row['emergency_training_person_name'];
$emergency_training_person_responsibility = $row['emergency_training_person_responsibility'];
$location = $row['location'];

//$date = date("d-m-Y");
/*
$sql2 = "SELECT * FROM `final_processed_coils` WHERE id = '$ID' ORDER BY id ASC limit 1";
//$sql = "SELECT * FROM `coils` WHERE id = '1' ";
$db->sql($sql2);
$res2 = $db->getResult();
//print_r($res2);
foreach ($res2 as $row2)
    $data2 = $row2;
*/
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>

<section class="content" style="background-color: white;">
    <div class="row">
        <div class="col-md-12" style="text-align-last: center;">
            <!-- general form elements -->
            <div class="box box-primary" style="font-size: large;">
                <!-- form start -->
                <div class="box-body">
                    <!--<div class="row">
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div>-->

                    <div class="row" style="margin-top: 450px;margin-bottom: 500px;">

                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;">
                            <h1><label><b> EMERGENCY PREPAREDNESS PLAN</b></label></h1>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;">
                            <h1><label><b>MANDAL ENGINEERING</b></label></h1>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-top: 100px;text-align-last: center;">
                            <h2><label><b> EMERGENCY PREPAREDNESS PLAN</b></label></h2>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;margin-bottom: 60px;">
                            <h2><label><b> For</b></label></h2>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;place-content: center;display: inline-flex;margin-bottom: 50px;">
                            <p>
                            <h3><b>Company Name : </b></h3>
                            <h2><b><u> MANDAL ENGINEERING</b></u></h2>
                            </p>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;place-content: center;margin-bottom: 50px;">
                            <p>
                            <h2><b>Company Address : </b></h2>
                            <h3><b> Off: - plot no.37,panchashil industriai estate,kharsundi,tal; Khalapur Khopoli raigad, maharastra,410201</b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;margin-bottom: 100px;">
                            <h2> DATE PREPARED : <?php echo $emergency_date_prepared; ?></h2>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 300px;">

                        <div class="col-xs-12" style="padding-top: 100px;text-align-last: center;margin-bottom: 20px;">
                            <h2><label><b> EMERGENCY PERSONNEL NAMES AND PHONE NUMBERS</b></label></h2>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;margin-bottom: 10px;">
                            <h3>DESIGNATED RESPONSIBLE OFFICIAL (Highest Ranking Manager at <?php echo $manager_at_site; ?> Site, such as <?php echo $manager_as; ?> ): </h3>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 50px;text-align-last: left;">
                            <p>
                            <h3>Name : <b><?php echo $manager_name; ?></b> Phone : <b>(<?php echo $manager_mobile; ?>)</b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;margin-bottom: 10px;">
                            <h3>EMERGENCY COORDINATOR:</h3>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 10px;text-align-last: left;">
                            <p>
                            <h3>Name : <b><?php echo $coordinator_name; ?></b> Phone : <b>(<?php echo $coordinator_mobile; ?>)</b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;margin-bottom: 10px;">
                            <h3>AREA/FLOOR MONITORS (If applicable):</h3>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 10px;text-align-last: left;">
                            <p>
                            <h3>Area/Floor : <b><?php echo $area_monitor; ?></b> Name : <b><?php echo $area_monitor_name; ?></b> Phone : <b>(<?php echo $area_monitor_mobile; ?>)</b></h3>
                            </p>
                            <p>
                            <h3>Area/Floor : <b><?php echo $floor_monitor; ?></b> Name : <b><?php echo $floor_monitor_name; ?></b> Phone : <b>(<?php echo $floor_monitor_mobile; ?>)</b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;margin-bottom: 10px;">
                            <h3>ASSISTANTS TO PHYSICALLY CHALLENGED (If applicable):</h3>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 100px;text-align-last: left;">
                            <p>
                            <h3>Name : <b><?php echo $assistants_to_phy_challanged_name1; ?></b> Phone : <b>(<?php echo $assistants_to_phy_challanged_mobile1; ?>)</b></h3>
                            </p>
                            <p>
                            <h3>Name : <b><?php echo $assistants_to_phy_challanged_name2; ?></b> Phone : <b>(<?php echo $assistants_to_phy_challanged_mobile2; ?>)</b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;margin-bottom: 50px;">
                            <h2> DATE : <?php echo $emergency_date_prepared; ?></h2>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-top: 100px;padding-bottom: 50px;text-align-last: center;">
                            <h2><label><b> EVACUATION ROUTES</b></label></h2>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li>
                                Evacuation route maps have been posted in each work area. The following information is marked on evacuation maps:
                                <ol style="list-style-type: number;text-align-last: left;padding-bottom: 50px;">
                                    <li>Emergency exits</li>
                                    <li>Primary and secondary evacuation routes</li>
                                    <li>Locations of fire extinguishers</li>
                                    <li>Fire alarm pull stations' location</li>
                                    <li>Assembly points</li>
                                </ol>
                            </li>
                            <li>
                                You shall be placed in the grade of “and your salary and other benefits shall be as applicable to the other staff in the said grade. Details of your salary and the benefits are set out herein given bellow.
                            </li>
                        </ul>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-top: 100px;padding-bottom: 50px;text-align-last: center;">
                            <h2><label><b> EVACUATION ROUTES</b></label></h2>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 20px;text-align-last: left;">
                            <p>
                            <h3>FIRE DEPARTMENT : <b><u><?php echo $emergency_fire_number; ?></u></b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 20px;text-align-last: left;">
                            <p>
                            <h3>AMBULANCE : <b><u><?php echo $emergency_ambulance_number; ?></u></b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 20px;text-align-last: left;">
                            <p>
                            <h3>POLICE : <b><u><?php echo $emergency_police_number; ?></u></b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 20px;text-align-last: left;">
                            <p>
                            <h3>SECURITY (If applicable) : <b><u><?php echo $emergency_security_number; ?></u></b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 70px;text-align-last: left;">
                            <p>
                            <h3>FACTORY MANAGER (If applicable) : <b><u><?php echo $emergency_factory_manager_number; ?></u></b></h3>
                            </p>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-top: 100px;padding-bottom: 50px;text-align-last: center;">
                            <h2><label><b> UTILITY COMPANY EMERGENCY CONTACTS</b></label></h2>
                            <h3> UTILITY COMPANY EMERGENCY CONTACTS</h3>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 50px;text-align-last: left;">
                            <p>
                            <h3>ELECTRIC : <b><u><?php echo $utility_emergency_number_electric; ?></u></b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 50px;text-align-last: left;">
                            <p>
                            <h3>WATER : <b><u><?php echo $utility_emergency_number_water; ?></u></b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="margin-bottom: 70px;text-align-last: left;">
                            <p>
                            <h3>GAS (if applicable) : <b><u><?php echo $utility_emergency_number_gas; ?></u></b></h3>
                            </p>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;margin-bottom: 70px;">
                            <h2> DATE PREPARED : <?php echo $utility_emergency_date; ?></h2>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-top: 100px;padding-bottom: 50px;text-align-last: center;">
                            <h2><label><b> EMERGENCY REPORTING AND EVACUATION PROCEDURES</b></label></h2>
                            <h3> UTILITY COMPANY EMERGENCY CONTACTS</h3>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li style="padding-bottom: 20px;">
                                MEDICAL
                            </li>
                            <li style="padding-bottom: 30px;">
                                FIRE
                            </li>
                            <li style="padding-bottom: 30px;">
                                SEVERE WEATHER
                            </li>
                            <li style="padding-bottom: 30px;">
                                CHEMICAL SPILL
                            </li>
                            <li style="padding-bottom: 30px;">
                                STRUCTURE CLIMBING/DESCENDING
                            </li>
                            <li style="padding-bottom: 30px;">
                                EXTENDED POWER LOSS
                            </li>
                            <li style="padding-bottom: 30px;">
                                OTHER (specify) <?php echo $other_type_emergency; ?>
                                (e.g., terrorist attack/hostage taking)
                            </li>
                        </ul>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-top: 100px;padding-bottom: 20px;text-align-last: center;">
                            <h2><label><b> MEDICAL EMERGENCY</b></label></h2>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 30px;">
                            <li>
                                Call medical emergency phone number (check applicable):
                                <ol style="list-style-type: square;text-align-last: left;padding-bottom: 20px;">
                                    <li>
                                        <?php
                                        if (($med_emergency_call_paramedic) == "yes") {
                                            echo "Paramedics";
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (($med_emergency_call_ambulance) == "yes") {
                                            echo "Ambulance";
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (($med_emergency_call_fire) == "yes") {
                                            echo "Fire Department";
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (!empty($med_emergency_call_other)) {
                                            echo "$med_emergency_call_other";
                                        }
                                        ?>
                                    </li>
                                </ol>
                            </li>
                            <ul style="list-style-type: none;">
                                <li>Provide the following information:</li>
                                <ol style="list-style-type: lower-alpha;text-align-last: left;padding-bottom: 20px;">
                                    <li> Nature of medical emergency,</li>
                                    <li> Location of the emergency (address, building, room number), and</li>
                                    <li> Your name and phone number from which you are calling.</li>
                                </ol>
                            </ul>
                            <li>
                                Do not move victim unless absolutely necessary.
                            </li>
                            <li>
                                Call the following personnel trained in CPR and First Aid to provide the required assistance prior to the arrival of the professional medical help:
                            </li>
                            <div class="col-xs-12" style="margin-bottom: 30px;text-align-last: left;">
                                <p>
                                <h3>Name : <b><?php echo $med_emergency_name1; ?></b> Phone : <b>(<?php echo $med_emergency_phone1; ?>)</b></h3>
                                </p>
                                <p>
                                <h3>Name : <b><?php echo $med_emergency_name2; ?></b> Phone : <b>(<?php echo $med_emergency_phone2; ?>)</b></h3>
                                </p>
                            </div>
                            <li>
                                If personnel trained in First Aid are not available, as a minimum, attempt to
                                provide the following assistance:
                                <ol style="list-style-type: number;text-align-last: left;padding-bottom: 20px;">
                                    <li>Stop the bleeding with firm pressure on the wounds (note: avoid
                                        contact with blood or other bodily fluids).
                                    </li>
                                    <li>Clear the air passages using the Heimlich Maneuver in case of
                                        choking.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                In case of rendering assistance to personnel exposed to hazardous materials,
                                consult the Material Safety Data Sheet (MSDS) and wear the appropriate personal
                                protective equipment. Attempt first aid ONLY if trained and qualified.

                            </li>
                        </ul>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;margin-bottom: 20px;">
                            <h2> DATE PREPARED : <?php echo $med_emergency_date; ?></h2>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-top: 100px;padding-bottom: 20px;text-align-last: center;">
                            <h2><label><b> FIRE EMERGENCY</b></label></h2>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;margin-bottom: 20px;">
                            <h4> When fire is discovered:</h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 30px;">
                            <li>
                                Activate the nearest fire alarm (if installed)
                            </li>
                            <li>
                                Notify the local Fire Department by calling <?php echo $fire_emergency_call; ?>
                            </li>
                            <li>
                                Call medical emergency phone number (check applicable):
                                <ol style="list-style-type: square;text-align-last: left;padding-bottom: 20px;">
                                    <li>
                                        <?php
                                        if (($fire_emergency_call_voice) == "yes") {
                                            echo "Voice Communication";
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (($fire_emergency_call_radio) == "yes") {
                                            echo "Radio";
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (($fire_emergency_call_paging) == "yes") {
                                            echo "Phone Paging";
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (!empty($fire_emergency_call_other)) {
                                            echo "$fire_emergency_call";
                                        }
                                        ?>
                                    </li>
                                </ol>
                            </li>
                        </ul>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;margin-bottom: 20px;">
                            <h4> Fight the fire ONLY if:</h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li style="padding-bottom: 20px;">
                                The Fire Department has been notified.
                            </li>
                            <li style="padding-bottom: 30px;">
                                The fire is small and is not spreading to other areas.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Escaping the area is possible by backing up to the nearest exit.
                            </li>
                            <li style="padding-bottom: 30px;">
                                The fire extinguisher is in working condition and personnel are trained to use it.
                            </li>
                        </ul>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;margin-bottom: 20px;">
                            <h4> Upon being notified about the fire emergency, occupants must:</h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li style="padding-bottom: 20px;">
                                Leave the building using the designated escape routes.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Assemble in the designated area (specify location):
                            </li>
                            <li style="padding-bottom: 30px;">
                                Remain outside until the competent authority (Designated Official or
                                designee) announces that it is safe to reenter.
                            </li>
                        </ul>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;margin-bottom: 20px;">
                            <h4> Designated Official, Emergency Coordinator or supervisors must (underline one):</h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li style="padding-bottom: 20px;">
                                Disconnect utilities and equipment unless doing so jeopardizeshis/her safety.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Coordinate an orderly evacuation of personnel.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Perform an accurate head count of personnel reported to the designated area.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Determine a rescue method to locate missing personnel.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Provide the Fire Department personnel with the necessaryinformation about the facility.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Perform assessment and coordinate weather forecast office emergency closing procedures.
                            </li>
                        </ul>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;margin-bottom: 20px;">
                            <h4> Area/Floor Monitors must:</h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li style="padding-bottom: 20px;">
                                Ensure that all employees have evacuated the area/floor.
                            </li>
                            <li style="padding-bottom: 30px;">
                                Report any problems to the Emergency Coordinator at the assembly area.
                            </li>
                        </ul>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;margin-bottom: 20px;">
                            <h4> Assistants to Physically Challenged should:</h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li style="padding-bottom: 20px;">
                                Assist all physically challenged employees in emergency evacuation.
                            </li>
                        </ul>

                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;margin-bottom: 20px;">
                            <h2> DATE PREPARED : <?php echo $fire_emergency_date; ?></h2>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;margin-bottom: 450px;">

                        <div class="col-xs-12" style="padding-bottom: 20px;text-align-last: center;">
                            <h2><label><b> EXTENDED POWER LOSS</b></label></h2>
                        </div>
                        <div class="col-xs-12" style="padding-bottom: 20px;text-align-last: center;">
                            <h4> In the event of extended power loss to a facility certain precautionary measures should
                                be taken depending on the geographical location and environment of the facility:
                            </h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 20px;">
                            <li>
                                Unnecessary electrical equipment and appliances should be turned off in
                                the event that power restoration would surge causing damage to
                                electronics and effecting sensitive equipment.
                            </li>
                            <li>
                                Facilities with freezing temperatures should turn off and drain the following
                                lines in the event of a long term power loss.
                                <ol style="list-style-type: number;text-align-last: left;padding-bottom: 50px;">
                                    <li>Fire sprinkler system</li>
                                    <li>Standpipes</li>
                                    <li>Potable water lines</li>
                                    <li>Toilets</li>
                                </ol>
                            </li>
                            <li>
                                Add propylene-glycol to drains to prevent traps from freezing
                            </li>
                            <li>
                                Equipment that contains fluids that may freeze due to long term
                                exposure to freezing temperatures should be moved to heated areas,
                                drained of liquids, or provided with auxiliary heat sources.
                            </li>
                        </ul>
                        <div class="col-xs-12" style="padding-bottom: 20px;text-align-last: center;">
                            <h4><u></u> Upon Restoration of heat and power:</u></h4>
                        </div>
                        <ul style="list-style-type: disc;text-align-last: left;padding-bottom: 50px;">
                            <li>
                                Electronic equipment should be brought up to ambient temperatures
                                before energizing to prevent condensate from forming on circuitry.
                            </li>
                            <li>
                                Fire and potable water piping should be checked for leaks from freeze
                                damage after the heat has been restored to the facility and water turned back on.
                            </li>
                        </ul>
                    </div>

                </div>

            </div><!-- /.box-body -->

        </div><!-- /.box -->
    </div><br>
</section>

<section>
    <div class="row no-print">
        <div class="col-xs-12">
            <form style="text-align-last: center; background-color:  white;"><button type='button' value='Print this page' onclick='printpage();' class="btn btn-success"><i class="fa fa-print"></i> Print</button>
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

<?php $db->disconnect();
?>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>