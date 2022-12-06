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
    if ($permissions['subcategories']['create'] == 1) {

        $designation_name = $db->escapeString($fn->xss_clean($_POST['designation_name']));
        $slug = $db->escapeString($function->slugify($fn->xss_clean($_POST['designation_name'])));
        $sql = "SELECT slug FROM emp_designation";
        $db->sql($sql);
        $res = $db->getResult();
        $i = 1;
        foreach ($res as $row) {
            if ($slug == $row['slug']) {
                $slug = $slug . '-' . $i;
                $i++;
            }
        }
        $main_emp_type = $db->escapeString($fn->xss_clean($_POST['main_emp_type']));

        $sql = "SELECT emp_type_name FROM `emp_type` WHERE id='$main_emp_type'";
        $db->sql($sql);
        $res = $db->getResult();
        $main_emp_type_name = $res[0]['emp_type_name'];

        if (!empty($designation_name) && !empty($main_emp_type)) {

            $sql_query = "INSERT INTO emp_designation (emp_type_id,emp_type_name, designation_name, slug)
						VALUES('$main_emp_type', '$main_emp_type_name', '$designation_name', '$slug')";


            // Execute query
            $db->sql($sql_query);
            // store result 
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }
            if ($result == 1) {
                $error['add_designation'] = " <section class='content-header'><span class='label label-success'>Designation Added Successfully</span></section>";
            } else {
                $error['add_designation'] = " <span class='label label-danger'>Failed add Designation</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create designation</span></section>";
    }
}

if (isset($_POST['btnCancel'])) {
    header("location:designation.php");
}

?>
<section class="content-header">
    <h1>Designation Added<small><a href='designation.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Designation</a></small></h1>
    <?php echo isset($error['add_designation']) ? $error['add_designation'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['subcategories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create designation.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Designation</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Main Category</label><?php echo isset($error['main_emp_type']) ? $error['main_emp_type'] : ''; ?>
                            <select class="form-control" id="main_emp_type" name="main_emp_type" required>
                                <option value="">--Select Main Category--</option>
                                <?php
                                if ($permissions['categories']['read'] == 1) {
                                    $sql = "SELECT * FROM emp_type";
                                    $db->sql($sql);
                                    $res = $db->getResult();
                                    foreach ($res as $emp_type) {
                                        echo "<option value='" . $emp_type['id'] . "'>" . $emp_type['emp_type_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Designation Name</label><?php echo isset($error['designation_name']) ? $error['designation_name'] : ''; ?>
                            <input type="text" class="form-control" name="designation_name" required>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">ADD</button>
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