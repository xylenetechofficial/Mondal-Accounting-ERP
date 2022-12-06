<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Locations /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add_location.php"><i class="fa fa-plus-square"></i> Add New Location</a>
    </ol>
</section>
<?php
if ($permissions['locations']['read'] == 1) {
?>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                    </div>
                    <div class="box-header">
                        <h3 class="box-title">Location</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="location_list" data-url="api-firebase/get-bootstrap-table-data.php?table=location" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="city_name" data-sortable="true">City Name</th>
                                    <th data-field="location_name" data-sortable="true">Location Name</th>
                                    <th data-field="state_name" data-sortable="true">State Name</th>
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
<?php } else { ?>
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view Locations.</div>
<?php } ?>