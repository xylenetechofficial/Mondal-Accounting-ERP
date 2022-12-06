<section class="content-header">
    <h1>PPES data</h1>
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
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=ppe_data" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="operate" data-sortable='true'>Action</th>
                                        <th data-field="id" data-sortable='true'>ID.</th>
                                        <th data-field="doc_no" data-sortable='true'>doc_no.</th>
                                        <th data-field="rev" data-sortable='true'>rev</th>
                                        <th data-field="effective_date" data-sortable='true'>effective_date</th>
                                        <th data-field="month" data-sortable='true'>month</th>
                                        <th data-field="emp_name" data-sortable='true'>emp_name</th>
                                        <th data-field="emp_code" data-sortable='true'>emp_code</th>
                                        <th data-field="designation" data-sortable='true'>designation.</th>
                                        <th data-field="helmet" data-sortable='true'>helmet</th>
                                        <th data-field="safty_shoes" data-sortable='true'>safty_shoes</th>
                                        <th data-field="visibility_vest" data-sortable='true'>visibility_vest</th>
                                        <th data-field="safty_glases" data-sortable='true'>safty_glases</th>
                                        <th data-field="hand_gloves" data-sortable='true'>hand_gloves</th>
                                        <th data-field="face_shield" data-sortable='true'>face_shield.</th>
                                        <th data-field="ear_plugs" data-sortable='true'>ear_plugs</th>
                                        <th data-field="shin_guards" data-sortable='true'>shin_guards</th>
                                        <th data-field="dust_mask" data-sortable='true'>dust_mask</th>
                                        <th data-field="hand_sleeves" data-sortable='true'>hand_sleeves</th>
                                        <th data-field="leather_appron" data-sortable='true'>leather_appron</th>
                                        <th data-field="remarks" data-sortable='true'>remarks.</th>
                                        <th data-field="checked_by" data-sortable='true'>checked_by</th>
                                        <th data-field="reviewed_by" data-sortable='true'>reviewed_by</th>
                                        <th data-field="date" data-sortable='true'>date</th>
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
                <div class="alert alert-danger">You have no permission to view PPES data.</div>
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