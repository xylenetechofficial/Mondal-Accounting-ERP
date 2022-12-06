<section class="content-header">
    <h1>Work permit Hot Job</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>

<!-- search form -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <?php if ($permissions['reports']['read'] == 1) { ?>
                <div class="box box-info">
                    
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=hot_job" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="operate" data-sortable='true'>Action</th>
                                        <th data-field="doc_no" data-sortable='true'>doc_no.</th>
                                        <th data-field="rev" data-sortable='true'>rev</th>
                                        <th data-field="effective_date" data-sortable='true'>effective_date</th>
                                        <th data-field="si_no" data-sortable='true'>si_no</th>
                                        <th data-field="date" data-sortable='true'>date</th>
                                        <th data-field="clearance_time_from" data-sortable='true'>clearance_time_from</th>
                                        <th data-field="clearance_time_to" data-sortable='true'>clearance_time_to.</th>
                                        <th data-field="clearance_date" data-sortable='true'>clearance_date</th>
                                        <th data-field="permission_given_to" data-sortable='true'>permission_given_to</th>
                                        <th data-field="designation" data-sortable='true'>designation</th>
                                        <th data-field="department" data-sortable='true'>department</th>
                                        <th data-field="to_take_job" data-sortable='true'>to_take_job</th>
                                        <th data-field="section_or_location" data-sortable='true'>section_or_location.</th>
                                        <th data-field="job_description" data-sortable='true'>job_description</th>
                                        <th data-field="check_points" data-sortable='true'>check_points</th>
                                        <th data-field="marking" data-sortable='true'>marking</th>
                                        <th data-field="reason_for_no" data-sortable='true'>reason_for_no</th>
                                        <th data-field="executing_signature" data-sortable='true'>executing_signature</th>
                                        <th data-field="executing_agency" data-sortable='true'>executing_agency.</th>
                                        <th data-field="executing_name" data-sortable='true'>executing_name</th>
                                        <th data-field="executing_designation" data-sortable='true'>executing_designation</th>
                                        <th data-field="executing_department" data-sortable='true'>executing_department</th>
                                        <th data-field="executing_date" data-sortable='true'>executing_date</th>
                                        <th data-field="executing_time" data-sortable='true'>executing_time</th>
                                        <th data-field="issuer_signature" data-sortable='true'>issuer_signature.</th>
                                        <th data-field="issuer_name" data-sortable='true'>issuer_name</th>
                                        <th data-field="issuer_designation" data-sortable='true'>issuer_designation</th>
                                        <th data-field="issuer_department" data-sortable='true'>issuer_department</th>
                                        <th data-field="issuer_date" data-sortable='true'>issuer_date</th>
                                        <th data-field="issuer_time" data-sortable='true'>issuer_time</th>
                                        <th data-field="approver_signature" data-sortable='true'>approver_signature.</th>
                                        <th data-field="approver_name" data-sortable='true'>approver_name</th>
                                        <th data-field="approver_designation" data-sortable='true'>approver_designation</th>
                                        <th data-field="approver_department" data-sortable='true'>approver_department</th>
                                        <th data-field="approver_date" data-sortable='true'>approver_date</th>
                                        <th data-field="approver_time" data-sortable='true'>approver_time</th>
                                        <th data-field="return_undertaking_to" data-sortable='true'>return_undertaking_to.</th>
                                        <th data-field="return_undertaking_job_descript" data-sortable='true'>return_undertaking_job_descript</th>
                                        <th data-field="return_undertaking_designation" data-sortable='true'>return_undertaking_designation</th>
                                        <th data-field="return_undertaking_department" data-sortable='true'>return_undertaking_department</th>
                                        <th data-field="work_agency_date" data-sortable='true'>work_agency_date</th>
                                        <th data-field="work_agency_sign" data-sortable='true'>work_agency_sign</th>
                                        <th data-field="work_agency_time" data-sortable='true'>work_agency_time.</th>
                                        <th data-field="work_agency_name" data-sortable='true'>work_agency_name</th>
                                        <th data-field="work_agency_designation" data-sortable='true'>work_agency_designation</th>
                                        <th data-field="work_agency_department" data-sortable='true'>work_agency_department</th>
                                        <th data-field="location_id" data-sortable='true'>location_id</th>
                                        <th data-field="location" data-sortable='true'>Location</th>
                                        <th data-field="created_at" data-sortable='true'>Created At</th>
                                        <th data-field="updated_at" data-sortable='true'>Updated At</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view Work permit Hot Job.</div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- /.content -->
<script>
    function queryParams(p) {
        return {
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
<?php
$db->disconnect();
?>