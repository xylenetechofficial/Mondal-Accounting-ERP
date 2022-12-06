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
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=hazard" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="operate" data-sortable='true'>Action</th>
                                        <th data-field="assesment_no" data-sortable='true'>assesment_no.</th>
                                        <th data-field="company_name" data-sortable='true'>company_name</th>
                                        <th data-field="site_area" data-sortable='true'>site_area</th>
                                        <th data-field="revision" data-sortable='true'>revision</th>
                                        <th data-field="prepared_by" data-sortable='true'>prepared_by</th>
                                        <th data-field="date1" data-sortable='true'>date1</th>
                                        <th data-field="sign1" data-sortable='true'>sign1.</th>
                                        <th data-field="dept" data-sortable='true'>dept</th>
                                        <th data-field="date2" data-sortable='true'>date2</th>
                                        <th data-field="sign2" data-sortable='true'>sign2</th>
                                        <th data-field="scope" data-sortable='true'>scope</th>
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