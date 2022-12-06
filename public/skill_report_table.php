<section class="content-header">
    <h1>Employees Information List /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1></h1>
    <hr />
</section>
<!-- search form -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($permissions['customers']['read'] == 1) { ?>
                <div class="box">
                    
                <div class="box-header">
                        <h3 class="box-title">OFI Report Lists</h3>
                        <div class="box-header with-border">
                            <form id="form" role="form" method="get" enctype="multipart/form-data" action="generate_skill_report_pdf.php">
                                <div class="form-group">
                                    
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
                                            <input type="submit" class="btn btn-primary" name="Get Skill Test Report PDF">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=skill_report" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_1" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <!--<th data-field="operate">Action</th>-->
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="emp_no" data-sortable="true">Emp No</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="emp_designation_name" data-sortable="true">Designation</th>
                                    <th data-field="qualification" data-sortable="true">Qualification</th>
                                    <th data-field="date" data-sortable="true">DOJ</th>
                                    <th data-field="emp_skills" data-sortable="true">Category</th>
                                    <th data-field="experience" data-sortable="true">Experience</th>
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