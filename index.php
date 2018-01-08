<!DOCTYPE html>

<?php
            session_start();

            include_once("include/db_connection.php");

            
        
?>


<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Portale Elettronica</title>


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
                <a class="navbar-brand page-scroll" href="#intro">Portale Elettronica</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#new">Nuovi Annunci</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
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
                            <a class="page-scroll" href="add.php">Aggiungi un Annuncio</a>
                        </li>
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
    <div id="intro" class="intro-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 bordered" >
                    <h1>Cerca:</h1>
                    
                    <form action="search.php" method="get">

                      <input type="text" name="searchquery">
                      <input type="submit" name="Cerca">
                        <br>
                        <br>
                    Se Vuoi Applica dei Filtri: <br>
                      <select name="Categoria" id="categoria" class="demoInputBox" onChange="getState(this.value);">
                            <?php
                               $sql = "SELECT macrocategory.ID, macrocategory.Nome FROM macrocategory";
                               
                               $results = mysql_query($sql);
                               
                               ?>

                                <option value="all">Tutte le Categorie</option>

                            <?php

                               while($row = mysql_fetch_array($results)){
                               
                                 echo "<option value='".$row['ID']."'>".$row['Nome']."</option>";
                               
                               }
                               
                            ?>
                            </select>
                            <br>
                            <br>
                            <select name="SottoCategoria" id="sottocategoria" class="demoInputBox">
                               <option value="">Seleziona Sottocategoria</option>
                            </select>




                    </form>
                    

                    

                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="new" class="about-section ">
        <div class="container ">
            <div class="row">
                <div class="col-lg-12 bordered" >
                    <h1>Gli Ultimi Annunci inseriti dagli Utenti</h1>
                    <br>
                    <table>
                        
                        <thead>
                            <th>Titolo</th>
                            <th>Descrizione</th>
                            <th>Prezzo</th>
                            <th>Data di Inserimento</th>
                            <th>Categoria</th>
                            <th>Sottocategoria</th>


                        </thead>
                        <tbody>
                            
                        <?php

                            $sql = "SELECT annunci.Titolo, annunci.Descrizione, annunci.Prezzo, annunci.DataInserimento, sottocategory.Nome as sottocategoria, macrocategory.Nome as categoria FROM annunci, users, sottocategory, macrocategory WHERE FKutente = users.ID AND FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID";

                            $result = mysql_query($sql);

                            while($row = mysql_fetch_array($result)){

                           

                                   echo" <tr> <td>".$row['Titolo']."</td> <td>".$row['Descrizione']."</td><td>".$row['Prezzo']."</td><td>".$row['DataInserimento']." </td><td>".$row['categoria']."</td><td>".$row['sottocategoria']."</td></tr>";

                            }
                            
                        ?>

                        </tbody>


                    </table>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Services Section</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Contact Section</h1>
                </div>
            </div>
        </div>
    </section>

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
