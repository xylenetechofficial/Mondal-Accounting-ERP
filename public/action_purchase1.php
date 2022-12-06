<?php

//fetch_data.php

session_start();
$ip_add = getenv("REMOTE_ADDR");
include_once('includes/crud.php');
$db = new Database();
$db->connect();
$prod_id = $_POST['prod_name']; //print_r($seeker_id);

if (isset($_POST["action"])) {
    $sql = "SELECT product_variant.*, products.name, products.location FROM `product_variant` INNER JOIN `products` ON products.id = product_variant.product_id WHERE `product_variant.product_id` = '$prod_id' ";
    $db->sql($sql); //print_r($sql);
    //$result = $db->fetchAll();
    //$total_row = $db->rowCount();
    $result = $db->getResult(); //print_r($result);
    //$output = ''; //print_r($output);
    $output = $result;
    //if ($total_row > 0) {
        /*
    foreach ($result as $row) {
        $output .= '
        <a href="#" style="width: 100%;">
            
        <form method="POST" action="jobdetail.php" style="width: 100%;"><br />
            <div class="box-body table-responsive">
                <table class="table table-hover table-bordered table-condensed table-striped" style="border: solid;">
                    <thead>
                        <tr style="border: solid;">
                                <th style="border: solid;" class="text-center">Product Name</th>
                                <th style="border: solid;" class="text-center">Purchase Quantity</th>
                                <!--<th style="border: solid;" class="text-center">Unit Cost</th>
                                <th style="border: solid;" class="text-center">Discount Percent</th>
                                <th style="border: solid;" class="text-center">Unit Cost (Before Tax)</th>
                                <th style="border: solid;" class="text-center">Subtotal (Before Tax)</th>
                                <th style="border: solid;" class="text-center">Product Tax</th>
                                <th style="border: solid;" class="text-center">Net Cost</th>
                                <th style="border: solid;" class="text-center">Line Total</th>-->
                                <!--<th style="border: solid;" class="text-center">Profit Margin %</th>
                                <th style="border: solid;" class="text-center">Unit Selling Price (Inc. tax)</th>
                                <th style="border: solid;" class="text-center">MFG Date / EXP Date</th>-->
                                <th style="border: solid;" class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr id="R0" style="border: solid;">
                                <td class="text-center" style="border: solid;">
                                        <input type="text" id="prod_name10" name="prod_name10" value=' . $row['id'] . ' class="prod_name">                                            
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="text" id="qty20" name="qty20" value=' . $row['id'] . ' class="qty">
                                </td>
                                <!--<td class="text-center" style="border: solid;">
                                        <input type="label" id="tbl30" name="tbl30" style="background-color: lavender;" class="original_width" onchange="updateqty(0)" readonly>
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="text" id="t30" name="t30" class="three">
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="text" id="t40" name="t40" class="four">
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="text" id="t40" name="t40" class="four">
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="t50" name="t50" class="inputtext" readonly>
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tblrem50" name="tblrem50" class="rem_original_val" readonly>
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tblremwt50" name="tblremwt50" class="rem_kata_val" readonly>
                                </td>-->
                                <!--<td class="text-center" style="border: solid;">
                                        <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tbltotrem50" name="tbltotrem50" class="rem_tot_original_val" readonly>
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tbltotremwt50" name="tbltotremwt50" class="rem_tot_kata_val" readonly>
                                </td>
                                <td class="text-center" style="border: solid;">
                                        <input type="number" step=".001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tbl50" name="tbl50" class="original_val" readonly>
                                </td>-->
                                <td class="text-center">Remove Row
                                </td>
                        </tr>
                    </tbody>
                <!--</table>-->
                <div class="row">
                <div class="col-md-6">
        
            </div>
            <div class="col-md-6" style="text-align: right;">
            <button class="btn btn-md btn-primary" id="addBtn" type="button">
            Add new Row
            </button>
        
            </div>
            </div><br>
            </div><br>
        
            </a>
        </form>
        
        ';
    }*/
    /*} else {
        $output = '<h3>No Data Found</h3>';
    }*/
    echo $output; //print_r($output);
    echo $result;
}
