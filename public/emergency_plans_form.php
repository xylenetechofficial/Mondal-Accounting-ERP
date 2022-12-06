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
    $emergency_date_prepared = $db->escapeString($fn->xss_clean($_POST['emergency_date_prepared']));
    $manager_at_site = $db->escapeString($fn->xss_clean($_POST['manager_at_site']));
    $manager_as = $db->escapeString($fn->xss_clean($_POST['manager_as']));
    $manager_name = $db->escapeString($fn->xss_clean($_POST['manager_name']));
    $manager_mobile = $db->escapeString($fn->xss_clean($_POST['manager_mobile']));
    $coordinator_name = $db->escapeString($fn->xss_clean($_POST['coordinator_name']));
    $coordinator_mobile = $db->escapeString($fn->xss_clean($_POST['coordinator_mobile']));
    $area_monitor = $db->escapeString($fn->xss_clean($_POST['area_monitor']));
    $area_monitor_name = $db->escapeString($fn->xss_clean($_POST['area_monitor_name']));
    $area_monitor_mobile = $db->escapeString($fn->xss_clean($_POST['area_monitor_mobile']));
    $floor_monitor = $db->escapeString($fn->xss_clean($_POST['floor_monitor']));
    $floor_monitor_name = $db->escapeString($fn->xss_clean($_POST['floor_monitor_name']));
    $floor_monitor_mobile = $db->escapeString($fn->xss_clean($_POST['floor_monitor_mobile']));
    $assistants_to_phy_challanged_name1 = $db->escapeString($fn->xss_clean($_POST['assistants_to_phy_challanged_name1']));
    $assistants_to_phy_challanged_mobile1 = $db->escapeString($fn->xss_clean($_POST['assistants_to_phy_challanged_mobile1']));
    $assistants_to_phy_challanged_name2 = $db->escapeString($fn->xss_clean($_POST['assistants_to_phy_challanged_name2']));
    $assistants_to_phy_challanged_mobile2 = $db->escapeString($fn->xss_clean($_POST['assistants_to_phy_challanged_mobile2']));
    $emergency_date = $db->escapeString($fn->xss_clean($_POST['emergency_date']));
    $emergency_fire_number = $db->escapeString($fn->xss_clean($_POST['emergency_fire_number']));
    $emergency_ambulance_number = $db->escapeString($fn->xss_clean($_POST['emergency_ambulance_number']));
    $emergency_police_number = $db->escapeString($fn->xss_clean($_POST['emergency_police_number']));
    $emergency_security_number = $db->escapeString($fn->xss_clean($_POST['emergency_security_number']));
    $emergency_factory_manager_number = $db->escapeString($fn->xss_clean($_POST['emergency_factory_manager_number']));
    $utility_emergency_number_electric = $db->escapeString($fn->xss_clean($_POST['utility_emergency_number_electric']));
    $utility_emergency_number_water = $db->escapeString($fn->xss_clean($_POST['utility_emergency_number_water']));
    $utility_emergency_number_gas = $db->escapeString($fn->xss_clean($_POST['utility_emergency_number_gas']));
    $utility_emergency_date = $db->escapeString($fn->xss_clean($_POST['utility_emergency_date']));
    $other_type_emergency = $db->escapeString($fn->xss_clean($_POST['other_type_emergency']));
    $med_emergency_call_paramedic = $db->escapeString($fn->xss_clean($_POST['med_emergency_call_paramedic']));
    $med_emergency_call_ambulance = $db->escapeString($fn->xss_clean($_POST['med_emergency_call_ambulance']));
    $med_emergency_call_fire = $db->escapeString($fn->xss_clean($_POST['med_emergency_call_fire']));
    $med_emergency_call_other = $db->escapeString($fn->xss_clean($_POST['med_emergency_call_other']));
    $med_emergency_name1 = $db->escapeString($fn->xss_clean($_POST['med_emergency_name1']));
    $med_emergency_phone1 = $db->escapeString($fn->xss_clean($_POST['med_emergency_phone1']));
    $med_emergency_name2 = $db->escapeString($fn->xss_clean($_POST['med_emergency_name2']));
    $med_emergency_phone2 = $db->escapeString($fn->xss_clean($_POST['med_emergency_phone2']));
    $med_emergency_date = $db->escapeString($fn->xss_clean($_POST['med_emergency_date']));
    $fire_emergency_call = $db->escapeString($fn->xss_clean($_POST['fire_emergency_call']));
    $fire_emergency_call_voice = $db->escapeString($fn->xss_clean($_POST['fire_emergency_call_voice']));
    $fire_emergency_call_radio = $db->escapeString($fn->xss_clean($_POST['fire_emergency_call_radio']));
    $fire_emergency_call_paging = $db->escapeString($fn->xss_clean($_POST['fire_emergency_call_paging']));
    $fire_emergency_call_other = $db->escapeString($fn->xss_clean($_POST['fire_emergency_call_other']));
    $fire_emergency_date = $db->escapeString($fn->xss_clean($_POST['fire_emergency_date']));
    $chem_spill_equipment = $db->escapeString($fn->xss_clean($_POST['chem_spill_equipment']));
    $chem_spill_ppe = $db->escapeString($fn->xss_clean($_POST['chem_spill_ppe']));
    $chem_spill_msds = $db->escapeString($fn->xss_clean($_POST['chem_spill_msds']));
    $chem_spill_cleanup_name = $db->escapeString($fn->xss_clean($_POST['chem_spill_cleanup_name']));
    $chem_spill_cleanup_mobile = $db->escapeString($fn->xss_clean($_POST['chem_spill_cleanup_mobile']));
    $chem_spill_date = $db->escapeString($fn->xss_clean($_POST['chem_spill_date']));
    $struct_climb_descend_emergency_type_tower = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_tower']));
    $struct_climb_descend_emergency_type_tower_location = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_tower_location']));
    $struct_climb_descend_emergency_type_tower_org = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_tower_org']));
    $struct_climb_descend_emergency_type_river = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_river']));
    $struct_climb_descend_emergency_type_river_location = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_river_location']));
    $struct_climb_descend_emergency_type_river_org = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_river_org']));
    $struct_climb_descend_emergency_type_other = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_other']));
    $struct_climb_descend_emergency_type_other_location = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_other_location']));
    $struct_climb_descend_emergency_type_other_org = $db->escapeString($fn->xss_clean($_POST['struct_climb_descend_emergency_type_other_org']));
    $critical_operation_area1 = $db->escapeString($fn->xss_clean($_POST['critical_operation_area1']));
    $critical_operation_name1 = $db->escapeString($fn->xss_clean($_POST['critical_operation_name1']));
    $critical_operation_job1 = $db->escapeString($fn->xss_clean($_POST['critical_operation_job1']));
    $critical_operation_assignment1 = $db->escapeString($fn->xss_clean($_POST['critical_operation_assignment1']));
    $critical_operation_area2 = $db->escapeString($fn->xss_clean($_POST['critical_operation_area2']));
    $critical_operation_name2 = $db->escapeString($fn->xss_clean($_POST['critical_operation_name2']));
    $critical_operation_job2 = $db->escapeString($fn->xss_clean($_POST['critical_operation_job2']));
    $critical_operation_assignment2 = $db->escapeString($fn->xss_clean($_POST['critical_operation_assignment2']));
    $critical_operation_area3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_area3']));
    $critical_operation_name3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_name3']));
    $critical_operation_job3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_job3']));
    $critical_operation_assignment3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_assignment3']));
    $critical_operation_offices = $db->escapeString($fn->xss_clean($_POST['critical_operation_offices']));
    $critical_operation_manuals = $db->escapeString($fn->xss_clean($_POST['critical_operation_manuals']));
    $critical_operation_contact_to_name1 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_name1']));
    $critical_operation_contact_to_location1 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_location1']));
    $critical_operation_contact_to_mobile1 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_mobile1']));
    $critical_operation_contact_to_name2 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_name2']));
    $critical_operation_contact_to_location2 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_location2']));
    $critical_operation_contact_to_mobile2 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_mobile2']));
    $critical_operation_contact_to_name3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_name3']));
    $critical_operation_contact_to_location3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_location3']));
    $critical_operation_contact_to_mobile3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_mobile3']));
    //$critical_operation_contact_to_mobile3 = $db->escapeString($fn->xss_clean($_POST['critical_operation_contact_to_mobile3']));
    $emergency_training_facility = $db->escapeString($fn->xss_clean($_POST['emergency_training_facility']));
    $emergency_training_person_name = $db->escapeString($fn->xss_clean($_POST['emergency_training_person_name']));
    $emergency_training_person_responsibility = $db->escapeString($fn->xss_clean($_POST['emergency_training_person_responsibility']));
    $location = $db->escapeString($fn->xss_clean($_POST['location']));

    $sql = "INSERT INTO `emergency_plans`(`manager_at_site`, `manager_as`, `manager_name`, `manager_mobile`, `coordinator_name`, `coordinator_mobile`, `area_monitor`, `floor_monitor`, `area_monitor_name`, `floor_monitor_name`, `area_monitor_mobile`, `floor_monitor_mobile`, `assistants_to_phy_challanged_name1`, `assistants_to_phy_challanged_name2`, `assistants_to_phy_challanged_mobile1`, `assistants_to_phy_challanged_mobile2`, `emergency_date_prepared`, `emergency_date`, `emergency_fire_number`, `emergency_ambulance_number`, `emergency_police_number`, `emergency_security_number`, `emergency_factory_manager_number`, `utility_emergency_number_electric`, `utility_emergency_number_water`, `utility_emergency_number_gas`, `utility_emergency_date`, `other_type_emergency`, `med_emergency_call_paramedic`, `med_emergency_call_ambulance`, `med_emergency_call_fire`, `med_emergency_call_other`, `med_emergency_name1`, `med_emergency_phone1`, `med_emergency_name2`, `med_emergency_phone2`, `med_emergency_date`, `fire_emergency_call`, `fire_emergency_call_voice`, `fire_emergency_call_radio`, `fire_emergency_call_paging`, `fire_emergency_call_other`, `fire_emergency_date`, `chem_spill_equipment`, `chem_spill_ppe`, `chem_spill_msds`, `chem_spill_cleanup_name`, `chem_spill_cleanup_mobile`, `chem_spill_date`, `struct_climb_descend_emergency_type_tower`, `struct_climb_descend_emergency_type_tower_location`, `struct_climb_descend_emergency_type_tower_org`, `struct_climb_descend_emergency_type_river`, `struct_climb_descend_emergency_type_river_location`, `struct_climb_descend_emergency_type_river_org`, `struct_climb_descend_emergency_type_other`, `struct_climb_descend_emergency_type_other_location`, `struct_climb_descend_emergency_type_other_org`, `critical_operation_area1`, `critical_operation_name1`, `critical_operation_job1`, `critical_operation_assignment1`, `critical_operation_area2`, `critical_operation_name2`, `critical_operation_job2`, `critical_operation_assignment2`, `critical_operation_area3`, `critical_operation_name3`, `critical_operation_job3`, `critical_operation_assignment3`, `critical_operation_offices`, `critical_operation_manuals`, `critical_operation_contact_to_name1`, `critical_operation_contact_to_location1`, `critical_operation_contact_to_mobile1`, `critical_operation_contact_to_name2`, `critical_operation_contact_to_location2`, `critical_operation_contact_to_mobile2`, `critical_operation_contact_to_name3`, `critical_operation_contact_to_location3`, `critical_operation_contact_to_mobile3`, `emergency_training_facility`, `emergency_training_person_name`, `emergency_training_person_responsibility`, `location`, `created_at`, `updated_at`) 
    VALUES ('$manager_at_site','$manager_as','$manager_name','$manager_mobile','$coordinator_name','$coordinator_mobile','$area_monitor','$area_monitor_name','$area_monitor_mobile','$floor_monitor','$floor_monitor_name','$floor_monitor_mobile','$assistants_to_phy_challanged_name1','$assistants_to_phy_challanged_mobile1','$assistants_to_phy_challanged_name2','$assistants_to_phy_challanged_mobile2','$emergency_date_prepared','$emergency_date','$emergency_fire_number','$emergency_ambulance_number','$emergency_police_number','$emergency_security_number','$emergency_factory_manager_number','$utility_emergency_number_electric','$utility_emergency_number_water','$utility_emergency_number_gas','$utility_emergency_date','$other_type_emergency','$med_emergency_call_paramedic','$med_emergency_call_ambulance','$med_emergency_call_fire','$med_emergency_call_other','$med_emergency_name1','$med_emergency_phone1','$med_emergency_name2','$med_emergency_phone2','$med_emergency_date','$fire_emergency_call','$fire_emergency_call_voice','$fire_emergency_call_radio','$fire_emergency_call_paging','$fire_emergency_call_other','$fire_emergency_date','$chem_spill_equipment','$chem_spill_ppe','$chem_spill_msds','$chem_spill_cleanup_name','$chem_spill_cleanup_mobile','$chem_spill_date','$struct_climb_descend_emergency_type_tower','$struct_climb_descend_emergency_type_tower_location','$struct_climb_descend_emergency_type_tower_org','$struct_climb_descend_emergency_type_river','$struct_climb_descend_emergency_type_river_location','$struct_climb_descend_emergency_type_river_org','$struct_climb_descend_emergency_type_other','$struct_climb_descend_emergency_type_other_location','$struct_climb_descend_emergency_type_other_org','$critical_operation_area1','$critical_operation_name1','$critical_operation_job1','$critical_operation_assignment1','$critical_operation_area2','$critical_operation_name2','$critical_operation_job2','$critical_operation_assignment2','$critical_operation_area3','$critical_operation_name3','$critical_operation_job3','$critical_operation_assignment3','$critical_operation_offices','$critical_operation_manuals','$critical_operation_contact_to_name1','$critical_operation_contact_to_location1','$critical_operation_contact_to_mobile1','$critical_operation_contact_to_name2','$critical_operation_contact_to_location2','$critical_operation_contact_to_mobile2','$critical_operation_contact_to_name3','$critical_operation_contact_to_location3','$critical_operation_contact_to_mobile3','$emergency_training_facility','$emergency_training_person_name','$emergency_training_person_responsibility','$location','$datetime','$datetime')";
    $db->sql($sql);
    print_r($sql);
    $res = $db->getResult();
    print_r($res);
}

