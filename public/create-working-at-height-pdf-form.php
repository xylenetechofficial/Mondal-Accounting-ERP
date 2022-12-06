<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$date = $_GET['date'];
$agency_name = $_GET['agency_name'];
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

$sql = "SELECT * FROM `working_at_height` WHERE date = '$date' AND agency_name = '$agency_name' AND job_description = '$job_description' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $doc_no = $row['doc_no'];
$ref_no = $row['ref_no'];
$rev = $row['rev'];
$si_no = $row['si_no'];
$effective_date = $row['effective_date'];
$date = $row['date'];
$agency_name = $row['agency_name'];
$exact_location = $row['exact_location'];
$job_description = $row['job_description'];
$duration_time_from = $row['duration_time_from'];
$duration_time_to = $row['duration_time_to'];
$commencement_date = $row['commencement_date'];
$check_points = $row['check_points'];
$marking = $row['marking'];
$site_engg_name = $row['site_engg_name'];
$site_engg_sign = $row['site_engg_sign'];
$site_engg_date = $row['site_engg_date'];
$mandal_engg_name = $row['mandal_engg_name'];
$mandal_engg_sign = $row['mandal_engg_sign'];
$mandal_engg_date = $row['mandal_engg_date'];
$hod_sign = $row['hod_sign'];
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
                                    <p>Ref : <?php echo $ref_no; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <p>Rev : #<?php echo $rev; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;">
                                    <p><b><u>WORK PERMIT FOR WORKING AT HEIGHT</u></b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: right;">
                                    <p>Si No : <?php echo $si_no; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <p>Effective date : <?php echo $effective_date; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: center;">
                                    <p></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: right;">
                                    <p>Date : <?php echo $date; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Name Of Agency : <?php echo $agency_name; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Exact Location : <?php echo $exact_location; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Brief Description Of Job : <?php echo $job_description; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Duration Of Job From : <?php echo $duration_time_from; ?> AM / PM To : <?php echo $duration_time_to; ?> AM / PM For Date Of Commencement : <?php echo $commencement_date; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Following Safty Measures Are To Be Checked Bebore Taking Up Work At Height</p>
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
                                            <th style="border: 1px solid black;">Safty Measure Points</th>
                                            <th style="border: 1px solid black;">Checked Status</th>
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
                                            </tr>
                                        <?php $row['id']++;
                                        } ?>
                                    </table>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>We Hereby Declare That Above Safty Precautions Have Been Taken.</p>
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
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Please Mention All The Points</p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: center;">
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
                                <div class="col-xs-12" style="text-align-last: right;">
                                    <p><img src="<?= DOMAIN_URL . 'upload/signature/' . $row['site_engg_sign']; ?>" style="height: 50px;" alt="<?php echo $row['site_engg_sign']; ?>" class="img-responsive"></p><br />
                                    <p>Signature Of Site Engineer Of Contractor / Agency</p>
                                    <p>Name : <?php echo $site_engg_name; ?></p>
                                    <p>Date : <?php echo $site_engg_date; ?></p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p>Inspected The Site & Safty Measures Taken By Agency / Contractor Found To Be Adequate</p>
                                </div>
                                <div class="col-xs-12" style="text-align-last: right;">
                                    <p><img src="<?= DOMAIN_URL . 'upload/signature/' . $row['mandal_engg_sign']; ?>" style="height: 50px;" alt="<?php echo $row['mandal_engg_sign']; ?>" class="img-responsive"></p><br />
                                    <p>Signature Of Site Engineer Of Mandal Engineering</p>
                                    <p>Name : <?php echo $mandal_engg_name; ?></p>
                                    <p>Date : <?php echo $mandal_engg_date; ?></p><br />
                                    <p><img src="<?= DOMAIN_URL . 'upload/signature/' . $row['hod_sign']; ?>" style="height: 50px;" alt="<?php echo $row['hod_sign']; ?>" class="img-responsive"></p>
                                    <p>Signature Of HOD</p>
                                </div><br /><br /><br />

                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p><b>Note - </b></p>
                                    <ol type="i">
                                        <li>This Form is Be Filled Up in Triplicate By The Agency Seeking Height Permit</li>
                                        <li>First Copy (White) To Be Issued To The Acceptor Agency / Contractor</li>
                                        <li>Second Copy (Pink) To Be Submitted To Safty Dept</li>
                                        <li>Third Copy (Yellow) To Be Retained By The Issuer Department</li>
                                    </ol>
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