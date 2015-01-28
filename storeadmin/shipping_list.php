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
// Chiedo comferma per iniziare la procedura di eliminazione del prodotto
if (isset($_GET['deleteid'])) {
    echo 'Vuoi veramente eliminare questo metodo? (CODICE ' . $_GET['deleteid'] . ')? '
            . '<a href="shipping_list.php?yesdelete=' . $_GET['deleteid'] . '">Yes</a> | '
            . '<a href="shipping_list.php">No</a>';
    exit();
}

if (isset($_GET['yesdelete'])) 
    { //se la risposta è affermativa procedo con l'eliminazione
    // remove item from system and delete its picture
    // delete from database
    $id_to_delete = $_GET['yesdelete'];
    $sql = mysql_query("DELETE FROM metodospedizione WHERE ship_code='$id_to_delete' LIMIT 1") or die(mysql_error());
    
    
    /*ricarico la pagina attuale, sia che l'admin abbia deciso la cancellazione
     * dell'oggetto sia nel caso contrario.
     */
    header("location: shipping_list.php");
    exit();
}
?>
<?php
/* Ottengo i dati inseriti nel form e li traduco in una istruzione mysql per
 * inserire un nuovo oggetto nel database.
 */
if (isset($_POST['shipping_name'])) /* se è stato cliccato il bottone per
 * inserire un nuova categoria
 */ {
    /*
     * prendiamo i dati dalla variabile _POST prodotta dal form. la funzione 
     * mysql_real_escape_string filtra di volta in volta il dato che a noi interessa
     * memorizzare nella variabile. Tale funzione produce un errore se viene 
     * utilizzata mentre non si è connessi al database 
     */
   // $product_code = mysql_real_escape_string($_POST['code']);
    $shipping_name = mysql_real_escape_string($_POST['shipping_name']);
    $met_price = mysql_real_escape_string($_POST['met_price']);
    
    
    $sql = mysql_query("INSERT INTO metodospedizione ( met_name, met_price ) 
        VALUES ( '$shipping_name', '$met_price')") or die(mysql_error());
    
    
    
    header("location: shipping_list.php");
    exit();
}
?>


<?php
/* In questo blocco php c'è una procedura che permette di visualizzare l'intero
 * inventario sotto forma di lista
 */
/* per il momento inizializzo la variabile con una stringa vuota
 */
$shipping_list = "";
/* effettuo una query sulla tabella dei prodotti
 */
$query = mysql_query("SELECT * FROM metodospedizione ORDER BY ship_code DESC") or die("Err:" . mysql_error());
$metCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($metCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    while ($row = mysql_fetch_array($query)) {
        $id = $row["ship_code"];
        $shipping_name = $row["met_name"];
        $met_price = $row["met_price"];
        $shipping_list .= "ID: $id - <strong>$shipping_name</strong> - Costo: $met_price €" ."&nbsp; &nbsp; &nbsp; <a href='shipping_edit.php?pid=$id'>edita</a> &bull; "
                . "<a href='shipping_list.php?deleteid=$id'>cancella</a><br />";
    }
} else {
    $shipping_list = "Non sono stati inseriti metodi di spedizione. Inseriscine almeno uno per i tuoi clienti";
}
?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestione dei Metodi di Spedizione  - NewEcommerce</title>
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
                <div align="right" style="margin-right:32px;"><a href="shipping_list.php#inventoryForm">+ Aggiungi 
                        un nuovo metodo di spedizione</a></div>
                <div align="left" style="margin-left:24px;">
                    <h2>Lista Metodi Spedizione</h2>
                    <?php
                    /* stampo a schermo la lista dei prodotti nell'inventario
                     */
                    echo $shipping_list;
                    ?>
                </div>
                <hr />
                <!-- Aggiunta di un anchor per poter andare direttamente a 
                questo punto della pagina -->
                <a name="inventoryForm" id="inventoryForm"></a>
                <h3>
                    &darr; Inserire i dati del nuovo metodo di spedizione &darr;
                </h3>
                <!-- Creo un form appoggiato ad una tabella che permetta 
                l'aggiunta di un nuovo oggetto all'inventario in maniera
                semplice e comoda. Una volta inseriti i dati il sistema eseguirà
                il comando mysql per aggiungere l'oggetto nel daabase -->
                <form action="shipping_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                        
                        <tr>
                            <td width="20%" align="right">Nome Metodo di Spedizione</td>
                            <td width="80%"><label>
                                    <input name="shipping_name" type="text" id="shipping_name" size="64" />
                                </label></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right">Costo per il cliente €</td>
                            <td width="80%"><label>
                                    <input name="met_price" type="text" id="met_price" size="64" />
                                </label></td>
                        </tr>
                         
                            <td><label>
                                    <input type="submit" name="button" id="button" value="Aggiungi" />
                                </label></td>
                        </tr>
                    </table>
                </form>
                <br />
                <br />
            </div>
            <?php include_once("template_footer.php"); ?>
        </div>
    </body>
</html>