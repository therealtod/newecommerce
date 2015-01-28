<?php
session_start();
include "user_verify_script.php";
include "../storescripts/connect_to_mysql.php";
?>


<?php
// Questo blocco assicura che gli errori non vengano soppressi
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
$query = mysql_query("SELECT * FROM transazione");

$transCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($transCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    $transactions_list = "";
    while ($row = mysql_fetch_array($query)) {
        $date_added = strftime("%b %d, %Y", strtotime($row["data"]));
        $id = $row["id"];
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
        $query2 = mysql_query("SELECT price, quantity FROM transactioncart WHERE trans_id=$id");
        while ($row = mysql_fetch_array($query2)) {
            $tot += $row["price"] * $row["quantity"];
        }



        $transactions_list .= "<tr id='trans_tr'><td>$id</td><td><strong>$userid - $username</strong></td><td>$met_name</td><td>$ship_name</td><td><em>$date_added</em> "
                . "</td><td>$tot</td><td><a href='transaction_details.php?id=$id'>dettagli</a></td></tr>";
    }
} else {

    $transactions_list = "Nessuna transazione da mostrare.";
}
?>



<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Storico vendite - NewEcommerce</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
    <div align="center" id="mainWrapper">
        <?php include_once("template_header.php"); ?>
        <div id="pageContent"><br />
            <!-- Aggiungo un pulsante che faccia subito raggiungere la parte
            della pagina che contiene il form per aggiungee un nuovo
            elemento al'inventario
            -->
            <div align="left" style="margin-left:24px;">
                <h2>Lista ordini eseguiti</h2>
                <table id="trans" width="90%"><tr><td><b>ID</b></td><td><b>Utente</b></td><td><b>Metodo di Pagamento</b></td><td><b>Metodo di Spedizione</b></td><td><b>Data di esecuzione ordine</b></td><td><b>Totale €</b></td><td></td><td></td></tr>
        
                <?php
                /* stampo a schermo la lista dei prodotti nell'inventario
                 */
                echo $transactions_list;
                ?>
                 </table>
                
            </div>

            <hr />

            <br />
            <br />
        </div>
        <?php include_once("template_footer.php"); ?>
    </div>
</body>
</html>
