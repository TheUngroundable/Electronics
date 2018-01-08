<?php
$nomehost = "localhost"; 
	$nomeuser = "root";
	$dbpassword = "";
	$dbname="electronics";
	mysql_connect($nomehost,$nomeuser,$dbpassword) or die('Impossibile connettersi al server: ' . mysql_error());
	mysql_select_db($dbname) or die ('Accesso al database non riuscito: ' . mysql_error());
	?>