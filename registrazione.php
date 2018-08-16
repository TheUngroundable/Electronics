<?php
//includo funzioni di verifica consistenza dati 
require 'include/funzioni.php';

$nome=$cognome=$nomeErr=$cognomeErr=$email=$emailErr=$password=$passwordErr=$conferma=$confermaErr=$dbErr="";
$err=false;
//verifico se post già inviata
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//connessione al db
	include_once("include/db_connection.php");


	//recupero dati post ed effettuo protezione da caratteri speciali
	if (empty($_POST["nome"])) {
		$nomeErr = "Il campo Nome e' obbligatorio";
		$err=true;
	} else {
		$nome = test_input($_POST["nome"]);
	}

	if (empty($_POST["cognome"])) {
		$cognomeErr = "Il campo Cognome e' obbligatorio";
		$err=true;
	} else {
		$cognome = test_input($_POST["cognome"]);
	}

	if (empty($_POST["email"])) {
		$emailErr = "Il campo Email e' obbligatorio";
		$err=true;
	} else {
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Formato Email non valido";
			$err=true;
		}else{	
			//verifico se email è già presente nel db
			if(isset_email($_POST["email"], $tab)){
				$emailErr = "Email già registrata";
				$err=true;
			}else
				$email = test_input($_POST["email"]);
		}
			
	}
 
	if (empty($_POST["password"])) {
		$passwordErr = "Il campo Password e' obbligatorio";
		$err=true;
	} else {
		if(!is_secure_password($_POST["password"])){
			$passwordErr = "La password deve essere lunga almeno 8 caratteri";
			$err=true;
		}else
			$password = test_input($_POST["password"]);
	}
	
	if (empty($_POST["conferma"])) {
		$confermaErr = "Il campo Conferma Password e' obbligatorio";
		$err=true;
	} else {
		if($_POST["password"]!=$_POST["conferma"]){
			$confermaErr = "Il campo Conferma e Password devono essere uguali";
			$err=true;
		}else
			$conferma = test_input($_POST["conferma"]);
	}

	//se non ci sono errori, procedo con inserimento nel db
	if(!$err){
		
		/* crittografia password */
		$passmd5 = md5($password);
		
		//query inserimento nuovo utente
		$query="INSERT INTO $tab (Nome,Cognome,Email,Password) VALUES ('$nome','$cognome','$email','$passmd5')";
		$result=$conn->query($query);
		if($result){
			//se la registrazione è andara a buon fine, l'utente è automaticamente loggato
			session_start();
			$_SESSION['session'] = 1;
			$_SESSION['email'] = $email;
			$_SESSION['nome'] = $nome;
			$_SESSION['cognome'] = $cognome;
			header("Location: index.php");	//ridirigo utente ad home page
			exit;
		}else{
        	$dbErr="Errore nell'inserimento: ".$conn->error();
			
		}

	}
}
?>

<html>
<head>
<title>Registrazione</title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<form name="registrazione" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>
<tr>
<td>nome:</td><td><input type="text" name="nome" value="<?php echo $nome;?>"><span class="error">* <?php echo $nomeErr;?></span></td>
</tr><tr>
<td>cognome:</td><td><input type="text" name="cognome" value="<?php echo $cognome;?>"><span class="error">* <?php echo $cognomeErr;?></span></td>
</tr><tr>
<td>email:</td><td><input type="text" name="email" value="<?php echo $email;?>"><span class="error">* <?php echo $emailErr;?></span></td>
</tr><tr>
<td>password:</td><td><input type="password" name="password"><span class="error">* <?php echo $passwordErr;?></span></td>
</tr><tr>
<td>conferma password:</td><td><input type="password" name="conferma"><span class="error">* <?php echo $confermaErr;?></span></td>
</tr><tr>
<td><input type="submit" name="submit" value="Salva"></td> 
</tr><tr>
<td><span class="error"><?php echo $dbErr;?></span></td>
</tr>
</table>
</form>
</body>
</html>