<?php
session_start();
include '../includes/crud.php';
include_once('../includes/variables.php');
include_once('../includes/custom-functions.php');

header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Access-Control-Allow-Origin: *');

$fn = new custom_functions;
include_once('verify-token.php');
$db = new Database();
$db->connect();
$response = array();

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

if (!isset($_POST['accesskey'])) {
    $response['error'] = true;
    $response['message'] = "Access key is invalid or not passed!";
    print_r(json_encode($response));
    return false;
}
$accesskey = $db->escapeString($fn->xss_clean($_POST['accesskey']));
if ($access_key != $accesskey) {
    $response['error'] = true;
    $response['message'] = "invalid accesskey!";
    print_r(json_encode($response));
    return false;
}
/*  
1.get-variants-offline.php
    accesskey:90336
    get_variants_offline:1
    variant_ids:55,56 
*/

if (!verify_token()) {
    return false;
}
if ((isset($_POST['get_variants_offline']) && $_POST['get_variants_offline'] == 1) && (isset($_POST['variant_ids'])) && !empty(trim($_POST['variant_ids']))) {
    $variant_ids = $db->escapeString($fn->xss_clean($_POST['variant_ids']));
    $sql = "SELECT pv.*,pv.id as product_variant_id,p.slug,p.tax_id FROM product_variant pv JOIN products p ON p.id=pv.product_id where pv.id IN ($variant_ids)";
    $db->sql($sql);
    $res = $db->getResult();
    $total_records = $db->numRows($res);

    $i = 0;
    $j = 0;
    $total_amount = "0";
    if ($total_records > 0) {
        foreach ($res as $row) {
            $sql = "select pv.*,pv.id as product_variant_id,p.shipping_delivery,p.name,p.image,p.slug,p.other_images,p.size_chart,pv.measurement,(select short_code from unit u where u.id=pv.stock_unit_id) as stock_unit_name,(select short_code from unit u where u.id=pv.measurement_unit_id) as unit from product_variant pv left join products p on p.id=pv.product_id where pv.id=" . $row['id'];
            $db->sql($sql);

            $res[$i]['item'] = $db->getResult();
            if ($row['tax_id'] == 0) {
                $res[$i]['tax_title'] = "";
                $res[$i]['tax_percentage'] = "0";
            } else {
                $t_id = $row['tax_id'];
                $sql_tax = "SELECT * from taxes where id= $t_id";
                $db->sql($sql_tax);
                $res_tax = $db->getResult();
                foreach ($res_tax as $tax) {
                    $res[$i]['tax_title'] = $tax['title'];
                    $res[$i]['tax_percentage'] = $tax['percentage'];
                }
            }

            $sql = "SELECT fp.*,fs.title as flash_sales_name FROM flash_sales_products fp LEFT JOIN flash_sales fs ON fs.id=fp.flash_sales_id where fp.product_variant_id= " . $res[$i]['id'] . " AND  fp.product_id = " . $res[$i]['product_id'];
            $db->sql($sql);
            $result = $db->getResult();
            if (!empty($result)) {
                $res[$i]['is_flash_sales'] = "true";
            } else {
                $res[$i]['is_flash_sales'] = "false";
            }
            $res[$i]['flash_sales'] = array();
            $flash_sale_data = array('id' => "", 'flash_sales_id' => "", 'product_id' => "", 'product_variant_id' => "", 'price' => "", 'discounted_price' => "", 'start_date' => "", 'end_date' => "", 'date_created' => "", 'status' => "", 'flash_sales_name' => "");
            $res[$i]['flash_sales'] = array($flash_sale_data);
            foreach ($result as $sale_row) {
                if ($res[$i]['is_flash_sales'] = "true") {
                    $res[$i]['flash_sales'] = array($sale_row);
                }
            }

            for ($k = 0; $k < count($res[$i]['item']); $k++) {
                $res[$i]['item'][$k]['cart_count'] = "0";
                $res[$i]['item'][$k]['other_images'] = json_decode($res[$i]['item'][$k]['other_images']);
                $res[$i]['item'][$k]['other_images'] = empty($res[$i]['item'][$k]['other_images']) ? array() : $res[$i]['item'][$k]['other_images'];
                $res[$i]['item'][$k]['shipping_delivery'] = empty($res[$i]['item'][$k]['shipping_delivery']) ? "" : $res[$i]['item'][$k]['shipping_delivery'];
                $res[$i]['item'][$k]['size_chart'] = (empty($res[$i]['item'][$k]['size_chart'])) ? '' : DOMAIN_URL . $res[$i]['item'][$k]['size_chart'];

                for ($l = 0; $l < count($res[$i]['item'][$k]['other_images']); $l++) {
                    $other_images = DOMAIN_URL . $res[$i]['item'][$k]['other_images'][$l];
                    $res[$i]['item'][$k]['other_images'][$l] = $other_images;
                }
            }

            for ($j = 0; $j < count($res[$i]['item']); $j++) {
                $res[$i]['item'][$j]['image'] = !empty($res[$i]['item'][$j]['image']) ? DOMAIN_URL . $res[$i]['item'][$j]['image'] : "";
            }
            $i++;
        }

        if (!empty($res)) {
            $response['error'] = false;
            $response['message'] = "Products retrived successfully!";
            $response['total'] = stripcslashes($total_records);
            $response['total_amount'] = $total_amount;
            $response['data'] = array_values($res);
        } else {
            $response['error'] = true;
            $response['message'] = "No item(s) found!";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "No item(s) found!";
    }

    print_r(json_encode($response));
    return false;
}
