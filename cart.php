<?php
session_start();
require 'storescripts/connect_to_mysql.php';
require 'user_verify_script.php';
?>
<?php
   $userid = $_SESSION["userid"];

?>
<?php

if (isset($_GET["checkout"])) {
    $met_spedizione =  $_POST['metodospedizione'];
    header ("location: checkout.php?m=$met_spedizione");
}
?>
<?php

if (isset($_GET['n'])) {
    $id_to_delete = $_GET['n'];
    $query = mysql_query("DELETE FROM carrello WHERE user_id=$userid and cart_element=$id_to_delete") or die(mysql_error());
    
    header ("location: cart.php?p=$userid");
}
    

?>



<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Il tuo carrello - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>

<body>
    <div align="center" id="mainWrapper">
        <?php include_once("./template_header.php"); ?>
        <div id="pageContent">
            <?php
            $query = mysql_query("SELECT * FROM carrello WHERE user_id = " . $userid);
            $n_rows = mysql_num_rows ($query);
            ?>
            <table id="carrello" width="600px">
                <tr>
                    <td></td>    <td id="titolo_cart"><b> Nome Prodotto</b></td> <td id="titolo_cart"> Prezzo Prodotto </td> <td id="titolo_cart"> Quantita'</td> <td id="titolo_cart">€</td>
                </tr> 
                <?php
                $tot = 0;
                while ($row = mysql_fetch_array($query)) {
                    echo "<tr>";
                    $query2 = mysql_query("SELECT * FROM prodotto WHERE prod_code = " . $row["prod_code"]) or die(mysql_error());
                    $prod_quantity = $row["quantity"];
                    $prod_cartnumber = $row["cart_element"];
                    while ($row2 = mysql_fetch_array($query2)) {
                        $prod_name = $row2["prod_name"];
                        $prod_price = $row2["price"];
                        $tot += $prod_quantity * $prod_price;
                    }
                    $string = '<td><img src="inventory_images/' . $row["prod_code"] . '.jpg" ' . 'height=' . '"20px"></td><td id=' . '"carrello_td">' . $prod_name . "</td><td id=" . "carrello_td" . ">" . $prod_price . "€</td><td id=" . "carrello_td" . ">" . $prod_quantity . "</td><td id=" . "carrello_td" . ">" . $prod_price * $prod_quantity . "€</td>";
                    echo $string . '<td> <a href="cart.php?n=' . $prod_cartnumber . ' ">cancella</a><br /> </td>';
                    echo "</tr>";
                }
                ?>
                <tr>
                
                    <td></td>  <td></td> <td></td>  <td id="totale" colspan="2" style="text-align: right;"><?php echo "Subtotale: $tot €" ?></td>

                    <td></td>  <td></td> <td></td> <td></td> <td>
                     </td>
                
                </tr> 

            </table><div id="checkout" align="right">
             <form action="cart.php?checkout=<?php echo $userid; ?>" enctype="multipart/form-data" name="myForm" id="myform" method="post">  
                 
                 <?php

/* effettuo una query sulla tabella delle categorie
 */
$query = mysql_query("SELECT * FROM metodospedizione") or die("Err:" . mysql_error());
$met_count = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($met_count > 0) { //se trovo almeno una categoria
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    echo '<select name="metodospedizione" id="metodospedizione">';
    while ($row = mysql_fetch_array($query)) {
        $codice_metodo = $row["ship_code"];
        $met_name = $row["met_name"];
        $met_price = $row["met_price"];
        echo '<option value="'.$codice_metodo .'">' .$met_name.' - '.$met_price.'€</option>';
                                   
            
         
        }
        echo "</select>";
    }
 else {
    echo "Nessun metodo di spedizione selezionabile";
}
?>
                 <?php 
                 if ($n_rows != 0)
                 {         
                 ?>
                 <input type="submit" name="pay" id="button" value="Paga ora" />
                     </form></div>
            <?php
                 }
                 ?>
            <br>
            <br>
            

        </div>
        <?php include_once("template_footer.php"); ?>
    </div>
</body>

<?php
/* FUNZIONI QUANDO SI CLICCA PAGA ORA - DA SISTEMARE
  if (isset($_POST["pay"]){

  $sqlCommand = mysql_query("INSERT INTO transazione ( user_id, password, name, surname, cod_fisc, last_log_date)
  VALUES ('$username', '$password', '$name', '$surname', '$fiscode', NOW()) ") or die(mysql_error());
  } */
?>
