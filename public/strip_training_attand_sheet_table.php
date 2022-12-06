<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Strip Training Attendance /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                        <h3 class="box-title">Strip Training Attendance</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=strip_training_attand_sheet" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="format_no" data-sortable="true">format_no</th>
                                    <th data-field="form_no" data-sortable="true">form_no</th>
                                    <th data-field="page" data-sortable="true">page</th>
                                    <th data-field="training_course" data-sortable="true">training_course</th>
                                    <th data-field="trainer_name" data-sortable="true">trainer_name</th>
                                    <th data-field="description" data-sortable="true">description</th>
                                    <th data-field="date" data-sortable="true">date</th>
                                    <th data-field="trainer_signature" data-sortable="true">trainer_signature</th>
                                    <th data-field="emp_id" data-sortable="true">emp_id</th>
                                    <th data-field="emp_no" data-sortable="true">emp_no</th>
                                    <th data-field="emp_name" data-sortable="true">emp_name</th>
                                    <th data-field="emp_sign" data-sortable="true">emp_sign</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view Strip Training Attendance.</div>
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