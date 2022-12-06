<!--<script>
    $(function() {
        // from http://stackoverflow.com/questions/45888/what-is-the-most-efficient-way-to-sort-an-html-selects-options-by-value-while
        var my_options = $('.product_variant select option');
        var selected = $('.product_variant').find('select').val();
        my_options.sort(function(a, b) {
            if (a.text > b.text) return 1;
            if (a.text < b.text) return -1;
            return 0
        })
        $('.product_variant').find('select').empty().append(my_options);
        $('.product_variant').find('select').val(selected);
        // set it to multiple
        $('.product_variant').find('select').attr('multiple', true);
        // remove all option
        $('.product_variant').find('select option[value=""]').remove();
        // add multiple select checkbox feature.
        $('.product_variant').find('select').multiselect();

    })
</script>-->

<!--<link rel="stylesheet" type="text/css" href="public/MultiSelect/multiselect.css" />-->

<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

//$ID = $db->escapeString($fn->xss_clean($_GET['id']));

?>
<?php

if (isset($_POST['btnAdd'])) {
?>
    <script type="text/javascript">
        window.location = "home.php";
    </script>
<?php
}

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>
<section class="content-header">
    <h1>Inward Sheet Form</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <form id="form" role="form" class="form" method="post" enctype="multipart/form-data" action="">
                    <div class="box-body">

                        <div class="col-md-2">
                            <div class="form-group" style="height: 300px;">
                                <!--<label for="exampleInputEmail1">Total Rem KATA WEIGHT</label><?php echo isset($error['net_weight']) ? $error['net_weight'] : ''; ?>
                                <input type="text" class="form-control" id="tot_rem_coils_kata_wt" name="tot_rem_coils_kata_wt" value='<?= $data['coils_kata_wt']; ?>' readonly>-->
                                <div class="clearfix m-b10" style="max-height: 200px;">
                                    <h5 class="widget-title font-weight-700 m-t0 text-uppercase">Select Products</h5>
                                    <div style="height: 120px;">
                                        <!--<select class="common_selector chosen-select prod_name" id="prod_name" name="prod_name" size="5" style="overflow-y: scroll;" data-placeholder="Choose Products..." tabindex="4" required>-->
                                        <input id="someinput">
                                        <br />
                                        <select class="select-products" class="prod_name" name="prod_name" id="optlist" multiple="multiple">
                                            <option>SELECT</option>
                                            <?php
                                            $sql = "SELECT * FROM `products` ORDER BY `products`.`name` ASC";
                                            $db->sql($sql);
                                            $products = $db->getResult();
                                            foreach ($products as $product) {
                                            ?>
                                                <option value="<?= $product['id'] ?>">
                                                    <label><?= $product['name']; ?></label>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        </input>
                                        <br />
                                        <input id="someinput1" /><br />

                                        <select class="chosen-products" name="chosen-products-name" id="optlist1" multiple="multiple"></select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h5 class="widget-title font-weight-700 text-uppercase">Purchase Products Details</h5>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="post-job-bx">
                                        <?php
                                        /*$sql = "SELECT * FROM `job_post`";
											$db->sql($sql);
											$getJob_post = $db->getResult();
											foreach ($getJob_post as $job_post) {*/
                                        ?>

                                        <li style="width: 100%;">

                                            <div class="row filter_data">

                                            </div>

                                            <!--<a href="#">
														<div class="d-flex m-b30">
															<div class="job-post-company">
																<span><img src="images/logo/icon1.png" /></span>
															</div>
															<div class="job-post-info">
																<h4><?= $job_post['designation']; ?></h4>
																<ul>
																	<li><i class="fa fa-map-marker"></i> <?= $job_post['job_location']; ?></li>
																	<li><i class="fa fa-bookmark-o"></i> <?= $job_post['job_type']; ?></li>
																	<li><i class="fa fa-clock-o"></i> Published 11 months ago</li>
																</ul>
															</div>
														</div>
														<div class="d-flex">
															<div class="job-time mr-auto">
																<span><?= $job_post['job_type']; ?></span>
															</div>
															<div class="salary-bx">
																<span>₹<?= $job_post['min']; ?> - ₹<?= $job_post['max']; ?></span>
															</div>
														</div>
														<span class="post-like fa fa-heart-o"></span>
													</a>-->
                                        </li>
                                        <? //php } 
                                        ?>
                                    </ul>
                                </div>
                            </div>

                        </div>


                        <!--<div class="box-body table-responsive">
                            <table class="table table-hover table-bordered table-condensed table-striped" style="border: solid;">
                                <thead>
                                    <tr style="border: solid;">
                                        <th style="border: solid;" class="text-center">Product Name</th>
                                        <th style="border: solid;" class="text-center">Purchase Quantity</th>
                                        <th style="border: solid;" class="text-center">Unit Cost</th>
                                        <th style="border: solid;" class="text-center">Discount Percent</th>
                                        <th style="border: solid;" class="text-center">Unit Cost (Before Tax)</th>
                                        <th style="border: solid;" class="text-center">Subtotal (Before Tax)</th>
                                        <th style="border: solid;" class="text-center">Product Tax</th>
                                        <th style="border: solid;" class="text-center">Net Cost</th>
                                        <th style="border: solid;" class="text-center">Line Total</th>-->
                        <!--<th style="border: solid;" class="text-center">Profit Margin %</th>
                                        <th style="border: solid;" class="text-center">Unit Selling Price (Inc. tax)</th>
                                        <th style="border: solid;" class="text-center">MFG Date / EXP Date</th>-->
                        <!--<th style="border: solid;" class="text-center">Remove</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <tr id="R0" style="border: solid;">
                                        <td class="text-center" style="border: solid;">
                                            <input type="text" id="prod_name10" name="prod_name10" class="prod_name" value='' onchange="updateqty(0)" required>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="text" id="qty20" name="qty20" class="qty" value='' onchange="updateqty(0)" required>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="label" id="tbl30" name="tbl30" style="background-color: lavender;" class="original_width" value='<?= $data['coils_width']; ?>' onchange="updateqty(0)" readonly>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="text" id="t30" name="t30" class="three" onchange="updateqty(0)" required>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="text" id="t40" name="t40" class="four" onchange="updateqty(0)" required>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="text" id="t40" name="t40" class="four" onchange="updateqty(0)" required>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="t50" name="t50" class="inputtext" readonly>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tblrem50" name="tblrem50" class="rem_original_val" value='<?= $data['coils_net_weight']; ?>' readonly>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tblremwt50" name="tblremwt50" class="rem_kata_val" value='<?= $data['coils_kata_wt']; ?>' readonly>
                                        </td>-->
                        <!--<td class="text-center" style="border: solid;">
                                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tbltotrem50" name="tbltotrem50" class="rem_tot_original_val" value='<?= $data['coils_net_weight']; ?>' readonly>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tbltotremwt50" name="tbltotremwt50" class="rem_tot_kata_val" value='<?= $data['coils_kata_wt']; ?>' readonly>
                                        </td>
                                        <td class="text-center" style="border: solid;">
                                            <input type="number" step=".001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" id="tbl50" name="tbl50" class="original_val" value='<?= $data['coils_net_weight']; ?>' readonly>
                                        </td>-->
                        <!--<td class="text-center">Remove Row</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <button class="btn btn-md btn-primary" id="addBtn" type="button">
                                        Add new Row
                                    </button>

                                </div>
                            </div><br>
                        </div>--><br>

                    </div><!-- /.box-body -->

                    <div class="box-footer" style="text-align: center;">
                        <!--<input type="submit" class="btn btn-primary" name="btnAdd">-->
                        <button class="btn btn-md btn-primary" id="saveBtn" type="button">
                            Save
                        </button>
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect(); ?>


<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<!--<script src="public/MultiSelect/multiselect.js"></script>-->

<script>
    //var can_submit = false;
    $('form').on('submit', function(e) {

        //var confirmation = confirm("Do you want to continue");

        //if (this.host !== window.location.host) {
        //if (confirmation) {
        if (window.confirm('Really Want To Submit?')) {
            window.location.href = "home.php";
            console.log("Clicked OK - submitting now ...");
            can_submit = true;
            window.location.href = "home.php";
            //console.location.href = "home.php";
            //console.location("home.php");
            echo(window.location = "home.php");

        } else {
            console.log("Clicked Cancel");
            //can_submit = false;
            return false;
        }
        //}
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
</script>

<script>
    function updateqty(e) {
        //alert(e+1);
        var inc = e + 1; //alert(inc);
        var one_val;
        var second_val;
        var third_val;
        var fourth_val;


        //Process Based On New Required Weight As Actual Weight Method

        var reqwt = $("#req_coils_net_weight").val();
        var orgwt = $("#rem_coils_net_weight").val(); //alert(orgwt);
        var katawt = $("#rem_coils_kata_wt").val();
        //var remwt = orgwt - reqwt;
        //$("#rem_coils_net_weight").val(remwt);
        //$("#req_coils_net_weight").attr('disabled', 'disabled').css('background-color', 'lavender');

        // End This Section


        if ($("table tr:nth-child(" + inc + ") td:nth-child(1) input[class*=one]").val() == '') {
            one_val = 0;
        } else {
            one_val = $("table tr:nth-child(" + inc + ") td:nth-child(1) input[class*=one]").val();
        }
        if ($("table tr:nth-child(" + inc + ") td:nth-child(2) input[class*=two]").val() == '') {
            second_val = 0;
        } else {
            second_val = $("table tr:nth-child(" + inc + ") td:nth-child(2) input[class*=two]").val();
        }
        if ($("table tr:nth-child(" + inc + ") td:nth-child(3) input[class*=three]").val() == '') {
            third_val = 0;
        } else {
            third_val = $("table tr:nth-child(" + inc + ") td:nth-child(3) input[class*=three]").val();
        }
        if ($("table tr:nth-child(" + inc + ") td:nth-child(4) input[class*=four]").val() == '') {
            fourth_val = 0;
        } else {
            fourth_val = $("table tr:nth-child(" + inc + ") td:nth-child(4) input[class*=four]").val();
        }

        //alert(one_val); alert(second_val); alert(third_val); alert(fourth_val);
        //var ori_val = $('#original_val').val(); alert(ori_val);
        var ori_thick = $("table tr:nth-child(" + inc + ") td:nth-child(1) input[class*=one]").val();
        var ori_len = $("table tr:nth-child(" + inc + ") td:nth-child(2) input[class*=two]").val();
        var ori_width = $("table tr:nth-child(" + inc + ") td:nth-child(3) input[class*=original_width]").val();
        //alert(ori_width);
        var ori_val = $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_original_val]").val(); //alert(ori_val);
        var rem_kata_wt_val = $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_kata_val]").val(); //alert(rem_kata_wt_val);

        /*
        if ($("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_original_val]").val() == '0.000') {
            ori_val = 0.000;
        } else {
            ori_val = $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_original_val]").val();
        }
        if ($("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_kata_val]").val() == '0.000') {
            rem_kata_wt_val = 0.000;
        } else {
            rem_kata_wt_val = $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_kata_val]").val();
        }
        */

        //var ori_val = $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=original_val]").val();
        //var rem_kata_wt_val = $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=kata_val]").val();
        //alert(ori_val);
        //var total_val = (one_val) * (second_val);
        var percent = 7.85 / 1000000000;

        /*if (second_val > '0.000') {
            total_val = one_val * third_val * second_val * fourth_val * percent;
            //processed_coils_total_wt = ori_val / ori_width * third_val * fourth_val;
        }*/
        /* else if (parting_qty > '0') {
				total_val = ori_val / ori_width * third_val * fourth_val;
				parting_wt = total_val / parting_qty;
			} */
        //else {
        total_val = ori_val / ori_width * third_val * fourth_val;

        //total_val = one_val * third_val * second_val * fourth_val * percent ;
        //total_val1 = ori_val / ori_width * third_val * fourth_val;
        //}
        //alert(total_val);
        var minus_value = (ori_val) - (total_val); //alert(minus_value);
        var minus_kata_wt = (rem_kata_wt_val) - (total_val); //alert(minus_kata_wt);

        //Process Based On New Required Weight As Actual Weight Method
        var pro_total_val = reqwt / ori_width * third_val * fourth_val;
        var process_total_val = parseFloat(pro_total_val).toFixed(3);

        var pro_minus_org_wt = parseFloat(ori_val) - parseFloat(process_total_val); //alert(minus_value);
        var process_minus_org_wt = parseFloat(pro_minus_org_wt).toFixed(3);

        var pro_minus_kata_wt = parseFloat(rem_kata_wt_val) - parseFloat(process_total_val); //alert(minus_kata_wt);
        var process_minus_kata_wt = parseFloat(pro_minus_kata_wt).toFixed(3);

        var pro_minus_total_org_wt = parseFloat(process_minus_org_wt) + parseFloat(orgwt); //alert(minus_value);
        var process_minus_total_org_wt = parseFloat(pro_minus_total_org_wt).toFixed(3);

        var pro_minus_total_kata_wt = parseFloat(process_minus_kata_wt) + parseFloat(katawt); //alert(minus_kata_wt);
        var process_minus_total_kata_wt = parseFloat(pro_minus_total_kata_wt).toFixed(3);


        // End This Section


        //$("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=inputtext]").val(total_val);
        //$("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=original_val]").val(minus_value);
        //$("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=kata_val]").val(minus_kata_wt);

        $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=inputtext]").val(process_total_val);
        $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_original_val]").val(process_minus_org_wt);
        $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_tot_original_val]").val(process_minus_total_org_wt);
        $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_kata_val]").val(process_minus_kata_wt);
        $("table tr:nth-child(" + inc + ") td:nth-child(5) input[class*=rem_tot_kata_val]").val(process_minus_total_kata_wt);
        $("table tr:nth-child(" + inc + ") td:nth-child(3) input[class*=original_width]").val(ori_width);
        $("table tr:nth-child(" + inc + ") td:nth-child(2) input[class*=two]").val(ori_len);
        $("table tr:nth-child(" + inc + ") td:nth-child(1) input[class*=one]").val(ori_thick);


        //Process Based On New Required Weight As Actual Weight Method

        $("#process_rem_coils_net_weight").val(process_minus_org_wt);
        $("#process_rem_coils_kata_wt").val(process_minus_kata_wt);
        $("#tot_rem_coils_net_weight").val(process_minus_total_org_wt);
        $("#tot_rem_coils_kata_wt").val(process_minus_total_kata_wt);
        //$("#rem_coils_net_weight").val(total_val);
        //$("#rem_coils_net_weight").val(total_val);

        // End This Section

    }
