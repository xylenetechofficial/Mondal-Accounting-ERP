<div id="content" class="container col-md-12">
    <?php
    include_once('includes/custom-functions.php');
    $fn = new custom_functions;

    if (isset($_POST['btnDelete'])) {
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
            return false;
        }

        $ID = (isset($_GET['id'])) ? $db->escapeString($fn->xss_clean($_GET['id'])) : "";

        // get image file from table
        $sql_query = "SELECT location_name FROM location WHERE id =" . $ID;
        $db->sql($sql_query);
        $res = $db->getResult();
        $sql_query = "DELETE FROM location WHERE id =" . $ID;
        $db->sql($sql_query);
        $delete_location_result = $db->getResult();
        if (!empty($delete_location_result)) {
            $delete_location_result = 0;
        } else {
            $delete_location_result = 1;
        }
        
        // if delete data success back to reservation page
        if ($delete_location_result == 1) {
            header("location: location.php");
        }
    }

    if (isset($_POST['btnNo'])) {
        header("location: location.php");
    }
    if (isset($_POST['btncancel'])) {
        header("location: location.php");
    }

    ?>
    <?php if ($permissions['locations']['delete'] == 1) { ?>
        <h1>Confirm Action</h1>
        <hr />
        <form method="post">
            <p>Are you sure want to delete this location?Related location Data will also deleted.</p>
            <input type="submit" class="btn btn-primary" value="Delete" name="btnDelete" />
            <input type="submit" class="btn btn-danger" value="Cancel" name="btnNo" />
        </form>
        <div class="separator"> </div>
    <?php } else { ?>
        <div class="alert alert-danger topmargin-sm">You have no permission to delete location.</div>
        <form method="post">
            <input type="submit" class="btn btn-danger" value="Back" name="btncancel" />
        </form>
    <?php } ?>
</div>
<?php $db->disconnect(); ?>