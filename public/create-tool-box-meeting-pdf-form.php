<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$project_name = $_GET['project_name'];
$project_date = $_GET['project_date'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `tool_box_meeting` WHERE project_name = '$project_name' AND project_date = '$project_date' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $authorised_by = $row['authorised_by'];
$issue_no = $row['issue_no'];
$date1 = $row['date1'];
$form_no = $row['form_no'];
$page = $row['page'];
$revision = $row['revision'];
$date = $row['date'];
$effective_date = $row['effective_date'];
$project_name = $row['project_name'];
$project_date = $row['project_date'];
$location = $row['location'];
$time = $row['time'];
$topic = $row['topic'];
$conducted_by = $row['conducted_by'];
$tot_no = $row['tot_no'];
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
                    <!--<div class="row">
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available; height: 250px;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div><br /><br />-->
                    
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="padding-top: 20px;padding-bottom: 20px;text-align-last: center;border: 1px solid black;color: red;background-color: peachpuff;font-style: ui-monospace;">
                                    <h1><b><u>MANDAL ENGINEERING</u></b></h1>
                                </div>
                                <div class="col-xs-9" style="text-align-last: center;border: 1px solid black;">
                                    <p><b>SAFETY HEALTH MANAGEMENT SYSTEM</b></p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                    <p>Authorized By : <?php echo $authorised_by; ?></p>
                                </div>
                                <div class="col-xs-9" style="text-align-last: center;border: 1px solid black;">
                                    <p><b>CONTRACTOR SAFETY MANAGEMENT</b></p>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                    <p>Page : <?php echo $page; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <p>Issue No. : <?php echo $issue_no; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <p>DATE : <?php echo $date1; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <p>Form No. <?php echo $form_no; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <p>Revision : <?php echo $revision; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <p>Date: <?php echo $date; ?></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <p>Effective DATE : <?php echo $effective_date; ?></p>
                                </div>
                                <div class="box">
                                    <div class="col-xs-12" style="text-align-last: center;border: 1px solid black;font-style: ui-monospace;">
                                        <h1><b>TOOL BOX SHEET</b></h1>
                                    </div>
                                    <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                        <p><b>Project Name:- <?php echo $project_name; ?></b></p>
                                    </div>
                                    <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                        <p><b>Date: <?php echo $project_date; ?></b></p>
                                    </div>
                                    <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                        <p><b>Location:- </b></p>
                                    </div>
                                    <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                        <p><b><?php echo $location; ?></b></p>
                                    </div>
                                    <div class="col-xs-3" style="text-align-last: left;border: 1px solid black;">
                                        <p><b>Time:- <?php echo $time; ?></b></p>
                                    </div>
                                    <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                        <p><b>Topic:- </b></p>
                                    </div>
                                    <div class="col-xs-7" style="text-align-last: left;border: 1px solid black;">
                                        <p><b><?php echo $topic; ?></b></p>
                                    </div>
                                    <div class="col-xs-8" style="text-align-last: left;border: 1px solid black;">
                                        <p><b>TBT Conducted by:- <?php echo $conducted_by; ?></b></p>
                                    </div>
                                    <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                        <p><b>Total No. </b></p>
                                    </div>
                                    <div class="col-xs-2" style="text-align-last: left;border: 1px solid black;">
                                        <p><b><?php echo $tot_no; ?></b></p>
                                    </div>

                                    <!-- /.box -->
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