<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Mass Meeting Attendance /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    <!--<ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-feedback-statement.php"><i class="fa fa-plus-square"></i> Add Feedback Statement</a>
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
                        <h3 class="box-title">Mass Meeting Attendance</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=tool_box_meeting" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="authorised_by" data-sortable="true">Authorised By</th>
                                    <th data-field="issue_no" data-sortable="true">Issue No</th>
                                    <th data-field="date1" data-sortable="true">Date1</th>
                                    <th data-field="form_no" data-sortable="true">Form No</th>
                                    <th data-field="page" data-sortable="true">Page</th>
                                    <th data-field="revision" data-sortable="true">Revision</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="effective_date" data-sortable="true">Effective Date</th>
                                    <th data-field="project_name" data-sortable="true">Project Name</th>
                                    <th data-field="project_date" data-sortable="true">Project Date</th>
                                    <th data-field="location" data-sortable="true">Location</th>
                                    <th data-field="time" data-sortable="true">Time</th>
                                    <th data-field="topic" data-sortable="true">Topic</th>
                                    <th data-field="conducted_by" data-sortable="true">Conducted By</th>
                                    <th data-field="tot_no" data-sortable="true">Tot No</th>
                                    <th data-field="emp_id" data-sortable="true">Emp Id</th>
                                    <th data-field="emp_no" data-sortable="true">Emp No</th>
                                    <th data-field="emp_name" data-sortable="true">Emp Name</th>
                                    <th data-field="emp_designation" data-sortable="true">Designation</th>
                                    <th data-field="attendance" data-sortable="true">Attendance</th>
                                    <th data-field="signature" data-sortable="true">Signature</th>
                                    <th data-field="doc_no" data-sortable="true">Doc No</th>
                                    <th data-field="rev" data-sortable="true">Rev</th>
                                    <th data-field="created_at" data-sortable="true">Created At</th>
                                    <th data-field="updated_at" data-sortable="true">Updated At</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view Mass Meeting Attendance.</div>
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