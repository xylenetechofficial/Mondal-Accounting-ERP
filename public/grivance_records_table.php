<section class="content-header">
    <h1>Grivance record system</h1>
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

                    <div class="box-header">
                        <h3 class="box-title">Training Calendar Lists</h3>
                        <div class="box-header with-border">
                            <form id="form" role="form" method="get" enctype="multipart/form-data" action="create_grivance_records_pdf.php">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="salyear" name="salyear" readonly>
                                    <!--<input type="hidden" class="form-control" id="salmonth" name="salmonth" readonly>
                                    <label for="from" class="control-label col-md-2 col-sm-3 col-xs-12">From & To Date</label>-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Format No.</label><?php echo isset($error['fromat_no']) ? $error['fromat_no'] : ''; ?>
                                            <input type="text" class="form-control" name="fromat_no" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">Select Year</label><?php echo isset($error['year']) ? $error['year'] : ''; ?>
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
                                        <label for="exampleInputEmail1">Select Location</label><?php echo isset($error['location_id']) ? $error['location_id'] : ''; ?>
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

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=grivance_records" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <!--<th data-field="operate" data-sortable='true'>Action</th>-->
                                        <th data-field="id" data-sortable='true'>ID</th>
                                        <th data-field="grivance_open" data-sortable='true'>grivance_open.</th>
                                        <th data-field="grivance_close" data-sortable='true'>grivance_close</th>
                                        <th data-field="month" data-sortable='true'>month</th>
                                        <th data-field="year" data-sortable='true'>year</th>
                                        <th data-field="date" data-sortable='true'>date</th>
                                        <th data-field="prepared_by_name" data-sortable='true'>prepared_by_name</th>
                                        <th data-field="prepared_by_sign" data-sortable='true'>prepared_by_sign.</th>
                                        <th data-field="checked_by_name" data-sortable='true'>checked_by_name</th>
                                        <th data-field="checked_by_sign" data-sortable='true'>checked_by_sign</th>
                                        <th data-field="location_id" data-sortable='true'>location_id</th>
                                        <th data-field="location" data-sortable='true'>location.</th>
                                        <th data-field="created_at" data-sortable='true'>created_at</th>
                                        <th data-field="updated_at" data-sortable='true'>updated_at</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view Grivance record system.</div>
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