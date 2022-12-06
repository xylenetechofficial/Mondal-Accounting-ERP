<section class="content-header">
    <h1>Working At Height</h1>
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
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=working_at_height" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="operate" data-sortable='true'>Action</th>
                                        <th data-field="doc_no" data-sortable='true'>doc_no.</th>
                                        <th data-field="ref_no" data-sortable='true'>ref_no</th>
                                        <th data-field="rev" data-sortable='true'>rev</th>
                                        <th data-field="si_no" data-sortable='true'>si_no</th>
                                        <th data-field="effective_date" data-sortable='true'>effective_date</th>
                                        <th data-field="date" data-sortable='true'>date</th>
                                        <th data-field="agency_name" data-sortable='true'>agency_name.</th>
                                        <th data-field="exact_location" data-sortable='true'>exact_location</th>
                                        <th data-field="job_description" data-sortable='true'>job_description</th>
                                        <th data-field="duration_time_from" data-sortable='true'>duration_time_from</th>
                                        <th data-field="duration_time_to" data-sortable='true'>duration_time_to</th>
                                        <th data-field="commencement_date" data-sortable='true'>commencement_date</th>
                                        <th data-field="check_points" data-sortable='true'>check_points.</th>
                                        <th data-field="marking" data-sortable='true'>marking</th>
                                        <th data-field="site_engg_name" data-sortable='true'>site_engg_name</th>
                                        <th data-field="site_engg_sign" data-sortable='true'>site_engg_sign</th>
                                        <th data-field="site_engg_date" data-sortable='true'>site_engg_date</th>
                                        <th data-field="mandal_engg_name" data-sortable='true'>mandal_engg_name</th>
                                        <th data-field="mandal_engg_sign" data-sortable='true'>mandal_engg_sign.</th>
                                        <th data-field="mandal_engg_date" data-sortable='true'>mandal_engg_date</th>
                                        <th data-field="hod_sign" data-sortable='true'>hod_sign</th>
                                        <th data-field="location_id" data-sortable='true'>location_id</th>
                                        <th data-field="location" data-sortable='true'>Location</th>
                                        <th data-field="created_at" data-sortable='true'>Created At</th>
                                        <th data-field="updated_at" data-sortable='true'>Updated At</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view Working At Height.</div>
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