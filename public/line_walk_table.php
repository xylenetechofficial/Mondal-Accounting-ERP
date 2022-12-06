<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Line Walk Lists /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                        <h3 class="box-title">Line Walk Lists</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=line_walk" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="doc_no" data-sortable="true">Doc No</th>
                                    <th data-field="rev" data-sortable="true">Rev</th>
                                    <th data-field="date" data-sortable="true">Date</th>
                                    <th data-field="line_walk_date" data-sortable="true">Line Walk Date</th>
                                    <th data-field="location" data-sortable="true">Location</th>
                                    <th data-field="department" data-sortable="true">Department</th>
                                    <th data-field="present" data-sortable="true">Present</th>
                                    <th data-field="line_manager" data-sortable="true">Line Manager</th>
                                    <th data-field="chaired_by" data-sortable="true">Chaired By</th>
                                    <th data-field="observation" data-sortable="true">Observation</th>
                                    <th data-field="action" data-sortable="true">Action</th>
                                    <th data-field="image" data-sortable="true">Image</th>
                                    <th data-field="created_at" data-sortable="true">Created At</th>
                                    <th data-field="updated_at" data-sortable="true">updated At</th>
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
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view Line Walk Lists.</div>
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