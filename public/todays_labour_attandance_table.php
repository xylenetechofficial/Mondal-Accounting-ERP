<section class="content-header">
    <h1>Today's Employees Attandance List /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    </h1>
    <!--<ol class="breadcrumb">
    <a class="btn btn-block btn-default" href="add_emp_join.php"><i class="fa fa-plus-square"></i> Join New Employee</a>
    </ol>-->
    <hr />
</section>
<!-- search form -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($permissions['customers']['read'] == 1) { ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Today's Labours Attandance List</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=todays_labour_attandance" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_1" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <!--<th data-field="operate">Action</th>-->
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="emp_id" data-sortable="true">Emp ID</th>
                                    <th data-field="emp_no" data-sortable="true">Emp No</th>
                                    <!--<th data-field="profile" data-sortable="true">Profile</th>-->
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">Mobile No</th>
                                    <th data-field="emp_designation_name" data-sortable="true">Designation</th>
                                    <th data-field="attendance" data-sortable="true">Attandance</th>
                                    <th data-field="in_time" data-sortable="true">In Time</th>
                                    <th data-field="in_time_latitude" data-sortable="true">In Time Latitude</th>
                                    <th data-field="in_time_longitude" data-sortable="true">In Time Longitude</th>
                                    <th data-field="in_time_location" data-sortable="true">In Time Location</th>
                                    <th data-field="out_time" data-sortable="true">out_time</th>
                                    <th data-field="out_time_latitude" data-sortable="true">Out Time Latitude</th>
                                    <th data-field="out_time_longitude" data-sortable="true">Out Time Longitude</th>
                                    <th data-field="out_time_location" data-sortable="true">Out Time Location</th>
                                    <th data-field="hours" data-sortable="true">Hours</th>
                                    <th data-field="tot_hours" data-sortable="true">Total Hours</th>
                                    <th data-field="ot_hours" data-sortable="true">OT Hours</th>
                                    <th data-field="created_at" data-sortable="true">Created At</th>
                                    <th data-field="updated_at" data-sortable="true">Updated At</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view Form</div>
            <?php } ?>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row (main row) -->
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($permissions['customers']['read'] == 1) { ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Today's Absent Labours List</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=todays_labour_absent_table" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_2" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <!--<th data-field="operate">Action</th>-->
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="emp_no" data-sortable="true">Emp No</th>
                                    <!--<th data-field="profile" data-sortable="true">Profile</th>-->
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">Mobile No</th>
                                    <th data-field="emp_designation_name" data-sortable="true">Designation</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view</div>
            <?php } ?>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row (main row) -->
</section>
<!-- /.content -->

<script>
    /*
    $('#filter_user').on('change', function() {
        $('#user_table').bootstrapTable('refresh');

    });
*/
    function queryParams_1(p) {
        return {
            //"filter_user": $('#filter_user').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
<script>
    function queryParams_2(p) {
        return {
            //"emp_id": $('#emp_id').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>