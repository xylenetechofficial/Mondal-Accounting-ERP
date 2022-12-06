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
    $shift_id = '1';

    $in_time = $today . ' 06:00:00';
    $out_time = $today . ' 14:00:00';

    if ($shift_id == '1') {
        //$hours = round((strtotime($out_time) - strtotime($in_time))/3600, 1);
        //$hours = (strtotime($out_time) - strtotime($in_time))/3600;
        $shift_in_time = $today . ' 06:00:00';
        $shift_out_time = $today . ' 13:50:00';
        $shift_ext_in_time = $today . ' 06:10:00';

        if ($in_time <= $shift_ext_in_time) {
            $final_in_time = $shift_in_time;
        } else {
            $final_in_time = $in_time;
        }

        if ($out_time >= $shift_out_time) {
            $final_out_time = $shift_out_time;
        } else {
            $final_out_time = $out_time;
        }
        print_r($final_in_time);print_r(' ----- ');
        print_r($final_out_time);print_r(' ----- ');

        $minutes = (strtotime($final_out_time) - strtotime($final_in_time)) / 3600 * 60;
        $hours = floor($minutes / 60);print_r($hours);print_r(' ----- ');
        $ext_minutes = $minutes % 60;
        print_r($ext_minutes);
    }

    ?>

</body>

</html>