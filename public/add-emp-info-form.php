<section class="content-header">
    <h1>Customers Enquiry</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<!-- search form -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($permissions['customers']['read'] == 1) { ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Customers Enquiry</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=test_form" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <!---<th data-field="user_id" data-sortable="true">User Id</th>-->
                                    <th data-field="name" data-sortable="true">Customer Name</th>
                                    <th data-field="email" data-sortable="true">Customer Email</th>
                                    <th data-field="mobile" data-sortable="true">Customer Mobile</th>
                                    <th data-field="age" data-sortable="true">Age</th>
                                    <th data-field="weight" data-sortable="true">Weight</th>
                                    <th data-field="height" data-sortable="true">Height</th>
                                    <th data-field="address" data-sortable="true">Address</th>
                                    <th data-field="qualification" data-sortable="true">Qualification</th>
                                    <th data-field="gender" data-sortable="true">Gender</th>
                                    <th data-field="created_at" data-sortable="true">Created At</th>
                                    
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
<!-- /.content -->