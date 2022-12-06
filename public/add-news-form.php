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
/*        $target_path = './upload/blogs/';
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }*/
/*
        $title = $db->escapeString($fn->xss_clean($_POST['title']));
        $slug = $function->slugify($db->escapeString($fn->xss_clean($_POST['title'])), 'blogs');
*/
        $newsliner = $db->escapeString($fn->xss_clean($_POST['newsliner']));
        $datetime = date("d-m-Y h:i:s A");
        $date = date("d-m-Y");
        $time = date("h:i:s A");

        
        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        //print_r($location1);
        $location = implode(',', $location1);
        //print_r($location);

        $error = array();
        if (empty($newsliner)) {
            $error['newsliner'] = " <span class='label label-danger'>Required!</span>";
        }
/*
        $category_id = $db->escapeString($fn->xss_clean($_POST['category_id']));

        $menu_image = $db->escapeString($fn->xss_clean($_FILES['image']['name']));
        $image_error = $db->escapeString($fn->xss_clean($_FILES['image']['error']));
        $image_type = $db->escapeString($fn->xss_clean($_FILES['image']['type']));

        $error = array();

        $allowedExts = array("gif", "jpeg", "jpg", "png");

        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["image"]["name"]));

        if ($image_error > 0) {
            $error['image'] = " <span class='label label-danger'>Not Uploaded!!</span>";
        } else {
            $result = $fn->validate_image($_FILES["image"]);
            if ($result) {
                $error['image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
            }
        }

        if (!empty($title) && !empty($newsliner) && empty($error['image'])) {
*/
            if (!empty($newsliner)) {
/*
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['image']['name']);
            $menu_image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            $upload = move_uploaded_file($_FILES['image']['tmp_name'], 'upload/blogs/' . $menu_image);

            $upload_image = 'upload/blogs/' . $menu_image;
*/
            //$sql_query = "INSERT INTO blogs (category_id,title,slug,newsliner, image)VALUES('$category_id','$title', '$slug', '$newsliner', '$upload_image')";
            $sql_query = "INSERT INTO news (newsliner, date, time,location_id,location, created_at, updated_at)VALUES('$newsliner', '$date', '$time', '$location_id', '$location', '$datetime', '$datetime')";

            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_category'] = " <section class='content-header'><span class='label label-success'>News Added Successfully</span></section>";
            } else {
                $error['add_category'] = " <span class='label label-danger'>Failed add news</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create news</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Add News <small><a href='news.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to News</a></small></h1>

    <?php echo isset($error['add_category']) ? $error['add_category'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create News.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add News</h3>

                </div>
                <form id="add_news_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <?php 
                        /*$sql = "Select * from blog_categories";
                        $db->sql($sql);
                        $result = $db->getResult();*/
                        ?>
                        <!--<div class="form-group">
                            <label class="control-label " for='category'>News Categories</label>
                            <select name='category_id' id='category_id' class='form-control'>
                                <option value="">Select Category</option>
                                <?php foreach ($result as $row) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php } ?>
                            </select>
                            <br>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">News Name</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Image&nbsp;&nbsp;&nbsp;*Please choose square image of larger than 350px*350px & smaller than 550px*550px.</label><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                            <input type="file" name="image" id="image" required />
                        </div>
                        <div class="form-group">
                            <label for="app_name">News :</label>
                            <textarea name="newsliner" id="newsliner" class="form-control addr" rows="16" required></textarea>
                        </div>-->
                        <div class="form-group">
                            <label for="newsliner">Add News :</label> <i class="text-danger asterik">*</i><?php echo isset($error['newsliner']) ? $error['newsliner'] : ''; ?>
                            <textarea name="newsliner" id="newsliner" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('newsliner');
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
<script src="dist/js/jquery.validate.min.js"></script>
<script>
    tinymce.init({
        selector: '.addr',
        height: 300,
        menubar: true,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    });
</script>
<script>
    $('#add_news_form').validate({
        ignore: [],
        debug: false,
        rules: {
            category_id: "required",
            newsliner: {
                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement();
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                    return editorcontent.length === 0;
                }
            }
        }
    });
</script>

<?php $db->disconnect(); ?>