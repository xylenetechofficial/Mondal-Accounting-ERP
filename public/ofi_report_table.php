<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>OFI Report Lists /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                        <h3 class="box-title">OFI Report Lists</h3>
                        <div class="box-header with-border">
                            <form id="form" role="form" method="get" enctype="multipart/form-data" action="generate_ofi_report_pdf.php">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="salyear" name="salyear" readonly>
                                    <!--<input type="hidden" class="form-control" id="salmonth" name="salmonth" readonly>
                                    <label for="from" class="control-label col-md-2 col-sm-3 col-xs-12">From & To Date</label>-->

                                    <div class="col-md-5">
                                        <select class="form-control" id="year" name="year" onchange="updateqty()">
                                            <option value="">--Select Year--</option>
                                            <?php

                                            for ($i = date('Y'); $i >= 2015; $i--) {
                                                echo "<option value=" . $i . ">" . $i . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
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
                                    <div class="col-md-2">
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" name="Get This Year PDF">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=ofi_report" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <!--<th data-field="operate">Action</th>-->
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="department" data-sortable="true">Department</th>
                                    <th data-field="document" data-sortable="true">Document</th>
                                    <th data-field="pl1" data-sortable="true">pl1</th>
                                    <th data-field="pl2" data-sortable="true">pl2</th>
                                    <th data-field="pl3" data-sortable="true">pl3</th>
                                    <th data-field="pl4" data-sortable="true">pl4</th>
                                    <th data-field="co1" data-sortable="true">co1</th>
                                    <th data-field="co2" data-sortable="true">co2</th>
                                    <th data-field="co3" data-sortable="true">co3</th>
                                    <th data-field="co4" data-sortable="true">co4</th>
                                    <th data-field="cl1" data-sortable="true">cl1</th>
                                    <th data-field="cl2" data-sortable="true">cl2</th>
                                    <th data-field="cl3" data-sortable="true">cl3</th>
                                    <th data-field="cl4" data-sortable="true">cl4</th>
                                    <th data-field="doc_no" data-sortable="true">Doc No</th>
                                    <th data-field="rev_no" data-sortable="true">Rev No</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="location_id" data-sortable="true">Location id</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view OFI Report Lists.</div>
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
<!--<script>
    
    function queryParams_1(p) {
        return {
            //"month": $('#salmonth').val(),
            //"year": $('#salyear').val(),
            //"filter_order": $('#filter_order_status').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>-->