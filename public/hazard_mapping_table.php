<section class="content-header">
    <h1>Hazards Mapping</h1>
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
                    
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=hazard_mapping" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <!--<th data-field="operate" data-sortable='true'>Action</th>-->
                                        <th data-field="task" data-sortable='true'>task.</th>
                                        <th data-field="risk" data-sortable='true'>risk</th>
                                        <th data-field="initial_nce" data-sortable='true'>initial_nce</th>
                                        <th data-field="initial_liklihood" data-sortable='true'>initial_liklihood</th>
                                        <th data-field="initial_rating" data-sortable='true'>initial_rating</th>
                                        <th data-field="proposed_control" data-sortable='true'>proposed_control</th>
                                        <th data-field="residual_nce" data-sortable='true'>residual_nce.</th>
                                        <th data-field="residual_liklihood" data-sortable='true'>residual_liklihood</th>
                                        <th data-field="residual_rating" data-sortable='true'>residual_rating</th>
                                        <th data-field="action_by" data-sortable='true'>action_by</th>
                                        <th data-field="action_date" data-sortable='true'>action_date</th>
                                        <th data-field="completed_by" data-sortable='true'>completed_by</th>
                                        <th data-field="completed_date" data-sortable='true'>completed_date.</th>
                                        <th data-field="location_id" data-sortable='true'>location_id</th>
                                        <th data-field="location" data-sortable='true'>location</th>
                                        <th data-field="created_at" data-sortable='true'>created_at</th>
                                        <th data-field="updated_at" data-sortable='true'>updated_at</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view Hazards Mapping.</div>
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