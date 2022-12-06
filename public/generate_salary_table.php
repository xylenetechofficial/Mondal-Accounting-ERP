<section class="content-header">
    <h1>Genarate Salary</h1>
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

    .ui-datepicker-calendar {
        display: none !important;
    }

    #ui-datepicker-div.noCalendar .ui-datepicker-calendar,
    #ui-datepicker-div.noCalendar .ui-datepicker-header a {
        display: none;
    }

    #ui-datepicker-div.noCalendar .ui-datepicker-header .ui-datepicker-title {
        width: 100%;
        margin: 0;
    }
</style>
<!-- search form -->
<section class="content">
    <!-- Main row -->
    <?php if ($permissions['reports']['read'] == 1) { ?>
        <div class="row">
            <div class="col-md-12">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <form method="POST" id="filter_form" name="filter_form">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="salmonth" name="salmonth" readonly>
                                <input type="hidden" class="form-control" id="salyear" name="salyear" readonly>
                                <!--<label for="from" class="control-label col-md-2 col-sm-3 col-xs-12">From & To Date</label>-->
                                <div class="col-md-3">
                                    <select class="form-control" id="month" name="month" onchange="updateqty()">
                                        <option value="">--Select Month--</option>
                                        <option value="january">January</option>
                                        <option value="february">February</option>
                                        <option value="march">March</option>
                                        <option value="april">April</option>
                                        <option value="may">May</option>
                                        <option value="june">June</option>
                                        <option value="july">July</option>
                                        <option value="august">August</option>
                                        <option value="september">September</option>
                                        <option value="october">October</option>
                                        <option value="november">November</option>
                                        <option value="december">December</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="year" name="year" onchange="updateqty()">
                                        <option value="">--Select Year--</option>
                                        <?php

                                        for ($i = date('Y'); $i >= 2015; $i--) {
                                            echo "<option value=" . $i . ">" . $i . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!--<input type="hidden" id="start_date" name="start_date">
                                <input type="hidden" id="end_date" name="end_date">-->
                            </div>
                            <!--<div class="form-group">
                                <select id="filter_order" name="filter_order" placeholder="Select Status" required class="form-control" style="width: 300px;">
                                    <option value="">All Orders</option>
                                    <option value='received'>Received</option>
                                    <option value='processed'>Processed</option>
                                    <option value='shipped'>Shipped</option>
                                    <option value='delivered'>Delivered</option>
                                </select>
                            </div>
                            <input type="hidden" id="filter_order_status" name="filter_order_status">-->
                        </form>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">

                            <table class="table no-margin" data-toggle="table" id="reports_list" data-url="api-firebase/get-bootstrap-table-data.php?table=salary_list" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="false" data-trim-on-search="false" data-sort-name="id" data-sort-order="asc" data-query-params="queryParams" data-show-export="true" data-export-types='["txt","excel"]' data-export-options='{"fileName": "salary-list-<?= date('d-m-Y') ?>"}'>
                                <thead>
                                    <!--data-visible='false'  -->
                                    <tr>
                                        <th data-field="eid" data-sortable='true'>EMP ID</th>
                                        <th data-field="emp_no" data-sortable='true'>EMP NO</th>
                                        <th data-field="emp_post" data-sortable='true'>EMP Post</th>
                                        <th data-field="tot_hrs" data-sortable='true'>Total Hours</th>
                                        <th data-field="tot_ot_hrs" data-sortable='true'>Total OT Hours</th>
                                        <th data-field="basic_salary" data-sortable='true'>Total Basic Salary</th>
                                        <th data-field="tot_spl_allowance" data-sortable='true'>Total Special Allowance</th>
                                        <th data-field="tot_ot_sal" data-sortable='true'>Total OT Salary</th>
                                        <th data-field="total_pf_wages" data-sortable='true'>P.F. Wages</th>
                                        <th data-field="total_hra" data-sortable='true'>hra</th>
                                        <th data-field="total_gross_salary" data-sortable='true'>Gross Salary</th>
                                        <th data-field="total_pf" data-sortable='true'>P.F.</th>
                                        <th data-field="total_esic" data-sortable='true'>E.S.I.C</th>
                                        <th data-field="final_total_deduction" data-sortable='true'>Tot Deduction</th>
                                        <th data-field="total_net_salary" data-sortable='true'>Net Salary</th>
                                        <th data-field="tot_sal" data-sortable='true'>Total Salary</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger">You have no permission to view sales reports.</div>
    <?php } ?>
</section>
<!-- /.content -->
<!--<script>
    function updateqty(e) {

        var m = $("#month").val();
        alert(m);
        var y = $("#year").val();
        alert(y);

        $("#salmonth").val(m);
        $("#salyear").val(y);

        var date = Date.parse(m - y);
        alert(date);
        console.log(date);

    };
</script>
<script>
    //$(document).ready(function() {

    function updateqty(e) {

        var m = $("#month").val();
        //alert(m);
        var y = $("#year").val();
        //alert(y);
        $("#salmonth").val(m);
        $("#salyear").val(y);
        /*
        var date = Date.parse(m - y);
        alert(date);
        console.log(date);

        $('#month').on('change', function() {
            $("#salmonth").val(m);
            $("#salyear").val(y);
        });
        
                $('#year').on('change', function() {
                    $("#salmonth").val(m);
                    $("#salyear").val(y);
                });
                
                $('#filter_order').on('change', function() {
                    $('#reports_list').bootstrapTable('refresh');
                });
        */
    };
    //});

    function queryParams(p) {
        return {
            "month": $('#salmonth').val(),
            "year": $('#salyear').val(),
            //"month": 'september',
            //"year": '2022',
            //"filter_order": $('#filter_order_status').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>-->

<script>
    $(document).ready(function() {
        
        $('#month').on('change', function() {
            var month = $('#month').val();
            $('#salmonth').val(month);
            //$('#end_date').val();
            $('#reports_list').bootstrapTable('refresh');
        });
        $('#year').on('change', function() {
            var year = $('#year').val();
            //$('#start_date').val();
            $('#salyear').val(year);
            $('#reports_list').bootstrapTable('refresh');
        });
        
    });

    function queryParams(p) {
        return {
            "month": $('#salmonth').val(),
            "year": $('#salyear').val(),
            //"filter_order": $('#filter_order_status').val(),
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