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
$location_id = $_GET['location_id'];
$month = $_GET['month'];
$year = $_GET['year'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `monthly_abp` WHERE month = '$month' AND year= '$year' AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res2 = $db->getResult();
/*
foreach ($res2 as $row2)
    $emp_selection_docs = $row2['emp_selection_docs'];
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
                        <div class="col-xs-12" style="padding: 0px;border: 1px solid black;">
                            <div class="box">
                                <div class="col-xs-12" style="border: 1px solid black; text-align-last: center;">
                                    <h2><b>Mandal Engineering Monthly ABP</b></h2>
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
                                            <th style="border: 1px solid black;">No.</th>
                                            <th style="border: 1px solid black;">Particulars</th>
                                            <th style="border: 1px solid black;">Plan Date</th>
                                            <th style="border: 1px solid black;">Actual Date</th>
                                            <th style="border: 1px solid black;">Month</th>
                                            <th style="border: 1px solid black;">Year</th>
                                        </tr>
                                        <?php
                                        foreach ($res2 as $row2) {

                                        ?>
                                        <tr>
                                            <td style="border: 1px solid black;"><?php echo $row2['id']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['abp_name']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['plan_date']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['actual_date']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['month']; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $row2['year']; ?></td>
                                        </tr>
                                        <?php $row2['id']++;
                                        } ?>
                                    </table>
                                </div>
                            </div>
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