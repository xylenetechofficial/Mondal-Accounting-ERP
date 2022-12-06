<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');
$db = new Database();
$db->connect();
include_once('../includes/variables.php');
include_once('verify-token.php');
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

$config = $fn->get_configurations();
$time_slot_config = $fn->time_slot_config();
$time_zone = $fn->set_timezone($config);
if (!$time_zone) {
    $response['error'] = true;
    $response['message'] = "Time Zone is not set.";
    print_r(json_encode($response));
    return false;
    exit();
}

/* 
1.get-categories.php
    accesskey:90336 
    limit:10    // {optional}
    offset:0    // {optional}
*/
/*
if (!verify_token()) {
    return false;
}
*/
$m = $db->escapeString($fn->xss_clean($_POST['month']));
$y = $db->escapeString($fn->xss_clean($_POST['year']));
$emp_id = $db->escapeString($fn->xss_clean($_POST['emp_id']));

$date = strtotime("$m $y");

$start_date = date('Y-m-01', $date);
$end_date  = date('Y-m-t', $date);
if (isset($_POST['accesskey'])) {
    $access_key_received = $db->escapeString($fn->xss_clean($_POST['accesskey']));
    if ($access_key_received == $access_key) {
        $sql = "SELECT salary.*, emp_attendance.emp_no, SUM(emp_attendance.tot_hours) AS tot_atten_hrs, emp_attendance.emp_id AS eid, SUM(emp_attendance.hours) AS tot_hrs, SUM(emp_attendance.ot_hours) AS tot_ot_hrs FROM `salary` INNER JOIN `emp_attendance` ON emp_attendance.emp_id = salary.emp_id WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "')  AND salary.emp_id ='$emp_id' LIMIT 1";
        $db->sql($sql);
        $res = $db->getResult();
        foreach ($res as $data)
            $row = $data;

        if (!empty($res)) {
            $tot_basic_sal = $row['basic_salary'] / 9 * $row['tot_hrs'];
            $tot_spl_allowance = $row['spl_allowance'] / 9 * $row['tot_hrs'];
            $tot_ot_sal = ($row['basic_salary'] / 9) * 2 * $row['tot_ot_hrs'];
            $total_pf_wages = $row['pf_wages'] / 9 * $row['tot_hrs'];
            $total_hra = $row['hra'] / 9 * $row['tot_hrs'];
            $total_gross_salary = $row['gross_salary'] / 9 * $row['tot_hrs'];
            $total_pf = $row['pf'] / 9 * $row['tot_hrs'];
            $total_esic = $row['esic'] / 9 * $row['tot_hrs'];
            $final_total_deduction = $row['total_deduction'] / 9 * $row['tot_hrs'];
            $total_net_salary = $row['net_salary'] / 9 * $row['tot_hrs'];
            $tot_sal = $tot_ot_sal + $total_net_salary;

            $tempRow['eid'] = $row['eid'];
            $tempRow['emp_no'] = $row['emp_no'];
            $tempRow['emp_post'] = $row['emp_post'];
            $tempRow['tot_hrs'] = $row['tot_hrs'];
            $tempRow['tot_atten_hrs'] = $row['tot_atten_hrs'];
            $tempRow['tot_ot_hrs'] = $row['tot_ot_hrs'];
            $tempRow['basic_salary'] = number_format((float)$tot_basic_sal, 2, '.', '');
            $tempRow['tot_spl_allowance'] = number_format((float)$tot_spl_allowance, 2, '.', '');
            $tempRow['tot_ot_sal'] = number_format((float)$tot_ot_sal, 2, '.', '');
            $tempRow['total_pf_wages'] = number_format((float)$total_pf_wages, 2, '.', '');
            $tempRow['total_hra'] = number_format((float)$total_hra, 2, '.', '');
            $tempRow['total_gross_salary'] = number_format((float)$total_gross_salary, 2, '.', '');
            $tempRow['total_pf'] = number_format((float)$total_pf, 2, '.', '');
            $tempRow['total_esic'] = number_format((float)$total_esic, 2, '.', '');
            $tempRow['final_total_deduction'] = number_format((float)$final_total_deduction, 2, '.', '');
            $tempRow['total_net_salary'] = number_format((float)$total_net_salary, 2, '.', '');
            $tempRow['tot_sal'] = number_format((float)$tot_sal, 2, '.', '');
            //$res = $tmp;
            $response['error'] = false;
            $response['message'] = "Employees Salary Slip Retrived Successfully!";
            $response['data'] = $tempRow;
        } else {
            $response['error'] = true;
            $response['message'] = "No data found!";
        }
        print_r(json_encode($response));
    } else {
        $response['error'] = true;
        $response['message'] = "accesskey is incorrect.";
        print_r(json_encode($response));
    }
} else {
    $response['error'] = true;
    $response['message'] = "accesskey is require.";
    print_r(json_encode($response));
}
$db->disconnect();
