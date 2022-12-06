<?php
include_once('includes/functions.php');
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php
if (isset($_POST['btnAdd'])) {
    if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
        echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
        return false;
    }
    if ($permissions['locations']['create'] == 1) {
        $datetime = date("Y-m-d H:i:s");
        $city_name = $db->escapeString($fn->xss_clean($_POST['city_name']));
        $location_name = $db->escapeString($fn->xss_clean($_POST['location_name']));
        $state_name = $db->escapeString($fn->xss_clean($_POST['state_name']));

        // create array variable to handle error
        $error = array();

        $sql_query = "INSERT INTO `location` (`city_name`,`location_name`,`state_name`,`created_at`,`updated_at`)VALUES('$city_name','$location_name','$state_name','$datetime','$datetime')";
        $db->sql($sql_query);
        $result = $db->getResult();
        //print_r($result);

        if (!empty($result)) {
            $result = 0;
        } else {
            $result = 1;
        }

        if ($result == 1) {
            $error['add_location'] = "<section class='content-header'>
												<span class='label label-success'>Location Added Successfully</span>
												<h4><small><a  href='location.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Locations</a></small></h4>
												</section>";
        } else {
            $error['add_location'] = " <span class='label label-danger'>Failed add Location</span>";
        }
    } else {
        $error['add_location'] = "<section class='content-header'><span class='label label-danger'>You have no permission to create Location</span></section>";
    }
}

if (isset($_POST['btnCancel'])) {
    header("location:location_table.php");
}

?>
<section class="content-header">
    <h1>Add Location</h1>
    <?php echo isset($error['add_location']) ? $error['add_location'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['locations']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Location</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Location</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">City Name</label><?php echo isset($error['city_name']) ? $error['city_name'] : ''; ?>
                            <input type="text" class="form-control" name="city_name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Location Name</label><?php echo isset($error['location_name']) ? $error['location_name'] : ''; ?>
                            <input type="text" class="form-control" name="location_name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">State Name</label><?php echo isset($error['state_name']) ? $error['state_name'] : ''; ?>
                            <input type="text" class="form-control" name="state_name" required>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" class="btn-warning btn" value="Clear" />
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>