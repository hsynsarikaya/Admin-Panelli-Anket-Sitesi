<?php 

try {

	$db= new PDO("mysql:host=localhost;dbname=cbsecim; charset=utf8", 'root', 'cece1453');

	
	
} catch (PDOExpception $e) {

	echo $e->getMessage();
	
}

require_once 'class.phpmailer.php';
?>