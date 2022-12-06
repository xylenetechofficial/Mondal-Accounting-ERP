<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$id = $_GET['id'];
$location_id = $_GET['location_id'];
//$format_no = $_GET['format_no'];
//$audit_date = $_GET['audit_date'];
//$department = $_GET['department'];

$sql = "SELECT * FROM `feedback` WHERE id = '$id' AND location_id = '$location_id' ORDER BY id DESC limit 1";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
    $format_no =  $row['format_no'];
$form_no =  $row['form_no'];
$revision_no =  $row['revision_no'];
$name =  $row['name'];
$department =  $row['department'];
$designation =  $row['designation'];
$date =  $row['date'];
$mobile =  $row['mobile'];
$statement =  $row['statement'];
$agree =  $row['agree'];
$neither_nor =  $row['neither_nor'];
$disagree =  $row['disagree'];
$remarks =  $row['remarks'];
$location =  $row['location'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

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
                                    <h1><b><u>MANDAL ENGINEERING</u></b></h1>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;border: 1px solid black;">
                                    <h4><b>Contractor Safty Management</b></h4>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;border: 1px solid black;">
                                    <h4>Format No - <?php echo $format_no; ?></h4>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;border: 1px solid black;">
                                    <h4><b>Form No : <?php echo $form_no; ?></b></h4>
                                </div>
                                <div class="col-xs-6" style="text-align-last: left;border: 1px solid black;">
                                    <h4>Revision No - <?php echo $revision_no; ?></h4>
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
                                    <h2><b>Employees PPEs Feedback Form </b></h2>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left;border: 1px solid black;">
                                    <h4><b>Employees Details</b></h4>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <h4><b>Name :- <?php echo $name; ?></b></h4>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <h4>Department :- <?php echo $department; ?></h4>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <h4><b>Designation :- <?php echo $designation; ?></b></h4>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <h4>Date - <?php echo $date; ?></h4>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <h4><b>Mobile : <?php echo $mobile; ?></b></h4>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;border: 1px solid black;">
                                    <h4>Location - <?php echo $location; ?></h4>
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
                                            <th style="border: 1px solid black;">Statement</th>
                                            <th style="border: 1px solid black;">Agree</th>
                                            <th style="border: 1px solid black;">Neither Agree Nor Disagree</th>
                                            <th style="border: 1px solid black;">Disagree</th>
                                            <th style="border: 1px solid black;">Remarks</th>
                                        </tr>

                                        <tr>
                                            <!--<td style="border: 1px solid black;"><?php echo $row['id']; ?></td>-->
                                            <td style="border: 1px solid black;"><?php echo $statement; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $agree; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $neither_nor; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $disagree; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $remarks; ?></td>
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