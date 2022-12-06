<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_GET['id'])) {
	$ID = $_GET['id']; //print_r($ID);
	//$USERID = $_GET['userId']; //print_r($USERID);
} else {
	$ID = "";
}

$date = date("Y-m-d");
$sql_query = "SELECT * FROM jha_type WHERE id =" . $ID;
// Execute query
$db->sql($sql_query);
// store result 
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "jha-types.php";
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
				<form id="form" role="form" method="get" enctype="multipart/form-data" action="generate_jha_pdf.php">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
							<input type="hidden" class="form-control" name="id" value="<?php echo $res[0]['id']; ?>" required>
							<input type="text" class="form-control" value="<?php echo $res[0]['name']; ?>" disabled>
							<input type="hidden" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Department & Section</label><?php echo isset($error['department']) ? $error['department'] : ''; ?>
                            <input type="text" class="form-control" name="department" required>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Doc No</label><?php echo isset($error['doc_no']) ? $error['doc_no'] : ''; ?>
							<input type="text" class="form-control" name="doc_no" required>
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Rev</label><?php echo isset($error['rev']) ? $error['rev'] : ''; ?>
							<input type="text" class="form-control" name="rev"  required>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Dated</label><?php echo isset($error['date']) ? $error['date'] : ''; ?>
							<input type="date" class="form-control" name="date" required>
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Revision no</label><?php echo isset($error['revision_no']) ? $error['revision_no'] : ''; ?>
							<input type="text" class="form-control" name="revision_no" required>
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Team</label><?php echo isset($error['team']) ? $error['team'] : ''; ?>
							<input type="text" class="form-control" name="team" value="MANDAL ENGINEERING" required>
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Prepared By</label><?php echo isset($error['prepared_by']) ? $error['prepared_by'] : ''; ?>
							<input type="text" class="form-control" name="prepared_by" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Contractor Approved By</label><?php echo isset($error['cont_approved_by']) ? $error['cont_approved_by'] : ''; ?>
							<input type="text" class="form-control" name="cont_approved_by" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Approved By</label><?php echo isset($error['approved_by']) ? $error['approved_by'] : ''; ?>
							<input type="text" class="form-control" name="approved_by" >
						</div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">JHA Type</label><?php echo isset($error['jha_type']) ? $error['jha_type'] : ''; ?>
                            <select class="form-control" id="jha_type" name="jha_type" required>
                                <option value="">--Select JHA--</option>
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