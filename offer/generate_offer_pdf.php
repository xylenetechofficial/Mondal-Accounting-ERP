<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
include_once('../includes/crud.php');
include_once('../includes/functions.php');
include_once('../includes/custom-functions.php');
include_once('../includes/firebase.php');
include_once('../includes/push.php');

$fnc = new functions;

$db = new Database();
$db->connect();
//include connection file 
//include_once("connection.php");
$id = $_POST['id'];
//$user_id = $_POST['user_id'];
$name = $_POST['name'];
//$name1 = $_POST['name'];
//$name = str_replace(' ', '', $name1);
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$address = $_POST['address'];
$qualification = $_POST['qualification'];
$gender = $_POST['gender'];
$designation = $_POST['designation'];
$salary = $_POST['salary'];
$dt = date("Y-m-d");
$datetime = date("Y-m-d_H:i:s");

//Update Diet Question
$sql_query = "UPDATE test_form SET designation = '" . $designation . "', salary = '" . $salary . "' WHERE id = " . $id;
$db->sql($sql_query);
$update_result = $db->getResult();

include_once('libs/fpdf.php');
//require('libs/WriteHTML.php');

//require('fpdf/fpdf.php');
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->Image('http://mandaladmin.theinnovatechsolutions.in/images/mandalHeader.png', 10, 0, 200);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 13);
//put logo
/*
$pdf->Cell(0, 5, '', 0, 1, 'R');
$pdf->Cell(0, 6, 'WhatsApp : +91 9870006216/7208141246', 0, 1, 'L');
$pdf->Cell(0, 6, 'Mail : info@j-fit.in', 0, 2, 'L');
$pdf->Cell(0, 6, 'Website : www.J-fit.in', 0, 2, 'L');
$pdf->Image('http://jfit.innovatechsolution.online//dist/img/logo.png', 150, 10, 50);
*/

$pdf->Ln();
$pdf->Ln();
//$pdf->Ln();
//$pdf->Cell(0, 8, 'Jigna Thakkar', 0, 1, 'C');
//$pdf->SetFont('Arial', '', 10);
//$pdf->Cell(0, 5, 'Email : jignathakkar711@gmail.com', 0, 0, 'C');
$pdf->Line(15, 40, 200, 40);  //Set the line
$pdf->Ln(70);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, 'Ref.: ME/2022-23/01', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'Date: ' . date("d-m-Y"), 0, 1, 'R');
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, 'To', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 7, $name, 0, 2, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, $address, 0, 2, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'OFFER LETTER', 0, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 7, 'Dear '. $name .',', 0, 0, 'L');
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 7, '      We refer to resume and subsequent interview you had with us on 7th April 2022 in our office. We are pleased to appoint you as "'. $designation .'" and your monthly yet salary would be "Rs.'. $salary .'/-". Appointment letter and the salary break-up will be given at the time of joining. Kindly confirm your joining date.', 0, 'L');
$pdf->Ln();
//$cell1 = '      We refer to resume and subsequent interview you had with us on 7th April 2022 in our office. We are pleased to appoint you as ';
//$pdf->MultiCell($pdf->GetStringWidth($cell1),7,$cell1, 0, 'L');
$pdf->SetFont('Arial', 'U', 11);
$pdf->MultiCell(0, 7, 'Your appointment is based on following terms & condition.', 0, 'L');
$pdf->Ln();

//$boldCell = $designation;
//$pdf->MultiCell($pdf->GetStringWidth($boldCell),7,$boldCell, 0, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 7, '1.	You will devote your entire time to work assign to you. You will not undertake any other direct /indirect business or work honorary or remunerator except with the written permission of the management in each case.', 0, 'L');

$pdf->MultiCell(0, 7, '2.	If for any reason you wish to resign from the company’s services. After confirmation you may do so by giving 1 (One) months’ notice in writing or pay the company 1 (One) month salary in lieu thereof. Similarly, the company can at its discretion terminate your services by giving 1 months’ salary in lieu thereof.', 0, 'L');


$pdf->MultiCell(0, 7, '3.	You will be entitled for all benefits, if any, as per Provision of Low.', 0, 'L');


$pdf->MultiCell(0, 7, '4.	During you employment, if you are found medically unfit at any time, the management will have the right to discontinue your service with 48 hours notice.', 0, 'L');


$pdf->MultiCell(0, 7, '5.	Your co-operation with the management staff and collogues in day-to-day work will be essential criterion for your advancement in career.', 0, 'L');


