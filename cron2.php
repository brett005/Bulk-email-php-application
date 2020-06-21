<?php
require 'class/class.phpmailer.php';

$connect = new PDO("mysql:host=localhost;dbname=hebnicin_mail", "hebnicin_plag", "wp75VT37oz");
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//mail body
$query1 = "SELECT * FROM body WHERE id = 1";
$statement1 = $connect->prepare($query1);
$statement1->execute();
$result1 = $statement1->fetchAll();

foreach($result1 as $row1)
			{
                $sub= $row1["subject"];
                $body = $row1["body"];
			}

//number of mails
$query2 = "select * from count where id = 1";
$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();
foreach($result2 as $n){
$number = $n["count"];
}
//echo $number."<br>";


$query = "SELECT * FROM customer where customer_id = $number";//ORDER BY customer_id";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
//var_dump($result);
foreach($result as $row)
	{
	    $rowemail = $row["customer_email"];
	    $rowname = $row["customer_name"];
	}
$number = $number+1;
$sql = "Update count SET count = $number WHERE id = 1"; 
        $connect->exec($sql);
            
//echo $number."<br>";
//echo $rowname.$rowemail;
$dir = "upload/";
$a = scandir($dir);


$mail = new PHPMailer;
		$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host = 'localhost';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = '25';								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'team.heb@heb-nic.in';					//Sets SMTP username
		$mail->Password = 'Ekdant123';					//Sets SMTP password
		$mail->SMTPSecure = '';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->From = 'team.heb@heb-nic.in';			//Sets the From email address for the message
		$mail->FromName = 'HEALTH EDUCATION BUREAU';					//Sets the From name of the message
		//$mail->AddAddress('parihargiriraj@live.com', 'parihargiriraj@live.com');
		$mail->AddAddress($rowemail, $rowname);	//Adds a "To" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML
		$mail->Subject = $sub;
		//'To make available "Plag-Check Software (Software &ndash; Adhering AICTE guidelines)" in your institute.'; //Sets the Subject of the message
		//An HTML or plain text message body
		$mail->Body = $body;
		foreach($a as $i){
		    $mail->AddAttachment($dir.$i);
		}
		$result = $mail->Send();
		//echo $result;
?> 