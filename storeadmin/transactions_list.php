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
$query = mysql_query ("SELECT * FROM transazione");

$transCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($transCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    $transactions_list= "";
    while ($row = mysql_fetch_array($query)) {
        $date_added = strftime("%b %d, %Y", strtotime($row["data"]));
        $id = $row["id"];
        $userid = $row["user_id"];
        $pag_code = $row["pag_code"];
        $ship_code = $row["ship_code"];
        $tot =  $row["tot"];        
        
        
       
        $transactions_list .= "ID: $id - <strong>$userid</strong> - Pagato con: $pag_code - Metodo di spedizione: $ship_code -- <em>eseguito il $date_added</em> "
                . "&nbsp; &nbsp; &nbsp; <a href='transaction_details.php?id=$id'>dettagli</a><br>";
        
    }
    }
    else {
        
        $transactions_list = "Nessuna transazione soddisfa i criteri di ricerca.";
    }



?>



<?php
/* Ottengo i dati inseriti nel form e li traduco in una istruzione mysql per
 * inserire un nuovo oggetto nel database.
 */
$query = mysql_query ("SELECT * FROM transazione");
if (isset ($_POST["userid"]))
{
    $userid = $_POST["userid"];
    $query = mysql_query ("SELECT * FROM $query WHERE user_id=$userid") or die (mysql_error());
}
if (isset ($_POST["ship_code"]))
{
    $ship_code = $_POST["ship_code"];
    $query = mysql_query("SELECT * FROM $query WHERE ship_code = $ship_code") or die (mysql_error());
}
if (isset ($_POST["pay_code"]))
{
    $pay_code = $_POST["pay_code"];
    $query = mysql_query ("SELECT * FROM $query WHERE pay_code = $pay_code") or die (mysql_error());
}
if (isset ($_POST["tot_low_limit"]))
{
    $tot_low_limit = $_POST["tot_low_limit"];
    $query = mysql_query("SELECT * FROM $query WHERE tot> $tot_low_limit") or die (mysql_error());
}
if (isset ($_POST["tot_high_limit"]))
{
    $tot_high_limit = $_POST["tot_high_limit"];
    $query = mysql_query("SELECT * FROM $query WHERE tot <= $tot_high_limit") or die (mysql_error());
}
if (isset ($_POST["date_low_limit"]))
{
    $date_low_limit = $_POST["date_low_limit"];
    $option = 1;
}
if (isset ($_POST["date_high_limit"]))
{
    $date_high_limit = $_POST["date_high_limit"];
    $option = 1;
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
                <?php
                /* stampo a schermo la lista dei prodotti nell'inventario
                 */
                echo $transactions_list;
                ?>
            </div>
          
            <hr />
            <h3>
                &darr; Ricerca negli ordini &darr;
            </h3>
            <!-- Creo un form appoggiato ad una tabella che permetta 
            l'aggiunta di un nuovo oggetto all'inventario in maniera
            semplice e comoda. Una volta inseriti i dati il sistema eseguirà
            il comando mysql per aggiungere l'oggetto nel daabase -->
            <form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                <table width="90%" border="0" cellspacing="0" cellpadding="6">

                    <tr>
                        <td width="20%" align="right">Per ID utente</td>
                        <td width="80%"><label>
                                <input name="userid" type="text" id="userid" size="64" />
                            </label></td>
                    </tr>
                    <tr>                      </tr>
                    <tr>
                        <td align="right">Spediti Tramite</td>
                        <td> <?php
                            $query = mysql_query("SELECT * FROM metodospedizione") or die("Err:" . mysql_error());
                            $metCount = mysql_num_rows($query); // conto il numero di oggetti trovati
                            if ($metCount > 0) { //se trovo almeno una categoria
                                /*
                                 * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
                                 * Creo delle variabili che conterranno i dati dei prodotti che vado 
                                 * leggendo nella lista, e le concateno nella variabile principale
                                 */
                                echo '<select name="ship_code" id="category">';
                                while ($row = mysql_fetch_array($query)) {
                                    $cat_code = $row["ship_code"];
                                    $name = $row["met_name"];
                                    echo '<option value="' . $cat_code . '">' . $name . '</option>';
                                }
                                echo "</select>";
                            } else {
                                echo "Nessun metodo di spedizione";
                            }
                            ?>
                    </tr>
                    <tr>
                        <td align="right">Pagati con</td>
                        <td> <?php
                            $query = mysql_query("SELECT * FROM metodopag") or die("Err:" . mysql_error());
                            $metCount = mysql_num_rows($query); // conto il numero di oggetti trovati
                            if ($metCount > 0) { //se trovo almeno una categoria
                                /*
                                 * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
                                 * Creo delle variabili che conterranno i dati dei prodotti che vado 
                                 * leggendo nella lista, e le concateno nella variabile principale
                                 */
                                echo '<select name="pay_code" id="category">';
                                while ($row = mysql_fetch_array($query)) {
                                    $cat_code = $row["met_code"];
                                    $name = $row["met_name"];
                                    echo '<option value="' . $cat_code . '">' . $name . '</option>';
                                }
                                echo "</select>";
                            } else {
                                echo "Nessun metodo di pagamento";
                            }
                            ?>


                        </td>
                    </tr>
                    <tr>
                        <td align="right">Totale > di € </td>
                        <td><label>
                                <input name="tot_low_limit" type="text" id="tot_low_limit" size="12" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Totale <= di €</td>
                        <td><label>
                                <input name="tot_high_limit" type="text" id="tot_high_limit" size="12" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Antecedenti al</td>
                        <td><label>
                                <input name="date_high_limit" type="text" id="date_high_limit" size="12" />
                            </label></td>
                    </tr><tr>
                        <td align="right">Posteriori al</td>
                        <td><label>
                                <input name="date_low_limit" type="text" id="date_low_limit" size="12" />
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
