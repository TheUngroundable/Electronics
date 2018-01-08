<!DOCTYPE html>

<?php
            session_start();

            include_once("include/db_connection.php");

            $search_output = "";
            $search_result = null;
            $sql = "";
            $searchquery = "";

            if($_SERVER['REQUEST_METHOD'] == 'GET'){


                if(empty($_GET)){

                    header("Location: index.php");

                }


                //if search is set
                if(isset($_GET['searchquery']) && $_GET['searchquery'] != ""){

                    $searchquery = preg_replace('#[^a-z 0-9?!]#i','', $_GET['searchquery']);

                    
                    $sql = "SELECT annunci.ID, annunci.Titolo, annunci.Descrizione, annunci.Prezzo, annunci.DataInserimento FROM annunci WHERE Titolo LIKE '%".$searchquery."%' OR annunci.Descrizione LIKE '%".$searchquery."%'";
                    
                        if($_GET['Categoria'] != "all"){

                            //if category is selected

                            if($_GET['SottoCategoria'] == "all"){

                                //if subcategory is not set

                                $sql = "SELECT annunci.ID, annunci.Titolo, annunci.Descrizione, annunci.Prezzo, annunci.DataInserimento FROM annunci, sottocategory, macrocategory WHERE macrocategory.ID = ".$_GET['Categoria']." AND annunci.FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID HAVING annunci.titolo LIKE '%".$searchquery."%' OR annunci.Descrizione LIKE '%".$searchquery."%'";

                            } else {

                                    //if subcategory is set
                                $sql = "SELECT annunci.ID, annunci.Titolo, annunci.Descrizione, annunci.Prezzo, annunci.DataInserimento FROM annunci, sottocategory, macrocategory WHERE macrocategory.ID = ".$_GET['Categoria']." AND sottocategory.ID = ".$_GET['SottoCategoria']." AND annunci.FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID HAVING annunci.titolo LIKE '%".$searchquery."%' OR annunci.Descrizione LIKE '%".$searchquery."%'";

                            }

                        }

                } else {

                    //if search is not set

                    if($_GET['Categoria'] != "all"){

                        //If category selected
                        if($_GET['SottoCategoria'] == "all"){

                           $sql = "SELECT annunci.* FROM annunci, sottocategory, macrocategory WHERE macrocategory.ID = ".$_GET['Categoria']." AND annunci.FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID ";

                        } else {

                            $sql = "SELECT annunci.* FROM annunci, sottocategory, macrocategory WHERE macrocategory.ID = ".$_GET['Categoria']." AND sottocategory.ID = ".$_GET['SottoCategoria']." AND annunci.FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID ";

                        }

                    } else {

                        //show every record 

                        $sql = "SELECT annunci.* FROM annunci, sottocategory, macrocategory WHERE annunci.FKsottocategoria = sottocategory.ID AND sottocategory.FKcategory = macrocategory.ID ";

                    }
                }
                
                    $sql .= " order by annunci.DataInserimento";
                    $result = mysql_query($sql) or die (mysql_error());
                    $count = mysql_num_rows($result);

                    

                    if($count >= 1){


                        $search_output = "<hr />$count results for <strong>$searchquery</strong><hr />";
                        
                        $i = 0;
                        while($row =mysql_fetch_array($result)){

                            $search_result[$i]['ID'] = $row['ID'];
                            $search_result[$i]['Titolo'] = $row['Titolo'];
                            $search_result[$i]['Descrizione'] = $row['Descrizione'];
                            $search_result[$i]['Prezzo'] = $row['Prezzo'];
                            $i++;

                        }

                       
                    } else {

                        $search_output = "<hr /> 0 results for <strong>$searchquery</strong><hr />";

                    }

                    
                

            }
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
                            <a class="page-scroll" href="user.php">Ciao, <?php echo $_SESSION["nome"]; ?></a>
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
                    
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

                      <input type="text" name="searchquery" value=<?php echo '"'.$searchquery.'"'; ?>>
                      <input type="submit" name="Cerca">
                        <br>
                        <br>
                    Se Vuoi Applica dei Filtri: <br>
                      <select name="Categoria" id="categoria" class="demoInputBox" onChange="getState(this.value);" value=<?php echo "'".$_POST['Categoria']."'"; ?>>
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
                    

                    <table class="table table-striped">

                    <thead>


                        <th>Titolo</th>
                        <th>Descrizione</th>
                        <th>Prezzo</th>                                                

                    </thead>

                    <?php

                    echo $search_output;

                    if(!empty($search_result)){

                        foreach ($search_result as $key) {
                           
                            echo "<tr><td><a href ='annuncio.php?ID=".$key['ID']."'>".$key['Titolo']."</a></td><td>".$key['Descrizione']."</td><td>€".$key['Prezzo']."</td></tr>";

                        }
                    }

                    ?>

                    </table>

                    <br>
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
