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
1. get-areas-by-city-id.php
    accesskey:90336
    city_id:24 
    search:Mirzapar    // {optional}
    limit:10            // {optional}
    offset:0            // {optional}
*/

if (!verify_token()) {
    return false;
}
if (isset($_POST['accesskey']) && isset($_POST['city_id'])) {
    $access_key_received = $db->escapeString($fn->xss_clean($_POST['accesskey']));
    $city_ID = $db->escapeString($fn->xss_clean($_POST['city_id']));
    $limit = (isset($_POST['limit']) && !empty($_POST['limit']) && is_numeric($_POST['limit'])) ? $db->escapeString($fn->xss_clean($_POST['limit'])) : 10;
    $offset = (isset($_POST['offset']) && !empty($_POST['offset']) && is_numeric($_POST['offset'])) ? $db->escapeString($fn->xss_clean($_POST['offset'])) : 0;
    if (isset($_POST['search'])) {
        $keyword = $db->escapeString($fn->xss_clean($_POST['search']));
    } else {
        $keyword = "";
    }
    if ($access_key_received == $access_key) {
        if ($keyword == "") {
            $sql_query1 = "SELECT count(id) as total FROM area WHERE city_id = " . $city_ID . " ORDER BY id ASC";
        } else {
            $sql_query1 = "SELECT count(id) as total FROM area WHERE name LIKE '%" . $keyword . "%' AND city_id = " . $city_ID . " ORDER BY id ASC";
        }
        $db->sql($sql_query1);
        $res1 = $db->getResult();

        if ($keyword == "") {
            $sql_query = "SELECT id, name, minimum_order_amount FROM area WHERE city_id = " . $city_ID . " ORDER BY id ASC ";
        } else {
            $sql_query = "SELECT id, name,minimum_order_amount FROM area WHERE name LIKE '%" . $keyword . "%' AND city_id = " . $city_ID . " ORDER BY id ASC ";
        }
        $db->sql($sql_query);
        $res = $db->getResult();
        if (!empty($res)) {
            $response['error'] = false;
            $response['message'] = "Cities Retrived Successfully!";
            $response['total'] = $res1[0]['total'];
            $response['data'] = $res;
        } else {
            $response['error'] = true;
            $response['message'] = "no data found!";
        }
        $output = json_encode($response);
    } else {
        $response['error'] = true;
        $response['message'] = "accesskey is incorrect.";
        print_r(json_encode($response));
    }
} else {
    $response['error'] = true;
    $response['message'] = "accesskey and city id are required.";
    print_r(json_encode($response));
}
echo $output;
$db->disconnect();
