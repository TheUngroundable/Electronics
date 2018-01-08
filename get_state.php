<?php

include_once("include/db_connection.php");

//DROPDOWN LOGIC

if(!empty($_POST["valCategoria"])) {
    $query ="SELECT ID, Nome FROM sottocategory WHERE FKcategory = '" . $_POST["valCategoria"] . "'";
    $results = mysql_query($query);
?>
    <option value="all">Seleziona Sottocategoria</option>

<?php
    
    while($row = mysql_fetch_array($results)){

        echo "<option value='".$row['ID']."'>".$row['Nome']."</option>";


    }

}
?>