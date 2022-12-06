<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql_query = "SELECT id, name FROM category ORDER BY id ASC";
$db->sql($sql_query);
$res = $db->getResult();
$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";

$db->sql($sql_query);

$res_cur = $db->getResult();
if (isset($_POST['btnAdd'])) {
    if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
        echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
        return false;
    }
    if ($permissions['products']['create'] == 1) {
        $target_path = './upload/images/';
        if (!is_dir($target_path)) {
            mkdir($target_path, 0777, true);
        }

        $name = $db->escapeString($fn->xss_clean($_POST['name']));
        $tax_id = (isset($_POST['tax_id']) && $_POST['tax_id'] != '') ? $db->escapeString($fn->xss_clean($_POST['tax_id'])) : 0;
        $slug = $function->slugify($db->escapeString($fn->xss_clean($_POST['name'])));
        $category_id = $db->escapeString($fn->xss_clean($_POST['category_id']));
        $subcategory_id = (isset($_POST['subcategory_id']) && $_POST['subcategory_id'] != '') ? $db->escapeString($fn->xss_clean($_POST['subcategory_id'])) : 0;
        $serve_for = $db->escapeString($fn->xss_clean($_POST['serve_for']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        $shipping_delivery = (isset($_POST['shipping_delivery']) && $_POST['shipping_delivery'] != '') ? $db->escapeString($fn->xss_clean($_POST['shipping_delivery'])) : '';

        $manufacturer = (isset($_POST['manufacturer']) && $_POST['manufacturer'] != '') ? $db->escapeString($fn->xss_clean($_POST['manufacturer'])) : '';
        $made_in = (isset($_POST['made_in']) && $_POST['made_in'] != '') ? $db->escapeString($fn->xss_clean($_POST['made_in'])) : '';
        $indicator = (isset($_POST['indicator']) && $_POST['indicator'] != '') ? $db->escapeString($fn->xss_clean($_POST['indicator'])) : '0';
        $return_status = (isset($_POST['return_status']) && $_POST['return_status'] != '') ? $db->escapeString($fn->xss_clean($_POST['return_status'])) : '0';
        $cancelable_status = (isset($_POST['cancelable_status']) && $_POST['cancelable_status'] != '') ? $db->escapeString($fn->xss_clean($_POST['cancelable_status'])) : '0';
        $cod_allowed = (!isset($_POST['cod_allowed_status']) && $_POST['cod_allowed_status'] == '') ? $db->escapeString($fn->xss_clean($_POST['cod_allowed_status'])) : '1';
        $till_status = (isset($_POST['till_status']) && $_POST['till_status'] != '') ? $db->escapeString($fn->xss_clean($_POST['till_status'])) : '';
        $total_allowed_quantity = (isset($_POST['total_allowed_quantity']) && !empty($_POST['total_allowed_quantity'])) ? $db->escapeString($fn->xss_clean($_POST['total_allowed_quantity'])) : 0;

        $error = array();

        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($tax_id)) {
            $error['tax_id'] = " <span class='label label-danger'>Required!</span>";
        }

        if ($cancelable_status == 1 && $till_status == '') {
            $error['cancelable'] = " <span class='label label-danger'>Required!</span>";
        }

        if (empty($category_id)) {
            $error['category_id'] = " <span class='label label-danger'>Required!</span>";
        }

        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }

        $allowedExts = array("gif", "jpeg", "jpg", "png");

        error_reporting(E_ERROR | E_PARSE);

        $error['other_images'] = $error['image'] = '';

        if ($_FILES["image"]["error"][0] == 0) {
            $image = $db->escapeString($fn->xss_clean($_FILES['image']['name']));
            $image_error = $db->escapeString($fn->xss_clean($_FILES['image']['error']));
            $image_type = $db->escapeString($fn->xss_clean($_FILES['image']['type']));

            $extension = end(explode(".", $_FILES["image"]["name"]));
            if ($image_error > 0) {
                $error['image'] = " <span class='label label-danger'>Not uploaded!</span>";
            } else {
                $result = $fn->validate_image($_FILES["image"]);
                if ($result) {
                    $error['image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!!!</span>";
                }
            }
        }

        if ($_FILES["size_chart"]["error"][0] == 0) {

            $size_chart = $db->escapeString($fn->xss_clean($_FILES['size_chart']['name']));
            $image_error1 = $db->escapeString($fn->xss_clean($_FILES['size_chart']['error']));
            $image_type1 = $db->escapeString($fn->xss_clean($_FILES['size_chart']['type']));

            if ($image_error1 > 0) {
                $error['size_chart'] = " <span class='label label-danger'>Not Uploaded!!</span>";
            } else {
                $result = $fn->validate_image($_FILES["size_chart"]);
                if ($result) {
                    $error['size_chart'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
                }
            }
        }

        if ($_FILES["other_images"]["error"][0] == 0) {
            for ($i = 0; $i < count($_FILES["other_images"]["name"]); $i++) {
                if ($_FILES["other_images"]["error"][$i] > 0) {
                    $error['other_images'] = " <span class='label label-danger'>Images not uploaded!</span>";
                } else {
                    $result = $fn->validate_other_images($_FILES["other_images"]["tmp_name"][$i], $_FILES["other_images"]["type"][$i]);
                    if ($result) {
                        $error['other_images'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
                    }
                }
            }
        }

        if (!empty($name) && !empty($category_id) && !empty($serve_for) && empty($error['cancelable']) && !empty($description)) {

            $string = '0123456789';

            $upload_image1 = "";
            $upload_image = "";
            $other_images = '';

            if (isset($_FILES['size_chart']) && !empty($_FILES['size_chart']['name'])) {
                $file1 = preg_replace("/\s+/", "_", $_FILES['size_chart']['name']);
                $extension1 = end(explode(".", $_FILES["size_chart"]["name"]));
                $size_chart = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension1;
                $upload = move_uploaded_file($_FILES['size_chart']['tmp_name'], 'upload/images/' . $size_chart);
                $upload_image1 = 'upload/images/' . $size_chart;
            }

            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;
                $file = preg_replace("/\s+/", "_", $_FILES['image']['name']);
                $upload = move_uploaded_file($_FILES['image']['tmp_name'], 'upload/images/' . $image);
                $upload_image = 'upload/images/' . $image;
            }

            if (isset($_FILES['other_images']) && ($_FILES['other_images']['size'][0] > 0)) {
                $file_data = array();
                $target_path = 'upload/other_images/';
                for ($i = 0; $i < count($_FILES["other_images"]["name"]); $i++) {

                    $filename = $_FILES["other_images"]["name"][$i];
                    $temp = explode('.', $filename);
                    $filename = microtime(true) . '-' . rand(100, 999) . '.' . end($temp);
                    $file_data[] = $target_path . '' . $filename;
                    if (!move_uploaded_file($_FILES["other_images"]["tmp_name"][$i], $target_path . '' . $filename))
                        echo "{$_FILES['image']['name'][$i]} not uploaded<br/>";
                }
                $other_images = json_encode($file_data);
            }


            $sql = "INSERT INTO products (size_chart,name,tax_id,slug,category_id,subcategory_id,image,other_images,description,shipping_delivery,indicator,manufacturer,made_in,return_status,cancelable_status, till_status,is_cod_allowed,total_allowed_quantity) VALUES('$upload_image1','$name','$tax_id','$slug','$category_id','$subcategory_id','$upload_image','$other_images','$description','$shipping_delivery','$indicator','$manufacturer','$made_in','$return_status','$cancelable_status','$till_status','$cod_allowed','$total_allowed_quantity')";
            $db->sql($sql);
            $product_result = $db->getResult();
            if (!empty($product_result)) {
                $product_result = 0;
            } else {
                $product_result = 1;
            }

            $sql = "SELECT id from products ORDER BY id DESC";
            $db->sql($sql);
            $res_inner = $db->getResult();
            if ($product_result == 1) {
                if ($_POST['type'] == 'packet') {
                    $packate_measurement = $db->escapeString($fn->xss_clean($_POST['packate_measurement']));
                    for ($i = 0; $i < count($_POST['packate_measurement_unit_id']); $i++) {
                        $variant_other_images = '';

                        if ($_FILES["packet_variant_images"]["error"][$i][0] == 0) {
                            for ($j = 0; $j < count($_FILES["packet_variant_images"]["name"][$i]); $j++) {
                                if ($_FILES["packet_variant_images"]["error"][$i][$j] > 0) {
                                    $error['packet_variant_images'] = " <span class='label label-danger'>Images not uploaded!</span>";
                                } else {
                                    $result = $fn->validate_other_images($_FILES["packet_variant_images"]["tmp_name"][$i][$j], $_FILES["packet_variant_images"]["type"][$i][$j]);
                                    if ($result) {
                                        $error['packet_variant_images'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
                                    }
                                }
                            }
                        }

                        if (isset($_FILES['packet_variant_images']) && (!empty($_FILES['packet_variant_images']['name'][$i][0])) && ($_FILES['packet_variant_images']['size'][$i][0] > 0)) {
                            $file_data = array();
                            $target_path1 = 'upload/variant_images/';
                            if (!is_dir($target_path1)) {
                                mkdir($target_path1, 0777, true);
                            }

                            for ($k = 0; $k < count($_FILES["packet_variant_images"]["name"][$i]); $k++) {
                                $filename = $_FILES["packet_variant_images"]["name"][$i][$k];
                                $temp = explode('.', $filename);
                                $filename = microtime(true) . '-' . rand(100, 999) . '.' . end($temp);
                                $file_data[] = $target_path1 . '' . $filename;
                                if (!move_uploaded_file($_FILES["packet_variant_images"]["tmp_name"][$i][$k], $target_path1 . '' . $filename))
                                    echo "{$_FILES['packet_variant_images']['name'][$i][$k]} not uploaded<br/>";
                            }
                            $variant_other_images = json_encode($file_data);
                        }

                        $product_id = $db->escapeString($res_inner[0]['id']);
                        $type = $db->escapeString($fn->xss_clean($_POST['type']));
                        $measurement = $db->escapeString($fn->xss_clean($_POST['packate_measurement'][$i]));
                        $measurement_unit_id = $db->escapeString($fn->xss_clean($_POST['packate_measurement_unit_id'][$i]));

                        $price = $db->escapeString($fn->xss_clean($_POST['packate_price'][$i]));
                        $discounted_price = !empty($_POST['packate_discounted_price'][$i]) ? $db->escapeString($fn->xss_clean($_POST['packate_discounted_price'][$i])) : 0;
                        $serve_for = $db->escapeString($fn->xss_clean($_POST['packate_serve_for'][$i]));
                        $stock = $db->escapeString($fn->xss_clean($_POST['packate_stock'][$i]));
                        $serve_for = ($stock == 0 || $stock <= 0) ? 'Sold Out' : $serve_for;
                        $stock_unit_id = $db->escapeString($fn->xss_clean($_POST['packate_stock_unit_id'][$i]));

                        $sql = "INSERT INTO product_variant (product_id,type,measurement,measurement_unit_id,price,discounted_price,serve_for,stock,stock_unit_id,images) VALUES('$product_id','$type','$measurement','$measurement_unit_id','$price','$discounted_price','$serve_for','$stock','$stock_unit_id','$variant_other_images')";
                        $db->sql($sql);
                        $product_variant = $db->getResult();
                    }
                    if (!empty($product_variant)) {
                        $product_variant = 0;
                    } else {
                        $product_variant = 1;
                    }
                } elseif ($_POST['type'] == "loose") {
                    for ($i = 0; $i < count($_POST['loose_measurement_unit_id']); $i++) {
                        $variant_other_images = '';

                        if ($_FILES["loose_variant_images"]["error"][$i][0] == 0) {
                            for ($j = 0; $j < count($_FILES["loose_variant_images"]["name"][$i]); $j++) {
                                if ($_FILES["loose_variant_images"]["error"][$i][$j] > 0) {
                                    $error['loose_variant_images'] = " <span class='label label-danger'>Images not uploaded!</span>";
                                } else {
                                    $result = $fn->validate_other_images($_FILES["loose_variant_images"]["tmp_name"][$i][$j], $_FILES["loose_variant_images"]["type"][$i][$j]);
                                    if ($result) {
                                        $error['loose_variant_images'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
                                    }
                                }
                            }
                        }

                        if (isset($_FILES['loose_variant_images']) && (!empty($_FILES['loose_variant_images']['name'][$i][0])) && ($_FILES['loose_variant_images']['size'][$i][0] > 0)) {
                            $file_data = array();
                            $target_path1 = 'upload/variant_images/';
                            if (!is_dir($target_path1)) {
                                mkdir($target_path1, 0777, true);
                            }

                            for ($k = 0; $k < count($_FILES["loose_variant_images"]["name"][$i]); $k++) {
                                $filename = $_FILES["loose_variant_images"]["name"][$i][$k];
                                $temp = explode('.', $filename);
                                $filename = microtime(true) . '-' . rand(100, 999) . '.' . end($temp);
                                $file_data[] = $target_path1 . '' . $filename;
                                if (!move_uploaded_file($_FILES["loose_variant_images"]["tmp_name"][$i][$k], $target_path1 . '' . $filename))
                                    echo "{$_FILES['loose_variant_images']['name'][$i][$k]} not uploaded<br/>";
                            }
                            $variant_other_images = json_encode($file_data);
                        }

                        $product_id = $db->escapeString($res_inner[0]['id']);
                        $type = $db->escapeString($fn->xss_clean($_POST['type']));
                        $measurement = $db->escapeString($fn->xss_clean($_POST['loose_measurement'][$i]));
                        $measurement_unit_id = $db->escapeString($fn->xss_clean($_POST['loose_measurement_unit_id'][$i]));
                        $price = $db->escapeString($fn->xss_clean($_POST['loose_price'][$i]));
                        $discounted_price = !empty($_POST['loose_discounted_price'][$i]) ? $db->escapeString($fn->xss_clean($_POST['loose_discounted_price'][$i])) : 0;
                        $serve_for = $db->escapeString($fn->xss_clean($_POST['serve_for']));
                        $stock = $db->escapeString($fn->xss_clean($_POST['loose_stock_name']));
                        $serve_for = ($stock == 0 || $stock <= 0) ? 'Sold Out' : $serve_for;
                        $stock_unit_id = $db->escapeString($fn->xss_clean($_POST['loose_stock_unit_id']));

                        $sql = "INSERT INTO product_variant (product_id,type,measurement,measurement_unit_id,price,discounted_price,serve_for,stock,stock_unit_id,images) VALUES('$product_id','$type','$measurement','$measurement_unit_id','$price','$discounted_price','$serve_for','$stock','$stock_unit_id','$variant_other_images')";
                        $db->sql($sql);
                        $product_variant = $db->getResult();
                    }
                    if (!empty($product_variant)) {
                        $product_variant = 0;
                    } else {
                        $product_variant = 1;
                    }
                }
            }
            if ($product_result == 1 && $product_variant == 1) {
                $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Product Added Successfully</span>
                                                <h4><small><a  href='products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Products</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }
        }
    } else {
        $error['check_permission'] = " <section class='content-header'> <span class='label label-danger'>You have no permission to create product</span></section>";
    }
}
?>
<section class="content-header">
    <h1>JOINING REPORT &</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if ($permissions['products']['create'] == 0) { ?>
                <div class="alert alert-danger">You have no permission to create product.</div>
            <?php } ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">EMPLOYEE INFORMATION SHEET</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>
                <form id='add_product_form' method="post" enctype="multipart/form-data">
                    <?php
                    $sql = "SELECT * FROM unit";
                    $db->sql($sql);
                    $res_unit = $db->getResult();
                    ?>
                    <div class="box-body">
                        <div class="form-group">
                            <div class='col-md-12' style="padding-bottom: 15px;">
                                <label for="exampleInputEmail1">Employee Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class='col-md-4'>
                                <label for="exampleInputEmail1">DATE OF BIRTH</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                <input type="text" class="form-control" name="dob" required>
                            </div>
                            <div class='col-md-4'>
                                <label for="exampleInputEmail1">WEIGHT</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                <input type="text" class="form-control" name="weight" required>
                            </div>
                            <div class='col-md-4'>
                                <label for="exampleInputEmail1">HEIGHT</label> <i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                <input type="text" class="form-control" name="height" required>
                            </div>
                        </div>
                        
                        <label for="type"><br></label><?= isset($error['type']) ? $error['type'] : ''; ?>
                        <div class="form-group" style="visibility: hidden;">
                            <label class="radio-inline"><input type="radio" name="type" id="packate" value="packet" checked>Packet</label>
                            <label class="radio-inline"><input type="radio" name="type" id="loose" value="loose">Loose</label>
                        </div>
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>EMPLOYEE FAMILY DETAILS</b></h3>
                        </div>
                        <hr>
                        <div id="packate_div" style="display:none">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputEmail1">Name</label> <i class="text-danger asterik">*</i>
                                        <input type="text" class="form-control measurement" name="fam_name[]" required id="f_name" />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group packate_div">
                                    <label for="exampleInputEmail1">Age</label> <i class="text-danger asterik">*</i>
                                        <input type="number" step="any" min="0" class="form-control measurement" name="fam_age[]" required id="f_age" />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group packate_div">
                                    <label for="exampleInputEmail1">Sex</label> <i class="text-danger asterik">*</i>
                                        <input type="text" class="form-control measurement" name="fam_sex[]" required id="f_sex" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group packate_div">
                                    <label for="exampleInputEmail1">RELATION</label> <i class="text-danger asterik">*</i>
                                        <input type="text" class="form-control measurement" name="fam_rel[]" required id="f_rel" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group packate_div">
                                    <label for="exampleInputEmail1">OCCUPATION</label> <i class="text-danger asterik">*</i>
                                        <input type="text" class="form-control measurement" name="fam_occu[]" required id="f_occu" />
                                    </div>
                                </div>
                                
                                <div class="col-md-1">
                                    <label>Variation</label>
                                    <a id="add_packate_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                </div>
                                <!--<div class="col-md-6">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputFile">Variant Images &nbsp;&nbsp;&nbsp;(Please choose square image of larger than 350px*350px & smaller than 550px*550px.)</label>
                                        <input type="file" name="packet_variant_images[0][]" id="packet_variant_images" multiple /><br />
                                    </div>
                                </div>-->
                            </div>
                        </div>


                        <div id="loose_div" style="display:none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group loose_div">
                                        <label for="exampleInputEmail1">Measurement</label> <i class="text-danger asterik">*</i>
                                        <input type="number" step="any" min="0" class="form-control measurement" id="l_measurement" name="loose_measurement[]">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group loose_div">
                                        <label for="unit">Unit:</label>
                                        <select class="form-control loose_units" name="loose_measurement_unit_id[]">
                                            <?php
                                            foreach ($res_unit as  $row) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['short_code'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group loose_div">
                                        <label for="price">Price (<?= $settings['currency'] ?>):</label> <i class="text-danger asterik">*</i>
                                        <input type="number" step="any" min="0" class="form-control" name="loose_price[]" id="loose_price">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group loose_div">
                                        <label for="discounted_price">Discounted Price(<?= $settings['currency'] ?>):</label>
                                        <input type="number" step="any" min="0" class="form-control" name="loose_discounted_price[]" id="discounted_price" />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label>Variation</label>
                                    <a id="add_loose_variation" title="Add variation of product" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group packate_div">
                                        <label for="exampleInputFile">Variant Images &nbsp;&nbsp;&nbsp;(Please choose square image of larger than 350px*350px & smaller than 550px*550px.)</label>
                                        <input type="file" name="loose_variant_images[0][]" id="loose_variant_images" class="loose_vari_image" multiple /><br />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="variations">
                        </div>
                        <hr>
                        <div id="loose_stock_div" style="display:none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity">Stock :</label> <i class="text-danger asterik">*</i><?php echo isset($error['quantity']) ? $error['quantity'] : ''; ?>
                                        <input type="number" step="any" min="0" class="form-control" name="loose_stock_name" id="l_stock"><br>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock_unit"> Unit :</label><?php echo isset($error['stock_unit']) ? $error['stock_unit'] : ''; ?>
                                        <select class="form-control" name="loose_stock_unit_id" id="loose_stock_unit_id">
                                            <?php
                                            foreach ($res_unit as $row) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['short_code'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="packate_server_hide">
                            <label for="serve_for">Status :</label><?php echo isset($error['serve_for']) ? $error['serve_for'] : ''; ?>
                            <select name="serve_for" class="form-control" required>
                                <option value="Available">Available</option>
                                <option value="Sold Out">Sold Out</option>
                            </select>
                            <br />
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category :</label> <i class="text-danger asterik">*</i><?php echo isset($error['category_id']) ? $error['category_id'] : ''; ?>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">--Select Category--</option>
                                <?php if ($permissions['categories']['read'] == 1) { ?>
                                    <?php foreach ($res as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php }
                                } ?>
                            </select>
                            <br />
                        </div>
                        <div class="form-group">
                            <label for="subcategory_id">Sub Category :</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control">
                                <option value="">--Select Sub Category--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Product Type :</label>
                            <select name="indicator" id="indicator" class="form-control">
                                <option value="0">--Select Type--</option>
                                <option value="1">Veg</option>
                                <option value="2">Non Veg</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Manufacturer :</label>
                            <input type="text" name="manufacturer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Made In :</label>
                            <input type="text" name="made_in" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Is Returnable? :</label><br>
                                    <input type="checkbox" id="return_status_button" class="js-switch">
                                    <input type="hidden" id="return_status" name="return_status">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Is cancel-able? :</label><br>
                                    <input type="checkbox" id="cancelable_button" class="js-switch">
                                    <input type="hidden" id="cancelable_status" name="cancelable_status">
                                </div>
                            </div>
                            <div class="col-md-3" id="till-status" style="display:none">
                                <div class="form-group">
                                    <label for="">Till which status? :</label> <i class="text-danger asterik">*</i> <?php echo isset($error['cancelable']) ? $error['cancelable'] : ''; ?><br>
                                    <select id="till_status" name="till_status" class="form-control">
                                        <option value="">Select</option>
                                        <option value="received">Received</option>
                                        <option value="processed">Processed</option>
                                        <option value="shipped">Shipped</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Is Cod Allowed? :</label><br>
                                    <input type="checkbox" id="cod_allowed_button" class="js-switch">
                                    <input type="hidden" id="cod_allowed_status" name="cod_allowed_status">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Total allowed quantity : <small>[Keep blank if no such limit]</small></label>
                                    <input type="number" min="1" class="form-control" name="total_allowed_quantity" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Main Image : <i class="text-danger asterik">*</i>&nbsp;&nbsp;&nbsp;*Please choose square image of 600px</label><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                            <input type="file" name="image" id="image" required>
                        </div>
                        <div class="form-group">
                            <label for="other_images">Other Images of the Product: *Please choose square image of larger than 350px*350px & smaller than 550px*550px.</label><?php echo isset($error['other_images']) ? $error['other_images'] : ''; ?>
                            <input type="file" name="other_images[]" id="other_images" multiple>
                        </div>
                        <div class="form-group">
                            <label for="size_chart">Size Chart : &nbsp;&nbsp;&nbsp;*Please choose square image of larger than 350px*350px & smaller than 550px*550px.</label><?php echo isset($error['size_chart']) ? $error['size_chart'] : ''; ?>
                            <input type="file" name="size_chart" id="size_chart">
                        </div>
                        <div class="form-group">
                            <label for="description">Description :</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                            <textarea name="description" id="description" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('description');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="shipping_delivery">shipping & Delivery :</label>
                            <textarea name="shipping_delivery" id="shipping_delivery" class="form-control" rows="4"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('shipping_delivery');
                            </script>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="dist/js/jquery.validate.min.js"></script>
<script>
    var changeCheckbox = document.querySelector('#cod_allowed_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#cod_allowed_status').val(1);
        } else {
            $('#cod_allowed_status').val(0);
        }
    };
</script>
<script>
    var changeCheckbox = document.querySelector('#return_status_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#return_status').val(1);
        } else {
            $('#return_status').val(0);
        }
    };
</script>

<script>
    var changeCheckbox = document.querySelector('#cancelable_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#cancelable_status').val(1);
            $('#till-status').show();

        } else {
            $('#cancelable_status').val(0);
            $('#till-status').hide();
            $('#till_status').val('');
        }
    };
