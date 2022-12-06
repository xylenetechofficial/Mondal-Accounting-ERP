<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="dist/img/logo.png">
    <title>Invoice For Mobile</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }
    </style>

    <style>
        .borderless td,
        .heading th {
            border: none !important;
            padding: 0px !important;
        }

        address {
            margin-bottom: 1px;
            font-style: normal;
            line-height: 1.42857143;
        }

        .row1 {
            margin-right: -15px;
            margin-left: -15px;
            margin-top: 46px;
        }
    </style>
</head>

<body>

    <?php
    include_once('library/jwt.php');
    include_once('includes/functions.php');
    include_once('includes/custom-functions.php');
    include_once('includes/crud.php');
    $function = new custom_functions;
    $settings = $function->get_configurations();
    $currency = $function->get_settings('currency');
    $db = new Database();
    $db->connect();
    $db->sql("SET NAMES 'utf8'");

    function verify_token()
    {
        $jwt = new JWT();
        try {
            $token = $_GET['token'];
        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            print_r(json_encode($response));
            return false;
        }
        if (!empty($token)) {
            try {
                $payload = $jwt->decode($token, JWT_SECRET_KEY, ['HS256']);
                if (!isset($payload->iss) || $payload->iss != 'eKart') { ?>
                    <h2 class="text-center" style="margin-top: 20%;">Invalid Hash</h2>
                <?php return false;
                } else {
                    return true;
                }
            } catch (Exception $e) { ?>
                <h2 class="text-center" style="margin-top: 20%;">Signature verification failed</h2>
            <?php return false;
            }
        } else { ?>
            <h2 class="text-center" style="margin-top: 20%;">Unauthorized access not allowed</h2>
        <?php return false;
        }
    }

    if (!isset($_GET['id']) || empty($_GET['id']) && !isset($_GET['token']) || empty($_GET['token'])) { ?>
        <h2 class="text-center" style="margin-top: 20%;">Please Pass Order Id & Token</h2>
        <?php return false;
    } else {
        $ID = $_GET['id'];
        $sql = "SELECT * FROM orders WHERE id  =" . $ID;
        $db->sql($sql);
        $res = $db->getResult();
    }
    if (!verify_token()) {
        return false;
    }
    if (!empty($res)) {
        if ($res[0]['active_status'] == 'cancelled' || $res[0]['active_status'] == 'returned') { ?>
            <h1 class="text-center" style="margin-top: 20%;">Not Generate Invoice Because Order is <?= $res[0]['active_status'] ?></h1>
        <?php return false;
        } else {
            $sql_outer = "SELECT oi.price as order_item_price,oi.*,u.*,p.*,v.*,o.*,u.name as uname,oi.discounted_price as dis_price,d.name as delivery_boy,o.status as order_status,oi.active_status as order_item_status,p.name as pname,oi.tax_amount*oi.quantity as tax_amount,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name FROM `order_items` oi JOIN users u ON u.id=oi.user_id JOIN product_variant v ON oi.product_variant_id=v.id JOIN products p ON p.id=v.product_id JOIN orders o ON o.id=oi.order_id LEFT JOIN delivery_boys d ON o.delivery_boy_id=d.id WHERE o.id=" . $ID;
            $db->sql($sql_outer);
            $res_outer = $db->getResult();
            $items = [];
            $final_price = 0;
            foreach ($res_outer as $row) {
                if ($row['dis_price'] == 0 || $row['dis_price'] == '') {
                    $final_price = $row['order_item_price'];
                } else {
                    $final_price = $row['dis_price'];
                }
                $data = array($row['product_id'], $row['pname'], $row['quantity'], $row['measurement'], $row['mesurement_unit_name'], $row['discounted_price'] * $row['quantity'], $row['discount'], $row['sub_total'], $row['order_item_status'], $row['tax_id'], $final_price);
                array_push($items, $data);
            }
            $encoded_items = $db->escapeString(json_encode($items));
            $id = $res_outer[0]['id'];
            $sql = "SELECT COUNT(id) as total FROM `invoice` where order_id=" . $id;
            $db->sql($sql);
            $res = $db->getResult();
            $total = $res[0]['total'];
            if ($total == 0) {

                $invoicedate = date('Y-m-d');
                $id = $res_outer[0]['id'];
                $name = $res_outer[0]['uname'];
                $email = $res_outer[0]['email'];
                $address = $res_outer[0]['address'];
                $phone = $res_outer[0]['mobile'];
                $orderdate = $res_outer[0]['date_added'];
                $order_list = $encoded_items;
                $discount = $res_outer[0]['discount'];
                $final_total = $res_outer[0]['final_total'];
                $total_payble = $res_outer[0]['total'];
                $shipping_charge = $res_outer[0]['delivery_charge'];
                $payment = $res_outer[0]['final_total'];
                $data = array(
                    'invoice_date' => $invoicedate,
                    'order_id' => $id,
                    'name' => $name,
                    'address' => $address,
                    'order_date' => $orderdate,
                    'phone_number' => $phone,
                    'order_list' => $encoded_items,
                    'email' => $email,
                    'discount' => $discount,
                    'total_sale' => $total_payble,
                    'shipping_charge' => $shipping_charge,
                    'payment' => $payment,
                );
                $db->insert('invoice', $data);
                $res = $db->getResult();
            }

            $sql_invoice = "SELECT id, invoice_date FROM invoice WHERE order_id =" . $id;

            // Execute query
            $db->sql($sql_invoice);
            // store result 
            $res_invoice = $db->getResult();
            $order_list = $encoded_items;
        ?>


            <section class="container-fluid">
                <section class="content-header">
                    <h1>
                        Invoice
                        <!-- <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small> -->
                    </h1>
                </section>
                <!-- <section class="content"> -->
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <h2 class="page-header text-left">
                                    <?= $settings['app_name']; ?>
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <h2 class="page-header text-right">
                                    Mo. <?= $settings['support_number']; ?>
                                </h2>
                            </div>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong><?= $settings['app_name']; ?></strong>
                            </address>
                            <address>
                                Email: <?= $settings['support_email']; ?><br>

                            </address>
                            <address>
                                Customer Care : <?= $settings['support_number']; ?>
                            </address>
                            <?php if (isset($res_outer[0]['delivery_boy'])) { ?>
                                <address>
                                    Delivery By : &nbsp; <?= $res_outer[0]['delivery_boy']; ?>
                                </address>
                            <?php } ?>
                            <?php if (isset($settings['tax_name']) && isset($settings['tax_number'])) { ?>
                                <address>
                                    <?= $settings['tax_name'] ?> : &nbsp; <?= $settings['tax_number'] ?>
                                </address>
                            <?php } ?>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong><?php echo $res_outer[0]['uname']; ?></strong>
                            </address>
                            <address>
                                <?php echo $res_outer[0]['address']; ?><br>

                            </address>
                            <address>
                                <strong><?php echo $res_outer[0]['mobile']; ?></strong><br>
                            </address>
                            <address>
                                <strong><?php echo $res_outer[0]['email']; ?></strong><br>
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-2 invoice-col">
                            Retail Invoice
                            <address>
                                <b>No : </b>#<?php echo $res_invoice[0]['id']; ?>
                            </address>
                            <address>
                                <b>Date: </b><?php echo date('d-m-Y', strtotime($res_invoice[0]['invoice_date'])); ?>
                            </address>
                            <address>
                                <b>Order ID: </b>#<?php echo $res_outer[0]['id']; ?>
                            </address>
                            <address>
                                <b>Date: </b><?php echo date('d-m-Y h:i A', strtotime($res_outer[0]['date_added'])); ?>
                            </address>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="col-md-12 table-responsive">
                            <table class="table borderless">
                                <thead class="text-center">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Product Code</th>
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Tax <?= $currency; ?>(%)</th>
                                        <th>Qty</th>
                                        <th>SubTotal (<?= $currency; ?>)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_total = 'select total from orders where id=' . $ID;
                                    $db->sql($sql_total);
                                    $res_total = $db->getResult();
                                    ?>
                                    <?php
                                    $decoded_items = json_decode(stripSlashes($order_list));
                                    $qty = 0;
                                    $i = 1;
                                    $total = $total_tax_amt = 0;
                                    $total_tax = array();
                                    foreach ($decoded_items as $item) {
                                        // print_r($item);
                                        if ($item[8] != 'cancelled' && $item[8] != 'returned') {
                                    ?>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i ?><br></td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $item[0] ?><br></td>
                                                <td><?= $item[1] ?><br></td>
                                                <td><?= $item[3] . " " . $item[4] ?><br></td>
                                                <td><?= $item[10] ?></td>
                                                <?php if ($item[9] != 0) {
                                                    $sql_tax = "SELECT * FROM `taxes` where id=" . $item[9];
                                                    $db->sql($sql_tax);
                                                    $res_tax = $db->getResult();
                                                    $tax_amount1 = ($res_tax[0]['percentage'] / 100) * $item[10];
                                                    $tax_amount2 = $tax_amount1 * $item[2];
                                                    // print_r($tax_amount2);
                                                ?>
                                                    <td><?php echo $tax_amount2 . " (" . $res_tax[0]['percentage'] . "%) " . $res_tax[0]['title'];
                                                        array_push($total_tax, $res_tax[0]['percentage']);
                                                        $total_tax_amt += $tax_amount2;
                                                    } else { ?><br></td>
                                                    <td><?= "0 %";
                                                    } ?><br></td>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $item[2] ?><br></td>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $item[7] ?><br></td>

                                            </tr>
                                    <?php $qty = $qty + $item[2];
                                            $i++;
                                            $total += $item[7];
                                        }
                                    } ?>

                                </tbody>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $qty ?><br></td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $res_total[0]['total']; ?><br></td>
                                </tr>
                            </table>
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <?php if ($res_outer[0]['discount'] > 0) {
                        $discounted_amount = $res_total[0]['total'] * $res_outer[0]['discount'] / 100; /*  */
                        $final_total = $res_total[0]['total'] - $discounted_amount;
                        $discount_in_rupees = $res_total[0]['total'] - $final_total;
                        $discount_in_rupees = $discount_in_rupees;
                        // echo $discount_in_rupees;
                    } else {
                        $discount_in_rupees = 0;
                    } ?>
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-md-6 col-md-offset-6">
                            <!--<p class="lead">Payment Date: </p>-->
                            <div class="table-responsive">
                                <table class="table borderless heading">
                                    <th></th>
                                    <tr>
                                        <th>Total Order Price (<?= $currency; ?>)</th>
                                        <td><?php echo '+ ' . $res_total[0]['total']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Charge (<?= $currency; ?>)</th>
                                        <td><?= '+ ' . $res_outer[0]['delivery_charge']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tax <?= $currency; ?>(%)</th>
                                        <td>
                                            <?php echo "+" . $total_tax_amt . "(";
                                            echo implode("%,", $total_tax) . "%)"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discount <?= $currency; ?>(%)</th>
                                        <td><?= '- ' . $discount_in_rupees . ' (' . $res_outer[0]['discount'] . '%)'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Promo (<?= $res_outer[0]['promo_code']; ?>) Discount (<?= $currency; ?>)</th>
                                        <td><?= '- ' . $res_outer[0]['promo_discount']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Wallet Used (<?= $currency; ?>)</th>
                                        <td><?= '- ' . $res_outer[0]['wallet_balance']; ?></td>
                                    </tr>
                                    <th>Final Total (<?= $currency; ?>)</th>
                                    <?php
                                    $total = $res_total[0]['total'];
                                    $delivery_charge = $res_outer[0]['delivery_charge'];
                                    $tax_amount = $res_outer[0]['tax_amount'];
                                    $promo_discount = $res_outer[0]['promo_discount'];
                                    $wallet = $res_outer[0]['wallet_balance'];
                                    $final_total = $total + $delivery_charge  - $discount_in_rupees - $promo_discount - $wallet;
                                    ?>
                                    <td><?= '= ' . ceil($final_total); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- </section> -->
            </section>
        <?php }
    } else { ?>
        <h1 class="text-center">Invalid Order Id</h1>
    <?php return false;
    } ?>
</body>

</html>