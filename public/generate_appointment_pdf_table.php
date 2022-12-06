<?php
include_once('includes/crud.php');
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$ID = $_GET['id'];
//print_r($ID);
$name = $_GET['name'];
$date = $_GET['date'];
$address = $_GET['address'];
$joining_date = $_GET['joining_date'];
$emp_post = $_GET['emp_post'];
$ref_no = $_GET['ref_no'];
$salary = $_GET['salary'];
$hra = $_GET['hra'];
$medical = $_GET['medical'];
$lta = $_GET['lta'];
$home_allow = $_GET['home_allow'];
$total = $_GET['total'];

//$date = date("d-m-Y");
/*
$sql2 = "SELECT * FROM `final_processed_coils` WHERE id = '$ID' ORDER BY id ASC limit 1";
//$sql = "SELECT * FROM `coils` WHERE id = '1' ";
$db->sql($sql2);
$res2 = $db->getResult();
//print_r($res2);
foreach ($res2 as $row2)
    $data2 = $row2;
*/
if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "home.php";
    </script>
<?php } ?>

<section class="content" style="background-color: white;">
    <div class="row" style="margin-right: 50px;margin-left: 50px;">
        <div class="col-md-12" style="text-align-last: center;">
            <!-- general form elements -->
            <div class="box box-primary" style="font-size: large;">
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12" style="padding: 0px;">
                            <img src="<?= DOMAIN_URL . 'images/mandalHeader.png' ?>" style="width: -webkit-fill-available;" alt="Mandal Engineering" class="img-responsive">
                        </div>
                    </div>

                    <div class="row" style="padding-left: 50px;padding-right: 50px;">
                        <!-- Left col -->
                        <div class="col-md-6" style="padding: 0px;text-align-last: left;">
                            <div>
                                <label>Ref : <?php echo $ref_no; ?></label>
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-6" style="padding: 0px;text-align-last: right;">
                            <div>
                                <label><?php echo $date; ?></label>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    </div><br><br>

                    <div class="row" style="padding-left: 50px;padding-right: 50px;">
                        <!-- Left col -->
                        <div class="col-xs-4" style="padding: 0px;text-align-last: left;">
                            <div>
                                <label>To,</label><br>
                                <label><?php echo $name; ?></label><br>
                                <label><?php echo $address; ?></label><br>
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-xs-8" style="padding: 0px;text-align-last: center;">
                            <div>
                                <label></label>
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: center;">
                            <label><b><u> APPOINTMENT LETTER</u></b></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;">
                            <label>Dear <?php echo $name; ?></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;">
                            <label>With reference to your application for appointment in the post of "<?php echo $emp_post; ?>" and the subsequent interview you had with us, we are pleased to inform you that you are selected to the said post and appointed on the following terms and conditions.</label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;">
                            <ul style="list-style-type: auto;">
                                <li>
                                    Your appointment to the post of "<?php echo $emp_post; ?>" shall take place with effect from the date of joining i.e. "<?php echo $joining_date; ?>".
                                </li>
                                <li>
                                    You shall be placed in the grade of “and your salary and other benefits shall be as applicable to the other staff in the said grade. Details of your salary and the benefits are set out herein given bellow.
                                </li><br>
                                <ul style="list-style-type: square; font-weight: 800;">
                                    <li>
                                        BASIC RS. <?php echo $salary; ?>
                                    </li>
                                    <li>
                                        H.R.A RS. <?php echo $hra; ?>
                                    </li>
                                    <li>
                                        MEDICAL RS. <?php echo $medical; ?>
                                    </li>
                                    <li>
                                        L.T.A. RS. <?php echo $lta; ?>
                                    </li>
                                    <li>
                                        HO ALLO. RS. <?php echo $home_allow; ?>
                                    </li>
                                    <li>
                                        ---------
                                    </li>
                                    <li>
                                        TOTAL RS. <?php echo $total; ?>
                                    </li>
                                    <li>
                                        ---------
                                    </li>
                                </ul><br><br>
                                <li>
                                    You shall report to the PROPRIETOR
                                </li>
                                <li>
                                    You shall be on Six Month's Probation. On successful completion of your above period you shall be given a letter of confirmation. In the absence of confirmation letter, you shall not be treated as confirmed.
                                </li>
                                <li>
                                    During the probation, your service shall be terminated with One month's notice or notice pay in lieu thereof. Similarly, you shall give at least one month's notice of resignation from service or notice pay in lieu thereof Cond…… 2/-
                                </li>
                                <li>
                                    After the confirmation, your service shall be terminated by Two-month notice or notice pay in lieu thereof. Similarly, you shall give at least Two month notice of resignation from service, or notice pay in lieu thereof.
                                </li>
                                <li>
                                    In the event of any misconduct on your part any time during the tenure of your service, you shall be terminated from the service without notice or notice pay.
                                </li>
                                <li>
                                    You will retire from the service at the end of the calendar month in which you attain the age of 58.
                                </li>
                                <li>
                                    Your employment will be subject to the terms and conditions that may come in force from time to time, if any, for the Staff in your grade.
                                </li>
                                <li>
                                    You shall not without our previous written permission carry out any business or be employed by any other firm, company or person. You will devote your whole time and attention to your duties to promote the interest of our organization.
                                </li>
                                <li>
                                    During or after your employment you shall not divulge or utilize any confidential information pertaining to our business or otherwise that you may poses to cause any kind of damage to us or our interest in any manner and you shall take all reasonable precaution to keep all such confidential information as secret.
                                </li>
                                <li>
                                    Your services shall be transferable at any time to any of our branch or place of our activities presently existing and they may be established in future within India at the sole discretion of the Company.
                                </li>
                                <li style="font-weight: 800;">
                                    Employee shall not take up whole or part time employment with any other Company engaged in the manufacture or engaged in similar business after the separation with the company.
                                </li>
                                
                            </ul>
                        </div><br><br><br>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;">
                            <label>For <b style="font-weight: 800;">MANDAL ENGINEERING.,</b></label>
                        </div><br><br><br>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;">
                            <label><b style="font-weight: 800;">[SHRIKANT MANDAL]</b></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;">
                            <label><b style="font-weight: 800;"><u>PROPRIETOR</u></b></label>
                        </div><br><br><br>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: left;">
                            <label style="font-weight: 500;">If you agree to the above term's conditions, the same may be expressed by signing the duplicate copy of this letter.</label>
                        </div><br><br><br>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;">
                            <label></label>
                        </div>
                        <div class="col-xs-12" style="padding: 0px;text-align-last: right;">
                            <label><b style="font-weight: 800;">Accepted By: -</b></label>
                        </div>
                    </div>

                </div>

            </div><!-- /.box-body -->

        </div><!-- /.box -->
    </div><br>
</section>

<section>
    <div class="row no-print">
        <div class="col-xs-12">
            <form style="text-align-last: center; background-color:  white;"><button type='button' value='Print this page' onclick='printpage();' class="btn btn-success"><i class="fa fa-print"></i> Print</button>
            </form>
            <script>
                function printpage() {
                    var is_chrome = function() {
                        return Boolean(window.chrome);
                    }
                    if (is_chrome) {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 100000);
                        //give them 10 seconds to print, then close
                    } else {
                        window.print();
                        window.close();
                    }
                }
            </script>
        </div>
    </div>
</section>

<div class="separator"> </div>

<?php $db->disconnect();
?>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script>