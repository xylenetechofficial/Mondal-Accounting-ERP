<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$site_area = $_GET['site_area'];
$dept = $_GET['dept'];
$date2 = $_GET['date2'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `hazard` WHERE site_area = '$site_area' AND dept = '$dept' AND date2 = '$date2' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $assesment_no = $row['assesment_no'];
$company_name = $row['company_name'];
$site_area = $row['site_area'];
$revision = $row['revision'];
$prepared_by = $row['prepared_by'];
$date1 = $row['date1'];
$sign1 = $row['sign1'];
$dept = $row['dept'];
$date2 = $row['date2'];
$sign2 = $row['sign2'];
$scope = $row['scope'];
$location_id = $row['location_id'];
$location = $row['location'];


$sql = "SELECT * FROM `hazard_mapping` WHERE location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $task = $row['task'];
$risk = $row['risk'];
$initial_nce = $row['initial_nce'];
$initial_liklihood = $row['initial_liklihood'];
$initial_rating = $row['initial_rating'];
$proposed_control = $row['proposed_control'];
$residual_nce = $row['residual_nce'];
$residual_liklihood = $row['residual_liklihood'];
$residual_rating = $row['residual_rating'];
$action_by = $row['action_by'];
$action_date = $row['action_date'];
$completed_by = $row['completed_by'];
$completed_date = $row['completed_date'];

$i = 1;

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
                    <!--<div class="row">
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available; height: 250px;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <p><b>Safety Performance Review mass- Meeting</b></p>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-9" style="text-align-last: center;">
                                    <p>Mandal Engineering</p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: right;">
                                    <p>RISK ASSESSMENT NO: <?php echo $assesment_no; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center; background-color: blue;">
                                    <p><b>HAZARD IDENTIFICATION AND RISK ASSESSMENT</b></p>
                                </div>

                                <div class="col-xs-2" style="text-align-last: left;background-color: lavender;border: 1px solid black;">
                                    <p>Company</p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                    <p><?php echo $company_name; ?></p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left;background-color: lavender;border: 1px solid black;">
                                    <p>Site Area</p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                    <p><?php echo $site_area; ?></p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;background-color: lavender;border: 1px solid black;">
                                    <p>Revision</p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;">
                                    <p><?php echo $revision; ?></p>
                                </div>

                                <div class="col-xs-2" style="text-align-last: left;background-color: lavender;border: 1px solid black;height: 42px;">
                                    <p>Prepared By:</p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;height: 42px;">
                                    <p><?php echo $prepared_by; ?></p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;background-color: lavender;border: 1px solid black;height: 42px;">
                                    <p>Date</p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;height: 42px;">
                                    <p><?php echo $date1; ?></p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;background-color: lavender;border: 1px solid black;height: 42px;">
                                    <p>Sign:</p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;height: 42px;">
                                    <img src="<?= $sign1; ?>" style="height: 30px;" alt="<?php echo $sign1; ?>" class="img-responsive">
                                </div>

                                <div class="col-xs-2" style="text-align-last: left;background-color: lavender;border: 1px solid black;height: 42px;">
                                    <p>DEPT:</p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;height: 42px;">
                                    <p><?php echo $dept; ?></p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;background-color: lavender;border: 1px solid black;height: 42px;">
                                    <p>Date</p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;height: 42px;">
                                    <p><?php echo $date2; ?></p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;background-color: lavender;border: 1px solid black;height: 42px;">
                                    <p>Sign:</p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;height: 42px;">
                                    <p><img src="<?= $sign2; ?>" style="height: 30px;" alt="<?php echo $sign2; ?>" class="img-responsive"></p>
                                </div>

                                <div class="col-xs-2" style="text-align-last: left;background-color: lavender;border: 1px solid black;height: 42px;">
                                    <p>Scope:</p>
                                </div>
                                <div class="col-xs-10" style="text-align-last: left;border: 1px solid black;height: 42px;">
                                    <p><?php echo $scope; ?></p>
                                </div>

                                <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>Lookup Detail:</b> User selects one Consequence and one Likelihood (result is determined automatically)</p>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div>
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">

                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th rowspan="2" colspan="2" style="border: 1px solid black;"></th>
                                            <th colspan="5" style="border: 1px solid black;">Consequence</th>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">1<br />Minor<br />First Aid Injury<br />$10k - $100k</td>
                                            <td style="border: 1px solid black;">2<br />Medium<br />MTI<br />$100k - $500k</td>
                                            <td style="border: 1px solid black;">3<br />Serious<br />RWI<br />$500K - $2M</td>
                                            <td style="border: 1px solid black;">4<br />Major<br />LTI<br />$2M - $20M</td>
                                            <td style="border: 1px solid black;">5<br />Catastrophic<br />Fatality<br />> $20M</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="5" style="border: 1px solid black;writing-mode: vertical-lr;text-align-last: center;"><b>Likelihood</b></td>
                                            <td style="border: 1px solid black;background-color: white;"><b>A - Almost Certain</b><br />>1 per week (>25%)</td>
                                            <td style="border: 1px solid black;background-color: yellow;"><b>MODERATE 11</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 16</b></td>
                                            <td style="border: 1px solid black;background-color: red;"><b>EXTREME 20</b></td>
                                            <td style="border: 1px solid black;background-color: red;"><b>EXTREME 23</b></td>
                                            <td style="border: 1px solid black;background-color: red;"><b>EXTREME 25</b></td>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;background-color: white;"><b>B - Likely</b><br />1/week - 1/month (10-25%)</td>
                                            <td style="border: 1px solid black;background-color: yellow;"><b>MODERATE 7</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 12</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 17</b></td>
                                            <td style="border: 1px solid black;background-color: red;"><b>EXTREME 21</b></td>
                                            <td style="border: 1px solid black;background-color: red;"><b>EXTREME 24</b></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;background-color: white;"><b>C - Possible</b><br />1/month - 1/year (1-10%)</td>
                                            <td style="border: 1px solid black;background-color: green;"><b>LOW 4</b></td>
                                            <td style="border: 1px solid black;background-color: yellow;"><b>MODERATE 8</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 13</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 18</b></td>
                                            <td style="border: 1px solid black;background-color: red;"><b>EXTREME 22</b></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;background-color: white;"><b>D - Unlikely</b><br />1/year - 1/10 years (0.1-1%)</td>
                                            <td style="border: 1px solid black;background-color: green;"><b>LOW 2</b></td>
                                            <td style="border: 1px solid black;background-color: green;"><b>LOW 5</b></td>
                                            <td style="border: 1px solid black;background-color: yellow;"><b>MODERATE 9</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 14</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 19</b></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;background-color: white;"><b>E - Rare</b><br />
                                                < 1/10 years (0.1%)</td>
                                            <td style="border: 1px solid black;background-color: green;"><b>LOW 1</b></td>
                                            <td style="border: 1px solid black;background-color: green;"><b>LOW 3</b></td>
                                            <td style="border: 1px solid black;background-color: green;"><b>LOW 6</b></td>
                                            <td style="border: 1px solid black;background-color: yellow;"><b>MODERATE 10</b></td>
                                            <td style="border: 1px solid black;background-color: orange;"><b>HIGH 15</b></td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div><br />
                    <div class="row">
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <p><b>Hazard Identification and Risk Assessment for cutting with gas</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">

                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th rowspan="2" style="border: 1px solid black;background-color: peachpuff;">S No.</th>
                                            <th rowspan="2" style="border: 1px solid black;background-color: peachpuff;">Task or Activity</th>
                                            <th rowspan="2" style="border: 1px solid black;background-color: peachpuff;">Hazard or Risk (Potential danger)</th>
                                            <th colspan="3" style="border: 1px solid black;background-color: peachpuff;">Initial Risk Score</th>
                                            <th rowspan="2" style="border: 1px solid black;background-color: peachpuff;">Proposed Control Measure</th>
                                            <th colspan="3" style="border: 1px solid black;background-color: peachpuff;">Residual Risk Score</th>
                                            <th colspan="2" style="border: 1px solid black;background-color: peachpuff;">Action</th>
                                            <th colspan="2" style="border: 1px solid black;background-color: peachpuff;">Completed</th>

                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black;background-color: peachpuff;writing-mode: vertical-lr;text-align-last: center;">nce</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;writing-mode: vertical-lr;text-align-last: center;">Likelihood</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;writing-mode: vertical-lr;text-align-last: center;">Risk Rating</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;writing-mode: vertical-lr;text-align-last: center;">nce</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;writing-mode: vertical-lr;text-align-last: center;">Likelihood</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;writing-mode: vertical-lr;text-align-last: center;">Risk Rating</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;">By</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;">Date</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;">By</th>
                                            <th style="border: 1px solid black;background-color: peachpuff;">Date</th>
                                        </tr>
                                        <?php
                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;"><?php echo $i;
                                                                                        $i++; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['task']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['risk']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['initial_nce']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['initial_liklihood']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['initial_rating']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['proposed_control']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['residual_nce']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['residual_liklihood']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['residual_rating']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['action_by']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['action_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['completed_by']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['completed_date']; ?></td>
                                            </tr>
                                        <?php $row['id']++;
                                        } ?>
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