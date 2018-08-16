<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <style>
        .error {color: #FF0000;}
    </style>

    <title>Aggiungi un annuncio</title>


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

    <?php




        require 'include/funzioni.php';
        //connessione al db
        include_once("include/db_connection.php");



        session_start();
        if(!isset($_SESSION['session'])){ 
            header("Location: index.php");  
        }



        $Titolo = $Descrizione = $Prezzo = $success = "";
        $titoloErr = $descrizioneErr = $prezzoErr = $categoriaErr = $sottocategoriaErr = "";
        $err = false;


        if ($_SERVER["REQUEST_METHOD"] == "POST") {


                
            
                $Titolo = test_input($_POST["Titolo"]);
                $Descrizione = test_input($_POST["Descrizione"]);
                $Prezzo = test_input($_POST["Prezzo"]);

                if($_POST['Categoria']=="select"){

                    $err = true;
                    $categoriaErr = "Selezionare una Categoria";
                }

                if($_POST['SottoCategoria']=="select"){

                    $err = true;
                    $sottocategoriaErr = "Selezionare una Sottocategoria";

                } else {

                    $sottoCategoria = $_POST['SottoCategoria'];

                }


                $Oggi = date("Y-m-d");
                

                if(!$err){

                    $sql ="INSERT INTO annunci (Titolo, Descrizione, Prezzo, DataInserimento, FKutente, FKsottocategoria)
                    VALUES ('".$Titolo."','".$Descrizione."','".$Prezzo."','".$Oggi."','".$_SESSION['ID']."','".$sottoCategoria."')";

                    $result = $conn->query($sql) or die ("Errore con l' inserimento"); 

                    if($result){

                        $success ="Inserimento avvenuto con Successo!".$result->fetch_assoc();
                    
                    }


                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }

                    $image=basename( $_FILES["image"]["name"],".jpg"); // used to store the filename in a variable

                    $insert_id = $conn->insert_id();

                    //storind the data in your database
                    $query= "INSERT INTO pictures (FKannunci, image_path) VALUES (".$insert_id.",".$image.")";
                    $conn->query($query);

                    echo $insert_id;





                    
                    





                }
        }


    ?>

</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

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
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="add.php" >Aggiungi un Annuncio</a>
                    </li>

                    <?php

                    if(!isset($_SESSION['session'])){

                        ?>

                       <li>
                        <a class="page-scroll" href="login.php">Login</a>
                    </li>

                    <?php
                    } else {
                    ?>
                        <li>
                            <a class="page-scroll" href="user.php">Hi, <?php echo $_SESSION["nome"]; ?></a>
                        </li>
                        <li>
                            <a class="page-scroll" href="logout.php">Logout</a>
                        </li>
                    <?php
                    }

                    ?>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Section -->
    <div id="intro" class="intro-section" style="">
        <div class="container" >
            <div class="row">
                <div class="col-lg-12 bordered" >

                <!-- User Datas -->
                    
                    <!-- Advertisement Section -->
                    <div>
                        <br>
                        <h1> Aggiungi un Annuncio </h1>
                        <form method="POST">
                        <br>
                            <p>Titolo: </p><input type="text" name="Titolo" required="" value="<?php echo $Titolo; ?>" placeholder="Inserisci un Titolo"><span class="error">* <?php echo $titoloErr;?></span>
                            <br>
                            <br>
                            <p>Descrizione: </p><textarea name="Descrizione" required="" value="<?php echo $Descrizione; ?>" placeholder="Inserisci una Descrizione"></textarea><span class="error">* <?php echo $descrizioneErr;?></span>
                            <br>
                            <br>
                            <p>Prezzo: </p><input type="number" name="Prezzo" min="0" required="" value="<?php echo $Prezzo; ?>" placeholder="Inserisci un prezzo" step="0.01"><span class="error">* <?php echo $prezzoErr;?></span>
                            <br>
                            <br>

                
                            <select name="Categoria" id="categoria" class="demoInputBox" onChange="getState(this.value);">
                            <?php
                               $sql = "SELECT macrocategory.ID, macrocategory.Nome FROM macrocategory";
                               
                               $results = mysql_query($sql);
                               
                               ?>

                                <option value="select">Seleziona Categoria</option>

                            <?php

                               while($row = mysql_fetch_array($results)){
                               
                                 echo "<option value='".$row['ID']."'>".$row['Nome']."</option>";
                               
                               }
                               
                               ?>
                            </select><span class="error">* <?php echo $categoriaErr;?></span>
                            <br>
                            <br>
                            <select name="SottoCategoria" id="sottocategoria" class="demoInputBox">
                               <option value="">Seleziona Sottocategoria</option>
                            </select><span class="error">* <?php echo $sottocategoriaErr;?></span>
                            <br>
                            <br>

                            <input type="file" name="image" value="">
                            <input type="submit" name="submit" value="Inserisci Annuncio!">
                            <br>
                            <br>
                            <span class="error"><?php echo $success;?></span>


                        </form>


                        

                    </div>

                    
                    <br>
                    <br>
                </div>
            </div>

            <br>
            <br>
            <br>

        </div>
    </div>
<br>
    <br><br><br>

    

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

   <script>
         function getState(val) {
           $.ajax({
           type: "POST",
           url: "get_state.php",
           data:'valCategoria='+val,
           success: function(data){
             $("#sottocategoria").html(data);
           }
           });
         }
      </script>

</body>

</html>
