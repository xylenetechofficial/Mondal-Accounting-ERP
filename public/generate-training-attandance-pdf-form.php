<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$ID = $_GET['id'];
//print_r($ID);
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `training_attandance_sheet` WHERE id = '$ID' AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res2 = $db->getResult();

foreach ($res2 as $row2)
    $id = $row2['id'];
$training_name = $row2['training_name'];
$doc_no = $row2['doc_no'];
$rev_no = $row2['rev_no'];
$location_id = $row2['location_id'];
$location = $row2['location'];
$date = $row2['date'];
$training_date = $row2['training_date'];
$emp_id = $row2['emp_id'];
$emp_no = $row2['emp_no'];
$emp_name = $row2['emp_name'];
$department = $row2['department'];
$mobile = $row2['mobile'];
$remark = $row2['remark'];
$signature = $row2['signature'];

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content" style="background-color: white;">
    <!--<div class="row" style="margin-right: 80px;margin-left: 80px;">-->
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div class="box-body">

                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;border: 1px solid black;">
                            <div class="box">
                                <div class="col-xs-12" style="border: 1px solid black; text-align-last: center; color:red; padding-top: 50px; padding-bottom: 50px;">
                                    <h1><b>Mandal Engineering</b></h1>
                                </div>

                                <div class="col-xs-8" style="border: 1px solid black; text-align-last: center;">
                                    <h4><b>Training Attandance Sheet</b></h4>
                                </div>
                                <div class="col-xs-2" style="border: 1px solid black; text-align-last: center;">
                                    <h4>Doc No.</h4>
                                </div>
                                <div class="col-xs-2" style="border: 1px solid black; text-align-last: center;">
                                    <h4><?php echo $doc_no; ?></h4>
                                </div>

                                <div class="col-xs-4" style="border: 1px solid black; text-align-last: center;">
                                    <h4>Training Program Name</h4>
                                </div>
                                <div class="col-xs-4" style="border: 1px solid black; text-align-last: center;">
                                    <h4><?php echo $training_name; ?></h4>
                                </div>
                                <div class="col-xs-2" style="border: 1px solid black; text-align-last: center;">
                                    <h4>Rev No.</h4>
                                </div>
                                <div class="col-xs-2" style="border: 1px solid black; text-align-last: center;">
                                    <h4><?php echo $rev_no; ?></h4>
                                </div>

                                <div class="col-xs-5" style="border: 1px solid black; text-align-last: center;">
                                    <h4>Location : <?php echo $location; ?></h4>
                                </div>
                                <div class="col-xs-4" style="border: 1px solid black; text-align-last: center;">
                                    <h4>Training Date : <?php echo $training_date; ?></h4>
                                </div>
                                <div class="col-xs-1" style="border: 1px solid black; text-align-last: center;">
                                    <h4>Date</h4>
                                </div>
                                <div class="col-xs-2" style="border: 1px solid black; text-align-last: center;">
                                    <h4><?php echo $date; ?></h4>
                                </div>

                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br />

                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border: 1px solid black;">ID.</th>
                                            <th style="border: 1px solid black;">Name Of Employee</th>
                                            <th style="border: 1px solid black;">Employee ID</th>
                                            <th style="border: 1px solid black;">Department</th>
                                            <th style="border: 1px solid black;">Contact No</th>
                                            <th style="border: 1px solid black;">Remark</th>
                                            <th style="border: 1px solid black;">Sign</th>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;"><?php echo $id; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $emp_name; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $emp_no; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $department; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $mobile; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $remark; ?></td>
                                            <td style="border: 1px solid black;"><?php echo '<img src="'. DOMAIN_URL . 'upload/signature/'.$signature.'" height="50">'; ?></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <h4>Trainer Name : </h4>
                                </div><br /><br />
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <h4>Trainer Signature : </h4>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br />
                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div>
    </div>
    <div class="row no-print">
        <div class="col-xs-12">
            <form style="text-align: center;"><button type='button' value='Print this page' onclick='printpage();' class="btn btn-success"><i class="fa fa-print"></i> Print</button>
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