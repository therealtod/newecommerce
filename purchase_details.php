<?php
session_start();
require_once ("./storescripts/connect_to_mysql.php");
?>

<?php
if (isset($_GET["id"])) {
    $transid = $_GET["id"];
} else {
    header("location: ./transaction_list.php");
}
?>



<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Transazione n. <?php echo $row["prod_name"] ?></title>
        <link rel="stylesheet" href="./style/style.css" type="text/css" media="screen" />

    </head>
    <body>
        <div align="center" id="mainWrapper">
            <?php include_once("./template_header.php"); ?>
            <div id="pageContent">
                <?php
                $query = mysql_query("SELECT * FROM transactioncart WHERE trans_id = $transid") or die(mysql_error());
                $row = mysql_fetch_array($query);
                ?>
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
                <?php
                $trans_selected = mysql_query("SELECT * FROM transazione WHERE id = $transid LIMIT 1");
                $date = strftime("%b %d, %Y", strtotime($row["data"]));
                $userid = $row["user_id"];
                $pag_code = $row["pag_code"];
                $ship_code = $row["ship_code"];
                $tot = $row["tot"];
                $selected = "<b>ID: $transid - <strong>$userid</strong> - Pagato con: $pag_code - Metodo di spedizione: $ship_code -- <em>eseguito il $date</em> </b>";
                echo $selected;
                ?>

            </div>

            <?php include_once("template_footer.php");
            ?>


        </div>
    </body>
</html>