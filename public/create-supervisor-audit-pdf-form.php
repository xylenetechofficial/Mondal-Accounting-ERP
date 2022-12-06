<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$audit_date = $_GET['audit_date'];
$department = $_GET['department'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `supervisor_audit` WHERE audit_date = '$audit_date' AND department = '$department' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $department = $row['department'];
$section = $row['section'];
$audit_date = $row['audit_date'];
$time = $row['time'];
$dept_representative = $row['dept_representative'];
$team_member1 = $row['team_member1'];
$team_member2 = $row['team_member2'];
$team_member3 = $row['team_member3'];
$team_member4 = $row['team_member4'];
$team_member5 = $row['team_member5'];
$team_member6 = $row['team_member6'];
$contract_name_vendor_code = $row['contract_name_vendor_code'];
$tot_contract_people_working = $row['tot_contract_people_working'];
$violation_subtotal = $row['violation_subtotal'];
$violation_severity_subtotal = $row['violation_severity_subtotal'];
$severity_index = $row['severity_index'];
$checked_by = $row['checked_by'];
$reviewed_by = $row['reviewed_by'];
$doc_no = $row['doc_no'];
$rev = $row['rev'];
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
                                    <h2><b>CONTRACTOR SAFTY AUDIT</b></h2>
                                </div>
                                <div class="col-xs-5" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>Department : <?php echo $department; ?></b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>Section : <?php echo $section; ?></b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>Date : <?php echo $audit_date; ?></b></p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                    <p><b>TIME :</b></p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                    <p><b> <?php echo $time; ?></b></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p>Departmental Representative : <?php echo $dept_representative; ?></p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;height: 32px;">
                                    <p> </p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black;">
                                    <p>Team Members</p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p>Description Of Severity Rating :</p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;height: 32px;">
                                    <p> </p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black;">
                                    <p><?php echo $team_member1; ?></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p>1=Untidy Area, Minor Issues, Sets Poor Example</p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;height: 32px;">
                                    <p> </p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black;">
                                    <p><?php echo $team_member2; ?></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p>2=Restricted Access, Unacceptable Trash, Disorderly</p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;height: 32px;">
                                    <p> </p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black;">
                                    <p><?php echo $team_member3; ?></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p>3=Rule or Procedure Violation, Potential Injury</p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;height: 32px;">
                                    <p> </p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black;">
                                    <p><?php echo $team_member4; ?></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p>4=Unsafe Condition, Serius Injury Potential</p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;height: 32px;">
                                    <p> </p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black;">
                                    <p><?php echo $team_member5; ?></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                    <p>5=Immediate Serious Injury Potential, Stop Activity Immediately & Correct</p>
                                </div>
                                <div class="col-xs-1" style="text-align-last: left;border: 1px solid black;height: 32px;">
                                    <p> </p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;border: 1px solid black;">
                                    <p><?php echo $team_member6; ?></p>
                                </div>
                                <div class="col-xs-7" style="text-align-last: center;border: 1px solid black;">
                                    <p><b>Name Of Contractors With Vendor Code </b></p>
                                </div>
                                <div class="col-xs-5" style="text-align-last: center;border: 1px solid black;">
                                    <p><b><?php echo $contract_name_vendor_code; ?></b></p>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">

                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border: 1px solid black;"> </th>
                                            <th style="border: 1px solid black;">Total Contractor People Working At Site</th>
                                            <th style="border: 1px solid black;"><?php echo $tot_contract_people_working; ?></th>
                                            <th colspan="5" style="border: 1px solid black;">Criteria</th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black;">S No.</th>
                                            <th style="border: 1px solid black;">Description</th>
                                            <th style="border: 1px solid black;writing-mode: vertical-lr;">Good Citizen</th>
                                            <th style="border: 1px solid black;writing-mode: vertical-lr;">No. of Violation</th>
                                            <th style="border: 1px solid black;writing-mode: vertical-lr;">Severity</th>
                                            <th style="border: 1px solid black;writing-mode: vertical-lr;">Violation x Severity</th>
                                            <th style="border: 1px solid black;writing-mode: vertical-lr;">Potential 4 & 5 Fatality & Serious</th>
                                            <th style="border: 1px solid black;writing-mode: vertical-lr;">Unsafe Act (UA)/Unsafe Condition (UC)</th>
                                        </tr>
                                        <?php
                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <!--<td style="border: 1px solid black;"><?php echo $row['id']; ?></td>-->
                                                <td style="border: 1px solid black;"><?php echo $i;
                                                                                        $i++; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['description']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['good_citizen']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['violation_no']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['severity']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['violation_severity']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['potential_fatality']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['ua_uc']; ?></td>
                                            </tr>
                                        <?php $row['id']++;
                                        } ?>
                                        <tr>
                                            <th style="border: 1px solid black;"></th>
                                            <th style="border: 1px solid black;">Subtotals</th>
                                            <th style="border: 1px solid black;"></th>
                                            <th style="border: 1px solid black;"><?php echo $violation_subtotal; ?></th>
                                            <th style="border: 1px solid black;"></th>
                                            <th style="border: 1px solid black;"><?php echo $violation_severity_subtotal; ?></th>
                                            <th style="border: 1px solid black;"></th>
                                            <th style="border: 1px solid black;"></th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black;"></th>
                                            <th style="border: 1px solid black;">Severity Index = (Total Of Violation x Severity) Divided By Total No Of Violation</th>
                                            <th colspan="6" style="border: 1px solid black;"><?php echo $severity_index; ?></th>
                                        </tr>
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
                                <div class="col-xs-2" style="text-align-last: left; border: 1px solid black; height:50;">
                                    <p><b>Checked By</b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p><?php echo '<img src="' . DOMAIN_URL . 'upload/signature/' . $row['checked_by'] . '" height="50">'; ?></p>
                                </div>
                                <div class="col-xs-2" style="text-align-last: left; border: 1px solid black; height:50;">
                                    <p><b>Reviewed By</b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p><?php echo '<img src="' . DOMAIN_URL . 'upload/signature/' . $row['reviewed_by'] . '" height="50">'; ?></p>
                                </div>
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