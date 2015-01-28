
<?php
session_start();
require 'storescripts/connect_to_mysql.php';
require 'user_verify_script.php';
?>

<?php
if (isset ($_GET["m"])) {
    $userid = $_SESSION["userid"];
    $ship_code = $_GET["m"];
    $query3 = mysql_query("SELECT * FROM metodospedizione WHERE ship_code = $ship_code") or die(mysql_error());
    $row3 = mysql_fetch_array($query3);
    $met_name = $row3["met_name"];
    $met_price = $row3["met_price"];
}

    if (isset ($_POST["address"]) && isset($_POST["met_pag"])) {
    $met_pag = $_POST['met_pag'];
    $ship_address = $_POST['address'];
    $query = mysql_query("INSERT INTO transazione (user_id, pay_code, ship_name, ship_price, data)"
            . "VALUES ($userid,'$met_pag','$met_name', $met_price , NOW() )") or die(mysql_error());
    $trans_id = mysql_insert_id();
    if ($met_pag == 1)
    {
        $query = mysql_query ("SELECT cardnum FROM creditcard WHERE userid=$userid") or die (mysql_error());
        $row = mysql_fetch_array($query);
        $cc_num = $row ["cardnum"];
        $query = mysql_query ("UPDATE transazione SET cc_num='$cc_num' WHERE user_id=$userid") or die (mysql_error());
    }
    $query = mysql_query("SELECT * FROM carrello WHERE user_id=$userid") or die(mysql_error());
    while ($row = mysql_fetch_array($query)) {
        $prod_code = $row["prod_code"];
        $quantity_bought = $row["quantity"];
        $query2 = mysql_query("SELECT * FROM prodotto WHERE prod_code = $prod_code") or die(mysql_error());
        $row2 = mysql_fetch_array($query2);
        $prod_name = $row2["prod_name"];
        $price = $row2["price"];
        $brand = $row2["brand"];
        $query2 = mysql_query("INSERT INTO transactioncart (trans_id, prod_name, price, quantity, brand)"
                . "VALUES ($trans_id , '$prod_name', $price, $quantity_bought, '$brand')") or die(mysql_error());
        $quantity_instock = $row2["instock"];
        $quantity_instock -= $quantity_bought;
        $query2 = mysql_query("UPDATE prodotto SET instock=$quantity_instock WHERE prod_code=$prod_code") or die(mysql_error());

//infine svuotiamo il carrello 
        $query2 = mysql_query("DELETE FROM carrello WHERE user_id = $userid");
        header("location: thanks.php");
    }
}
?>



<?php
$query = mysql_query("SELECT * FROM indirizzo WHERE user_id=$userid ORDER BY add_code") or die("Err:" . mysql_error());
$addCount = mysql_num_rows($query);
$address_list = "";
if ($addCount > 0) {

    while ($row = mysql_fetch_array($query)) {
        $n = $row["add_code"];
        $via = $row["via"];
        $citta = $row["citta"];
        $cap = $row["CAP"];
        $regione = $row["regione"];
        $paese = $row["paese"];
        $civico = $row ["civico"];
        $appartamento = $row["appart"];
        $provincia = $row["provincia"];
        $address_list .= "<input type='radio' name='address' value='$n'>   Indirizzo n.: $n -- via $via $civico $appartamento $citta $cap ($provincia) - Regione: $regione -Paese: $paese <br>";
    }
    $address_list .= 'Puoi modificare i tuoi indirizzi dal tuo <a href="user_panel.php"> pannello utente</a>';
} else {
    $address_list .= '<b>ATTENZIONE:</b> Non hai attualmente inserito indirizzi di spedizione nel tuo profilo. Aggiungine almeno uno dal tuo <a href="user_panel.php"> pannello utente</a>';
}
?>

<?php
$query = mysql_query("SELECT * FROM metodopag ORDER BY met_code") or die("Err:" . mysql_error());
$metCount = mysql_num_rows($query);
$met_list = "";
if ($metCount > 0) {

    while ($row = mysql_fetch_array($query)) {
        $met_code = $row["met_code"];
        $met_pagname = $row["met_name"];
        $met_num = $row["met_num"];
        $met_info = $row["met_info"];

        $met_list .= "<input type='radio' name='met_pag' value=$met_code> $met_pagname - $met_info - $met_num <br>";
    }
   }
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Checkout - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>

<body>
    <div align="center" id="mainWrapper">
        <?php include_once("./template_header.php"); ?>
        <div id="pageContent">
            <?php
            $query = mysql_query("SELECT * FROM carrello WHERE user_id = " . $userid);
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
                    $row2 = mysql_fetch_array($query2);
                    $prod_name = $row2["prod_name"];
                    $prod_price = $row2["price"];



                    $tot += $prod_quantity * $prod_price + $met_price;

                    $string = '<td><img src="inventory_images/' . $row["prod_code"] . '.jpg" ' . 'height=' . '"20px"></td><td id=' . '"carrello_td">' . $prod_name . "</td><td id=" . "carrello_td" . ">" . $prod_price . "€</td><td id=" . "carrello_td" . ">" . $prod_quantity . "</td><td id=" . "carrello_td" . ">" . $prod_price * $prod_quantity . "€</td>";
                    echo $string;
                    echo "</tr>";
                }
                ?>
                <tr>

                    <td></td>  <td></td> <td><?php echo $met_name; ?></td> <td></td> <td><?php echo " $met_price €" ?></td>

                    <td></td>  <td></td> <td></td> <td></td> <td>
                    </td>

                </tr> 
                <tr>

                    <td></td>  <td></td> <td></td>  <td id="totale" colspan="2" style="text-align: right;"><?php echo "Totale: $tot €" ?></td>

                    <td></td>  <td></td> <td></td> <td></td> <td>
                    </td>

                </tr> 

            </table>
            <p style="text-align: left; padding-left: 40px;"> <a href="cart.php" text-align="left">Modifica ordine</a></p>
            <br>
            <br><form action="checkout.php?m=<?php echo $ship_code ?>" enctype="multipart/form-data" name="myForm" id="myform" method="post" >
                <h3>Seleziona l'indirizzo a cui spedire l'ordine:</h3>  
                <?php echo $address_list; ?>


                <p> ------------------ </p>
        <h3>Seleziona il metodo con cui desidere pagare:</h3>
                            <?php echo $met_list; ?>

                <br>
                <input type="submit" name="button" id="button" value="Conferma ordine" />



                <br>
                <br>
                <br>
              
            </form>
        </div>
        <?php include_once("template_footer.php"); ?>
    </div>
</body>

