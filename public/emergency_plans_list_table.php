<section class="content-header">
    <h1>Emergency Plans List /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1></h1>
    <ol class="breadcrumb">
    <a class="btn btn-block btn-default" href="add_emp_join.php"><i class="fa fa-plus-square"></i> Join New Employee</a>
    </ol>
    <hr />
</section>
<!-- search form -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($permissions['customers']['read'] == 1) { ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Emergency Plans List</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=emergency_plans_list" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_1" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="emergency_date_prepared" data-sortable="true">Date Prepared</th>
                                    <th data-field="manager_at_site" data-sortable="true">Highest Ranking Manager at Site</th>
                                    <th data-field="manager_as" data-sortable="true">Highest Ranking Manager at Site Such As</th>
                                    <th data-field="manager_name" data-sortable="true">Highest Ranking Manager Name</th>
                                    <th data-field="manager_mobile" data-sortable="true">Highest Ranking Manager Phone</th>
                                    <th data-field="coordinator_name" data-sortable="true">EMERGENCY COORDINATOR NAME</th>
                                    <th data-field="coordinator_mobile" data-sortable="true">EMERGENCY COORDINATOR Mobile</th>
                                    <th data-field="area_monitor" data-sortable="true">Area/Floor 1</th>
                                    <th data-field="area_monitor_name" data-sortable="true">Area/Floor Name 1</th>
                                    <th data-field="area_monitor_mobile" data-sortable="true">Area/Floor Phone 1</th>
                                    <th data-field="floor_monitor" data-sortable="true">Area/Floor 2</th>
                                    <th data-field="floor_monitor_name" data-sortable="true">Area/Floor Name 2</th>
                                    <th data-field="floor_monitor_mobile" data-sortable="true">Area/Floor Phone 2</th>
                                    <th data-field="assistants_to_phy_challanged_name1" data-sortable="true">Assistants To Physically Challenged Name 1</th>
                                    <th data-field="assistants_to_phy_challanged_mobile1" data-sortable="true">Assistants To Physically Challenged Phone 1</th>
                                    <th data-field="assistants_to_phy_challanged_name2" data-sortable="true">Assistants To Physically Challenged Name 2</th>
                                    <th data-field="assistants_to_phy_challanged_mobile2" data-sortable="true">Assistants To Physically Challenged Phone 2</th>
                                    <th data-field="emergency_date" data-sortable="true">Emergency Personnel Date</th>
                                    <th data-field="emergency_fire_number" data-sortable="true">Fire Department No</th>
                                    <th data-field="emergency_ambulance_number" data-sortable="true">Ambulance Department No</th>
                                    <th data-field="emergency_police_number" data-sortable="true">Police Department No</th>
                                    <th data-field="emergency_security_number" data-sortable="true">Security Department No</th>
                                    <th data-field="emergency_factory_manager_number" data-sortable="true">Factory Manager No</th>
                                    <th data-field="utility_emergency_number_electric" data-sortable="true">Electric No</th>
                                    <th data-field="utility_emergency_number_water" data-sortable="true">Water No</th>
                                    <th data-field="utility_emergency_number_gas" data-sortable="true">Gas No</th>
                                    <th data-field="utility_emergency_date" data-sortable="true">Utility Contacts Update Date</th>
                                    <th data-field="other_type_emergency" data-sortable="true">Other Type Of Emergency</th>
                                    <th data-field="med_emergency_call_paramedic" data-sortable="true">Call medical emergency Paramedics</th>
                                    <th data-field="med_emergency_call_ambulance" data-sortable="true">Call medical emergency Ambulance</th>
                                    <th data-field="med_emergency_call_fire" data-sortable="true">Call medical emergency Fire Department</th>
                                    <th data-field="med_emergency_call_other" data-sortable="true">Call medical emergency Other (Specify)</th>
                                    <th data-field="med_emergency_name1" data-sortable="true">Medical Emergency Name 1</th>
                                    <th data-field="med_emergency_phone1" data-sortable="true">Medical Emergency Phone 1</th>
                                    <th data-field="med_emergency_name2" data-sortable="true">Medical Emergency Name 2</th>
                                    <th data-field="med_emergency_phone2" data-sortable="true">Medical Emergency Phone 2</th>
                                    <th data-field="med_emergency_date" data-sortable="true">Medical Emergency Date</th>
                                    <th data-field="fire_emergency_call" data-sortable="true">Notify Fire Department by calling</th>
                                    <th data-field="fire_emergency_call_voice" data-sortable="true">Notify Fire Emergency By Voice Communication</th>
                                    <th data-field="fire_emergency_call_radio" data-sortable="true">Notify Fire Emergency By Radio</th>
                                    <th data-field="fire_emergency_call_paging" data-sortable="true">Notify Fire Emergency By Phone Paging</th>
                                    <th data-field="fire_emergency_call_other" data-sortable="true">Notify Fire Emergency By Other (specify)</th>
                                    <th data-field="fire_emergency_date" data-sortable="true">Fire Emergency Date</th>
                                    <th data-field="chem_spill_equipment" data-sortable="true">Chem Spill Containment Equipment</th>
                                    <th data-field="chem_spill_ppe" data-sortable="true">Personal Protective Equipment</th>
                                    <th data-field="chem_spill_msds" data-sortable="true">MSDS</th>
                                    <th data-field="chem_spill_cleanup_name" data-sortable="true">Spill Cleanup Company Name</th>
                                    <th data-field="chem_spill_cleanup_mobile" data-sortable="true">Spill Cleanup Company Phone</th>
                                    <th data-field="chem_spill_date" data-sortable="true">Chem Spill Date</th>
                                    <th data-field="struct_climb_descend_emergency_type_tower" data-sortable="true">Structure Type 1</th>
                                    <th data-field="struct_climb_descend_emergency_type_tower_location" data-sortable="true">Structure Location 1</th>
                                    <th data-field="struct_climb_descend_emergency_type_tower_org" data-sortable="true">Emergency Response Organization 1</th>
                                    <th data-field="struct_climb_descend_emergency_type_river" data-sortable="true">Structure Type 2</th>
                                    <th data-field="struct_climb_descend_emergency_type_river_location" data-sortable="true">Structure Location 2</th>
                                    <th data-field="struct_climb_descend_emergency_type_river_org" data-sortable="true">Emergency Response Organization 2</th>
                                    <th data-field="struct_climb_descend_emergency_type_other" data-sortable="true">Structure Type 3</th>
                                    <th data-field="struct_climb_descend_emergency_type_other_location" data-sortable="true">Structure Location 3</th>
                                    <th data-field="struct_climb_descend_emergency_type_other_org" data-sortable="true">Emergency Response Organization 3</th>
                                    <th data-field="critical_operation_area1" data-sortable="true">Critical Operations Assignments Work Area 1</th>
                                    <th data-field="critical_operation_name1" data-sortable="true">Critical Operations Assignments Name 1</th>
                                    <th data-field="critical_operation_job1" data-sortable="true">Critical Operations Assignments Job Title 1</th>
                                    <th data-field="critical_operation_assignment1" data-sortable="true">Critical Operations Assignments Description 1</th>
                                    <th data-field="critical_operation_area2" data-sortable="true">Critical Operations Assignments Work Area 2</th>
                                    <th data-field="critical_operation_name2" data-sortable="true">Critical Operations Assignments Name 2</th>
                                    <th data-field="critical_operation_job2" data-sortable="true">Critical Operations Assignments Job Title 2</th>
                                    <th data-field="critical_operation_assignment2" data-sortable="true">Critical Operations Assignments Description 2</th>
                                    <th data-field="critical_operation_area3" data-sortable="true">Critical Operations Assignments Work Area 3</th>
                                    <th data-field="critical_operation_name3" data-sortable="true">Critical Operations Assignments Name 3</th>
                                    <th data-field="critical_operation_job3" data-sortable="true">Critical Operations Assignments Job Title 3</th>
                                    <th data-field="critical_operation_assignment3" data-sortable="true">Critical Operations Assignments Description 3</th>
                                    <th data-field="critical_operation_offices" data-sortable="true">assigned personnel shall notify the offices</th>
                                    <th data-field="critical_operation_manuals" data-sortable="true">Emergency Evacuation Procedures included in Manual</th>
                                    <th data-field="critical_operation_contact_to_name1" data-sortable="true">Critical Operations Name 1</th>
                                    <th data-field="critical_operation_contact_to_location1" data-sortable="true">Critical Operations Location 1</th>
                                    <th data-field="critical_operation_contact_to_mobile1" data-sortable="true">Critical Operations Number 1</th>
                                    <th data-field="critical_operation_contact_to_name2" data-sortable="true">Critical Operations Name 2</th>
                                    <th data-field="critical_operation_contact_to_location2" data-sortable="true">Critical Operations Location 2</th>
                                    <th data-field="critical_operation_contact_to_mobile2" data-sortable="true">Critical Operations Number 2</th>
                                    <th data-field="critical_operation_contact_to_name3" data-sortable="true">Critical Operations Name 3</th>
                                    <th data-field="critical_operation_contact_to_location3" data-sortable="true">Critical Operations Location 3</th>
                                    <th data-field="critical_operation_contact_to_mobile3" data-sortable="true">Critical Operations Number 3</th>
                                    <th data-field="emergency_training_facility" data-sortable="true">Facility</th>
                                    <th data-field="emergency_training_person_name" data-sortable="true">Trained Person Name</th>
                                    <th data-field="emergency_training_person_responsibility" data-sortable="true">Trained Person Responsibility</th>
                                    <th data-field="location" data-sortable="true">Location</th>
                                    <th data-field="created_at" data-sortable="true">Created At</th>
                                    <th data-field="updated_at" data-sortable="true">Updated At</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view Form</div>
            <?php } ?>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row (main row) -->
    
</section>
<!-- /.content -->

<script>
    $('#filter_user').on('change', function() {
        $('#user_table').bootstrapTable('refresh');

    });

    function queryParams_1(p) {
        return {
            //"filter_user": $('#filter_user').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>