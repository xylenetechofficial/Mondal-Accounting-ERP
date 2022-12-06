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

        $job_steps = $db->escapeString($fn->xss_clean($_POST['job_steps']));
        $jha_type = $db->escapeString($fn->xss_clean($_POST['jha_type']));
        $responsibility = $db->escapeString($fn->xss_clean($_POST['responsibility']));

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

        if (empty($job_steps)) {
            $error['job_steps'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($jha_type)) {
            $error['jha_type'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($job_steps) && !empty($jha_type)) {

            // insert new data to menu table
            $sql_query = "INSERT INTO jha_job_seq (job_steps,jha_type,responsibility, location_id, location)VALUES('$job_steps', '$jha_type', '$responsibility', '$location_id', '$location')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_jha'] = " <section class='content-header'><span class='label label-success'>Category Added Successfully</span></section>";
            } else {
                $error['add_jha'] = " <span class='label label-danger'>Failed add category</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create category</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Sequence of Basic Job Steps <small><a href='add-jha-basic-job-seq.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Categories</a></small></h1>

    <?php echo isset($error['add_jha']) ? $error['add_jha'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Sequence of Basic Job Steps.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sequence of Basic Job Steps</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sequence of Basic Job Steps</label><?php echo isset($error['job_steps']) ? $error['job_steps'] : ''; ?>
                            <input type="text" class="form-control" name="job_steps" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">JHA Type</label><?php echo isset($error['jha_type']) ? $error['jha_type'] : ''; ?>
                            <select class="form-control" id="jha_type" name="jha_type" required>
                                <option value="">--Select JHA Type--</option>
                                <?php
                                $sql = "SELECT * FROM `jha_type`";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $jha_type) {
                                    echo "<option value='" . $jha_type['id'] . "'>" . $jha_type['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Job Responsibility</label><?php echo isset($error['responsibility']) ? $error['responsibility'] : ''; ?>
                            <input type="text" class="form-control" name="responsibility" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Location</label><?php echo isset($error['location_id']) ? $error['location_id'] : ''; ?>
                            <select class="form-control" id="location_id" name="location_id" required>
                                <option value="">--Select Location--</option>
                                <?php
                                $sql = "SELECT * FROM `location`";
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