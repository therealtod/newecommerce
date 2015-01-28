<?php
session_start();
require 'user_verify_script.php';
require '../storescripts/connect_to_mysql.php';
?>
<?php
// Mi assicuro che gli errori non vengano soppressi
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
/* come nel caso in cui si aggiunge un oggetto all'inventario, anche qui 
 * controlliamo i dati inseriti nel form e effettuiamo delle query per 
 * modificare il database.
 */
if (isset($_POST['product_name'])) /* se è stato cliccato il pulsante per
 * confermare le modifiche
 */ {
    $pid = mysql_real_escape_string($_POST['thisID']);
    $product_name2 = mysql_real_escape_string($_POST['product_name']);
    $inStock2 = mysql_real_escape_string($_POST['instock']);
    $price2 = mysql_real_escape_string($_POST['price']);
    $category2 = mysql_real_escape_string($_POST['category']);
    $brand2 = mysql_real_escape_string($_POST['brand']);
    $description2 = mysql_real_escape_string($_POST['description']);
    /* aggiorniamo il database con i nuovi dati mediante un comando mysql
     */
    $sql = mysql_query("UPDATE prodotto SET prod_name='$product_name2', instock='$inStock2', price='$price2', description='$description2', cat_code='$category2', brand='$brand2' WHERE prod_code='$pid'") or die("Err:" . mysql_error());
    echo $sql;
    if ($_FILES['fileField']['tmp_name'] != "") { //se non è vuoto 
        /* Aggiorniamo anche l'immagine nel nostro archivio
         * 
         */
        $newname = "$pid.jpg";
        move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
    }
    //Refresh forzato
    //header("location: inventory_edit.php");
    //exit();
}
?>
<?php
/* prelevo le informazioni riguardanti l'oggetto selezionato e le inserisco
 * automaticamente in un form dove l'admin potrà vederle e decidere quali
 * modificare
 */
if (isset($_GET['pid'])) /* se è settata la variabile che passiamo dall'altra
 * pagina (il codice del prodotto)
 * (si potrebbe filtrare un'altra volta ma è ridondante) 
 */ {
    $targetID = $_GET['pid']; //salvo il codice su una nuova variabile
    /* query sul database per richiamare informazioni sul prodotto
     * 
     */
    $sql = mysql_query("SELECT * FROM prodotto WHERE prod_code='$targetID' LIMIT 1");
    $productCount = mysql_num_rows($sql);
    if ($productCount > 0) {
        while ($row = mysql_fetch_array($sql)) {

            $product_name = $row["prod_name"];
            $inStock = $row["instock"];
            $price = $row["price"];
            $category = $row["cat_code"];
            $brand = $row["brand"];
            $description = $row["description"];
            $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        }
    } else {
        /* non dovrebbe mai accadere visto che il codice lo passiamo in 
         * automatico dall'altra pagina
         */
        echo "ERRORE: codice prodotto inesistente nel database.";
        exit();
    }
}
?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Inventory List</title>
        <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
    </head>

    <body>
        <div align="center" id="mainWrapper">
<?php include_once("template_header.php"); ?>
            <div id="pageContent"><br />
                <a name="inventoryForm" id="inventoryForm"></a>
                <h3>
                    &darr; Modifica oggetto &darr;
                </h3>
                <form action="inventory_edit.php?pid=<?php echo $targetID; ?>" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                            <td width="20%" align="right">Nome prodotto</td>
                            <td width="80%"><label>
                                    <input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Quantità in stock</td>
                            <td><label>
                                    <input name="instock" type="text" id="price" size="12" value="<?php echo $inStock; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Prezzo</td>
                            <td><label>
                                    €
                                    <input name="price" type="text" id="price" size="12" value="<?php echo $price; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Categoria</td>
                            <td><label>

                                    <input name="category" type="text" id="category" size="8" value="<?php echo $category; ?>"

                                </label></td>
                        </tr>
                        <tr>

                        </tr>
                        <tr>
                            <td align="right">Marca</td>
                            <td><label>

                                    <input name="brand" type="text" id="brand" size="8" value="<?php echo $brand; ?>"

                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Descrizione</td>
                            <td><label>
                                    <textarea name="description" id="description" cols="64" rows="5"><?php echo $description; ?></textarea>
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Immagine del prodotto</td>
                            <td><label>
                                    <input type="file" name="fileField" id="fileField" />
                                </label></td>
                        </tr>      
                        <tr>
                            <td>&nbsp;</td>
                            <td><label>
                                    <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
                                    <input type="submit" name="button" id="button" value="Conferma Modifiche" />
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