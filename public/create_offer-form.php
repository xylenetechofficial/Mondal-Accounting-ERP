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

$sql_query = "SELECT * FROM test_form WHERE id =" . $ID;
// Execute query
$db->sql($sql_query);
// store result 
$res = $db->getResult();

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
				<form id="form" role="form" method="post" enctype="multipart/form-data" action="offer/generate_offer_pdf.php">
					<div class="box-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Name</label><?php echo isset($error['name']) ? $error['name'] : ''; ?>
							<input type="hidden" class="form-control" name="id" value="<?php echo $res[0]['id']; ?>" required>
							<!--<input type="hidden" class="form-control" name="user_id" value="<?php echo $res[0]['user_id']; ?>" required>-->
							<input type="text" class="form-control" value="<?php echo $res[0]['name']; ?>" disabled>
							<input type="hidden" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Email</label><?php echo isset($error['email']) ? $error['email'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['email']; ?>" disabled>
							<input type="hidden" class="form-control" name="email" value="<?php echo $res[0]['email']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Mobile</label><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['mobile']; ?>" disabled>
							<input type="hidden" class="form-control" name="mobile" value="<?php echo $res[0]['mobile']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Age (Yrs)</label><?php echo isset($error['age']) ? $error['age'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['age']; ?>" disabled>
							<input type="hidden" class="form-control" name="age" value="<?php echo $res[0]['age']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Height (ft)</label><?php echo isset($error['height']) ? $error['height'] : ''; ?>
							<input type="text" class="form-control" value="<?php echo $res[0]['height']; ?>" disabled>
							<input type="hidden" class="form-control" name="height" value="<?php echo $res[0]['height']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Weight</label><?php echo isset($error['weight']) ? $error['weight'] : ''; ?>
                            <input type="text" class="form-control" value="<?php echo $res[0]['weight']; ?>" disabled>
							<input type="hidden" class="form-control" name="weight" value="<?php echo $res[0]['weight']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Address</label><?php echo isset($error['address']) ? $error['address'] : ''; ?>
                            <input type="text" class="form-control" value="<?php echo $res[0]['address']; ?>" disabled>
							<input type="hidden" class="form-control" name="address" value="<?php echo $res[0]['address']; ?>" >
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Qualification</label><?php echo isset($error['qualification']) ? $error['qualification'] : ''; ?>
                            <input type="text" class="form-control" value="<?php echo $res[0]['qualification']; ?>" disabled>
							<input type="hidden" class="form-control" name="qualification" value="<?php echo $res[0]['qualification']; ?>" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Gender</label><?php echo isset($error['gender']) ? $error['gender'] : ''; ?>
                            <input type="text" class="form-control" value="<?php echo $res[0]['gender']; ?>" disabled>
							<input type="hidden" class="form-control" name="gender" value="<?php echo $res[0]['gender']; ?>" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Designation</label><?php echo isset($error['designation']) ? $error['designation'] : ''; ?>
							<input type="text" class="form-control" name="designation" >
						</div>
                        <div class="form-group">
							<label for="exampleInputEmail1">Salary</label><?php echo isset($error['salary']) ? $error['salary'] : ''; ?>
							<input type="text" class="form-control" name="salary" >
						</div>

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="btnAdd">
					</div>

				</form>

			</div><!-- /.box -->
		</div>

		<!--<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">PDF History</h3>
				</div>
				<div class="box-body">
					<?php
					$sql_query = "SELECT userpdf.id AS upid, userpdf.user_id AS upuid, userpdf.diet_question_id AS updqid, userpdf.pdf, users.id, users.mobile FROM `userpdf` INNER JOIN `users` ON userpdf.user_id = users.id WHERE userpdf.user_id =" . $USERID . " ORDER BY userpdf.id DESC";
					// Execute query
					$db->sql($sql_query);
					// store result
					$res = $db->getResult();

					foreach ($res as $pdf) { ?>
						<?php
						$strPdf = $pdf['pdf'];
						//print_r($strPdf);
						$pdfExplode = explode("/", $strPdf);
						$pdfname = $pdfExplode[4];
						?>
						<div class="form-group">
							<a href="<?php echo $pdf['pdf']; ?>" target="_blank"><button style="font-size:14px;color:red"><i class="fa fa-file-pdf-o"></i> <?php echo $pdfname; ?></button></a>
							&emsp;
							<a class="btn-xs btn-danger" href="delete-pdf.php?id=<?php echo $pdf['upid']; ?>"><i class="fa fa-trash-o"></i>Delete</a>
							<a class="btn-xs btn-success" href="https://api.whatsapp.com/send?phone=+91<?php echo $pdf['mobile']; ?>&text=<?php echo $pdf['pdf']; ?>"><i class="fa fa-whatsapp"></i> Send</a>
						</div>
					<?php } ?>
				</div>

			</div>
		</div>-->

	</div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>