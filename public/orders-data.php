<?php
include_once('includes/variables.php');
include_once('includes/crud.php');
include_once('includes/custom-functions.php');
$function = new custom_functions();
$ID = (isset($_GET['id'])) ? $db->escapeString($function->xss_clean($_GET['id'])) : "";

// create array variable to handle error
$update_order_permission = $permissions['orders']['update'];
$allowed = ALLOW_MODIFICATION;
$pickup = $function->is_lockup($ID);
$error = array();
if (isset($_POST['update_order_status'])) {

    $process = $db->escapeString($function->xss_clean($_POST['status']));
}
// echo $sql = "SELECT oi.*,oi.id as order_item_id,oi.tax_amount*oi.quantity as tax_of_amount,oi.tax_percentage as percentage_of_tax,p.*,v.product_id, v.measurement,o.*,o.total as order_total,o.wallet_balance,oi.active_status as oi_active_status,u.email,u.name as uname,u.country_code,o.status as order_status,p.name as pname,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name ,oi.product_variant_id
//         FROM `order_items` oi
//         JOIN users u ON u.id=oi.user_id
//         JOIN product_variant v ON oi.product_variant_id=v.id
//         JOIN products p ON p.id=v.product_id
//         RIGHT JOIN orders o ON o.id=oi.order_id
//     WHERE o.id=" . $ID;

$sql = "SELECT oi.*,oi.id as order_item_id,oi.tax_amount*oi.quantity as tax_of_amount,oi.tax_percentage as percentage_of_tax,o.*,o.total as order_total,o.wallet_balance,
        oi.active_status as oi_active_status,u.email,u.name as uname,u.country_code,o.status as order_status,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name,
 p.id AS pro_id,p.name as pname,cancelable_status FROM `order_items` oi JOIN users u ON u.id=oi.user_id 
        LEFT JOIN product_variant v ON oi.product_variant_id=v.id LEFT JOIN products p ON p.id = v.product_id RIGHT JOIN orders o ON o.id=oi.order_id WHERE o.id=" . $ID;
$db->sql($sql);
$res = $db->getResult();

$sql1 = "SELECT obt.* FROM order_bank_transfers obt WHERE obt.order_id = $ID";
$db->sql($sql1);
$res1 = $db->getResult();

