<?php 
ob_start();
session_start();
date_default_timezone_set('Europe/Istanbul');
function mailgonder($kullanici_mail,$mailkonu,$mesaj){

$host="";
$pass="";
$from="gotrimes@gmail.com";

	$mail= new PHPMailer();
	$mail->IsSMTP(true);
	$mail->From		=$from;
	$mail->SMTPDebug=0;
	$mail->SMTPSecure='ssl';
	$mail->Sender 	=$from;
	$mail->AddAddress($kullanici_mail);
	$mail->AddReplyTo=($kullanici_mail);
	$mail->FromName =$from;
	$mail->Host 	=$host;
	$mail->SMTPAuth =true;
	$mail->Port 	=465;
	$mail->CharSet 	='UTF-8';
	$mail->Username =$from;
	$mail->Password =$pass;
	$mail->Subject 	=$mailkonu;
	$mail->isHTML(true);
	$mail->SetLanguage('tr','../net/language');
	$mail->Body ="
	$mesaj<hr><br> <p>Cumhurbaşkanlığı Anketi için size özel kodunuz yukarıda sunulmuştur.</p><br>";
	$mail->Send();



}

 ?>