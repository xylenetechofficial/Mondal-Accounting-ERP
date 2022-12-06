<section class="content-header">
    <h1>Parties List /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    </h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add_party.php"><i class="fa fa-plus-square"></i> Add Party</a>
    </ol>
    <hr />
</section>
<!-- search form -->
<section class="content">
    <div class="row">
        <div class="col-xs-6">
            <?php if ($permissions['customers']['read'] == 1) { ?>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Name</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=parties" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_1" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Party</th>
                                    <th data-field="amount" data-sortable="true">Amount</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view Form</div>
            <?php } ?>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row (main row) -->

    <div class="modal fade" id="ViewParty" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-3" style="text-align-last: left;">
                            <p>Party Name</p>
                        </div>
                        <div class="col-xs-3" style="text-align-last: left;">
                            <p>Phone : </p>
                        </div>
                        <div class="col-xs-3" style="text-align-last: left;">
                            <p>Email : </p>
                        </div>
                        <div class="col-xs-3" style="text-align-last: left;">
                            <p>GSTIN : </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;">
                            <p>Address : </p>
                        </div>
                    </div>
                    <h3 class="modal-title" id="exampleModalLongTitle">TRANSACTIONS</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="party_id" id="party_id" value="">
                    <table class="table table-hover" id="transaction_table" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=party_transaction" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-show-clear="true" data-query-params="queryParams_2" data-sort-name="id" data-sort-order="desc">
                        <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="type" data-visible="true">Type</th>
                                <th data-field="number" data-visible="true">Number</th>
                                <th data-field="date" data-visible="true">Date</th>
                                <th data-field="total" data-visible="true">Total</th>
                                <th data-field="balance" data-sortable="true">Balance</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

<script>
    $('#filter_user').on('change', function() {
        $('#user_table').bootstrapTable('refresh');

    });

    function queryParams_1(p) {
        return {
            //"filter_user": $('#filter_user').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
<script>
    var party_id = "";
    $(document).on("click", '.view_party_transact', function() {
        party_id = $(this).data("id");
        $('#party_id').val(party_id);
        $('#transaction_table').bootstrapTable('refresh');
    });

    function queryParams_2(p) {
        return {
            "party_id": $('#party_id').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>