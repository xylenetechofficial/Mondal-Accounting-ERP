<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//$datetime = date("Y-m-d H:i:s");
?>
<?php
if (isset($_POST['btnAdd'])) {

    $datetime = date("Y-m-d H:i:s");
    //$date = $db->escapeString($fn->xss_clean($_POST['date']));
    $name = $db->escapeString($fn->xss_clean($_POST['name']));
    $mobile = $db->escapeString($fn->xss_clean($_POST['mobile']));
    $alt_mob = $db->escapeString($fn->xss_clean($_POST['alt_mob']));
    $tax_no = $db->escapeString($fn->xss_clean($_POST['tax_no']));
    //$country_code = $db->escapeString($fn->xss_clean($_POST['country_code']));
    //$fcm_id = $db->escapeString($fn->xss_clean($_POST['fcm_id']));
    $dob = $db->escapeString($fn->xss_clean($_POST['dob']));
    $email = $db->escapeString($fn->xss_clean($_POST['email']));;
    //$password = md5($db->escapeString($fn->xss_clean($_POST['password'])));
    $address = $db->escapeString($fn->xss_clean($_POST['address']));
    $city = $db->escapeString($fn->xss_clean($_POST['city']));
    $area = $db->escapeString($fn->xss_clean($_POST['area']));
    $state = $db->escapeString($fn->xss_clean($_POST['state']));
    $pincode = $db->escapeString($fn->xss_clean($_POST['pincode']));
    $pay_days = $db->escapeString($fn->xss_clean($_POST['pay_days']));
    $pay_term = $db->escapeString($fn->xss_clean($_POST['pay_term']));
    $ship_add = $db->escapeString($fn->xss_clean($_POST['ship_add']));
    //$created_at = $datetime;
    //$updated_at = $datetime;
    $status = 1;

    $sql_query = "INSERT INTO cust (name,mobile,alt_mob,tax_no,dob,email,address,city,area,state,pincode,pay_days,pay_term,ship_add,status,created_at,updated_at)VALUES('$name', '$mobile', '$alt_mob','$tax_no','$dob','$email','$address','$city','$area','$state','$pincode','$pay_days','$pay_term','$ship_add','$status','$datetime','$datetime')";
    $db->sql($sql_query);
    $result = $db->getResult();
    /*
    $sql = "SELECT id FROM inward_form ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res_coil_id = $db->getResult();
    $coil_id = $res_coil_id[0]['id'];

    $sql_query1 = "INSERT INTO `coils`(`coils_id`, `coils_date`, `coils_truck_no`, `coils_party_name`, `coils_mita_coil_no`, `coils_party_coil_no`, `coils_grade`, `coils_thickness`, `coils_width`, `coils_rm_width`, `coils_length`, `coils_quantity`, `coils_net_weight`, `coils_kata_wt`, `coils_location`, `coils_remark`, `coils_lot_no`, `coils_invoice_no`, `coils_mother_coil_loc`, `coils_remark1`, `coils_remark2`, `coils_remark3`, `coils_status`, `coils_process_status`, `created_at`)VALUES('$coil_id','$date', '$truck_no', '$party_name','$mita_coil_no','$party_coil_no','$grade','$thickness','$width','$rm_width','$length','$quantity','$net_weight','$kata_wt','$location','$remark','$lot_no','$invoice_no','$mother_coil_loc','$remark1','$remark2','$remark3','$status','$process_status','$datetime')";
    $db->sql($sql_query1);
    $result1 = $db->getResult();
*/
}

if (isset($_POST['btnAdd'])) {
?>
    <script type="text/javascript">
        window.location = "cust.php";
    </script>
<?php
}

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>Add Customers Form</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <form id="form" role="form" method="post" enctype="multipart/form-data" action="add_cust.php">
                    <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">NAME</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mobile NO </label><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                <input type="text" class="form-control" name="mobile">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Alternate Mob NO</label><?php echo isset($error['alt_mob']) ? $error['alt_mob'] : ''; ?>
                                <input type="text" class="form-control" name="alt_mob">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tax No.</label><?php echo isset($error['tax_no']) ? $error['tax_no'] : ''; ?>
                                <input type="text" class="form-control" name="tax_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email ID</label><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date Of Birth</label><?php echo isset($error['dob']) ? $error['dob'] : ''; ?>
                                <input type="date" class="form-control" name="dob">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                                <input type="text" class="form-control" name="address">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">City</label><?php echo isset($error['city']) ? $error['city'] : ''; ?>
                                <input type="text" class="form-control" name="city">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Area</label><?php echo isset($error['area']) ? $error['area'] : ''; ?>
                                <input type="text" class="form-control" name="area">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">State</label><?php echo isset($error['state']) ? $error['state'] : ''; ?>
                                <input type="text" class="form-control" name="state">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                <input type="text" class="form-control" name="pincode">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pay Term</label><?php echo isset($error['pincode']) ? $error['pincode'] : ''; ?>
                                <div class="form-group" style="display: flex;">
                                    <input type="text" class="form-control" name="pay_days" placeholder="Pay Terms">
                                    <select id='pay_term' name="pay_term" class='form-control'>
                                        <option value=''>SELECT</option>
                                        <option value='months'>Months</option>
                                        <option value='days'>Days</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Shipping Address</label><?php echo isset($error['ship_add']) ? $error['ship_add'] : ''; ?>
                                <input type="text" class="form-control" name="ship_add">
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label for="exampleInputEmail1">Invoice No</label><?php echo isset($error['invoice_no']) ? $error['invoice_no'] : ''; ?>
                            <input type="text" class="form-control" name="invoice_no">
                        </div>-->

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" name="btnAdd">
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="public/MultiSelect/multiselect.js"></script>

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