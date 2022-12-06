<?php 
// Include calendar helper functions 
include_once 'function.php'; 
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>PHP Event Calendar by CodexWorld</title>
<meta charset="utf-8">
<link rel="icon" href="https://www.codexworld.com/wp-content/uploads/2014/09/favicon.ico" type="image/x-icon">
<link href="https://demos.codexworld.com/includes/css/bootstrap.css" rel="stylesheet">
<link href="https://demos.codexworld.com/includes/css/style.css" rel="stylesheet">
<script src="https://pagead2.googlesyndication.com/pagead/managed/js/adsense/m202211100101/reactive_library_fy2021.js"></script>
<script src="https://partner.googleadservices.com/gampad/cookie.js?domain=demos.codexworld.com&amp;callback=_gfp_s_&amp;client=ca-pub-5750766974376423&amp;cookie=ID%3D5329b5a85f54e4fd-22faabee5ad80003%3AT%3D1668323455%3ART%3D1668323455%3AS%3DALNI_Ma5wYywQwp6wc3poY4vYMK797cgvg&amp;gpic=UID%3D00000b7b0ba95a13%3AT%3D1668323455%3ART%3D1668680265%3AS%3DALNI_Ma10coLRoF0wrioExrKVPH9wepvNw&amp;gpid_exp=1"></script>
<script src="https://pagead2.googlesyndication.com/pagead/managed/js/adsense/m202211100101/show_ads_impl_fy2021.js" id="google_shimpl"></script>
<script async="" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- Stylesheet file -->
<link rel="stylesheet" href="calender_css/style.css">

<!-- jQuery library -->
<script src="calender_js/jquery.min.js"></script>
</head>
<body>
    <!-- Display event calendar -->
    <div id="calendar_div">
        <?php echo getCalender(); ?>
    </div>
</body>
</html>