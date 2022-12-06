<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {
    if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
        echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
        return false;
    }
    if ($permissions['categories']['create'] == 1) {

        $step = $db->escapeString($fn->xss_clean($_POST['step']));
        $associated_req = $db->escapeString($fn->xss_clean($_POST['associated_req']));
        $responsibility = $db->escapeString($fn->xss_clean($_POST['responsibility']));
        $process_ppe = $db->escapeString($fn->xss_clean($_POST['process_ppe']));
        $remarks = $db->escapeString($fn->xss_clean($_POST['remarks']));

        $sop_id = $db->escapeString($fn->xss_clean($_POST['sop_id']));
        $sql = "SELECT name FROM `sop_type` WHERE id = '$sop_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $row)
            $sop_type1 = $row;
        //print_r($location1);
        $sop_type = implode(',', $sop_type1);
        //print_r($location);

        
        $activity_id = $db->escapeString($fn->xss_clean($_POST['activity_id']));
        $sql = "SELECT activity_name FROM `sop_activity` WHERE id = '$activity_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res2 = $db->getResult();
        foreach ($res2 as $row2)
            $activity_name1 = $row2;
        //print_r($location1);
        $activity_name = implode(',', $activity_name1);
        //print_r($location);


        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        //print_r($location1);
        $location = implode(',', $location1);
        //print_r($location);

        // create array variable to handle error
        $error = array();

        if (empty($sop_type)) {
            $error['sop_type'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($sop_type)) {

            // insert new data to menu table
            $sql_query = "INSERT INTO `sop_process` (step,sop_id,sop_type,activity_id,activity_name,associated_req,responsibility,process_ppe,remarks,location_id,location)VALUES('$step', '$sop_id', '$sop_type', '$activity_id', '$activity_name', '$associated_req', '$responsibility', '$process_ppe', '$remarks', '$location_id', '$location')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_sop'] = " <section class='content-header'><span class='label label-success'>SOP Process Added Successfully</span></section>";
            } else {
                $error['add_sop'] = " <span class='label label-danger'>Failed add SOP Process</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create SOP Process</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add SOP Process <small><a href='add-sop-process-form.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to SOP Process</a></small></h1>

    <?php echo isset($error['add_sop']) ? $error['add_sop'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create SOP Process.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add SOP Process</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Step</label><?php echo isset($error['step']) ? $error['step'] : ''; ?>
                            <input type="number" min="1" step="1" class="form-control" name="step" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">SOP Type</label><?php echo isset($error['sop_id']) ? $error['sop_id'] : ''; ?>
                            <select class="form-control" id="sop_id" name="sop_id" required>
                                <option value="">--Select SOP Type--</option>
                                <?php
                                $sql = "SELECT * FROM sop_type";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $sop_type) {
                                    echo "<option value='" . $sop_type['id'] . "'>" . $sop_type['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">SOP Activity</label><?php echo isset($error['activity_id']) ? $error['activity_id'] : ''; ?>
                            <select class="form-control" id="activity_id" name="activity_id" required>
                                <option value="">--Select SOP Activity--</option>
                                <?php
                                $sql = "SELECT * FROM sop_activity";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $sop_activity) {
                                    echo "<option value='" . $sop_activity['id'] . "'>" . $sop_activity['activity_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="associated_req">Associated Requirements/ Hazards/Impacts</label> <i class="text-danger asterik">*</i><?php echo isset($error['associated_req']) ? $error['associated_req'] : ''; ?>
                            <textarea name="associated_req" id="associated_req" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('associated_req');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Responsibility</label><?php echo isset($error['responsibility']) ? $error['responsibility'] : ''; ?>
                            <input type="text" class="form-control" name="responsibility" required>
                        </div>
                        <div class="form-group">
                            <label for="process_ppe">Process / tools / PPEs (HOW)</label> <i class="text-danger asterik">*</i><?php echo isset($error['process_ppe']) ? $error['process_ppe'] : ''; ?>
                            <textarea name="process_ppe" id="process_ppe" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('process_ppe');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks / Reference</label> <i class="text-danger asterik">*</i><?php echo isset($error['remarks']) ? $error['remarks'] : ''; ?>
                            <textarea name="remarks" id="remarks" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('remarks');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Location</label><?php echo isset($error['location_id']) ? $error['location_id'] : ''; ?>
                            <select class="form-control" id="location_id" name="location_id" required>
                                <option value="">--Select Location--</option>
                                <?php
                                $sql = "SELECT * FROM location";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $location) {
                                    echo "<option value='" . $location['id'] . "'>" . $location['location_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" class="btn-warning btn" value="Clear" />

                    </div>

                </form>

            </div><!-- /.box -->
            <?php echo isset($error['check_permission']) ? $error['check_permission'] : ''; ?>
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>