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

        $req_ppe = $db->escapeString($fn->xss_clean($_POST['req_ppe']));
        $req_tools = $db->escapeString($fn->xss_clean($_POST['req_tools']));
        $req_training = $db->escapeString($fn->xss_clean($_POST['req_training']));
        $emp_name = $db->escapeString($fn->xss_clean($_POST['emp_name']));

        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        //print_r($location1);
        $location = implode(',', $location1);
        //print_r($location);

        $jha_type_id = $db->escapeString($function->slugify($fn->xss_clean($_POST['jha_type_id'])));
        $sql = "SELECT name FROM `jha_type` WHERE id = '$jha_type_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res2 = $db->getResult();
        foreach ($res2 as $row2)
            $jha_type1 = $row2;
        $jha_type = implode(',', $jha_type1);
        //print_r($location);

        // create array variable to handle error
        $error = array();

        if (empty($req_ppe)) {
            $error['req_ppe'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($req_ppe)) {

            // insert new data to menu table
            $sql_query = "INSERT INTO `jha_required` (req_ppe,req_tools,req_training,emp_name, jha_type_id, jha_type,location_id,location)VALUES('$req_ppe', '$req_tools', '$req_training', '$emp_name', '$jha_type_id', '$jha_type', '$location_id', '$location')";
            $db->sql($sql_query);
            $result = $db->getResult();
            //print_r($result);
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_jha'] = " <section class='content-header'><span class='label label-success'>JHA Added Successfully</span></section>";
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
    <h1>Add JHA <small><a href='add-jha-requirments.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to JHA</a></small></h1>

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
                <div class="alert alert-danger">You have no permission to create JHA.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add JHA</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="req_ppe">Required PPE</label> <i class="text-danger asterik">*</i><?php echo isset($error['req_ppe']) ? $error['req_ppe'] : ''; ?>
                            <textarea name="req_ppe" id="req_ppe" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('req_ppe');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="req_tools">Required Tools & equipments</label> <i class="text-danger asterik">*</i><?php echo isset($error['req_tools']) ? $error['req_tools'] : ''; ?>
                            <textarea name="req_tools" id="req_tools" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('req_tools');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="req_training">Required Training</label> <i class="text-danger asterik">*</i><?php echo isset($error['req_training']) ? $error['req_training'] : ''; ?>
                            <textarea name="req_training" id="req_training" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('req_training');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Special skilled employees</label><?php echo isset($error['emp_name']) ? $error['emp_name'] : ''; ?>
                            <select class="form-control" id="emp_name" name="emp_name" required>
                                <option value="">--Select Special skilled employees--</option>
                                <?php
                                $sql = "SELECT * FROM `emp_joining_form`";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $emp_joining_form) {
                                    echo "<option value='" . $emp_joining_form['id'] . "'>" . $emp_joining_form['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">JHA Type</label><?php echo isset($error['jha_type_id']) ? $error['jha_type_id'] : ''; ?>
                            <select class="form-control" id="jha_type_id" name="jha_type_id" required>
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