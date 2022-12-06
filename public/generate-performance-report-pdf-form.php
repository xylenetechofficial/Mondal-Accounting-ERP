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

$month_from = $_GET['month_from'];
$month_to = $_GET['month_to'];
$doc_no = $_GET['doc_no'];
$rev_no = $_GET['rev_no'];
$date = $_GET['date'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `performance_report` WHERE month_from = '$month_from' AND month_to= '$month_to' AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res2 = $db->getResult();

foreach ($res2 as $row2)
    $id = $row2['id'];

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
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">
                                <div class="col-xs-12" style="border: 1px solid black; text-align-last: center; background-color:gray; padding-top: 10px; padding-bottom: 20px;">
                                    <h3><b>Performance Report</b></h3>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br />
                    <div class="row">
                        <div class="box">
                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                <h6><b>From</b></h6>
                            </div>
                            <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                <h6><?php echo $row2['report_from']; ?></h6>
                            </div>
                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                <h6><b>To </b></h6>
                            </div>
                            <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                <h6><?php echo $row2['report_to']; ?></h6>
                            </div>
                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                <h6><b>M(From)</b></h6>
                            </div>
                            <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                <h6><?php echo $row2['month_from']; ?></h6>
                            </div>
                            <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                <h6><b>M(To)</b></h6>
                            </div>
                            <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                <h6><?php echo $row2['month_to']; ?></h6>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <br /><br />
                    </div>
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border: 1px solid black;">ID.</th>
                                            <th style="border: 1px solid black;">Objective</th>
                                            <th style="border: 1px solid black;">Department</th>
                                            <th style="border: 1px solid black;">Past Perform</th>
                                            <th style="border: 1px solid black;">Forecast Perform</th>
                                            <th style="border: 1px solid black;">Actual Perform</th>
                                            <th style="border: 1px solid black;">Line of Improve</th>
                                            <th style="border: 1px solid black;">Action Taken</th>
                                        </tr>
                                        <?php
                                        foreach ($res2 as $row2) {

                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;"><?php echo $row2['id']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['objective']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['department']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['past_perform']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['forecast_perform']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['actual_perform']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['line_of_improve']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['action_taken']; ?></td>
                                            </tr>
                                        <?php $row2['id']++;
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="box">
                            <div class="col-xs-4" style="text-align-last: left;">
                                <h4>Doc No : <?php echo $doc_no; ?></h4>
                            </div>
                            <div class="col-xs-4" style="text-align-last: left;">
                                <h4>Rev : <?php echo $rev_no; ?></h4>
                            </div>
                            <div class="col-xs-4" style="text-align-last: left;">
                                <h4>Date : <?php echo $date; ?></h4>
                            </div>
                        </div>
                        <!-- /.box -->
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