<?php
include_once('includes/functions.php');
?>
<section class="content-header">
    <h1>Houskeeping checklist & s 5 audit list /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
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
                        <h3 class="box-title">Houskeeping checklist & s 5 audit list</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" id="cateory_list" data-url="api-firebase/get-bootstrap-table-data.php?table=houskeeping_checklist" data-page-list="[5tools_checklist 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-query-params="queryParams_1">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="form_no" data-sortable="true">form_no</th>
                                    <th data-field="format_no" data-sortable="true">format_no</th>
                                    <th data-field="audit_name" data-sortable="true">audit_name</th>
                                    <th data-field="audit_date" data-sortable="true">audit_date</th>
                                    <th data-field="member_present" data-sortable="true">member_present</th>
                                    <th data-field="area" data-sortable="true">area</th>
                                    <th data-field="check_point_type1" data-sortable="true">check_point_type1</th>
                                    <th data-field="check_point_action1" data-sortable="true">check_point_action1</th>
                                    <th data-field="check_point_type2" data-sortable="true">check_point_type2</th>
                                    <th data-field="check_point_action2" data-sortable="true">check_point_action2</th>
                                    <th data-field="check_point_type3" data-sortable="true">check_point_type3</th>
                                    <th data-field="check_point_action3" data-sortable="true">check_point_action3</th>
                                    <th data-field="check_point_type4" data-sortable="true">check_point_type4</th>
                                    <th data-field="check_point_action4" data-sortable="true">check_point_action4</th>
                                    <th data-field="check_point_type5" data-sortable="true">check_point_type5</th>
                                    <th data-field="check_point_action5" data-sortable="true">check_point_action5</th>
                                    <th data-field="check_point_type6" data-sortable="true">check_point_type6</th>
                                    <th data-field="check_point_action6" data-sortable="true">check_point_action6</th>
                                    <th data-field="check_point_type7" data-sortable="true">check_point_type7</th>
                                    <th data-field="check_point_action7" data-sortable="true">check_point_action7</th>
                                    <th data-field="check_point_type8" data-sortable="true">check_point_type8</th>
                                    <th data-field="check_point_action8" data-sortable="true">check_point_action8</th>
                                    <th data-field="check_point_type9" data-sortable="true">check_point_type9</th>
                                    <th data-field="check_point_action9" data-sortable="true">check_point_action9</th>
                                    <th data-field="check_point_type10" data-sortable="true">check_point_type10</th>
                                    <th data-field="check_point_action10" data-sortable="true">check_point_action10</th>
                                    <th data-field="check_point_type11" data-sortable="true">check_point_type11</th>
                                    <th data-field="check_point_action11" data-sortable="true">check_point_action11</th>
                                    <th data-field="check_point_type12" data-sortable="true">check_point_type12</th>
                                    <th data-field="check_point_action12" data-sortable="true">check_point_action12</th>
                                    <th data-field="check_point_type13" data-sortable="true">check_point_type13</th>
                                    <th data-field="check_point_action13" data-sortable="true">check_point_action13</th>
                                    <th data-field="check_point_type14" data-sortable="true">check_point_type14</th>
                                    <th data-field="check_point_action14" data-sortable="true">check_point_action14</th>
                                    <th data-field="check_point_type15" data-sortable="true">check_point_type15</th>
                                    <th data-field="check_point_action15" data-sortable="true">check_point_action15</th>
                                    <th data-field="check_point_type16" data-sortable="true">check_point_type16</th>
                                    <th data-field="check_point_action16" data-sortable="true">check_point_action16</th>
                                    <th data-field="check_point_type17" data-sortable="true">check_point_type17</th>
                                    <th data-field="check_point_action17" data-sortable="true">check_point_action17</th>
                                    <th data-field="check_point_type18" data-sortable="true">check_point_type18</th>
                                    <th data-field="check_point_action18" data-sortable="true">check_point_action18</th>
                                    <th data-field="check_point_type19" data-sortable="true">check_point_type19</th>
                                    <th data-field="check_point_action19" data-sortable="true">check_point_action19</th>
                                    <th data-field="check_point_type20" data-sortable="true">check_point_type20</th>
                                    <th data-field="check_point_action20" data-sortable="true">check_point_action20</th>
                                    <th data-field="check_point_type21" data-sortable="true">check_point_type21</th>
                                    <th data-field="check_point_action21" data-sortable="true">check_point_action21</th>
                                    <th data-field="check_point_type22" data-sortable="true">check_point_type22</th>
                                    <th data-field="check_point_action22" data-sortable="true">check_point_action22</th>
                                    <th data-field="check_point_type23" data-sortable="true">check_point_type23</th>
                                    <th data-field="check_point_action23" data-sortable="true">check_point_action23</th>
                                    <th data-field="check_point_type24" data-sortable="true">check_point_type24</th>
                                    <th data-field="check_point_action24" data-sortable="true">check_point_action24</th>
                                    <th data-field="check_point_type25" data-sortable="true">check_point_type25</th>
                                    <th data-field="check_point_action25" data-sortable="true">check_point_action25</th>
                                    <th data-field="audit_member_sign" data-sortable="true">audit_member_sign</th>
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