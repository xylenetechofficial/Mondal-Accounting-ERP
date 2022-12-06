<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$date = $_GET['date'];
$month = $_GET['month'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `ppe_data` WHERE date = '$date' AND month = '$month' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $doc_no = $row['doc_no'];
$rev = $row['rev'];
$effective_date = $row['effective_date'];
$month = $row['month'];
$emp_name = $row['emp_name'];
$emp_code = $row['emp_code'];
$designation = $row['designation'];
$helmet = $row['helmet'];
$safty_shoes = $row['safty_shoes'];
$visibility_vest = $row['visibility_vest'];
$safty_glases = $row['safty_glases'];
$hand_gloves = $row['hand_gloves'];
$face_shield = $row['face_shield'];
$ear_plugs = $row['ear_plugs'];
$shin_guards = $row['shin_guards'];
$dust_mask = $row['dust_mask'];
$hand_sleeves = $row['hand_sleeves'];
$leather_appron = $row['leather_appron'];
$remarks = $row['remarks'];
$checked_by = $row['checked_by'];
$reviewed_by = $row['reviewed_by'];
$date = $row['date'];

$i = 1;

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
                        <div class="col-xs-12" style="text-align-last: center; background-color: lightgray;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;border: 1px solid black; color: orangered;">
                                    <h1><b>MANDAL ENGINEERING</b></h1>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;border: 1px solid black; color: black;">
                                    <h2><b>PPE INSPECTION MONTHLY CHECKLIST</b></h2>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black; color: orangered;">
                                    <p><b>Doc No : <?php echo $doc_no; ?></b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black; color: orangered;">
                                    <p><b>Rev No. : <?php echo $rev; ?></b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black; color: orangered;">
                                    <p><b>Effective Date : <?php echo $effective_date; ?></b></p>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
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
                                            <th rowspan="2" style="border: 1px solid black;">S No.</th>
                                            <th colspan="13" style="border: 1px solid black;"></th>
                                            <th style="border: 1px solid black;">Month :-</th>
                                            <th style="border: 1px solid black;"><?php echo $month; ?></th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black;">Name Of Employee</th>
                                            <th style="border: 1px solid black;">Employee Code</th>
                                            <th style="border: 1px solid black;">Designation</th>
                                            <th style="border: 1px solid black;">Helmet</th>
                                            <th style="border: 1px solid black;">Safty Shoes</th>
                                            <th style="border: 1px solid black;">Visibility Vest</th>
                                            <th style="border: 1px solid black;">Safty Glasses</th>
                                            <th style="border: 1px solid black;">Hand Gloves</th>
                                            <th style="border: 1px solid black;">Face Shield</th>
                                            <th style="border: 1px solid black;">Ear Plug</th>
                                            <th style="border: 1px solid black;">Shin Guards</th>
                                            <th style="border: 1px solid black;">Dust Mask</th>
                                            <th style="border: 1px solid black;">Hand Sleeves</th>
                                            <th style="border: 1px solid black;">Leather Appron</th>
                                            <th style="border: 1px solid black;">Remarks</th>
                                        </tr>
                                        <?php
                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td style="border: 1px solid black;"><?php echo $i;
                                                                                        $i++; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['emp_name']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['emp_code']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['designation']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['helmet']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['safty_shoes']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['visibility_vest']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['safty_glases']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['hand_gloves']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['face_shield']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['ear_plugs']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['shin_guards']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['dust_mask']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['hand_sleeves']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['leather_appron']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['remarks']; ?></td>
                                            </tr>
                                        <?php $row['id']++;
                                        } ?>

                                        <tr>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;color: lightskyblue;"><b>OK</b></td>
                                            <td style="border: 1px solid black;"><b>If Physical Condition is Good</b></td>
                                            <td style="border: 1px solid black;color: lightskyblue;"><b>NOT OK</b></td>
                                            <td style="border: 1px solid black;"><b>If Physical Condition is Not Good</b></td>
                                            <td style="border: 1px solid black;color: lightskyblue;"><b>N/A</b></td>
                                            <td style="border: 1px solid black;"><b>If Not Required</b></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;"></td>
                                            <td style="border: 1px solid black;color: lightskyblue;"><b>Checked By : </b></td>
                                            <td colspan="5" style="border: 1px solid black;"><b><?php echo $checked_by; ?></b></td>
                                            <td colspan="2" style="border: 1px solid black;color: lightskyblue;"><b>Reviewed By : </b></td>
                                            <td colspan="5" style="border: 1px solid black;"><b><?php echo $reviewed_by; ?></b></td>
                                            <td style="border: 1px solid black;color: lightskyblue;"><b>Date : </b></td>
                                            <td style="border: 1px solid black;"><b><?php echo $date; ?></b></td>
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