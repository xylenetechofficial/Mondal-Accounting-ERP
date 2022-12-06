<?php
session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['user'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/crud.php');
include_once('../includes/variables.php');
$db = new Database();
$db->connect();
$config = $fn->get_configurations();
$low_stock_limit = $config['low-stock-limit'];
// $pickup = $fn->is_lockup($ID);

$time_zone = $fn->set_timezone($config);
if (!$time_zone) {
    $response['error'] = true;
    $response['message'] = "Time Zone is not set.";
    print_r(json_encode($response));
    return false;
    exit();
}

//data of 'ORDERS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'orders') {
    $offset = 0;
    $limit = 10;
    $sort = 'o.id';
    $order = 'DESC';
    $where = ' ';
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $db->escapeString($fn->xss_clean($_GET['start_date']));
        $end_date = $db->escapeString($fn->xss_clean($_GET['end_date']));
        $where .= " where DATE(date_added)>=DATE('" . $start_date . "') AND DATE(date_added)<=DATE('" . $end_date . "')";
    }
    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
            $where .= " AND (name like '%" . $search . "%' OR o.id like '%" . $search . "%' OR o.mobile like '%" . $search . "%' OR address like '%" . $search . "%' OR `payment_method` like '%" . $search . "%' OR `delivery_charge` like '%" . $search . "%' OR `delivery_time` like '%" . $search . "%' OR o.`status` like '%" . $search . "%' OR `date_added` like '%" . $search . "%')";
        } else {
            $where .= " where (name like '%" . $search . "%' OR o.id like '%" . $search . "%' OR o.mobile like '%" . $search . "%' OR address like '%" . $search . "%' OR `payment_method` like '%" . $search . "%' OR `delivery_charge` like '%" . $search . "%' OR `delivery_time` like '%" . $search . "%' OR o.`status` like '%" . $search . "%' OR `date_added` like '%" . $search . "%')";
        }
    }
    if (isset($_GET['filter_order']) && $_GET['filter_order'] != '') {
        $filter_order = $db->escapeString($fn->xss_clean($_GET['filter_order']));
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $where .= " and `active_status`='" . $filter_order . "'";
        } elseif (isset($_GET['start_date']) && $_GET['start_date'] != '') {
            $where .= " and `active_status`='" . $filter_order . "'";
        } else {
            $where .= " where `active_status`='" . $filter_order . "'";
        }
    }
    $sql = "SELECT COUNT(o.id) as total FROM `orders` o JOIN users u ON u.id=o.user_id" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row) {
        $total = $row['total'];
    }
    $sql = "select o.*,u.name FROM orders o JOIN users u ON u.id=o.user_id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    for ($i = 0; $i < count($res); $i++) {
        $sql = "select oi.*,p.name as name, u.name as uname,v.measurement, (SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name,(SELECT status FROM orders o where o.id=oi.order_id)as order_status from `order_items` oi 
			    left join product_variant v on oi.product_variant_id=v.id 
			    left join products p on p.id=v.product_id 
			    left join users u ON u.id=oi.user_id
			    where oi.order_id=" . $res[$i]['id'];
        $db->sql($sql);
        $res[$i]['items'] = $db->getResult();
    }
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        $items = $row['items'];
        $items1 = '';
        $temp = '';
        $total_amt = 0;
        foreach ($items as $item) {
            $temp .= "<b>Item ID :</b>" . $item['id'] . "<b> Product Variant Id :</b> " . $item['product_variant_id'] . "<b> Name : </b>" . $item['name'] . " <b>Unit : </b>" . $item['measurement'] . $item['mesurement_unit_name'] . " <b>Price : </b>" . $item['price'] . " <b>QTY : </b>" . $item['quantity'] . " <b>Subtotal : </b>" . $item['quantity'] * $item['price'] . "<br>------<br>";
            $total_amt += $item['sub_total'];
        }
        $items1 = $temp;
        $temp = '';
        $status = json_decode($row['items'][0]['order_status']);
        if (!empty($status)) {
            foreach ($status as $st) {
                $temp .= $st[0] . " : " . $st[1] . "<br>------<br>";
            }
        }
        if ($row['active_status'] == 'received') {
            $active_status = '<label class="label label-primary">' . $row['active_status'] . '</label>';
        }
        if ($row['active_status'] == 'awaiting') {
            $active_status = '<label class="label label-secondary">' . $row['active_status'] . '</label>';
        }
        if ($row['active_status'] == 'awaiting_payment') {
            $active_status = '<label class="label label-secondary">' . $row['active_status'] . '</label>';
        }
        if ($row['active_status'] == 'processed') {
            $active_status = '<label class="label label-info">' . $row['active_status'] . '</label>';
        }
        if ($row['active_status'] == 'shipped') {
            $active_status = '<label class="label label-warning">' . $row['active_status'] . '</label>';
        }
        if ($row['active_status'] == 'ready_to_pickup') {
            $active_status = '<label class="label label-warning">' . $row['active_status'] . '</label>';
        }
        if ($row['active_status'] == 'delivered') {
            $active_status = '<label class="label label-success">' . $row['active_status'] . '</label>';
        }
        if ($row['active_status'] == 'returned' || $row['active_status'] == 'cancelled') {
            $active_status = '<label class="label label-danger">' . $row['active_status'] . '</label>';
        }
        $sql = "select name from delivery_boys where id=" . $row['delivery_boy_id'];
        $db->sql($sql);
        $res_dboy = $db->getResult();
        $status = $temp;
        $operate = "<a class='btn btn-sm btn-primary edit-fees' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editFeesModal'>Edit</a>";

        $operate .= "<a onclick='return conf(\"delete\");' class='btn btn-sm btn-danger' href='../public/db_operations.php?id=" . $row['id'] . "&delete_order=1' target='_blank'>Delete</a>";
        $discounted_amount = $row['total'] * $row['items'][0]['discount'] / 100;
        $final_total = $row['total'] - $discounted_amount;
        $discount_in_rupees = $row['total'] - $final_total;
        $discount_in_rupees = floor($discount_in_rupees);
        $tempRow['id'] = $row['id'];
        $tempRow['user_id'] = $row['user_id'];
        $tempRow['name'] = $row['items'][0]['uname'];
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['mobile'] = str_repeat("*", strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
        } else {
            $tempRow['mobile'] = $row['mobile'];
        }
        $tempRow['order_note'] = $row['order_note'];
        $tempRow['delivery_charge'] = $row['delivery_charge'];
        $tempRow['items'] = $items1;
        $tempRow['total'] = $row['total'];
        $tempRow['tax'] = $row['tax_amount'] . '(' . $row['tax_percentage'] . '%)';
        $tempRow['promo_discount'] = $row['promo_discount'];
        $tempRow['wallet_balance'] = $row['wallet_balance'];
        $tempRow['discount'] = $discount_in_rupees . '(' . $row['items'][0]['discount'] . '%)';
        $tempRow['qty'] = $row['items'][0]['quantity'];
        $tempRow['final_total'] = $row['final_total'];
        $tempRow['promo_code'] = $row['promo_code'];
        $tempRow['deliver_by'] = !empty($res_dboy[0]['name']) ? $res_dboy[0]['name'] : 'Not Assigned';
        $tempRow['payment_method'] = $row['payment_method'];
        $tempRow['address'] = $row['address'];
        $tempRow['delivery_time'] = $row['delivery_time'];
        $tempRow['status'] = $status;
        $tempRow['local_pickup'] = $row['local_pickup'] == 1 ? "<label class='label label-success'>Yes</label>" : "<label class='label label-danger'>NO</label>";
        $tempRow['pickup_time'] = !empty($row['pickup_time']) ? $row['pickup_time'] : "";
        $tempRow['active_status'] = $active_status;
        $tempRow['wallet_balance'] = $row['wallet_balance'];
        $tempRow['date_added'] = date('d-m-Y', strtotime($row['date_added']));
        $tempRow['operate'] = '<a href="order-detail.php?id=' . $row['id'] . '"><i class="fa fa-eye"></i> View</a>
				<br><a href="delete-order.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i> Delete</a>';
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'CATEGORY' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'category') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `subtitle` like '%" . $search . "%' OR `image` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `category` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `category` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = '<a href="view-subcategory.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>View Subcategories</a>';
        $operate .= ' <a href="edit-category.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-category.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['subtitle'] = $row['subtitle'];
        $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='" . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SUBCATEGORY' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'subcategory') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where s.`id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `subtitle` like '%" . $search . "%' OR `image` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `subcategory` s" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT s.*,(SELECT name FROM category c WHERE c.id=s.category_id) as category_name FROM `subcategory` s" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = '<a href="view-subcategory-product.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>View Products</a>';
        $operate .= ' <a href="edit-subcategory.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-subcategory.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['category_name'] = $row['category_name'];
        $tempRow['subtitle'] = $row['subtitle'];
        $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='" . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'PRODUCTS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'products') {
    $offset = 0;
    $limit = 10;
    $sort = 'product_id';
    $order = 'ASC';
    $where = '';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        if ($_GET['sort'] == 'product_id') {
            $sort = "pv.product_id";
        } else {
            $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
            $sort = "p." . $sort;
        }
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) and $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " where (p.`id` like '%" . $search . "%' OR pv.`id` like '%" . $search . "%' OR p.`name` like '%" . $search . "%' OR pv.`measurement` like '%" . $search . "%' OR u.`short_code` like '%" . $search . "%' )";
    }

    if (isset($_GET['category_id']) && $_GET['category_id'] != '') {
        $category_id = $db->escapeString($fn->xss_clean($_GET['category_id']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and p.`category_id`=' . $category_id;
        else
            $where = ' where p.`category_id`=' . $category_id;
    }
    if (isset($_GET['sold_out']) && $_GET['sold_out'] == 1) {
        $where .= empty($where) ? " WHERE pv.serve_for = 'Sold Out'" : " AND serve_for = 'Sold Out'";
    }
    if (isset($_GET['low_stock']) && $_GET['low_stock'] == 1) {
        $where .= empty($where) ? " WHERE pv.stock < $low_stock_limit AND pv.serve_for = 'Available'" : " AND stock < $low_stock_limit AND serve_for = 'Available'";
    }

    $join = "LEFT JOIN `product_variant` pv ON pv.product_id = p.id
            LEFT JOIN `unit` u ON u.id = pv.measurement_unit_id
            LEFT JOIN `flash_sales_products` fp ON fp.product_id = p.id";

    $sql = "SELECT COUNT(p.id) as `total` FROM `products` p $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
    $sql = "SELECT p.id AS id,fp.price as sales_price,fp.discounted_price as sales_discounted_price,fp.status as sales_status,fp.start_date,fp.end_date,p.name,p.status,p.tax_id, p.ratings,p.number_of_ratings,p.image, p.indicator, p.manufacturer, p.made_in, p.return_status, p.cancelable_status, p.till_status,p.description, pv.id as product_variant_id, pv.price, pv.discounted_price, pv.measurement, pv.serve_for, pv.stock,pv.stock_unit_id, u.short_code 
            FROM `products` p
            $join 
            $where ORDER BY $sort $order LIMIT $offset, $limit";
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    $currency = $fn->get_settings('currency', false);

    foreach ($res as $row) {
        // print_r($row);
        if ($row['indicator'] == 0) {
            $indicator = "<span class='label label-info'>None</span>";
        }
        if ($row['indicator'] == 1) {
            $indicator = "<span class='label label-success'>Veg</span>";
        }
        if ($row['indicator'] == 2) {
            $indicator = "<span class='label label-danger'>Non-Veg</span>";
        }
        if ($row['till_status'] == 'received') {
            $till_status = '<label class="label label-primary">Received</label>';
        }
        if ($row['till_status'] == 'processed') {
            $till_status = '<label class="label label-info">Processed</label>';
        }
        if ($row['till_status'] == 'shipped') {
            $till_status = '<label class="label label-warning">Shipped</label>';
        }
        if ($row['till_status'] == 'delivered') {
            $till_status = '<label class="label label-success">Delivered</label>';
        }

        if (!empty($row['stock_unit_id'])) {
            $sql = "select short_code as stock_unit from unit where id = " . $row['stock_unit_id'];
            $db->sql($sql);
            $stock_unit = $db->getResult();
            $tempRow['stock'] = $row['stock'] . ' ' . $stock_unit[0]['stock_unit'];
        }

        $operate = '<a class="btn btn-xs btn-info" href="view-product-variants.php?id=' . $row['id'] . '" title="View"><i class="fa fa-folder-open"></i></a>&nbsp;';
        $operate .= '<a class="btn btn-xs btn-primary" href="edit-product.php?id=' . $row['id'] . '" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
        $operate .= '<a class="btn btn-xs btn-success" href="view-ratings.php?id=' . $row['id'] . '" title="View Ratings"><i class="fa fa-star"></i></a>&nbsp;';
        $operate .= ' <a class="btn btn-xs btn-danger" href="delete-product.php?id=' . $row['product_variant_id'] . '" title="Delete"><i class="fa fa-trash-o"></i></a>&nbsp;';
        if ($row['status'] == 1) {
            $operate .= "<a class='btn btn-xs btn-warning set-product-deactive' data-id='" . $row['id'] . "' title='Hide'>  <i class='fa fa-eye'></i> </a>";
        } elseif ($row['status'] == 0) {
            $operate .= "<a class='btn btn-xs btn-success set-product-active' data-id='" . $row['id'] . "' title='Show'>  <i class='fa fa-eye-slash'></i> </a>";
        }
        $paymentDate = date('Y-m-d');
        $contractDateBegin = $row['start_date'];
        $contractDateEnd =  $row['end_date'];

        $tempRow['id'] = $row['product_variant_id'];
        $tempRow['product_id'] = $row['id'];
        $tempRow['tax_id'] = $row['tax_id'];
        $tempRow['name'] = $row['name'];
        $tempRow['measurement'] =  $row['measurement'] == 0 ? $row['short_code']  : $row['measurement'] . " " . $row['short_code'];
        $tempRow['price'] = ($contractDateBegin >= $paymentDate && $paymentDate <= $contractDateEnd && $row['sales_status'] == 1) ? $currency . " " . $row['sales_price'] : $currency . " " . $row['price'];
        $tempRow['indicator'] = $indicator;
        $tempRow['manufacturer'] = $row['manufacturer'];
        $tempRow['made_in'] = $row['made_in'];
        $tempRow['ratings'] = '<input type="text" class="ratings rating-loading" value="' . $row['ratings'] . '" data-size="xs" title="" readonly>';
        $tempRow['description'] = $row['description'];
        $tempRow['return_status'] = $row['return_status'] == 1 ? "<span class='label label-success'>Allowed</span>" : "<span class='label label-danger'>Not Allowed</span>";
        $tempRow['cancelable_status'] = $row['cancelable_status'] == 1 ? "<span class='label label-success'>Allowed</span>" : "<span class='label label-danger'>Not Allowed</span>";
        $tempRow['till_status'] = $row['cancelable_status'] == 1 ? $till_status : "<label class='label label-info'>Not Applicable</label>";
        $tempRow['discounted_price'] = ($contractDateBegin >= $paymentDate && $paymentDate <= $contractDateEnd && $row['sales_status'] == 1) ? $currency . " " . $row['sales_discounted_price'] : $currency . " " . $row['discounted_price'];
        $tempRow['serve_for'] = $row['serve_for'] == 'Sold Out' ? "<span class='label label-danger'>Sold Out</label>" : "<span class='label label-success'>Available</label>";
        $tempRow['image'] = "<a data-lightbox='product' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='" . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'USERS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'users') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['filter_user']) && $_GET['filter_user'] != '') {
        $filter_user = $db->escapeString($fn->xss_clean($_GET['filter_user']));
        $where .= ' WHERE u.city=' . $filter_user;
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        if (isset($_GET['filter_user']) && $_GET['filter_user'] != '') {
            $where .= " and u.`id` like '%" . $search . "%' OR u.`name` like '%" . $search . "%' OR u.`email` like '%" . $search . "%' OR u.`mobile` like '%" . $search . "%' ";
        } else {
            $where .= " Where u.`id` like '%" . $search . "%' OR u.`name` like '%" . $search . "%' OR u.`email` like '%" . $search . "%' OR u.`mobile` like '%" . $search . "%'";
        }
    }
    if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] != '') {
        $filter_order = $db->escapeString($fn->xss_clean($_GET['filter_order']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and active_status=' . $filter_order;
        else
            $where = ' where active_status=' . $filter_order;
    }

    $sql = "SELECT COUNT(id) as total FROM `users` u " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT u.* FROM `users` u " . $where . " ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = '<a class="btn btn-xs btn-info view-address" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewAddressModel" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        if ($row['status'] == 1) {
            $operate .= "<a class='btn btn-xs btn-warning set-product-deactive' data-id='" . $row['id'] . "' title='Hide'>  <i class='fa fa-eye'></i> </a>";
        } elseif ($row['status'] == 0) {
            $operate .= "<a class='btn btn-xs btn-success set-product-active' data-id='" . $row['id'] . "' title='Show'>  <i class='fa fa-eye-slash'></i> </a>";
        }

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $path = DOMAIN_URL . 'upload/profile/';
        if (!empty($row['profile'])) {
            $tempRow['profile'] = "<a data-lightbox='product' href='" . $path . $row['profile'] . "' data-caption='" . $row['name'] . "'><img src='" . $path . $row['profile'] . "' title='" . $row['name'] . "' height='50' /></a>";
        } else {
            $tempRow['profile'] = "<a data-lightbox='product' href='" . $path . "default_user_profile.png' data-caption='" . $row['name'] . "'><img src='" . $path . "default_user_profile.png' title='" . $row['name'] . "' height='50' /></a>";
        }
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['email'] = str_repeat("*", strlen($row['email']) - 13) . substr($row['email'], -13);
            $tempRow['mobile'] = str_repeat("*", strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
        } else {
            $tempRow['mobile'] = $row['mobile'];
            $tempRow['email'] = $row['email'];
        }
        $tempRow['balance'] = $row['balance'];
        $tempRow['referral_code'] = $row['referral_code'];
        $tempRow['friends_code'] = !empty($row['friends_code']) ? $row['friends_code'] : '-';
        $tempRow['city_id'] = $row['city'];
        $tempRow['area_id'] = $row['area'];
        $tempRow['apikey'] = $row['apikey'];
        $tempRow['status'] = $row['status'] == 1 ? "<label class='label label-success'>Active</label>" : "<label class='label label-danger'>De-Active</label>";
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'user_address') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where ua.`id` like '%" . $search . "%' OR ua.`pincode` like '%" . $search . "%'";
    }

    if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
        $user_id = $db->escapeString($fn->xss_clean($_GET['user_id']));
        $where .= !empty($where) ? ' AND ua.user_id = ' . $user_id : ' WHERE ua.user_id = ' . $user_id;
    }
    $sql = "SELECT COUNT(user_id) as total FROM `user_addresses` ua " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT ua.*,u.email,u.balance,u.referral_code,u.street,u.apikey,u.status,(SELECT name FROM city c WHERE c.id=ua.city_id) as city_name,ua.landmark as street,(SELECT name FROM area a WHERE a.id=ua.area_id) as area_name FROM `users` u LEFT JOIN user_addresses ua on ua.user_id=u.id " . $where . " ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $path = DOMAIN_URL . 'upload/profile/';
        if (!empty($row['profile'])) {
            $tempRow['profile'] = "<a data-lightbox='product' href='" . $path . $row['profile'] . "' data-caption='" . $row['name'] . "'><img src='" . $path . $row['profile'] . "' title='" . $row['name'] . "' height='50' /></a>";
        } else {
            $tempRow['profile'] = "<a data-lightbox='product' href='" . $path . "default_user_profile.png' data-caption='" . $row['name'] . "'><img src='" . $path . "default_user_profile.png' title='" . $row['name'] . "' height='50' /></a>";
        }
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['email'] = str_repeat("*", strlen($row['email']) - 13) . substr($row['email'], -13);
            $tempRow['mobile'] = str_repeat("*", strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
        } else {
            $tempRow['mobile'] = $row['mobile'];
            $tempRow['email'] = $row['email'];
        }
        $tempRow['balance'] = $row['balance'];
        $tempRow['referral_code'] = $row['referral_code'];
        $tempRow['friends_code'] = !empty($row['friends_code']) ? $row['friends_code'] : '-';
        $tempRow['city_id'] = $row['city_id'];
        $tempRow['city'] = $row['city_name'];
        $tempRow['area_id'] = $row['area_id'];
        $tempRow['area'] = $row['area_name'];
        $tempRow['street'] = $row['street'];
        $tempRow['apikey'] = $row['apikey'];

        $tempRow['status'] = $row['status'] == 1 ? "<label class='label label-success'>Active</label>" : "<label class='label label-danger'>De-Active</label>";
        $tempRow['date_created'] = $row['date_created'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'user_wallet') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['filter_user']) && $_GET['filter_user'] != '') {
        $filter_user = $db->escapeString($fn->xss_clean($_GET['filter_user']));
        $where .= ' WHERE u.city=' . $filter_user;
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        if (isset($_GET['filter_user']) && $_GET['filter_user'] != '') {
            $where .= " and u.`id` like '%" . $search . "%' OR u.`name` like '%" . $search . "%' OR u.`email` like '%" . $search . "%' OR u.`mobile` like '%" . $search . "%' ";
        } else {
            $where .= " Where u.`id` like '%" . $search . "%' OR u.`name` like '%" . $search . "%' OR u.`email` like '%" . $search . "%' OR u.`mobile` like '%" . $search . "%'";
        }
    }
    if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] != '') {
        $filter_order = $db->escapeString($fn->xss_clean($_GET['filter_order']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and active_status=' . $filter_order;
        else
            $where = ' where active_status=' . $filter_order;
    }


    $sql = "SELECT COUNT(id) as total FROM `users` u " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT u.*,(SELECT name FROM city c WHERE c.id=ua.city_id) as city_name,ua.landmark as street,(SELECT name FROM area a WHERE a.id=ua.area_id) as area_name FROM `users` u LEFT JOIN user_addresses ua on ua.user_id=u.id " . $where . " GROUP BY u.id ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        if ($row['status'] == 1) {
            $operate = "<a class='btn btn-xs btn-warning set-product-deactive' data-id='" . $row['id'] . "' title='Hide'>  <i class='fa fa-eye'></i> </a>";
        } elseif ($row['status'] == 0) {
            $operate = "<a class='btn btn-xs btn-success set-product-active' data-id='" . $row['id'] . "' title='Show'>  <i class='fa fa-eye-slash'></i> </a>";
        }

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $path = DOMAIN_URL . 'upload/profile/';
        if (!empty($row['profile'])) {
            $tempRow['profile'] = "<a data-lightbox='product' href='" . $path . $row['profile'] . "' data-caption='" . $row['name'] . "'><img src='" . $path . $row['profile'] . "' title='" . $row['name'] . "' height='50' /></a>";
        } else {
            $tempRow['profile'] = "<a data-lightbox='product' href='" . $path . "default_user_profile.png' data-caption='" . $row['name'] . "'><img src='" . $path . "default_user_profile.png' title='" . $row['name'] . "' height='50' /></a>";
        }
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['email'] = str_repeat("*", strlen($row['email']) - 13) . substr($row['email'], -13);
            $tempRow['mobile'] = str_repeat("*", strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
        } else {
            $tempRow['mobile'] = $row['mobile'];
            $tempRow['email'] = $row['email'];
        }
        $tempRow['balance'] = $row['balance'];
        $tempRow['referral_code'] = $row['referral_code'];
        $tempRow['friends_code'] = !empty($row['friends_code']) ? $row['friends_code'] : '-';
        $tempRow['city_id'] = $row['city'];
        $tempRow['city'] = $row['city_name'];
        $tempRow['area_id'] = $row['area'];
        $tempRow['area'] = $row['area_name'];
        $tempRow['street'] = $row['street'];
        $tempRow['apikey'] = $row['apikey'];

        $tempRow['status'] = $row['status'] == 1 ? "<label class='label label-success'>Active</label>" : "<label class='label label-danger'>De-Active</label>";
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'AREAS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'area') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($fn->xss_clean($_GET['offset'])) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($fn->xss_clean($_GET['limit'])) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($fn->xss_clean($_GET['sort'])) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($fn->xss_clean($_GET['order'])) : 'DESC';

    if (isset($_GET['filter_area']) && !empty($_GET['filter_area'])) {
        $filter_area = $db->escapeString($fn->xss_clean($_GET['filter_area']));
        $where .= ' where c.id=' . $filter_area;
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        if (isset($_GET['filter_area']) && !empty($_GET['filter_area'])) {
            $where .= " and a.`id` like '%" . $search . "%' OR a.`name` like '%" . $search . "%' OR `city_id` like '%" . $search . "%' OR c.`name` like '%" . $search . "%'";
        } else {
            $where .= " Where a.`id` like '%" . $search . "%' OR a.`name` like '%" . $search . "%' OR `city_id` like '%" . $search . "%' OR c.`name` like '%" . $search . "%'";
        }
    }

    $sql = "SELECT COUNT(a.id) as total FROM `area` a JOIN city c ON a.city_id=c.id " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT a.*,c.name as city_name FROM `area` a join city c ON a.city_id=c.id $where ORDER BY $sort $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a href="edit-area.php?id=' . $row['id'] . '" title="Edit"><i class="fa fa-edit"></i>Edit</a>&nbsp;';
        $operate .= ' <a class="btn btn-xs btn-danger" href="delete-area.php?id=' . $row['id'] . '" title="Delete"><i class="fa fa-trash-o"></i> Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['delivery_charges'] = $row['delivery_charges'];
        $tempRow['minimum_free_delivery_order_amount'] = $row['minimum_free_delivery_order_amount'];
        $tempRow['minimum_order_amount'] = $row['minimum_order_amount'];
        $tempRow['city_id'] = $row['city_id'];
        $tempRow['city_name'] = $row['city_name'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'NOTIFICATIONS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'notifications') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `title` like '%" . $search . "%' OR `message` like '%" . $search . "%' OR `image` like '%" . $search . "%' OR `date_sent` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(*) as total FROM `notifications` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `notifications` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {


        $operate = " <a class='btn btn-xs btn-danger delete-notification' data-id='" . $row['id'] . "' data-image='" . $row['image'] . "' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>";

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['message'] = $row['message'];
        $tempRow['type'] = $row['type'];
        $tempRow['type_id'] = $row['type_id'];
        $tempRow['image'] = (!empty($row['image'])) ? "<a data-lightbox='slider' href='" . $row['image'] . "' data-caption='" . $row['title'] . "'><img src='" . $row['image'] . "' title='" . $row['title'] . "' width='50' /></a>" : "No Image";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SLIDER' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'slider') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `image` like '%" . $search . "%' OR `image2` like '%" . $search . "%' OR `date_added` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(*) as total FROM `slider` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `slider` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a href="edit-slider.php?id=' . $row['id'] . '" class="btn btn-xs btn-primary" title="edit"><i class="fa fa-edit"></i></a>';
        $operate .= " <a class='btn btn-xs btn-danger delete-slider' data-id='" . $row['id'] . "' data-image='" . $row['image'] . "' data-image2='" . $row['image2'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['type'] = $row['type'];
        $tempRow['type_id'] = $row['type_id'];
        $tempRow['slider_url'] = $row['slider_url'];
        $tempRow['title'] = !empty($row['title']) ? $row['title'] : "";
        $tempRow['short_description'] = !empty($row['short_description']) ? $row['short_description'] : "";
        $tempRow['image'] = (!empty($row['image'])) ? "<a data-lightbox='slider' href='" . $row['image'] . "'><img src='" . $row['image'] . "' width='40'/></a>" : "No Image";
        $tempRow['image2'] = (!empty($row['image2'])) ? "<a data-lightbox='slider' href='" . $row['image2'] . "'><img src='" . $row['image2'] . "' width='40'/></a>" : "No Image";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'OFFERS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'offers') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `date_added` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(id) as total FROM `offers` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `offers` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        $operate = " <a class='btn btn-xs btn-danger delete-offer' data-id='" . $row['id'] . "' data-image='" . $row['image'] . "' title='Delete'><i class='fa fa-trash-o'></i>Delete</a>";

        $tempRow['id'] = $row['id'];
        $tempRow['image'] = (!empty($row['image'])) ? "<a data-lightbox='offer' href='" . $row['image'] . "'><img src='" . $row['image'] . "' width='40'/></a>" : "No Image";
        $tempRow['position'] = $row['position'];
        $tempRow['section_position'] = $row['section_position'];
        $tempRow['date_created'] = date('d-m-Y h:i:sa', strtotime($row['date_added']));
        $tempRow['operate'] = $operate;

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'MEDIA' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'media') {
    $where = '';

    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($fn->xss_clean($_GET['offset'])) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($fn->xss_clean($_GET['limit'])) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($fn->xss_clean($_GET['sort'])) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($fn->xss_clean($_GET['order'])) : 'DESC';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `extension` like '%" . $search . "%' OR `type` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `date_created` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(id) as total FROM `media` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `media` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        $operate = " <a class='btn btn-xs btn-danger delete_media' data-id='" . $row['id'] . "' data-image='" . $row['sub_directory'] . '/' . $row['name'] . "'title='Delete'><i class='fa fa-trash-o'></i>Delete</a>";
        $operate .= " <a class='btn btn-xs btn-primary copy_to_clipboard' title='Copy'><i class='fa fa-copy'></i>Copy</a> ";

        $tempRow['id'] = $row['id'];
        $tempRow['image'] = "<img src='" . $row['sub_directory'] . '/' . $row['name'] . "' width='60' height: 60px; />";
        $full_path =  $row['sub_directory']  . $row['name'];
        $tempRow['image'] .= "<span class='copy-path hide'>$full_path</span>";
        $tempRow['name'] = $row['name'];
        $tempRow['extension'] = $row['extension'];
        $tempRow['type'] = $row['type'];
        $tempRow['sub_directory'] = $row['sub_directory'];
        $tempRow['size'] = ($row['size'] > 1) ? formatBytes($row['size']) : $row['size'];
        $tempRow['date_created'] = date('d-m-Y h:i:sa', strtotime($row['date_created']));
        $tempRow['operate'] = $operate;

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SECTIONS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'sections') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `title` like '%" . $search . "%' OR `date_added` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(*) as total FROM `sections` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `sections` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = "<a class='btn btn-xs btn-primary edit-section' data-id='" . $row['id'] . "' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";

        $operate .= " <a class='btn btn-xs btn-danger delete-section' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['short_description'] = $row['short_description'];
        $tempRow['style'] = $row['style'];
        $tempRow['product_type'] = $row['product_type'];
        $tempRow['product_ids'] = $row['product_ids'];
        $tempRow['category_ids'] = $row['category_ids'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SELLER_REQUEST' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'seller_request') {
    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $status = $db->escapeString($fn->xss_clean($_GET['status']));
    $where = ' where status=' . $status;
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "  and (`id` like '%" . $search . "%' OR `name` like '%" . $search . "%')";
    }

    $sql = "SELECT COUNT(*) as total FROM `seller` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `seller` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a href="edit-request.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['email'] = $row['email'];
        $tempRow['company'] = $row['company_name'];
        $tempRow['address'] = $row['company_address'];
        $tempRow['gst_no'] = $row['gst_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        if ($row['status'] == 0) {
            $tempRow['status'] = "<span class='label label-warning'>Pending</span>";
        } elseif ($row['status'] == 1) {
            $tempRow['status'] =  "<span class='label label-success'>Accepted</span>";
        } else {
            $tempRow['status'] =  "<span class='label label-danger'>Denied</span>";
        }
        $tempRow['date_created'] = $row['date_created'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'DELIVERY_BOYS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'delivery-boys') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `address` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `delivery_boys` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `delivery_boys` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;

    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    $path = 'upload/delivery-boy/';
    foreach ($res as $row) {

        $operate = "<a class='btn btn-xs btn-primary edit-delivery-boy' data-id='" . $row['id'] . "' data-driving_license='" . $row['driving_license'] . "' data-national_identity_card='" . $row['national_identity_card'] . "' data-toggle='modal' data-target='#editDeliveryBoyModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";

        $operate .= " <a class='btn btn-xs btn-danger delete-delivery-boy' data-id='" . $row['id'] . "' data-driving_license='" . $row['driving_license'] . "' data-national_identity_card='" . $row['national_identity_card'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";

        $operate .= " <a class='btn btn-xs btn-primary transfer-fund' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-mobile='" . $row['mobile'] . "' data-address='" . $row['address'] . "' data-balance='" . $row['balance'] . "' data-toggle='modal' data-target='#fundTransferModal' title='Fund Transfer'><i class='fa fa-chevron-circle-right'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['mobile'] = str_repeat("*", strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
        } else {
            $tempRow['mobile'] = $row['mobile'];
        }
        $tempRow['address'] = $row['address'];
        $tempRow['bonus'] = $row['bonus'];
        $tempRow['bonus_method'] = isset($row['bonus_method']) && !empty($row['bonus_method']) ? $row['bonus_method'] : "";
        $tempRow['balance'] = ceil($row['balance']);
        if (!empty($row['driving_license'])) {
            $tempRow['driving_license'] = "<a data-lightbox='product' href='" . DOMAIN_URL . $path . $row['driving_license'] . "'><img src='" . DOMAIN_URL . $path . $row['driving_license'] . "' height='50' /></a>";
            $tempRow['national_identity_card'] = "<a data-lightbox='product' href='" . $path . $row['national_identity_card'] . "'><img src='" . $path . $row['national_identity_card'] . "' height='50' /></a>";
        } else {
            $tempRow['national_identity_card'] = "<p>No National Identity Card</p>";
            $tempRow['driving_license'] = "<p>No Driving License</p>";
        }
        $tempRow['dob'] = $row['dob'];
        $tempRow['bank_account_number'] = $row['bank_account_number'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['account_name'] = $row['account_name'];
        $tempRow['other_payment_information'] = (!empty($row['other_payment_information'])) ? $row['other_payment_information'] : "";
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        if ($row['is_available'] == 0)
            $tempRow['available'] = "<label class='label label-danger'>NO</label>";
        else
            $tempRow['available'] = "<label class='label label-success'>Yes</label>";

        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-danger'>Deactive</label>";
        else
            $tempRow['status'] = "<label class='label label-success'>Active</label>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SOCIAL_MEDIA' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'social_media') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'ASC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `icon` like '%" . $search . "%' OR `link` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `social_media` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `social_media` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {


        $operate = "<a class='btn btn-xs btn-primary edit-social-media' data-id='" . $row['id'] . "'  data-toggle='modal' data-target='#editSocialMediaModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";

        $operate .= " <a class='btn btn-xs btn-danger delete-social-media' data-id='" . $row['id'] . "'   title='Delete'><i class='fa fa-trash-o'></i></a>";

        $tempRow['id'] = $row['id'];
        //$tempRow['name'] = $row['name'];

        $tempRow['id'] = $row['id'];
        $icon = "<i class='fa " . $row['icon'] . "'></i>";
        $tempRow['social_icon'] = $icon;
        $tempRow['icon'] = $row['icon'];
        $tempRow['link'] = $row['link'];

        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'PAYMENT_REQUEST' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'payment-requests') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where p.`id` like '%" . $search . "%' OR `user_id` like '%" . $search . "%' OR `payment_type` like '%" . $search . "%' OR `amount_requested` like '%" . $search . "%' OR `remarks` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `email` like '%" . $search . "%' OR `date_created` like '%" . $search . "%' OR `payment_address` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `payment_requests` p JOIN users u ON p.user_id=u.id" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT p.*,u.name,u.email FROM payment_requests p JOIN users u ON u.id=p.user_id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;

    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = "<a class='btn btn-xs btn-primary edit-payment-request' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editPaymentRequestModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['user_id'] = $row['user_id'];
        $tempRow['payment_type'] = $row['payment_type'];
        if ($row['payment_type'] == 'bank') {
            $payment_address = json_decode($row['payment_address'], true);
            $tempRow['payment_address'] = '<b>A/C Holder</b><br>' . $payment_address[0][1] . '<br>' . '<b>A/C Number</b><br>' . $payment_address[1][1] . '<br>' . '<b>IFSC Code</b><br>' . $payment_address[2][1] . '<br>' . '<b>Bank Name</b><br>' . $payment_address[3][1];
        } else {
            $tempRow['payment_address'] = $row['payment_address'];
        }
        $tempRow['amount_requested'] = $row['amount_requested'];
        $tempRow['remarks'] = $row['remarks'];
        $tempRow['name'] = $row['name'];
        $tempRow['email'] = $row['email'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-warning'>Pending</label>";
        if ($row['status'] == 1)
            $tempRow['status'] = "<label class='label label-primary'>Success</label>";
        if ($row['status'] == 2)
            $tempRow['status'] = "<label class='label label-danger'>Cancelled</label>";
        $tempRow['operate'] = $operate;
        $tempRow['date_created'] = $row['date_created'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'FUND_TRANSFER Transfer' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'fund-transfers') {

    $offset = 0;
    $limit = 10;
    $sort = 'f.id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where f.`id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `address` like '%" . $search . "%' OR `message` like '%" . $search . "%' OR f.`date_created` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(f.`id`) as total FROM `fund_transfers` f LEFT JOIN `delivery_boys` d ON f.delivery_boy_id=d.id" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT f.*,d.name,d.mobile,d.address FROM `fund_transfers` f LEFT JOIN `delivery_boys` d ON f.delivery_boy_id=d.id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;

    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['mobile'] = str_repeat("*", strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
        } else {
            $tempRow['mobile'] = $row['mobile'];
        }
        $tempRow['address'] = $row['address'];
        $tempRow['delivery_boy_id'] = $row['delivery_boy_id'];
        $tempRow['opening_balance'] = $row['opening_balance'];
        $tempRow['closing_balance'] = $row['closing_balance'];
        $tempRow['amount'] = $row['amount'];
        $tempRow['type'] = $row['type'] == 'credit' ? '<span class="label label-success">Credit</span>' : '<span class="label label-danger">Debit</span>';
        $tempRow['status'] = $row['status'] == 'SUCCESS' ? '<span class="label label-success">Success</span>' : '<span class="label label-danger">Failed</span>';
        $tempRow['message'] = $row['message'];
        $tempRow['date_created'] = $row['date_created'];


        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'UNITS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'unit') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `short_code` like '%" . $search . "%' OR `conversion` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `unit` $where";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `unit` $where ORDER BY $sort $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a href="edit-unit.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';

        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['short_code'] = $row['short_code'];
        $tempRow['parent_id'] = $row['parent_id'];
        $tempRow['conversion'] = $row['conversion'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'PROMO_CODES' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'promo-codes') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `promo_code` like '%" . $search . "%' OR `message` like '%" . $search . "%' OR `start_date` like '%" . $search . "%' OR `end_date` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(id) as total FROM `promo_codes`" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `promo_codes`" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = "<a class='btn btn-xs btn-primary edit-promo-code' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editPromoCodeModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
        $operate .= " <a class='btn btn-xs btn-danger delete-promo-code' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";


        $tempRow['id'] = $row['id'];
        $tempRow['promo_code'] = $row['promo_code'];
        $tempRow['message'] = $row['message'];
        $tempRow['start_date'] = $row['start_date'];
        $tempRow['end_date'] = $row['end_date'];
        $tempRow['no_of_users'] = $row['no_of_users'];
        $tempRow['minimum_order_amount'] = $row['minimum_order_amount'];
        $tempRow['discount'] = $row['discount'];
        $tempRow['discount_type'] = $row['discount_type'];
        $tempRow['max_discount_amount'] = $row['max_discount_amount'];
        $tempRow['repeat_usage'] = $row['repeat_usage'] == 1 ? 'Allowed' : 'Not Allowed';
        $tempRow['no_of_repeat_usage'] = $row['no_of_repeat_usage'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-danger'>Deactive</label>";
        else
            $tempRow['status'] = "<label class='label label-success'>Active</label>";
        $tempRow['date_created'] = date('d-m-Y h:i:sa', strtotime($row['date_created']));
        $tempRow['operate'] = $operate;

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'TIME_SLOTS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'time-slots') {

    $offset = 0;
    $limit = 10;
    $sort = 'last_order_time';
    $order = 'ASC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `title` like '%" . $search . "%' OR `from_time` like '%" . $search . "%' OR `to_time` like '%" . $search . "%' OR `last_order_time` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `time_slots` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `time_slots` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = "<a class='btn btn-xs btn-primary edit-time-slot' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editTimeSlotModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
        $operate .= " <a class='btn btn-xs btn-danger delete-time-slot' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";
        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['from_time'] = $row['from_time'];
        $tempRow['to_time'] = $row['to_time'];
        $tempRow['last_order_time'] = $row['last_order_time'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-danger'>Deactive</label>";
        else
            $tempRow['status'] = "<label class='label label-success'>Active</label>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'RETURN_REQUESTS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'return-requests') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where r.`id` like '%" . $search . "%' OR r.`user_id` like '%" . $search . "%' OR r.`order_id` like '%" . $search . "%' OR p.`name` like '%" . $search . "%' OR u.`name` like '%" . $search . "%' OR r.`status` like '%" . $search . "%' OR r.`date_created` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `return_requests` r LEFT JOIN users u ON r.user_id=u.id" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT r.*,u.name,oi.tax_percentage,oi.tax_amount,oi.product_variant_id,oi.quantity,p.id as product_id,p.name as product_name,pv.price,pv.discounted_price FROM return_requests r LEFT JOIN users u ON u.id=r.user_id LEFT JOIN order_items oi ON oi.id=r.order_item_id LEFT JOIN products p ON p.id = r.product_id LEFT JOIN product_variant pv ON pv.id=r.product_variant_id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = "<a class='btn btn-xs btn-primary edit-return-request' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editReturnRequestModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
        $operate .= " <a class='btn btn-xs btn-danger delete-return-request' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['user_id'] = $row['user_id'];
        $tempRow['order_id'] = $row['order_id'];
        $tempRow['order_item_id'] = $row['order_item_id'];
        $tempRow['product_id'] = $row['product_id'];
        $tempRow['price'] = $row['price'];
        $tempRow['discounted_price'] = $row['discounted_price'];
        $tempRow['remarks'] = $row['remarks'];
        $tempRow['name'] = $row['name'];
        $tempRow['product_name'] = $row['product_name'];
        $tempRow['product_variant_id'] = $row['product_variant_id'];
        $tempRow['quantity'] = $row['quantity'];
        $tempRow['tax_amount'] = $row['tax_amount'];
        $tempRow['tax_percentage'] = $row['tax_percentage'];
        $tempRow['total'] = $row['discounted_price'] == 0 ? $row['price'] * $row['quantity'] + $row['tax_amount'] : $row['discounted_price'] * $row['quantity'] + $row['tax_amount'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-warning'>Pending</label>";
        if ($row['status'] == 1)
            $tempRow['status'] = "<label class='label label-primary'>Approved</label>";
        if ($row['status'] == 2)
            $tempRow['status'] = "<label class='label label-danger'>Cancelled</label>";
        $tempRow['operate'] = $operate;
        $tempRow['date_created'] = $row['date_created'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SYSTEM_USERS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'system-users') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'ASC';
    $where = '';
    $condition = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `username` like '%" . $search . "%' OR `email` like '%" . $search . "%' OR `role` like '%" . $search . "%' OR `date_created` like '%" . $search . "%'";
    }
    if ($_SESSION['role'] != 'super admin') {
        if (empty($where)) {
            $condition .= ' where created_by=' . $_SESSION['id'];
        } else {
            $condition .= ' and created_by=' . $_SESSION['id'];
        }
    }

    $sql = "SELECT COUNT(id) as total FROM `admin`" . $where . "" . $condition;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `admin`" . $where . "" . $condition . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        if ($row['created_by'] != 0) {
            $sql = "SELECT username FROM admin WHERE id=" . $row['created_by'];
            $db->sql($sql);
            $created_by = $db->getResult();
        }

        if ($row['role'] != 'super admin') {
            $operate = "<a class='btn btn-xs btn-primary edit-system-user' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editSystemUserModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
            $operate .= " <a class='btn btn-xs btn-danger delete-system-user' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";
        } else {
            $operate = '';
        }
        if ($row['role'] == 'super admin') {
            $role = '<span class="label label-success">Super Admin</span>';
        }
        if ($row['role'] == 'admin') {
            $role = '<span class="label label-primary">Admin</span>';
        }
        if ($row['role'] == 'editor') {
            $role = '<span class="label label-warning">Editor</span>';
        }
        $tempRow['id'] = $row['id'];
        $tempRow['username'] = $row['username'];
        $tempRow['email'] = $row['email'];
        $tempRow['permissions'] = $row['permissions'];
        $tempRow['role'] = $role;
        $tempRow['created_by_id'] = $row['created_by'] != 0 ? $row['created_by'] : '-';
        $tempRow['created_by'] = $row['created_by'] != 0 ? $created_by[0]['username'] : '-';
        $tempRow['date_created'] = date('d-m-Y h:i:sa', strtotime($row['date_created']));
        $tempRow['operate'] = $operate;

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'WALLET_TRANSACTIONS Transactions' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'wallet-transactions') {

    $offset = 0;
    $limit = 10;
    $sort = 'w.id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where w.`id` like '%" . $search . "%' OR `user_id` like '%" . $search . "%' OR `message` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `date_created` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `wallet_transactions` w JOIN `users` u ON u.id=w.user_id " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT w.*,u.name FROM `wallet_transactions` w JOIN `users` u ON u.id=w.user_id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $tempRow['id'] = $row['id'];
        $tempRow['user_id'] = $row['user_id'];
        $tempRow['name'] = $row['name'];
        $tempRow['type'] = $row['type'];
        $tempRow['amount'] = $row['amount'];
        $tempRow['message'] = $row['message'];
        $tempRow['date_created'] = $row['date_created'];
        $tempRow['las_updated'] = $row['last_updated'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-danger'>Deactive</label>";
        else
            $tempRow['status'] = "<label class='label label-success'>Active</label>";
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'WITHDRAWAL_REQUESTS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'withdrawal-requests') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['type']) && $_GET['type'] != '') {
        $type = $db->escapeString($fn->xss_clean($_GET['type']));
        $where .= empty($where) ? " WHERE type = '" . $type . "'" : " and type = '" . $type . "'";
    }

    if (isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'user') {
        $sql = "SELECT COUNT(w.id) as total FROM `withdrawal_requests` w LEFT JOIN users u ON w.type_id=u.id" . $where;
    } elseif (isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'delivery_boy') {
        $sql = "SELECT COUNT(w.id) as total FROM `withdrawal_requests` w LEFT JOIN delivery_boys d ON w.type_id=d.id" . $where;
    } else {
        $sql = "SELECT COUNT(id) as total FROM `withdrawal_requests`" . $where;
    }
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
    if (isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'user') {
        $sql = "SELECT * FROM withdrawal_requests" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    } elseif (isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'delivery_boy') {
        $sql = "SELECT * FROM withdrawal_requests" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    } else {
        $sql = "SELECT * FROM `withdrawal_requests`" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    }
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        if ($row['type'] == 'user') {
            $sql = "select name,balance from users where id=" . $row['type_id'];
        } else {
            $sql = "select name,balance from delivery_boys where id=" . $row['type_id'];
        }
        $db->sql($sql);
        $res1 = $db->getResult();
        $operate = "<a class='btn btn-xs btn-primary edit-withdrawal-request' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editWithdrawalRequestModal' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";
        $operate .= " <a class='btn btn-xs btn-danger delete-withdrawal-request' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['type'] = $row['type'] == 'delivery_boy' ? 'Delivery Boy' : 'User';
        $tempRow['type_id'] = $row['type_id'];
        $tempRow['amount'] = $row['amount'];
        $tempRow['balance'] = $res1[0]['balance'];
        $tempRow['message'] = empty($row['message']) ? '-' : $row['message'];
        $tempRow['name'] = !empty($res1[0]['name']) ? $res1[0]['name'] : "";

        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-warning'>Pending</label>";
        if ($row['status'] == 1)
            $tempRow['status'] = "<label class='label label-primary'>Approved</label>";
        if ($row['status'] == 2)
            $tempRow['status'] = "<label class='label label-danger'>Cancelled</label>";
        $tempRow['operate'] = $operate;
        $tempRow['date_created'] = $row['date_created'];
        $tempRow['last_updated'] = $row['last_updated'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SALES_REPORTS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'sales_reports') {
    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = ' ';
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $db->escapeString($fn->xss_clean($_GET['start_date']));
        $end_date = $db->escapeString($fn->xss_clean($_GET['end_date']));
        $where .= " where DATE(date_added)>=DATE('" . $start_date . "') AND DATE(date_added)<=DATE('" . $end_date . "')";
    } else {
        $where .= " WHERE date_added > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    }

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " AND (o.id like '%" . $search . "%' OR o.mobile like '%" . $search . "%' OR u.name like '%" . $search . "%' OR address like '%" . $search . "%' OR date_added like '%" . $search . "%' OR `final_total` like '%" . $search . "%')";
    }
    $sql = "SELECT COUNT(o.id) as total FROM `orders` o LEFT JOIN users u ON u.id=o.user_id" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row) {
        $total = $row['total'];
    }
    $sql = "select o.id,o.user_id,o.mobile,o.address,o.date_added,o.final_total,u.name FROM orders o left join users u on u.id=o.user_id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {

        $tempRow['id'] = $row['id'];
        $tempRow['user_id'] = $row['user_id'];
        $tempRow['name'] = $row['name'];
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['mobile'] = str_repeat("*", strlen($row['mobile']) - 3) . substr($row['mobile'], -3);
        } else {
            $tempRow['mobile'] = $row['mobile'];
        }
        $tempRow['address'] = $row['address'];
        $tempRow['final_total'] = $row['final_total'];
        $tempRow['date_added'] = date('d-m-Y', strtotime($row['date_added']));
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'INVOICE_REPORTS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'invoice_reports') {
    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = ' ';
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $db->escapeString($fn->xss_clean($_GET['start_date']));
        $end_date = $db->escapeString($fn->xss_clean($_GET['end_date']));
        $where .= " where DATE(invoice_date) >= DATE('" . $start_date . "') AND DATE(invoice_date) <= DATE('" . $end_date . "')";
    } else {
        $where .= " WHERE invoice_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    }

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " AND (name like '%" . $search . "%' OR i.id like '%" . $search . "%' OR invoice_date like '%" . $search . "%' OR order_id like '%" . $search . "%' OR i.address like '%" . $search . "%' OR `order_date` like '%" . $search . "%'  OR `phone_number` like '%" . $search . "%' OR `order_list` like '%" . $search . "%' OR `email` like '%" . $search . "%' OR i.`discount` like '%" . $search . "%' OR `total_sale` like '%" . $search . "%' OR shipping_charge LIKE '%" . $search . "%' OR payment LIKE '%" . $search . "%')";
    }
    $sql = "SELECT COUNT(i.id) as total FROM invoice i" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row) {
        $total = $row['total'];
    }
    $sql = "SELECT i.*,o.tax_amount,o.tax_percentage,o.wallet_balance,o.promo_code,o.promo_discount,o.total FROM invoice i LEFT JOIN orders o ON o.id=i.order_id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    for ($i = 0; $i < count($res); $i++) {
        $sql = "select oi.*,p.name as name, u.name as uname,v.measurement, (SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name,(SELECT status FROM orders o where o.id=oi.order_id)as order_status from `order_items` oi 
			    join product_variant v on oi.product_variant_id=v.id 
			    join products p on p.id=v.product_id 
			    JOIN users u ON u.id=oi.user_id 
			    where oi.order_id=" . $res[$i]['order_id'];
        $db->sql($sql);
        $res[$i]['items'] = $db->getResult();
    }
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();
    $temp = '';
    $total_amt = 0;
    foreach ($res as $row) {
        $items = $row['items'];
        foreach ($items as $item) {
            $temp .= "<b>Item ID :</b>" . $item['id'] . "<b> Product Variant Id :</b> " . $item['product_variant_id'] . "<b> Name : </b>" . $item['name'] . " <b>Unit : </b>" . $item['measurement'] . $item['mesurement_unit_name'] . " <b>Price : </b>" . $item['price'] . " <b>QTY : </b>" . $item['quantity'] . " <b>Subtotal : </b>" . $item['quantity'] * $item['price'] . "<br>------<br>";
            $total_amt += $item['sub_total'];
        }
        if (is_numeric($row['discount'])) {
            $discounted_amount = $row['total'] * $row['discount'] / 100; /*  */
            $final_total = $row['total'] - $discounted_amount;
            $discount_in_rupees = $row['total'] - $final_total;
            $discount_in_rupees = floor($discount_in_rupees);
            $tempRow['discount'] = $discount_in_rupees . '(' . $row['discount'] . '%)';
        } else {
            $tempRow['discount'] = 0;
        }
        $tempRow['id'] = $row['id'];
        $tempRow['invoice_date'] = date('d-m-Y', strtotime($row['invoice_date']));
        $tempRow['order_id'] = $row['order_id'];
        $tempRow['name'] = $row['name'];
        $tempRow['address'] = $row['address'];
        $tempRow['order_date'] = date('d-m-Y h:i:s', strtotime($row['order_date']));
        if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
            $tempRow['phone_number'] = str_repeat("*", strlen($row['phone_number']) - 3) . substr($row['phone_number'], -3);
            $tempRow['email'] = str_repeat("*", strlen($row['email']) - 13) . substr($row['email'], -13);
        } else {
            $tempRow['email'] = $row['email'];
            $tempRow['phone_number'] = $row['phone_number'];
        }

        $tempRow['items'] = $temp;
        $tempRow['tax'] = $row['tax_amount'] . '(' . $row['tax_percentage'] . '%)';
        $tempRow['promo_discount'] = $row['promo_discount'];
        $tempRow['wallet_balance'] = $row['wallet_balance'];
        // $tempRow['discount'] = $discount_in_rupees . '(' . $row['discount'] . '%)';
        $tempRow['promo_code'] = $row['promo_code'];
        $tempRow['total_sale'] = $row['total'];
        $tempRow['shipping_charge'] = $row['shipping_charge'];
        $tempRow['payment'] = ceil($row['payment']);
        $tempRow['action'] = '<a href="order-detail.php?id=' . $row['order_id'] . '" title="View Order"><i class="fa fa-folder-open"></i>&nbsp;Order&nbsp;</a> <a href="invoice.php?id=' . $row['order_id'] . '"><i class="fa fa-eye" title="View Invoice"></i>&nbsp;Invoice</a>';

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'TAXES' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'taxes') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `title` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `taxes` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `taxes` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-tax.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-tax.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['percentage'] = $row['percentage'];
        if ($row['status'] == 0)
            $tempRow['status'] = "<label class='label label-danger'>Deactive</label>";
        else
            $tempRow['status'] = "<label class='label label-success'>Active</label>";;
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'PRODUCT_SALES_REPORT' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'product_sales_report') {
    $where = ' ';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';
    $currency = $fn->get_settings('currency', false);
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $db->escapeString($fn->xss_clean($_GET['start_date']));
        $end_date = $db->escapeString($fn->xss_clean($_GET['end_date']));
        if (!empty($where)) {
            $where .= " AND DATE(oi.date_added)>=DATE('" . $start_date . "') AND DATE(oi.date_added)<=DATE('" . $end_date . "')";
        } else {
            $where .= " WHERE DATE(oi.date_added)>=DATE('" . $start_date . "') AND DATE(oi.date_added)<=DATE('" . $end_date . "')";
        }
    } else {
        if (!empty($where)) {
            $where .= " AND oi.date_added > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        } else {
            $where .= " WHERE oi.date_added > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        }
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        if (!empty($where)) {
            $where .= " AND (oi.id like '%" . $search . "%' OR pv.id like '%" . $search . "%' OR p.name like '%" . $search . "%' OR u.name like '%" . $search . "%' )";
        } else {
            $where .= " WHERE (oi.id like '%" . $search . "%' OR pv.id like '%" . $search . "%' OR p.name like '%" . $search . "%' OR u.name like '%" . $search . "%' )";
        }
    }
    if (isset($_GET['filter_order']) && $_GET['filter_order'] != '') {
        $filter_order = $db->escapeString($fn->xss_clean($_GET['filter_order']));
        if (!empty($where)) {
            $where .= " AND oi.`active_status`='" . $filter_order . "'";
        } else {
            $where .= " WHERE oi.`active_status`='" . $filter_order . "'";
        }
    }

    $sql = "SELECT pv.product_id,p.name as p_name, pv.measurement,u.short_code as u_name,oi.*, 
    (SELECT count(oi.product_variant_id) FROM `order_items` oi where pv.id = oi.product_variant_id $where) as total_sales, 
    (SELECT SUM(oi.sub_total) FROM `order_items` oi where pv.id = oi.product_variant_id $where) as total_price
    FROM `order_items` oi join `product_variant` pv ON oi.product_variant_id=pv.id join products p ON pv.product_id=p.id join unit u on pv.measurement_unit_id=u.id WHERE oi.`active_status`!= 'cancelled' AND oi.`active_status` != 'returned' $where GROUP by (pv.id) ";
    $db->sql($sql);
    $res1 = $db->getResult();
    $total = $db->numRows($res1);

    $sql .= " ORDER BY $sort $order LIMIT $offset, $limit ";
    $db->sql($sql);
    $res = $db->getResult();

    $tempRow = $bulkData = $rows = array();
    $bulkData['total'] = $total;
    foreach ($res as $row) {
        $tempRow['product_name'] = $row['p_name'];
        $tempRow['product_varient_id'] = $row['product_variant_id'];
        $tempRow['unit_name'] = $row['measurement'] . ' ' . $row['u_name'];
        $tempRow['total_sales'] = $row['total_sales'];
        $tempRow['total_price'] = $currency . ' ' . number_format($row['total_price']);
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'NEWSLETTER' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'newsletter') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `email` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `newsletter` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `newsletter` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = $tempRow = array();

    foreach ($res as $row) {
        $tempRow['id'] = $row['id'];
        $tempRow['email'] = $row['email'];
        $tempRow['created_at'] = $row['created_at'];

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'BLOGS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'blogs') {
    // print_r($_GET);

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `title` like '%" . $search . "%' OR `description` like '%" . $search . "%' ";
    }
    if (isset($_GET['category_id']) && $_GET['category_id'] != '') {
        $category_id = $db->escapeString($fn->xss_clean($_GET['category_id']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and b.`category_id`=' . $category_id;
        else
            $where = ' where b.`category_id`=' . $category_id;
    }

    $sql = "SELECT COUNT(b.`id`) as total FROM `blogs` b  LEFT JOIN blog_categories bc on bc.id = b.category_id" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT b.*,bc.name as category_name FROM `blogs` b LEFT JOIN blog_categories bc on bc.id = b.category_id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-blog.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-blog.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['category_name'] = $row['category_name'];
        $tempRow['description'] = $row['description'];
        $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['title'] . "'><img src='" . $row['image'] . "' title='" . $row['title'] . "' height='50' /></a>";
        $tempRow['date_created'] = date("Y-m-d", strtotime($row['date_created']));
        $tempRow['status'] = ($row['status']) ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Deactive</label>';
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'PRODUCT_ADVERTISEMENT' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'product_advt') {

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `ad1` like '%" . $search . "%' OR `ad2` like '%" . $search . "%' OR `ad3` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `product_ads` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `product_ads` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-product-advt.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-product-advt.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['ad1'] = "<a data-lightbox='category' href='" . DOMAIN_URL . 'upload/product-advt/' . $row['ad1'] . "' data-caption='" . $row['ad1'] . "'><img src='" . DOMAIN_URL . 'upload/product-advt/' . $row['ad1'] . "' title='" . $row['ad1'] . "' height='50' /></a>";
        $tempRow['ad2'] = "<a data-lightbox='category' href='" . DOMAIN_URL . 'upload/product-advt/' . $row['ad2'] . "' data-caption='" . $row['ad2'] . "'><img src='" . DOMAIN_URL . 'upload/product-advt/' . $row['ad2'] . "' title='" . $row['ad2'] . "' height='50' /></a>";
        $tempRow['ad3'] = "<a data-lightbox='category' href='" . DOMAIN_URL . 'upload/product-advt/' . $row['ad3'] . "' data-caption='" . $row['ad3'] . "'><img src='" . DOMAIN_URL . 'upload/product-advt/' . $row['ad3'] . "' title='" . $row['ad3'] . "' height='50' /></a>";

        $tempRow['date_created'] = date("Y-m-d", strtotime($row['date_created']));

        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'flash_sales') {

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `title` like '%" . $search . "%' OR `date_added` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(*) as total FROM `flash_sales` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `flash_sales` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = "<a class='btn btn-xs btn-primary edit-flash-sales' data-id='" . $row['id'] . "' title='Edit'><i class='fa fa-pencil-square-o'></i></a>";

        $operate .= " <a class='btn btn-xs btn-danger delete-flash-sales' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['short_description'] = $row['short_description'];
        $tempRow['status'] = ($row['status']) ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Deactive</label>';
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'flash_sales_products') {

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where fp.`id` like '%" . $search . "%' OR p.`name` like '%" . $search . "%' OR fs.`title` like '%" . $search . "%' ";
    }

    if (isset($_GET['flash_sales_id']) && $_GET['flash_sales_id'] != '') {
        $flash_sales_id = $db->escapeString($fn->xss_clean($_GET['flash_sales_id']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and fp.`flash_sales_id`=' . $flash_sales_id;
        else
            $where = ' where fp.`flash_sales_id`=' . $flash_sales_id;
    }

    $sql = "SELECT * FROM `flash_sales_products`";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row) {
        $time = date("Y-m-d H:i:s");
        $time1 = $row['start_date'];
        $time2 = $row['end_date'];

        $row_time['is_date_created'] = strtotime("$time");
        $row_time['is_start_date'] = strtotime("$time1");
        $row_time['is_end_date'] = strtotime("$time2");

        if ($row_time['is_start_date'] < $row_time['is_date_created'] && $row_time['is_end_date'] < $row_time['is_date_created']) {
            $sql1 = "UPDATE flash_sales_products SET status = 0 where id =" . $row['id'];
            $db->sql($sql1);
            $res = $db->getResult();
        }
    }

    // $sql = "SELECT * FROM `flash_sales_products` WHERE DATE(NOW()) >= DATE(end_date)";
    // $db->sql($sql);
    // $res = $db->getResult();
    // $count = $db->numRows($res);
    // foreach ($res as $row) {
    //     $sql1 = "UPDATE flash_sales_products SET status = 0 where id =" . $row['id'];
    //     $db->sql($sql1);
    //     $res = $db->getResult();
    // }

    $sql = "SELECT COUNT(fp.id) as total FROM `flash_sales_products` fp" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT fp.*,fs.title as flash_sales_name,p.name as product_name,pv.measurement,u.short_code FROM `flash_sales_products` fp JOIN flash_sales fs ON fs.id = fp.flash_sales_id JOIN products p ON p.id=fp.product_id JOIN product_variant pv ON pv.id=fp.product_variant_id JOIN unit u ON pv.measurement_unit_id=u.id" . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = "<a class='btn btn-xs btn-primary edit_flash_sales_products' data-id='" . $row['id'] . "' title='Edit'  data-toggle='modal' data-target='#edit_flash_sales_products'><i class='fa fa-pencil-square-o'></i></a>&nbsp;";
        $operate .= "<a class='btn btn-xs btn-danger delete-flash-sales-products' data-id='" . $row['id'] . "' title='Delete'><i class='fa fa-trash-o'></i></a>";

        $tempRow['id'] = $row['id'];
        $tempRow['flash_sales_id'] = $row['flash_sales_id'];
        $tempRow['flash_sales_name'] = $row['flash_sales_name'];
        $tempRow['product_id'] = $row['product_id'];
        $tempRow['product_name'] = $row['product_name'];
        $tempRow['product_variant_id'] = $row['product_variant_id'];
        $tempRow['Measurement'] = $row['measurement'] . " " . $row['short_code'];
        $tempRow['price'] = $row['price'];
        $tempRow['discounted_price'] = $row['discounted_price'];
        $tempRow['start_date'] = $row['start_date'];
        $tempRow['end_date'] = $row['end_date'];
        $tempRow['status'] = ($row['status']) ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Deactive</label>';
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'BLOGS CATEGORIES' table goes here

if (isset($_GET['table']) && $_GET['table'] == 'blog_categories') {

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' ";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `blog_categories` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `blog_categories` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-blog-category.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-blog-category.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='" . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";
        $tempRow['date_added'] = date("Y-m-d", strtotime($row['date_added']));
        $tempRow['status'] = ($row['status']) ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Deactive</label>';
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

//data of complaints table

if (isset($_GET['table']) && $_GET['table'] == 'complaints') {
    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'ASC';
    $where = '';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        if ($_GET['sort'] == 'id') {
            $sort = "id";
        } else {
            $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
        }
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) and $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " where (c.`id` like '%" . $search . "%' OR c.`title` like '%" . $search . "%' OR c.`message` like '%" . $search . "%' OR c.`email` like '%" . $search . "%' OR c.`status` like '%" . $search . "%' )";
    }

    $sql = "SELECT COUNT(id) as `total` FROM `complaints` c " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
    $sql = "SELECT c.id AS id, c.title,c.message,c.email,c.status,(select type From complaint_type ct WHERE ct.id=c.type_id ) as complaint_type,c.image 
            FROM `complaints` c
            $where ORDER BY $sort $order LIMIT $offset, $limit";
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();


    foreach ($res as $row) {
        if ($row['status'] == 'open') {
            $status = '<label class="label label-primary">Open</label>';
        }
        if ($row['status'] == 'closed') {
            $status = '<label class="label label-danger">Closed</label>';
        }
        if ($row['status'] == 'reopen') {
            $status = '<label class="label label-warning">Reopen</label>';
        }
        if ($row['status'] == 'resolved') {
            $status = '<label class="label label-success">Resolved</label>';
        }

        $operate = '<a href="support-view.php?id=' . $row['id'] . '" target="blank" title="View"><i class="fa fa-folder-open"></i></a>';

        $operate .= ' <a class="btn btn-xs btn-danger" href="delete-complaints.php?id=' . $row['id'] . '" title="Delete"><i class="fa fa-trash-o"></i></a>&nbsp;';

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['message'] = $row['message'];
        $tempRow['image'] = "<a data-lightbox='complaints' href='" . $row['image'] . "' data-caption='" . $row['title'] . "'><img src='" . $row['image'] . "' title='" . $row['title'] . "' height='50' /></a>";
        $tempRow['email'] = $row['email'];
        $tempRow['status'] = $status;
        $tempRow['type'] = $row['complaint_type'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'ratings') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where pr.`id` like '%" . $search . "%' OR pr.`review` like '%" . $search . "%' OR pr.`user_id` like '%" . $search . "%' ";
    }

    if (isset($_GET['product_id']) && $_GET['product_id'] != '') {
        $product_id = $db->escapeString($fn->xss_clean($_GET['product_id']));
        if (!empty($where)) {
            $where .= ' and pr.`product_id`=' . $product_id;
        } else {
            $where = ' where pr.`product_id`=' . $product_id;
        }
    }

    $sql = "SELECT COUNT(id) as `total` FROM `product_reviews` pr " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
    $sql = "SELECT * FROM `product_reviews` pr $where ORDER BY $sort $order LIMIT $offset, $limit";
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $tempRow['id'] = $row['id'];
        $tempRow['product_id'] = $row['product_id'];
        $tempRow['user_id'] = $row['user_id'];
        $tempRow['rate'] = '<input type="text" class="ratings rating-loading" value="' . $row['rate'] . '" data-size="xs" title="" readonly>';
        $tempRow['review'] = $row['review'];

        $i = 0;
        if (isset($row['images']) && !empty($row['images'])) {
            $images = json_decode($row['images']);
            $tempRow['images'] = '';
            for ($j = 0; $j < count($images); $j++) {
                $image_unique_name = 'rating-image-' . $i;
                $image_url  =  $images[$j];
                if ($j == 0) {
                    $counter = count($images) - 1;
                    $counter = (count($images) > 1) ? '+ ' . $counter : ' ';
                    $tempRow['images'] = '<div class="row"><div class="col-md-6"><div class="product-image "><a href=' . $image_url . ' data-lightbox="category" > <img src=' . $image_url . ' class="img-fluid rounded" height="50"> </a></div></div><div class="col-md-6 my-auto "></div></div>';
                } else {
                    $tempRow['images'] .= '<div class="mx-auto product-image d-none"><a href=' . $image_url . ' data-lightbox="category"><img src=' . $image_url . ' class="img-fluid rounded" height="50"></a></div>';
                }
            }
        } else {
            $tempRow['images'] = '-';
        }
        $tempRow['status'] = ($row['status']) ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Deactive</label>';
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'Cities' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'Cities') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `city` $where";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `city` $where ORDER BY $sort $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a href="edit-city.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>&nbsp;';
        $operate .= ' <a href="delete-city.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'transaction') {

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where t.`id` like '%" . $search . "%' OR u.`name` like '%" . $search . "%'";
    }

    $sql = "SELECT count(t.id) as total FROM transactions t LEFT JOIN users u ON t.user_id = u.id $where";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT t.*,u.name FROM transactions t LEFT JOIN users u ON t.user_id = u.id $where ORDER BY $sort $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['order_id'] = $row['order_id'];
        $tempRow['type'] = $row['type'];
        $tempRow['txn_id'] = $row['txn_id'];
        $tempRow['amount'] = $row['amount'];
        $tempRow['status'] = $row['status'];
        $tempRow['message'] = $row['message'];
        $tempRow['transaction_date'] = $row['transaction_date'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

// data of 'test_form' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'test_form') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `test_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `test_form` " . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate = ' <a href="createDietPlan.php?id=' . $row['id'] . '&userId=' . $row['user_id'] . '"><i class="fa fa-edit"></i>Generate PDF</a><br>';
        //$operate .= ' <a class="btn-xs btn-danger" href="delete-customerEnquiry.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /*
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option value="createDietPlan.php?id=' . $row['id'] . '&userId=' . $row['user_id'] . '">Generate Diet Plan</option>
        <option value="viewPDF.php?id=' . $row['user_id'] . '">View Diet Plan</option>
		<option value="image.php?id=' . $row['user_id'] . '">View Diet Images</option>
        </select>';
        */
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['email'] = $row['email'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['age'] = $row['age'];
        $tempRow['weight'] = $row['weight'];
        $tempRow['height'] = $row['height'];
        $tempRow['address'] = $row['address'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['gender'] = $row['gender'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'emp_joining_form' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'emp_joining_form') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_joining_form` " . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        $operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        $operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        $operate .= ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['father_name'] = $row['father_name'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['age'] = $row['age'];
        $tempRow['blood_group'] = $row['blood_group'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mobile'] = $row['alt_mobile'];
        $tempRow['marital_status'] = $row['marital_status'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['aadhar_no'] = $row['aadhar_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        $tempRow['esic_no'] = $row['esic_no'];
        $tempRow['uan_no'] = $row['uan_no'];
        $tempRow['identification_mark'] = $row['identification_mark'];
        $tempRow['permanant_address'] = $row['permanant_address'];
        $tempRow['present_address'] = $row['present_address'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['acc_holder_name'] = $row['acc_holder_name'];
        $tempRow['acc_no'] = $row['acc_no'];
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        $tempRow['place'] = $row['place'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_post'] = $row['emp_post'];
        $tempRow['salary'] = $row['salary'];
        $tempRow['spl_allowance'] = $row['spl_allowance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'family' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'family') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `emp_id` like '%" . $search . "%' OR `family_name` like '%" . $search . "%' OR `family_age` like '%" . $search . "%' OR `family_relation` like '%" . $search . "%' OR `family_remark` like '%" . $search . "%' OR `created_at` like '%" . $search . "%'";
    }

    if (isset($_GET['emp_id']) && !empty($_GET['emp_id'])) {
        $emp_id = $db->escapeString($fn->xss_clean($_GET['emp_id']));
        $where .= !empty($where) ? ' AND emp_id = ' . $emp_id : ' WHERE emp_id = ' . $emp_id;
    }
    $sql = "SELECT COUNT(emp_id) as total FROM `family`" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `family`" . $where . " ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $tempRow['id'] = $row['id'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['family_name'] = $row['family_name'];
        $tempRow['family_age'] = $row['family_age'];
        $tempRow['family_relation'] = $row['family_relation'];
        $tempRow['family_remark'] = $row['family_remark'];
        $tempRow['created_at'] = $row['created_at'];

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'CUST' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'cust') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mob` like '%" . $search . "%' OR `email` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `address` like '%" . $search . "%' OR `city` like '%" . $search . "%' OR `area` like '%" . $search . "%' OR `state` like '%" . $search . "%' OR `pincode` like '%" . $search . "%' OR `ship_add` like '%" . $search . "%' OR `status` like '%" . $search . "%' OR `created_at` like '%" . $search . "%'";
    }
    if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] != '') {
        $filter_order = $db->escapeString($fn->xss_clean($_GET['filter_order']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and active_status=' . $filter_order;
        else
            $where = ' where active_status=' . $filter_order;
    }

    $sql = "SELECT COUNT(id) as total FROM `cust` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `cust`" . $where . " ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-cust.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>&nbsp;';
        $operate .= ' <a href="delete-cust.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';
        if ($row['status'] == 1) {
            $operate .= "<a class='btn btn-xs btn-warning set-product-deactive' data-id='" . $row['id'] . "' title='Hide'>  <i class='fa fa-eye'></i> </a>";
        } elseif ($row['status'] == 0) {
            $operate .= "<a class='btn btn-xs btn-success set-product-active' data-id='" . $row['id'] . "' title='Show'>  <i class='fa fa-eye-slash'></i> </a>";
        }

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mob'] = $row['alt_mob'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['email'] = $row['email'];
        $tempRow['address'] = $row['address'];
        $tempRow['city'] = $row['city'];
        $tempRow['area'] = $row['area'];
        $tempRow['state'] = $row['state'];
        $tempRow['pincode'] = $row['pincode'];
        $tempRow['ship_add'] = $row['ship_add'];
        $tempRow['status'] = $row['status'] == 1 ? "<label class='label label-success'>Active</label>" : "<label class='label label-danger'>De-Active</label>";
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'SUPPLIER' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'supplier') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mob` like '%" . $search . "%' OR `tax_no` like '%" . $search . "%' OR `email` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `address` like '%" . $search . "%' OR `city` like '%" . $search . "%' OR `area` like '%" . $search . "%' OR `state` like '%" . $search . "%' OR `pincode` like '%" . $search . "%' OR `ship_add` like '%" . $search . "%' OR `status` like '%" . $search . "%' OR `created_at` like '%" . $search . "%'";
    }
    if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] != '') {
        $filter_order = $db->escapeString($fn->xss_clean($_GET['filter_order']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and active_status=' . $filter_order;
        else
            $where = ' where active_status=' . $filter_order;
    }

    $sql = "SELECT COUNT(id) as total FROM `supplier` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `supplier`" . $where . " ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-supplier.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>&nbsp;';
        $operate .= ' <a href="delete-supplier.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';
        if ($row['status'] == 1) {
            $operate .= "<a class='btn btn-xs btn-warning set-product-deactive' data-id='" . $row['id'] . "' title='Hide'>  <i class='fa fa-eye'></i> </a>";
        } elseif ($row['status'] == 0) {
            $operate .= "<a class='btn btn-xs btn-success set-product-active' data-id='" . $row['id'] . "' title='Show'>  <i class='fa fa-eye-slash'></i> </a>";
        }

        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mob'] = $row['alt_mob'];
        $tempRow['tax_no'] = $row['tax_no'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['email'] = $row['email'];
        $tempRow['address'] = $row['address'];
        $tempRow['city'] = $row['city'];
        $tempRow['area'] = $row['area'];
        $tempRow['state'] = $row['state'];
        $tempRow['pincode'] = $row['pincode'];
        $tempRow['ship_add'] = $row['ship_add'];
        $tempRow['status'] = $row['status'] == 1 ? "<label class='label label-success'>Active</label>" : "<label class='label label-danger'>De-Active</label>";
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'labours_salary_list' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'labours_salary_list') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';
    //$m = (isset($_GET['month'])) ? $db->escapeString($fn->xss_clean($_GET['month'])) : "";
    //$y = (isset($_GET['year'])) ? $db->escapeString($fn->xss_clean($_GET['year'])) : "";
    //$m = 'september';
    //$y = '2022';
    //$datetime = date("Y-m-d H:i:s");
    //$date = date('Y-m-d');
    //$date = strtotime("$m $y");

    //$start_date = date('Y-m-01', $date);
    //$end_date  = date('Y-m-t', $date);
    //$currency = $fn->get_settings('currency', false);

    if (!empty($_GET['month']) && !empty($_GET['year'])) {
        $m = $db->escapeString($fn->xss_clean($_GET['month']));
        $y = $db->escapeString($fn->xss_clean($_GET['year']));

        $date = strtotime("$m $y");

        $start_date = date('Y-m-01', $date);
        $end_date  = date('Y-m-t', $date);

        //$start_date = '2022-09-01'; //date('Y-m-01', $date);
        //$end_date  = '2022-09-30'; //date('Y-m-t', $date);

        if (!empty($where)) {
            $where .= " AND DATE(date)>=DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "')";
        } else {
            $where .= " WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "')";
        }
    } else {
        if (!empty($where)) {
            $where .= " AND date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        } else {
            $where .= " WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        }
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        if (!empty($where)) {
            $where .= " AND (eid like '%" . $search . "%' OR emp_attendance.emp_no like '%" . $search . "%' OR salary.emp_post like '%" . $search . "%' )";
        } else {
            $where .= " WHERE (eid like '%" . $search . "%' OR emp_attendance.emp_no like '%" . $search . "%' OR salary.emp_post like '%" . $search . "%' )";
        }
    }


    $sql = "SELECT salary.*, emp_joining_form.emp_type_id, emp_attendance.emp_no, SUM(emp_attendance.tot_hours) AS tot_atten_hrs, emp_attendance.emp_id AS eid, SUM(emp_attendance.hours) AS tot_hrs, SUM(emp_attendance.ot_hours) AS tot_ot_hrs FROM `salary` INNER JOIN `emp_attendance` ON emp_attendance.emp_id = salary.emp_id INNER JOIN `emp_joining_form` ON emp_joining_form.id = emp_attendance.emp_id WHERE DATE(emp_attendance.date)>= DATE('" . $start_date . "') AND DATE(emp_attendance.date)<=DATE('" . $end_date . "') AND emp_joining_form.emp_type_id = '2' GROUP BY emp_id";
    $db->sql($sql);
    $res1 = $db->getResult();
    $total = $db->numRows($res1);

    $sql .= " ORDER BY $sort $order LIMIT $offset, $limit ";
    $db->sql($sql);
    $res = $db->getResult();

    $tempRow = $bulkData = $rows = array();
    $bulkData['total'] = $total;
    foreach ($res as $row) {

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
        //$tempRow['eid'] = $row['eid'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'staff_salary_list' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'staff_salary_list') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';
    //$m = (isset($_GET['month'])) ? $db->escapeString($fn->xss_clean($_GET['month'])) : "";
    //$y = (isset($_GET['year'])) ? $db->escapeString($fn->xss_clean($_GET['year'])) : "";
    //$m = 'september';
    //$y = '2022';
    //$datetime = date("Y-m-d H:i:s");
    //$date = date('Y-m-d');
    //$date = strtotime("$m $y");

    //$start_date = date('Y-m-01', $date);
    //$end_date  = date('Y-m-t', $date);
    //$currency = $fn->get_settings('currency', false);

    if (!empty($_GET['month']) && !empty($_GET['year'])) {
        $m = $db->escapeString($fn->xss_clean($_GET['month']));
        $y = $db->escapeString($fn->xss_clean($_GET['year']));

        $date = strtotime("$m $y");

        $start_date = date('Y-m-01', $date);
        $end_date  = date('Y-m-t', $date);

        //$start_date = '2022-09-01'; //date('Y-m-01', $date);
        //$end_date  = '2022-09-30'; //date('Y-m-t', $date);

        if (!empty($where)) {
            $where .= " AND DATE(date)>=DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "')";
        } else {
            $where .= " WHERE DATE(date)>= DATE('" . $start_date . "') AND DATE(date)<=DATE('" . $end_date . "')";
        }
    } else {
        if (!empty($where)) {
            $where .= " AND date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        } else {
            $where .= " WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        }
    }
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        if (!empty($where)) {
            $where .= " AND (eid like '%" . $search . "%' OR emp_attendance.emp_no like '%" . $search . "%' OR salary.emp_post like '%" . $search . "%' )";
        } else {
            $where .= " WHERE (eid like '%" . $search . "%' OR emp_attendance.emp_no like '%" . $search . "%' OR salary.emp_post like '%" . $search . "%' )";
        }
    }


    $sql = "SELECT salary.*, emp_joining_form.emp_type_id, emp_attendance.emp_no, SUM(emp_attendance.tot_hours) AS tot_atten_hrs, emp_attendance.emp_id AS eid, SUM(emp_attendance.hours) AS tot_hrs, SUM(emp_attendance.ot_hours) AS tot_ot_hrs FROM `salary` INNER JOIN `emp_attendance` ON emp_attendance.emp_id = salary.emp_id INNER JOIN `emp_joining_form` ON emp_joining_form.id = emp_attendance.emp_id WHERE DATE(emp_attendance.date)>= DATE('" . $start_date . "') AND DATE(emp_attendance.date)<=DATE('" . $end_date . "') AND emp_joining_form.emp_type_id = '1' GROUP BY emp_id";
    $db->sql($sql);
    $res1 = $db->getResult();
    $total = $db->numRows($res1);

    $sql .= " ORDER BY $sort $order LIMIT $offset, $limit ";
    $db->sql($sql);
    $res = $db->getResult();

    $sql = "SELECT emp_joining_form.emp_type_id, emp_attendance.emp_no, COUNT(emp_attendance.attendance) FROM `emp_joining_form` INNER JOIN `emp_attendance` ON emp_attendance.emp_id = emp_joining_form.id WHERE DATE(emp_attendance.date)>= DATE('" . $start_date . "') AND DATE(emp_attendance.date)<=DATE('" . $end_date . "') AND emp_joining_form.emp_type_id = '1' AND emp_attendance.attendance = 'present' GROUP BY emp_id";
    $db->sql($sql);
    $result = $db->getResult();

    $sql = "SELECT emp_joining_form.emp_type_id, emp_attendance.emp_no, COUNT(emp_attendance.attendance) FROM `emp_joining_form` INNER JOIN `emp_attendance` ON emp_attendance.emp_id = emp_joining_form.id WHERE DATE(emp_attendance.date)>= DATE('" . $start_date . "') AND DATE(emp_attendance.date)<=DATE('" . $end_date . "') AND emp_joining_form.emp_type_id = '1' AND emp_attendance.attendance = 'half_day' GROUP BY emp_id";
    $db->sql($sql);
    $result = $db->getResult();

    $tempRow = $bulkData = $rows = array();
    $bulkData['total'] = $total;
    foreach ($res as $row) {

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
        //$tempRow['eid'] = $row['eid'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'location' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'location') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where = " Where `id` like '%" . $search . "%' OR `city_name` like '%" . $search . "%' OR `location_name` like '%" . $search . "%' OR `state_name` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `location` $where";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `location` $where ORDER BY $sort $order LIMIT $offset,$limit";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a class="btn btn-xs btn-warning" href="edit_location.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>&nbsp;';
        $operate .= ' <a class="btn btn-xs btn-danger" href="delete_location.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['city_name'] = $row['city_name'];
        $tempRow['location_name'] = $row['location_name'];
        $tempRow['state_name'] = $row['state_name'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'emp_type' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'emp_type') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `emp_type_name` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `emp_type` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_type` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a class="btn btn-xs btn-warning" href="edit-emp-type.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-emp-type.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['emp_type_name'] = $row['emp_type_name'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'emp_designation' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'emp_designation') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `designation_name` like '%" . $search . "%' OR `emp_type_name` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `emp_designation` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_designation` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a class="btn btn-xs btn-warning" href="edit-emp-designation.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-emp-designation.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['designation_name'] = $row['designation_name'];
        $tempRow['emp_type_name'] = $row['emp_type_name'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'get_emp_offer' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'get_emp_offer') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_joining_form` " . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        $operate = '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate .= ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['father_name'] = $row['father_name'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['age'] = $row['age'];
        $tempRow['blood_group'] = $row['blood_group'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mobile'] = $row['alt_mobile'];
        $tempRow['marital_status'] = $row['marital_status'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['aadhar_no'] = $row['aadhar_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        $tempRow['esic_no'] = $row['esic_no'];
        $tempRow['uan_no'] = $row['uan_no'];
        $tempRow['identification_mark'] = $row['identification_mark'];
        $tempRow['permanant_address'] = $row['permanant_address'];
        $tempRow['present_address'] = $row['present_address'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['acc_holder_name'] = $row['acc_holder_name'];
        $tempRow['acc_no'] = $row['acc_no'];
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        $tempRow['place'] = $row['place'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_post'] = $row['emp_post'];
        $tempRow['salary'] = $row['salary'];
        $tempRow['spl_allowance'] = $row['spl_allowance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'get_emp_appoint' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'get_emp_appoint') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_joining_form` " . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        $operate = ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate .= ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['father_name'] = $row['father_name'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['age'] = $row['age'];
        $tempRow['blood_group'] = $row['blood_group'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mobile'] = $row['alt_mobile'];
        $tempRow['marital_status'] = $row['marital_status'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['aadhar_no'] = $row['aadhar_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        $tempRow['esic_no'] = $row['esic_no'];
        $tempRow['uan_no'] = $row['uan_no'];
        $tempRow['identification_mark'] = $row['identification_mark'];
        $tempRow['permanant_address'] = $row['permanant_address'];
        $tempRow['present_address'] = $row['present_address'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['acc_holder_name'] = $row['acc_holder_name'];
        $tempRow['acc_no'] = $row['acc_no'];
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        $tempRow['place'] = $row['place'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_post'] = $row['emp_post'];
        $tempRow['salary'] = $row['salary'];
        $tempRow['spl_allowance'] = $row['spl_allowance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'get_emp_salary_slip' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'get_emp_salary_slip') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_joining_form` " . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        $operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['father_name'] = $row['father_name'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['age'] = $row['age'];
        $tempRow['blood_group'] = $row['blood_group'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mobile'] = $row['alt_mobile'];
        $tempRow['marital_status'] = $row['marital_status'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['aadhar_no'] = $row['aadhar_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        $tempRow['esic_no'] = $row['esic_no'];
        $tempRow['uan_no'] = $row['uan_no'];
        $tempRow['identification_mark'] = $row['identification_mark'];
        $tempRow['permanant_address'] = $row['permanant_address'];
        $tempRow['present_address'] = $row['present_address'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['acc_holder_name'] = $row['acc_holder_name'];
        $tempRow['acc_no'] = $row['acc_no'];
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        $tempRow['place'] = $row['place'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_post'] = $row['emp_post'];
        $tempRow['salary'] = $row['salary'];
        $tempRow['spl_allowance'] = $row['spl_allowance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'get_emp_probation_list' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'get_emp_probation_list') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();

    $date = date("Y-m-d");

    foreach ($res as $row)
        $total = $row['total'];

    if (!empty($where)) {
        $sql = "SELECT * FROM `emp_joining_form` WHERE DATE(probation_period_end)>= DATE('$date')";
    } else {
        $sql = "SELECT * FROM `emp_joining_form` " . $where . "AND DATE(probation_period_end)>= DATE('$date')";
    }

    //$sql = "SELECT * FROM `emp_joining_form` WHERE DATE(probation_period_end)<= DATE('$date') OR probation_period_end IS NULL";
    //$sql = "SELECT * FROM `emp_joining_form` " . $where . "AND DATE(probation_period_end)<= DATE('$date') OR probation_period_end IS NULL";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['father_name'] = $row['father_name'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['age'] = $row['age'];
        $tempRow['blood_group'] = $row['blood_group'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mobile'] = $row['alt_mobile'];
        $tempRow['marital_status'] = $row['marital_status'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['aadhar_no'] = $row['aadhar_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        $tempRow['esic_no'] = $row['esic_no'];
        $tempRow['uan_no'] = $row['uan_no'];
        $tempRow['identification_mark'] = $row['identification_mark'];
        $tempRow['permanant_address'] = $row['permanant_address'];
        $tempRow['present_address'] = $row['present_address'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['acc_holder_name'] = $row['acc_holder_name'];
        $tempRow['acc_no'] = $row['acc_no'];
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        $tempRow['place'] = $row['place'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_post'] = $row['emp_post'];
        $tempRow['salary'] = $row['salary'];
        $tempRow['spl_allowance'] = $row['spl_allowance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'get_emp_probation_end_list' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'get_emp_probation_end_list') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();

    $date = date("Y-m-d");

    foreach ($res as $row)
        $total = $row['total'];

    if (!empty($where)) {
        $sql = "SELECT * FROM `emp_joining_form` WHERE DATE(probation_period_end)<= DATE('$date')";
        //$sql = "SELECT * FROM `emp_joining_form` WHERE DATE(probation_period_end)<= DATE('$date') AND confirmation_status = 'pending'";
    } else {
        $sql = "SELECT * FROM `emp_joining_form` " . $where . "AND DATE(probation_period_end)<= DATE('$date')";
        //$sql = "SELECT * FROM `emp_joining_form` " . $where . "AND DATE(probation_period_end)<= DATE('$date') AND confirmation_status = 'pending'";
    }

    //$sql = "SELECT * FROM `emp_joining_form` WHERE DATE(probation_period_end)<= DATE('$date') OR probation_period_end IS NULL";
    //$sql = "SELECT * FROM `emp_joining_form` " . $where . "AND DATE(probation_period_end)<= DATE('$date') OR probation_period_end IS NULL";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        $operate .= '<a class="btn btn-xs btn-success" href="create-confirmation.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Create Confimation Letter</a>';
        $operate .= '<a class="btn btn-xs btn-warning" href="edit-probation.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Update Probation Period</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['father_name'] = $row['father_name'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['age'] = $row['age'];
        $tempRow['blood_group'] = $row['blood_group'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mobile'] = $row['alt_mobile'];
        $tempRow['marital_status'] = $row['marital_status'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['aadhar_no'] = $row['aadhar_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        $tempRow['esic_no'] = $row['esic_no'];
        $tempRow['uan_no'] = $row['uan_no'];
        $tempRow['identification_mark'] = $row['identification_mark'];
        $tempRow['permanant_address'] = $row['permanant_address'];
        $tempRow['present_address'] = $row['present_address'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['acc_holder_name'] = $row['acc_holder_name'];
        $tempRow['acc_no'] = $row['acc_no'];
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        $tempRow['place'] = $row['place'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_post'] = $row['emp_post'];
        $tempRow['salary'] = $row['salary'];
        $tempRow['spl_allowance'] = $row['spl_allowance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'get_emp_birthday' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'get_emp_birthday') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_joining_form` WHERE DATE(dob)= DATE('$date')";
    //$sql = "SELECT * FROM `emp_joining_form` WHERE DATE(dob)>= DATE('$date')";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['father_name'] = $row['father_name'];
        $tempRow['dob'] = $row['dob'];
        $tempRow['age'] = $row['age'];
        $tempRow['blood_group'] = $row['blood_group'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['alt_mobile'] = $row['alt_mobile'];
        $tempRow['marital_status'] = $row['marital_status'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['aadhar_no'] = $row['aadhar_no'];
        $tempRow['pan_no'] = $row['pan_no'];
        $tempRow['esic_no'] = $row['esic_no'];
        $tempRow['uan_no'] = $row['uan_no'];
        $tempRow['identification_mark'] = $row['identification_mark'];
        $tempRow['permanant_address'] = $row['permanant_address'];
        $tempRow['present_address'] = $row['present_address'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['acc_holder_name'] = $row['acc_holder_name'];
        $tempRow['acc_no'] = $row['acc_no'];
        $tempRow['ifsc_code'] = $row['ifsc_code'];
        $tempRow['place'] = $row['place'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_post'] = $row['emp_post'];
        $tempRow['salary'] = $row['salary'];
        $tempRow['spl_allowance'] = $row['spl_allowance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'todays_labour_attandance' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'todays_labour_attandance') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `emp_id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%' OR `attendance` like '%" . $search . "%'";
    }

    $date = date("Y-m-d");

    //$sql = "SELECT COUNT(*) as total FROM `emp_attendance` " . $where;
    $sql = "SELECT COUNT(*) as total FROM `emp_attendance` ";
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT emp_attendance.*, emp_joining_form.name, emp_joining_form.mobile, emp_joining_form.emp_designation_name FROM `emp_attendance` INNER JOIN `emp_joining_form` ON emp_joining_form.id = emp_attendance.emp_id WHERE DATE(emp_attendance.date)= DATE('$date') AND emp_joining_form.emp_type_id = '2'";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        $tempRow['attendance'] = $row['attendance'];
        $tempRow['in_time'] = $row['in_time'];
        $tempRow['in_time_latitude'] = $row['in_time_latitude'];
        $tempRow['in_time_longitude'] = $row['in_time_longitude'];
        $tempRow['in_time_location'] = $row['in_time_location'];
        $tempRow['out_time'] = $row['out_time'];
        $tempRow['out_time_latitude'] = $row['out_time_latitude'];
        $tempRow['out_time_longitude'] = $row['out_time_longitude'];
        $tempRow['out_time_location'] = $row['out_time_location'];
        $tempRow['hours'] = $row['hours'];
        $tempRow['tot_hours'] = $row['tot_hours'];
        $tempRow['ot_hours'] = $row['ot_hours'];
        //$tempRow['is_logged_in'] = $row['is_logged_in'];
        //$tempRow['date'] = $row['date'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'todays_labour_absent_table' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'todays_labour_absent_table') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }

    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT id, emp_no, name, mobile,emp_designation_name FROM emp_joining_form WHERE NOT EXISTS ( SELECT emp_attendance.emp_id FROM emp_attendance WHERE emp_joining_form.id = emp_attendance.emp_id AND emp_attendance.date = '$date' ) AND emp_joining_form.emp_type_id = '2'";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        //$tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'todays_staff_attandance' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'todays_staff_attandance') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `emp_id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%' OR `attendance` like '%" . $search . "%'";
    }

    $date = date("Y-m-d");

    //$sql = "SELECT COUNT(*) as total FROM `emp_attendance` " . $where;
    $sql = "SELECT COUNT(*) as total FROM `emp_attendance` ";
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT emp_attendance.*, emp_joining_form.name, emp_joining_form.mobile, emp_joining_form.emp_designation_name FROM `emp_attendance` INNER JOIN `emp_joining_form` ON emp_joining_form.id = emp_attendance.emp_id WHERE DATE(emp_attendance.date)= DATE('$date') AND emp_joining_form.emp_type_id = '1'";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        $tempRow['attendance'] = $row['attendance'];
        $tempRow['in_time'] = $row['in_time'];
        $tempRow['in_time_latitude'] = $row['in_time_latitude'];
        $tempRow['in_time_longitude'] = $row['in_time_longitude'];
        $tempRow['in_time_location'] = $row['in_time_location'];
        $tempRow['out_time'] = $row['out_time'];
        $tempRow['out_time_latitude'] = $row['out_time_latitude'];
        $tempRow['out_time_longitude'] = $row['out_time_longitude'];
        $tempRow['out_time_location'] = $row['out_time_location'];
        $tempRow['hours'] = $row['hours'];
        $tempRow['tot_hours'] = $row['tot_hours'];
        $tempRow['ot_hours'] = $row['ot_hours'];
        //$tempRow['is_logged_in'] = $row['is_logged_in'];
        //$tempRow['date'] = $row['date'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'todays_staff_absent_table' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'todays_staff_absent_table') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }

    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT id, emp_no, name, mobile,emp_designation_name FROM emp_joining_form WHERE NOT EXISTS ( SELECT emp_attendance.emp_id FROM emp_attendance WHERE emp_joining_form.id = emp_attendance.emp_id AND emp_attendance.date = '$date' ) AND emp_joining_form.emp_type_id = '1'";
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        //$tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'labours_leave_apply' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'labours_leave_apply') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'ASC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = "WHERE `emp_id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%' OR `leave_type` like '%" . $search . "%' OR `reason` like '%" . $search . "%' OR `leave_status` like '%" . $search . "%'";
    }

    //$sql = "SELECT COUNT(*) as total FROM `labour_leave` " . $where;
    $sql = "SELECT COUNT(*) as total FROM `labour_leave` WHERE leave_status = 'pending'";
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT labour_leave.*, emp_joining_form.mobile, emp_joining_form.name, emp_joining_form.emp_designation_name FROM `labour_leave` INNER JOIN `emp_joining_form` ON emp_joining_form.id = labour_leave.emp_id WHERE labour_leave.leave_status = 'pending' ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    //$sql_query = "SELECT * FROM `labour_leave` WHERE leave_status = 'pending' ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        $tempRow['leave_type'] = $row['leave_type'];
        $tempRow['leave_from_date'] = $row['leave_from_date'];
        $tempRow['leave_to_date'] = $row['leave_to_date'];
        $tempRow['reason'] = $row['reason'];
        $tempRow['leave_status'] = $row['leave_status'];
        $tempRow['date'] = $row['date'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'staff_leave_apply' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'staff_leave_apply') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'ASC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = "WHERE `emp_id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%' OR `leave_type` like '%" . $search . "%' OR `reason` like '%" . $search . "%' OR `leave_status` like '%" . $search . "%'";
    }

    //$sql = "SELECT COUNT(*) as total FROM `staff_leave` " . $where;
    $sql = "SELECT COUNT(*) as total FROM `staff_leave` WHERE leave_status = 'pending'";
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT staff_leave.*, emp_joining_form.mobile, emp_joining_form.name, emp_joining_form.emp_designation_name FROM `staff_leave` INNER JOIN `emp_joining_form` ON emp_joining_form.id = staff_leave.emp_id WHERE staff_leave.leave_status = 'pending' ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    //$sql_query = "SELECT * FROM `staff_leave` WHERE leave_status = 'pending' ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        $operate = ' <a class="btn btn-xs btn-success" href="approve_leave_staff.php?id=' . $row['id'] . '&emp_id=' . $row['emp_id'] . '"><i class="fa fa-edit"></i> Approve Staff Leave</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        $tempRow['leave_type'] = $row['leave_type'];
        $tempRow['leave_from_date'] = $row['leave_from_date'];
        $tempRow['leave_to_date'] = $row['leave_to_date'];
        $tempRow['reason'] = $row['reason'];
        $tempRow['leave_status'] = $row['leave_status'];
        $tempRow['date'] = $row['date'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'emergency_plans_list' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'emergency_plans_list') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }
*/
    $sql = "SELECT COUNT(*) as total FROM `emergency_plans` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emergency_plans` " . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        $operate = ' <a class="btn btn-xs btn-success" href="create-emergency-plans.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Emergency Plan</a><br>';
        //$operate .= ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emergency_date_prepared'] = $row['emergency_date_prepared'];
        $tempRow['manager_at_site'] = $row['manager_at_site'];
        $tempRow['manager_as'] = $row['manager_as'];
        $tempRow['manager_name'] = $row['manager_name'];
        $tempRow['manager_mobile'] = $row['manager_mobile'];
        $tempRow['coordinator_name'] = $row['coordinator_name'];
        $tempRow['coordinator_mobile'] = $row['coordinator_mobile'];
        $tempRow['area_monitor'] = $row['area_monitor'];
        $tempRow['area_monitor_name'] = $row['area_monitor_name'];
        $tempRow['area_monitor_mobile'] = $row['area_monitor_mobile'];
        $tempRow['floor_monitor'] = $row['floor_monitor'];
        $tempRow['floor_monitor_name'] = $row['floor_monitor_name'];
        $tempRow['floor_monitor_mobile'] = $row['floor_monitor_mobile'];
        $tempRow['assistants_to_phy_challanged_name1'] = $row['assistants_to_phy_challanged_name1'];
        $tempRow['assistants_to_phy_challanged_mobile1'] = $row['assistants_to_phy_challanged_mobile1'];
        $tempRow['assistants_to_phy_challanged_name2'] = $row['assistants_to_phy_challanged_name2'];
        $tempRow['assistants_to_phy_challanged_mobile2'] = $row['assistants_to_phy_challanged_mobile2'];
        $tempRow['emergency_date'] = $row['emergency_date'];
        $tempRow['emergency_fire_number'] = $row['emergency_fire_number'];
        $tempRow['emergency_ambulance_number'] = $row['emergency_ambulance_number'];
        $tempRow['emergency_police_number'] = $row['emergency_police_number'];
        $tempRow['emergency_security_number'] = $row['emergency_security_number'];
        $tempRow['emergency_factory_manager_number'] = $row['emergency_factory_manager_number'];
        $tempRow['utility_emergency_number_electric'] = $row['utility_emergency_number_electric'];
        $tempRow['utility_emergency_number_water'] = $row['utility_emergency_number_water'];
        $tempRow['utility_emergency_number_gas'] = $row['utility_emergency_number_gas'];
        $tempRow['utility_emergency_date'] = $row['utility_emergency_date'];
        $tempRow['other_type_emergency'] = $row['other_type_emergency'];
        $tempRow['med_emergency_call_paramedic'] = $row['med_emergency_call_paramedic'];
        $tempRow['med_emergency_call_ambulance'] = $row['med_emergency_call_ambulance'];
        $tempRow['med_emergency_call_fire'] = $row['med_emergency_call_fire'];
        $tempRow['med_emergency_call_other'] = $row['med_emergency_call_other'];
        $tempRow['med_emergency_name1'] = $row['med_emergency_name1'];
        $tempRow['med_emergency_phone1'] = $row['med_emergency_phone1'];
        $tempRow['med_emergency_name2'] = $row['med_emergency_name2'];
        $tempRow['med_emergency_phone2'] = $row['med_emergency_phone2'];
        $tempRow['med_emergency_date'] = $row['med_emergency_date'];
        $tempRow['fire_emergency_call'] = $row['fire_emergency_call'];
        $tempRow['fire_emergency_call_voice'] = $row['fire_emergency_call_voice'];
        $tempRow['fire_emergency_call_radio'] = $row['fire_emergency_call_radio'];
        $tempRow['fire_emergency_call_paging'] = $row['fire_emergency_call_paging'];
        $tempRow['fire_emergency_call_other'] = $row['fire_emergency_call_other'];
        $tempRow['fire_emergency_date'] = $row['fire_emergency_date'];
        $tempRow['chem_spill_equipment'] = $row['chem_spill_equipment'];
        $tempRow['chem_spill_ppe'] = $row['chem_spill_ppe'];
        $tempRow['chem_spill_msds'] = $row['chem_spill_msds'];
        $tempRow['chem_spill_cleanup_name'] = $row['chem_spill_cleanup_name'];
        $tempRow['chem_spill_cleanup_mobile'] = $row['chem_spill_cleanup_mobile'];
        $tempRow['chem_spill_date'] = $row['chem_spill_date'];
        $tempRow['struct_climb_descend_emergency_type_tower'] = $row['struct_climb_descend_emergency_type_tower'];
        $tempRow['struct_climb_descend_emergency_type_tower_location'] = $row['struct_climb_descend_emergency_type_tower_location'];
        $tempRow['struct_climb_descend_emergency_type_tower_org'] = $row['struct_climb_descend_emergency_type_tower_org'];
        $tempRow['struct_climb_descend_emergency_type_river'] = $row['struct_climb_descend_emergency_type_river'];
        $tempRow['struct_climb_descend_emergency_type_river_location'] = $row['struct_climb_descend_emergency_type_river_location'];
        $tempRow['struct_climb_descend_emergency_type_river_org'] = $row['struct_climb_descend_emergency_type_river_org'];
        $tempRow['struct_climb_descend_emergency_type_other'] = $row['struct_climb_descend_emergency_type_other'];
        $tempRow['struct_climb_descend_emergency_type_other_location'] = $row['struct_climb_descend_emergency_type_other_location'];
        $tempRow['struct_climb_descend_emergency_type_other_org'] = $row['struct_climb_descend_emergency_type_other_org'];
        $tempRow['critical_operation_area1'] = $row['critical_operation_area1'];
        $tempRow['critical_operation_name1'] = $row['critical_operation_name1'];
        $tempRow['critical_operation_job1'] = $row['critical_operation_job1'];
        $tempRow['critical_operation_assignment1'] = $row['critical_operation_assignment1'];
        $tempRow['critical_operation_area2'] = $row['critical_operation_area2'];
        $tempRow['critical_operation_name2'] = $row['critical_operation_name2'];
        $tempRow['critical_operation_job2'] = $row['critical_operation_job2'];
        $tempRow['critical_operation_assignment2'] = $row['critical_operation_assignment2'];
        $tempRow['critical_operation_area3'] = $row['critical_operation_area3'];
        $tempRow['critical_operation_name3'] = $row['critical_operation_name3'];
        $tempRow['critical_operation_job3'] = $row['critical_operation_job3'];
        $tempRow['critical_operation_assignment3'] = $row['critical_operation_assignment3'];
        $tempRow['critical_operation_offices'] = $row['critical_operation_offices'];
        $tempRow['critical_operation_manuals'] = $row['critical_operation_manuals'];
        $tempRow['critical_operation_contact_to_name1'] = $row['critical_operation_contact_to_name1'];
        $tempRow['critical_operation_contact_to_location1'] = $row['critical_operation_contact_to_location1'];
        $tempRow['critical_operation_contact_to_mobile1'] = $row['critical_operation_contact_to_mobile1'];
        $tempRow['critical_operation_contact_to_name2'] = $row['critical_operation_contact_to_name2'];
        $tempRow['critical_operation_contact_to_location2'] = $row['critical_operation_contact_to_location2'];
        $tempRow['critical_operation_contact_to_mobile2'] = $row['critical_operation_contact_to_mobile2'];
        $tempRow['critical_operation_contact_to_name3'] = $row['critical_operation_contact_to_name3'];
        $tempRow['critical_operation_contact_to_location3'] = $row['critical_operation_contact_to_location3'];
        $tempRow['critical_operation_contact_to_mobile3'] = $row['critical_operation_contact_to_mobile3'];
        $tempRow['emergency_training_facility'] = $row['emergency_training_facility'];
        $tempRow['emergency_training_person_name'] = $row['emergency_training_person_name'];
        $tempRow['emergency_training_person_responsibility'] = $row['emergency_training_person_responsibility'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'jha_type' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'jha_type') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `jha_type` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `jha_type`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-jha.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Create JHA</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['location'] = $row['location'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['emp_designation_name'] = $row['emp_designation_name'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'jha_job_seq' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'jha_job_seq') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
*/
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `jha_job_seq` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `jha_job_seq`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        //$tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'jha_potential_hazard' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'jha_potential_hazard') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
*/
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `jha_potential_hazard` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `jha_potential_hazard`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        //$tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'jha_safegaurd' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'jha_safegaurd') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
*/
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `jha_safegaurd` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `jha_safegaurd`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        //$tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['name'] = $row['name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'sop_type' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'sop_type') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `sop_type` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `sop_type`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-sop.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Create SOP</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['location'] = $row['location'];
        //$tempRow['profile'] = $row['profile'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['emp_designation_name'] = $row['emp_designation_name'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'capa' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'capa') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `capa` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `capa`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="generate-capa-pdf.php?form_no=' . $row['form_no'] . '&location=' . $row['location'] . '&format_no=' . $row['format_no'] . '&audit_date=' . $row['audit_date'] . '&department=' . $row['department'] . '"><i class="fa fa-folder-open-o"></i>Create CAPA</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['form_no'] = $row['form_no'];
        $tempRow['format_no'] = $row['format_no'];
        $tempRow['audit_date'] = $row['audit_date'];
        $tempRow['department'] = $row['department'];
        $tempRow['root_cause'] = $row['root_cause'];
        $tempRow['corrective_action'] = $row['corrective_action'];
        $tempRow['preventive_action'] = $row['preventive_action'];
        $tempRow['consequence'] = $row['consequence'];
        $tempRow['responsibility'] = $row['responsibility'];
        $tempRow['target_date'] = $row['target_date'];
        $tempRow['status'] = $row['status'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'mock_drill' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'mock_drill') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `mock_drill` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `mock_drill`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="generate-mock-drill-pdf.php?id=' . $row['id'] . '&location=' . $row['location'] . '"><i class="fa fa-folder-open-o"></i>Create Mock Drill PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['drill_date'] = $row['drill_date'];
        $tempRow['drill_type'] = $row['drill_type'];
        $tempRow['fire'] = $row['fire'];
        $tempRow['gas_leak'] = $row['gas_leak'];
        $tempRow['fall_down'] = $row['fall_down'];
        $tempRow['other'] = $row['other'];
        $tempRow['start_time'] = $row['start_time'];
        $tempRow['end_time'] = $row['end_time'];
        $tempRow['total_time'] = $row['total_time'];
        $tempRow['alarm_worked'] = $row['alarm_worked'];
        $tempRow['describe_alarm'] = $row['describe_alarm'];
        $tempRow['describe_situation'] = $row['describe_situation'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'job_description' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'job_description') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `job_description` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `job_description`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="generate-job-description-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Job Description</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['designation_id'] = $row['designation_id'];
        $tempRow['designation'] = $row['designation'];
        $tempRow['reports_to'] = $row['reports_to'];
        $tempRow['description'] = $row['description'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'emp_selection_process' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'emp_selection_process') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `emp_selection_process` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_selection_process`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-emp-select-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Job Selection</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['emp_selection'] = $row['emp_selection'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'emp_selection_process_docs' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'emp_selection_process_docs') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `emp_selection_process_docs` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_selection_process_docs`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-emp-select-docs-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Job Selection Docs</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['emp_selection_docs'] = $row['emp_selection_docs'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'abp' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'abp') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `abp` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `abp`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-abp-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create ABP PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['particulars'] = $row['particulars'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'monthly_abp' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'monthly_abp') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `monthly_abp` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `monthly_abp`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="generate-monthly-abp-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '&month=' . $row['month'] . '&year=' . $row['year'] . '"><i class="fa fa-folder-open-o"></i>Create Monthly ABP PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['abp_name'] = $row['abp_name'];
        $tempRow['plan_date'] = $row['plan_date'];
        $tempRow['actual_date'] = $row['actual_date'];
        $tempRow['month'] = $row['month'];
        $tempRow['year'] = $row['year'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'training_attandance_sheet' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'training_attandance_sheet') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `training_attandance_sheet` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `training_attandance_sheet`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="generate-training-attandance-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Training Attandance PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['training_name'] = $row['training_name'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev_no'] = $row['rev_no'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['date'] = $row['date'];
        $tempRow['training_date'] = $row['training_date'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['emp_name'] = $row['emp_name'];
        $tempRow['department'] = $row['department'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['remark'] = $row['remark'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'performance_report' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'performance_report') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `performance_report` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `performance_report` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `performance_report`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="generate-performance-report-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '&month_from=' . $row['month_from'] . '&month_to=' . $row['month_to'] . '&doc_no=' . $row['doc_no'] . '&rev_no=' . $row['rev_no'] . '&date=' . $row['date'] . '"><i class="fa fa-folder-open-o"></i>Create Performance Report PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['report_from'] = $row['report_from'];
        $tempRow['report_to'] = $row['report_to'];
        $tempRow['month_from'] = $row['month_from'];
        $tempRow['month_to'] = $row['month_to'];
        $tempRow['objective'] = $row['objective'];
        $tempRow['department'] = $row['department'];
        $tempRow['past_perform'] = $row['past_perform'];
        $tempRow['forecast_perform'] = $row['forecast_perform'];
        $tempRow['actual_perform'] = $row['actual_perform'];
        $tempRow['line_of_improve'] = $row['line_of_improve'];
        $tempRow['action_taken'] = $row['action_taken'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev_no'] = $row['rev_no'];
        $tempRow['date'] = $row['date'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'ofi_report' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'ofi_report') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `ofi_report` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `ofi_report` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `ofi_report`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="generate-performance-report-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '&month_from=' . $row['month_from'] . '&month_to=' . $row['month_to'] . '&doc_no=' . $row['doc_no'] . '&rev_no=' . $row['rev_no'] . '&date=' . $row['date'] . '"><i class="fa fa-folder-open-o"></i>Create Performance Report PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['department'] = $row['department'];
        $tempRow['document'] = $row['document'];
        $tempRow['pl1'] = $row['pl1'];
        $tempRow['pl2'] = $row['pl2'];
        $tempRow['pl3'] = $row['pl3'];
        $tempRow['pl4'] = $row['pl4'];
        $tempRow['co1'] = $row['co1'];
        $tempRow['co2'] = $row['co2'];
        $tempRow['co3'] = $row['co3'];
        $tempRow['co4'] = $row['co4'];
        $tempRow['cl1'] = $row['cl1'];
        $tempRow['cl2'] = $row['cl2'];
        $tempRow['cl3'] = $row['cl3'];
        $tempRow['cl4'] = $row['cl4'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev_no'] = $row['rev_no'];
        $tempRow['date'] = $row['date'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'training_calendar' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'training_calendar') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `training_calendar` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `training_calendar` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `training_calendar`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="generate-performance-report-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '&month_from=' . $row['month_from'] . '&month_to=' . $row['month_to'] . '&doc_no=' . $row['doc_no'] . '&rev_no=' . $row['rev_no'] . '&date=' . $row['date'] . '"><i class="fa fa-folder-open-o"></i>Create Performance Report PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['topic'] = $row['topic'];
        $tempRow['jan_plan_date'] = $row['jan_plan_date'];
        $tempRow['jan_actual_date'] = $row['jan_actual_date'];
        $tempRow['feb_plan_date'] = $row['feb_plan_date'];
        $tempRow['feb_actual_date'] = $row['feb_actual_date'];
        $tempRow['mar_plan_date'] = $row['mar_plan_date'];
        $tempRow['mar_actual_date'] = $row['mar_actual_date'];
        $tempRow['apr_plan_date'] = $row['apr_plan_date'];
        $tempRow['apr_actual_date'] = $row['apr_actual_date'];
        $tempRow['may_plan_date'] = $row['may_plan_date'];
        $tempRow['may_actual_date'] = $row['may_actual_date'];
        $tempRow['jun_plan_date'] = $row['jun_plan_date'];
        $tempRow['jun_actual_date'] = $row['jun_actual_date'];
        $tempRow['jul_plan_date'] = $row['jul_plan_date'];
        $tempRow['jul_actual_date'] = $row['jul_actual_date'];
        $tempRow['aug_plan_date'] = $row['aug_plan_date'];
        $tempRow['aug_actual_date'] = $row['aug_actual_date'];
        $tempRow['sep_plan_date'] = $row['sep_plan_date'];
        $tempRow['sep_actual_date'] = $row['sep_actual_date'];
        $tempRow['oct_plan_date'] = $row['oct_plan_date'];
        $tempRow['oct_actual_date'] = $row['oct_actual_date'];
        $tempRow['nov_plan_date'] = $row['nov_plan_date'];
        $tempRow['nov_actual_date'] = $row['nov_actual_date'];
        $tempRow['dec_plan_date'] = $row['dec_plan_date'];
        $tempRow['dec_actual_date'] = $row['dec_actual_date'];
        $tempRow['year'] = $row['year'];
        $tempRow['date'] = $row['date'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'feedback_statement' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'feedback_statement') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `feedback_statement` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `feedback_statement`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="create-abp-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create ABP PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['statement'] = $row['statement'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'feedback' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'feedback') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `feedback` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `feedback`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-feedback-pdf.php?id=' . $row['id'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Feedback PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['format_no'] = $row['format_no'];
        $tempRow['form_no'] = $row['form_no'];
        $tempRow['revision_no'] = $row['revision_no'];
        $tempRow['name'] = $row['name'];
        $tempRow['department'] = $row['department'];
        $tempRow['designation'] = $row['designation'];
        $tempRow['date'] = $row['date'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['statement'] = $row['statement'];
        $tempRow['agree'] = $row['agree'];
        $tempRow['neither_nor'] = $row['neither_nor'];
        $tempRow['disagree'] = $row['disagree'];
        $tempRow['remarks'] = $row['remarks'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'mass_meeting' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'mass_meeting') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `mass_meeting` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `mass_meeting` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `mass_meeting`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-mass-meeting-pdf.php?date=' . $row['date'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Mass Meeting PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['date'] = $row['date'];
        $tempRow['meeting_no'] = $row['meeting_no'];
        $tempRow['present'] = $row['present'];
        $tempRow['safty_pause'] = $row['safty_pause'];
        $tempRow['pomb_discuss'] = $row['pomb_discuss'];
        //$tempRow['count'] = $row['count'];
        $tempRow['point'] = $row['point'];
        $tempRow['action'] = $row['action'];
        $tempRow['target'] = $row['target'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'mass_meeting_attandance' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'mass_meeting_attandance') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `mass_meeting_attandance` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `mass_meeting_attandance` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `mass_meeting_attandance`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-mass-meeting-attandance-pdf.php?date=' . $row['date'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Mass Meeting Attendance PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['date'] = $row['date'];
        $tempRow['time'] = $row['time'];
        $tempRow['venue'] = $row['venue'];
        $tempRow['meeting_no'] = $row['meeting_no'];
        $tempRow['chaired_by'] = $row['chaired_by'];
        //$tempRow['emp_count'] = $row['emp_count'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['emp_name'] = $row['emp_name'];
        $tempRow['attendance'] = $row['attendance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'tool_box_meeting' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'tool_box_meeting') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `tool_box_meeting` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `tool_box_meeting` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `tool_box_meeting`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-tool-box-meeting-pdf.php?project_date=' . $row['project_date'] . '&project_name=' . $row['project_name'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Tool Box Meeting PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['authorised_by'] = $row['authorised_by'];
        $tempRow['issue_no'] = $row['issue_no'];
        $tempRow['date1'] = $row['date1'];
        $tempRow['form_no'] = $row['form_no'];
        $tempRow['page'] = $row['page'];
        $tempRow['revision'] = $row['revision'];
        $tempRow['date'] = $row['date'];
        $tempRow['effective_date'] = $row['effective_date'];
        $tempRow['project_name'] = $row['project_name'];
        $tempRow['project_date'] = $row['project_date'];
        $tempRow['location'] = $row['location'];
        $tempRow['time'] = $row['time'];
        $tempRow['topic'] = $row['topic'];
        $tempRow['conducted_by'] = $row['conducted_by'];
        $tempRow['tot_no'] = $row['tot_no'];
        //$tempRow['emp_count'] = $row['emp_count'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['emp_name'] = $row['emp_name'];
        $tempRow['emp_designation'] = $row['emp_designation'];
        $tempRow['attendance'] = $row['attendance'];
        $tempRow['signature'] = $row['signature'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'line_walk' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'line_walk') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `line_walk` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `line_walk` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `line_walk`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-line-walk-pdf.php?date=' . $row['date'] . '&location_id=' . $row['location_id'] . '&department=' . $row['department'] . '"><i class="fa fa-folder-open-o"></i>Create Line Walk PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['date'] = $row['date'];
        $tempRow['line_walk_date'] = $row['line_walk_date'];
        $tempRow['location'] = $row['location'];
        $tempRow['department'] = $row['department'];
        $tempRow['present'] = $row['present'];
        $tempRow['line_manager'] = $row['line_manager'];
        $tempRow['chaired_by'] = $row['chaired_by'];
        $tempRow['observation'] = $row['observation'];
        $tempRow['action'] = $row['action'];
        $tempRow['image'] = $row['image'];
        //$tempRow['image'] = "<a data-lightbox='product' href='" . $path . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='" . $path . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'skill_report' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'skill_report') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `profile` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `father_name` like '%" . $search . "%' OR `dob` like '%" . $search . "%' OR `age` like '%" . $search . "%' OR `blood_group` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `alt_mobile` like '%" . $search . "%' OR `marital_status` like '%" . $search . "%' OR `qualification` like '%" . $search . "%' OR `experience` like '%" . $search . "%' OR `aadhar_no` like '%" . $search . "%' OR `pan_no` like '%" . $search . "%' OR `esic_no` like '%" . $search . "%' OR `uan_no` like '%" . $search . "%' OR `identification_mark` like '%" . $search . "%' OR `permanant_address` like '%" . $search . "%' OR `present_address` like '%" . $search . "%' OR `bank_name` like '%" . $search . "%' OR `acc_holder_name` like '%" . $search . "%' OR `acc_no` like '%" . $search . "%' OR `ifsc_code` like '%" . $search . "%' OR `place` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `emp_post` like '%" . $search . "%' OR `salary` like '%" . $search . "%' OR `spl_allowance` like '%" . $search . "%' OR `signature` like '%" . $search . "%' OR `created_at` like '%" . $search . "%' OR `updated_at` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(*) as total FROM `emp_joining_form` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `test_form` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `emp_joining_form` " . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        /*
        $operate = '<a class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" title="View Address"><i class="fa fa-credit-card"></i></a>&nbsp;';
        $operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        $operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        $operate .= ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';
*/
        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['id'] = $row['id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['name'] = $row['name'];
        $tempRow['emp_designation_name'] = $row['emp_designation_name'];
        $tempRow['qualification'] = $row['qualification'];
        $tempRow['date'] = $row['date'];
        $tempRow['emp_skills'] = $row['emp_skills'];
        $tempRow['experience'] = $row['experience'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $operate;
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'supervisor_audit' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'supervisor_audit') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `supervisor_audit` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `supervisor_audit` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `supervisor_audit`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-supervisor-audit-pdf.php?audit_date=' . $row['audit_date'] . '&department=' . $row['department'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Supervisor Audit PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['department'] = $row['department'];
        $tempRow['section'] = $row['section'];
        $tempRow['audit_date'] = $row['audit_date'];
        $tempRow['time'] = $row['time'];
        $tempRow['dept_representative'] = $row['dept_representative'];
        $tempRow['team_member1'] = $row['team_member1'];
        $tempRow['team_member2'] = $row['team_member2'];
        $tempRow['team_member3'] = $row['team_member3'];
        $tempRow['team_member4'] = $row['team_member4'];
        $tempRow['team_member5'] = $row['team_member5'];
        $tempRow['team_member6'] = $row['team_member6'];
        $tempRow['contract_name_vendor_code'] = $row['contract_name_vendor_code'];
        $tempRow['tot_contract_people_working'] = $row['tot_contract_people_working'];
        $tempRow['description'] = $row['description'];
        $tempRow['good_citizen'] = $row['good_citizen'];
        $tempRow['violation_no'] = $row['violation_no'];
        $tempRow['severity'] = $row['severity'];
        $tempRow['violation_severity'] = $row['violation_severity'];
        $tempRow['potential_fatality'] = $row['potential_fatality'];
        $tempRow['ua_uc'] = $row['ua_uc'];
        $tempRow['violation_subtotal'] = $row['violation_subtotal'];
        $tempRow['violation_severity_subtotal'] = $row['violation_severity_subtotal'];
        $tempRow['severity_index'] = $row['severity_index'];
        $tempRow['checked_by'] = $row['checked_by'];
        $tempRow['reviewed_by'] = $row['reviewed_by'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['date'] = $row['date'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'work_permit' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'work_permit') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `work_permit` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `work_permit` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `work_permit`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-work-permit-pdf.php?date=' . $row['date'] . '&department=' . $row['department'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Work Permit PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['effective_date'] = $row['effective_date'];
        $tempRow['si_no'] = $row['si_no'];
        $tempRow['date'] = $row['date'];
        $tempRow['department'] = $row['department'];
        $tempRow['section'] = $row['section'];
        $tempRow['org_permit_valid_from'] = $row['org_permit_valid_from'];
        $tempRow['org_permit_valid_to'] = $row['org_permit_valid_to'];
        $tempRow['renewal_valid_from1'] = $row['renewal_valid_from1'];
        $tempRow['renewal_valid_to1'] = $row['renewal_valid_to1'];
        $tempRow['renewal_valid_from2'] = $row['renewal_valid_from2'];
        $tempRow['renewal_valid_to2'] = $row['renewal_valid_to2'];
        $tempRow['job_description'] = $row['job_description'];
        $tempRow['working_agency_name'] = $row['working_agency_name'];
        $tempRow['work_permit_area'] = $row['work_permit_area'];
        $tempRow['welding_gas_cutting'] = $row['welding_gas_cutting'];
        $tempRow['rigging_fitting'] = $row['rigging_fitting'];
        $tempRow['work_at_height'] = $row['work_at_height'];
        $tempRow['Hydraulic_Pneumatic'] = $row['Hydraulic_Pneumatic'];
        $tempRow['painting_cleaning'] = $row['painting_cleaning'];
        $tempRow['confined_space'] = $row['confined_space'];
        $tempRow['gas'] = $row['gas'];
        $tempRow['electrical'] = $row['electrical'];
        $tempRow['other'] = $row['other'];
        $tempRow['gas_hazard_permit_taken'] = $row['gas_hazard_permit_taken'];
        $tempRow['gas_hazard_permit_no'] = $row['gas_hazard_permit_no'];
        $tempRow['confined_space_permit_taken'] = $row['confined_space_permit_taken'];
        $tempRow['confined_space_permit_no'] = $row['confined_space_permit_no'];
        $tempRow['electrical_power_permit_taken'] = $row['electrical_power_permit_taken'];
        $tempRow['electrical_power_permit_no'] = $row['electrical_power_permit_no'];
        $tempRow['grounding_discharging_permit_taken'] = $row['grounding_discharging_permit_taken'];
        $tempRow['grounding_discharging_permit_no'] = $row['grounding_discharging_permit_no'];
        $tempRow['Hydraulic_Pneumatic_permit_taken'] = $row['Hydraulic_Pneumatic_permit_taken'];
        $tempRow['Hydraulic_Pneumatic_permit_no'] = $row['Hydraulic_Pneumatic_permit_no'];
        $tempRow['hot_work_permit_taken'] = $row['hot_work_permit_taken'];
        $tempRow['hot_work_permit_no'] = $row['hot_work_permit_no'];
        $tempRow['mechanized_grading_permit_taken'] = $row['mechanized_grading_permit_taken'];
        $tempRow['mechanized_grading_permit_no'] = $row['mechanized_grading_permit_no'];
        $tempRow['positive_isolation_permit_taken'] = $row['positive_isolation_permit_taken'];
        $tempRow['positive_isolation_permit_no'] = $row['positive_isolation_permit_no'];
        $tempRow['spl_instruction'] = $row['spl_instruction'];
        $tempRow['permit_org_name_req_by'] = $row['permit_org_name_req_by'];
        $tempRow['permit_org_name_issued_by'] = $row['permit_org_name_issued_by'];
        $tempRow['permit_org_name_taken_by_working'] = $row['permit_org_name_taken_by_working'];
        $tempRow['permit_org_name_taken_by_central'] = $row['permit_org_name_taken_by_central'];
        $tempRow['renewal1_name_req_by'] = $row['renewal1_name_req_by'];
        $tempRow['renewal1_name_issued_by'] = $row['renewal1_name_issued_by'];
        $tempRow['renewal1_name_taken_by_working'] = $row['renewal1_name_taken_by_working'];
        $tempRow['renewal1_name_taken_by_central'] = $row['renewal1_name_taken_by_central'];
        $tempRow['renewal2_name_req_by'] = $row['renewal2_name_req_by'];
        $tempRow['renewal2_name_issued_by'] = $row['renewal2_name_issued_by'];
        $tempRow['renewal2_name_taken_by_working'] = $row['renewal2_name_taken_by_working'];
        $tempRow['renewal2_name_taken_by_central'] = $row['renewal2_name_taken_by_central'];
        $tempRow['permit_org_designation_req_by'] = $row['permit_org_designation_req_by'];
        $tempRow['permit_org_designation_issued_by'] = $row['permit_org_designation_issued_by'];
        $tempRow['permit_org_designation_taken_by_working'] = $row['permit_org_designation_taken_by_working'];
        $tempRow['permit_org_designation_taken_by_central'] = $row['permit_org_designation_taken_by_central'];
        $tempRow['renewal1_designation_req_by'] = $row['renewal1_designation_req_by'];
        $tempRow['renewal1_designation_issued_by'] = $row['renewal1_designation_issued_by'];
        $tempRow['renewal1_designation_taken_by_working'] = $row['renewal1_designation_taken_by_working'];
        $tempRow['renewal1_designation_taken_by_central'] = $row['renewal1_designation_taken_by_central'];
        $tempRow['renewal2_designation_req_by'] = $row['renewal2_designation_req_by'];
        $tempRow['renewal2_designation_issued_by'] = $row['renewal2_designation_issued_by'];
        $tempRow['renewal2_designation_taken_by_working'] = $row['renewal2_designation_taken_by_working'];
        $tempRow['renewal2_designation_taken_by_central'] = $row['renewal2_designation_taken_by_central'];
        $tempRow['permit_org_signature_req_by'] = $row['permit_org_signature_req_by'];
        $tempRow['permit_org_signature_issued_by'] = $row['permit_org_signature_issued_by'];
        $tempRow['permit_org_signature_taken_by_working'] = $row['permit_org_signature_taken_by_working'];
        $tempRow['permit_org_signature_taken_by_central'] = $row['permit_org_signature_taken_by_central'];
        $tempRow['renewal1_signature_req_by'] = $row['renewal1_signature_req_by'];
        $tempRow['renewal1_signature_issued_by'] = $row['renewal1_signature_issued_by'];
        $tempRow['renewal1_signature_taken_by_working'] = $row['renewal1_signature_taken_by_working'];
        $tempRow['renewal1_signature_taken_by_central'] = $row['renewal1_signature_taken_by_central'];
        $tempRow['renewal2_signature_req_by'] = $row['renewal2_signature_req_by'];
        $tempRow['renewal2_signature_issued_by'] = $row['renewal2_signature_issued_by'];
        $tempRow['renewal2_signature_taken_by_working'] = $row['renewal2_signature_taken_by_working'];
        $tempRow['renewal2_signature_taken_by_central'] = $row['renewal2_signature_taken_by_central'];
        $tempRow['name_return_by_working_agency'] = $row['name_return_by_working_agency'];
        $tempRow['name_return_by_taken_by'] = $row['name_return_by_taken_by'];
        $tempRow['name_revived_by_executive'] = $row['name_revived_by_executive'];
        $tempRow['name_revived_by_owner'] = $row['name_revived_by_owner'];
        $tempRow['designation_return_by_working_agency'] = $row['designation_return_by_working_agency'];
        $tempRow['designation_return_by_taken_by'] = $row['designation_return_by_taken_by'];
        $tempRow['designation_revived_by_executive'] = $row['designation_revived_by_executive'];
        $tempRow['designation_revived_by_owner'] = $row['designation_revived_by_owner'];
        $tempRow['signature_return_by_working_agency'] = $row['signature_return_by_working_agency'];
        $tempRow['signature_return_by_taken_by'] = $row['signature_return_by_taken_by'];
        $tempRow['signature_revived_by_executive'] = $row['signature_revived_by_executive'];
        $tempRow['signature_revived_by_owner'] = $row['signature_revived_by_owner'];
        $tempRow['north_hazard'] = $row['north_hazard'];
        $tempRow['north_precautions'] = $row['north_precautions'];
        $tempRow['south_remark'] = $row['south_remark'];
        $tempRow['south_hazard'] = $row['south_hazard'];
        $tempRow['south_precautions'] = $row['south_precautions'];
        $tempRow['north_remark'] = $row['north_remark'];
        $tempRow['east_hazard'] = $row['east_hazard'];
        $tempRow['east_precautions'] = $row['east_precautions'];
        $tempRow['east_remark'] = $row['east_remark'];
        $tempRow['west_hazard'] = $row['west_hazard'];
        $tempRow['west_precautions'] = $row['west_precautions'];
        $tempRow['west_remark'] = $row['west_remark'];
        $tempRow['top_hazard'] = $row['top_hazard'];
        $tempRow['top_precautions'] = $row['top_precautions'];
        $tempRow['top_remark'] = $row['top_remark'];
        $tempRow['bottom_hazard'] = $row['bottom_hazard'];
        $tempRow['bottom_precautions'] = $row['bottom_precautions'];
        $tempRow['bottom_remark'] = $row['bottom_remark'];
        $tempRow['sign_permit_req_by'] = $row['sign_permit_req_by'];
        $tempRow['sop_made_approved'] = $row['sop_made_approved'];
        $tempRow['test_pass_certificate'] = $row['test_pass_certificate'];
        $tempRow['medically_fit'] = $row['medically_fit'];
        $tempRow['tools_condition_Certificate'] = $row['tools_condition_Certificate'];
        $tempRow['trained_on_sop'] = $row['trained_on_sop'];
        $tempRow['work_person_name'] = $row['work_person_name'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['in_time'] = $row['in_time'];
        $tempRow['out_time'] = $row['out_time'];
        $tempRow['tool_box_talk'] = $row['tool_box_talk'];
        $tempRow['renewal1'] = $row['renewal1'];
        $tempRow['renewal2'] = $row['renewal2'];
        $tempRow['permit_receiver_sign'] = $row['permit_receiver_sign'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'manual' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'manual') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `manual_name` like '%" . $search . "%' OR `pdf` like '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(`id`) as total FROM `manual` " . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `manual` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $tempRow['id'] = $row['id'];
        $tempRow['manual_name'] = $row['manual_name'];
        //$tempRow['subtitle'] = $row['subtitle'];
        //$tempRow['pdf'] = "<a href='" . $row['pdf'] . " '  target='_blank'>'".$pdf['pdf']."'</a>";
        $tempRow['pdf'] = $row['pdf'];
        //$tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'hot_job' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'hot_job') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `hot_job` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `hot_job` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `hot_job`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-hot-job-pdf.php?date=' . $row['date'] . '&designation=' . $row['designation'] . '&department=' . $row['department'] . '&job_description=' . $row['job_description'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Work Permit PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['effective_date'] = $row['effective_date'];
        $tempRow['si_no'] = $row['si_no'];
        $tempRow['date'] = $row['date'];
        $tempRow['clearance_time_from'] = $row['clearance_time_from'];
        $tempRow['clearance_time_to'] = $row['clearance_time_to'];
        $tempRow['clearance_date'] = $row['clearance_date'];
        $tempRow['permission_given_to'] = $row['permission_given_to'];
        $tempRow['designation'] = $row['designation'];
        $tempRow['department'] = $row['department'];
        $tempRow['to_take_job'] = $row['to_take_job'];
        $tempRow['section_or_location'] = $row['section_or_location'];
        $tempRow['job_description'] = $row['job_description'];
        $tempRow['check_points'] = $row['check_points'];
        $tempRow['marking'] = $row['marking'];
        $tempRow['reason_for_no'] = $row['reason_for_no'];
        $tempRow['executing_signature'] = $row['executing_signature'];
        $tempRow['executing_agency'] = $row['executing_agency'];
        $tempRow['executing_name'] = $row['executing_name'];
        $tempRow['executing_designation'] = $row['executing_designation'];
        $tempRow['executing_department'] = $row['executing_department'];
        $tempRow['executing_date'] = $row['executing_date'];
        $tempRow['executing_time'] = $row['executing_time'];
        $tempRow['issuer_signature'] = $row['issuer_signature'];
        $tempRow['issuer_name'] = $row['issuer_name'];
        $tempRow['issuer_designation'] = $row['issuer_designation'];
        $tempRow['issuer_department'] = $row['issuer_department'];
        $tempRow['issuer_date'] = $row['issuer_date'];
        $tempRow['issuer_time'] = $row['issuer_time'];
        $tempRow['approver_signature'] = $row['approver_signature'];
        $tempRow['approver_name'] = $row['approver_name'];
        $tempRow['approver_designation'] = $row['approver_designation'];
        $tempRow['approver_department'] = $row['approver_department'];
        $tempRow['approver_date'] = $row['approver_date'];
        $tempRow['approver_time'] = $row['approver_time'];
        $tempRow['return_undertaking_to'] = $row['return_undertaking_to'];
        $tempRow['return_undertaking_job_descript'] = $row['return_undertaking_job_descript'];
        $tempRow['return_undertaking_designation'] = $row['return_undertaking_designation'];
        $tempRow['return_undertaking_department'] = $row['return_undertaking_department'];
        $tempRow['work_agency_date'] = $row['work_agency_date'];
        $tempRow['work_agency_sign'] = $row['work_agency_sign'];
        $tempRow['work_agency_time'] = $row['work_agency_time'];
        $tempRow['work_agency_name'] = $row['work_agency_name'];
        $tempRow['work_agency_designation'] = $row['work_agency_designation'];
        $tempRow['work_agency_department'] = $row['work_agency_department'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'working_at_height' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'working_at_height') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `working_at_height` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `working_at_height` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `working_at_height`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-working-at-height-pdf.php?date=' . $row['date'] . '&agency_name=' . $row['agency_name'] . '&job_description=' . $row['job_description'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Work Permit PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['ref_no'] = $row['ref_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['si_no'] = $row['si_no'];
        $tempRow['effective_date'] = $row['effective_date'];
        $tempRow['date'] = $row['date'];
        $tempRow['agency_name'] = $row['agency_name'];
        $tempRow['exact_location'] = $row['exact_location'];
        $tempRow['job_description'] = $row['job_description'];
        $tempRow['duration_time_from'] = $row['duration_time_from'];
        $tempRow['duration_time_to'] = $row['duration_time_to'];
        $tempRow['commencement_date'] = $row['commencement_date'];
        $tempRow['check_points'] = $row['check_points'];
        $tempRow['marking'] = $row['marking'];
        $tempRow['site_engg_name'] = $row['site_engg_name'];
        $tempRow['site_engg_sign'] = $row['site_engg_sign'];
        $tempRow['site_engg_date'] = $row['site_engg_date'];
        $tempRow['mandal_engg_name'] = $row['mandal_engg_name'];
        $tempRow['mandal_engg_sign'] = $row['mandal_engg_sign'];
        $tempRow['mandal_engg_date'] = $row['mandal_engg_date'];
        $tempRow['hod_sign'] = $row['hod_sign'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'hazard_mapping' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'hazard_mapping') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `hazard_mapping` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `hazard_mapping` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `hazard_mapping`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="create-working-at-height-pdf.php?date=' . $row['date'] . '&agency_name=' . $row['agency_name'] . '&job_description=' . $row['job_description'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Work Permit PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['task'] = $row['task'];
        $tempRow['risk'] = $row['risk'];
        $tempRow['initial_nce'] = $row['initial_nce'];
        $tempRow['initial_liklihood'] = $row['initial_liklihood'];
        $tempRow['initial_rating'] = $row['initial_rating'];
        $tempRow['proposed_control'] = $row['proposed_control'];
        $tempRow['residual_nce'] = $row['residual_nce'];
        $tempRow['residual_liklihood'] = $row['residual_liklihood'];
        $tempRow['residual_rating'] = $row['residual_rating'];
        $tempRow['action_by'] = $row['action_by'];
        $tempRow['action_date'] = $row['action_date'];
        $tempRow['completed_by'] = $row['completed_by'];
        $tempRow['completed_date'] = $row['completed_date'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'hazard' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'hazard') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `hazard` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `hazard` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `hazard`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-hazard-mapping-pdf.php?site_area=' . $row['site_area'] . '&dept=' . $row['dept'] . '&date2=' . $row['date2'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Hazard Mapping PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['assesment_no'] = $row['assesment_no'];
        $tempRow['company_name'] = $row['company_name'];
        $tempRow['site_area'] = $row['site_area'];
        $tempRow['revision'] = $row['revision'];
        $tempRow['prepared_by'] = $row['prepared_by'];
        $tempRow['date1'] = $row['date1'];
        $tempRow['sign1'] = $row['sign1'];
        $tempRow['dept'] = $row['dept'];
        $tempRow['date2'] = $row['date2'];
        $tempRow['sign2'] = $row['sign2'];
        $tempRow['scope'] = $row['scope'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'checklist_report' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'checklist_report') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `checklist_report` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `checklist_report` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `checklist_report`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="create-checklist-report-pdf.php?&date=' . $row['date'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Hazard Mapping PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['date'] = $row['date'];
        $tempRow['goggle'] = $row['goggle'];
        $tempRow['gloves'] = $row['gloves'];
        $tempRow['jacket'] = $row['jacket'];
        $tempRow['shoes'] = $row['shoes'];
        $tempRow['helmet'] = $row['helmet'];
        $tempRow['hand_sleevs'] = $row['hand_sleevs'];
        $tempRow['leg_gaurd'] = $row['leg_gaurd'];
        $tempRow['ear_plug'] = $row['ear_plug'];
        $tempRow['remark'] = $row['remark'];
        $tempRow['sign'] = $row['sign'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'ppe_data' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'ppe_data') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `ppe_data` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `ppe_data` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `ppe_data`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-ppe-data-pdf.php?date=' . $row['date'] . '&month=' . $row['month'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create PPE Data PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['doc_no'] = $row['doc_no'];
        $tempRow['rev'] = $row['rev'];
        $tempRow['effective_date'] = $row['effective_date'];
        $tempRow['month'] = $row['month'];
        $tempRow['emp_name'] = $row['emp_name'];
        $tempRow['emp_code'] = $row['emp_code'];
        $tempRow['designation'] = $row['designation'];
        $tempRow['helmet'] = $row['helmet'];
        $tempRow['safty_shoes'] = $row['safty_shoes'];
        $tempRow['visibility_vest'] = $row['visibility_vest'];
        $tempRow['safty_glases'] = $row['safty_glases'];
        $tempRow['hand_gloves'] = $row['hand_gloves'];
        $tempRow['face_shield'] = $row['face_shield'];
        $tempRow['ear_plugs'] = $row['ear_plugs'];
        $tempRow['shin_guards'] = $row['shin_guards'];
        $tempRow['dust_mask'] = $row['dust_mask'];
        $tempRow['hand_sleeves'] = $row['hand_sleeves'];
        $tempRow['leather_appron'] = $row['leather_appron'];
        $tempRow['remarks'] = $row['remarks'];
        $tempRow['checked_by'] = $row['checked_by'];
        $tempRow['reviewed_by'] = $row['reviewed_by'];
        $tempRow['date'] = $row['date'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'master_list' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'master_list') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `master_list` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `master_list` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `master_list`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="create-checklist-report-pdf.php?&date=' . $row['date'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Hazard Mapping PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['instrument_name'] = $row['instrument_name'];
        $tempRow['description'] = $row['description'];
        $tempRow['qty'] = $row['qty'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'tools_checklist' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'tools_checklist') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `tools_checklist` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `tools_checklist` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `tools_checklist`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="create-checklist-report-pdf.php?&date=' . $row['date'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Hazard Mapping PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['tool_list'] = $row['tool_list'];
        $tempRow['inspection_date'] = $row['inspection_date'];
        $tempRow['due_date'] = $row['due_date'];
        $tempRow['remark'] = $row['remark'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'houskeeping_process' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'houskeeping_process') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `houskeeping_process` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `houskeeping_process` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `houskeeping_process`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-houskeeping-process-pdf.php?&date=' . $row['date'] . '&department=' . $row['department'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Housekeeping Process PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['contractor_name'] = $row['contractor_name'];
        $tempRow['section'] = $row['section'];
        $tempRow['department'] = $row['department'];
        $tempRow['date'] = $row['date'];
        $tempRow['review_subject'] = $row['review_subject'];
        $tempRow['satisfactory_yes'] = $row['satisfactory_yes'];
        $tempRow['mom_satisfactory_no'] = $row['mom_satisfactory_no'];
        $tempRow['remark'] = $row['remark'];
        $tempRow['action'] = $row['action'];
        $tempRow['additional_remark'] = $row['additional_remark'];
        $tempRow['inspected_by'] = $row['inspected_by'];
        $tempRow['verify_by'] = $row['verify_by'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'houskeeping_checklist' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'houskeeping_checklist') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `houskeeping_checklist` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `houskeeping_checklist` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `houskeeping_checklist`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-houskeeping-checklist-pdf.php?&audit_name=' . $row['audit_name'] . '&audit_date=' . $row['audit_date'] . '&area=' . $row['area'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Housekeeping Process PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['form_no'] = $row['form_no'];
        $tempRow['format_no'] = $row['format_no'];
        $tempRow['audit_name'] = $row['audit_name'];
        $tempRow['audit_date'] = $row['audit_date'];
        $tempRow['member_present'] = $row['member_present'];
        $tempRow['area'] = $row['area'];
        $tempRow['check_point_type1'] = $row['check_point_type1'];
        $tempRow['check_point_action1'] = $row['check_point_action1'];
        $tempRow['check_point_type2'] = $row['check_point_type2'];
        $tempRow['check_point_action2'] = $row['check_point_action2'];
        $tempRow['check_point_type3'] = $row['check_point_type3'];
        $tempRow['check_point_action3'] = $row['check_point_action3'];
        $tempRow['check_point_type4'] = $row['check_point_type4'];
        $tempRow['check_point_action4'] = $row['check_point_action4'];
        $tempRow['check_point_type5'] = $row['check_point_type5'];
        $tempRow['check_point_action5'] = $row['check_point_action5'];
        $tempRow['check_point_type6'] = $row['check_point_type6'];
        $tempRow['check_point_action6'] = $row['check_point_action6'];
        $tempRow['check_point_type7'] = $row['check_point_type7'];
        $tempRow['check_point_action7'] = $row['check_point_action7'];
        $tempRow['check_point_type8'] = $row['check_point_type8'];
        $tempRow['check_point_action8'] = $row['check_point_action8'];
        $tempRow['check_point_type9'] = $row['check_point_type9'];
        $tempRow['check_point_action9'] = $row['check_point_action9'];
        $tempRow['check_point_type10'] = $row['check_point_type10'];
        $tempRow['check_point_action10'] = $row['check_point_action10'];
        $tempRow['check_point_type11'] = $row['check_point_type11'];
        $tempRow['check_point_action11'] = $row['check_point_action11'];
        $tempRow['check_point_type12'] = $row['check_point_type12'];
        $tempRow['check_point_action12'] = $row['check_point_action12'];
        $tempRow['check_point_type13'] = $row['check_point_type13'];
        $tempRow['check_point_action13'] = $row['check_point_action13'];
        $tempRow['check_point_type14'] = $row['check_point_type14'];
        $tempRow['check_point_action14'] = $row['check_point_action14'];
        $tempRow['check_point_type15'] = $row['check_point_type15'];
        $tempRow['check_point_action15'] = $row['check_point_action15'];
        $tempRow['check_point_type16'] = $row['check_point_type16'];
        $tempRow['check_point_action16'] = $row['check_point_action16'];
        $tempRow['check_point_type17'] = $row['check_point_type17'];
        $tempRow['check_point_action17'] = $row['check_point_action17'];
        $tempRow['check_point_type18'] = $row['check_point_type18'];
        $tempRow['check_point_action18'] = $row['check_point_action18'];
        $tempRow['check_point_type19'] = $row['check_point_type19'];
        $tempRow['check_point_action19'] = $row['check_point_action19'];
        $tempRow['check_point_type20'] = $row['check_point_type20'];
        $tempRow['check_point_action20'] = $row['check_point_action20'];
        $tempRow['check_point_type21'] = $row['check_point_type21'];
        $tempRow['check_point_action21'] = $row['check_point_action21'];
        $tempRow['check_point_type22'] = $row['check_point_type22'];
        $tempRow['check_point_action22'] = $row['check_point_action22'];
        $tempRow['check_point_type23'] = $row['check_point_type23'];
        $tempRow['check_point_action23'] = $row['check_point_action23'];
        $tempRow['check_point_type24'] = $row['check_point_type24'];
        $tempRow['check_point_action24'] = $row['check_point_action24'];
        $tempRow['check_point_type25'] = $row['check_point_type25'];
        $tempRow['check_point_action25'] = $row['check_point_action25'];
        $tempRow['audit_member_sign'] = $row['audit_member_sign'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'NEWS' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'news') {
    // print_r($_GET);

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `newsliner` like '%" . $search . "%' OR `date` like '%" . $search . "%' ";
    }
    /*
    if (isset($_GET['category_id']) && $_GET['category_id'] != '') {
        $category_id = $db->escapeString($fn->xss_clean($_GET['category_id']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and b.`category_id`=' . $category_id;
        else
            $where = ' where b.`category_id`=' . $category_id;
    }*/

    $sql = "SELECT COUNT(`id`) as total FROM `news`" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `news` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = ' <a href="edit-news.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-news.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['newsliner'] = $row['newsliner'];
        $tempRow['date'] = $row['date'];
        $tempRow['time'] = $row['time'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'strip_training_attand_sheet' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'strip_training_attand_sheet') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `strip_training_attand_sheet` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `strip_training_attand_sheet` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `strip_training_attand_sheet`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a class="btn btn-xs btn-warning" href="create-strip-training-attand-sheet-pdf.php?&date=' . $row['date'] . '&training_course=' . $row['training_course'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Housekeeping Process PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['format_no'] = $row['format_no'];
        $tempRow['form_no'] = $row['form_no'];
        $tempRow['page'] = $row['page'];
        $tempRow['training_course'] = $row['training_course'];
        $tempRow['trainer_name'] = $row['trainer_name'];
        $tempRow['description'] = $row['description'];
        $tempRow['date'] = $row['date'];
        $tempRow['trainer_signature'] = $row['trainer_signature'];
        $tempRow['emp_id'] = $row['emp_id'];
        $tempRow['emp_no'] = $row['emp_no'];
        $tempRow['emp_name'] = $row['emp_name'];
        $tempRow['emp_sign'] = $row['emp_sign'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'grivance_records' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'grivance_records') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $_GET['offset'];
    if (isset($_GET['limit']))
        $limit = $_GET['limit'];

    if (isset($_GET['sort']))
        $sort = $_GET['sort'];
    if (isset($_GET['order']))
        $order = $_GET['order'];
    /*
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " Where `id` like '%" . $search . "%' OR `emp_no` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `mobile` like '%" . $search . "%' OR `emp_designation_name` like '%" . $search . "%'";
    }
    */
    $date = date("Y-m-d");

    $sql = "SELECT COUNT(*) as total FROM `grivance_records` " . $where;
    //$sql = "SELECT COUNT(*) as total FROM `grivance_records` WHERE weight != ''";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `grivance_records`" . $where;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        //$operate = '<a class="btn btn-xs btn-warning" href="create-grivance-records-pdf.php?&date=' . $row['date'] . '&training_course=' . $row['training_course'] . '&location_id=' . $row['location_id'] . '"><i class="fa fa-folder-open-o"></i>Create Housekeeping Process PDF</a>';
        //$operate .= '<a class="btn btn-xs btn-warning" href="create_offer.php?id=' . $row['id'] . '"><i class="fa fa-folder-open-o"></i>Generate Offer Letter</a>';
        //$operate .= ' <a class="btn btn-xs btn-success" href="create-appointment.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Appointment Letter</a><br>';
        //$operate = ' <a class="btn btn-xs btn-info" href="create-salary-slip.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Generate Salary Slip</a><br>';

        //$operate .= '<a href="viewPDF.php?id=' . $row['user_id'] . '"><i class="fa fa-folder-open-o"></i>View PDF</a>';
        /* 
		$dropdown = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        <option value="">Select...</option>
        <option class="btn btn-xs btn-info view-emp-family" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewEmpFamily" value="">View Address</option>
        <option value="create_offer.php?id=' . $row['id'] . '">Generate Diet Plan</option>
        <option value="create-appointment-form.php?id=' . $row['id'] . '">View Diet Plan</option>
        </select>';
       */
        //$tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['grivance_open'] = $row['grivance_open'];
        $tempRow['grivance_close'] = $row['grivance_close'];
        $tempRow['month'] = $row['month'];
        $tempRow['year'] = $row['year'];
        $tempRow['date'] = $row['date'];
        $tempRow['prepared_by_name'] = $row['prepared_by_name'];
        $tempRow['prepared_by_sign'] = $row['prepared_by_sign'];
        $tempRow['checked_by_name'] = $row['checked_by_name'];
        $tempRow['checked_by_sign'] = $row['checked_by_sign'];
        $tempRow['location_id'] = $row['location_id'];
        $tempRow['location'] = $row['location'];
        $tempRow['created_at'] = $row['created_at'];
        $tempRow['updated_at'] = $row['updated_at'];
        //$tempRow['operate'] = $dropdown;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'parties' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'parties') {
    // print_r($_GET);

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `amount` like '%" . $search . "%' ";
    }
    /*
    if (isset($_GET['category_id']) && $_GET['category_id'] != '') {
        $category_id = $db->escapeString($fn->xss_clean($_GET['category_id']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and b.`category_id`=' . $category_id;
        else
            $where = ' where b.`category_id`=' . $category_id;
    }*/

    $sql = "SELECT COUNT(`id`) as total FROM `parties`" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `parties` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = '<a class="btn btn-xs btn-info view_party_transact" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewParty" title="View Info"><i class="fa fa-credit-card"></i></a>&nbsp;';
        $operate .= ' <a href="edit-party.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-party.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['amount'] = $row['amount'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'party_transaction' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'party_transaction') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `type` like '%" . $search . "%' OR `number` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `total` like '%" . $search . "%' OR `balance` like '%" . $search . "%'";
    }

    if (isset($_GET['party_id']) && !empty($_GET['party_id'])) {
        $party_id = $db->escapeString($fn->xss_clean($_GET['party_id']));
        $where .= !empty($where) ? ' AND party_id = ' . $emp_id : ' WHERE party_id = ' . $party_id;
    }
    $sql = "SELECT COUNT(party_id) as total FROM `transaction`" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `transaction`" . $where . " ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $tempRow['id'] = $row['id'];
        $tempRow['type'] = $row['type'];
        $tempRow['number'] = $row['number'];
        $tempRow['date'] = $row['date'];
        $tempRow['total'] = $row['total'];
        $tempRow['balance'] = $row['balance'];

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'bank' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'bank') {
    // print_r($_GET);

    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `name` like '%" . $search . "%' OR `amount` like '%" . $search . "%' ";
    }
    /*
    if (isset($_GET['category_id']) && $_GET['category_id'] != '') {
        $category_id = $db->escapeString($fn->xss_clean($_GET['category_id']));
        if (isset($_GET['search']) and $_GET['search'] != '')
            $where .= ' and b.`category_id`=' . $category_id;
        else
            $where = ' where b.`category_id`=' . $category_id;
    }*/

    $sql = "SELECT COUNT(`id`) as total FROM `bank`" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `bank` " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $operate = '<a class="btn btn-xs btn-info view_bank_transact" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#ViewParty" title="View Info"><i class="fa fa-credit-card"></i></a>&nbsp;';
        $operate .= ' <a href="edit-party.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-party.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';

        $tempRow['operate'] = $operate;
        $tempRow['id'] = $row['id'];
        $tempRow['bank_name'] = $row['bank_name'];
        $tempRow['amount'] = $row['amount'];
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

// data of 'bank_transaction' table goes here
if (isset($_GET['table']) && $_GET['table'] == 'bank_transaction') {
    $where = '';
    $offset = (isset($_GET['offset']) && !empty($_GET['offset']) && is_numeric($_GET['offset'])) ? $db->escapeString($_GET['offset']) : 0;
    $limit = (isset($_GET['limit']) && !empty($_GET['limit']) && is_numeric($_GET['limit'])) ? $db->escapeString($_GET['limit']) : 10;
    $sort = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $db->escapeString($_GET['sort']) : 'id';
    $order = (isset($_GET['order']) && !empty($_GET['order'])) ? $db->escapeString($_GET['order']) : 'DESC';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= " Where `id` like '%" . $search . "%' OR `type` like '%" . $search . "%' OR `number` like '%" . $search . "%' OR `date` like '%" . $search . "%' OR `total` like '%" . $search . "%' OR `balance` like '%" . $search . "%'";
    }

    if (isset($_GET['bank_id']) && !empty($_GET['bank_id'])) {
        $bank_id = $db->escapeString($fn->xss_clean($_GET['bank_id']));
        $where .= !empty($where) ? ' AND bank_id = ' . $emp_id : ' WHERE bank_id = ' . $bank_id;
    }
    $sql = "SELECT COUNT(bank_id) as total FROM `transaction`" . $where;
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `transaction`" . $where . " ORDER BY `" . $sort . "` " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();
    $bulkData = array();
    $bulkData['total'] = $total;
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        $tempRow['id'] = $row['id'];
        $tempRow['type'] = $row['type'];
        $tempRow['number'] = $row['number'];
        $tempRow['date'] = $row['date'];
        $tempRow['amount'] = $row['total'];
        //$tempRow['balance'] = $row['balance'];

        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

$db->disconnect();
