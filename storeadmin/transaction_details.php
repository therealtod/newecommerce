<?php
session_start();
require_once ("../storescripts/connect_to_mysql.php");
?>

<?php
if (isset($_GET["id"])) {
    $transid = $_GET["id"];
} else {
    header("location: ./transaction_list.php");
}
?>
 <?php
    $selected= "";
                $query = mysql_query("SELECT * FROM transazione WHERE id = $transid LIMIT 1");
                $row= mysql_fetch_array($query);
                $date_added = strftime("%b %d, %Y", strtotime($row["data"]));
                $userid = $row["user_id"];
                $pag_code = $row["pay_code"];
                $ship_name = $row["ship_name"];
                $tot = $row["ship_price"];
        
        $query3 = mysql_query("SELECT username FROM utente WHERE id=$userid");
        $row3 = mysql_fetch_array($query3);
        $username = $row3["username"];
        $query4 = mysql_query("SELECT met_name FROM  metodopag WHERE met_code=$pag_code");
        $row4 = mysql_fetch_array($query4);
        $met_name = $row4["met_name"];
        $query2 = mysql_query("SELECT price, quantity FROM transactioncart WHERE trans_id=$transid");
        while ($row = mysql_fetch_array($query2)) {
            $tot += $row["price"] * $row["quantity"];
        }
        
          $selected .= "<tr id='trans_selected'><td>$transid</td><td><strong>$userid - $username</strong></td><td>$met_name</td><td>$ship_name</td><td><em>$date_added</em> "
                . "</td><td>$tot</td></tr>";
   
          
                 ?>



<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Transazione n. <?php echo $row["prod_name"] ?></title>
        <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />

    </head>
    <body>
        <div align="center" id="mainWrapper">
            <?php include_once("./template_header.php"); ?>
            <div id="pageContent">
                <?php
                $query = mysql_query("SELECT * FROM transactioncart WHERE trans_id = $transid") or die(mysql_error());
                ?><br><h3> Ordine selezionato: </h3><br>
                <table id="trans" width="90%"><tr><td><b>ID</b></td><td><b>Utente</b></td><td><b>Metodo di Pagamento</b></td><td><b>Metodo di Spedizione</b></td><td><b>Data di esecuzione ordine</b></td><td><b>Totale €</b></td><td></td><td></td></tr>
        <b> <?php echo $selected ?></b></table><br>
        <br><h3> Dettagli: </h3>
                <table id="transactioncart" width="600px">
                    <tr>
                        <td></td>    <td id="titolo_cart"><b> Nome Prodotto</b></td> <td id="titolo_cart"> Prezzo Prodotto </td> <td id="titolo_cart"> Quantita'</td> <td id="titolo_cart">€</td>
                    </tr> 
                    <?php
                    $tot = 0;
                    while ($row = mysql_fetch_array($query)) {
                        echo "<tr>";

                        $prod_name = $row["prod_name"];
                        $prod_quantity = $row["quantity"];
                        $item_n = $row["item_n"];
                        $price = $row["price"];
                        $brand = $row["brand"];
                        $string = '<td></td><td id=' . '"carrello_td">' . $prod_name . "</td><td id=" . "carrello_td" . ">" . $price . "€</td><td id=" . "carrello_td" . ">" . $prod_quantity . "</td><td id=" . "carrello_td" . ">" . $price * $prod_quantity . "€</td>";
                        echo $string;
                        echo "</tr>";
                    }
                    ?>
                </table>
        
        <a href="transactions_list.php"> Torna alla lista degli ordini </a>
<br>
        <br>
            </div>

            <?php include_once("template_footer.php");
            ?>


        </div>
    </body>
</html>
