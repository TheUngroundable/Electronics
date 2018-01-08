<?php
//includo funzioni di verifica consistenza dati 
require 'include/funzioni.php';


$email=$emailErr=$password=$passwordErr=$dbErr="";
$err=false;
//verifico se post già inviata
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//connessione al db
	
    include_once("include/db_connection.php");

	//recupero dati post ed effettuo protezione da caratteri speciali
	if (empty($_POST["email"])) {
		$emailErr = "Il campo Email e' obbligatorio";
		$err=true;
	} else {
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Formato Email non valido";
			$err=true;
		}else{	
			$email = test_input($_POST["email"]);
		}
			
	}
 
	if (empty($_POST["password"])) {
		$passwordErr = "Il campo Password e' obbligatorio";
		$err=true;
	} else {
		$password = test_input($_POST["password"]);
	}
	
	//se non ci sono errori, procedo con inserimento nel db
	if(!$err){
		/* crittografia password */
		$passmd5 = md5($password);
		

		/* lettura della tabella utenti */
		$query="SELECT ID, Nome, Cognome FROM users WHERE Email='".$email."' and Password='".$passmd5."'";
		$result=mysql_query($query)  or die ("problemino con la query");
        if($result){
        	$count=mysql_num_rows($result);
            if($count!=0){
        		session_start();
                $row=mysql_fetch_array($result);
                $_SESSION['session'] = 1;
                $_SESSION['ID'] = $row['ID'];
                $_SESSION['email'] = $email;
                $_SESSION['nome'] = $row['Nome'];
                $_SESSION['cognome'] = $row['Cognome'];
                header("Location: index.php");	//ridirigo utente ad home page
				exit;
			}else{
            	$dbErr="Identificazione non riuscita: nome utente o password errati ";
            }
        }else{
        	$dbErr="Errore nel login: ".mysql_error();
			
		}
	}
}
?>

<html>
<head>
<title>Login</title>



<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    


    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/scrolling-nav.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->




<style>
.error {color: #FF0000;}
</style>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top" >

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">Portale Elettronica</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Section -->
    <div id="intro" class="intro-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 bordered" style="text-align: center">
                    <form name="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<br><br>
                        <h3>Inserisci i dati per effettuare l' accesso!</h3>
						<br><br>
						Email:&nbsp;&nbsp;<input type="text" name="email" value="<?php echo $email;?>"><span class="error">*</span><br><span class="error"><?php echo $emailErr;?></span>
						<br>
						Password:&nbsp;&nbsp;<input type="password" name="password"><span class="error">*</span><br><span class="error"><?php echo $passwordErr;?></span>
						<br>
						<input type="submit" name="submit" value="Log In!">
						<br>
						<span class="error"><?php echo $dbErr;?></span>
						
						<?php
						if($dbErr!=""){
							echo "<br><a href='index.php'>Torna alla Home</a>";
						}


						?>


						
						</form>
                    <br>
                </div>
            </div>
        </div>
    </div>

    

 <footer class="footer">
      <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
      </div>
    </footer>

    

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>

  

</body>
</html>






