<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
include_once('includes/crud.php');
include_once('includes/variables.php');
$fn = new custom_functions;
$fn = new custom_functions();
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
//$datetime = date("Y-m-d H:i:s");
$date = date("Y-m-d");
//$effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($date)));
//print_r($effectiveDate);
$id = (isset($_GET['id'])) ? $db->escapeString($fn->xss_clean($_GET['id'])) : "";
$emp_id = (isset($_GET['emp_id'])) ? $db->escapeString($fn->xss_clean($_GET['emp_id'])) : "";

$sql = "SELECT * FROM `staff_leave` WHERE emp_id = '$emp_id' AND id = '$id' ORDER BY id DESC limit 1";
$db->sql($sql);
$res = $db->getResult();
$emp_no = $res[0]['emp_no'];
$leave_type = $res[0]['leave_type'];
$reason = $res[0]['reason'];
$apply_date = $res[0]['date'];
$leave_dates = $res[0]['leave_dates'];
$leave_counts = $res[0]['leave_counts'];
//print_r($emp_no);

$sql = "SELECT * FROM `emp_joining_form` WHERE id = '$emp_id' ORDER BY id DESC limit 1";
$db->sql($sql);
$emp_res = $db->getResult();
$name = $emp_res[0]['name'];
$mobile = $emp_res[0]['mobile'];

?>
<?php
if (isset($_POST['btnAdd'])) {

    $datetime = date("Y-m-d H:i:s");
    $today = date("Y-m-d");
    $selectedValues = $_POST['selectedValues'];
    //print_r($selectedValues);
    if (isset($_SESSION["id"])) {
        $approved_by_emp_id = $_SESSION["id"];
        //print_r($approved_by_emp_id);
        $approved_by_emp_name = $_SESSION["user"];
        //print_r($approved_by_emp_name);
    } else {
        $approved_by_emp_id = '0';
        //print_r($approved_by_emp_id);
    }
    //$id = (isset($_POST['id'])) ? $db->escapeString($fn->xss_clean($_POST['id'])) : "";
    //$emp_no = (isset($_POST['emp_no'])) ? $db->escapeString($fn->xss_clean($_POST['emp_no'])) : "";
    //$approved_by_emp_name = (isset($_POST['approved_by_emp_name'])) ? $db->escapeString($fn->xss_clean($_POST['approved_by_emp_name'])) : "";
    //$approved_by_emp_id = (isset($_POST['approved_by_emp_id'])) ? $db->escapeString($fn->xss_clean($_POST['approved_by_emp_id'])) : "";
    $approved_by_remark = (isset($_POST['approved_by_remark'])) ? $db->escapeString($fn->xss_clean($_POST['approved_by_remark'])) : "";
    $leave_status = (isset($_POST['leave_status'])) ? $db->escapeString($fn->xss_clean($_POST['leave_status'])) : "";
    $is_logged_in = 'false';
    $hours = '9';
    $ot_hours = '0';
    $tot_hours = '9';
    $in_time = '09:00:00';
    $out_time = '18:00:00';

    $dates = explode(', ', $selectedValues);

    if ($leave_status == 'approved') {

        foreach ($dates as $date) {

            $sql = "INSERT INTO `emp_attendance`(`emp_id`, `emp_no`, `attendance`, `in_time`, `out_time`, `hours`, `tot_hours`, `ot_hours`, `is_logged_in`, `date`, `created_at`, `updated_at`) VALUES ('$emp_id','$emp_no','$leave_type','$in_time','$out_time','$hours','$ot_hours','$tot_hours','$is_logged_in','$date','$datetime','$datetime')";
            $db->sql($sql);
            $emp_atten = $db->getResult();
            //print_r($sql);
        }
    }

    $sql = "UPDATE `staff_leave` SET `leave_status`='$leave_status',`approved_by_date`='$today',`approved_dates`='$selectedValues',`approved_by_emp_name`='$approved_by_emp_name',`approved_by_emp_no`='$approved_by_emp_id',`approved_by_remark`='$approved_by_remark',`updated_at`='$datetime' WHERE id = '$id' AND emp_no = '$emp_no' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $emp_atten = $db->getResult();
}
/*
if (isset($_POST['btnAdd'])) {
?>
    <script type="text/javascript">
        window.location = "emp-info.php";
    </script>
<?php
}
*/
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>


<section class="content-header">
    <h1>Staff Leave Approve / Reject Form</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <form id="form" role="form" method="post" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-md-4">
                            <div style="width: max-content;"><br /><br />
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Dates</label><?php echo isset($error['selectedValues']) ? $error['selectedValues'] : ''; ?><br />
                                    <input type="text" name="selectedValues" id="selectedValues" class="date-values" readonly required />
                                </div>
                                <div id="parent" class="container" style="display:none;width: max-content;">
                                    <div class="row header-row" style="width: auto;">
                                        <!--<div class="col-xs previous">
                                            <a href="" id="previous" onclick="previous()">
                                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                            </a>
                                        </div>-->
                                        <div class="card-header month-selected col-sm" id="monthAndYear">
                                        </div>
                                        <div class="col-sm">
                                            <select class="form-control col-xs-6" style="width: auto;" name="month" id="month" onchange="change()"></select>
                                        </div>
                                        <div class="col-sm">
                                            <select class="form-control col-xs-6" style="width: auto;" name="year" id="year" onchange="change()"></select>
                                        </div>
                                        <!--<div class="col-xs next">
                                            <a href="" id="next" onclick="next()">
                                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>-->
                                    </div>
                                    <table id="calendar">
                                        <thead>
                                            <tr>
                                                <th>S</th>
                                                <th>M</th>
                                                <th>T</th>
                                                <th>W</th>
                                                <th>T</th>
                                                <th>F</th>
                                                <th>S</th>
                                            </tr>
                                        </thead>
                                        <tbody id="calendarBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8"><br /><br />
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Emp No</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $emp_no; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Emp Name</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $name; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Emp Mobile</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $mobile; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Leave Type</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $leave_type; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Leave Reason</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $reason; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Leave Apply Date</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $apply_date; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Dates Of Leave</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $leave_dates; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Leave Count</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" value="<?php echo $leave_counts; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Leave Status</label><?php echo isset($error['leave_status']) ? $error['leave_status'] : ''; ?>
                                        <select class="form-control" id="leave_status" name="leave_status" required>
                                            <option value="">
                                                <label>--Select--</label>
                                            </option>
                                            <option value="approved">
                                                <label>Approved</label>
                                            </option>
                                            <option value="reject">
                                                <label>Reject</label>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Approved / Reject Remark</label><?php echo isset($error['approved_by_remark']) ? $error['approved_by_remark'] : ''; ?>
                                        <input type="text" class="form-control" id="approved_by_remark" name="approved_by_remark">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br /><br />
                    <div class="box-footer" style="text-align: center;">
                        <input type="submit" class="btn btn-primary" name="btnAdd">
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>