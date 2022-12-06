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
        $target_path = './upload/images/';
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }

        $emp_type_name = $db->escapeString($fn->xss_clean($_POST['emp_type_name']));

        // create array variable to handle error
        $error = array();

        if (empty($emp_type_name)) {
            $error['emp_type_name'] = " <span class='label label-danger'>Required!</span>";
        }
        
        if (!empty($emp_type_name)) {

            $sql_query = "INSERT INTO `emp_type` (emp_type_name)VALUES('$emp_type_name')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_emp_type'] = " <section class='content-header'><span class='label label-success'>Employee Type Added Successfully</span></section>";
            } else {
                $error['add_emp_type'] = " <span class='label label-danger'>Failed add Employee Type</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create Employee Type</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add Employee Type <small><a href='emp-type.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Employees</a></small></h1>

    <?php echo isset($error['add_emp_type']) ? $error['add_emp_type'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Employee Type.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Employee Type</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Employee Type Name</label><?php echo isset($error['emp_type_name']) ? $error['emp_type_name'] : ''; ?>
                            <input type="text" class="form-control" name="emp_type_name" required>
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