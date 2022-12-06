<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$date = $_GET['date'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `mass_meeting_attandance` WHERE date = '$date' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $date = $row['date'];
$time = $row['time'];
$venue = $row['venue'];
$meeting_no = $row['meeting_no'];
$chaired_by = $row['chaired_by'];
$doc_no = $row['doc_no'];
$rev = $row['rev'];
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
                    <div class="row">
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available; height: 250px;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <p><b>Safety Performance Review mass- Meeting</b></p>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div>
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-5" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>DATE :</b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p><b><?php echo $date; ?></b></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>TIME:</b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p><b><?php echo $time; ?></b></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>VENUE :</b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p><b><?php echo $venue; ?></b></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>MEETING NO.</b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p><b><?php echo $meeting_no; ?></b></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>CHAIRED BY:</b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p><b><?php echo $chaired_by; ?></b></p>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <p><b>Attendance Sheet:</b></p>
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
                                            <!--<th style="border: 1px solid black;">No.</th>-->
                                            <th style="border: 1px solid black;">S No.</th>
                                            <th style="border: 1px solid black;">Name</th>
                                            <th style="border: 1px solid black;">Attendance</th>
                                            <th style="border: 1px solid black;">Signature</th>
                                        </tr>
                                        <?php
                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <!--<td style="border: 1px solid black;"><?php echo $row['id']; ?></td>-->
                                                <td style="border: 1px solid black;"><?php echo $i;
                                                                                        $i++; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['emp_name']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['attendance']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo '<img src="' . DOMAIN_URL . 'upload/signature/' . $row['signature'] . '" height="50">'; ?></td>
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
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p><b>Document No : <?php echo $doc_no; ?></b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p><b>Rev : <?php echo $rev; ?></b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p><b>Date : <?php echo $date; ?></b></p>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
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