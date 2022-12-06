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
$name = $_GET['name'];
$date = $_GET['date'];
$department = $_GET['department'];
$control_no = $_GET['control_no'];
$rev = $_GET['rev'];
//$revision_no = $_GET['revision_no'];
//$team = $_GET['team'];
$sop_id = $_GET['sop_type'];
$prepared_by = $_GET['prepared_by'];
$reviewed_by = $_GET['reviewed_by'];
$approved_by = $_GET['approved_by'];
$location_id = $_GET['location_id'];
//$total = $_GET['total'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);
/*
$sql = "SELECT job_steps, responsibility FROM `jha_job_seq` WHERE jha_type = '$ID' AND location_id= '$location_id'";
// Execute query
//print_r($sql);
$db->sql($sql);
// store result 
$res = $db->getResult();
//print_r($res);
foreach ($res as $row)
    $job_steps = $row['job_steps'];
$responsibility = $row['responsibility'];

$sql = "SELECT potential_hazard_name FROM `jha_potential_hazard` WHERE jha_type_id = '$ID' AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $potential_hazard_name = $row1['potential_hazard_name'];

*/
$sql = "SELECT * FROM `sop_process` WHERE sop_id = '$sop_id' AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res2 = $db->getResult();
/*
foreach ($res2 as $row2)
    $safegaurd_name = $row2['safegaurd_name'];
*/
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


$sql = "SELECT name FROM `emp_joining_form` WHERE id = '$emp_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res4 = $db->getResult();
foreach ($res4 as $row4)
    $emp_name1 = $row4;
//print_r($emp_name1);
$emp_name = implode(',', $emp_name1);
//print_r($location);
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
                                <div class="col-xs-12" style="text-align-last: center;color: red;">
                                    <h1>MANDAL ENGINEERING</h1>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <h1>STANDARD OPERATING PROCEDURE (SOP)</h1>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <h1><?php echo $name; ?></h1>
                                </div>
                                
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;border: 1px solid black;">
                            <div class="box">
                                <div class="col-xs-3" style="border: 1px solid black;">
                                    <h3>Control No. : <?php echo $control_no; ?></h3>
                                </div>
                                <div class="col-xs-3" style="border: 1px solid black;">
                                    <h3>Rev. No: <?php echo $rev; ?></h3>
                                </div>
                                <div class="col-xs-3" style="border: 1px solid black;">
                                    <h3>Effective Date: <?php echo $date; ?></h3>
                                </div>
                                <div class="col-xs-3" style="border: 1px solid black;">
                                    <h3>Department : <?php echo $department; ?></h3>
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
                                            <th style="border: 1px solid black;">Step No</th>
                                            <th style="border: 1px solid black;">Activity(WHAT)</th>
                                            <th style="border: 1px solid black;">Associated Requirements/ Hazards/Impacts</th>
                                            <th style="border: 1px solid black;">Responsibility (WHO)</th>
                                            <th style="border: 1px solid black;">Process / tools / PPEs (HOW)</th>
                                            <th style="border: 1px solid black;">Remarks / Reference</th>
                                        </tr>
                                        <?php
                                        foreach ($res2 as $row2) {

                                        ?>
                                        <tr>
                                            <td style="border: 1px solid black;"><?php echo $row2['step']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['activity_name']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['associated_req']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['responsibility']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['process_ppe']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['remarks']; ?></td>
                                        </tr>
                                        <?php $row2['step']++;
                                        } ?>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br>
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">

                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border: 1px solid black;">PREPARED BY</th>
                                            <th style="border: 1px solid black;">CONTRACTOR APPROVED BY</th>
                                            <th style="border: 1px solid black;">APPROVED BY</th>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;"><?= $prepared_by; ?></td>
                                            <td style="border: 1px solid black;"><?= $reviewed_by; ?></td>
                                            <td style="border: 1px solid black;"><?= $approved_by; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black;">Signature with Date: </th>
                                            <th style="border: 1px solid black;">Signature with Date: </th>
                                            <th style="border: 1px solid black;">Signature with Date: </th>
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