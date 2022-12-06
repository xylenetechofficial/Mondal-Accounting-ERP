<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Work permit details Lists /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    <!--<ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-abp.php"><i class="fa fa-plus-square"></i> Add ABP</a>
    </ol>-->
</section>
<?php
$data = $fn->get_settings('categories_settings', true);
if ($permissions['categories']['read'] == 1) {
?>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-header">
                        <h3 class="box-title">Work permit details Lists</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=work_permit" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="doc_no" data-sortable="true">doc_no</th>
                                    <th data-field="rev" data-sortable="true">rev</th>
                                    <th data-field="effective_date" data-sortable="true">effective_date</th>
                                    <th data-field="si_no" data-sortable="true">si_no</th>
                                    <th data-field="date" data-sortable="true">date</th>
                                    <th data-field="department" data-sortable="true">department</th>
                                    <th data-field="section" data-sortable="true">section</th>
                                    <th data-field="org_permit_valid_from" data-sortable="true">org_permit_valid_from</th>
                                    <th data-field="org_permit_valid_to" data-sortable="true">org_permit_valid_to</th>
                                    <th data-field="renewal_valid_from1" data-sortable="true">renewal_valid_from1</th>
                                    <th data-field="renewal_valid_to1" data-sortable="true">renewal_valid_to1</th>
                                    <th data-field="renewal_valid_from2" data-sortable="true">renewal_valid_from2</th>
                                    <th data-field="renewal_valid_to2" data-sortable="true">renewal_valid_to2</th>
                                    <th data-field="job_description" data-sortable="true">job_description</th>
                                    <th data-field="working_agency_name" data-sortable="true">working_agency_name</th>
                                    <th data-field="work_permit_area" data-sortable="true">work_permit_area</th>
                                    <th data-field="welding_gas_cutting" data-sortable="true">welding_gas_cutting</th>
                                    <th data-field="rigging_fitting" data-sortable="true">rigging_fitting</th>
                                    <th data-field="work_at_height" data-sortable="true">work_at_height</th>
                                    <th data-field="Hydraulic_Pneumatic" data-sortable="true">Hydraulic_Pneumatic</th>
                                    <th data-field="painting_cleaning" data-sortable="true">painting_cleaning</th>
                                    <th data-field="confined_space" data-sortable="true">confined_space Severity</th>
                                    <th data-field="gas" data-sortable="true">gas</th>
                                    <th data-field="electrical" data-sortable="true">electrical</th>
                                    <th data-field="other" data-sortable="true">other</th>
                                    <th data-field="gas_hazard_permit_taken" data-sortable="true">gas_hazard_permit_taken</th>
                                    <th data-field="gas_hazard_permit_no" data-sortable="true">gas_hazard_permit_no</th>
                                    <th data-field="confined_space_permit_taken" data-sortable="true">confined_space_permit_taken</th>
                                    <th data-field="confined_space_permit_no" data-sortable="true">confined_space_permit_no</th>
                                    <th data-field="electrical_power_permit_taken" data-sortable="true">electrical_power_permit_taken</th>
                                    <th data-field="electrical_power_permit_no" data-sortable="true">electrical_power_permit_no</th>
                                    <th data-field="grounding_discharging_permit_taken" data-sortable="true">grounding_discharging_permit_taken</th>
                                    <th data-field="grounding_discharging_permit_no" data-sortable="true">grounding_discharging_permit_no</th>
                                    <th data-field="Hydraulic_Pneumatic_permit_taken" data-sortable="true">Hydraulic_Pneumatic_permit_taken</th>
                                    <th data-field="Hydraulic_Pneumatic_permit_no" data-sortable="true">Hydraulic_Pneumatic_permit_no</th>
                                    <th data-field="hot_work_permit_taken" data-sortable="true">hot_work_permit_taken</th>
                                    <th data-field="hot_work_permit_no" data-sortable="true">hot_work_permit_no</th>
                                    <th data-field="mechanized_grading_permit_taken" data-sortable="true">mechanized_grading_permit_taken</th>
                                    <th data-field="mechanized_grading_permit_no" data-sortable="true">mechanized_grading_permit_no</th>
                                    <th data-field="positive_isolation_permit_taken" data-sortable="true">positive_isolation_permit_taken</th>
                                    <th data-field="positive_isolation_permit_no" data-sortable="true">positive_isolation_permit_no</th>
                                    <th data-field="spl_instruction" data-sortable="true">spl_instruction</th>
                                    <th data-field="permit_org_name_req_by" data-sortable="true">permit_org_name_req_by</th>
                                    <th data-field="permit_org_name_issued_by" data-sortable="true">permit_org_name_issued_by</th>
                                    <th data-field="permit_org_name_taken_by_working" data-sortable="true">permit_org_name_taken_by_working</th>
                                    <th data-field="permit_org_name_taken_by_central" data-sortable="true">permit_org_name_taken_by_central</th>
                                    <th data-field="renewal1_name_req_by" data-sortable="true">renewal1_name_req_by</th>
                                    <th data-field="renewal1_name_issued_by" data-sortable="true">renewal1_name_issued_by</th>
                                    <th data-field="renewal1_name_taken_by_working" data-sortable="true">renewal1_name_taken_by_working</th>
                                    <th data-field="renewal1_name_taken_by_central" data-sortable="true">renewal1_name_taken_by_central</th>
                                    <th data-field="renewal2_name_req_by" data-sortable="true">renewal2_name_req_by</th>
                                    <th data-field="renewal2_name_issued_by" data-sortable="true">renewal2_name_issued_by</th>
                                    <th data-field="renewal2_name_taken_by_working" data-sortable="true">renewal2_name_taken_by_working</th>
                                    <th data-field="renewal2_name_taken_by_central" data-sortable="true">renewal2_name_taken_by_central</th>
                                    <th data-field="permit_org_designation_req_by" data-sortable="true">permit_org_designation_req_by by</th>
                                    <th data-field="permit_org_designation_issued_by" data-sortable="true">permit_org_designation_issued_by</th>
                                    <th data-field="permit_org_designation_taken_by_working" data-sortable="true">permit_org_designation_taken_by_working</th>
                                    <th data-field="permit_org_designation_taken_by_central" data-sortable="true">permit_org_designation_taken_by_central</th>
                                    <th data-field="renewal1_designation_req_by" data-sortable="true">renewal1_designation_req_by</th>
                                    <th data-field="renewal1_designation_issued_by" data-sortable="true">renewal1_designation_issued_by</th>
                                    <th data-field="renewal1_designation_taken_by_working" data-sortable="true">renewal1_designation_taken_by_working</th>
                                    <th data-field="renewal1_designation_taken_by_central" data-sortable="true">renewal1_designation_taken_by_central</th>
                                    <th data-field="renewal2_designation_req_by" data-sortable="true">renewal2_designation_req_by</th>
                                    <th data-field="renewal2_designation_issued_by" data-sortable="true">renewal2_designation_issued_by</th>
                                    <th data-field="renewal2_designation_taken_by_working" data-sortable="true">renewal2_designation_taken_by_working</th>
                                    <th data-field="renewal2_designation_taken_by_central" data-sortable="true">renewal2_designation_taken_by_central</th>
                                    <th data-field="permit_org_signature_req_by" data-sortable="true">permit_org_signature_req_by</th>
                                    <th data-field="permit_org_signature_issued_by" data-sortable="true">permit_org_signature_issued_by</th>
                                    <th data-field="permit_org_signature_taken_by_working" data-sortable="true">permit_org_signature_taken_by_working</th>
                                    <th data-field="permit_org_signature_taken_by_central" data-sortable="true">permit_org_signature_taken_by_central</th>
                                    <th data-field="renewal1_signature_req_by" data-sortable="true">renewal1_signature_req_by</th>
                                    <th data-field="renewal1_signature_issued_by" data-sortable="true">renewal1_signature_issued_by</th>
                                    <th data-field="renewal1_signature_taken_by_working" data-sortable="true">renewal1_signature_taken_by_working</th>
                                    <th data-field="renewal1_signature_taken_by_central" data-sortable="true">renewal1_signature_taken_by_central</th>
                                    <th data-field="renewal2_signature_req_by" data-sortable="true">renewal2_signature_req_by</th>
                                    <th data-field="renewal2_signature_issued_by" data-sortable="true">renewal2_signature_issued_by</th>
                                    <th data-field="renewal2_signature_taken_by_working" data-sortable="true">renewal2_signature_taken_by_working</th>
                                    <th data-field="renewal2_signature_taken_by_central" data-sortable="true">renewal2_signature_taken_by_central</th>
                                    <th data-field="name_return_by_working_agency" data-sortable="true">name_return_by_working_agency</th>
                                    <th data-field="name_return_by_taken_by" data-sortable="true">name_return_by_taken_by</th>
                                    <th data-field="name_revived_by_executive" data-sortable="true">name_revived_by_executive</th>
                                    <th data-field="name_revived_by_owner" data-sortable="true">name_revived_by_owner</th>
                                    <th data-field="designation_return_by_working_agency" data-sortable="true">designation_return_by_working_agency</th>
                                    <th data-field="designation_return_by_taken_by" data-sortable="true">designation_return_by_taken_by</th>
                                    <th data-field="designation_revived_by_executive" data-sortable="true">designation_revived_by_executive</th>
                                    <th data-field="designation_revived_by_owner" data-sortable="true">designation_revived_by_owner</th>
                                    <th data-field="signature_return_by_working_agency" data-sortable="true">signature_return_by_working_agency</th>
                                    <th data-field="signature_return_by_taken_by" data-sortable="true">signature_return_by_taken_by</th>
                                    <th data-field="signature_revived_by_executive" data-sortable="true">signature_revived_by_executive</th>
                                    <th data-field="signature_revived_by_owner" data-sortable="true">signature_revived_by_owner</th>
                                    <th data-field="north_hazard" data-sortable="true">north_hazard</th>
                                    <th data-field="north_precautions" data-sortable="true">north_precautions</th>
                                    <th data-field="south_remark" data-sortable="true">south_remark</th>
                                    <th data-field="south_hazard" data-sortable="true">south_hazard</th>
                                    <th data-field="south_precautions" data-sortable="true">south_precautions</th>
                                    <th data-field="north_remark" data-sortable="true">north_remark</th>
                                    <th data-field="east_hazard" data-sortable="true">east_hazard</th>
                                    <th data-field="east_precautions" data-sortable="true">east_precautions</th>
                                    <th data-field="east_remark" data-sortable="true">east_remark</th>
                                    <th data-field="west_hazard" data-sortable="true">west_hazard</th>
                                    <th data-field="west_precautions" data-sortable="true">west_precautions</th>
                                    <th data-field="west_remark" data-sortable="true">west_remark</th>
                                    <th data-field="top_hazard" data-sortable="true">top_hazard</th>
                                    <th data-field="top_precautions" data-sortable="true">top_precautions</th>
                                    <th data-field="top_remark" data-sortable="true">top_remark</th>
                                    <th data-field="bottom_hazard" data-sortable="true">bottom_hazard</th>
                                    <th data-field="bottom_precautions" data-sortable="true">bottom_precautions</th>
                                    <th data-field="bottom_remark" data-sortable="true">bottom_remark</th>
                                    <th data-field="sign_permit_req_by" data-sortable="true">sign_permit_req_by</th>
                                    <th data-field="sop_made_approved" data-sortable="true">sop_made_approved</th>
                                    <th data-field="test_pass_certificate" data-sortable="true">test_pass_certificate</th>
                                    <th data-field="medically_fit" data-sortable="true">medically_fit</th>
                                    <th data-field="tools_condition_Certificate" data-sortable="true">tools_condition_Certificate</th>
                                    <th data-field="trained_on_sop" data-sortable="true">trained_on_sop</th>
                                    <th data-field="work_person_name" data-sortable="true">work_person_name</th>
                                    <th data-field="emp_no" data-sortable="true">emp_no</th>
                                    <th data-field="in_time" data-sortable="true">in_time</th>
                                    <th data-field="out_time" data-sortable="true">out_time</th>
                                    <th data-field="tool_box_talk" data-sortable="true">tool_box_talk</th>
                                    <th data-field="renewal1" data-sortable="true">renewal1</th>
                                    <th data-field="renewal2" data-sortable="true">renewal2</th>
                                    <th data-field="permit_receiver_sign" data-sortable="true">permit_receiver_sign</th>
                                    <th data-field="location_id" data-sortable="true">location_id</th>
                                    <th data-field="location" data-sortable="true">location</th>
                                    <th data-field="created_at" data-sortable="true">Created</th>
                                    <th data-field="updated_at" data-sortable="true">Updated</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="separator"> </div>
        </div>
    </section>
<?php } else { ?>
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view Work permit details Lists.</div>
<?php } ?>
<script>
    function queryParams_1(p) {
        return {
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>