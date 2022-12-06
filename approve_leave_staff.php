<?php
// start session

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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php include "header.php"; ?>
<html>

<head>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
    <link href="styles.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <script src="multidatespicker.js" type="text/javascript"></script>
    <title>Staff Leave Approve | <?= $settings['app_name'] ?> - Dashboard</title>
    <style>
        .asterik {
            font-size: 20px;
            line-height: 0px;
            vertical-align: middle;
        }
    </style>
</head>
</body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php include('public/approve_leave_staff_form.php'); ?>
</div><!-- /.content-wrapper -->
</body>

</html>
<?php include "footer.php"; ?>