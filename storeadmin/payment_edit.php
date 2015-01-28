<?php
session_start();
include "user_verify_script.php";
include "../storescripts/connect_to_mysql.php";
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
    $sql = mysql_query("SELECT * FROM metodopag WHERE met_code='$targetID' LIMIT 1");
        $metCount = mysql_num_rows($sql);

    if ($metCount > 0) {
        while ($row = mysql_fetch_array($sql)) {
            $payment_id = $row["met_code"];
            $payment_name = $row["met_name"];
            $payment_num = $row["met_num"];
            $payment_info = $row["met_info"];

           
        }
    } else {
        /* non dovrebbe mai accadere visto che il codice lo passiamo in 
         * automatico dall'altra pagina
         */
        echo "ERRORE: id metodo pagamento inesistente nel database.";
        exit();
    }
}
?>

<?php
/* Ottengo i dati inseriti nel form e li traduco in una istruzione mysql per
 * inserire un nuovo oggetto nel database.
 */
if (isset($_POST['payment_name2']) || isset($_POST['payment_info'])) /* se è stato cliccato il bottone per
 * inserire un nuova categoria
 */ {
    /*
     * prendiamo i dati dalla variabile _POST prodotta dal form. la funzione 
     * mysql_real_escape_string filtra di volta in volta il dato che a noi interessa
     * memorizzare nella variabile. Tale funzione produce un errore se viene 
     * utilizzata mentre non si è connessi al database 
     */
   // $product_code = mysql_real_escape_string($_POST['code']);
    $pid = mysql_real_escape_string($_GET['pid']);
    $payment_name2 = mysql_real_escape_string($_POST['payment_name2']); 
    $payment_info2 = mysql_real_escape_string($_POST['payment_info']); 
    $payment_num2 = mysql_real_escape_string($_POST['payment_num']); 


    
    $sql = mysql_query("UPDATE  metodopag SET met_name='$payment_name2', met_info='$payment_num2', met_info='$payment_info2'  WHERE met_code = '$pid'") or die(mysql_error());
    
    
    
    header("location: payment_list.php");
    exit();
}
?>




<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestione dei Metodi di Pagamento - NewEcommerce</title>
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
                <form action="payment_edit.php?pid=<?php echo$_GET['pid']; ?>" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                        <tr width="20%"> <td>Id metodo di pagamento: <b><?php echo $payment_id; ?></b></td></tr>
                        <tr>
                            <td width="20%">Nome metodo</td>
                            
                            
                            <td width="80%"><label>
                                    <input name="payment_name2" type="text" id="payment_name2" value='<?php echo $payment_name; ?>' size="64" />
                                </label></td>
                        </tr>
                        <tr>
                            <td width="20%">Compilare nel caso di codice da aggiungere: (IBAN, C/C Postale..)</td>
                            
                            
                            <td width="80%"><label>
                                    <input name="payment_num2" type="text" id="payment_num2" value='<?php echo $payment_num; ?>' size="64" />
                                </label></td>
                        </tr>
                        <tr>
                            <td width="20%">Informazioni</td>
                            
                            
                            <td width="80%"><label>
                                    <input name="payment_info" type="text" id="payment_info" value='<?php echo $payment_info; ?>' size="64" />
                                </label></td>
                        </tr>
                        <tr>
                         
                            <td><label>
                                    <input type="submit" name="button" id="button" value="Modifica Metodo di spedizione" />
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