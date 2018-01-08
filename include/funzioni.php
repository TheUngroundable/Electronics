<?php
// protezione da injection
function test_input($data) {

	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysql_real_escape_string($data);
	return $data;
}

//verifica sicurezza pwd
function is_secure_password($password){
	if(strlen($password)>=8){
		return TRUE;
	}else{
		return FALSE;
	}
}

// verifica email utente già esistente
function isset_email($email, $tab){
	$query = "SELECT COUNT(email) AS count 
				FROM ".$tab."
				WHERE email='".mysql_real_escape_string($email)."' 
				LIMIT 1";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['count']==1){
		return TRUE;
	}else{
		return FALSE;
	}
}
?>