$pdf->MultiCell(0, 7, '6.	The company will be entitled to terminate your service at any time without any notice in the event of dishonesty, disobedience, misappropriation, absent from duty without permission or any other act considered detrimental to the interest of the company or violation of one or more terms of this appointment.', 0, 'L');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->MultiCell(0, 7, 'We welcome you as a member of our organization. We hope that our association will be a mutually happy and rewarding one.', 0, 'L');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->MultiCell(0, 7, 'For MANDAL ENGINEERING.,', 0, 'L');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 7, '[SHRIKANT MANDAL]', 0, 'L');

$pdf->SetFont('Arial', 'BU', 11);
$pdf->MultiCell(0, 7, 'PROPRIETOR', 0, 'L');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 7, 'If you agree to the above terms conditions, the same may be expressed by signing the duplicate copy of this letter.', 0, 'L');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->MultiCell(0, 7, 'Accepted By: -', 0, 'R');

//$cell2 = ' and your monthly yet salary would be Rs.';
//$pdf->MultiCell($pdf->GetStringWidth($cell2),7,$cell2, 0);

$pdf->Cell(0, 5, '__________________________________________________________________________________________', 0, 1, 'L');

$pdf->Ln();

$pdf->SetAutoPageBreak(true, 10);
/*foreach($header as $heading) {
	foreach($heading as $column_heading)
		$pdf->Cell(90,12,$column_heading,1);
}
foreach($result as $row) {
	$pdf->SetFont('Arial','',12);	
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(90,12,$column,1);
}*/
$pdf->Output($name . "_" . $datetime . '.pdf', 'F');

$data = array(
    'user_id' => $id,
    'pdf' => "http://mandaladmin.theinnovatechsolutions.in/offer/" . $name . "_" . $datetime . ".pdf"
    //'notificationDate' => $tenDays,
    //'diet_question_id' => $id
);
$db->insert('offer_pdf', $data);
/*
//Update For  PDF Status Generated Or Pending
$sqlUpdateDietQuestion = "UPDATE `diet_question` SET pdf_status='generated' WHERE id = $id";
$db->sql($sqlUpdateDietQuestion);
$res = $db->getResult();

$to = $email;
$subject = "Diet Plan PDF";
//$headers = "FROM: Jack Sparrow <some@site.com>\r\n";
$headers = 'FROM: J-Fit By Jigna Thakkar <jignathakkar711@gmail.com>' . PHP_EOL .
    'Reply-To: J-Fit By Jigna Thakkar <jignathakkar711@gmail.com>' . PHP_EOL .
    'X-Mailer: PHP/' . phpversion();
//$headers .= "MIME-Version: 1.0" . "\r\n";
//$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//$headers .= "FROM: J-Fit By Jigna Thakkar" . "\r\n";
$message = "Your Diet Plan PDF generated. Please get pdf from your DietPlan application. ";
$message .= "http://jfit.innovatechsolution.online/public/" . $name . "_" . $datetime . ".pdf";
mail($to, $subject, $message, $headers);


$push = new Push(
    "Your Diet Plan PDF Generated",
    "Your Diet Plan PDF Generated",
    null,
    "type",
    "0"
);
//getting the push from push object
$mPushNotification = $push->getPush();

//getting the token from database object 
$devicetoken = $fnc->getTokenByUid($user_id);

//creating firebase class object 
$firebase = new Firebase();

//sending push notification and displaying result 
$firebase->send($devicetoken, $mPushNotification);
*/


$whatsupMsg = "PDF Gnerated Link : " . "http://mandaladmin.theinnovatechsolutions.in/offer/" . $name . "_" . $datetime . ".pdf";
$WhatsupArr = json_encode(array(
    "phone" => $mobile,
    "body" => $whatsupMsg
));
$url = "https://eu211.chat-api.com/instance222035/message?token=vhlni0btm5nkmqsb";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $WhatsupArr);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-lenght:' . strlen($WhatsupArr)
));
$response = curl_exec($curl);
curl_close($curl);
//echo $response;
?>
<html>

<head>
    <title>PDF</title>
</head>

<body>
    <div class="pdf_link" style="text-align: center;margin-top: 200px;font-size: xx-large;">
        <a href="http://mandaladmin.theinnovatechsolutions.in/offer/<?php echo $name . "_" . $datetime . '.pdf'; ?>" id="mylink" target="_blank">PDF File Of Offer Letter</a>
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
    </div>
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!--<script>
    $(document).ready(function() {
        $(document).on('click', '#mylink', function(e) {
            var user_id = $("#user_id").val();
            $.ajax({
                url: "../send-single-push.php",
                type: "POST",
                data: {
                    title: "Diet Plan PDF Generated",
                    message: "Your Diet Plan PDF Generated",
                    type: "PDF",
                    user_id: "user_id",
                },
                dataType: "json",
                success: function(data) {
                    //alert(data);
                }
            });
        });
    });
</script>-->