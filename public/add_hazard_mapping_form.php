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

        $datetime = date("Y-m-d H:i:s");

        $task = $db->escapeString($fn->xss_clean($_POST['task']));
        $risk = $db->escapeString($fn->xss_clean($_POST['risk']));
        $initial_nce = $db->escapeString($fn->xss_clean($_POST['initial_nce']));
        $initial_liklihood = $db->escapeString($fn->xss_clean($_POST['initial_liklihood']));
        $initial_rating = $db->escapeString($fn->xss_clean($_POST['initial_rating']));
        $proposed_control = $db->escapeString($fn->xss_clean($_POST['proposed_control']));
        $residual_nce = $db->escapeString($fn->xss_clean($_POST['residual_nce']));
        $residual_liklihood = $db->escapeString($fn->xss_clean($_POST['residual_liklihood']));
        $residual_rating = $db->escapeString($fn->xss_clean($_POST['residual_rating']));
        $action_by = $db->escapeString($fn->xss_clean($_POST['action_by']));
        $action_date = $db->escapeString($fn->xss_clean($_POST['action_date']));
        $completed_by = $db->escapeString($fn->xss_clean($_POST['completed_by']));
        $completed_date = $db->escapeString($fn->xss_clean($_POST['completed_date']));

        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        //print_r($location1);
        $location = implode(',', $location1);
        //print_r($location);

        // create array variable to handle error
        $error = array();

        if (empty($task)) {
            $error['task'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($risk)) {
            $error['risk'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($task) && !empty($risk)) {

            // insert new data to menu table
            $sql_query = "INSERT INTO hazard_mapping (task, risk, initial_nce, initial_liklihood, initial_rating, proposed_control, residual_nce, residual_liklihood, residual_rating, action_by, action_date, completed_by, completed_date, location_id, location, created_at, updated_at)VALUES('$task', '$risk', '$initial_nce', '$initial_liklihood', '$initial_rating', '$proposed_control', '$residual_nce', '$residual_liklihood', '$residual_rating', '$action_by', '$action_date', '$completed_by', '$completed_date', '$location_id', '$location', '$datetime', '$datetime')";
            $db->sql($sql_query);
            $result = $db->getResult();
            if (!empty($result)) {
                $result = 0;
            } else {
                $result = 1;
            }

            if ($result == 1) {
                $error['add_jha'] = " <section class='content-header'><span class='label label-success'>Hazards Added Successfully</span></section>";
            } else {
                $error['add_jha'] = " <span class='label label-danger'>Failed add Hazards</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create Hazards</span></section>";
    }
}
?>
<section class="content-header">
    <h1>Sequence of Basic Job Steps <small><a href='hazard_mapping.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Hazards</a></small></h1>

    <?php echo isset($error['add_jha']) ? $error['add_jha'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <?php if ($permissions['categories']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create Hazards.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Hazards</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Task Or Activity</label><?php echo isset($error['task']) ? $error['task'] : ''; ?>
                            <input type="text" class="form-control" name="task" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hazard or Risk (Potential Danger)</label><?php echo isset($error['risk']) ? $error['risk'] : ''; ?>
                            <input type="text" class="form-control" name="risk" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Initial Risk NCE</label><?php echo isset($error['initial_nce']) ? $error['initial_nce'] : ''; ?>
                            <input type="text" class="form-control" name="initial_nce" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Initial Risk Liklihood</label><?php echo isset($error['initial_liklihood']) ? $error['initial_liklihood'] : ''; ?>
                            <input type="text" class="form-control" name="initial_liklihood" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Initial Risk Rating</label><?php echo isset($error['initial_rating']) ? $error['initial_rating'] : ''; ?>
                            <input type="text" class="form-control" name="initial_rating" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Proposed Control Measured</label><?php echo isset($error['proposed_control']) ? $error['proposed_control'] : ''; ?>
                            <input type="text" class="form-control" name="proposed_control" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Residual Risk NCE</label><?php echo isset($error['residual_nce']) ? $error['residual_nce'] : ''; ?>
                            <input type="text" class="form-control" name="residual_nce" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Residual Risk Liklihood</label><?php echo isset($error['residual_liklihood']) ? $error['residual_liklihood'] : ''; ?>
                            <input type="text" class="form-control" name="residual_liklihood" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Residual Risk Rating</label><?php echo isset($error['residual_rating']) ? $error['residual_rating'] : ''; ?>
                            <input type="text" class="form-control" name="residual_rating" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Action By</label><?php echo isset($error['action_by']) ? $error['action_by'] : ''; ?>
                            <input type="text" class="form-control" name="action_by" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Action Date</label><?php echo isset($error['action_date']) ? $error['action_date'] : ''; ?>
                            <input type="text" class="form-control" name="action_date" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Completed By</label><?php echo isset($error['completed_by']) ? $error['completed_by'] : ''; ?>
                            <input type="text" class="form-control" name="completed_by" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Completed Date</label><?php echo isset($error['completed_date']) ? $error['completed_date'] : ''; ?>
                            <input type="text" class="form-control" name="completed_date" required>
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