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
        $target_path = './upload/pdfs/';
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }
        $datetime = date("Y-m-d H:i:s");
        $emergency_plans_type = $db->escapeString($fn->xss_clean($_POST['emergency_plans_type']));

        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        //print_r($location1);
        $location = implode(',', $location1);
        //print_r($location);

        // get pdf info
        $menu_pdf = $db->escapeString($fn->xss_clean($_FILES['emergency_plans_pdf']['name']));
        $pdf_error = $db->escapeString($fn->xss_clean($_FILES['emergency_plans_pdf']['error']));
        $pdf_type = $db->escapeString($fn->xss_clean($_FILES['emergency_plans_pdf']['type']));

        // create array variable to handle error
        $error = array();

        if (empty($emergency_plans_type)) {
            $error['emergency_plans_type'] = " <span class='label label-danger'>Required!</span>";
        }

        // common pdf file extensions
        $allowedExts = array("application/pdf");

        // get pdf file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["emergency_plans_pdf"]["name"]));

        if ($pdf_error > 0) {
            $error['emergency_plans_pdf'] = " <span class='label label-danger'>Not Uploaded!!</span>";
        } else {
            $result = $fn->validate_pdf($_FILES["emergency_plans_pdf"]);
            if ($result) {
                $error['emergency_plans_pdf'] = " <span class='label label-danger'>File type must pdf!</span>";
            }
            // $mimetype = mime_content_type($_FILES["emergency_plans_pdf"]["tmp_name"]);
            // if (!in_array($mimetype, array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'))) {
            // 	$error['emergency_plans_pdf'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
            // }
        }

        if (!empty($emergency_plans_type) && empty($error['emergency_plans_pdf'])) {

            // create random pdf file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['emergency_plans_pdf']['name']);
            $menu_pdf = $function->get_random_string($string, 4) . "-EMERGENCY-PLANS-" . date("Y-m-d") . "." . $extension;

            // upload new pdf
            $upload = move_uploaded_file($_FILES['emergency_plans_pdf']['tmp_name'], 'upload/pdfs/' . $menu_pdf);

            // insert new data to menu table
            $upload_pdf = DOMAIN_URL . 'upload/pdfs/' . $menu_pdf;
            $sql_query = "INSERT INTO emergency_plans_pdf (emergency_plans_type, pdf,location_id,location,created_at, updated_at)VALUES('$emergency_plans_type', '$upload_pdf', '$location_id', '$location', '$datetime','$datetime')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_emergency_plans'] = " <section class='content-header'><span class='label label-success'>Emergency Plans Added Successfully</span></section>";
            } else {
                $error['add_emergency_plans'] = " <span class='label label-danger'>Failed add Emergency Plans</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create emergency plans</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add Emergency Plans <small><a href='emergency_plans_list.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Emergency Plans</a></small></h1>

    <?php echo isset($error['add_emergency_plans']) ? $error['add_emergency_plans'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Emergency Plans.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Emergency Plans</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Emergency Plans Type</label><?php echo isset($error['emergency_plans_type']) ? $error['emergency_plans_type'] : ''; ?>
                            <input type="text" name="emergency_plans_type" id="emergency_plans_type" required />                            
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Update PDF&nbsp;&nbsp;&nbsp;</label><?php echo isset($error['emergency_plans_pdf']) ? $error['emergency_plans_pdf'] : ''; ?>
                            <input type="file" name="emergency_plans_pdf" id="emergency_plans_pdf" required />
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