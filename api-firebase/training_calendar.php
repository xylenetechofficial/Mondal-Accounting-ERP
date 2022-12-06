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

if ((isset($_POST['type'])) && ($_POST['type'] == 'training_calendar')) {
    /*
    if (!verify_token()) {
        return false;
    }*/
    $datetime = date("Y-m-d H:i:s");
    //$date = date("Y-m-d");
    //$abp_id = (isset($_POST['abp_id'])) ? $db->escapeString($fn->xss_clean($_POST['abp_id'])) : "";
    $topic = (isset($_POST['topic'])) ? $db->escapeString($fn->xss_clean($_POST['topic'])) : "";
    $plan_date = (isset($_POST['plan_date'])) ? $db->escapeString($fn->xss_clean($_POST['plan_date'])) : "";
    $actual_date = (isset($_POST['actual_date'])) ? $db->escapeString($fn->xss_clean($_POST['actual_date'])) : "";
    $month = (isset($_POST['month'])) ? $db->escapeString($fn->xss_clean($_POST['month'])) : "";
    $year = (isset($_POST['year'])) ? $db->escapeString($fn->xss_clean($_POST['year'])) : "";
    $date = (isset($_POST['date'])) ? $db->escapeString($fn->xss_clean($_POST['date'])) : "";
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
                'topic' => $topic,
                'jan_plan_date' => $plan_date,
                'jan_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Feb') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'feb_plan_date' => $plan_date,
                'feb_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Mar') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'mar_plan_date' => $plan_date,
                'mar_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Apr') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'apr_plan_date' => $plan_date,
                'apr_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'May') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'may_plan_date' => $plan_date,
                'may_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Jun') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'jun_plan_date' => $plan_date,
                'jun_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Jul') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'jul_plan_date' => $plan_date,
                'jul_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Aug') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'aug_plan_date' => $plan_date,
                'aug_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Sep') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'sep_plan_date' => $plan_date,
                'sep_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Oct') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'oct_plan_date' => $plan_date,
                'oct_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Nov') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'nov_plan_date' => $plan_date,
                'nov_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    elseif ($month == 'Dec') {
        $data = array(); {
            $data = array(
                //'abp_id' => $abp_id,
                'topic' => $topic,
                'dec_plan_date' => $plan_date,
                'dec_actual_date' => $actual_date,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'location_id' => $location_id,
                'location' => $location,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
        }

        $db->insert('training_calendar', $data);
        $res = $db->getResult();
    }
    $response["error"]   = false;
    $response["message"] = "Monthly Training Calender Data Submitted Successfully";
    //$response["id"] = $res2[0]['id'];
    echo json_encode($response);
} else {
    $response['error'] = "true";
    $response['message'] = "Monthly Training Calender Data Not Submitted";
    echo json_encode($response);
}
