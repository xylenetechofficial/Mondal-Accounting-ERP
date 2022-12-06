<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include_once('../includes/variables.php');
include_once('../includes/crud.php');
include '../includes/custom-functions.php';
$fn = new custom_functions;
$fn = new custom_functions();
//include_once('verify-token.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$response = array();

if ((isset($_POST['type'])) && ($_POST['type'] == 'grivance_records')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    //$abp_id = (isset($_POST['abp_id'])) ? $db->escapeString($fn->xss_clean($_POST['abp_id'])) : "";
    //$topic = (isset($_POST['topic'])) ? $db->escapeString($fn->xss_clean($_POST['topic'])) : "";
    $grivance_open = (isset($_POST['grivance_open'])) ? $db->escapeString($fn->xss_clean($_POST['grivance_open'])) : "";
    $grivance_close = (isset($_POST['grivance_close'])) ? $db->escapeString($fn->xss_clean($_POST['grivance_close'])) : "";
    $month = (isset($_POST['month'])) ? $db->escapeString($fn->xss_clean($_POST['month'])) : "";
    $year = (isset($_POST['year'])) ? $db->escapeString($fn->xss_clean($_POST['year'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
    $prepared_by_name = (isset($_POST['prepared_by_name'])) ? $db->escapeString($fn->xss_clean($_POST['prepared_by_name'])) : "";
    $prepared_by_sign = (isset($_POST['prepared_by_sign'])) ? $db->escapeString($fn->xss_clean($_POST['prepared_by_sign'])) : "";
    $checked_by_name = (isset($_POST['checked_by_name'])) ? $db->escapeString($fn->xss_clean($_POST['checked_by_name'])) : "";
    $checked_by_sign = (isset($_POST['checked_by_sign'])) ? $db->escapeString($fn->xss_clean($_POST['checked_by_sign'])) : "";
    $location_id = (isset($_POST['location_id'])) ? $db->escapeString($fn->xss_clean($_POST['location_id'])) : "";
    $sql = "SELECT location_name FROM `location` WHERE id = '$location_id' ORDER BY id DESC limit 1";
    $db->sql($sql);
    $res1 = $db->getResult();
    foreach ($res1 as $row1)
        $location1 = $row1;
    $location = implode(',', $location1);
    //$created_at = (isset($_POST['created_at'])) ? $db->escapeString($fn->xss_clean($_POST['created_at'])) : "";
    //$updated_at = (isset($_POST['updated_at'])) ? $db->escapeString($fn->xss_clean($_POST['updated_at'])) : "";
    if ($month == 'Jan') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'jan_grivance_open' => $grivance_open,
                'jan_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Feb') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'feb_grivance_open' => $grivance_open,
                'feb_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Mar') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'mar_grivance_open' => $grivance_open,
                'mar_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Apr') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'apr_grivance_open' => $grivance_open,
                'apr_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'May') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'may_grivance_open' => $grivance_open,
                'may_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Jun') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'jun_grivance_open' => $grivance_open,
                'jun_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Jul') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'jul_grivance_open' => $grivance_open,
                'jul_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Aug') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'aug_grivance_open' => $grivance_open,
                'aug_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Sep') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'sep_grivance_open' => $grivance_open,
                'sep_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Oct') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'oct_grivance_open' => $grivance_open,
                'oct_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Nov') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'nov_grivance_open' => $grivance_open,
                'nov_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Dec') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                //'topic' => $topic,
                'dec_grivance_open' => $grivance_open,
                'dec_grivance_close' => $grivance_close,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'prepared_by_name' => $prepared_by_name,
                'prepared_by_sign' => $prepared_by_sign,
                'checked_by_name' => $checked_by_name,
                'checked_by_sign' => $checked_by_sign,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('grivance_records', $data);
        $res = $db->getResult();
    }
    $response["error"]   = false;
    $response["message"] = "Grivance Records Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Grivance Records Not Submitted";
    echo json_encode($response);
}
