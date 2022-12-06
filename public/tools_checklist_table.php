<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Tools checklist report list /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                    <h3 class="box-title">Tools checklist report list</h3>
                        <div class="box-header with-border">
                            <form id="form" role="form" method="get" enctype="multipart/form-data" action="create-tools-checklist-report-pdf.php">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="salyear" name="salyear" readonly>
                                    <!--<input type="hidden" class="form-control" id="salmonth" name="salmonth" readonly>
                                    <label for="from" class="control-label col-md-2 col-sm-3 col-xs-12">From & To Date</label>-->

                                    <div class="col-md-4">
                                        <select class="form-control" id="month" name="month" onchange="updateqty()">
                                            <option value="">--Select Month--</option>
                                            <option value="january">January</option>
                                            <option value="february">February</option>
                                            <option value="march">March</option>
                                            <option value="april">April</option>
                                            <option value="may">May</option>
                                            <option value="june">June</option>
                                            <option value="july">July</option>
                                            <option value="august">August</option>
                                            <option value="september">September</option>
                                            <option value="october">October</option>
                                            <option value="november">November</option>
                                            <option value="december">December</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="year" name="year" onchange="updateqty()">
                                            <option value="">--Select Year--</option>
                                            <?php

                                            for ($i = date('Y'); $i >= 2015; $i--) {
                                                echo "<option value=" . $i . ">" . $i . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
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
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=tools_checklist" data-page-list="[5tools_checklist 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <!--<th data-field="operate">Action</th>-->
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="tool_list" data-sortable="true">tool_list</th>
                                    <th data-field="inspection_date" data-sortable="true">inspection_date</th>
                                    <th data-field="due_date" data-sortable="true">due_date</th>
                                    <th data-field="remark" data-sortable="true">remark</th>
                                    <th data-field="location_id" data-sortable="true">location_id</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view Tools checklist report list.</div>
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