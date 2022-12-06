<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="styles.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <script src="multidatespicker.js" type="text/javascript"></script>

</head>

<body>
    <?php
    session_reset();

    session_start();
    $ip_add = getenv("REMOTE_ADDR");

    include_once('includes/functions.php');
    date_default_timezone_set('Asia/Kolkata');
    $function = new functions;
    include_once('includes/custom-functions.php');
    include_once('includes/crud.php');
    include_once('includes/variables.php');
    $fn = new custom_functions;
    $fn = new custom_functions();
    $db = new Database();
    $db->connect();
    date_default_timezone_set('Asia/Kolkata');
    //$datetime = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    //$effectiveDate = date('Y-m-d', strtotime("+3 months", strtotime($date)));
    //print_r($effectiveDate);
    $ID = (isset($_GET['id'])) ? $db->escapeString($fn->xss_clean($_GET['id'])) : "";

    ?>
    <?php
    if (isset($_POST['btnAdd'])) {

        $datetime = date("Y-m-d H:i:s");
        print_r($datetime);
        $selectedValues = $_POST['selectedValues'];
        print_r($selectedValues);
        if (isset($_SESSION["id"])) {
            $user_id = $_SESSION["id"];
            print_r($user_id);
        } else {
            $user_id = '0';
            print_r($user_id);
        }
        //$selectedValues1 = count($selectedValues);
        //print_r($selectedValues1);
    }
    ?>
    <form id="form" role="form" method="post" enctype="multipart/form-data" action="">
        <div style="width: 22%;margin:20px;">
            <input type="text" name="selectedValues" id="selectedValues" class="date-values" readonly />
            <div id="parent" class="container" style="display:none;">
                <div class="row header-row">
                    <div class="col-xs previous">
                        <a href="" id="previous" onclick="previous()">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="card-header month-selected col-sm" id="monthAndYear">
                    </div>
                    <div class="col-sm">
                        <select class="form-control col-xs-6" name="month" id="month" onchange="change()"></select>
                    </div>
                    <div class="col-sm">
                        <select class="form-control col-xs-6" name="year" id="year" onchange="change()"></select>
                    </div>
                    <div class="col-xs next">
                        <a href="" id="next" onclick="next()">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <table id="calendar">
                    <thead>
                        <tr>
                            <th>S</th>
                            <th>M</th>
                            <th>T</th>
                            <th>W</th>
                            <th>T</th>
                            <th>F</th>
                            <th>S</th>
                        </tr>
                    </thead>
                    <tbody id="calendarBody"></tbody>
                </table>
            </div>
        </div><br /><br />
        <div class="box-footer">
            <input type="submit" class="btn btn-primary" name="btnAdd">
        </div>
    </form>
</body>

</html>