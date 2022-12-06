<section class="content-header">
    <h1>CAPA List</h1>
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
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=capa" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="operate" data-sortable='true'>Action</th>
                                        <th data-field="id" data-sortable='true'>ID No.</th>
                                        <th data-field="form_no" data-sortable='true'>Form No</th>
                                        <th data-field="format_no" data-sortable='true'>Format No</th>
                                        <th data-field="audit_date" data-sortable='true'>Audit Date</th>
                                        <th data-field="department" data-sortable='true'>Department</th>
                                        <th data-field="root_cause" data-sortable='true'>Root Cause</th>
                                        <th data-field="corrective_action" data-sortable='true'>Corrective Action</th>
                                        <th data-field="preventive_action" data-sortable='true'>Preventive Action</th>
                                        <th data-field="consequence" data-sortable='true'>Consequence</th>
                                        <th data-field="responsibility" data-sortable='true'>Responsibility</th>
                                        <th data-field="target_date" data-sortable='true'>Target Date</th>
                                        <th data-field="status" data-sortable='true'>Status</th>
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
                <div class="alert alert-danger">You have no permission to view CAPA.</div>
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