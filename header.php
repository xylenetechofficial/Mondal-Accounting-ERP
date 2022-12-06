<?php include_once('includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");

include('includes/variables.php');
include_once('includes/custom-functions.php');
include_once('includes/functions.php');
$fn = new custom_functions;
$permissions = $fn->get_permissions($_SESSION['id']);
$config = $fn->get_configurations();
$time_zone = $fn->set_timezone($config);
if (!$time_zone) {
    echo "Time Zone is not set.";
    return false;
    exit();
}

$settings['app_name'] = $config['app_name'];
$words = explode(" ", $settings['app_name']);
$acronym = "";
foreach ($words as $w) {
    $acronym .= $w[0];
}

$currency = $fn->get_settings('currency');
$settings['currency'] = $currency;
$isAuth = $fn->get_settings('doctor_brown');
$cal_time_check = $time_check = '';
if (!empty($isAuth)) {
    $isAuth = json_decode($isAuth);
    $time_check = $isAuth->time_check;
    $str = trim($isAuth->code_bravo) . "|" . trim($isAuth->code_adam) . "|" . trim($isAuth->dr_firestone) . "|" . DOMAIN_URL;
    $cal_time_check = hash('sha256', $str);
}

$role = $fn->get_role($_SESSION['id']);
$sql_logo = "select value from `settings` where variable='Logo' OR variable='logo'";
$db->sql($sql_logo);
$res_logo = $db->getResult();
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/ico" href="<?= 'dist/img/' . $res_logo[0]['value'] ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link href="dist/css/multiple-select.css" rel="stylesheet" />
    <link rel="stylesheet" href="dist/css/print.css" type="text/css" media="print">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <script src="plugins/jQuery/jquery-3.3.1.min.js"></script>
    <script src="plugins/jQueryUI/jquery-ui.js"></script>
    <link rel="stylesheet" href="plugins/switchery/switchery.min.css">
    <script src="plugins/switchery/switchery.min.js"></script>
    <link href="plugins/datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/dropzone/dropzone.css">
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="plugins/izitoast/iziToast.css">
    <link rel="stylesheet" href="plugins/izitoast/iziToast.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-table.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap-table-filter-control.css" />
    <link rel="stylesheet" href="dist/css/jquery.fancybox.min.css" />

    <script src="dist/js/jquery.fancybox.min.js"></script>
    <link href="plugins/select2/select2.min.css" rel="stylesheet" />
    <script src="plugins/select2/select2-4.0.6.min.js"></script>
    <link rel="stylesheet" href="dist/css/lightbox.min.css">
    <script src="dist/js/lightbox.min.js"></script>
    <script src="dist/js/tinymce.min.js"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            var currentMonth = date.getMonth() - 10;
            var currentDate = date.getDate();
            var currentYear = date.getFullYear() - 10;

            $('.datepicker').datepicker({
                minDate: new Date(currentYear, currentMonth, currentDate),
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
    <script language="javascript">
        function printpage() {
            window.print();
        }
    </script>
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">

        <!-- verify purchase code -->
        <?php /*
        if ($time_check != $cal_time_check || empty($cal_time_check) || empty($time_check)) {
            $file = basename($_SERVER['PHP_SELF']);
            if ($file != 'purchase-code.php') { ?>
                <div class="overlay" style="background: #000000d9; position: absolute; width: 100%; height: 307%; z-index: 9999999;">
                    <div class="container text-center " style="background: white; padding: 100px; margin-top: 10%;">
                        <div>
                            <h4>Please activate the system use it further</h4>
                            <a href="purchase-code.php"><i class="fa fa-check"></i> Register system</a>
                        </div>
                    </div>
                </div>
        <?php exit();
            }
        } */ ?>

        <header class="main-header">
            <a href="home.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <h2><?= $acronym ?></h2>
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <h3><?= $settings['app_name'] ?></h3>
                </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <?php
                        $sql_query = "SELECT * FROM admin where id=" . $_SESSION['id'];

                        $db->sql($sql_query);
                        $result = $db->getResult();
                        foreach ($result as $row) {
                            $user = $row['username'];
                            $email = $row['email'];
                        ?>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="images/avatar.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?= $user; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="images/avatar.png" class="img-circle" alt="User Image">
                                        <p>
                                            <?= $user; ?>
                                            <small><?= $email; ?></small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="admin-profile.php" class="btn btn-default btn-flat"> Edit Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Log out</a>
                                        </div>
                                    </li>
                                    <!-- Menu Body -->
                                    <!-- Menu Footer-->
                                </ul>
                            </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar" id="style-6">
            <?php } ?>

            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="home.php">
                        <i class="fa fa-home" class="active"></i> <span>Home</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>HRMS</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="add_emp_join.php"><i class="fa fa-sliders"></i> Add Employees</a></li>
                        <li><a href="emp-info.php"><i class="fa fa-sliders"></i> EMPLOYEE INFORMATION List</a></li>
                        <li><a href="get_emp_offer.php"><i class="fa fa-sliders"></i> Generate Offer Letter</a></li>
                        <li><a href="get_emp_appoint.php"><i class="fa fa-sliders"></i> Generate Appointment Letter</a></li>
                        <li><a href="get_emp_salary_slip.php"><i class="fa fa-sliders"></i> Generate Salary Slip</a></li>
                        <li><a href="get_emp_birthday.php"><i class="fa fa-sliders"></i> Today's Birthday List</a></li>
                        <li><a href="get_emp_probation_list.php"><i class="fa fa-sliders"></i> Probation Period Employee List</a></li>
                        <li><a href="get_emp_probation_end_list.php"><i class="fa fa-sliders"></i> Probation Period End Employee List</a></li>
                        <li><a href="todays_labour_attandance.php"><i class="fa fa-sliders"></i> Today's Labours Attandance List</a></li>
                        <li><a href="todays_staff_attandance.php"><i class="fa fa-sliders"></i> Today's Staff Attandance List</a></li>
                        <li><a href="labours_leave_apply.php"><i class="fa fa-sliders"></i> Labours Leaves Apply List</a></li>
                        <li><a href="staff_leave_apply.php"><i class="fa fa-sliders"></i> Staff Leaves Apply List</a></li>
                        <li><a href="main-slider.php"><i class="fa fa-sliders"></i> Home Slider Images</a></li>
                        <li><a href="add-news.php"><i class="fa fa-sliders"></i> Add News</a></li>                        
                        <!--<li><a href="get_emp_salary_slip.php"><i class="fa fa-sliders"></i> Generate Conformation Letter</a></li>-->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bullseye"></i>
                                <span>Employee Designation</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="designation.php"><i class="fa fa-sliders"></i> Designation List</a></li>
                                <li><a href="add-emp-designation.php"><i class="fa fa-reorder"></i> Add Designation</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Purchase</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <!--<ul class="treeview-menu">
                        <li><a href="categories.php"><i class="fa fa-sliders"></i> Manage Categories</a></li>
                        <li><a href="categories-order.php"><i class="fa fa-reorder"></i> Categories Order</a></li>
                    </ul>-->
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Account</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="generate_salary_labour.php"><i class="fa fa-sliders"></i> Generate Labours Salary</a></li>
                        <li><a href="generate_salary_staff.php"><i class="fa fa-sliders"></i> Generate Staff Salary</a></li>
                        <li><a href="get_emp_salary_slip.php"><i class="fa fa-sliders"></i> Generate Salary Slip</a></li>
                        <li><a href="add_sales.php"><i class="fa fa-sliders"></i> Add Sales</a></li>
                        <li><a href="add_quotation.php"><i class="fa fa-sliders"></i> Add Quotation</a></li>
                        <li><a href="add_party.php"><i class="fa fa-sliders"></i> Add Party</a></li>
                        <li><a href="Parties-new.php"><i class="fa fa-sliders"></i> Parties</a></li>
                        <li><a href="sale_order.php"><i class="fa fa-sliders"></i> Sale Order</a></li>
                        <li><a href="del_challan.php"><i class="fa fa-sliders"></i> Delivery Challan</a></li>
                        <li><a href="credit_note.php"><i class="fa fa-sliders"></i> Credit Note</a></li>
                        <li><a href="add_purchase.php"><i class="fa fa-sliders"></i> Add Purchase</a></li>
                        <li><a href="purchase_order.php"><i class="fa fa-sliders"></i> Purchase Order</a></li>
                        <li><a href="debit_note.php"><i class="fa fa-sliders"></i> Debit Note</a></li>
                        <li><a href="add_expense.php"><i class="fa fa-sliders"></i> Add Expense</a></li>
                        <li><a href="bank_acc.php"><i class="fa fa-sliders"></i> Bank Account</a></li>
                        <li><a href="add_payment_in.php"><i class="fa fa-sliders"></i> Add Payment In</a></li>
                        <li><a href="add_payment_out.php"><i class="fa fa-sliders"></i> Add Payment Out</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Marketing</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <!--<ul class="treeview-menu">
                        <li><a href="categories.php"><i class="fa fa-sliders"></i> Manage Categories</a></li>
                        <li><a href="categories-order.php"><i class="fa fa-reorder"></i> Categories Order</a></li>
                    </ul>-->
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Store</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bullseye"></i>
                                <span>Categories</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="categories.php"><i class="fa fa-sliders"></i> Manage Categories</a></li>
                                <li><a href="add-category.php"><i class="fa fa-reorder"></i> Add Categories</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bullseye"></i>
                                <span>Sub Categories</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="subcategories.php"><i class="fa fa-sliders"></i> Manage Sub Categories</a></li>
                                <li><a href="add-subcategory.php"><i class="fa fa-reorder"></i> Add Sub Categories</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cubes"></i>
                                <span>Products</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="add-product.php"><i class="fa fa-plus"></i> Add Product</a></li>
                                <li><a href="products.php"><i class="fa fa-sliders"></i> Manage Products</a></li>
                                <li><a href="products-taxes.php"><i class="fa fa-plus"></i> Taxes</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-map-marker"></i>
                                <span>Work Location</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="location.php"><i class="fa fa-reorder"></i> Location List</a></li>
                                <li><a href="add_location.php"><i class="fa fa-location-arrow"></i> Add Location </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-male"></i>
                                <span>Customers</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="add_cust.php"><i class="fa fa-sliders"></i> Add Customer</a></li>
                                <li><a href="cust.php"><i class="fa fa-reorder"></i> Customers List</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-male"></i>
                                <span>Suppliers</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="add_supplier.php"><i class="fa fa-sliders"></i> Add Suppliers</a></li>
                                <li><a href="supplier.php"><i class="fa fa-reorder"></i> Suppliers List</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Safety</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(I) Manual</a></li>
                        <ul>
                            <li><a href="add-manual.php"><i class="fa fa-sliders"></i> Add Manual</a></li>
                            <li><a href="manual.php"><i class="fa fa-sliders"></i> Manual Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(III) Emergency plan</a></li>
                        <ul>
                            <li><a href="emergency_plans.php"><i class="fa fa-sliders"></i> Emergency plan Form</a></li>
                            <li><a href="emergency_plans_list.php"><i class="fa fa-reorder"></i> Emergency plan List</a></li>
                            <li><a href="add_emergency_plans_pdf.php"><i class="fa fa-sliders"></i> Upload Emergency plan PDFs</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(IV) Mock Drill Reports</a></li>
                        <ul>
                            <li><a href="mock-drill.php"><i class="fa fa-sliders"></i> Mock Drill Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(V) Org structure & roles & responsibility</a></li>
                        <ul>
                            <li><a href="job_description.php"><i class="fa fa-sliders"></i> Org structure & roles & responsibility Form</a></li>
                            <li><a href="job-description-list.php"><i class="fa fa-sliders"></i> Org structure & roles & responsibility Lists</a></li>
                            <li><a href="add_job_description_pdf.php"><i class="fa fa-sliders"></i> Upload Org structure & roles & responsibility PDF</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(VI) Employees skill test report</a></li>
                        <ul>
                            <li><a href="skill_report.php"><i class="fa fa-sliders"></i> Employees skill test report Lists</a></li>
                            <li><a href="add_skill_report_pdf.php"><i class="fa fa-sliders"></i> Upload Employees skill test report PDF</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(VIII) CAPA Reports</a></li>
                        <ul>
                            <li><a href="capa.php"><i class="fa fa-sliders"></i> CAPA Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(X) JHA</a></li>
                        <ul>
                            <li><a href="add-jha-type.php"><i class="fa fa-sliders"></i> Add JHA Types</a></li>
                            <li><a href="add-jha-basic-job-seq.php"><i class="fa fa-reorder"></i> Sequence of Basic Job Steps</a></li>
                            <li><a href="add-jha-potential-hazard.php"><i class="fa fa-sliders"></i> Potential Hazards</a></li>
                            <li><a href="add-jha-safegaurd.php"><i class="fa fa-reorder"></i> Safeguard / Controls</a></li>
                            <li><a href="add-jha-requirments.php"><i class="fa fa-reorder"></i> JHA Requirments</a></li>
                            <li><a href="jha-types.php"><i class="fa fa-sliders"></i> JHA Types List</a></li>
                            <li><a href="add-jha-pdfs.php"><i class="fa fa-sliders"></i> Upload JHA PDFs</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.1(XI) SOP</a></li>
                        <ul>
                            <li><a href="add-sop-type.php"><i class="fa fa-sliders"></i> Add SOP Types</a></li>
                            <li><a href="add-sop-activity.php"><i class="fa fa-reorder"></i> SOP Activities</a></li>
                            <li><a href="add-sop-process.php"><i class="fa fa-sliders"></i> SOP Process</a></li>
                            <li><a href="sop-types.php"><i class="fa fa-sliders"></i> SOP Types Lists</a></li>
                            <li><a href="add-sop-pdfs.php"><i class="fa fa-sliders"></i> Upload SOP PDFs</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.2(I) Employees Selection Procedure</a></li>
                        <ul>
                            <!--<li><a href="add-emp-select-category.php"><i class="fa fa-sliders"></i> Employees Selection Category</a></li>-->
                            <li><a href="add-emp-selection.php"><i class="fa fa-reorder"></i> Employees Selection Form</a></li>
                            <li><a href="emp-selection.php"><i class="fa fa-sliders"></i> Employees Selection Lists</a></li>
                            <li><a href="add_emp_selection_pdf.php"><i class="fa fa-sliders"></i> Upload Employees Selection PDF</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.2(III) Employees Selection Procedure Documents</a></li>
                        <ul>
                            <!--<li><a href="add-emp-select-category.php"><i class="fa fa-sliders"></i> Employees Selection Category</a></li>-->
                            <li><a href="add-emp-selection-docs.php"><i class="fa fa-reorder"></i> Employees Selection Procedure Docs Form</a></li>
                            <li><a href="emp-selection-docs.php"><i class="fa fa-sliders"></i> Employees Selection Procedure Docs Lists</a></li>
                            <li><a href="add_emp_selection_docs_pdf.php"><i class="fa fa-reorder"></i> Upload Employees Selection Docs Procedure PDF</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.2(V) Monthly ABP update</a></li>
                        <ul>
                            <!--<li><a href="add-emp-select-category.php"><i class="fa fa-sliders"></i> Employees Selection Category</a></li>-->
                            <li><a href="add-abp.php"><i class="fa fa-reorder"></i> Monthly ABP update Form</a></li>
                            <li><a href="abp.php"><i class="fa fa-sliders"></i> ABP Lists</a></li>
                            <li><a href="monthly_abp.php"><i class="fa fa-sliders"></i> Monthly ABP update Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.3(IV) OFI against close report (Last audit Report)</a></li>
                        <ul>
                            <li><a href="ofi_report.php"><i class="fa fa-sliders"></i> OFI against close report Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.4(I) Training Calendar</a></li>
                        <ul>
                            <li><a href="training_calendar.php"><i class="fa fa-sliders"></i> Training Calendar Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.4(III) Training Attandance Sheet</a></li>
                        <ul>
                            <li><a href="training_attandance_sheet.php"><i class="fa fa-sliders"></i> Training Attandance Sheet Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.4(IV) Performance Report</a></li>
                        <ul>
                            <li><a href="performance_report.php"><i class="fa fa-sliders"></i> Performance Report Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.4(V) Feedback</a></li>
                        <ul>
                            <li><a href="add-feedback-statement.php"><i class="fa fa-sliders"></i> Add Feedback Statement</a></li>
                            <li><a href="feedback-statement.php"><i class="fa fa-sliders"></i> Feedback Statement Lists</a></li>
                            <li><a href="feedback.php"><i class="fa fa-sliders"></i> Feedback Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.5(I) Mass Meeting</a></li>
                        <ul>
                            <li><a href="mass_meeting_attendance.php"><i class="fa fa-sliders"></i> Mass Meeting Attendance List</a></li>
                            <li><a href="mass_meeting.php"><i class="fa fa-sliders"></i> Mass Meeting Points Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.5(II) Tool Box Meeting</a></li>
                        <ul>
                            <li><a href="tool_box_meeting.php"><i class="fa fa-sliders"></i> Tool Box Meeting Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 1.5(IV) Safty Line Walk Report</a></li>
                        <ul>
                            <li><a href="line_walk.php"><i class="fa fa-sliders"></i> Safty Line Walk Report Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.1(a & b)(III) Work permit details</a></li>
                        <ul>
                            <li><a href="work_permit.php"><i class="fa fa-sliders"></i> Work permit details Lists</a></li>
                            <li><a href="hot_job.php"><i class="fa fa-sliders"></i> Work permit Hot Job Lists</a></li>
                            <li><a href="working_at_height.php"><i class="fa fa-sliders"></i> Working At Height Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.1(a & b)(IV) Supervisor Audit</a></li>
                        <ul>
                            <li><a href="supervisor_audit.php"><i class="fa fa-sliders"></i> Supervisor Audit Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.3(II) Hazards Mapping</a></li>
                        <ul>
                            <li><a href="add_hazard_mapping.php"><i class="fa fa-sliders"></i> Add Hazards Mapping</a></li>
                            <li><a href="hazard_mapping.php"><i class="fa fa-sliders"></i> Hazards Mapping Lists</a></li>
                            <li><a href="hazard.php"><i class="fa fa-sliders"></i> Hazards Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.3(III) Checklist report</a></li>
                        <ul>
                            <li><a href="checklist_report.php"><i class="fa fa-sliders"></i> Checklist report Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.3(IV) PPES data</a></li>
                        <ul>
                            <li><a href="ppe_data.php"><i class="fa fa-sliders"></i> PPES data Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.4(I) Master list</a></li>
                        <ul>
                            <li><a href="master_list.php"><i class="fa fa-sliders"></i> Master list's Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.4(III) Tools checklist report</a></li>
                        <ul>
                            <li><a href="tools_checklist.php"><i class="fa fa-sliders"></i> Tools checklist report Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.5(I) Houskeeping Process</a></li>
                        <ul>
                            <li><a href="houskeeping_process.php"><i class="fa fa-sliders"></i> Houskeeping Process Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.5(II) Houskeeping checklist & s 5 audit</a></li>
                        <ul>
                            <li><a href="houskeeping_checklist.php"><i class="fa fa-sliders"></i> Houskeeping checklist & s 5 audit Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 2.6(III) Safty Videos</a></li>
                        <ul>
                            <li><a href="add_safty_videos.php"><i class="fa fa-sliders"></i> Safty Videos Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 4.1(III) strip training records</a></li>
                        <ul>
                            <li><a href="strip_training_attand_sheet.php"><i class="fa fa-sliders"></i> strip training records Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 4.2(II) Near miss records /Total no of near miss</a></li>
                        <ul>
                            <li><a href="near_miss_records.php"><i class="fa fa-sliders"></i> Near miss records /Total no of near miss Lists</a></li>
                        </ul>
                        <li><a href=""><i class="fa fa-sliders"></i> 4.3(II) Grivance record system</a></li>
                        <ul>
                            <li><a href="grivance_records.php"><i class="fa fa-sliders"></i> Grivance record system Lists</a></li>
                        </ul>
                    </ul>
                    <!--<ul class="treeview-menu">
                        <li><a href="categories.php"><i class="fa fa-sliders"></i> Manage Categories</a></li>
                        <li><a href="categories-order.php"><i class="fa fa-reorder"></i> Categories Order</a></li>
                    </ul>-->
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Production</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <!--<ul class="treeview-menu">
                        <li><a href="categories.php"><i class="fa fa-sliders"></i> Manage Categories</a></li>
                        <li><a href="categories-order.php"><i class="fa fa-reorder"></i> Categories Order</a></li>
                    </ul>-->
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Quality</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <!--<ul class="treeview-menu">
                        <li><a href="categories.php"><i class="fa fa-sliders"></i> Manage Categories</a></li>
                        <li><a href="categories-order.php"><i class="fa fa-reorder"></i> Categories Order</a></li>
                    </ul>-->
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bullseye"></i>
                        <span>Reports</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="report-sale.php"><i class="fa fa-sliders"></i> Sale</a></li>
                        <li><a href="cash-flow.php"><i class="fa fa-sliders"></i> Cash Flow</a></li>
                        <li><a href="gst1.php"><i class="fa fa-sliders"></i> GSTR 1</a></li>
                        <li><a href="gst2.php"><i class="fa fa-sliders"></i> GSTR 2</a></li>
                        <li><a href="gst3b.php"><i class="fa fa-sliders"></i> GSTR 3B</a></li>
                    </ul>
                </li>
                <?php
                if ($role == 'admin' || $role == 'super admin') {
                ?>
                    <li class="treeview">
                        <a href="system-users.php">
                            <i class="fa fa-users" class="active"></i> <span>System Users</span>
                        </a>
                    </li>
                <?php }
                $query = "SELECT version FROM updates ORDER BY id DESC LIMIT 1";
                $db->sql($query);
                $result = $db->getResult();
                if (!empty($result)) {
                ?>
                    <center><a href="home.php" class="label label-success"><?= $result[0]['version'] ?></a></center>
                <?php } ?>
            </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
</body>

</html>