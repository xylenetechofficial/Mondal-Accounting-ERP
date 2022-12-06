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
    $city = $db->escapeString($fn->xss_clean($_POST['city']));
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

    $sql_query = "INSERT INTO party (name,gst_no,mobile,city,gst_type,bill_address,ship_address,state,email,add_field1,add_field2,add_field3,add_field4,add_field_date,created_at,updated_at)VALUES('$name', '$gst_no', '$mobile','$city','$gst_type','$bill_address','$ship_address','$state','$email','$add_field1','$add_field2','$add_field3','$add_field4','$add_field_date','$datetime','$datetime')";
    $db->sql($sql_query);
    // print_r($sql_query);
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
                            <div class="row">
                                <div class="col-xs-3" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Party Name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">GSTIN</label>
                                        <input type="text" name="gst_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Phone No</label>
                                        <input type="text" name="mobile" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="inputCity">Location</label>
                                        <select class="form-control" id="inputCity" name="city">
                                            <option value="">-- Select one -- </option>
                                        </select>
                                    </div>
                                </div>

                            </div><br /><br /><br />
                            <div class="row">
                                <!-- Left col -->
                                <div class="col-xs-12" style="padding: 0px;">
                                    <div class="box">

                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <ul class="nav nav-pills" style="justify-content: center;">
                                                <li class="active"><a data-toggle="pill" href="#gst_address">GST & Address</a></li>
                                                <li><a data-toggle="pill" href="#add_fields">Additional Fields</a></li>
                                            </ul><br><br>

                                            <div class="tab-content">

                                                <div id="gst_address" class="tab-pane active">

                                                    <div class="row">

                                                        <div class="col-md-5">
                                                            <div class="col-md-12" style="text-align-last: left;">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label for="outline-select">GST Type</label>
                                                                    <select class="form-control" id="gst_type" name="gst_type">
                                                                        <option value="unreg_consumer">Unregistered/Consumer</option>
                                                                        <option value="register">Registered</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12" style="text-align-last: left;">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label for="inputState">State</label>
                                                                    <select class="form-control" id="inputState" name="state" required>
                                                                        <option value="SelectState">Select State</option>
                                                                        <option value="Andra Pradesh">Andra Pradesh</option>
                                                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                                        <option value="Assam">Assam</option>
                                                                        <option value="Bihar">Bihar</option>
                                                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                                                        <option value="Goa">Goa</option>
                                                                        <option value="Gujarat">Gujarat</option>
                                                                        <option value="Haryana">Haryana</option>
                                                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                                        <option value="Jharkhand">Jharkhand</option>
                                                                        <option value="Karnataka">Karnataka</option>
                                                                        <option value="Kerala">Kerala</option>
                                                                        <option value="Madya Pradesh">Madya Pradesh</option>
                                                                        <option value="Maharashtra">Maharashtra</option>
                                                                        <option value="Manipur">Manipur</option>
                                                                        <option value="Meghalaya">Meghalaya</option>
                                                                        <option value="Mizoram">Mizoram</option>
                                                                        <option value="Nagaland">Nagaland</option>
                                                                        <option value="Orissa">Orissa</option>
                                                                        <option value="Punjab">Punjab</option>
                                                                        <option value="Rajasthan">Rajasthan</option>
                                                                        <option value="Sikkim">Sikkim</option>
                                                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                                                        <option value="Telangana">Telangana</option>
                                                                        <option value="Tripura">Tripura</option>
                                                                        <option value="Uttaranchal">Uttaranchal</option>
                                                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                                        <option value="West Bengal">West Bengal</option>
                                                                        <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                                                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                                        <option value="Chandigarh">Chandigarh</option>
                                                                        <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                                                        <option value="Daman and Diu">Daman and Diu</option>
                                                                        <option value="Delhi">Delhi</option>
                                                                        <option value="Lakshadeep">Lakshadeep</option>
                                                                        <option value="Pondicherry">Pondicherry</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12" style="text-align-last: left;">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label for="outline-select">Email</label>
                                                                    <input type="email" name="email" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="col-xs-6">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label style="display: block;" for="outline-select">Billing Address</label>
                                                                    <textarea rows="4" name="bill_address"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label style="display: block;" for="outline-select">Shipping Address</label>
                                                                    <textarea rows="4" name="ship_address"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div id="add_fields" class="tab-pane fade">
                                                    <div class="row">

                                                        <div class="col-md-5">
                                                            <div class="col-md-12" style="text-align-last: left;">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label for="outline-select" style="float: left;">Additional Field 1 Name</label>
                                                                    <!--<input type="checkbox" name="" style="margin: revert;">-->
                                                                    <input type="text" name="add_field1" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12" style="text-align-last: left;">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label for="outline-select" style="float: left;">Additional Field 2 Name</label>
                                                                    <!--<input type="checkbox" name="" style="margin: revert;">-->
                                                                    <input type="text" name="add_field2" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12" style="text-align-last: left;">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label for="outline-select" style="float: left;">Additional Field 3 Name</label>
                                                                    <!--<input type="checkbox" name="" style="margin: revert;">-->
                                                                    <input type="text" name="add_field3" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12" style="text-align-last: left;">
                                                                <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                                                    <label for="outline-select" style="float: left;">Additional Field 4 Name</label>
                                                                    <!--<input type="checkbox" name="" style="margin: revert;">-->
                                                                    <div class="col-xs-12" style="display: flex;">
                                                                        <input type="text" name="add_field4" class="form-control">
                                                                        <input type="date" name="add_field_date" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <!-- right col (We are only adding the ID to make the widgets sortable)-->
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
<script src="public/js/state_and_city.js"></script>