<section class="content-header">
    <h1>Mock Drill</h1>
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
                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=mock_drill" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="operate" data-sortable='true'>Action</th>
                                        <th data-field="id" data-sortable='true'>ID No.</th>
                                        <th data-field="drill_date" data-sortable='true'>Drill Date</th>
                                        <th data-field="drill_type" data-sortable='true'>Drill Type</th>
                                        <th data-field="fire" data-sortable='true'>Fire</th>
                                        <th data-field="gas_leak" data-sortable='true'>Gas Leak</th>
                                        <th data-field="fall_down" data-sortable='true'>Fall Down</th>
                                        <th data-field="other" data-sortable='true'>Other</th>
                                        <th data-field="start_time" data-sortable='true'>Start Time</th>
                                        <th data-field="end_time" data-sortable='true'>end Time</th>
                                        <th data-field="total_time" data-sortable='true'>Total Time</th>
                                        <th data-field="alarm_worked" data-sortable='true'>alarm_worked</th>
                                        <th data-field="describe_alarm" data-sortable='true'>Describe Alarm</th>
                                        <th data-field="describe_situation" data-sortable='true'>Describe Situation</th>
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
                <div class="alert alert-danger">You have no permission to view Mock Drill.</div>
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