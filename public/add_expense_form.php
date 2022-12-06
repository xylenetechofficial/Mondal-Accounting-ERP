<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php

if (isset($_POST['btnAdd'])) {

    $datetime = date("Y-m-d H:i:s");
    //$date = $db->escapeString($fn->xss_clean($_POST['date']));
    $name = $db->escapeString($fn->xss_clean($_POST['name']));
    $gst_no = $db->escapeString($fn->xss_clean($_POST['gst_no']));
    $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
    $gst_type = $db->escapeString($fn->xss_clean($_POST['gst_type']));
    $bill_address = $db->escapeString($fn->xss_clean($_POST['bill_address']));
    $ship_address = $db->escapeString($fn->xss_clean($_POST['ship_address']));
    $state = $db->escapeString($fn->xss_clean($_POST['state']));
    $email = $db->escapeString($fn->xss_clean($_POST['email']));
    $add_field1 = $db->escapeString($fn->xss_clean($_POST['add_field1']));
    $add_field2 = $db->escapeString($fn->xss_clean($_POST['add_field2']));
    $add_field3 = $db->escapeString($fn->xss_clean($_POST['add_field3']));
    $add_field4 = $db->escapeString($fn->xss_clean($_POST['add_field4']));
    $add_field_date = $db->escapeString($fn->xss_clean($_POST['add_field_date']));
    //$pay_term = $db->escapeString($fn->xss_clean($_POST['pay_term']));

    $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    //print_r($location1);
    $location = implode(',', $location1);
    //print_r($location);

    $sql_query = "INSERT INTO party (name,gst_no,mobile,location_id,location,gst_type,bill_address,ship_address,state,email,add_field1,add_field2,add_field3,add_field4,add_field_date,created_at,updated_at)VALUES('$name', '$gst_no', '$mobile','$location_id','$location','$gst_type','$bill_address','$ship_address','$state','$email','$add_field1','$add_field2','$add_field3','$add_field4','$add_field_date','$datetime','$datetime')";
    $db->sql($sql_query);
    $result = $db->getResult();
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
    <h1>Add Party</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol><br />
    <!--<label style="vertical-align: bottom; margin-bottom: 14px;">Credit</label>
     <label class="switch">
         <input type="checkbox" checked>
         <span class="slider round"></span>
     </label>
     <label style="vertical-align: bottom; margin-bottom: 14px;">Cash</label>-->

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
                            <ul class="nav nav-pills" style="justify-content: center;">
                                <li class="active"><a data-toggle="pill" href="#no_gst">Without GST</a></li>
                                <li><a data-toggle="pill" href="#gst">GST</a></li>
                            </ul><br><br>
                            <div class="tab-content">

                                <div id="no_gst" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="col-xs-12" style="text-align-last: left;">
                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                    <label for="outline-select">Expense Category</label>
                                                    <select class="form-control" id="party" name="party" onchange="location = this.value;" required>
                                                        <option value="">--Select Expense Category--</option>
                                                        <option value="add_expense_category.php">Add Expense Category</option>
                                                        <option value="">Petrol</option>
                                                        <option value="">Food</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                        </div>

                                        <div class="col-md-4">
                                            <div class="col-xs-12" style="text-align-last: right;">
                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                    <p><label for="outline-select">Expense No</label></p>
                                                    <input type="text" name="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xs-12" style="text-align-last: right;">
                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                    <p><label for="outline-select">Date</label></p>
                                                    <input type="date" name="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="gst" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="col-xs-12" style="text-align-last: left;">
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
                                            <div class="col-xs-12" style="text-align-last: left;">
                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                    <label for="outline-select">Expense Category</label>
                                                    <select class="form-control" id="party" name="party" onchange="location = this.value;" required>
                                                        <option value="">--Select Expense Category--</option>
                                                        <option value="add_expense_category.php">Add Expense Category</option>
                                                        <option value="">Petrol</option>
                                                        <option value="">Food</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                        </div>

                                        <div class="col-md-4">
                                            <div class="col-xs-12" style="text-align-last: right;">
                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                    <p><label for="outline-select">Expense No</label></p>
                                                    <input type="text" name="" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-xs-12" style="text-align-last: right;">
                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                    <p><label for="outline-select">Bill Date</label></p>
                                                    <input type="date" name="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xs-12" style="text-align-last: right;">
                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                    <label for="outline-select">State</label>
                                                    <select class="form-control" id="state" name="state">
                                                        <option value="">--Select State--</option>
                                                        <option value="maharashtra">Maharashtra</option>
                                                        <option value="delhi">Delhi</option>
                                                    </select>
                                                </div>
                                            </div>
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
                        <div class="box-footer" style="text-align-last: center;">
                            <input type="submit" class="btn btn-primary" name="btnAdd">
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
<script>
    //var can_submit = false;
    $('form').on('submit', function(e) {

        var confirmation = confirm("Do you want to continue");
        if (confirmation) {
            console.log("Clicked OK - submitting now ...");
            //can_submit = true;

        } else {
            console.log("Clicked Cancel");
            //can_submit = false;
            return false;
        }

    });
</script>