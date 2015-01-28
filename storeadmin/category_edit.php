<?php
session_start();
include "user_verify_script.php";
include "../storescripts/connect_to_mysql.php";
?>



<?php
/* Ottengo i dati inseriti nel form e li traduco in una istruzione mysql per
 * inserire un nuovo oggetto nel database.
 */
if (isset($_POST['category_name2'])) /* se è stato cliccato il bottone per
 * inserire un nuova categoria
 */ {
    /*
     * prendiamo i dati dalla variabile _POST prodotta dal form. la funzione 
     * mysql_real_escape_string filtra di volta in volta il dato che a noi interessa
     * memorizzare nella variabile. Tale funzione produce un errore se viene 
     * utilizzata mentre non si è connessi al database 
     */
   // $product_code = mysql_real_escape_string($_POST['code']);
    $pid = $_GET['pid'];
    $category_name = mysql_real_escape_string($_POST['category_name2']);
    
 
    $sql = mysql_query("UPDATE  categoria  SET name='$category_name' WHERE cat_code = '$pid'") or die(mysql_error());
    
    
    
    header("location: category_list.php");
    exit();
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
    $category_id = $_GET['pid']; //salvo il codice su una nuova variabile
    /* query sul database per richiamare informazioni sul prodotto
     * 
     */
    $sql = mysql_query("SELECT * FROM categoria WHERE cat_code='$category_id' LIMIT 1");
        $adminCount = mysql_num_rows($sql);

    if ($adminCount > 0) {
        while ($row = mysql_fetch_array($sql)) {
            $category_name = $row["name"];
           
        }
    } else {
        /* non dovrebbe mai accadere visto che il codice lo passiamo in 
         * automatico dall'altra pagina
         */
        echo "ERRORE: id categoria inesistente nel database.";
        exit();
    }
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
                <div align="right" style="margin-right:32px;">
                <!-- Creo un form appoggiato ad una tabella che permetta 
                l'aggiunta di un nuovo oggetto all'inventario in maniera
                semplice e comoda. Una volta inseriti i dati il sistema eseguirà
                il comando mysql per aggiungere l'oggetto nel daabase -->
                <form action="category_edit.php?pid=<?php echo $category_id; ?>" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                        <tr width="20%"> <td>Id categoria: <b><?php echo $category_id; ?></b></td></tr>
                        <tr>
                            <td width="20%">Nome categoria</td>
                            
                            
                            <td width="80%"><label>
                                    <input name="category_name2" type="text" id="category_name" value='<?php echo $category_name; ?>' size="64" />
                                </label></td>
                        </tr>
                        
                         
                            <td><label>
                                    <input type="submit" name="button" id="button" value="Modifica categoria" />
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