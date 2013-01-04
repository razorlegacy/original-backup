<?php
	$toEmail = $fromEmail = $_POST['email_to'];
	$ccEmail = $_POST['email_cc'];
	
	$email_body 		= "[Submission] ".$_POST['emcOrohi_cb_question']."\n";
    $email_subject  	= $_POST['configData']." ".$_POST['email_title'];

    $headers			= "From: ".strip_tags($fromEmail)."\r\n";
    $headers           	.= "Reply-To: ".strip_tags($fromEmail)."\r\n";
	$headers			.= "Cc: ".strip_tags($ccEmail). "\r\n";
    $headers			.= "X-Mailer: PHP/".phpversion();
    $headers			.= "MIME-Version: 1.0\r\n";
	$headers			.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
   
   if(!mail($toEmail, $email_subject, $email_body, $headers)) {
		echo 'There was an error. Please try again.';
	} else {
		echo "Thank you for your submission!";
	}
?>