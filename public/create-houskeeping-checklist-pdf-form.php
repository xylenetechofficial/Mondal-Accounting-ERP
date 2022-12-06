<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

//$id = $_GET['id'];
//print_r($ID);

$location_id = $_GET['location_id'];
$audit_name = $_GET['audit_name'];
$audit_date = $_GET['audit_date'];
$area = $_GET['area'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `houskeeping_checklist` WHERE audit_name = '$audit_name' AND audit_date = '$audit_date' AND area = '$area' AND location_id = '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult();
foreach ($res as $row)
$form_no = $row['form_no'];
$format_no = $row['format_no'];
$audit_name = $row['audit_name'];
$audit_date = $row['audit_date'];
$member_present = $row['member_present'];
$area = $row['area'];
$check_point_type1 = $row['check_point_type1'];
$check_point_action1 = $row['check_point_action1'];
$check_point_type2 = $row['check_point_type2'];
$check_point_action2 = $row['check_point_action2'];
$check_point_type3 = $row['check_point_type3'];
$check_point_action3 = $row['check_point_action3'];
$check_point_type4 = $row['check_point_type4'];
$check_point_action4 = $row['check_point_action4'];
$check_point_type5 = $row['check_point_type5'];
$check_point_action5 = $row['check_point_action5'];
$check_point_type6 = $row['check_point_type6'];
$check_point_action6 = $row['check_point_action6'];
$check_point_type7 = $row['check_point_type7'];
$check_point_action7 = $row['check_point_action7'];
$check_point_type8 = $row['check_point_type8'];
$check_point_action8 = $row['check_point_action8'];
$check_point_type9 = $row['check_point_type9'];
$check_point_action9 = $row['check_point_action9'];
$check_point_type10 = $row['check_point_type10'];
$check_point_action10 = $row['check_point_action10'];
$check_point_type11 = $row['check_point_type11'];
$check_point_action11 = $row['check_point_action11'];
$check_point_type12 = $row['check_point_type12'];
$check_point_action12 = $row['check_point_action12'];
$check_point_type13 = $row['check_point_type13'];
$check_point_action13 = $row['check_point_action13'];
$check_point_type14 = $row['check_point_type14'];
$check_point_action14 = $row['check_point_action14'];
$check_point_type15 = $row['check_point_type15'];
$check_point_action15 = $row['check_point_action15'];
$check_point_type16 = $row['check_point_type16'];
$check_point_action16 = $row['check_point_action16'];
$check_point_type17 = $row['check_point_type17'];
$check_point_action17 = $row['check_point_action17'];
$check_point_type18 = $row['check_point_type18'];
$check_point_action18 = $row['check_point_action18'];
$check_point_type19 = $row['check_point_type19'];
$check_point_action19 = $row['check_point_action19'];
$check_point_type20 = $row['check_point_type20'];
$check_point_action20 = $row['check_point_action20'];
$check_point_type21 = $row['check_point_type21'];
$check_point_action21 = $row['check_point_action21'];
$check_point_type22 = $row['check_point_type22'];
$check_point_action22 = $row['check_point_action22'];
$check_point_type23 = $row['check_point_type23'];
$check_point_action23 = $row['check_point_action23'];
$check_point_type24 = $row['check_point_type24'];
$check_point_action24 = $row['check_point_action24'];
$check_point_type25 = $row['check_point_type25'];
$check_point_action25 = $row['check_point_action25'];
$audit_member_sign = $row['audit_member_sign'];

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
                    </div><br /><br />
                    <div class="row">
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center;">
                                    <h1><b>MONTHLY TOOLS CHECKLIST</b></h1>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-xs-12" style="text-align-last: center;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: center; color: red; background-color: lavender;">
                                    <h1><b><u>MANDAL ENGINEERING</u></b></h1>
                                </div>
                                <div class="col-xs-8" style="text-align-last: left;">
                                    <p><b>Form No : <?php echo $form_no; ?></b></p>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left; background-color: darkgray;">
                                    <p><b>Format No : <?php echo $format_no; ?></b></p>
                                </div>
                            </div>
                        </div>
                    </div><br /><br /><br />
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">

                                <!-- /.box-header -->
                                <div class="box-body table-responsive" style="padding: 0px;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th colspan="4" style="border: 1px solid black;">Checklist for 5S Audit : <?php echo $audit_name; ?></th>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2" style="border: 1px solid black;">Area : <?php echo $area; ?></th>
                                        </tr>
                                        <tr>
                                            <th style="border: 1px solid black;">S No.</th>
                                            <th style="border: 1px solid black;">Check Point</th>
                                            <th style="border: 1px solid black;">Yes / No</th>
                                            <th style="border: 1px solid black;">Action Taken</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" style="border: 1px solid black;">1S - SEIRI (SORT OUT)</th>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;">1</td>
                                            <td style="border: 1px solid black;">Unwanted things lying on M/C. Table , Self Etc.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type1; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action1; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">2</td>
                                            <td style="border: 1px solid black;">Things are not kept which are not in use.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type2; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action2; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">3</td>
                                            <td style="border: 1px solid black;">No Spare component, Tools, File, Papers etc. are Lying unnecessarily.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type3; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action3; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">4</td>
                                            <td style="border: 1px solid black;">Things which cannot be used are removed.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type4; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action4; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">5</td>
                                            <td style="border: 1px solid black;">All notice boards and displays of information are arranged properly.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type5; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action5; ?></td>
                                        </tr>

                                        <tr>
                                            <th colspan="4" style="border: 1px solid black;">2S - SEITON (SET IN ORDER)</th>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;">6</td>
                                            <td style="border: 1px solid black;">Specified place for keeping components. Tools and files.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type6; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action6; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">7</td>
                                            <td style="border: 1px solid black;">Everyone is keeping things at decided place.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type7; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action7; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">8</td>
                                            <td style="border: 1px solid black;">Arrangement of rest room is good</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type8; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action8; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">9</td>
                                            <td style="border: 1px solid black;">Bench, Table, Chair, Computer, Printer, Telephone and cups are kept property.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type9; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action9; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">10</td>
                                            <td style="border: 1px solid black;">The identification system of the entire above is good.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type10; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action10; ?></td>
                                        </tr>

                                        <tr>
                                            <th colspan="4" style="border: 1px solid black;">3S - SEISO (CLEANING)</th>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;">11</td>
                                            <td style="border: 1px solid black;">Whether there is scrap, dust, oil leakage, water leakage.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type11; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action11; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">12</td>
                                            <td style="border: 1px solid black;">cleaning of machine is good</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type12; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action12; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">13</td>
                                            <td style="border: 1px solid black;">Whether dirt, dust, cobweb, oil spillage in the room/workplace.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type13; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action13; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">14</td>
                                            <td style="border: 1px solid black;">whether scrap bin/dust bin are overflowing.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type14; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action14; ?></td>
                                        </tr>

                                        <tr>
                                            <th colspan="4" style="border: 1px solid black;">4S - SEIKETSU (STANDERDIZE)</th>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;">15</td>
                                            <td style="border: 1px solid black;">Places for keeping component, tools, gauge and file are specified.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type15; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action15; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;">16</td>
                                            <td style="border: 1px solid black;">Places for keeping component, tools, gauge and files are neat and tidy.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type16; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action16; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">17</td>
                                            <td style="border: 1px solid black;">Whether the work area is dirty.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type17; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action17; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">18</td>
                                            <td style="border: 1px solid black;">Whether the machine and gauges are dirty.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type18; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action18; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">19</td>
                                            <td style="border: 1px solid black;">Whether the machine are being inspected and maintained in good condition.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type19; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action19; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">20</td>
                                            <td style="border: 1px solid black;">Indications are easy to see or not.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type20; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action20; ?></td>
                                        </tr>

                                        <tr>
                                            <th colspan="4" style="border: 1px solid black;">5S - SHITSUKE (SUSTAIN)</th>
                                        </tr>

                                        <tr>
                                            <td style="border: 1px solid black;">21</td>
                                            <td style="border: 1px solid black;">All workers are using required PPE.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type21; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action21; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">22</td>
                                            <td style="border: 1px solid black;">PPE used are being worn properly.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type22; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action22; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">23</td>
                                            <td style="border: 1px solid black;">People are smoking / Spitting at workplace.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type23; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action23; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">24</td>
                                            <td style="border: 1px solid black;">Dust bins for waste materials are kept in place.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type24; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action24; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">25</td>
                                            <td style="border: 1px solid black;">Everyone is keeping things at decided place.</td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_type25; ?></td>
                                            <td style="border: 1px solid black;"><?php echo $check_point_action25; ?></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="text-align-last: center; background-color: lightgray;">
                            <div class="box">
                                <div class="col-xs-12" style="text-align-last: left;">
                                    <p><b>Signature of Audit team member.</b><img src="<?= $audit_member_sign; ?>" style="height: 60px;" alt="<?php echo $audit_member_sign; ?>" class="img-responsive"></p>
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