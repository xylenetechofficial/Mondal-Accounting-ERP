<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();
$fm = 'January';
$lm = 'December';
$y = $_GET['year'];
$location_id = $_GET['location_id'];

$fdate = strtotime("$fm $y"); //print_r($fdate);
$ldate = strtotime("$lm $y"); //print_r($ldate);

$start_date = date('Y-m-01', $fdate); //print_r($start_date);
$end_date  = date('Y-m-t', $ldate); //print_r($end_date);

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `ofi_report` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "') AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res2 = $db->getResult(); //print_r($res2);

foreach ($res2 as $row2)
    $id = $row2['id'];
    $doc_no = $row2['doc_no'];
    $rev_no = $row2['rev_no'];
    $date = $row2['date'];

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
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">
                                <div class="col-xs-12" style="border: 1px solid black; text-align-last: center; background-color:gray; padding-top: 10px; padding-bottom: 20px;">
                                    <h3><b>INTERNAL AUDIT PLAN</b></h3>
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
                                            <th style="border: 1px solid black;">ID.</th>
                                            <th style="border: 1px solid black;">Department</th>
                                            <th style="border: 1px solid black;">Document</th>
                                            <th style="border: 1px solid black;">Activity</th>
                                            <th colspan="4" style="border: 1px solid black;">Enter Actual Audit Plan Month Audit Completed Date & Audit Close Date </th>

                                        </tr>
                                        <?php
                                        foreach ($res2 as $row2) {

                                        ?>
                                            <tr>
                                                <td rowspan="3" style="border: 1px solid black;"><?php echo $row2['id']; ?></td>
                                                <td rowspan="3" style="border: 1px solid black;"><?php echo $row2['department']; ?></td>
                                                <td rowspan="3" style="border: 1px solid black;"><?php echo $row2['document']; ?></td>
                                                <td style="border: 1px solid black;">PL</td>
                                                <td style="border: 1px solid black;"><?php echo $row2['pl1']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['pl2']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['pl3']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['pl4']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">CO</td>
                                                <td style="border: 1px solid black;"><?php echo $row2['co1']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['co2']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['co3']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['co4']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;">CL</td>
                                                <td style="border: 1px solid black;"><?php echo $row2['cl1']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['cl2']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['cl3']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row2['cl4']; ?></td>
                                            </tr>
                                        <?php $row2['id']++;
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="box">
                            <div class="col-xs-4" style="text-align-last: left;">
                                <h4>Doc No : <?php echo $doc_no; ?></h4>
                            </div>
                            <div class="col-xs-4" style="text-align-last: left;">
                                <h4>Rev : <?php echo $rev_no; ?></h4>
                            </div>
                            <div class="col-xs-4" style="text-align-last: left;">
                                <h4>Date : <?php echo $date; ?></h4>
                            </div>
                        </div>
                        <!-- /.box -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br />
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