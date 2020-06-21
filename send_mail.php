<?php
//send_mail.php
session_start();
$body = $_SESSION['body'];
$subject = $_SESSION['subject'];
$dir = "upload/";
$a = scandir($dir);

if(isset($_POST['email_data']))
{
	require 'class/class.phpmailer.php';
	$output = '';
	foreach($_POST['email_data'] as $row)
	{
		$mail = new PHPMailer;
		$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host = 'localhost';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = '25';								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'username';					//Sets SMTP username
		$mail->Password = 'password';					//Sets SMTP password
		$mail->SMTPSecure = '';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->From = 'email';			//Sets the From email address for the message
		$mail->FromName = 'Name';					//Sets the From name of the message
		$mail->AddAddress($row["email"], $row["name"]);	//Adds a "To" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML
		$mail->Subject = $subject;
		//'To make available "Plag-Check Software (Software &ndash; Adhering AICTE guidelines)" in your institute.'; //Sets the Subject of the message
		//An HTML or plain text message body
		$mail->Body = $body;
		

		$mail->AltBody = '';
		foreach($a as $i){
		    $mail->AddAttachment($dir.$i);
		}
		//$mail->AddAttachment('subformmain.pdf');
		//$mail->AddAttachment('APH.pdf');

		$result = $mail->Send();						//Send an Email. Return true on success or false on error

		if($result["code"] == '400')
		{
			$output .= html_entity_decode($result['full_error']);
		}

	}
	if($output == '')
	{
		echo 'ok';
	}
	else
	{
		echo $output;
	}
}

?>
