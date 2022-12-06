<?php

//fetch_data.php

session_start();
$ip_add = getenv("REMOTE_ADDR");
include_once('includes/crud.php');
$db = new Database();
$db->connect();
include_once('includes/custom-functions.php');
$function = new custom_functions();
$settings = $function->get_settings('system_timezone', true);
$app_name = $settings['app_name'];
$config = $function->get_configurations();
if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}

//$prod_id = $_POST['prod_name']; print_r($prod_id);
//$prod_id = implode("','", $_POST["location"]);

if (isset($_POST["action"])) {
    $sql = "SELECT product_variant.*, products.name AS pname, products.location AS plocation FROM `product_variant` INNER JOIN `products` ON products.id = product_variant.product_id WHERE products.status = '1' ";
    //$sql = "SELECT * FROM products WHERE status = '1' ";
    if (isset($_POST["prod_name"])) {
        $prod_id = implode("','", $_POST["prod_name"]);
        $sql .= "
   AND `product_variant.product_id` IN('" . $prod_id . "')
  ";
    }
    $sql .= " ORDER BY `product_variant`.`id` ASC";
    $db->sql($sql);
    print_r($sql);
    //$result = $db->fetchAll();
    //$total_row = $db->rowCount();
    $result = $db->getResult();
    print_r($result);
    $output = ''; //print_r($output);
    //if ($total_row > 0) {
    foreach ($result as $row) {
        $output .= '
            
        <form method="POST" action="jobdetail.php" style="width: 100%;"><br />
        <a href="#" style="width: 100%;">

        <ul>
			<li><i class="fa fa-map-marker"></i> ' . $row['pname'] . ' </li>
			<li><i class="fa fa-bookmark-o"></i> ' .  $row['plocation'] . ' </li>
		</ul>
        </a>
     
        </form>

        ';
    }
    /*} else {
        $output = '<h3>No Data Found</h3>';
    }*/
    echo $output; //print_r($output);
}