</script>
<!-- JAVASCRIPT FILES ========================================= -->
<script src="chkbox.js"></script>
<script src="js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="plugins/wow/wow.js"></script><!-- WOW JS -->
<script src="plugins/bootstrap/js/popper.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script><!-- FORM JS -->
<script src="plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script><!-- FORM JS -->
<!--<script src="plugins/magnific-popup/magnific-popup.js"></script>-->
<!-- MAGNIFIC POPUP JS -->
<script src="plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
<script src="plugins/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
<script src="plugins/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
<script src="plugins/masonry/masonry-3.1.4.js"></script><!-- MASONRY -->
<script src="plugins/masonry/masonry.filter.js"></script><!-- MASONRY -->
<script src="plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
<script src="plugins/rangeslider/rangeslider.js"></script><!-- Rangeslider -->
<script src="js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
<script src="js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS  -->
<script src='js/recaptcha/api.js'></script> <!-- Google API For Recaptcha  -->
<script src="js/dz.ajax.js"></script><!-- CONTACT JS  -->

<script src="js/jquery-ui.js"></script>

<script src="chosen.jquery.js" type="text/javascript"></script>
<script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="docsupport/init.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(function() {
        opts = $('#optlist option').map(function() {
            return [
                [this.value, $(this).text()]
            ];
        });
        //alert(opts);
        opts1 = $('#optlist1 option').map(function() {
            return [
                [this.value, $(this).text()]
            ];
        });
        //alert(opts1);



        $('#someinput').keyup(function() {

            var rxp = new RegExp($('#someinput').val(), 'i'); //alert(rxp);
            var optlist = $('#optlist').empty(); //alert(optlist);
            opts.each(function() {
                if (rxp.test(this[1])) {
                    optlist.append($('<option/>').attr('value', this[0]).text(this[1]));
                } else {
                    optlist.append($('<option/>').attr('value', this[0]).text(this[1]).addClass("hidden"));
                }
            });
            $(".hidden").toggleOption(false);

        });
        $('#someinput1').keyup(function() {

            var rxp = new RegExp($('#someinput1').val(), 'i');
            var optlist = $('#optlist1').empty();
            opts1.each(function() {
                if (rxp.test(this[1])) {
                    optlist.append($('<option/>').attr('value', this[0]).text(this[1]));
                } else {
                    optlist.append($('<option/>').attr('value', this[0]).text(this[1]).addClass("hidden"));
                }
            });
            $(".hidden").toggleOption(false);

        });
        $('.select-products').click(function() {
            var prod_name = $('#optlist').val();
            //alert(prod_name);
            $('.select-products option:selected').remove().appendTo('.chosen-products');
            opts = $('#optlist option').map(function() {
                return [
                    [this.value, $(this).text()]
                ];
            });
            //alert(opts);
            opts1 = $('#optlist1 option').map(function() {
                return [
                    [this.value, $(this).text()]
                ];
            });
            //alert(opts1);
        });

        $('.chosen-products').click(function() {
            $('.chosen-products option:selected').remove().appendTo('.select-products');
            opts = $('#optlist option').map(function() {
                return [
                    [this.value, $(this).text()]
                ];
            });
            //alert(opts);
            opts1 = $('#optlist1 option').map(function() {
                return [
                    [this.value, $(this).text()]
                ];
            });
            //alert(opts1);
        });


    });

    jQuery.fn.toggleOption = function(show) {
        jQuery(this).toggle(show);
        if (show) {
            if (jQuery(this).parent('span.toggleOption').length)
                jQuery(this).unwrap();
        } else {
            if (jQuery(this).parent('span.toggleOption').length == 0)
                jQuery(this).wrap('<span class="toggleOption" style="display: none;" />');
        }
    };
