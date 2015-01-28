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
    echo 'Vuoi veramente eliminare questo prodotto (CODICE ' . $_GET['deleteid'] . ')? '
            . '<a href="inventory_list.php?yesdelete=' . $_GET['deleteid'] . '">Yes</a> | '
            . '<a href="inventory_list.php">No</a>';
    exit();
}

if (isset($_GET['yesdelete'])) 
    { //se la risposta è affermativa procedo con l'eliminazione
    // remove item from system and delete its picture
    // delete from database
    $id_to_delete = $_GET['yesdelete'];
    $sql = mysql_query("DELETE FROM prodotto WHERE prod_code='$id_to_delete' LIMIT 1") or die(mysql_error());
    // procediamo inoltre con l'eliminazione dell'immagine che accompagnava
    // il prodotto
    $pictodelete = ("../inventory_images/$id_to_delete.jpg");
    if (file_exists($pictodelete)) {
        unlink($pictodelete);
    }
    /*ricarico la pagina attuale, sia che l'admin abbia deciso la cancellazione
     * dell'oggetto sia nel caso contrario.
     */
    header("location: inventory_list.php");
    exit();
}
?>
<?php
/* Ottengo i dati inseriti nel form e li traduco in una istruzione mysql per
 * inserire un nuovo oggetto nel database.
 */
if (isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['sel_category']) && isset($_POST['brand'])) /* se è stato cliccato il bottone per
 * inserire un nuovo prodotto
 */ {
    echo $_POST['sel_category'];
    /*
     * prendiamo i dati dalla variabile _POST prodotta dal form. la funzione 
     * mysql_real_escape_string filtra di volta in volta il dato che a noi interessa
     * memorizzare nella variabile. Tale funzione produce un errore se viene 
     * utilizzata mentre non si è connessi al database 
     */
   // $product_code = mysql_real_escape_string($_POST['code']);
    $product_name = mysql_real_escape_string($_POST['product_name']);
    $price = mysql_real_escape_string($_POST['price']);
    $inStock = mysql_real_escape_string($_POST['instock']);
    $category = $_POST['sel_category'];
    $brand = mysql_real_escape_string($_POST['brand']);
    $description = mysql_real_escape_string($_POST['description']);
    //Controlliamo se nel database esistano altri oggetti uguali
  /*  $query = mysql_query("SELECT * FROM prodotto WHERE prod_code='$product_code' LIMIT 1");
    $matching = mysql_num_rows($query); // numero righe corrispondenti
    if ($matching > 0) {
        echo 'ERRORE: si sta tentando di aggiungere un altro oggetto col codice "&product_code" nel sistema, <a href="inventory_list.php">clicca qui</a>';
        exit();
    } */
    // Se non abbiamo trovato un oggetto uguale ne aggiungiamo uno nuovo al DB
    $sql = mysql_query("INSERT INTO prodotto ( prod_name, instock, price, cat_code, brand, description, date_added) 
        VALUES ( '$product_name', '$inStock', '$price', '$category', '$brand', '$description', NOW())") or die(mysql_error());
    /*$sql = mysql_query("INSERT INTO prodotto (prod_code, prod_name, instock, price, category, brand, description, date_added) 
        VALUES('$product_code, $product_name',1,'$price',
            '$subcategory','$brand', '$description',now())") or die(mysql_error());*/
    $pid = mysql_insert_id();
    //Aggiungi l'immagine all'archivio immagine con il nome adequato
    $newname = $pid.'.jpg';
    $uploaded = move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/".$newname);  
    if (!$uploaded)
    {
        echo "ERRORE: non è riuscita la creazione dell'immagine";
    }
    /* Autorefresh per evitare che aggiornando la pagina dopo aver riempito il
     * form l'oggetto venga inserito due volte
     */
    header("location: inventory_list.php");
    exit();
}
?>


<?php
/* In questo blocco php c'è una procedura che permette di visualizzare l'intero
 * inventario sotto forma di lista
 */
/* per il momento inizializzo la variabile con una stringa vuota
 */
$product_list = "";
/* effettuo una query sulla tabella dei prodotti
 */
$query = mysql_query("SELECT * FROM prodotto ORDER BY date_added DESC") or die("Err:" . mysql_error());
$productCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($productCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    while ($row = mysql_fetch_array($query)) {
        $id = $row["prod_code"];
        $product_name = $row["prod_name"];
        $price = $row["price"];
        $instock2 = $row["instock"];
        $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        $product_list .= "Product ID: $id - <strong>$product_name</strong> - $$price - Quantità disponibile: $instock2 -- <em>aggiunto il $date_added</em> "
                . "&nbsp; &nbsp; &nbsp; <a href='inventory_edit.php?pid=$id'>edita</a> &bull; "
                . "<a href='inventory_list.php?deleteid=$id'>cancella</a><br />";
    }
} else {
    $product_list = "L'inventario è attualmente vuoto";
}
?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Amministrazione dell'inventario  - NewEcommerce</title>
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
                <div align="right" style="margin-right:32px;"><a href="inventory_list.php#inventoryForm">+ Aggiungi 
                        un nuovo prodotto all'inventario</a></div>
                <div align="left" style="margin-left:24px;">
                    <h2>Lista inventario</h2>
                    <?php
                    /* stampo a schermo la lista dei prodotti nell'inventario
                     */
                    echo $product_list;
                    ?>
                </div>
                <hr />
                <!-- Aggiunta di un anchor per poter andare direttamente a 
                questo punto della pagina -->
                <a name="inventoryForm" id="inventoryForm"></a>
                <h3>
                    &darr; Inserire i dati del nuovo prodotto &darr;
                </h3>
                <!-- Creo un form appoggiato ad una tabella che permetta 
                l'aggiunta di un nuovo oggetto all'inventario in maniera
                semplice e comoda. Una volta inseriti i dati il sistema eseguirà
                il comando mysql per aggiungere l'oggetto nel daabase -->
                <form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                     
                        <tr>
                            <td width="20%" align="right">Nome prodotto</td>
                            <td width="80%"><label>
                                    <input name="product_name" type="text" id="product_name" size="64" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Prezzo</td>
                            <td><label>
                                    €
                                    <input name="price" type="text" id="price" size="12" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Categoria</td>
                            <td> <?php

/* effettuo una query sulla tabella delle categorie
 */
$query = mysql_query("SELECT * FROM categoria") or die("Err:" . mysql_error());
$categoryCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($categoryCount > 0) { //se trovo almeno una categoria
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    echo '<select name="sel_category" id="category">';
    while ($row = mysql_fetch_array($query)) {
        $cat_code = $row["cat_code"];
        $name = $row["name"];
        echo '<option value="'.$cat_code .'">' .$name .'</option>';
                                   
            
         
        }
        echo "</select>";
    }
 else {
    echo "No category";
}
?>

                                    
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Quantità disponibile</td>
                            <td><label>
                                    <input name="instock" type="text" id="instock" size="12" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Marca</td>
                            <td><label>
                                    <input name="brand" type="text" id="brand" size="12" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Descrizione</td>
                            <td><label>
                                    <textarea name="description" id="description" cols="64" rows="5"></textarea>
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Immagine prodotto</td>
                            <td><label>
                                    <input type="file" name="fileField" id="fileField" />
                                </label></td>
                        </tr>      
                        <tr>
                            <td>&nbsp;</td>
                            <td><label>
                                    <input type="submit" name="button" id="button" value="Aggiungi prodotto" />
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
