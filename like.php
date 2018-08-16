<?php

include("include/db_connection.php");


$annuncio = $_POST['code'];
$user = $_POST['userid'];
$liked = $_POST['liked'];

if($liked == 0){

	$sql = "INSERT INTO likes (FKutente, FKannuncio) VALUES (".$user.", ".$annuncio.")";
	$conn->query($sql) or die ("Problema con il like");

} else if ($liked == 1){

	$sql = "DELETE FROM likes WHERE FKutente =".$user." AND FKannuncio = ".$annuncio;
	$conn->query($sql) or die ("Problema con il dislike");

}




?>