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
$sql_query = "SELECT * FROM emp_joining_form WHERE id =" . $ID;
// Execute query
$db->sql($sql_query);
// store result 
$res = $db->getResult();

$sql = "SELECT * FROM salary WHERE emp_id =" . $ID;
// Execute query
$db->sql($sql);
// store result 
$res1 = $db->getResult();



if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "add-emp-info.php";
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
				<form id="form" role="form" method="get" enctype="multipart/form-data" action="generate_appointment_pdf.php">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
							<input type="hidden" class="form-control" name="id" value="<?php echo $res[0]['id']; ?>" required>
							<!--<input type="hidden" class="form-control" name="user_id" value="<?php echo $res[0]['user_id']; ?>" required>-->
							<input type="text" class="form-control" value="<?php echo $res[0]['name']; ?>" disabled>
							<input type="hidden" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>" >
                            <input type="hidden" class="form-control" name="date" value="<?php echo $date; ?>" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                            <input type="text" class="form-control" name="address" value="<?php echo $res[0]['present_address']; ?>" disabled>
							<input type="hidden" class="form-control" name="address" value="<?php echo $res[0]['present_address']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Joining Date</label><?php echo isset($error['date']) ? $error['date'] : ''; ?>
							<input type="date" class="form-control" name="joining_date" value="<?php echo $res[0]['date']; ?>" disabled>
							<input type="hidden" class="form-control" name="joining_date" value="<?php echo $res[0]['date']; ?>" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Designation</label><?php echo isset($error['emp_post']) ? $error['emp_post'] : ''; ?>
							<input type="text" class="form-control" name="emp_post" value="<?php echo $res[0]['emp_post']; ?>"  disabled>
                            <input type="hidden" class="form-control" name="emp_post" value="<?php echo $res[0]['emp_post']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Reference No</label><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
							<input type="text" class="form-control" name="ref_no" value="" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Basic Salary</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="salary" value="<?php echo $res[0]['salary']; ?>" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">H.R.A</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="hra" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Medical</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="medical" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">L.T.A.</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="lta" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Home Allowance</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="home_allow" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Total</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="total" >
						</div>

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