</script>
<script>
    $(document).ready(function() {

        filter_data();
        //$('#prod_name').on('change', function() {
        function filter_data() {
            $('.filter_data').html('<div id="loading" style="" ></div>');
            var action = 'fetch_data'; //alert(action);
            var prod_name = $('#optlist').val();
            alert(prod_name);
            //var designation = get_filter('designation');
            $.ajax({
                url: "action_purchase2.php",
                method: "POST",
                data: {
                    action: action,
                    prod_name: prod_name
                    //designation: designation
                },
                success: function(data) {
                    $('.filter_data').html(data);
                    //alert("hi");
                }
            });
        }
        //});

        function get_filter(class_name) {
            var filter = [];
            //$('.' + class_name + ':checked').each(function() {
            $('.' + class_name + ':selected').each(function() {
                filter.push($(this).val());
                alert($(this).val());
            });
            return filter;
        }

        //$('.common_selector').click(function() {
        $('.common_selector').change(function() {
            filter_data();
            //alert("hi");
            //alert($(this).val());
            //alert(filter_data());
            //var location = $(this).val();

        });
    });
</script>
<!--<script>
    function updateprod(e) {

        $(function() {
            //alert(e+1);
            var inc = e + 1; //alert(inc);
            var prod_name = $("#prod_name10").val();
            alert(prod_name);
            console.log(prod_name);
        })

    }
