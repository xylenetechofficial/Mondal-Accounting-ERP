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
        $statement = $db->escapeString($fn->xss_clean($_POST['statement']));

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

        if (empty($statement)) {
            $error['statement'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($statement)) {

            // insert new data to menu table
            $sql_query = "INSERT INTO `feedback_statement` (statement,location_id,location,created_at,updated_at)VALUES('$statement', '$location_id', '$location', '$datetime', '$datetime')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_feedback'] = " <section class='content-header'><span class='label label-success'>Feedback Statement Added Successfully</span></section>";
            } else {
                $error['add_feedback'] = " <span class='label label-danger'>Failed add Feedback Statement</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create Feedback Statement</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add Feedback Statement <small><a href='feedback-statement.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Feedback Statement</a></small></h1>

    <?php echo isset($error['add_feedback']) ? $error['add_feedback'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Feedback Statement.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Feedback Statement</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="statement">Feedback Statement</label> <i class="text-danger asterik">*</i><?php echo isset($error['statement']) ? $error['statement'] : ''; ?>
                            <textarea name="statement" id="statement" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('statement');
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