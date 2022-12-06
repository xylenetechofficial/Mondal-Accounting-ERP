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
$fromat_no = $_GET['fromat_no'];

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

$sql = "SELECT * FROM `grivance_records` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult(); //print_r($res2);

foreach ($res as $row)
    $id = $row['id'];
$prepared_by_name = $row['prepared_by_name'];
$prepared_by_sign = $row['prepared_by_sign'];
$checked_by_name = $row['checked_by_name'];
$checked_by_sign = $row['checked_by_sign'];

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
                        <div class="box">
                            <div class="col-xs-12" style="text-align-last: center; border: 1px solid black;">
                                <h1><b>MANDAL ENGINEERING</b></h1>
                            </div>
                            <div class="col-xs-12" style="text-align-last: center; border: 1px solid black;">
                                <h1><b>GRIEVANCE REDRESSAL STATUS REPORT</b></h1>
                            </div>
                            <div class="col-xs-9" style="text-align-last: center; border: 1px solid black;">
                                <p><b>As Month - FY <?php echo $y; ?>-<?php echo $ny; ?></b></p>
                            </div>
                            <div class="col-xs-3" style="text-align-last: left; border: 1px solid black;">
                                <p>Format No : <?php echo $fromat_no; ?></p>
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
                                            <th colspan="3" style="border: 1px solid black;"><u>ME GRIVANCE CHART FY <?php echo $y; ?>-<?php echo $ny; ?></u></th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black;">Month</th>
                                            <th style="border: 1px solid black;">Total no of grivance open</th>
                                            <th style="border: 1px solid black;">Total no of grivance close</th>
                                        </tr>
                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'April' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Apr-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'May' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">May-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'June' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Jun-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'July' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Jul-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'August' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Aug-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'September' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Sep-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'October' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Oct-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'November' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Nov-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'December' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Dec-<?php echo $y; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'January' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Jan-<?php echo $ny; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'February' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Feb-<?php echo $ny; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>

                                        <?php
                                        $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND month= 'March' AND location_id= '$location_id' group by month";
                                        $db->sql($sql);
                                        $res = $db->getResult(); //print_r($res);

                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;">Mar-<?php echo $ny; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_open']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['total_grivance_close']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><br /><br />

                    <div class="row">
                        <div class="col-xs-4">
                                <?php
                                $sql = "SELECT SUM(grivance_open) AS total_grivance_open,SUM(grivance_close) AS total_grivance_close, month, year FROM grivance_records WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id' GROUP BY month ORDER BY id ASC";
                                $db->sql($sql);
                                $result_order = $db->getResult(); ?>
                                <div class="tile-stats" style="padding:10px;">
                                    <div id="earning_chart" style="width:100%;height:350px;"></div>
                                </div>
                        </div>
                    </div><br /><br />

                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">

                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border: 1px solid black;">Action Taken</th>
                                            <th style="border: 1px solid black;">Name</th>
                                            <th style="border: 1px solid black;">Signature</th>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;">Prepared By</td>
                                            <td style="border: 1px solid black;"><?php echo $prepared_by_name; ?></td>
                                            <td style="border: 1px solid black;"><?php echo '<img src="' . $prepared_by_sign . '" height="80">'; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">Checked & Review By</td>
                                            <td style="border: 1px solid black;"><?php echo $checked_by_name; ?></td>
                                            <td style="border: 1px solid black;"><?php echo '<img src="' . $checked_by_sign . '" height="80">'; ?></td>
                                        </tr>
                                    </table>
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

<script type="text/javascript" src="plugins/chartjs/loader.js"></script>

<script>
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year <?php echo $y; ?>-<?php echo $ny; ?>', 'Total No. Of Grivance Open', 'Total No. Of Grivance Close'],
            //['<?= $row['month'] ?>', 'Total No. Of Grivance Open'],
            //['<?= $row['month'] ?>', 'Total No. Of Grivance Close'],
            <?php foreach ($result_order as $row) {
                //$month = $row['month'];
                echo "['" . $row['month'] .'-'. $row ['year'] . "'," . $row['total_grivance_open'] . "," . $row['total_grivance_close'] . "],";
                //echo "['" . $month . "'," . $row['total_grivance_close'] . "],";
            } ?>
        ]);
        var options = {
            chart: {
                title: 'ME GRIVANCE CHART FY <?php echo $y; ?>-<?php echo $ny; ?>',
                //subtitle: 'Total Sale In Last Week (Month: <?php echo date("M"); ?>)',
            }
        };
        var chart = new google.charts.Bar(document.getElementById('earning_chart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>