<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();
error_reporting(0);
$fm = 'April';
$lm = 'March';
$y = $_GET['year'];
$ny = date("Y", strtotime("$y +1 year"));
$location_id = $_GET['location_id'];
$doc_no = $_GET['doc_no'];
$rev_no = $_GET['rev_no'];
$date = $_GET['date'];

$fdate = strtotime("$fm $y"); //print_r($fdate);
$ldate = strtotime("$lm $ny"); //print_r($ldate);

$start_date = date('Y-m-01', $fdate); //print_r($start_date);
$end_date  = date('Y-m-t', $ldate); //print_r($end_date);

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `training_calendar` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult(); //print_r($res2);

foreach ($res as $row)
    $id = $row['id'];

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
                            <h1 style="color: red; text-align-last: center;"><b>INTERNAL AUDIT PLAN</b></h1>
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="box">
                            <div class="col-xs-12" style="text-align-last: center; border: 1px solid black;">
                                <h2><b><U>TRAINING CALENDER</U></b></h2>
                            </div>
                            <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                <h4>Doc No : <?php echo $doc_no; ?></h4>
                            </div>
                            <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                <h4>Rev : <?php echo $rev_no; ?></h4>
                            </div>
                            <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                <h4>Date : <?php echo $date; ?></h4>
                            </div>
                        </div>
                        <!-- /.box -->
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
                                            <th colspan="2" style="border: 1px solid black; border-bottom: none;">Topic.</th>
                                            <th colspan="9" style="border: 1px solid black;"><?php echo $y; ?></th>
                                            <th colspan="3" style="border: 1px solid black;"><?php echo $ny; ?></th>
                                        </tr>
                                        <tr>
                                            <th style="border-left: 1px solid black;"></th>
                                            <th style="border: none;"></th>
                                            <th style="border: 1px solid black;">Apr</th>
                                            <th style="border: 1px solid black;">May</th>
                                            <th style="border: 1px solid black;">Jun</th>
                                            <th style="border: 1px solid black;">Jul</th>
                                            <th style="border: 1px solid black;">Aug</th>
                                            <th style="border: 1px solid black;">Sep</th>
                                            <th style="border: 1px solid black;">Oct</th>
                                            <th style="border: 1px solid black;">Nov</th>
                                            <th style="border: 1px solid black;">Dec</th>
                                            <th style="border: 1px solid black;">Jan</th>
                                            <th style="border: 1px solid black;">Feb</th>
                                            <th style="border: 1px solid black;">Mar</th>
                                        </tr>
                                        <?php

                                        $sql = "SELECT * FROM `training_calendar` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id' AND topic= 'Fire Extinguisher Training'";
                                        // Execute query
                                        $db->sql($sql);
                                        // store result 
                                        $res2 = $db->getResult(); //print_r($res2);

                                        //foreach ($res2 as $row2) {

                                        ?>
                                            <tr>
                                                <td rowspan="2" style="border: 1px solid black;">Fire Extinguisher Training</td>
                                                <td style="border: 1px solid black;">P</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_plan_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">A</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_actual_date']; ?></td>
                                            </tr>
                                        <?php //$row2['id']++;
                                        //} ?>

                                        <?php

                                        $sql = "SELECT * FROM `training_calendar` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id' AND topic= 'Height Work Training'";
                                        // Execute query
                                        $db->sql($sql);
                                        // store result 
                                        $res2 = $db->getResult(); //print_r($res2);

                                        //foreach ($res2 as $row2) {

                                        ?>
                                            <tr>
                                                <td rowspan="2" style="border: 1px solid black;">Height Work Training</td>
                                                <td style="border: 1px solid black;">P</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_plan_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">A</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_actual_date']; ?></td>
                                            </tr>
                                        <?php //$row2['id']++;
                                        //} ?>
                                        <?php

                                        $sql = "SELECT * FROM `training_calendar` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id' AND topic= 'Work Place Safety Training'";
                                        // Execute query
                                        $db->sql($sql);
                                        // store result 
                                        $res2 = $db->getResult(); //print_r($res2);

                                        //foreach ($res2 as $row2) {

                                        ?>
                                            <tr>
                                                <td rowspan="2" style="border: 1px solid black;">Work Place Safety Training</td>
                                                <td style="border: 1px solid black;">P</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_plan_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">A</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_actual_date']; ?></td>
                                            </tr>
                                        <?php //$row2['id']++;
                                        //} ?>
                                        <?php

                                        $sql = "SELECT * FROM `training_calendar` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id' AND topic= 'SOP Information Training'";
                                        // Execute query
                                        $db->sql($sql);
                                        // store result 
                                        $res2 = $db->getResult(); //print_r($res2);

                                        //foreach ($res2 as $row2) {

                                        ?>
                                            <tr>
                                                <td rowspan="2" style="border: 1px solid black;">SOP Information Training</td>
                                                <td style="border: 1px solid black;">P</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_plan_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">A</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_actual_date']; ?></td>
                                            </tr>
                                        <?php //$row2['id']++;
                                        //} ?>
                                        <?php

                                        $sql = "SELECT * FROM `training_calendar` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id' AND topic= 'Behavioral Safty Training'";
                                        // Execute query
                                        $db->sql($sql);
                                        // store result 
                                        $res2 = $db->getResult(); //print_r($res2);

                                        //foreach ($res2 as $row2) {

                                        ?>
                                            <tr>
                                                <td rowspan="2" style="border: 1px solid black;">Behavioral Safty Training</td>
                                                <td style="border: 1px solid black;">P</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_plan_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_plan_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">A</td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['apr_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['may_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jun_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jul_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['aug_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['sep_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[0]['oct_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[1]['nov_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[2]['dec_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['jan_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['feb_actual_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $res2[3]['mar_actual_date']; ?></td>
                                            </tr>
                                        <?php //$row2['id']++;
                                        //} ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><br /><br />

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