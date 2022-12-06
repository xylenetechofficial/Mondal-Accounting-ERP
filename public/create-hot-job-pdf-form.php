<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$date = $_GET['date'];
$designation = $_GET['designation'];
$department = $_GET['department'];
$job_description = $_GET['job_description'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `hot_job` WHERE date = '$date' AND designation = '$designation' AND department = '$department' AND job_description = '$job_description' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $doc_no = $row['doc_no'];
$rev = $row['rev'];
$effective_date = $row['effective_date'];
$si_no = $row['si_no'];
$date = $row['date'];
$clearance_time_from = $row['clearance_time_from'];
$clearance_time_to = $row['clearance_time_to'];
$clearance_date = $row['clearance_date'];
$permission_given_to = $row['permission_given_to'];
$designation = $row['designation'];
$department = $row['department'];
$to_take_job = $row['to_take_job'];
$section_or_location = $row['section_or_location'];
$job_description = $row['job_description'];
//$check_points = $row['check_points'];
//$marking = $row['marking'];
//$reason_for_no = $row['reason_for_no'];
$executing_signature = $row['executing_signature'];
$executing_agency = $row['executing_agency'];
$executing_name = $row['executing_name'];
$executing_designation = $row['executing_designation'];
$executing_department = $row['executing_department'];
$executing_date = $row['executing_date'];
$executing_time = $row['executing_time'];
$issuer_signature = $row['issuer_signature'];
$issuer_name = $row['issuer_name'];
$issuer_designation = $row['issuer_designation'];
$issuer_department = $row['issuer_department'];
$issuer_date = $row['issuer_date'];
$issuer_time = $row['issuer_time'];
$approver_signature = $row['approver_signature'];
$approver_name = $row['approver_name'];
$approver_designation = $row['approver_designation'];
$approver_department = $row['approver_department'];
$approver_date = $row['approver_date'];
$approver_time = $row['approver_time'];
$return_undertaking_to = $row['return_undertaking_to'];
$return_undertaking_job_descript = $row['return_undertaking_job_descript'];
$return_undertaking_designation = $row['return_undertaking_designation'];
$return_undertaking_department = $row['return_undertaking_department'];
$work_agency_date = $row['work_agency_date'];
$work_agency_sign = $row['work_agency_sign'];
$work_agency_time = $row['work_agency_time'];
$work_agency_name = $row['work_agency_name'];
$work_agency_designation = $row['work_agency_designation'];
$work_agency_department = $row['work_agency_department'];
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
                    </div><br /><br />-->
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
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <p>Form : <?php echo $doc_no; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;">
                                    <p><b>Mandal Engineering</b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: right;">
                                    <p>ORIGINAL - Blue, DUPLICATE - White</p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <p>Rev : #<?php echo $rev; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;">
                                    <p><b>DAILY PRE REQUISTITE FROM HOT JOB</b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: right;">
                                    <p>Si No : <?php echo $effective_date; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <p>Effective date : <?php echo $si_no; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;">
                                    <p>(For Further Instruction / Clarification See Overleaf)</p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: right;">
                                    <p>Date : <?php echo $date; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>The Pre Requistite Form is Require To Be Fill For Any "Hot Work " Job in 'Non Designated Area'</p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>ONE FORM TO BE USED FOR ONE JOB ONLY</p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>This Clearance is Given To For a Single Day From : <?php echo $clearance_time_from; ?> AM / PM To : <?php echo $clearance_time_to; ?> AM / PM For The Date : <?php echo $clearance_date; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>The Permission is Here Given To Mr / Ms : <?php echo $permission_given_to; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Designation : <?php echo $designation; ?> Department / Contractor : <?php echo $department; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>To Take Up The Job : <?php echo $to_take_job; ?> Section / Location : <?php echo $section_or_location; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Brief Description Of Job : <?php echo $job_description; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Following Checkes Have Been Verified</p>
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
                                            <!--<th style="border: 1px solid black;">No.</th>-->
                                            <th style="border: 1px solid black;">S No.</th>
                                            <th style="border: 1px solid black;">Check Points</th>
                                            <th style="border: 1px solid black;">Yes / No</th>
                                            <th style="border: 1px solid black;">Reason For "No" Selection</th>
                                        </tr>
                                        <?php
                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <!--<td style="border: 1px solid black;"><?php echo $row['id']; ?></td>-->
                                                <td style="border: 1px solid black;"><?php echo $i;
                                                                                        $i++; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['check_points']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['marking']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['reason_for_no']; ?></td>
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
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <p>Please Mention All The Points</p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;">
                                    <p>I Certify That The Place As Stated Above is Safe & Work Can Be Started Now</p>
                                </div>
                            </div>
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        </div>
                    </div><br />

                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p>Sign Of Executing <img src="<?= DOMAIN_URL . 'upload/signature/' . $row['executing_signature']; ?>" style="height: 50px;" alt="<?php echo $row['executing_signature']; ?>" class="img-responsive"></p>
                                    <p>Agency : <?php echo $executing_agency; ?></p>
                                    <p>Name : <?php echo $executing_name; ?></p>
                                    <p>Designation : <?php echo $executing_designation; ?></p>
                                    <p>Department : <?php echo $executing_department; ?></p>
                                    <p>Date : <?php echo $executing_date; ?></p>
                                    <p>Time : <?php echo $executing_time; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p>Sign Of Issuer <img src="<?= DOMAIN_URL . 'upload/signature/' . $row['issuer_signature']; ?>" style="height: 50px;" alt="<?php echo $row['issuer_signature']; ?>" class="img-responsive"></p>
                                    <p>Name : <?php echo $issuer_name; ?></p>
                                    <p>Designation : <?php echo $issuer_designation; ?></p>
                                    <p>Department : <?php echo $issuer_department; ?></p>
                                    <p>Date : <?php echo $issuer_date; ?></p>
                                    <p>Time : <?php echo $issuer_time; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left; border: 1px solid black;">
                                    <p>Sign Of Approver <img src="<?= DOMAIN_URL . 'upload/signature/' . $row['approver_signature']; ?>" style="height: 50px;" alt="<?php echo $row['approver_signature']; ?>" class="img-responsive"></p>
                                    <p>Name : <?php echo $approver_name; ?></p>
                                    <p>Designation : <?php echo $approver_designation; ?></p>
                                    <p>Department : <?php echo $approver_department; ?></p>
                                    <p>Date : <?php echo $approver_date; ?></p>
                                    <p>Time : <?php echo $approver_time; ?></p>
                                </div>

                                <div class="col-xs-12" style="text-align-last: center;">
                                    <p><b>Return Undertaking on The Complition of the Job</b></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: right;">
                                    <p>To : <?php echo $return_undertaking_to; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Job Description : <?php echo $return_undertaking_job_descript; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <p>Designation : <?php echo $return_undertaking_designation; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: right;">
                                    <p>Deaprtment : <?php echo $return_undertaking_department; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>We Have Completed The Above job Specified in The Permit To The Work From & Have Removed All the Materials, Men Cleared The Site For Any Left over Fire or Flammable Materials</p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>They Have Been Told To Not Do Any Other Job in The Area Without Fresh Permit</p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Date : <?php echo $work_agency_date; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Sign Of Working Agency : <img src="<?= DOMAIN_URL . 'upload/signature/' . $row['work_agency_sign']; ?>" style="height: 50px;" alt="Mandal Engineering" class="img-responsive"></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Time : <?php echo $work_agency_time; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Name : <?php echo $work_agency_name; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Designation : <?php echo $work_agency_designation; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Department / Contractor : <?php echo $work_agency_department; ?></p>
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