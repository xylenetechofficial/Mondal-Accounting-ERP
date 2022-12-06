<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
session_start();
include '../includes/crud.php';
include '../includes/custom-functions.php';
$fn = new custom_functions;
include '../includes/variables.php';
include_once('verify-token.php');
$db = new Database();
$db->connect();
$fn = new custom_functions();
$settings = $fn->get_settings('system_timezone', true);
$app_name = $settings['app_name'];
include 'send-email.php';

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

if (isset($_POST['place_order']) && isset($_POST['user_id']) && !empty($_POST['product_variant_id'])) {
    /*
    1.place_order
        accesskey:90336
        place_order:1
        user_id:32
        mobile:0123456789
        product_variant_id:["551","550"]
        quantity:["3","1"]
        delivery_charge:50
        total:500
        final_total:550
        address:bhuj
        latitude:44.456321
        longitude:12.456987
        payment_method:Paypal / Payumoney / COD / PAYTM / razorpay / bank transfer
        discount:10         // {optional}
        tax_percentage:20   // {optional}
        tax_amount:30       // {optional}
        area_id:1           // {optional}
        order_note:home     // {optional}
        wallet_balance:450  // {optional}
        promo_code:NEW20    // {optional}
        promo_discount:40   // {optional}
        order_from:test     // {optional}
        local_pickup:0/1    // {optional}
        wallet_used:true/false  // {optional}
        status:awaiting_payment     // {optional}
        delivery_time:Today - Evening (4:00pm to 7:00pm)    // {optional}
    */

    if (!verify_token()) {
        return false;
    }

    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $mobile = (isset($_POST['mobile'])) ? $db->escapeString($fn->xss_clean($_POST['mobile'])) : "";
    $dob = (isset($_POST['dob'])) ? $db->escapeString($fn->xss_clean($_POST['dob'])) : "";
    $email = (isset($_POST['email'])) ? $db->escapeString($fn->xss_clean($_POST['email'])) : "";
    $address = (isset($_POST['address'])) ? $db->escapeString($fn->xss_clean($_POST['address'])) : "";
    $state = (isset($_POST['state'])) ? $db->escapeString($fn->xss_clean($_POST['state'])) : "";
    $district = (isset($_POST['district'])) ? $db->escapeString($fn->xss_clean($_POST['district'])) : "";
    $city = (isset($_POST['city'])) ? $db->escapeString($fn->xss_clean($_POST['city'])) : "";
    $pincode = (isset($_POST['pincode'])) ? $db->escapeString($fn->xss_clean($_POST['pincode'])) : "";
    $height = (isset($_POST['height'])) ? $db->escapeString($fn->xss_clean($_POST['height'])) : "";
    $weight = (isset($_POST['weight'])) ? $db->escapeString($fn->xss_clean($_POST['weight'])) : "";
    $gender = (isset($_POST['gender'])) ? $db->escapeString($fn->xss_clean($_POST['gender'])) : "";
    $age = (isset($_POST['age'])) ? $db->escapeString($fn->xss_clean($_POST['age'])) : "";
    $bloodgrp = (isset($_POST['bloodgrp'])) ? $db->escapeString($fn->xss_clean($_POST['bloodgrp'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
    $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";

    $status[] = array($active_status, date("d-m-Y h:i:sa"));
    $item_details = $function->get_product_by_variant_id($items);
    $total_amount = $total + $delivery_charge + $tax_amount - $discount;
    $quantity = $function->xss_clean($_POST['quantity']);
    $quantity_arr = json_decode($quantity, 1);

    $walletvalue = ($wallet_used) ? $wallet_balance : 0;
    $order_status = $db->escapeString(json_encode($status));

    $sql = "INSERT INTO `emp_form`(`user_id`,`otp`, `mobile`,`order_note`, `total`, `delivery_charge`, `tax_amount`, `tax_percentage`, `wallet_balance`, `discount`, `promo_code`, `promo_discount`, `final_total`, `payment_method`, `address`, `latitude`, `longitude`, `delivery_time`, `status`, `active_status`,`order_from`,`local_pickup`, `date_added`) VALUES ('$user_id','$otp_number','$mobile','$order_note','$total','$delivery_charge','$tax_amount','$tax_percentage','$walletvalue','$discount','$promo_code','$promo_discount','$final_total','$payment_method','$address','$latitude','$longitude','$delivery_time','$order_status','$active_status','$order_from','$local_pickup','" . date("Y-m-d H:i:s") . "')";
    $db->sql($sql);
    $sql = "SELECT id FROM emp_form where user_id=$user_id order by id desc limit 1";
    $db->sql($sql);
    $res_order_id = $db->getResult();
    $order_id = $res_order_id[0]['id'];

    for ($i = 0; $i < count($item_details); $i++) {

        $product_id = $item_details[$i]['product_id'];
        $measurement = $item_details[$i]['measurement'];
        $product_variant_id = $item_details[$i]['id'];
        $measurement_unit_id = $item_details[$i]['measurement_unit_id'];
        $stock_unit_id = $item_details[$i]['stock_unit_id'];

        $sql_result = "SELECT * FROM flash_sales_products WHERE status = 1 AND product_id = " . $product_id . " AND product_variant_id = " . $product_variant_id . " ";
        $db->sql($sql_result);
        $res1 = $db->getResult();

        $price = empty($res1) ? $item_details[$i]['price'] : $res1[0]['price'];
        $discounted_price = empty($res1) ? $item_details[$i]['discounted_price'] : $res1[0]['discounted_price'];

        $type = $item_details[$i]['type'];
        $total_stock = $item_details[$i]['stock'];
        $quantity = $quantity_arr[$i];
        $tax_title = $item_details[$i]['tax_title'];
        $tax_percentage = $item_details[$i]['tax_percentage'];
        $tax_amt = $discounted_price != 0 ? (($tax_percentage / 100) * $discounted_price)  : (($tax_percentage / 100) * $price);
        $sub_total = $discounted_price != 0 ? ($discounted_price + ($tax_percentage / 100) * $discounted_price) * $quantity : ($price + ($tax_percentage / 100) * $price) * $quantity;

        $res_product = $function->get_data($columns = ['name'], 'id=' . $product_id, 'products');
        $res_variant = $function->get_data($columns = ['measurement', 'measurement_unit_id'], 'id=' . $product_variant_id, 'product_variant');
        $res_unit = $function->get_data($columns = ['short_code'], 'id=' . $res_variant[0]['measurement_unit_id'], 'unit');

        $product_name = $db->escapeString($function->xss_clean($res_product[0]['name']));
        $variant_name = $res_variant[0]['measurement'] . " " . $res_unit[0]['short_code'];
        // $data = array(
        //     'user_id' => $user_id,
        //     'order_id' => $db->escapeString($order_id),
        //     'product_variant_id' => $db->escapeString($product_variant_id),
        //     'quantity' => $db->escapeString($quantity),
        //     'price' => $db->escapeString($price),
        //     'discounted_price' => $db->escapeString($discounted_price),
        //     'tax_amount' => $db->escapeString($tax_amt),
        //     'tax_percentage' => (empty($tax_percentage) || $tax_percentage == "") ? 0 : $db->escapeString($tax_percentage),
        //     'discount' => $discount,
        //     'sub_total' => $db->escapeString($sub_total),
        //     'status' => $db->escapeString(json_encode($status)),
        //     'active_status' => $active_status

        // );
        $neworder_id         = $db->escapeString($order_id);
        $product_variant_id = $db->escapeString($product_variant_id);
        $quantity             = $db->escapeString($quantity);
        $order_price        = $db->escapeString($price);
        $discounteds_price    = $db->escapeString($discounted_price);
        $tax_amount = $db->escapeString($tax_amt);
        $tax_percentage = (empty($tax_percentage) || $tax_percentage == "") ? 0 : $db->escapeString($tax_percentage);
        $order_sub_total    = $db->escapeString($sub_total);
        $order_item_status  = $db->escapeString(json_encode($status));

        $sql = "INSERT INTO `order_items`(`user_id`, `order_id`, `product_variant_id`, `quantity`, `price`, `discounted_price`,`tax_amount`,`tax_percentage`, `discount`, `sub_total`, `status`, `active_status`,`product_name`,`variant_name`,`product_id`) VALUES ('$user_id','$neworder_id','$product_variant_id','$quantity','$order_price','$discounteds_price','$tax_amount', $tax_percentage ,'$discount','$order_sub_total','$order_item_status','$active_status','$product_name','$variant_name','$product_id')";
        $db->sql($sql);
        $res = $db->getResult();
        $balance = $final_total / 10;
        if ($type == 'packet') {
            $stock = $total_stock - $quantity;
            $sql = "update product_variant set stock = $stock where id = $product_variant_id";
            $db->sql($sql);
            $res = $db->getResult();
            $db->select("product_variant", "stock", null, "id='" . $product_variant_id . "'");
            $variant_qty = $db->getResult();
            if ($variant_qty[0]['stock'] <= 0) {
                $data = array(
                    "serve_for" => "Sold Out",
                );
                $db->update("product_variant", $data, "id=$product_variant_id");
                $res = $db->getResult();
            }
        } elseif ($type == 'loose') {
            if ($measurement_unit_id == $stock_unit_id) {
                $stock = $quantity * $measurement;
            } else {
                $db->select('unit', '*', null, 'id=' . $measurement_unit_id);
                $unit = $db->getResult();
                $stock = $function->convert_to_parent(($measurement * $quantity), $unit[0]['id']);
            }

            $sql = "update product_variant set stock = stock - $stock where product_id = $product_id AND type='loose'";
            $db->sql($sql);
            $res = $db->getResult();
            $sql = "select stock from product_variant where product_id=" . $product_id;
            $db->sql($sql);
            $res_stck = $db->getResult();
            if ($res_stck[0]['stock'] <= 0) {
                $sql = "update product_variant set serve_for='Sold Out' where product_id=" . $product_id;
                $db->sql($sql);
            }
        }
    }
    $data = array(
        'final_total' => $final_total
    );
    if ($db->update('orders', $data, 'id=' . $order_id)) {
        $res = $db->getResult();
        $response['error'] = false;
        $response['message'] = "Order placed successfully.";
        $response['order_id'] = $order_id;

        /* send email notification for the order received */
        if ($active_status == "received") {
            $sql = "select name, email, mobile, country_code from users where id=" . $user_id;
            $db->sql($sql);
            $res = $db->getResult();
            $to = $res[0]['email'];
            $mobile = $res[0]['mobile'];
            $country_code = $res[0]['country_code'];
            $subject = "Order received successfully";
            $message = "Hello, Dear " . ucwords($res[0]['name']) . ", We have received your order successfully. Your order summaries are as followed:<br><br>";
            $user_msg = "Hello, Dear " . ucwords($res[0]['name']) . ", We have received your order successfully. Your order summaries are as followed:<br><br>";
            $otp_msg = "Here is your OTP. Please, give it to delivery boy only while getting your order.";
            $message .= "<b>Order ID :</b> #" . $response['order_id'] . "<br><br>Ordered Items : <br>";
            $items = $db->escapeString($_POST['product_variant_id']);
            $quantity_arr = json_decode($_POST['quantity'], 1);
            $item_details = $function->get_product_by_variant_id($items);
            $subtotal = $item_data1 = array();
            for ($i = 0; $i < count($item_details); $i++) {
                $product_id = $item_details[$i]['product_id'];
                $measurement = $item_details[$i]['measurement'];
                $product_variant_id = $item_details[$i]['id'];
                $measurement_unit_id = $item_details[$i]['measurement_unit_id'];
                $stock_unit_id = $item_details[$i]['stock_unit_id'];
                $price = $item_details[$i]['price'];
                $discounted_price = $item_details[$i]['discounted_price'];
                $type = $item_details[$i]['type'];
                $total_stock = $item_details[$i]['stock'];
                $quantity = $quantity_arr[$i];
                $price = $item_details[$i]['discounted_price'] == 0 ? $item_details[$i]['price'] : $item_details[$i]['discounted_price'];
                $message .= "<b>Name : </b>" . $item_details[$i]['name'] . "<b> Unit :</b>" . $item_details[$i]['measurement'] . " " . $item_details[$i]['measurement_unit_name'] . "<b> QTY :</b>" . $quantity . "<b> Subtotal :</b>" . $price * $quantity . "<br>";
                $item_data1[] = array('name' => $item_details[$i]['name'], 'tax_amount' => $tax_amt, 'tax_percentage' => $tax_percentage, 'tax_title' => $item_details[$i]['tax_title'], 'unit' =>  $item_details[$i]['measurement'] . " " . $item_details[$i]['measurement_unit_name'], 'qty' => $quantity, 'subtotal' => ($price * $quantity));
            }
            $message .= "<b>OTP : </b>" . $otp_number . "<b>Total Amount : </b>" . $total . " <b>Delivery Charge : </b>" . $delivery_charge . " <b>Tax Amount : </b>" . $tax_amount . " <b>Discount : </b>" . $discount . " <b>Wallet Used : </b>" . $wallet_balance . " <b>Final Total :</b>" . $final_total;
            $message .= "<br>Payment Method : " . $payment_method;

            $order_data = array('total_amount' => $total, 'delivery_charge' => $delivery_charge, 'discount' => $discount, 'wallet_used' => $wallet_balance, 'final_total' => $final_total, 'payment_method' => $payment_method, 'address' => $address, 'user_msg' => $user_msg, 'otp_msg' => $otp_msg, 'otp' => $otp_number);

            $message .= "<br><br>Thank you for placing an order with us!<br><br>You will receive future updates on your order via Email!";
            send_smtp_mail($to, $subject, $item_data1, $order_data);
            $subject = "New order placed for $app_name";
            $message = "New order ID : #" . $response['order_id'] . " received please take note of it and proceed further";
            $function->send_notification_to_admin("New Order Arrived.", $message, "admin_notification", $response['order_id']);
            send_email($support_email, $subject, $message);
            $function->send_order_update_notification($user_id, "Your order has been received", $message, 'order', $response['order_id']);
        }
        print_r(json_encode($response));
    } else {
        $response['error'] = "true";
        $response['message'] = "Could not place order. Try again!";
        $response['order_id'] = 0;
        print_r(json_encode($response));
    }
} elseif (isset($_POST['place_order']) && isset($_POST['user_id']) && empty(json_decode($_POST['product_variant_id']))) {
    $response['error'] = "true";
    $response['message'] = "Order without items in cart can not be placed!";
    $response['order_id'] = 0;
    print_r(json_encode($response));
}
