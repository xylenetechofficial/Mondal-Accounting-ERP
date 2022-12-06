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

        $safegaurd_name = $db->escapeString($fn->xss_clean($_POST['safegaurd_name']));

        $jha_job_seq_id = $db->escapeString($fn->xss_clean($_POST['jha_job_seq_id']));
        $sql = "SELECT job_steps FROM `jha_job_seq` WHERE id = '$jha_job_seq_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $row)
            $jha_job_seq1 = $row;
        $jha_job_seq = implode(',', $jha_job_seq1);
        //print_r($location);


        $location_id = $db->escapeString($fn->xss_clean($_POST['location_id']));
        $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res1 = $db->getResult();
        foreach ($res1 as $row1)
            $location1 = $row1;
        $location = implode(',', $location1);
        //print_r($location);

        $jha_type_id = $db->escapeString($function->slugify($fn->xss_clean($_POST['jha_type_id'])));
        $sql = "SELECT name FROM `jha_type` WHERE id = '$jha_type_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res2 = $db->getResult();
        foreach ($res2 as $row2)
            $jha_type1 = $row2;
        $jha_type = implode(',', $jha_type1);
        //print_r($location);

        $jha_potential_hazard_id = $db->escapeString($fn->xss_clean($_POST['jha_potential_hazard_id']));
        $sql = "SELECT potential_hazard_name FROM `jha_potential_hazard` WHERE id = '$jha_potential_hazard_id' ORDER BY id DESC limit 1";
        $db->sql($sql);
        $res3 = $db->getResult();
        foreach ($res3 as $row3)
            $jha_potential_hazard1 = $row3;
        $jha_potential_hazard = implode(',', $jha_potential_hazard1);
        //print_r($location);

        // create array variable to handle error
        $error = array();

        if (empty($safegaurd_name)) {
            $error['safegaurd_name'] = " <span class='label label-danger'>Required!</span>";
        }

        if (!empty($safegaurd_name)) {

            $sql_query = "INSERT INTO jha_safegaurd (jha_job_seq_id,jha_job_seq, jha_potential_hazard_id, jha_potential_hazard, jha_type_id, jha_type, safegaurd_name, location_id, location)
						VALUES('$jha_job_seq_id','$jha_job_seq', '$jha_potential_hazard_id', '$jha_potential_hazard', '$jha_type_id', '$jha_type','$safegaurd_name', '$location_id', '$location')";


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
                $error[' add_potential'] = " <section class='content-header'><span class='label label-success'>Potential Hazard Added Successfully</span></section>";
            } else {
                $error[' add_potential'] = " <span class='label label-danger'>Failed add Potential Hazard</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'><span class='label label-danger'>You have no permission to create Potential Hazard</span></section>";
    }
}

if (isset($_POST['btnCancel'])) {
    header("location:add-jha-potential-hazard.php");
}

?>
<section class="content-header">
    <h1>Add Sub Potential Hazard<small><a href='add-jha-potential-hazard.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Sub Potential Hazard</a></small></h1>
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
                <div class="alert alert-danger">You have no permission to create Potential Hazard.</div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Sub Category</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">JHA Job Sequence</label><?php echo isset($error['jha_job_seq_id']) ? $error['jha_job_seq_id'] : ''; ?>
                            <select class="form-control" id="jha_job_seq_id" name="jha_job_seq_id" required>
                                <option value="">--Select Job Sequence--</option>
                                <?php
                                $sql = "SELECT * FROM jha_job_seq";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $jha_job_seq) {
                                    echo "<option value='" . $jha_job_seq['id'] . "'>" . $jha_job_seq['job_steps'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">JHA Potential Hazard</label><?php echo isset($error['jha_potential_hazard_id']) ? $error['jha_potential_hazard_id'] : ''; ?>
                            <select name="jha_potential_hazard_id" id="jha_potential_hazard_id" class="form-control">
                                <option value="">--Select Potential Hazard--</option>
                            </select>
                        </div>
                        <!--<div class="form-group">
                            <label for="exampleInputEmail1">Safeguard / Controls to be put in place</label><?php echo isset($error['safegaurd_name']) ? $error['safegaurd_name'] : ''; ?>
                            <input type="text" class="form-control" name="safegaurd_name" required>
                        </div>-->
                        <div class="form-group">
                            <label for="safegaurd_name">Safeguard / Controls to be put in place :</label> <i class="text-danger asterik">*</i><?php echo isset($error['safegaurd_name']) ? $error['safegaurd_name'] : ''; ?>
                            <textarea name="safegaurd_name" id="safegaurd_name" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('safegaurd_name');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">JHA Type</label><?php echo isset($error['jha_type_id']) ? $error['jha_type_id'] : ''; ?>
                            <select class="form-control" id="jha_type_id" name="jha_type_id" required>
                                <option value="">--Select JHA Type--</option>
                                <?php
                                $sql = "SELECT * FROM `jha_type`";
                                $db->sql($sql);
                                $res = $db->getResult();
                                foreach ($res as $jha_type) {
                                    echo "<option value='" . $jha_type['id'] . "'>" . $jha_type['name'] . "</option>";
                                }
                                ?>
                            </select>
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

<script>
    $(document).on('change', '#jha_job_seq_id', function() {
        $.ajax({
            url: "public/db-operation.php",
            data: "jha_job_seq_id=" + $('#jha_job_seq_id').val() + "&change_jha_job_seq_id=1",
            method: "POST",
            success: function(data) {
                $('#jha_potential_hazard_id').html("<option value=''>---Select Potential Hazard---</option>" + data);
            }
        });
    });
</script>

<?php $db->disconnect(); ?>