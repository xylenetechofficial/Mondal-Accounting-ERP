<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
//ob_end_clean();
//ob_start();

$location_id = $_GET['location_id'];
$i = 1;

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `emp_joining_form` WHERE  location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res = $db->getResult(); //print_r($res2);

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
                        <div class="col-xs-12" style="padding: 0px;">
                            <div class="box">
                                <div class="col-xs-12" style="border: 1px solid black; text-align-last: center; background-color:yellow; color:red; padding-top: 10px; padding-bottom: 20px;">
                                    <h3><b>Mandal Engineering</b></h3>
                                </div>
                                <div class="col-xs-12" style="border: 1px solid black; text-align-last: center;">
                                    <h3><b>Employee List</b></h3>
                                </div>
                                <div class="col-xs-12" style="text-align-last: left; padding-top: 10px;">
                                    <p>Subject - Mandal Engineering Employee List</p>
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
                                            <!--<th style="border: 1px solid black;">No.</th>-->
                                            <th style="border: 1px solid black;">S No.</th>
                                            <th style="border: 1px solid black;">Name</th>
                                            <th style="border: 1px solid black;">Designation</th>
                                            <th style="border: 1px solid black;">Qualification</th>
                                            <th style="border: 1px solid black;">DOJ</th>
                                            <th style="border: 1px solid black;">Category</th>
                                            <th style="border: 1px solid black;">Experience</th>
                                        </tr>
                                        <?php
                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <!--<td style="border: 1px solid black;"><?php echo $row['id']; ?></td>-->
                                                <td style="border: 1px solid black;"><?php echo $i;
                                                                                        $i++; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['name']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['emp_designation_name']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['qualification']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['date']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['emp_skills']; ?></td>
                                                <td style="border: 1px solid black;"><?php echo $row['experience']; ?></td>
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