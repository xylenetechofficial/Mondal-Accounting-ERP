<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
$i = 1;
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php

if (isset($_POST['btnAdd'])) {
?>
    <script type="text/javascript">
        window.location = "home.php";
    </script>
<?php
}

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>Credit Note</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol><br />
    
    <hr />
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div id="credit" class="tab-pane active">
                    <form id="form" role="form" class="form" method="post" enctype="multipart/form-data" action="">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="col-xs-7" style="text-align-last: left;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select">Party</label>
                                            <select class="form-control" id="party" name="party" onchange="location = this.value;" required>
                                                <option value="">--Select Party--</option>
                                                <option value="add_party.php">Add Party</option>
                                                <option value="">party1</option>
                                                <option value="">party2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-5" style="text-align-last: left;">
                                        <!--<div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select">Phone No</label>
                                            <input type="text" name="emp_no" class="form-control">
                                        </div>-->
                                    </div>
                                    <div class="col-xs-6" style="text-align-last: left;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select">Billing Address</label>
                                            <textarea rows="4" name="bill_address"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" style="text-align-last: left;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select">Shipping Address</label>
                                            <textarea rows="4" name="ship_address"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">

                                </div>

                                <div class="col-md-4">
                                    <div class="col-xs-12" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <p><label for="outline-select">Order No</label></p>
                                            <input type="text" name="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <p><label for="outline-select">Order Date</label></p>
                                            <input type="date" name="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <p><label for="outline-select">Due Date</label></p>
                                            <input type="date" name="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select">State Of Supply</label>
                                            <select class="form-control" id="state" name="state">
                                                <option value="">--Select State--</option>
                                                <option value="maharashtra">Maharashtra</option>
                                                <option value="delhi">Delhi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div><br /><br /><br />
                            <div class="row">
                                <!-- Left col -->
                                <div class="col-xs-12" style="padding: 0px;">
                                    <div class="box">

                                        <!-- /.box-header -->
                                        <div class="box-body table-responsive" style="padding: 0px;">
                                            <table class="table table-hover">
                                                <tr>
                                                    <th rowspan="2" style="border: 1px solid black;">#</th>
                                                    <th rowspan="2" style="border: 1px solid black;">Item</th>
                                                    <th rowspan="2" style="border: 1px solid black;">Qty</th>
                                                    <th rowspan="2" style="border: 1px solid black;">Unit</th>
                                                    <th style="border: 1px solid black;">PRICE/UNIT</th>
                                                    <th colspan="2" style="border: 1px solid black;">DISCOUNT</th>
                                                    <th colspan="2" style="border: 1px solid black;">TAX</th>
                                                    <th rowspan="2" style="border: 1px solid black;">AMOUNT</th>
                                                </tr>
                                                <tr>
                                                    <th style="border: 1px solid black;">
                                                        <select class="form-control" id="tax" name="tax">
                                                            <option value="#">With Tax</option>
                                                            <option value="#">Without Tax</option>
                                                        </select>
                                                    </th>
                                                    <th style="border: 1px solid black;">%</th>
                                                    <th style="border: 1px solid black;">AMOUNT</th>
                                                    <th style="border: 1px solid black;">%</th>
                                                    <th style="border: 1px solid black;">AMOUNT</th>
                                                </tr>

                                                <tr>
                                                    <td style="border: 1px solid black;">1</td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;">
                                                        <select class="form-control" id="unit" name="unit">
                                                            <option value="">NONE</option>
                                                            <?php
                                                            $sql = "SELECT * FROM unit";
                                                            $db->sql($sql);
                                                            $res = $db->getResult();
                                                            foreach ($res as $unit) {
                                                                echo "<option value='" . $unit['id'] . "'>" . $unit['short_code'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;">
                                                        <select class="form-control" id="tax" name="tax">
                                                            <option value="">--Select--</option>
                                                            <?php
                                                            $sql = "SELECT * FROM taxes";
                                                            $db->sql($sql);
                                                            $res = $db->getResult();
                                                            foreach ($res as $tax) {
                                                                echo "<option value='" . $tax['id'] . "'>" . $tax['title'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;"></td>

                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid black;"><button>Add Row</button></td>
                                                    <td style="border: 1px solid black;">Total</td>
                                                    <td style="border: 1px solid black;">0</td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;">0</td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td style="border: 1px solid black;">0</td>
                                                    <td style="border: 1px solid black;">0</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Payment Type</label>
                                        <select class="form-control" id="" name="">
                                            <option value="cash">Cash</option>
                                            <option value="credit">Credit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-5">
                                    <div class="col-xs-5" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select" style="float: left;">Round Off</label>
                                            <input type="checkbox" name="">
                                            <input type="number" name="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-7" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select">Total</label>
                                            <input type="text" name="" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Add Description</label>
                                        <input type="text" name="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-8">

                                </div>
                                <!--<div class="col-md-5">
                                    <div class="col-xs-5" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <input type="checkbox" name="">
                                            <label for="outline-select" style="float: left;">Round Off</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-7" style="text-align-last: right;">
                                        <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                            <label for="outline-select">Received</label>
                                            <input type="text" name="" class="form-control">
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </form>
                </div>
                <div id="cash" class="tab-pane active">
                    <form id="form" role="form" class="form" method="post" enctype="multipart/form-data" action="">
                        <div class="box-body">
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>


<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<!--<script src="public/MultiSelect/multiselect.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
</script>