<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Training Calendar Lists /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                        <h3 class="box-title">Training Calendar Lists</h3>
                        <div class="box-header with-border">
                            <form id="form" role="form" method="get" enctype="multipart/form-data" action="generate_training_calendar_pdf.php">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="salyear" name="salyear" readonly>
                                    <!--<input type="hidden" class="form-control" id="salmonth" name="salmonth" readonly>
                                    <label for="from" class="control-label col-md-2 col-sm-3 col-xs-12">From & To Date</label>-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Doc No.</label><?php echo isset($error['doc_no']) ? $error['doc_no'] : ''; ?>
                                            <input type="text" class="form-control" name="doc_no" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Rev No.</label><?php echo isset($error['rev_no']) ? $error['rev_no'] : ''; ?>
                                            <input type="text" class="form-control" name="rev_no" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Date</label><?php echo isset($error['date']) ? $error['date'] : ''; ?>
                                            <input type="date" class="form-control" name="date" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <select class="form-control" id="year" name="year" onchange="updateqty()">
                                            <option value="">--Select Year--</option>
                                            <?php

                                            for ($i = date('Y'); $i >= 2015; $i--) {
                                                echo "<option value=" . $i . ">" . $i . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="location_id" name="location_id" onchange="updateqty()" required>
                                            <option value="">--Select Location--</option>
                                            <?php
                                            $sql = "SELECT * FROM `location`";
                                            $db->sql($sql);
                                            $res = $db->getResult();
                                            foreach ($res as $location) {
                                                echo "<option value='" . $location['id'] . "'>" . $location['location_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" name="Get This Year PDF">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=training_calendar" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <!--<th data-field="operate">Action</th>-->
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="topic" data-sortable="true">Topic</th>
                                    <th data-field="jan_plan_date" data-sortable="true">Jan Plan Date</th>
                                    <th data-field="jan_actual_date" data-sortable="true">Jan Actual Date</th>
                                    <th data-field="feb_plan_date" data-sortable="true">Feb Plan Date</th>
                                    <th data-field="feb_actual_date" data-sortable="true">Feb Actual Date</th>
                                    <th data-field="mar_plan_date" data-sortable="true">Mar Plan Date</th>
                                    <th data-field="mar_actual_date" data-sortable="true">Mar Actual Date</th>
                                    <th data-field="apr_plan_date" data-sortable="true">Apr Plan Date</th>
                                    <th data-field="apr_actual_date" data-sortable="true">Apr Actual Date</th>
                                    <th data-field="may_plan_date" data-sortable="true">May Plan Date</th>
                                    <th data-field="may_actual_date" data-sortable="true">May Actual Date</th>
                                    <th data-field="jun_plan_date" data-sortable="true">Jun Plan Date</th>
                                    <th data-field="jun_actual_date" data-sortable="true">Jun Actual Date</th>
                                    <th data-field="jul_plan_date" data-sortable="true">Jul Plan Date</th>
                                    <th data-field="jul_actual_date" data-sortable="true">Jul Actual Date</th>
                                    <th data-field="aug_plan_date" data-sortable="true">Aug Plan Date</th>
                                    <th data-field="aug_actual_date" data-sortable="true">Aug Actual Date</th>
                                    <th data-field="sep_plan_date" data-sortable="true">Sep Plan Date</th>
                                    <th data-field="sep_actual_date" data-sortable="true">Sep Actual Date</th>
                                    <th data-field="oct_plan_date" data-sortable="true">Oct Plan Date</th>
                                    <th data-field="oct_actual_date" data-sortable="true">Oct Actual Date</th>
                                    <th data-field="nov_plan_date" data-sortable="true">Nov Plan Date</th>
                                    <th data-field="nov_actual_date" data-sortable="true">Nov Actual Date</th>
                                    <th data-field="dec_plan_date" data-sortable="true">Dec Plan Date</th>
                                    <th data-field="dec_actual_date" data-sortable="true">Dec Actual Date</th>
                                    <th data-field="year" data-sortable="true">Year</th>
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