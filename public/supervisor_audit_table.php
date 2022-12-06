<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Training Attandance Sheet Lists /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                        <h3 class="box-title">Training Attandance Sheet Lists</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=supervisor_audit" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="department" data-sortable="true">Department</th>
                                    <th data-field="section" data-sortable="true">Section</th>
                                    <th data-field="audit_date" data-sortable="true">Audit Date</th>
                                    <th data-field="time" data-sortable="true">Time</th>
                                    <th data-field="dept_representative" data-sortable="true">Dept Representative</th>
                                    <th data-field="team_member1" data-sortable="true">Team Member 1</th>
                                    <th data-field="team_member2" data-sortable="true">Team Member 2</th>
                                    <th data-field="team_member3" data-sortable="true">Team Member 3</th>
                                    <th data-field="team_member4" data-sortable="true">Team Member 4</th>
                                    <th data-field="team_member5" data-sortable="true">Team Member 5</th>
                                    <th data-field="team_member6" data-sortable="true">Team Member 6</th>
                                    <th data-field="contract_name_vendor_code" data-sortable="true">Contractor Name Vendor Code</th>
                                    <th data-field="tot_contract_people_working" data-sortable="true">Tot Contract People Working</th>
                                    <th data-field="description" data-sortable="true">Description</th>
                                    <th data-field="good_citizen" data-sortable="true">Good Citizen</th>
                                    <th data-field="violation_no" data-sortable="true">Voilation No</th>
                                    <th data-field="severity" data-sortable="true">Severity</th>
                                    <th data-field="violation_severity" data-sortable="true">Violation Everity</th>
                                    <th data-field="potential_fatality" data-sortable="true">Potential Fatality</th>
                                    <th data-field="ua_uc" data-sortable="true">Ua Uc</th>
                                    <th data-field="violation_subtotal" data-sortable="true">Voilation Subtotal</th>
                                    <th data-field="violation_severity_subtotal" data-sortable="true">Violation Severity Subtotal</th>
                                    <th data-field="severity_index" data-sortable="true">Severity Index</th>
                                    <th data-field="checked_by" data-sortable="true">Checked by</th>
                                    <th data-field="reviewed_by" data-sortable="true">Reviewed by</th>
                                    <th data-field="doc_no" data-sortable="true">Doc No</th>
                                    <th data-field="rev" data-sortable="true">Rev</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="location_id" data-sortable="true">location id</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view ABP Lists.</div>
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