</script>
<script>
    if ($('#packate').prop('checked')) {
        $('#packate_div').show();
        $('#packate_server_hide').hide();
        $('.loose_div').children(":input").prop('disabled', true);
        $('#loose_stock_div').children(":input").prop('disabled', true);
    }

    $.validator.addMethod('lessThanEqual', function(value, element, param) {
        return this.optional(element) || parseInt(value) < parseInt($(param).val());
    }, "Discounted Price should be lesser than Price");
</script>
<script>
    var num = 2;
    var i = 1;

    $('#add_packate_variation').on('click', function() {
        html = '<div class="row"><div class="col-md-2"><div class="form-group"><label for="measurement">Measurement</label> <i class="text-danger asterik">*</i>' +
            '<input type="number" class="form-control measurement" name="packate_measurement[]" required="" step="any" min="0"></div></div>' +

            '<div class="col-md-2"><div class="form-group packate_div"><label for="exampleInputEmail1">RELATION</label> <i class="text-danger asterik">*</i>' +
            '<input type="text" class="form-control measurement" name="fam_rel[]" required id="f_rel" /></div></div>' +

            '<div class="col-md-2"><div class="form-group"><label for="price">Price(<?= $settings['currency'] ?>):</label> <i class="text-danger asterik">*</i>' +
            '<input type="number" step="any" min="0" class="form-control" name="packate_price[]" required=""></div></div>' +

            '<div class="col-md-2"><div class="form-group"><label for="discounted_price">Discounted Price(<?= $settings['currency'] ?>):</label>' +
            '<input type="number" step="any" min="0" class="form-control" name="packate_discounted_price[]" /></div></div>' +

            '<div class="col-md-1"><div class="form-group"><label for="stock">Stock:</label> <i class="text-danger asterik">*</i>' +
            '<input type="number" step="any" min="0" class="form-control" name="packate_stock[]" /></div></div>' +

            '<div class="col-md-1"><div class="form-group"><label for="unit">Unit:</label>' +
            '<select class="form-control" name="packate_stock_unit_id[]">' +
            '<?php
                foreach ($res_unit as  $row) {
                    echo "<option value=" . $row['id'] . ">" . $row['short_code'] . "</option>";
                }
                ?>' +
            '</select>' +
            '</div></div>' +
            '<div class="col-md-2"><div class="form-group packate_div"><label for="qty">Status:</label><select name="packate_serve_for[]" class="form-control" required><option value="Available">Available</option><option value="Sold Out">Sold Out</option></select></div></div>' +
            '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove_variation text-danger" title="Remove variation of product" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>' +

            '<div class="col-md-6">' +
            '<div class="form-group packate_div">' +
            '<label for="exampleInputFile">Variant Images &nbsp;&nbsp;&nbsp;(Please choose square image of larger than 350px*350px & smaller than 550px*550px.)</label>' +
            '<input type="file" name="packet_variant_images[' + i++ + '][]" id="packet_variant_images" multiple /><br />' +
            '</div></div>' +

            '</div>';

        $('#variations').append(html);
        $('#add_product_form').validate();
    });

    $('#add_loose_variation').on('click', function() {
        html = '<div class="row"><div class="col-md-4"><div class="form-group"><label for="measurement">Measurement</label> <i class="text-danger asterik">*</i>' +
            '<input type="number" step="any" min="0" class="form-control measurement" name="loose_measurement[]" required=""></div></div>' +
            '<div class="col-md-2"><div class="form-group loose_div">' +
            '<label for="unit">Unit:</label><select class="form-control loose_units" name="loose_measurement_unit_id[]">' +
            '<?php
                foreach ($res_unit as  $row) {
                    echo "<option value=" . $row['id'] . ">" . $row['short_code'] . "</option>";
                }
                ?>' +
            '</select></div></div>' +
            '<div class="col-md-3"><div class="form-group"><label for="price">Price  (<?= $settings['currency'] ?>):</label> <i class="text-danger asterik">*</i>' +
            '<input type="number" step="any" min="0" class="form-control" name="loose_price[]" required=""></div></div>' +
            '<div class="col-md-2"><div class="form-group"><label for="discounted_price">Discounted Price(<?= $settings['currency'] ?>):</label>' +
            '<input type="number" step="any"  min="0" class="form-control" name="loose_discounted_price[]" /></div></div>' +
            '<div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove_variation text-danger" title="Remove variation of product" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div>' +

            '<div class="col-md-6">' +
            '<div class="form-group packate_div">' +
            '<label for="exampleInputFile">Variant Images &nbsp;&nbsp;&nbsp;(Please choose square image of larger than 350px*350px & smaller than 550px*550px.)</label>' +
            '<input type="file" name="loose_variant_images[' + i++ + '][]" id="loose_variant_images" class="loose_vari_image" multiple /><br />' +
            '</div></div>' +

            '</div>';
        $('#variations').append(html);
    });
