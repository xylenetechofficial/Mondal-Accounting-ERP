<section class="content-header">
    <h1>Today's Employees Birthday List /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1></h1>
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
                        <h3 class="box-title">Today's Employees Birthday</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=get_emp_birthday" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_1" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="emp_no" data-sortable="true">Emp No</th>
                                    <th data-field="profile" data-sortable="true">Profile</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="father_name" data-sortable="true">Father Name</th>
                                    <th data-field="dob" data-sortable="true">DOB</th>
                                    <th data-field="age" data-sortable="true">Age</th>
                                    <th data-field="blood_group" data-sortable="true">Blood Group</th>
                                    <th data-field="mobile" data-sortable="true">Mobile</th>
                                    <th data-field="alt_mobile" data-sortable="true">Alt Mobile</th>
                                    <th data-field="marital_status" data-sortable="true">Marital Status</th>
                                    <th data-field="qualification" data-sortable="true">Qualification</th>
                                    <th data-field="experience" data-sortable="true">Experience</th>
                                    <th data-field="aadhar_no" data-sortable="true">Aadhar No</th>
                                    <th data-field="pan_no" data-sortable="true">Pan No</th>
                                    <th data-field="esic_no" data-sortable="true">ESIC No</th>
                                    <th data-field="uan_no" data-sortable="true">UAN No</th>
                                    <th data-field="identification_mark" data-sortable="true">Identification Mark</th>
                                    <th data-field="permanant_address" data-sortable="true">Permanant Address</th>
                                    <th data-field="present_address" data-sortable="true">Present Address</th>
                                    <th data-field="bank_name" data-sortable="true">Bank Name</th>
                                    <th data-field="acc_holder_name" data-sortable="true">Acc Holder Name</th>
                                    <th data-field="acc_no" data-sortable="true">Acc No</th>
                                    <th data-field="ifsc_code" data-sortable="true">IFSC Code</th>
                                    <th data-field="place" data-sortable="true">Place</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="emp_post" data-sortable="true">Emp Post</th>
                                    <th data-field="salary" data-sortable="true">Salary</th>
                                    <th data-field="spl_allowance" data-sortable="true">Spl Allowance</th>
                                    <th data-field="signature" data-sortable="true">Signature</th>
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
    
    <div class="modal fade" id="ViewEmpFamily" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">View Address Table</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="emp_id" id="emp_id" value="">
                    <table class="table table-hover" id="family_table" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=family" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-filter-show-clear="true" data-query-params="queryParams_2" data-sort-name="id" data-sort-order="desc">
                        <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="emp_id">Emp ID</th>
                                <th data-field="family_name" data-visible="true">Family Person Name</th>
                                <th data-field="family_age" data-visible="true">Family Person Age</th>
                                <th data-field="family_relation">Family Person Relation</th>
                                <th data-field="family_remark" data-sortable="true">Remark</th>
                                <th data-field="created_at" data-visible="true">Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

<script>
    $('#filter_user').on('change', function() {
        $('#user_table').bootstrapTable('refresh');

    });

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
    var emp_id = "";
    $(document).on("click", '.view-emp-family', function() {
        emp_id = $(this).data("id");
        $('#emp_id').val(emp_id);
        $('#family_table').bootstrapTable('refresh');
    });

    function queryParams_2(p) {
        return {
            "emp_id": $('#emp_id').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>