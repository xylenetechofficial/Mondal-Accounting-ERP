<?php
// start session
ob_start();

session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

?>

<?php include "header.php"; ?>
<html>

<head>
    <title>Add JHA PDFs | <?= $settings['app_name'] ?> - Dashboard <?= $settings['isAuth'] ?> </title>
</head>
</body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php
    include('public/add-jha-pdfs-form.php');
    ?>
</div><!-- /.content-wrapper -->
</body>

</html>
<?php include "footer.php"; ?>