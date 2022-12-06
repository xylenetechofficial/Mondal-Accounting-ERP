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
        $target_path = './upload/manual_pdfs/';
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }
        $datetime = date("Y-m-d H:i:s");
        $manual_name = $db->escapeString($fn->xss_clean($_POST['manual_name']));

        // get pdf info
        $menu_pdf = $db->escapeString($fn->xss_clean($_FILES['manual_pdf']['name']));
        $pdf_error = $db->escapeString($fn->xss_clean($_FILES['manual_pdf']['error']));
        $pdf_type = $db->escapeString($fn->xss_clean($_FILES['manual_pdf']['type']));

        // create array variable to handle error
        $error = array();

        if (empty($manual_name)) {
            $error['manual_name'] = " <span class='label label-danger'>Required!</span>";
        }
        
        // common pdf file extensions
        $allowedExts = array("application/pdf");

        // get pdf file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["manual_pdf"]["name"]));

        if ($pdf_error > 0) {
            $error['manual_pdf'] = " <span class='label label-danger'>Not Uploaded!!</span>";
        } else {
            $result = $fn->validate_pdf($_FILES["manual_pdf"]);
            if ($result) {
                $error['manual_pdf'] = " <span class='label label-danger'>File type must pdf!</span>";
            }
            // $mimetype = mime_content_type($_FILES["manual_pdf"]["tmp_name"]);
            // if (!in_array($mimetype, array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'))) {
            // 	$error['manual_pdf'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
            // }
        }

        if (!empty($manual_name) && empty($error['manual_pdf'])) {

            // create random pdf file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['manual_pdf']['name']);
            $menu_pdf = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            // upload new pdf
            $upload = move_uploaded_file($_FILES['manual_pdf']['tmp_name'], 'upload/manual_pdfs/' . $menu_pdf);

            // insert new data to menu table
            $upload_pdf = DOMAIN_URL . 'upload/manual_pdfs/' . $menu_pdf;
            $sql_query = "INSERT INTO manual (manual_name, pdf,created_at, updated_at)VALUES('$manual_name', '$upload_pdf', '$datetime','$datetime')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_manual'] = " <section class='content-header'><span class='label label-success'>Manual Added Successfully</span></section>";
            } else {
                $error['add_manual'] = " <span class='label label-danger'>Failed add manual</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create manual</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add Manual <small><a href='manual.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Manuals</a></small></h1>

    <?php echo isset($error['add_manual']) ? $error['add_manual'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Manual.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Manual</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Manual Name</label><?php echo isset($error['manual_name']) ? $error['manual_name'] : ''; ?>
                            <input type="text" class="form-control" name="manual_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputFile">Update PDF&nbsp;&nbsp;&nbsp;</label><?php echo isset($error['manual_pdf']) ? $error['manual_pdf'] : ''; ?>
                            <input type="file" name="manual_pdf" id="manual_pdf" required />
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