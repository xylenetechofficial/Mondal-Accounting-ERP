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

    $ID = $_GET['id'];
    //print_r($ID);


    $m = $_GET['month'];
    $y = $_GET['year'];

    $date = strtotime("$m $y");

    $start_date = date('Y-m-01', $date);
    $end_date  = date('Y-m-t', $date);

    if (!isset($_GET['id']) || empty($_GET['id'])) { ?>
        <h2 class="text-center" style="margin-top: 20%;">Please Id</h2>
    <?php return false;
    } else {
        $ID = $_GET['id'];
        $sql = "SELECT * FROM salary WHERE emp_id =" . $ID;
        // Execute query
        $db->sql($sql);
        // store result 
        $row = $db->getResult();
    }
    if (!empty($row)) {

        $sql_query = "SELECT SUM(emp_attendance.hours) AS tot_hrs, SUM(emp_attendance.ot_hours) AS tot_ot_hrs, COUNT(emp_attendance.attendance) AS tot_days FROM `emp_attendance` WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "')  AND attendance ='present' AND emp_id =" . $ID;
        $db->sql($sql_query);
        $res = $db->getResult();

        $tot_hrs = $res[0]['tot_hrs'];
        $tot_ot_hrs = $res[0]['tot_ot_hrs'];
        $tot_days = $res[0]['tot_days'];

        $sql_query = "SELECT * FROM emp_joining_form WHERE id = '$ID' ORDER BY name DESC";
        $db->sql($sql_query);
        $res1 = $db->getResult();

        $name = $res1[0]['name'];
        $date = $res1[0]['date'];
        $dob = $res1[0]['dob'];
        $address = $res1[0]['permanant_address'];
        $joining_date = $res1[0]['date'];
        $emp_post = $res1[0]['emp_post'];
        $emp_no = $res1[0]['emp_no'];
        $bank_name = $res1[0]['bank_name'];
        $acc_no = $res1[0]['acc_no'];
        //$ref_no = $_GET['ref_no'];
        $salary = $res1[0]['salary'];
        $per_day_salary = $row[0]['basic_salary'];

        $basic_sal = $row[0]['basic_salary'] / 9 * $tot_hrs;

        //$spl_allowance = $_GET['spl_allowance'];
        $per_day_spl_allowance = $res1[0]['spl_allowance'];

        $spl_allowance = $row[0]['spl_allowance'] / 9 * $tot_hrs;

        $ot_sal = ($row[0]['basic_salary'] / 9) * 2 * $tot_ot_hrs;

        $pf_wages = $row[0]['pf_wages'] / 9 * $tot_hrs;
        $hra = $row[0]['hra'] / 9 * $tot_hrs;
        $gross_salary = $row[0]['gross_salary'] / 9 * $tot_hrs;
        $tot_gross_salary = $ot_sal + $gross_salary;
        $pf = $row[0]['pf'] / 9 * $tot_hrs;
        $esic = $row[0]['esic'] / 9 * $tot_hrs;
        $final_deduction = $row[0]['total_deduction'] / 9 * $tot_hrs;
        $net_salary = $row[0]['net_salary'] / 9 * $tot_hrs;
        $sal = $ot_sal + $net_salary;


        $tot_basic_sal = number_format((float)$basic_sal, 2, '.', '');
        $tot_spl_allowance = number_format((float)$spl_allowance, 2, '.', '');
        $tot_ot_sal = number_format((float)$ot_sal, 2, '.', '');
        $total_pf_wages = number_format((float)$pf_wages, 2, '.', '');
        $total_hra = number_format((float)$hra, 2, '.', '');
        $total_gross_salary = number_format((float)$tot_gross_salary, 2, '.', '');
        //$total_gross_salary = number_format((float)$gross_salary, 2, '.', '');
        $total_pf = number_format((float)$pf, 2, '.', '');
        $total_esic = number_format((float)$esic, 2, '.', '');
        $final_total_deduction = number_format((float)$final_deduction, 2, '.', '');
        $total_net_salary = number_format((float)$net_salary, 2, '.', '');
        $tot_sal = number_format((float)$sal, 2, '.', '');

    ?>


        <section class="container-fluid">
            <section class="content-header">
                <h1>
                    <!-- <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small> -->
                </h1>
            </section>
            <!-- <section class="content"> -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <!-- form start -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12" style="padding: 0px;">
                                        <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available;" alt="Mandal Engineering" class="img-responsive">
                                    </div>
                                </div>
                                <div class="row">
                                    <table border="1">
                                        <tr height="100px" style="background-color:#363636;color:#ffffff;text-align:center;font-size:24px; font-weight:600;">
                                            <td colspan='4' style="text-transform: uppercase;">Salary Slip Of <?php echo $m; ?> <?php echo $y; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Employee NO:</th>
                                            <td><?php echo $emp_no; ?></td>
                                            <th>Name</th>
                                            <td><?php echo $name; ?></td>
                                        </tr>
                                        <!-----2 row--->
                                        <tr>
                                            <th>Bank</th>
                                            <td><?php echo $bank_name; ?></td>
                                            <th>Bank A/c No.</th>
                                            <td><?php echo $acc_no; ?></td>
                                        </tr>
                                        <!------3 row---->
                                        <tr>
                                            <th>DOB</th>
                                            <td><?php echo $dob; ?></td>
                                            <th>Lop Days</th>
                                            <td>0</td>
                                        </tr>
                                        <!------4 row---->
                                        <tr>
                                            <th>PF No.</th>
                                            <td>26123456</td>
                                            <th>STD days</th>
                                            <td>30</td>
                                        </tr>
                                        <!------5 row---->
                                        <tr>
                                            <th>Location</th>
                                            <td>India</td>
                                            <th>Working Days</th>
                                            <td><?php echo $tot_days; ?></td>
                                        </tr>
                                        <!------6 row---->
                                        <tr>
                                            <th>Department</th>
                                            <td>IT</td>
                                            <th>Designation</th>
                                            <td><?php echo $emp_post; ?></td>
                                        </tr>
                                        <!-----7 row--->
                                        <tr>
                                            <th>Total Working Hours</th>
                                            <td><?php echo $tot_hrs; ?></td>
                                            <th>Total Over Time Hours</th>
                                            <td><?php echo $tot_ot_hrs; ?></td>
                                        </tr>
                                    </table>
                                    <tr></tr>
                                    <br />
                                    <table border="1">
                                        <tr>
                                            <th>Earnings</th>
                                            <th>Amount</th>
                                            <th>Deductions</th>
                                            <th>Amount</th>
                                        </tr>
                                        <tr>
                                            <td>Basic</td>
                                            <td><?= $tot_basic_sal; ?></td>
                                            <td>provident fund</td>
                                            <td><?= $total_pf; ?></td>
                                        </tr>
                                        <tr>
                                            <td>House Rent Allowance</td>
                                            <td><?= $total_hra; ?></td>
                                            <td>E.S.I.C</td>
                                            <td><?= $total_esic; ?></td>
                                        </tr>
                                        <tr>
                                            <td>special Allowance</td>
                                            <td>400</td>
                                            <!--<td>Income tax</td>
                                            <td>500</td>-->
                                        </tr>
                                        <tr>
                                            <td>P.F Wages</td>
                                            <td><?= $total_pf_wages; ?></td>
                                        </tr>
                                        <tr>
                                            <td>ADD Special allowance</td>
                                            <td>2000</td>
                                        </tr>
                                        <tr>
                                            <td>shift Allowance</td>
                                            <td>1000</td>
                                        </tr>
                                        <tr>
                                            <td>bonus</td>
                                            <td>500</td>
                                        </tr>
                                        <tr>
                                            <td>medical Allowance</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <th>Gross Earnings</th>
                                            <td>Rs.<?= $total_gross_salary; ?></td>
                                            <th>Gross Deductions</th>
                                            <td>Rs.<?= $final_total_deduction; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><strong>NET PAY</strong></td>
                                            <td>Rs.<?= $tot_sal; ?></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                            </div>

                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                </div>
                <div class="row no-print">
                    <div class="col-xs-12">
                        <form style="text-align: center; background-color:  white;"><button type='button' value='Print this page' onclick='printpage();' class="btn btn-success"><i class="fa fa-print"></i> Print</button>
                        </form>
                        <script>
                            function printpage() {
                                var is_chrome = function() {
                                    return Boolean(window.chrome);
                                }
                                if (is_chrome) {
                                    window.print();
                                    setTimeout(function() {
                                        window.close();
                                    }, 100000);
                                    //give them 10 seconds to print, then close
                                } else {
                                    window.print();
                                    window.close();
                                }
                            }
                        </script>
                    </div>
                </div>
            </section><!-- </section> -->
        </section>
    <?php //}
    } else { ?>
        <h1 class="text-center">Invalid Id</h1>
    <?php return false;
    } ?>
</body>

</html>