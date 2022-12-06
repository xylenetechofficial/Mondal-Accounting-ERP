<?php
include_once('includes/functions.php');

$db = new Database();
$db->connect();
//$sql_query = "SELECT * FROM userpdf WHERE user_id =" . $ID;
$sql_query = "SELECT * FROM `manual` ORDER BY `id` DESC";

// Execute query
$db->sql($sql_query);
// store result 
$res = $db->getResult();
//print_r($res);

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "customersEnquiry.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>VIew Manual</h1>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
	<hr />
</section>

<section class="content">
	<div class="row">
		<div class="col-md-6">
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Manual</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
					<?php foreach ($res as $pdf) { ?>
						<?php
						$pdfid = $pdf['id'];
						//print_r($pdfid);
						$strPdf = $pdf['pdf'];
						//print_r($strPdf);
						$pdfExplode = explode("/", $strPdf);
						//$pdfname = $pdfExplode[2];
                        $pdfname = $pdf['manual_name'];
						?>
						<div class="form-group">
						<a href="<?php echo $pdf['pdf']; ?>" target="_blank"><button style="font-size:14px;color:red"><i class="fa fa-file-pdf-o"></i>  <?php echo $pdfname; ?></button></a>
							&emsp;
							<!--<a class="btn-xs btn-danger" href="delete-pdf.php?id=<?php echo $pdf['upid']; ?>"><i class="fa fa-trash-o"></i>Delete</a>
							<a class="btn-xs btn-success" href="https://api.whatsapp.com/send?phone=+91<?php echo $pdf['mobile']; ?>&text=<?php echo $pdf['pdf']; ?>"><i class="fa fa-whatsapp"></i> Send</a>-->
						</div>
					<?php } ?>
				</div>

			</div><!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="public/MultiSelect/multiselect.js"></script>