<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$form_no = $_GET['form_no'];
$location = $_GET['location'];
$format_no = $_GET['format_no'];
$audit_date = $_GET['audit_date'];
$department = $_GET['department'];

$sql = "SELECT * FROM `capa` WHERE form_no = '$form_no' AND location = '$location' AND format_no = '$format_no' AND audit_date = '$audit_date' AND department = '$department'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();

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
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;background-color: lightgray;border: 1px solid black;">
                                    <h2><b><u>MANDAL ENGINEERING</u></b></h2>
                                </div>
                                <div class="col-xs-9" style="text-align-last: left;border: 1px solid black;">
                                    <h4><b>Form No : <?php echo $form_no; ?></b></h4>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                    <h4>Format No - <?php echo $format_no; ?></h4>
                                </div>

                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <h2><b><u>Corrective Action and Preventive Action (CAPA)</u></b></h2>
                                </div><br /><br />
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <h4><b>Date of Audit : <?php echo $audit_date; ?></b></h4>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;">
                                    <h4><b>Dept. : <?php echo $department; ?></b></h4>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;">
                                    <h4><b>Location : <?php echo $location; ?></b></h4>
                                </div><br /><br />
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <h4><b>Brief Description of severity - 1. 2. 3.</b></h4>
                                </div>
                            </div><br />
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br /><br />
                    
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">

                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <!--<th style="border: 1px solid black;">No.</th>-->
                                            <th style="border: 1px solid black;">Root Cause</th>
                                            <th style="border: 1px solid black;">Corrective Action</th>
                                            <th style="border: 1px solid black;">Preventive Action</th>
                                            <th style="border: 1px solid black;">Consequence Management, if any</th>
                                            <th style="border: 1px solid black;">Responsibility</th>
                                            <th style="border: 1px solid black;">Target Date</th>
                                            <th style="border: 1px solid black;">Status</th>
                                        </tr>
                                        <?php
                                        foreach ($res as $row) {

                                        ?>
                                            <tr>
                                                <!--<td style="border: 1px solid black;"><?php echo $row['id']; ?></td>-->
                                                <td style="border: 1px solid black;"><?php echo $row['root_cause']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['corrective_action']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['preventive_action']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['consequence']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['responsibility']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['target_date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['status']; ?></td>
                                            </tr>
                                        <?php $row['root_cause']++;
                                        } ?>
                                    </table>
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