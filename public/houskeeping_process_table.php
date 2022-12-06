<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Houskeeping Process list /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    <!--<ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-feedback-statement.php"><i class="fa fa-plus-square"></i> Add Feedback Statement</a>
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
                        <h3 class="box-title">Houskeeping Process list</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=houskeeping_process" data-page-list="[5tools_checklist 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="contractor_name" data-sortable="true">contractor_name</th>
                                    <th data-field="section" data-sortable="true">section</th>
                                    <th data-field="department" data-sortable="true">department</th>
                                    <th data-field="date" data-sortable="true">date</th>
                                    <th data-field="review_subject" data-sortable="true">review_subject</th>
                                    <th data-field="satisfactory_yes" data-sortable="true">satisfactory_yes</th>
                                    <th data-field="mom_satisfactory_no" data-sortable="true">mom_satisfactory_no</th>
                                    <th data-field="remark" data-sortable="true">remark</th>
                                    <th data-field="action" data-sortable="true">action</th>
                                    <th data-field="additional_remark" data-sortable="true">additional_remark</th>
                                    <th data-field="inspected_by" data-sortable="true">inspected_by</th>
                                    <th data-field="verify_by" data-sortable="true">verify_by</th>
                                    <th data-field="location_id" data-sortable="true">location_id</th>
                                    <th data-field="location" data-sortable="true">Location</th>
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
<?php } else { ?>
    <div class="alert alert-danger topmargin-sm" style="margin-top: 20px;">You have no permission to view Houskeeping Process list.</div>
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