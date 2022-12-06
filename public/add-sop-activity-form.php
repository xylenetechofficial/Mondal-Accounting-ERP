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
        $activity_name = $db->escapeString($fn->xss_clean($_POST['activity_name']));

        $sop_id = $db->escapeString($fn->xss_clean($_POST['sop_id']));
        $sql = "SELECT name FROM `sop_type` WHERE id = '$sop_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $row)
            $sop_type1 = $row;
        //print_r($location1);
        $sop_type = implode(',', $sop_type1);
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

        if (empty($activity_name)) {
            $error['activity_name'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($activity_name)) {

            // insert new data to menu table
            $sql_query = "INSERT INTO `sop_activity` (step,activity_name,sop_id,sop_type,location_id,location)VALUES('$step', '$activity_name', '$sop_id', '$sop_type', '$location_id', '$location')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_sop'] = " <section class='content-header'><span class='label label-success'>SOP Activity Added Successfully</span></section>";
            } else {
                $error['add_sop'] = " <span class='label label-danger'>Failed add SOP Activity</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create SOP Activity</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add SOP Activity <small><a href='add-sop-activity-form.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to SOP Activity</a></small></h1>

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
                <div class="alert alert-danger">You have no permission to create SOP.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add SOP</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Step</label><?php echo isset($error['step']) ? $error['step'] : ''; ?>
                            <input type="number" min="1" step="1" class="form-control" name="step" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Activity Type Name</label><?php echo isset($error['activity_name']) ? $error['activity_name'] : ''; ?>
                            <input type="text" class="form-control" name="activity_name" required>
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