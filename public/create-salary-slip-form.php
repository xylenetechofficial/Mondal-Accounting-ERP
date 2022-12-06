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
				<form id="form" role="form" method="get" enctype="multipart/form-data" action="generate_salary_slip.php">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
							<input type="hidden" class="form-control" name="id" value="<?php echo $res[0]['id']; ?>" required>
							<!--<input type="hidden" class="form-control" name="user_id" value="<?php echo $res[0]['user_id']; ?>" required>-->
							<input type="text" class="form-control" value="<?php echo $res[0]['name']; ?>" disabled>
							<input type="hidden" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
							<input type="hidden" class="form-control" name="date" value="<?php echo $date; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['present_address']; ?>" disabled>
							<input type="hidden" class="form-control" name="address" value="<?php echo $res[0]['present_address']; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Joining Date</label><?php echo isset($error['date']) ? $error['date'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['date']; ?>" disabled>
							<input type="hidden" class="form-control" name="joining_date" value="<?php echo $res[0]['date']; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Designation</label><?php echo isset($error['emp_post']) ? $error['emp_post'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['emp_post']; ?>" disabled>
							<input type="hidden" class="form-control" name="emp_post" value="<?php echo $res[0]['emp_post']; ?>">
						</div>

						<div class="form-group">
							<label for="exampleInputEmail1">Basic Salary</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['salary']; ?>" disabled>
							<input type="hidden" class="form-control" name="salary" value="<?php echo $res[0]['salary']; ?>">
							<input type="hidden" class="form-control" name="basic_salary" value="<?php echo $res1[0]['basic_salary']; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Special Allowance</label><?php echo isset($error['spl_allowance']) ? $error['spl_allowance'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['spl_allowance']; ?>" disabled>
							<input type="hidden" class="form-control" name="spl_allowance" value="<?php echo $res[0]['spl_allowance']; ?>">
							<input type="hidden" class="form-control" name="per_day_spl_allowance" value="<?php echo $res1[0]['spl_allowance']; ?>">
							<input type="hidden" class="form-control" name="pf_wages" value="<?php echo $res1[0]['pf_wages']; ?>">
							<input type="hidden" class="form-control" name="hra" value="<?php echo $res1[0]['hra']; ?>">
							<input type="hidden" class="form-control" name="gross_salary" value="<?php echo $res1[0]['gross_salary']; ?>">
							<input type="hidden" class="form-control" name="pf" value="<?php echo $res1[0]['pf']; ?>">
							<input type="hidden" class="form-control" name="esic" value="<?php echo $res1[0]['esic']; ?>">
							<input type="hidden" class="form-control" name="total_deduction" value="<?php echo $res1[0]['total_deduction']; ?>">
							<input type="hidden" class="form-control" name="net_salary" value="<?php echo $res1[0]['net_salary']; ?>">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Select Month & Year</label><?php echo isset($error['tot_days']) ? $error['tot_days'] : ''; ?><br />
							<div class="col-md-3">
								<select class="form-control" id="month" name="month" onchange="updateqty()">
									<option value="">--Select Month--</option>
									<option value="january">January</option>
									<option value="february">February</option>
									<option value="march">March</option>
									<option value="april">April</option>
									<option value="may">May</option>
									<option value="june">June</option>
									<option value="july">July</option>
									<option value="august">August</option>
									<option value="september">September</option>
									<option value="october">October</option>
									<option value="november">November</option>
									<option value="december">December</option>
								</select>
							</div>
							<div class="col-md-3">
								<select class="form-control" id="year" name="year" onchange="updateqty()">
									<option value="">--Select Year--</option>
									<?php

									for ($i = date('Y'); $i >= 2015; $i--) {
										echo "<option value=" . $i . ">" . $i . "</option>";
									}
									?>
								</select>
							</div>
						</div><br /><br />

						<div class="box-footer" style="text-align: center;">
							<input type="submit" class="btn btn-primary" name="btnAdd">
						</div>

				</form>

			</div><!-- /.box -->
		</div>

	</div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>