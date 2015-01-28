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
    echo 'Vuoi veramente eliminare questa categoria (CODICE ' . $_GET['deleteid'] . ')? '
            . '<a href="category_list.php?yesdelete=' . $_GET['deleteid'] . '">Yes</a> | '
            . '<a href="category_list.php">No</a>';
    exit();
}

if (isset($_GET['yesdelete'])) 
    { //se la risposta è affermativa procedo con l'eliminazione
    // remove item from system and delete its picture
    // delete from database
    $id_to_delete = $_GET['yesdelete'];
    $sql = mysql_query("DELETE FROM categoria WHERE cat_code='$id_to_delete' LIMIT 1") or die(mysql_error());
    
    
    /*ricarico la pagina attuale, sia che l'admin abbia deciso la cancellazione
     * dell'oggetto sia nel caso contrario.
     */
    header("location: category_list.php");
    exit();
}
?>
<?php
/* Ottengo i dati inseriti nel form e li traduco in una istruzione mysql per
 * inserire un nuovo oggetto nel database.
 */
if (isset($_POST['category_name'])) /* se è stato cliccato il bottone per
 * inserire un nuova categoria
 */ {
    /*
     * prendiamo i dati dalla variabile _POST prodotta dal form. la funzione 
     * mysql_real_escape_string filtra di volta in volta il dato che a noi interessa
     * memorizzare nella variabile. Tale funzione produce un errore se viene 
     * utilizzata mentre non si è connessi al database 
     */
   // $product_code = mysql_real_escape_string($_POST['code']);
    $category_name = mysql_real_escape_string($_POST['category_name']);
    
    
    $sql = mysql_query("INSERT INTO categoria (name) 
        VALUES ( '$category_name')") or die(mysql_error());
    
    
    
    header("location: category_list.php");
    exit();
}
?>


<?php
/* In questo blocco php c'è una procedura che permette di visualizzare l'intero
 * inventario sotto forma di lista
 */
/* per il momento inizializzo la variabile con una stringa vuota
 */
$category_list = "";
/* effettuo una query sulla tabella dei prodotti
 */
$query = mysql_query("SELECT * FROM categoria ORDER BY name DESC") or die("Err:" . mysql_error());
$catCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($catCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    while ($row = mysql_fetch_array($query)) {
        $id = $row["cat_code"];
        $category_name = $row["name"];
        $category_list .= "Categoria ID: $id - <strong>$category_name</strong> -" ."&nbsp; &nbsp; &nbsp; <a href='category_edit.php?pid=$id'>edit</a> &bull; "
                . "<a href='category_list.php?deleteid=$id'>delete</a><br />";
    }
} else {
    $category_list = "L'inventario è attualmente vuoto";
}
?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestione delle Categorie - NewEcommerce</title>
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
                <div align="right" style="margin-right:32px;"><a href="category_list.php#inventoryForm">+ Aggiungi 
                        una nuova categoria</a></div>
                <div align="left" style="margin-left:24px;">
                    <h2>Lista categorie</h2>
                    <?php
                    /* stampo a schermo la lista dei prodotti nell'inventario
                     */
                    echo $category_list;
                    ?>
                </div>
                <hr />
                <!-- Aggiunta di un anchor per poter andare direttamente a 
                questo punto della pagina -->
                <a name="inventoryForm" id="inventoryForm"></a>
                <h3>
                    &darr; Inserire i dati della nuova categoria &darr;
                </h3>
                <!-- Creo un form appoggiato ad una tabella che permetta 
                l'aggiunta di un nuovo oggetto all'inventario in maniera
                semplice e comoda. Una volta inseriti i dati il sistema eseguirà
                il comando mysql per aggiungere l'oggetto nel daabase -->
                <form action="category_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                        
                        <tr>
                            <td width="20%" align="right">Nome categoria</td>
                            <td width="80%"><label>
                                    <input name="category_name" type="text" id="category_name" size="64" />
                                </label></td>
                        </tr>
                        
                         
                            <td><label>
                                    <input type="submit" name="button" id="button" value="Aggiungi categoria" />
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