$items = [];
foreach ($res as $row) {
    $data = array($row['product_id'], $row['product_variant_id'], $row['product_name'], $row['variant_name'], $row['mesurement_unit_name'], $row['quantity'], $row['discounted_price'], $row['price'], $row['oi_active_status'], $row['cancelable_status'], $row['order_item_id'], $row['sub_total'], $row['tax_of_amount'], $row['percentage_of_tax'], $row['pro_id'], $row['pname']);
    array_push($items, $data);
}
?>
<section class="content-header">
    <h1>Order Detail</h1>
    <?php echo isset($error['update_data']) ? $error['update_data'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-9">
            <?php
            if ($permissions['orders']['read'] == 1) {
                if ($permissions['orders']['update'] == 0) { ?>
                    <div class="alert alert-danger topmargin-sm">You have no permission to update orders.</div>
                <?php } ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Detail</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <input type="hidden" name="hidden" id="order_id" value="<?php echo $res[0]['id']; ?>">
                                <th style="width: 10px">ID</th>
                                <td><?php echo $res[0]['id']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Name</th>
                                <td><?php echo $res[0]['uname']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Email</th>
                                <?php if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) { ?>
                                    <td> <?= str_repeat("*", strlen($res[0]['email']) - 13) . substr($res[0]['email'], -13); ?></td>
                                <?php } else { ?>
                                    <td> <?= $res[0]['email']; ?> </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <th style="width: 10px">Contact</th>
                                <?php if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) { ?>
                                    <td> <?= str_repeat("*", strlen($res[0]['mobile']) - 3) . substr($res[0]['mobile'], -3); ?></td>
                                <?php } else { ?>
                                    <td> <?= $res[0]['mobile']; ?> </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <th style="width: 10px">Customer Note</th>
                                <td><?php echo $res[0]['order_note']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Items</th>
                                <td><?php $total = 0;
                                    foreach ($items as $item) {
                                        // echo "<pre>";
                                        // print_r($item);
                                        // echo "<pre>";
                                        $active_status = "";
                                        if ($item[8] == 'received') {
                                            $active_status = '<label class="label label-primary">' . $item[8] . '</label>';
                                        }
                                        if ($item[8] == 'processed') {
                                            $active_status = '<label class="label label-info">' . $item[8] . '</label>';
                                        }
                                        if ($item[8] == 'shipped') {
                                            $active_status = '<label class="label label-warning">' . $item[8] . '</label>';
                                        }
                                        if ($item[8] == 'delivered') {
                                            $active_status = '<label class="label label-success">' . $item[8] . '</label>';
                                        }
                                        if ($item[8] == 'returned' || $item[8] == 'cancelled') {
                                            $active_status = '<label class="label label-danger">' . $item[8] . '</label>';
                                        }
                                        if ($row['active_status'] == 'awaiting_payment') {
                                            $active_status = '<label class="label label-secondary">Awaiting Payment</label>';
                                        }
                                        $total += $subtotal = ($item[6] != 0 && $item[6] < $item[7]) ? ($item[6] * $item[5]) : ($item[7] * $item[5]);
                                        $product_id = empty($item[14]) ? $item[0] : $item[14];
                                        $product_name = !empty($item[15]) ? $item[15] : $item[2];
                                        $unit = !empty($item[3]) ? $item[3] : $item[4];

                                        echo "<b>Product Id : </b>" . $product_id;
                                        echo "<b> Product Variant Id : </b>" . $item[1];
                                        echo " <b>Name : </b>" . $product_name;
                                        echo " <b>Unit : </b>" . $unit;
                                        echo " <b>Quantity : </b>" . $item[5];
                                        echo " <b>Price : </b>" . $item[7];
                                        echo " <b>Discounted Price : </b>" . $item[6];
                                        echo " <b>Tax Amount : </b>" . $item[12];
                                        echo " <b>Tax Percentage : </b>" . $item[13];
                                        echo " <b>Subtotal : </b>" . $item[11];
                                        echo " <b>Active Status : </b>" . $active_status . "
                                        <a href='" . DOMAIN_URL . "/view-product-variants.php?id=" . $item[0] . "' class='btn btn-success btn-xs' title='View Product'><i class='fa fa-eye'></i> Product</a>
                                       <br> <br>";
                                        if ($item[8] != 'returned' && $item[8] != 'cancelled') {
                                            echo "  <a href='#' class='btn btn-danger btn-xs update_order_item_status' data-value='" . $item[0] . "' data-value1='" . $item[10] . "' title='Cancel Product'><i class='fa fa-remove'></i> Cancel Product ? </a>
                                            <br>
                                            -----------------------------------<br>";
                                            echo "   <div class='alert alert-danger' id='result_fail1' style='display:none'></div>
                                            <div class='alert alert-success' id='result_success1' style='display:none'></div>";
                                        }
                                    } ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Total (<?= $settings['currency'] ?>)</th>
                                <td><?php echo $res[0]['order_total']; ?></td>
                            </tr>
                            <?php
                            if ($pickup == 0) {
                            ?>
                                <tr>
                                    <th style="width: 10px">D.Charge (<?= $settings['currency'] ?>)</th>
                                    <td><?php echo $res[0]['delivery_charge']; ?></td>

                                </tr>
                            <?php } ?>
                            <?php if ($res[0]['discount'] > 0) {
                                $discounted_amount = $res[0]['total'] * $res[0]['discount'] / 100; /*  */
                                $final_total = $res[0]['total'] - $discounted_amount;
                                $discount_in_rupees = $res[0]['total'] - $final_total;
                                $discount_in_rupees = $discount_in_rupees;
                            } else {
                                $discount_in_rupees = 0;
                            } ?>
                            <tr>
                                <th style="width: 10px">Disc. <?= $settings['currency'] ?>(%)</th>
                                <td><?php echo  $discount_in_rupees . '(' . $res[0]['discount'] . '%)'; ?></td>
                            </tr>

                            <tr>
                                <th style="width: 10px">Promo Disc. (<?= $settings['currency'] ?>)</th>
                                <td><?php echo $res[0]['promo_discount']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Wallet Used</th>
                                <td><?php echo $res[0]['wallet_balance']; ?></td>
                            </tr>


                            <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $res[0]['order_total']; ?>">
                            <input type="hidden" name="delivery_charge" id="delivery_charge" value="<?php echo $res[0]['delivery_charge']; ?>">
                            <input type="hidden" name="tax_amount" id="tax_amount" value="<?php echo $res[0]['tax_amount']; ?>">
                            <input type="hidden" name="promo_discount" id="promo_discount" value="<?php echo $res[0]['promo_discount']; ?>">
                            <input type="hidden" name="wallet_balance" id="wallet_balance" value="<?php echo $res[0]['wallet_balance']; ?>">
                            <?php
                            $total = $res[0]['total'];
                            $delivery_charge = $res[0]['delivery_charge'];
                            $tax_amount = $res[0]['tax_amount'];
                            $promo_discount = $res[0]['promo_discount'];
                            $wallet = $res[0]['wallet_balance'];
                            $final_total = $total + $delivery_charge + $tax_amount - $discount_in_rupees - $promo_discount - $wallet;
                            $f_total = $total + $delivery_charge + $tax_amount - $promo_discount - $wallet;
                            ?>
                            <input type="hidden" name="final_amount" id="final_amount" value="<?= $f_total; ?>">
                            <tr>
                                <th style="width: 10px">Discount %</th>
                                <td><input type="number" class="form-control" id="input_discount" name="input_discount" value="<?php echo $res[0]['discount']; ?>" min=0 max=100></td>
                                <td><a href="#" title='save_discout' class="btn btn-primary form-control update_order_total_payable" data-id='<?= $row['id']; ?>'>Save</a></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Payable Total(<?= $settings['currency'] ?>)</th>
                                <td><input type="text" class="form-control" id="final_total" name="final_total" value="<?= ceil($final_total); ?>" disabled></td>
                            </tr>
                            <?php
                            if ($pickup == 0) {
                            ?>
                                <tr>
                                    <th>Deliver By</th>
                                    <td>
                                        <?php
                                        $sql = "SELECT id,name,is_available FROM delivery_boys WHERE status=1";
                                        $db->sql($sql);
                                        $result = $db->getResult();
                                        ?>
                                        <select id='deliver_by' name='deliver_by' class='deliver_by form-control col-md-7 col-xs-12' required>
                                            <option value=''>Select Delivery Boy</option>
                                            <?php foreach ($result as $row1) { ?>
                                                <option value='<?= $row1['id'] ?>' id="<?= $row1['id'] ?>" <?= ($row1['is_available'] == 0) ? "disabled" : ""; ?> <?= ($res[0]['delivery_boy_id'] == $row1['id']) ? "selected" : "" ?>><?= $row1['name'] ?></option>
                                            <?php
                                            } ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <td><input type="hidden" class="form-control" id="deliver_by" name="deliver_by" value="<?= $res[0]['delivery_boy_id'] ?>"></td>
                            <?php } ?>
                            <tr>
                                <th style="width: 10px">Payment Method</th>
                                <td><?php echo $res[0]['payment_method']; ?></td>
                            </tr>
                            <?php if (!empty($res1)) { ?>
                                <tr>
                                    <th style="width: 10px">Bank Transfer</th>
                                    <td>
                                        <?php for ($i = 0; $i < count($res1); $i++) { ?>
                                            <img src="<?php echo $res1[$i]['attachment']; ?>" height="100" />
                                            <a class='btn btn-xs btn-danger delete-image' data-i='<?= $res1[$i]['id']; ?>' data-pid='<?= $ID; ?>'>Delete</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-xl btn-primary" id="edit_bank_transfer" data-toggle='modal' data-target='#editBankTransferModal' title='Edit'><i class='fa fa-pencil-square-o'></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th style="width: 10px">Promo Code</th>
                                <td><?= (!empty($res[0]['promo_code']) || $res[0]['promo_code'] != null) ? $res[0]['promo_code'] : ""; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Address</th>
                                <td><?php echo $res[0]['address']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Order Date</th>
                                <td><?php echo date('d-m-Y', strtotime($row['date_added'])); ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Delivery Time</th>
                                <td><?php echo $res[0]['delivery_time']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php
                                    $status = json_decode($res[0]['order_status']);
                                    $i = count($status);
                                    $currentStatus = $status[$i - 1][0];
                                    ?>
                                    <select name="status" id="status" class="form-control">
                                        <option value="awaiting_payment">Awaiting</option>
                                        <option value="received">Received</option>
                                        <option value="processed">Processed</option>
                                        <?php if ($pickup == 0) { ?>
                                            <option value="shipped">Shipped</option>
                                        <?php } else { ?>
                                            <option value="ready_to_pickup">Ready To Pickup</option>
                                        <?php } ?>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancel</option>
                                        <option value="returned">Returned</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <?php if ($pickup == 1) { ?>
                            <hr>
                            <h5><b>Local/Store Pickup</b></h5>
                            <hr>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="">Local Pickup</label>
                                    <input type="checkbox" id="local_pickup" class="js-switch" <?= $pickup == 1 ? 'checked' : ''; ?>>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="">Seller Notes</label>
                                    <input type="text" class="form-control" name="seller_notes" id="seller_notes" value="<?= $res[0]['seller_notes'] ?>" placeholder='Seller Notes' />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Pickup Time</label>
                                    <div class="input-group date dtpickerdemo">
                                        <input type="text" class="form-control" name="pickup_time" id="pickup_time" value="<?= $res[0]['pickup_time'] ?>" required="">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                        <!-- /.box-body -->
                        <div class="alert alert-danger" id="result_fail" style="display:none"></div>
                        <div class="alert alert-success" id="result_success" style="display:none"></div>
                        <div class="box-footer clearfix">
                            <?php $whatsapp_message = "Hello " . ucwords($res[0]['uname']) . ", Your order with ID : " . $res[0]['id'] . " is " . ucwords($currentStatus) . ". Please take a note of it. If you have further queries feel free to contact us. Thank you."; ?>
                            <a href="#" title=' update' id="submit_btn" class="btn btn-primary update_order_status" data-id='<?= $res[0]['id']; ?>'>Update</a>
                            <a href="https://api.whatsapp.com/send?phone=<?= '+' . $res[0]['country_code'] . ' ' . $res[0]['mobile']; ?>&text=<?= $whatsapp_message; ?>" target='_blank' title="Send Whatsapp Notification" class="btn btn-success"><i class="fa fa-whatsapp"></i> Send Whatsapp Notification</a>
                        </div>
                    </div>
                    <?php
                    if ($currentStatus == "received") { ?>
                        <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i>Generate Invoice</button>
                    <?php } elseif ($currentStatus == "processed") { ?>
                        <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                    <?php } elseif ($currentStatus == "shipped") { ?>
                        <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                    <?php } elseif ($currentStatus == "delivered") { ?>
                        <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                    <?php } elseif ($currentStatus == "ready_to_pickup") { ?>
                        <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                    <?php } else { ?>
                        <button class="btn btn-primary disabled pull-right" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">You have no permission to view orders</div>
            <?php }  ?>
            <!-- /.box -->
        </div>
        <?php if ($permissions['orders']['read'] == 1) { ?>
            <div class="col-md-3">
                <ul class="timeline">
                    <?php foreach ($status as $s) { ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?= $s[0]; ?>
                            </span>
                        </li>
                        <li>
                            <i class="fa fa-circle bg-blue"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header"><?= $s[1]; ?></h3>
                                <div class="timeline-body">
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
    <div class="modal fade" id='editBankTransferModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Bank Transfer</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <form id="update_form" method="POST" action="public/db-operation.php" data-parsley-validate class="form-horizontal form-label-left">
                            <input type='hidden' name="order_id" id="order_id" value="<?= $ID ?>" />
                            <input type='hidden' name="update_bank_transfer" id="update_bank_transfer" value='1' />

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div id="status" class="btn-group">
                                        <label class="btn btn-warning" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="0" <?php echo ($res1[0]['status'] == 0) ? 'checked' : '' ?>> Pending
                                        </label>
                                        <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="1" <?php echo ($res1[0]['status'] == 1) ? 'checked' : '' ?>> Accepted
                                        </label>
                                        <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="status" value="2" <?php echo ($res1[0]['status'] == 2) ? 'checked' : '' ?>> Rejected
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Message</label>
                                <textarea id="message" name="message" class="form-control col-md-7 col-xs-12" style=" min-width:500px; max-width:100%;min-height:100px;height:100%;width:100%;"><?= $res1[0]['message'] ?></textarea>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-9">
                                    <button type="submit" id="update_btn" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-8" style="display:none;" id="update_result"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="plugins/datetimepicker/jquery-2.1.1.min.js"></script>
<script src="dist/js/jquery.validate.min.js"></script>

<script type="text/javascript">
    $(function() {
        $('.dtpickerdemo').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss A',
        });
    });
</script>
<script>
    $('#update_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if ($("#update_form").validate().form()) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    $('#update_result').html(result);
                    $('#update_result').show().delay(6000).fadeOut();
                    $('#update_btn').html('Update');
                    $('#update_form')[0].reset();
                    setTimeout(function() {
                        $('#editBankTransferModal').modal('hide');
                        window.location.reload();
                    }, 1000);
                }
            });
        }
    });
