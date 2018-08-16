<?php

        session_start();
        if(!isset($_SESSION['session'])){ 
            header("Location: index.php");  
        }

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo "Ciao, ".$_SESSION['nome'] ?></title>


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

<style type="text/css">
    
    th {

        text-align: center;

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

                        include_once("include/db_connection.php");


                    ?>
                    
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
                    <h1>Bentornat<?php


                    $sql ="SELECT Sesso From users where ID = ".$_SESSION['ID'];
                    $result = $conn->query($sql);
                    $result = $result->fetch_assoc();

                    if($result['Sesso'] == 'M'){

                        echo "o";
 
                    } else if ($result['Sesso'] == 'F'){

                        echo "a";

                    }

                     ?>, <?php echo $_SESSION['nome']; ?></h1>
                    <a href=<?php echo '"edit.php?id='.$_SESSION['ID'].'"'; ?>>Modifica il tuo profilo</a>
                    <hr>

                    <div class="row" style="padding: 25px">

                        <ul class="nav nav-tabs">
                          <li class="active"><a data-toggle="tab" href="#annunci">I Tuoi Annunci</a></li>
                          <li><a data-toggle="tab" href="#preferiti">I Tuoi Annunci Preferiti</a></li>
                        </ul>

                        <div class="tab-content">
                          <div id="annunci" class="tab-pane fade in active">
                            <h3>I Tuoi Annunci</h3>
                            
                            <table class="table table-striped">


                        <?php

                        $sql = "SELECT annunci.ID, annunci.Titolo, annunci.Descrizione, annunci.Prezzo, annunci.DataInserimento, sottocategory.Nome as sottocategoria, macrocategory.Nome as categoria FROM annunci, users, sottocategory, macrocategory WHERE FKutente = users.ID AND FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID AND users.Email = '".$_SESSION['email']."'";
                        $result = $conn->query($sql) or die ("problemino con la query");
                        
                        if($result->num_rows!=0){

                        ?>

                        <thead>
                            
                            <th>Titolo</th>
                            <th><span class="glyphicon glyphicon-euro"></span></th>
                            <th><span class="glyphicon glyphicon-calendar"></span></th>
                            <th><span class="glyphicon glyphicon-eye-open"></span></th>
                            <th><span class="glyphicon glyphicon glyphicon-flash"></span></th>



                        </thead>
                        <tbody>
                        
                        <?php

                        
                                while($row = $result->fetch_array()){

                                   echo"<tr><td><a href='annuncio.php?ID=".$row['ID']."'>".$row['Titolo']."</a></td><td>".$row['Prezzo']."</td><td>".$row['DataInserimento']." </td><td>".$row['categoria']."</td><td><a href='edit_ad.php?id=".$row['ID']."'>Modifica</a></td></tr>";

                                    }
                            } else {

                                echo "<h3>Non hai ancora inserito degli annunci!<h3><h4>Inseriscine uno <a href='#'>adesso</a>";


                            }
                        
                        ?>
                        </tbody>
                        </table>


                          </div>

                          <div id="preferiti" class="tab-pane fade">
                            <h3>I Tuoi Annunci Preferiti</h3>
                        <table class="table table-striped">


                        <?php

                        $sql = "SELECT annunci.ID, annunci.Titolo, annunci.Descrizione, annunci.Prezzo, annunci.DataInserimento, sottocategory.Nome as sottocategoria, macrocategory.Nome as categoria FROM annunci, users, sottocategory, macrocategory, likes WHERE FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID AND likes.FKutente = users.ID AND likes.FKannuncio = annunci.ID AND users.Email = '".$_SESSION['email']."'";
                        $result = $conn->query($sql) or die ("problemino con la query");
                        
                        if($result->num_rows!=0){

                        ?>

                        <thead>
                            
                            <th>Titolo</th>
                            
                            <th><span class="glyphicon glyphicon-euro"></span></th>
                            <th><span class="glyphicon glyphicon-calendar"></span></th>
                            <th>Categoria</th>
                            <th>Sottocategoria</th>



                        </thead>
                        <tbody>
                        
                        <?php

                                while($row = $result->fetch_array()){

                                   echo" <tr><td><a href='annuncio.php?ID=".$row['ID']."'>".$row['Titolo']."</a></td> <td>".$row['Prezzo']."</td><td>".$row['DataInserimento']." </td><td>".$row['categoria']."</td><td>".$row['sottocategoria']."</td></tr>";

                                    }
                            } else {

                                echo "<h3>Non hai ancora inserito degli annunci preferiti!</h3>";


                            }
                        
                        ?>
                        </tbody>
                        </table>



                          </div>

                          
                        </div>

                    </div>
                    


                   
                    <!-- Favourite Advertisement Section -->

                    <div>
                        <hr>
                        
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
    <br>
    <br>
    <br>
    <br>
    

    

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
