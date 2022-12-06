<section class="content-header">
    <h1>Bank List /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    </h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add_bank.php"><i class="fa fa-plus-square"></i> Add Bank</a>
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
                        <table class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=bank" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_1" data-filter-show-clear="true" data-sort-name="id" data-sort-order="desc">
                            <thead>
                                <tr>
                                    <th data-field="operate">Action</th>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="bank_name" data-sortable="true">Bank</th>
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

    <div class="modal fade" id="ViewTransanction" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-12" style="text-align-last: left;">
                            <p>Bank Name</p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;">
                            <p>Account No : </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;">
                            <p>IFSC Code : </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;">
                            <p>UPI Id : </p>
                        </div>
                        <div class="col-xs-12" style="text-align-last: left;">
                            <label for="outline-select">Deposit / Withdraw</label>
                            <select class="form-control" id="dep_withdraw" name="dep_withdraw" onchange="location = this.value;" required>
                                <option value="bank_to_cash_trans.php">Bank To Cash Transfer</option>
                                <option value="cash_to_bank_trans.php">Cash To Bank Transfer</option>
                                <option value="bank_to_bank_trans.php">Bank To Bank Transfer</option>
                                <option value="adj_bank_bal.php">Adjust Bank Balance</option>
                            </select>
                        </div>
                    </div>
                    <h3 class="modal-title" id="exampleModalLongTitle">TRANSACTIONS</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="bank_id" id="bank_id" value="">
                    <table class="table table-hover" id="bank_transaction_table" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=bank_transaction" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-show-clear="true" data-query-params="queryParams_2" data-sort-name="id" data-sort-order="desc">
                        <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="type" data-visible="true">Type</th>
                                <th data-field="number" data-visible="true">Name</th>
                                <th data-field="date" data-visible="true">Date</th>
                                <th data-field="amount" data-visible="true">Amount</th>
                                <!--<th data-field="balance" data-sortable="true">Balance</th>-->
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
    var bank_id = "";
    $(document).on("click", '.view_bank_transact', function() {
        bank_id = $(this).data("id");
        $('#bank_id').val(bank_id);
        $('#bank_transaction_table').bootstrapTable('refresh');
    });

    function queryParams_2(p) {
        return {
            "bank_id": $('#bank_id').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>