</script>
<script>
    $(document).on('click', '.delete-image', function() {
        var pid = $(this).data('pid');
        var i = $(this).data('i');
        if (confirm('Are you sure want to delete the image?')) {
            $.ajax({
                type: 'POST',
                url: 'public/delete-attachments.php',
                data: 'i=' + i + '&pid=' + pid,
                success: function(result) {
                    if (result == '1') {
                        alert('Image deleted successfully');
                        window.location.reload();
                    } else
                        alert('Image could not be deleted!');

                }
            });
        }
    });
</script>
<script>
    var allowed = '<?= $allowed; ?>';
    $(document).on('click', '.update_order_status', function(e) {
        e.preventDefault();
        if (allowed == 0) {
            alert('Sorry! This operation is not allowed in demo panel!.');
            window.location.reload();
            return false;
        }
        var update_permission = '<?= $update_order_permission; ?>';
        if (update_permission == 0) {
            alert('Sorry! you have no permission to update orders.');
            window.location.reload();
            return false;
        }
        var status = $('#status').val();
        var id = $('#order_id').val();
        var deliver_by = $('#deliver_by').val();
        var pickup_time = $('#pickup_time').val();
        var seller_notes = $('#seller_notes').val();
        var dataString = 'update_order_status=true&id=' + id + '&status=' + status + '&delivery_boy_id=' + deliver_by + '&pickup_time=' + pickup_time + '&seller_notes=' + seller_notes + '&ajaxCall=1';
        $.ajax({
            url: "api-firebase/order-process.php",
            type: "POST",
            data: dataString,
            beforeSend: function() {
                $('#submit_btn').html('Please wait..');
                $('#submit_btn').attr('disabled', true);
            },
            dataType: "json",
            success: function(data) {
                if (data.error == true) {
                    $('#result_fail').html(data.message);
                    $('#result_fail').show().delay(6000).fadeOut();
                } else {
                    $('#result_success').html(data.message);
                    $('#result_success').show().delay(6000).fadeOut();
                }
                $('#submit_btn').attr('disabled', false);
                $('#submit_btn').html('Update');
            }
        });
    });
    $(document).on('click', '.update_order_item_status', function(e) {
        e.preventDefault();
        if (allowed == 0) {
            alert('Sorry! This operation is not allowed in demo panel!.');
            window.location.reload();
            return false;
        }
        var update_permission = '<?= $update_order_permission; ?>';
        if (update_permission == 0) {
            alert('Sorry! you have no permission to update orders.');
            window.location.reload();
            return false;
        }
        var status1 = 'cancelled';
        var id = $('#order_id').val();
        var item_id = $(this).data('value1');
        var dataString = 'update_order_item_status=1&order_id=' + id + '&status=' + status1 + '&order_item_id=' + item_id + '&ajaxCall=1';
        if (confirm("Are you sure? you want to delete the order item")) {
            $.ajax({
                url: "api-firebase/order-process.php",
                type: "POST",
                data: dataString,
                beforeSend: function() {
                    $('#submit_btn').html('Please wait..');
                    $('#submit_btn').attr('disabled', true);
                },
                dataType: "json",
                success: function(data) {
                    if (data.error == true) {
                        $('#result_fail1').html(data.message);
                        $('#result_fail1').show().delay(6000).fadeOut();

                    } else {
                        $('#result_success1').html(data.message);
                        $('#result_success1').show().delay(6000).fadeOut();
                        location.reload(true);
                    }
                    $('#submit_btn').attr('disabled', false);
                    $('#submit_btn').html('Update');
                }
            });
        }
    });

    $(document).on('click', '.update_order_total_payable', function(e) {
        e.preventDefault();
        if (allowed == 0) {
            alert('Sorry! This operation is not allowed in demo panel!.');
            window.location.reload();
            return false;
        }
        var update_permission = '<?= $update_order_permission; ?>';
        if (update_permission == 0) {
            alert('Sorry! you have no permission to update orders.');
            window.location.reload();
            return false;
        }
        var discount = $('#input_discount').val();
        var total_payble = $('#final_total').val();
        var deliver_by = $('#deliver_by').val();
        var id = $('#order_id').val();
        var dataString = 'update_order_total_payable=true&id=' + id + '&discount=' + discount + '&total_payble=' + total_payble + '&deliver_by=' + deliver_by + '&ajaxCall=1';
        $.ajax({
            url: "api-firebase/order-process.php",
            type: "POST",
            data: dataString,
            beforeSend: function() {
                $(this).html('...');
            },
            dataType: "json",
            success: function(data) {
                var result = $.map(data, function(value, index) {
                    return [value];
                });
                alert(result[1]);
                if (!result[0]) {}
                location.reload();
            }

        });
    });

    $(document).ready(function() {
        $("#status").val("<?= $GLOBALS['currentStatus'] ?>");
    });

    function myfunction() {
        var create = '<?php echo $permissions['reports']['create']; ?>';
        if (create == 0) {
            alert('You have no permission to create invoice');
            return false;

        }
        window.location.href = 'invoice.php?id=<?php echo $res[0]['id']; ?>';
    }
    $('#input_discount').on('input', function() {
        var total = $("#total_amount").val();

        var delivery_charge = $("#delivery_charge").val();

        var tax_amount = $("#tax_amount").val();

        var promo_discount = $("#promo_discount").val();

        var wallet_balance = $("#wallet_balance").val();

        var discount = $('#input_discount').val();
        discounted_amount = total * discount / 100;
        final_total = total - discounted_amount;
        discount_in_rupees = total - final_total;
        discount_in_rupees = discount_in_rupees;
        var f_total = +total + +delivery_charge + +tax_amount - promo_discount - wallet_balance - discount_in_rupees;
        if (discount >= 0) {
            $("#final_total").val(Math.round((f_total + Number.EPSILON) * 100) / 100);
        }
    });
</script>
<script>
    var changeCheckbox = document.querySelector('#local_pickup');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#generate-otp').val(1);
        } else {
            $('#generate-otp').val(0);
        }
    };
</script>

<?php $db->disconnect(); ?>