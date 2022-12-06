<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Performance Report Lists /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                        <h3 class="box-title">Performance Report Lists</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=performance_report" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="report_from" data-sortable="true">From</th>
                                    <th data-field="report_to" data-sortable="true">To</th>
                                    <th data-field="month_from" data-sortable="true">Month_From</th>
                                    <th data-field="month_to" data-sortable="true">Month_To</th>
                                    <th data-field="objective" data-sortable="true">Objective</th>
                                    <th data-field="department" data-sortable="true">Department</th>
                                    <th data-field="past_perform" data-sortable="true">Past Perform</th>
                                    <th data-field="forecast_perform" data-sortable="true">Forecast Perform</th>
                                    <th data-field="actual_perform" data-sortable="true">Actual Perform</th>
                                    <th data-field="line_of_improve" data-sortable="true">Line of Improve</th>
                                    <th data-field="action_taken" data-sortable="true">Action Taken</th>
                                    <th data-field="doc_no" data-sortable="true">Doc No</th>
                                    <th data-field="rev_no" data-sortable="true">Rev No</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="location_id" data-sortable="true">Location Id</th>
                                    <th data-field="location" data-sortable="true">Location</th>
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