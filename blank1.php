<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="dist/img/logo.png">
    <title>Salary Slip</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        table td {
            line-height: 25px;
            padding-left: 15px;
        }

        table th {
            background-color: #fbc403;
            color: #363636;
        }
    </style>
</head>

<body>

    <?php
    //include_once('library/jwt.php');
    include_once('includes/functions.php');
    include_once('includes/custom-functions.php');
    include_once('includes/crud.php');
    $function = new custom_functions;
    $settings = $function->get_configurations();
    $currency = $function->get_settings('currency');
    $db = new Database();
    $db->connect();
    $db->sql("SET NAMES 'utf8'");

    $today = date("Y-m-d");
    $yesterday = date("Y-m-d", strtotime("$today -1 day"));

    $in_time = '2022-11-13 09:11:00';
    $out_time = '2022-11-13 18:00:00';
    $org_out_time = $today .' 18:00:00';
    print_r($org_out_time);
/*
    $extra_minutes = (strtotime($org_out_time) - strtotime($out_time))/3600*60;
    print_r($extra_minutes); print_r("----");
*/
    $minutes = (strtotime($out_time) - strtotime($in_time))/3600*60;
    //print_r($minutes);
    $hours = floor($minutes/60);
    print_r($hours); print_r("----");
    $ext_minutes = $minutes % 60;
    print_r($ext_minutes); print_r("----");

    if (($ext_minutes > 49)&&($ext_minutes < 60))
    {
        $ext_hours = 1;
    } else {
        $ext_hours = 0;
    }

    $tot_hours = $hours + $ext_hours;
    print_r($tot_hours);

    if ($tot_hours > 9)
    {
        $ot_hours = $tot_hours - 9;
        $hours = $tot_hours - $ot_hours;
    } else {
        $ot_hours = 0;
        $hours = $tot_hours;
    }


    ?>
          
</body>

</html>