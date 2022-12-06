<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$id = $_GET['id'];
$location = $_GET['location'];

$sql = "SELECT * FROM `mock_drill` WHERE id = '$id' AND location = '$location'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $drill_date = $row['drill_date'];
$drill_type = $row['drill_type'];
$fire = $row['fire'];
$gas_leak = $row['gas_leak'];
$fall_down = $row['fall_down'];
$other = $row['other'];
$start_time = $row['start_time'];
$end_time = $row['end_time'];
$total_time = $row['total_time'];
$alarm_worked = $row['alarm_worked'];
$describe_alarm = $row['describe_alarm'];
$describe_situation = $row['describe_situation'];
$location = $row['location'];

$sql = "SELECT location_name FROM `location` WHERE location_name = '$location' ORDER BY id DESC";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);
/*
$sql = "SELECT * FROM `jha_required` WHERE jha_type_id = '$ID' AND location_id= '$location_id' ORDER BY step DESC";
// Execute query
$db->sql($sql);
// store result 
$res3 = $db->getResult();
foreach ($res3 as $row3)

    $req_ppe = $row3['req_ppe'];
$req_tools = $row3['req_tools'];
$req_training = $row3['req_training'];
$emp_id = $row3['emp_name'];

*/

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
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <h2><b><u>MOCK DRILL REPORT</u></b></h2>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div><br /><br />

                        <div class="row">
                            <!-- Left col -->
                            <div class="col-xs-12" style="padding: 0px;">
                                <div class="box">
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><b>MOCK DRILL DATE: <?php echo $drill_date; ?></b></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><b>TYPE OF DRILL : <?php echo $drill_type; ?></b></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;">
                                        <h4><b>* Fire : <?php echo $fire; ?></b></h4>
                                        <h4><b>* Gas Leakage : <?php echo $gas_leak; ?></b></h4>
                                        <h4><b>* Fall Down : <?php echo $fall_down; ?></b></h4>
                                        <h4><b>* Other Specific : <?php echo $other; ?></b></h4>
                                    </div>
                                    <div class="row">
                                        <!-- Left col -->
                                        <div class="col-xs-12" style="padding: 0px;">
                                            <div class="box">
                                                <!-- /.box-header -->
                                                <div class="box-body table-responsive" style="padding-left: 20px;padding-right: 20px;">
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <!--<th style="border: 1px solid black;">No.</th>-->
                                                            <th style="border: 1px solid black;">Drill Start Time:</th>
                                                            <th style="border: 1px solid black;">Drill End Time:</th>
                                                            <th style="border: 1px solid black;">Total Time Drill:</th>
                                                        </tr>
                                                        <tr>
                                                            <!--<td style="border: 1px solid black;"><?php echo $id; ?></td>-->
                                                            <td style="border: 1px solid black;"><?php echo $start_time; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $end_time; ?></td>
                                                            <td style="border: 1px solid black;"><?php echo $total_time; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><b>Alarm Worked Properly ?</b></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><?php echo $alarm_worked; ?></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><b>Describe what happen when alarmed?</b></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><?php echo $describe_alarm; ?></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><b>Peoples are evacuated properly?- Describe Situation</b></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><?php echo $describe_situation; ?></h4>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <h4><b>Sign & Date: </b></h4>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div><br><br><br><br><br><br>
                        <div class="row">
                            <!-- Left col -->
                            <div class="col-xs-12" style="padding: 0px;">
                                <div class="box" style="border: none;">
                                    <div class="col-xs-6" style="text-align-last: center;">
                                        <h3><b>Signature of Supervisor</b></h3>
                                    </div>
                                    <div class="col-xs-6" style="text-align-last: center;">
                                        <h3><b>Signature of Proprietor</b></h3>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div>
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