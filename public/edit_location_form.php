<?php
include_once('includes/functions.php');
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
$ID = (isset($_GET['id'])) ? $db->escapeString($fn->xss_clean($_GET['id'])) : "";
// create array variable to store category data
$category_data = array();
if (isset($_POST['btnEdit'])) {

    if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
        echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
        return false;
    }
    if ($permissions['locations']['update'] == 1) {

        $datetime = date("Y-m-d H:i:s");
        $city_name = $db->escapeString($fn->xss_clean($_POST['city_name']));
        $location_name = $db->escapeString($fn->xss_clean($_POST['location_name']));
        $state_name = $db->escapeString($fn->xss_clean($_POST['state_name']));
        $error = array();
        
        if (!empty($city_name)) {
            $sql_query = "UPDATE location SET city_name = '" . $city_name . "', location_name = '" . $location_name . "', state_name = '" . $state_name . "', updated_at = '" . $datetime . "' WHERE id =" . $ID;
            $db->sql($sql_query);
            $update_result = $db->getResult();
            if (!empty($update_result)) {
                $update_result = 0;
            } else {
                $update_result = 1;
            }
            if ($update_result == 1) {
                $error['update_location'] = " <section class='content-header'>
												<span class='label label-success'>Location updated Successfully</span>
												<h4><small><a  href='location.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Location</a></small></h4>
												
												</section>";
            } else {
                $error['update_location'] = " <span class='label label-danger'>Failed update location</span>";
            }
        }
    } else {
        $error['update_location'] = " <span class='label label-danger'>You have no permission to update location</span>";
    }
}

// create array variable to store previous data
$data = array();
$sql_query = "SELECT * FROM location WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "location.php";
    </script>
<?php }; ?>
<section class="content-header">
    <h1>
        Edit location</h1>
    <small><?php echo isset($error['update_location']) ? $error['update_location'] : ''; ?></small>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['locations']['update'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to update location</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Location</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form id="edit_location_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                    <div class="form-group">
                            <label for="exampleInputEmail1">City Name</label><?php echo isset($error['city_name']) ? $error['city_name'] : ''; ?>
                            <input type="text" class="form-control" name="city_name" value="<?php echo $res[0]['city_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Location Name</label><?php echo isset($error['location_name']) ? $error['location_name'] : ''; ?>
                            <input type="text" class="form-control" name="location_name" value="<?php echo $res[0]['location_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">State Name</label><?php echo isset($error['state_name']) ? $error['state_name'] : ''; ?>
                            <input type="text" class="form-control" name="state_name" value="<?php echo $res[0]['state_name']; ?>" required>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
                        <button type="submit" class="btn btn-danger" name="btnCancel">Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>
<script src="dist/js/jquery.validate.min.js"></script>