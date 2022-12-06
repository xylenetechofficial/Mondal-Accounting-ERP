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

        $datetime = date("Y-m-d H:i:s");
        $particulars = $db->escapeString($fn->xss_clean($_POST['particulars']));

        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        $location = implode(',', $location1);
        //print_r($location);

        // create array variable to handle error
        $error = array();

        if (empty($particulars)) {
            $error['particulars'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($particulars)) {

            $sql_query = "INSERT INTO abp (particulars, location_id, location, created_at, updated_at)
						VALUES('$particulars', '$location_id', '$location', '$datetime', '$datetime')";


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
                $error[' add_potential'] = " <section class='content-header'><span class='label label-success'>Monthly Abp Particulars Form Added Successfully</span></section>";
            } else {
                $error[' add_potential'] = " <span class='label label-danger'>Failed To Add Monthly Abp Particulars Form</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to Add Monthly Abp Particulars Form</span></section>";
    }
}

if (isset($_POST['btnCancel'])) {
    header("location:add-emp-selection.php");
}

?>
<section class="content-header">
    <h1>Add Monthly Abp Particulars Form<small><a href='add-emp-selection.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Monthly Abp Particulars</a></small></h1>
    <?php echo isset($error[' add_potential']) ? $error[' add_potential'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['subcategories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to Add Monthly Abp Particulars Form.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Monthly Abp Particulars Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Particulars</label><?php echo isset($error['particulars']) ? $error['particulars'] : ''; ?>
                            <input type="text" class="form-control" name="particulars" id="particulars" required />
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