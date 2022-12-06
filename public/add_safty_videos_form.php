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
        $target_path = './upload/videos/';
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }
        $datetime = date("Y-m-d H:i:s");
        $video_title = $db->escapeString($fn->xss_clean($_POST['video_title']));

        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        //print_r($location1);
        $location = implode(',', $location1);
        //print_r($location);

        // get video info
        $menu_video = $db->escapeString($fn->xss_clean($_FILES['safty_video']['name']));
        $video_error = $db->escapeString($fn->xss_clean($_FILES['safty_video']['error']));
        $video_type = $db->escapeString($fn->xss_clean($_FILES['safty_video']['type']));

        // create array variable to handle error
        $error = array();

        if (empty($video_title)) {
            $error['video_title'] = " <span class='label label-danger'>Required!</span>";
        }

        // common video file extensions
        $allowedExts = array("mp4");

        // get video file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["safty_video"]["name"]));

        if ($video_error > 0) {
            $error['safty_video'] = " <span class='label label-danger'>Not Uploaded!!</span>";
        } else {
            $result = $fn->validate_video($_FILES["safty_video"]);
            if ($result) {
                $error['safty_video'] = " <span class='label label-danger'>File type must mp4!</span>";
            }
            // $mimetype = mime_content_type($_FILES["safty_video"]["tmp_name"]);
            // if (!in_array($mimetype, array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'))) {
            // 	$error['safty_video'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
            // }
        }

        if (!empty($video_title) && empty($error['safty_video'])) {

            // create random video file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['safty_video']['name']);
            $menu_video = $function->get_random_string($string, 4) . "-safty-" . date("Y-m-d") . "." . $extension;

            // upload new video
            $upload = move_uploaded_file($_FILES['safty_video']['tmp_name'], 'upload/videos/' . $menu_video);

            // insert new data to menu table
            $upload_video = DOMAIN_URL . 'upload/videos/' . $menu_video;
            $sql_query = "INSERT INTO safty_video (video_title, video,location_id,location,created_at, updated_at)VALUES('$video_title', '$upload_video', '$location_id', '$location', '$datetime','$datetime')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_sop'] = " <section class='content-header'><span class='label label-success'>SOP Added Successfully</span></section>";
            } else {
                $error['add_sop'] = " <span class='label label-danger'>Failed add sop</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create sop</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add SOP <small><a href='sop-types.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to SOP</a></small></h1>

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
                            <label for="exampleInputEmail1">Safty Video Title</label><?php echo isset($error['video_title']) ? $error['video_title'] : ''; ?>
                            <input type="text" name="video_title" id="video_title" required />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Upload Video&nbsp;&nbsp;&nbsp;</label><?php echo isset($error['safty_video']) ? $error['safty_video'] : ''; ?>
                            <input type="file" name="safty_video" id="safty_video" required />
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