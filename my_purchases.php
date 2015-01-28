<?php
session_start();
include "user_verify_script.php";
include "storescripts/connect_to_mysql.php";

?>

<?php
/* In questo blocco php c'è una procedura che permette di visualizzare l'intero
 * inventario sotto forma di lista
 */
/* per il momento inizializzo la variabile con una stringa vuota
 */
if(isset($_GET["p"])){

$transaction = "";
/* effettuo una query sulla tabella dei prodotti
 */
$query = mysql_query("SELECT * FROM transactioncart WHERE trans_id=$trans_id") or die("Err:" . mysql_error());
$transcartCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($transcartCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    while ($row = mysql_fetch_array($query)) {
      //  $item_n = $row["item_n"];
        $prod_name = $row["prod_name"];
        $price = $row["price"];
        $quantity = $row["quantity"];
        $brand = $row["brand"];
        $transaction .= "<tr id='purchases'><td>$prod_name</td>$price</td><td>$quantity</td></tr>";
    }
} else {
    $product_list = "Nessuna vendita che soddisfi i criteri di ricerca";
}}
?>

<?php
// Questo blocco assicura che gli errori non vengano soppressi
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
$query = mysql_query ("SELECT * FROM transazione WHERE user_id=$userid");

$transCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($transCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    $mypurchases_list= "";
    while ($row = mysql_fetch_array($query)) {
        $date_added = strftime("%b %d, %Y", strtotime($row["data"]));
        $id = $row["id"];
        $userid = $row["user_id"];
        $pag_code = $row["pay_code"];
        $ship_name = $row["ship_name"];
        $tot =  $row["ship_price"];
        $query2 = mysql_query ("SELECT price, quantity FROM transactioncart WHERE trans_id=$id");
        while ($row = mysql_fetch_array($query2))
        {
            $tot += $row["price"] * $row["quantity"];
        }
        
        
        
       
        $mypurchases_list .= "<tr id='purchases'><td>$id</td><td>$pag_code</td><td>$ship_name</td><td>$date_added</td><td>$tot</td>"
                . "<td></td><td><a href='purchase_details.php?id=$id'>dettagli</a></td></tr>";
        
    }
    }
    else {
        
        $mypurchases_list = "Non vi sono ordini attualmente eseguiti";
    }



?>









<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Storico vendite - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
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
                 <table width="90%"><tr><td><b>ID</b></td><td><b>Metodo di Pagamento</b></td><td><b>Metodo di Spedizione</b></td><td><b>Data di esecuzione ordine</b></td><td><b>Totale €</b></td><td></td><td></td></tr>
        
                <?php
                /* stampo a schermo la lista dei prodotti nell'inventario
                 */
                echo $mypurchases_list;
                ?>
                 </table>  </div>
            <hr />
           
            <br />
            <br />
        </div>
        <?php include_once("template_footer.php"); ?>
    </div>
</body>
</html>