if (isset($_POST['btnAdd'])) {
?>
    <script type="text/javascript">
        window.location = "emergency_plans.php";
    </script>
<?php
}

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>Emergency Plans Form</h1>
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
                <form id="add_product_form" role="form" method="post" enctype="multipart/form-data" action="emergency_plans.php">
                    <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date Prepared</label><?php echo isset($error['emergency_date_prepared']) ? $error['emergency_date_prepared'] : ''; ?>
                                <input type="date" name="emergency_date_prepared" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Highest Ranking Manager at Site</label><?php echo isset($error['manager_at_site']) ? $error['manager_at_site'] : ''; ?>
                                <input type="text" name="manager_at_site" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Highest Ranking Manager at Site Such As</label><?php echo isset($error['manager_as']) ? $error['manager_as'] : ''; ?>
                                <input type="text" name="manager_as" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Highest Ranking Manager Name</label><?php echo isset($error['manager_name']) ? $error['manager_name'] : ''; ?>
                                <input type="text" name="manager_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Highest Ranking Manager Phone</label><?php echo isset($error['manager_mobile']) ? $error['manager_mobile'] : ''; ?>
                                <input type="text" name="manager_mobile" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">EMERGENCY COORDINATOR NAME</label><?php echo isset($error['coordinator_name']) ? $error['coordinator_name'] : ''; ?>
                                <input type="text" name="coordinator_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">EMERGENCY COORDINATOR Mobile </label><?php echo isset($error['coordinator_mobile']) ? $error['coordinator_mobile'] : ''; ?>
                                <input type="text" class="form-control" name="coordinator_mobile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area/Floor 1</label><?php echo isset($error['area_monitor']) ? $error['area_monitor'] : ''; ?>
                                <input type="text" class="form-control" name="area_monitor">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area/Floor Name 1</label><?php echo isset($error['area_monitor_name']) ? $error['area_monitor_name'] : ''; ?>
                                <input type="text" class="form-control" name="area_monitor_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area/Floor Phone 1</label><?php echo isset($error['area_monitor_mobile']) ? $error['area_monitor_mobile'] : ''; ?>
                                <input type="text" class="form-control" name="area_monitor_mobile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area/Floor 2</label><?php echo isset($error['floor_monitor']) ? $error['floor_monitor'] : ''; ?>
                                <input type="text" class="form-control" name="floor_monitor">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area/Floor Name 2</label><?php echo isset($error['floor_monitor_name']) ? $error['floor_monitor_name'] : ''; ?>
                                <input type="text" class="form-control" name="floor_monitor_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area/Floor Phone 2</label><?php echo isset($error['floor_monitor_mobile']) ? $error['floor_monitor_mobile'] : ''; ?>
                                <input type="text" class="form-control" name="floor_monitor_mobile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Assistants To Physically Challenged Name 1</label><?php echo isset($error['assistants_to_phy_challanged_name1']) ? $error['assistants_to_phy_challanged_name1'] : ''; ?>
                                <input type="text" class="form-control" name="assistants_to_phy_challanged_name1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Assistants To Physically Challenged Phone 1</label><?php echo isset($error['assistants_to_phy_challanged_mobile1']) ? $error['assistants_to_phy_challanged_mobile1'] : ''; ?>
                                <input type="text" class="form-control" name="assistants_to_phy_challanged_mobile1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Assistants To Physically Challenged Name 2</label><?php echo isset($error['assistants_to_phy_challanged_name2']) ? $error['assistants_to_phy_challanged_name2'] : ''; ?>
                                <input type="text" class="form-control" name="assistants_to_phy_challanged_name2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Assistants To Physically Challenged Phone 2</label><?php echo isset($error['assistants_to_phy_challanged_mobile2']) ? $error['assistants_to_phy_challanged_mobile2'] : ''; ?>
                                <input type="text" class="form-control" name="assistants_to_phy_challanged_mobile2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Emergency Personnel Date</label><?php echo isset($error['emergency_date']) ? $error['emergency_date'] : ''; ?>
                                <input type="date" class="form-control" name="emergency_date">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Fire Department No</label><?php echo isset($error['emergency_fire_number']) ? $error['emergency_fire_number'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_fire_number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ambulance Department No</label><?php echo isset($error['emergency_ambulance_number']) ? $error['emergency_ambulance_number'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_ambulance_number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Police Department No</label><?php echo isset($error['emergency_police_number']) ? $error['emergency_police_number'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_police_number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Security Department No</label><?php echo isset($error['emergency_security_number']) ? $error['emergency_security_number'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_security_number">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Factory Manager No.</label><?php echo isset($error['emergency_factory_manager_number']) ? $error['emergency_factory_manager_number'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_factory_manager_number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Electric No</label><?php echo isset($error['utility_emergency_number_electric']) ? $error['utility_emergency_number_electric'] : ''; ?>
                                <input type="text" class="form-control" name="utility_emergency_number_electric">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Water No</label><?php echo isset($error['utility_emergency_number_water']) ? $error['utility_emergency_number_water'] : ''; ?>
                                <input type="text" class="form-control" name="utility_emergency_number_water">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gas No</label><?php echo isset($error['utility_emergency_number_gas']) ? $error['utility_emergency_number_gas'] : ''; ?>
                                <input type="text" class="form-control" name="utility_emergency_number_gas">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Utility Contacts Update Date</label><?php echo isset($error['utility_emergency_date']) ? $error['utility_emergency_date'] : ''; ?>
                                <input type="date" class="form-control" name="utility_emergency_date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Other Type Of Emergency</label><?php echo isset($error['other_type_emergency']) ? $error['other_type_emergency'] : ''; ?>
                                <input type="text" class="form-control" name="other_type_emergency">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Call medical emergency Paramedics</label><?php echo isset($error['med_emergency_call_paramedic']) ? $error['med_emergency_call_paramedic'] : ''; ?>
                                <select class="form-control" id="med_emergency_call_paramedic" name="med_emergency_call_paramedic" required>
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
                                <label for="exampleInputEmail1">Call medical emergency Ambulance</label><?php echo isset($error['med_emergency_call_ambulance']) ? $error['med_emergency_call_ambulance'] : ''; ?>
                                <select class="form-control" id="med_emergency_call_ambulance" name="med_emergency_call_ambulance" required>
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
                                <label for="exampleInputEmail1">Call medical emergency Fire Department</label><?php echo isset($error['med_emergency_call_fire']) ? $error['med_emergency_call_fire'] : ''; ?>
                                <select class="form-control" id="med_emergency_call_fire" name="med_emergency_call_fire" required>
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
                                <label for="exampleInputEmail1">Call medical emergency Other (Specify)</label><?php echo isset($error['med_emergency_call_other']) ? $error['med_emergency_call_other'] : ''; ?>
                                <input type="text" class="form-control" name="med_emergency_call_other">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Medical Emergency Name 1</label><?php echo isset($error['med_emergency_name1']) ? $error['med_emergency_name1'] : ''; ?>
                                <input type="text" class="form-control" name="med_emergency_name1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Medical Emergency Phone 1</label><?php echo isset($error['med_emergency_phone1']) ? $error['med_emergency_phone1'] : ''; ?>
                                <input type="text" class="form-control" name="med_emergency_phone1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Medical Emergency Name 2</label><?php echo isset($error['med_emergency_name2']) ? $error['med_emergency_name2'] : ''; ?>
                                <input type="text" class="form-control" name="med_emergency_name2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Medical Emergency Phone 2</label><?php echo isset($error['med_emergency_phone2']) ? $error['med_emergency_phone2'] : ''; ?>
                                <input type="text" class="form-control" name="med_emergency_phone2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Medical Emergency Date</label><?php echo isset($error['med_emergency_date']) ? $error['med_emergency_date'] : ''; ?>
                                <input type="date" class="form-control" name="med_emergency_date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Notify Fire Department by calling</label><?php echo isset($error['fire_emergency_call']) ? $error['fire_emergency_call'] : ''; ?>
                                <input type="text" class="form-control" name="fire_emergency_call">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Notify Fire Emergency By Voice Communication</label><?php echo isset($error['fire_emergency_call_voice']) ? $error['fire_emergency_call_voice'] : ''; ?>
                                <select class="form-control" id="fire_emergency_call_voice" name="fire_emergency_call_voice" required>
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
                                <label for="exampleInputEmail1">Notify Fire Emergency By Radio</label><?php echo isset($error['fire_emergency_call_radio']) ? $error['fire_emergency_call_radio'] : ''; ?>
                                <select class="form-control" id="fire_emergency_call_radio" name="fire_emergency_call_radio" required>
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
                                <label for="exampleInputEmail1">Notify Fire Emergency By Phone Paging</label><?php echo isset($error['fire_emergency_call_paging']) ? $error['fire_emergency_call_paging'] : ''; ?>
                                <select class="form-control" id="fire_emergency_call_paging" name="fire_emergency_call_paging" required>
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
                                <label for="exampleInputEmail1">Notify Fire Emergency By Other (specify)</label><?php echo isset($error['fire_emergency_call_other']) ? $error['fire_emergency_call_other'] : ''; ?>
                                <input type="text" class="form-control" name="fire_emergency_call_other">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Fire Emergency Date</label><?php echo isset($error['fire_emergency_date']) ? $error['fire_emergency_date'] : ''; ?>
                                <input type="date" class="form-control" name="fire_emergency_date">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chem Spill Containment Equipment</label><?php echo isset($error['chem_spill_equipment']) ? $error['chem_spill_equipment'] : ''; ?>
                                <input type="text" class="form-control family_div" name="chem_spill_equipment" id="chem_spill_equipment">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Personal Protective Equipment</label><?php echo isset($error['chem_spill_ppe']) ? $error['chem_spill_ppe'] : ''; ?>
                                <input type="text" class="form-control family_div" name="chem_spill_ppe" id="chem_spill_ppe">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">MSDS</label><?php echo isset($error['chem_spill_msds']) ? $error['chem_spill_msds'] : ''; ?>
                                <input type="text" class="form-control family_div" name="chem_spill_msds" id="chem_spill_msds">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Spill Cleanup Company Name</label><?php echo isset($error['chem_spill_cleanup_name']) ? $error['chem_spill_cleanup_name'] : ''; ?>
                                <input type="text" class="form-control family_div" name="chem_spill_cleanup_name" id="chem_spill_cleanup_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Spill Cleanup Company Phone</label><?php echo isset($error['chem_spill_cleanup_mobile']) ? $error['chem_spill_cleanup_mobile'] : ''; ?>
                                <input type="text" class="form-control" name="chem_spill_cleanup_mobile" id="chem_spill_cleanup_mobile">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Chem Spill Date</label><?php echo isset($error['chem_spill_date']) ? $error['chem_spill_date'] : ''; ?>
                                <input type="date" class="form-control" name="chem_spill_date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Structure Type 1</label><?php echo isset($error['struct_climb_descend_emergency_type_tower']) ? $error['struct_climb_descend_emergency_type_tower'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_tower">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Structure Location 1</label><?php echo isset($error['struct_climb_descend_emergency_type_tower_location']) ? $error['struct_climb_descend_emergency_type_tower_location'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_tower_location">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Emergency Response Organization 1</label><?php echo isset($error['struct_climb_descend_emergency_type_tower_org']) ? $error['struct_climb_descend_emergency_type_tower_org'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_tower_org">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Structure Type 2</label><?php echo isset($error['struct_climb_descend_emergency_type_river']) ? $error['struct_climb_descend_emergency_type_river'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_river">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Structure Location 2</label><?php echo isset($error['struct_climb_descend_emergency_type_river_location']) ? $error['struct_climb_descend_emergency_type_river_location'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_river_location">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Emergency Response Organization 2</label><?php echo isset($error['struct_climb_descend_emergency_type_river_org']) ? $error['struct_climb_descend_emergency_type_river_org'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_river_org">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Structure Type 3</label><?php echo isset($error['struct_climb_descend_emergency_type_other']) ? $error['struct_climb_descend_emergency_type_other'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_other">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Structure Location 3</label><?php echo isset($error['struct_climb_descend_emergency_type_other_location']) ? $error['struct_climb_descend_emergency_type_other_location'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_other_location" multiple>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Emergency Response Organization 3</label><?php echo isset($error['struct_climb_descend_emergency_type_other_org']) ? $error['struct_climb_descend_emergency_type_other_org'] : ''; ?>
                                <input type="text" class="form-control" name="struct_climb_descend_emergency_type_other_org">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Work Area 1</label><?php echo isset($error['critical_operation_area1']) ? $error['critical_operation_area1'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_area1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Name 1</label><?php echo isset($error['critical_operation_name1']) ? $error['critical_operation_name1'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_name1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Job Title 1</label><?php echo isset($error['critical_operation_job1']) ? $error['critical_operation_job1'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_job1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Description 1</label><?php echo isset($error['critical_operation_assignment1']) ? $error['critical_operation_assignment1'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_assignment1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Work Area 2</label><?php echo isset($error['critical_operation_area2']) ? $error['critical_operation_area2'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_area2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Name 2</label><?php echo isset($error['critical_operation_name2']) ? $error['critical_operation_name2'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_name2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Job Title 2</label><?php echo isset($error['critical_operation_job2']) ? $error['critical_operation_job2'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_job2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Description 2</label><?php echo isset($error['critical_operation_assignment2']) ? $error['critical_operation_assignment2'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_assignment2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Work Area 3</label><?php echo isset($error['critical_operation_area3']) ? $error['critical_operation_area3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_area3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Name 3</label><?php echo isset($error['critical_operation_name3']) ? $error['critical_operation_name3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_name3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Job Title 3</label><?php echo isset($error['critical_operation_job3']) ? $error['critical_operation_job3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_job3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Assignments Description 3</label><?php echo isset($error['critical_operation_assignment3']) ? $error['critical_operation_assignment3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_assignment3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">assigned personnel shall notify the offices</label><?php echo isset($error['critical_operation_offices']) ? $error['critical_operation_offices'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_offices">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Emergency Evacuation Procedures included in Manual</label><?php echo isset($error['critical_operation_manuals']) ? $error['critical_operation_manuals'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_manuals">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Name 1</label><?php echo isset($error['critical_operation_contact_to_name1']) ? $error['critical_operation_contact_to_name1'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_name1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Location 1</label><?php echo isset($error['critical_operation_contact_to_location1']) ? $error['critical_operation_contact_to_location1'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_location1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Number 1</label><?php echo isset($error['critical_operation_contact_to_mobile1']) ? $error['critical_operation_contact_to_mobile1'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_mobile1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Name 2</label><?php echo isset($error['critical_operation_contact_to_name2']) ? $error['critical_operation_contact_to_name2'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_name2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Location 2</label><?php echo isset($error['critical_operation_contact_to_location2']) ? $error['critical_operation_contact_to_location2'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_location2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Number 2</label><?php echo isset($error['critical_operation_contact_to_mobile2']) ? $error['critical_operation_contact_to_mobile2'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_mobile2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Name 3</label><?php echo isset($error['critical_operation_contact_to_name3']) ? $error['critical_operation_contact_to_name3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_name3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Location 3</label><?php echo isset($error['critical_operation_contact_to_location3']) ? $error['critical_operation_contact_to_location3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_location3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Number 3</label><?php echo isset($error['critical_operation_contact_to_mobile3']) ? $error['critical_operation_contact_to_mobile3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_mobile3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Critical Operations Number 3</label><?php echo isset($error['critical_operation_contact_to_mobile3']) ? $error['critical_operation_contact_to_mobile3'] : ''; ?>
                                <input type="text" class="form-control" name="critical_operation_contact_to_mobile3">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Facility</label><?php echo isset($error['emergency_training_facility']) ? $error['emergency_training_facility'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_training_facility">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trained Person Name</label><?php echo isset($error['emergency_training_person_name']) ? $error['emergency_training_person_name'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_training_person_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trained Person Responsibility</label><?php echo isset($error['emergency_training_person_responsibility']) ? $error['emergency_training_person_responsibility'] : ''; ?>
                                <input type="text" class="form-control" name="emergency_training_person_responsibility">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Location</label><?php echo isset($error['location']) ? $error['location'] : ''; ?>
                                <select class="form-control" id="location" name="main_category_name" required>
                                    <option value="">--Select Location--</option>
                                    <?php
                                    $sql = "SELECT * FROM location";
                                    $db->sql($sql);
                                    $res = $db->getResult();
                                    foreach ($res as $location) {
                                        echo "<option value='" . $location['id'] . "'>" . $location['location_name'] . "</option>";
                                    }
                                    ?>
                                </select>
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