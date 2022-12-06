<?php
include_once('../includes/crud.php');
include_once('../includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

$ID = $_GET['id'];
//print_r($ID);
$name = $_GET['name'];
$date = $_GET['date'];
$address = $_GET['address'];
$joining_date = $_GET['joining_date'];
$emp_post = $_GET['emp_post'];
$ref_no = $_GET['ref_no'];
$salary = $_GET['salary'];
$hra = $_GET['hra'];
$medical = $_GET['medical'];
$lta = $_GET['lta'];
$home_allow = $_GET['home_allow'];
$total = $_GET['total'];

//$date = date("d-m-Y");
/*
$sql2 = "SELECT * FROM `final_processed_coils` WHERE id = '$ID' ORDER BY id ASC limit 1";
//$sql = "SELECT * FROM `coils` WHERE id = '1' ";
$db->sql($sql2);
$res2 = $db->getResult();
//print_r($res2);
foreach ($res2 as $row2)
    $data2 = $row2;
*/
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>

<section class="content" style="background-color: white;">
    <div class="row" style="margin-right: 80px;margin-left: 80px;">
        <div class="col-md-12" style="text-align-last: center;">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div>

                    <div class="row" style="padding-left: 50px;padding-right: 50px;font-size: x-large;">
                        <!-- Left col -->
                        <div class="col-md-6" style="padding: 0px;float: left;">
                            <div>
                                <label>Ref : <?php echo $ref_no; ?></label>
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-6" style="padding: 0px;float: right;">
                            <div>
                                <label><?php echo $date; ?></label>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br><br>

                    <div class="row" style="padding-left: 50px;padding-right: 50px;font-size: x-large;">
                        <!-- Left col -->
                        <div class="col-xs-4" style="padding: 0px;float: left;">
                            <div>
                                <label>To,</label><br>
                                <label><?php echo $name; ?></label><br>
                                <label><?php echo $address; ?></label><br>
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-xs-8" style="padding: 0px;text-align-last: center;">
                            <div>
                                <label></label>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div>

                </div>

            </div><!-- /.box-body -->

        </div><!-- /.box -->
    </div>
    <div class="row no-print">
        <div class="col-xs-12">
            <form style="text-align-last: center; background-color:  white;"><button type='button' value='Print this page' onclick='printpage();' class="btn btn-success"><i class="fa fa-print"></i> Print</button>
            </form>
            <script>
                function printpage() {
                    var is_chrome = function() {
                        return Boolean(window.chrome);
                    }
                    if (is_chrome) {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 100000);
                        //give them 10 seconds to print, then close
                    } else {
                        window.print();
                        window.close();
                    }
                }
            </script>
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="public/MultiSelect/multiselect.js"></script>

<script>
    function priceFormatter(data) {
        var field = this.field
        return '<span style="color:green;font-weight:bold;font-size:large;"> <?= $settings['currency'] ?> ' + data.map(function(row) {
                return +row[field]
            })
            .reduce(function(sum, i) {
                // return sum + i
                return (Math.round(sum + i));
            }, 0);
    }
</script>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script>
    //var can_submit = false;
    $('form').on('submit', function(e) {

        //var confirmation = confirm("Do you want to continue");

        //if (this.host !== window.location.host) {
        //if (confirmation) {
        if (window.confirm('Really Want To Submit?')) {
            window.location.href = "home.php";
            console.log("Clicked OK - submitting now ...");
            can_submit = true;
            window.location.href = "home.php";
            //console.location.href = "home.php";
            //console.location("home.php");
            echo(window.location = "home.php");

        } else {
            console.log("Clicked Cancel");
            //can_submit = false;
            return false;
        }
        //}
    });
</script>