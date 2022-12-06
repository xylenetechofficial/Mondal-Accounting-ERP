<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php

if (isset($_POST['btnAdd'])) {

?>
    <script type="text/javascript">
        window.location = "home.php";
    </script>
<?php
}

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>Add Party</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol><br />
    <!--<label style="vertical-align: bottom; margin-bottom: 14px;">Credit</label>
     <label class="switch">
         <input type="checkbox" checked>
         <span class="slider round"></span>
     </label>
     <label style="vertical-align: bottom; margin-bottom: 14px;">Cash</label>-->

    <hr />
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div id="credit" class="tab-pane active">
                    <form id="form" role="form" class="form" method="post" enctype="multipart/form-data" action="">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">From</label>
                                        <select class="form-control" id="" name="" required>
                                            <option value="">Innova</option>
                                            <option value="">Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">To</label>
                                        <input type="text" name="" value="Cash" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-4" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Amount</label>
                                        <input type="text" name="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-4" style="text-align-last: right;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <p><label for="outline-select">Due Date</label></p>
                                        <input type="date" name="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Add Description</label>
                                        <input type="text" name="" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-md-4" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Add Photo</label>
                                        <input type="file" name="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-3" style="text-align-last: left;">
                                    <div class="form-group pmd-textfield pmd-textfield-outline pmd-textfield-floating-label">
                                        <label for="outline-select">Location</label>
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
                                </div>

                            </div><br /><br />

                        </div>
                        <div class="box-footer" style="text-align-last: center;">
                            <input type="submit" class="btn btn-primary" name="btnAdd">
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>


<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<!--<script src="public/MultiSelect/multiselect.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
</script>
<script>
    //var can_submit = false;
    $('form').on('submit', function(e) {

        var confirmation = confirm("Do you want to continue");
        if (confirmation) {
            console.log("Clicked OK - submitting now ...");
            //can_submit = true;

        } else {
            console.log("Clicked Cancel");
            //can_submit = false;
            return false;
        }

    });
</script>