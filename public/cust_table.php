<section class="content-header">
    <h1>Customers List</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<style>
    .btn {
        padding: 9px 12px;
        line-height: 0.42857143;
    }
</style>
<!-- search form -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($permissions['customers']['read'] == 1) { ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Customers</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" id="user_table" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=cust" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-show-clear="true" data-query-params="queryParams_1" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">MOB No</th>
                                    <th data-field="alt_mob" data-sortable="true">ALT Mob No</th>
                                    <th data-field="dob" data-sortable="true">Birth Date</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="address" data-sortable="true">Address</th>
                                    <th data-field="city" data-sortable="true" data-visible="false">City</th>
                                    <th data-field="area" data-sortable="true">Area</th>
                                    <th data-field="state" data-sortable="true">State</th>
                                    <th data-field="pincode" data-sortable="true">Pincode</th>
                                    <th data-field="ship_add" data-sortable="true">Shipping Add</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="created_at" data-sortable="true">Date & Time</th>
                                    <th data-field="updated_at" data-sortable="true">Upadted At</th>
                                    <th data-field="operate" data-events="actionEvents">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view customers</div>
            <?php } ?>
            <!-- /.box -->
        </div>
    </div><!-- /.row (main row) -->
</section>
<script>
    $('#filter_user').on('change', function() {
        $('#user_table').bootstrapTable('refresh');

    });

    function queryParams_1(p) {
        return {
            "filter_user": $('#filter_user').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>

<script>
    window.actionEvents = {
        'click .set-product-deactive': function(e, value, rows, index) {
            var p_id = $(this).data("id");
            $.ajax({
                url: 'public/db-operation.php',
                type: "get",
                data: 'id=' + p_id + '&cust_status=1&cust_type=deactive',
                success: function(result) {
                    if (result == 1)
                        $('#user_table').bootstrapTable('refresh');
                    else
                        alert('Error! Users could not be deactivated.');
                }
            });

        },
        'click .set-product-active': function(e, value, rows, index) {
            var p_id = $(this).data("id");
            $.ajax({
                url: 'public/db-operation.php',
                type: "get",
                data: 'id=' + p_id + '&cust_status=1&cust_type=active',
                success: function(result) {
                    if (result == 1)
                        $('#user_table').bootstrapTable('refresh');
                    else
                        alert('Error! Users could not be deactivated.');
                }
            });
        }
    };
</script>