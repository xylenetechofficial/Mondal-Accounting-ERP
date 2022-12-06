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
$doc_no = $_GET['doc_no'];
$issue_date = $_GET['issue_date'];
$rev_no = $_GET['rev_no'];
$location_id = $_GET['location_id'];

$sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res1 = $db->getResult();
foreach ($res1 as $row1)
    $location1 = $row1;
//print_r($location1);
$location = implode(',', $location1);
//print_r($location);

$sql = "SELECT * FROM `emp_selection_process_docs` WHERE id = '$ID' AND location_id= '$location_id'";
// Execute query
$db->sql($sql);
// store result 
$res2 = $db->getResult();

foreach ($res2 as $row2)
    $emp_selection_docs = $row2['emp_selection_docs'];


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
                                    <h2><b>Health Safety & Enviroment Managament System (HSEMS)</b></h2>
                                </div>
                                <div class="col-xs-4" style="border: 1px solid black;">
                                    <h3>DOC NO. : <?php echo $doc_no; ?></h3>
                                </div>
                                <div class="col-xs-4" style="border: 1px solid black;">
                                    <h3>Issue Date. : <?php echo $issue_date; ?></h3>
                                </div>
                                <div class="col-xs-4" style="border: 1px solid black;">
                                    <h3>Ref NO. & Date : <?php echo $rev_no; ?></h3>
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
                                <div class="col-xs-12" style="border: 1px solid black;">
                                    <p><?php echo $emp_selection_docs; ?></p>
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