</script>-->
<script>
    $(document).ready(function() {

        $('#req_coils_net_weight').on('change', function() {
            var reqwt = $("#req_coils_net_weight").val();
            var orgwt = $("#rem_coils_net_weight").val();
            var orgkatawt = $("#rem_coils_kata_wt").val();
            var remwt1 = parseFloat(orgwt) - parseFloat(reqwt);
            var remwt = parseFloat(remwt1).toFixed(3);;
            var remkatawt1 = parseFloat(orgkatawt) - parseFloat(reqwt);
            var remkatawt = parseFloat(remkatawt1).toFixed(3);;
            $("#rem_coils_net_weight").val(remwt);
            $("#tblrem50").val(reqwt);
            $("#req_coils_kata_wt").val(reqwt);
            $("#tblremwt50").val(reqwt);
            $("#req_coils_net_weight").attr('disabled', 'disabled').css('background-color', 'lavender');
            $("#req_coils_kata_wt").attr('disabled', 'disabled').css('background-color', 'lavender');

            $("#rem_coils_kata_wt").val(remkatawt);
            //$("#req_coils_net_weight").attr('disabled', 'disabled').css('background-color', 'lavender');
        });

        // Denotes total number of rows
        var rowIdx = 0; //alert(rowIdx);

        // jQuery button click event to add a row
        $('#addBtn').on('click', function() {
            var i = rowIdx + 1;
            /*
            var previous_val = $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=original_val]").val()
            	- $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=inputtext]").val();
            */
            //var previous_val = $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=original_val]").val();
            //var rem_kata_wt_val = $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=kata_val]").val();

            var prev = $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=rem_original_val]").val();
            //var rem_org = parseFloat(prev) //alert(prev);
            var previous_val = parseFloat(prev).toFixed(3); //alert(prev);
            //var previous_val = Math.round(rem_org).toFixed(3);

            var rem_kata = $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=rem_kata_val]").val();
            var rem_kata_wt_val = parseFloat(rem_kata).toFixed(3); //alert(prev);

            var rem_tot_org = $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=rem_tot_original_val]").val();
            var rem_tot_org_wt_val = parseFloat(rem_tot_org).toFixed(3); //alert(prev);

            var rem_tot_kata = $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=rem_tot_kata_val]").val();
            var rem_tot_kata_wt_val = parseFloat(rem_tot_kata).toFixed(3); //alert(prev);

            var org_width = $("table tr:nth-child(" + i + ") td:nth-child(3) input[class*=original_width]").val();
            var org_len = $("table tr:nth-child(" + i + ") td:nth-child(2) input[class*=two]").val();
            var org_thick = $("table tr:nth-child(" + i + ") td:nth-child(1) input[class*=one]").val();
            if ((previous_val) > 0) {
                // Adding a row inside the tbody.
                $("table tr:nth-child(" + i + ") td:nth-child(1) input[class*=one]").attr('disabled', 'disabled').css('background-color', 'lavender');
                $("table tr:nth-child(" + i + ") td:nth-child(2) input[class*=two]").attr('disabled', 'disabled').css('background-color', 'lavender');
                $("table tr:nth-child(" + i + ") td:nth-child(3) input[class*=original_width]").attr('disabled', 'disabled').css('background-color', 'lavender');
                $("table tr:nth-child(" + i + ") td:nth-child(3) input[class*=three]").attr('disabled', 'disabled').css('background-color', 'lavender');
                $("table tr:nth-child(" + i + ") td:nth-child(4) input[class*=four]").attr('disabled', 'disabled').css('background-color', 'lavender');
                $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=inputtext]").attr('disabled', 'disabled').css('background-color', 'lavender');
                $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=rem_original_val]").attr('disabled', 'disabled').css('background-color', 'lavender');
                $("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=rem_kata_val]").attr('disabled', 'disabled').css('background-color', 'lavender');

                //$("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=original_val]").attr('disabled', 'disabled').css('background-color', 'lavender');
                //$("table tr:nth-child(" + i + ") td:nth-child(5) input[class*=kata_val]").attr('disabled', 'disabled').css('background-color', 'lavender');

                $('#tbody').append(`<tr id="R${++rowIdx}">
			            <td style="border: solid;" class="row-index text-center" name="Row1${rowIdx}" id="Row1${rowIdx}">
						    <input type="text" name="t1${rowIdx}" id="t1${rowIdx}" class="one" value="${org_thick}" onchange="updateqty(${rowIdx})" required>
						</td>
			            <td style="border: solid;" class="row-index text-center" name="Row2${rowIdx}" id="Row2${rowIdx}">
			                <input type="text" name="t2${rowIdx}" id="t2${rowIdx}" class="two" value="${org_len}" onchange="updateqty(${rowIdx})" required>
						</td>
						<td style="border: solid;" class="row-index text-center" name="Row3${rowIdx}" id="Row3${rowIdx}">
							<input type="text" name="tbl3${rowIdx}" id="tbl3${rowIdx}" style="background-color: lavender;" class="original_width" value="${org_width}" readonly>
			                <input type="text" name="t3${rowIdx}" id="t3${rowIdx}" class="three" onchange="updateqty(${rowIdx})" required>
						</td>
						<td style="border: solid;" class="row-index text-center" name="Row4${rowIdx}" id="Row4${rowIdx}">
			                <input type="text" name="t4${rowIdx}" id="t4${rowIdx}" class="four" onchange="updateqty(${rowIdx})" required>
						</td>
						<td style="border: solid;" class="row-index text-center" name="Row5${rowIdx}" id="Row5${rowIdx}">
							<input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" class="inputtext" name="t5${rowIdx}" id="t5${rowIdx}" readonly>
							<input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" name="tblrem5${rowIdx}" id="tblrem5${rowIdx}" class="rem_original_val" value="${previous_val}" readonly>
                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" name="tblremwt5${rowIdx}" id="tblremwt5${rowIdx}" class="rem_kata_val" value="${rem_kata_wt_val}" readonly>

                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" name="tbltotrem5${rowIdx}" id="tbltotrem5${rowIdx}" class="rem_tot_original_val" value="${rem_tot_org_wt_val}" readonly>
                            <input type="number" step="0.001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" name="tbltotremwt5${rowIdx}" id="tbltotremwt5${rowIdx}" class="rem_tot_kata_val" value="${rem_tot_kata_wt_val}" readonly>

                            <!--<input type="number" step=".001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" name="tbl5${rowIdx}" id="tbl5${rowIdx}" class="original_val" value="${previous_val}" readonly>
                            <input type="number" step=".001" pattern="^\d*(\.\d{0,3})?$" style="background-color: lavender;" name="tblwt5${rowIdx}" id="tblwt5${rowIdx}" class="kata_val" value="${rem_kata_wt_val}" readonly>-->
						</td>
						<td style="border: solid;" class="text-center">
							<button class="btn btn-danger remove" type="button">Remove</button>
						</td>
					</tr>`);
            } else {
                alert("Original Value is Zero");
            }
        });

        //var tot_row_count = rowIdx;
        //alert(tot_row_count);

        // jQuery button click event to remove a row.
        $('#tbody').on('click', '.remove', function() {

            // Getting all the rows next to the row
            // containing the clicked button
            var child = $(this).closest('tr').nextAll();

            // Iterating across all the rows
            // obtained to change the index
            child.each(function() {

                // Getting <tr> id.
                var id = $(this).attr('id');

                // Getting the <p> inside the .row-index class.
                var idx = $(this).children('.row-index').children('p');

                // Gets the row number from <tr> id.
                var dig = parseInt(id.substring(1));

                // Modifying row index.
                idx.html(`Row ${dig - 1}`);

                // Modifying row id.
                $(this).attr('id', `R${dig - 1}`);
            });

            // Removing the current row.
            $(this).closest('tr').remove();

            // Decreasing total number of rows by 1.
            rowIdx--;
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#saveBtn').on('click', function() {
            var id = $("#coils_id").val();
            //var date = $("#coils_date").val();
            var truck_no = $("#coils_truck_no").val();
            var party_name = $("#coils_party_name").val();
            var mita_coil_no = $("#coils_mita_coil_no").val();
            var party_coil_no = $("#coils_party_coil_no").val();
            var grade = $("#coils_grade").val();
            //var thickness = $("#coils_thickness").val();
            var rm_thickness = $("#coils_rm_thickness").val(); //
            var rm_width = $("#coils_rm_width").val(); //
            var length = $("#coils_length").val(); //
            var quantity = $("#coils_quantity").val();
            var net_weight = $("#coils_net_weight").val(); //
            var kata_wt = $("#coils_kata_wt").val(); //
            var location = $("#processed_coils_location").val();
            var remark = $("#processed_coils_remark").val();
            var invoice_no = $("#coils_invoice_no").val();
            var lot_no = $("#coils_lot_no").val();
            var mother_coil_loc = $("#coils_mother_coil_loc").val();
            var remark1 = $("#processed_coils_remark1").val();
            var remark2 = $("#processed_coils_remark2").val();
            var remark3 = $("#processed_coils_remark3").val();
            //var created_at = $("#created_at").val();

            var customers = new Array();
            $("div table tbody tr").each(function() {
                var row = $(this);
                var customer = {};
                customer.rowone = row.find("input.one").val(); //Thickness
                customer.rowtwo = row.find("input.two").val(); //LENGTH
                customer.rowthree = row.find("input.three").val(); //Req Width
                customer.rowfour = row.find("input.four").val(); //Req Quantity
                customer.rowfive = row.find("input.inputtext").val(); //Tot Weight
                customer.rowsix = row.find("input.rem_original_val").val(); //Rem Weight
                customer.rowseven = row.find("input.original_width").val(); //Org Width
                customer.roweight = row.find("input.rem_kata_val").val(); //Rem Kata Weight
                customer.rownine = row.find("input.rem_tot_original_val").val(); //Rem Total Original Weight
                customer.rowten = row.find("input.rem_tot_kata_val").val(); //Rem Total Kata Weight
                customer.id = id;
                customer.truck_no = truck_no;
                customer.party_name = party_name;
                customer.mita_coil_no = mita_coil_no;
                customer.party_coil_no = party_coil_no;
                customer.grade = grade;
                //customer.thickness = thickness;
                customer.rm_thickness = rm_thickness;
                customer.rm_width = rm_width;
                customer.length = length;
                //customer.quantity = quantity;
                customer.net_weight = net_weight;
                customer.kata_wt = kata_wt;
                customer.location = location;
                customer.remark = remark;
                customer.lot_no = lot_no;
                customer.invoice_no = invoice_no;
                customer.mother_coil_loc = mother_coil_loc;
                customer.remark1 = remark1;
                customer.remark2 = remark2;
                customer.remark3 = remark3;

                customers.push(customer);
                var tot_count = customers.length;

                //alert(customer.eight);
            });
            console.log(customers);
            console.log(JSON.stringify(customers));
            //Send the JSON array to Controller using AJAX.
            $.ajax({
                url: "public/action2.php",
                method: "POST",
                data: {
                    customers: customers
                    //eight: eight
                },
                success: function(r) {
                    alert(r + " record(s) inserted.");
                }
            });
            if (window.confirm('Really Want To Submit?')) {
                window.location.href = "home.php";
                console.log("Clicked OK - submitting now ...");
                can_submit = true;
                window.location.href = "home.php";
                //console.location.href = "home.php";
                //console.location("home.php");
                echo(window.location = "home.php");
            } else {
                console.log("Clicked Cancel");
                //can_submit = false;
                return false;
            }
        });
    });
</script>