<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Annuncio</title>
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
         session_start();
         
         
         
             include_once("include/db_connection.php");
         
         
         
         $err = false;
         $liked = 0;
         $logged = false;
         
         
         //check if ad is already liked
         if(isset($_SESSION['session'])){ 
         
             $logged = true;
         
             $sql="SELECT * from likes where FKutente = ".$_SESSION['ID']." AND FKannuncio = ".$_GET['ID'];
         
             $result = $conn->($sql);
         
             if($result->num_rows()){
         
                 $liked = 1;
         
             }
         }
         
         if(isset($_GET['ID']) && !empty($_GET['ID'])){
         
         
             $titolo = $descrizione = $prezzo = $dataInserimento = $email = $citta = $regione = $sottocategoria = $categoria = "";
         
         
             $sql = "SELECT annunci.Titolo, annunci.Descrizione, annunci.Prezzo, annunci.DataInserimento, users.Email, citta.Nome as Citta, region.Nome as Regione, sottocategory.Nome as Sottocategoria, macrocategory.Nome as Categoria from annunci, users, citta, region, sottocategory, macrocategory WHERE users.FKCity = citta.ID AND citta.FKregion = Region.ID AND annunci.FKutente = users.ID AND annunci.FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID AND annunci.ID = ".$_GET['ID'];
         
             $query = $conn->query($sql);
             $result = $query->fetch_array();
         
             if ($query->num_rows==0) {
         
                 header("Location: index.php");
         
             } else {
         
                 $titolo = $result['Titolo'];
                 $descrizione = $result['Descrizione'];
                 $prezzo = $result['Prezzo'];
                 $dataInserimento = $result['DataInserimento'];
                 $email = $result['Email'];
                 $citta = $result['Citta'];
                 $regione = $result['Regione'];
                 $sottocategoria = $result['Sottocategoria'];
                 $categoria = $result['Categoria'];
         
         
             }
         
         
         } else {
         
             header("Location: index.php");
         
         }
         
         
         
         ?>
      <style type="text/css">
         .hide-bullets {
         list-style:none;
         margin-left: -40px;
         margin-top:20px;
         }
         .thumbnail {
         padding: 0;
         }
         .carousel-inner>.item>img, .carousel-inner>.item>a>img {
         width: 100%;
         }
      </style>
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
                  <?php
                     if(isset($_SESSION['session'])){ 
                     
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
         <!-- Breadcrumb Section -->
         
         <div class="container" >

          <div class="col-xs-12 col-md-12 col-lg-12 col-centered">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href=<?php echo '"search.php?categoria='.$categoria.'"'; ?>><?php echo $categoria; ?></a></li>
               <li class="breadcrumb-item"><a href="#"><?php echo $sottocategoria; ?></a></li>
               <li class="breadcrumb-item active"><?php echo $titolo; ?></li>
            </ol>
         </div>

            <div class="row">
               <div class="col-lg-12 col-md-12 bordered " style="padding:  30px" >
                  <!-- Dati Annuncio -->
                  <div class="row">
                      <div class="col-md-6">
                         <!-- Prezzo, Data Inserimento e Descrizione -->
                         <div class="row">
                            <?php 
                               echo "<h2><strong>".$titolo."</strong></h2>";
                               echo "<hr>";
                               
                               ?>
                            <!-- Prezzo-->
                            <div class ="well  col-md-5 col-sm-5 col-xs-5" style="font-size: 18px">
                               <span class="glyphicon glyphicon-euro" style="font-size: 15px"></span><label><?php echo " ".$prezzo; ?></label>
                            </div>
                            <div class ="col-md-2 col-sm-2 col-xs-2"></div>
                            <!-- Data Inserimento -->
                            <div class ="well  col-md-5 col-sm-5 col-xs-5" style="font-size: 18px">
                               <span class="glyphicon glyphicon-calendar" style="font-size: 15px"></span><label><?php echo " ".$dataInserimento; ?></label>
                            </div>
                            <!-- Descrizione -->
                            <div class="well col-md-12 col-sm-12 col-xs-12">
                               <p>
                                  <?php
                                     echo $descrizione;
                                     
                                     ?>
                               </p>
                            </div>
                         </div>
                      </div>

                      <!-- Immagini Annuncio -->
                      <div class="col-md-6 col-xs-12">
                         Gallery Immagini
                      </div>

                  </div>
                  <div class="row">
                      <!-- Rispondi Annuncio -->
                      <div class="col-md-6 col-xs-12">

                        <button id="rispondi" type="button" class="btn btn-primary">Rispondi all' annuncio!</button>
                        <!-- Text Area -->
                        <br>
                        <br>
                        <div id="area" class="well" hidden>
                            <form>
                                <input class="form-control input-lg" type="Area" placeholder="Ciao! Sono interessato al tuo annuncio..." required>
                                <br>

                                <button type="submit" class="btn btn-default">Invia!</button>
                            </form>
                        </div>

                      </div>
                      <!-- Informazioni Rivenditore -->
                      <div class="col-md-6 col-xs-12">

                        <div class="panel panel-default">
                          <div class="panel-heading">Informazioni Rivenditore</div>
                        
                          <div style="padding: 20px;">

                            <div class="well well-sm col-md-4">
                              
                              <img src="assets/img_avatarM.png" style="width: 25%">

                            </div>



                            <div class="well well-sm col-md-6">

                            Panel Content

                            </div>
                            
                          </div>

                        </div>


                      </div>
                      
                  </div>
               </div>
            </div>
            <br>
            
         </div>
      </div>

      <br><br><br>

      <!-- Like Button -->
                      <button id="like" type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Devi essere Loggato per poter aggiungere fra i preferiti" <?php if(!$logged){ echo " disabled";}?>> 
                      <span id="likeGlyphicon" <?php if($liked == 1){ echo 'class="glyphicon glyphicon-ok"';} else if ($liked == 0) {echo 'class="glyphicon glyphicon-heart"';} ?> ></span>&nbsp;
                      </button>

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
      <script type="text/javascript">
         var id = <?php echo $_GET['ID'] ?>;
         var userid = <?php echo $_SESSION['ID'] ?>;
         var liked = <?php echo $liked ?>;
         var logged = <?php echo $logged ?>;
         
             $('#like').hover(function() { 
         
                 if(liked == 1){
         
                     $("#likeGlyphicon").toggleClass('glyphicon-ok glyphicon-remove');
         
                 }
         
             });
         
         
             $('#like').click(function() { 
         
                 
         
                         $.ajax({
                             url: 'like.php',
                             type: 'POST',
                             data: 'code=' + id + '&userid=' + userid + '&liked=' + liked , // An object with the key 'submit' and value 'true;
                             success: function () {
         
                                 if(liked == 0){
                                     $("#likeGlyphicon").removeClass('glyphicon-remove');
                                     $("#likeGlyphicon").removeClass('glyphicon-heart');
                                     $("#likeGlyphicon").addClass('glyphicon-ok');
                                     liked = 1;
         
                                 } else if (liked == 1) {
                                     
                                     $("#likeGlyphicon").removeClass('glyphicon-remove');
                                     $("#likeGlyphicon").removeClass('glyphicon-ok');
                                     $("#likeGlyphicon").addClass('glyphicon-heart');
                                     
                                     liked = 0;
                                 }
                             }
                         });  
         
                   
         
                 
         
         
                 
         
                 //else if liked 
         
                     //remove from db
                     //change icon back to heart
                     //restore variable
         
             });
         
         
         
         
         
         
      </script>

      <!-- Script for Hidden Div -->
      <script>
         
      $('#rispondi').click(function() { 

            $("#area").show("slow");

        }
      );

      </script>
   </body>
</html>