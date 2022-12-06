<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_GET['id'])) {
	$ID = $_GET['id']; //print_r($ID);
    $location_id = $_GET['location_id']; //print_r($ID);
} else {
	$ID = "";
}

$date = date("Y-m-d");
$sql_query = "SELECT * FROM emp_selection_process WHERE id =" . $ID;
// Execute query
$db->sql($sql_query);
// store result 
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "emp-selection.php";
	</script>
<?php } ?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-primary">
				<!-- form start -->
				<form id="form" role="form" method="get" enctype="multipart/form-data" action="generate_emp_selection_pdf.php">
					<div class="box-body">
						<div class="form-group">
							<input type="hidden" class="form-control" name="id" value="<?php echo $res[0]['id']; ?>" required>
							<input type="hidden" class="form-control" name="location_id" value="<?php echo $res[0]['location_id']; ?>" >
						</div>
                        
						<div class="form-group">
							<label for="exampleInputEmail1">Doc No</label><?php echo isset($error['doc_no']) ? $error['doc_no'] : ''; ?>
							<input type="text" class="form-control" name="doc_no" required>
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Issue Date</label><?php echo isset($error['issue_date']) ? $error['issue_date'] : ''; ?>
							<input type="date" class="form-control" name="issue_date"  required>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Rev No. & Date</label><?php echo isset($error['rev_no']) ? $error['rev_no'] : ''; ?>
							<input type="text" class="form-control" name="rev_no" required>
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
                        <!--<div class="form-group">
							<label for="exampleInputEmail1">Total</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="total" >
						</div>-->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="btnAdd">
					</div>

				</form>

			</div><!-- /.box -->
		</div>

	</div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>