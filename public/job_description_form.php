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

        $datetime = date("Y-m-d H:i:s");
        $reports_to = $db->escapeString($fn->xss_clean($_POST['reports_to']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        
        $designation_id = $db->escapeString($fn->xss_clean($_POST['designation_id']));
        $sql = "SELECT designation_name FROM `emp_designation` WHERE id = '$designation_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $row)
            $designation1 = $row;
        //print_r($location1);
        $designation = implode(',', $designation1);
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

        if (empty($designation)) {
            $error['designation'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($designation)) {

            // insert new data to menu table
            $sql_query = "INSERT INTO `job_description` (designation_id,designation,reports_to,description,location_id,location,created_at,updated_at)VALUES('$designation_id', '$designation', '$reports_to', '$description', '$location_id', '$location','$datetime','$datetime')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_job_description'] = " <section class='content-header'><span class='label label-success'>Job DESCRIPTION Added Successfully</span></section>";
            } else {
                $error['add_job_description'] = " <span class='label label-danger'>Failed add Job DESCRIPTION</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create Job DESCRIPTION</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add Job DESCRIPTION <small><a href='job-description-list.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Job DESCRIPTION</a></small></h1>

    <?php echo isset($error['add_job_description']) ? $error['add_job_description'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Job DESCRIPTION.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add SOP Job DESCRIPTION</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">DISIGNATION</label><?php echo isset($error['designation_id']) ? $error['designation_id'] : ''; ?>
                            <select class="form-control" id="designation_id" name="designation_id" required>
                                <option value="">--Select DISIGNATION--</option>
                                <?php
                                $sql = "SELECT * FROM emp_designation";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $sop_type) {
                                    echo "<option value='" . $sop_type['id'] . "'>" . $sop_type['designation_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">REPORTS TO :</label><?php echo isset($error['reports_to']) ? $error['reports_to'] : ''; ?>
                            <input type="text" class="form-control" name="reports_to" required>
                        </div>

                        <div class="form-group">
                            <label for="description">DESCRIPTION</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                            <textarea name="description" id="description" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('description');
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