</script>
<script>
    $('#add_product_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            measurement: "required",
            price: "required",
            quantity: "required",
            image: "required",
            stock: "required",
            discounted_price: {
                lessThanEqual: "#price"
            },
            description: {
                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement();
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                    return editorcontent.length === 0;
                }
            }
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>
<script>
    $(document).on('click', '.remove_variation', function() {
        $(this).closest('.row').remove();
    });

    $(document).on('change', '#category_id', function() {
        $.ajax({
            url: "public/db-operation.php",
            data: "category_id=" + $('#category_id').val() + "&change_category=1",
            method: "POST",
            success: function(data) {
                $('#subcategory_id').html("<option value=''>---Select Subcategory---</option>" + data);
            }
        });
    });

    $(document).on('change', '#packate', function() {
        $('#variations').html("");
        $('#packate_div').show();
        $('#packate_server_hide').hide();
        $('.packate_div').children(":input").prop('disabled', false);
        $('#loose_div').hide();
        $('.loose_div').children(":input").prop('disabled', true);
        $('#loose_stock_div').hide();
        $('#loose_stock_unit_id').hide();
        $('#loose_stock_div').children(":input").prop('disabled', true);

        $('#l_measurement').attr('required', false);
        $('#p_measurement').attr('required', true);
        $('#loose_price').attr('required', false);
        $('#packate_price').attr('required', true);
        $('#l_stock').attr('required', false);
        $('#p_stock').attr('required', true);

    });
    $(document).on('change', '#loose', function() {
        $('#variations').html("");
        $('#packate_div').hide();
        $('#packate_server_hide').show();
        $('.packate_div').children(":input").prop('disabled', true);
        $('#loose_div').show();
        $('.loose_div').children(":input").prop('disabled', false);
        $('#loose_stock_div').show();
        $('#loose_stock_unit_id').show();
        $('#loose_stock_div').children(":input").prop('disabled', false);

        $('#loose_variant_images').prop('disabled', false);

        $('#l_measurement').attr('required', true);
        $('#p_measurement').attr('required', false);
        $('#loose_price').attr('required', true);
        $('#packate_price').attr('required', false);
        $('#l_stock').attr('required', true);
        $('#p_stock').attr('required', false);
    });
</script>