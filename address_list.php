<?php
session_start();
include "user_verify_script.php";
include "./storescripts/connect_to_mysql.php";
?>


<?php
// Questo blocco assicura che gli errori non vengano soppressi
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
$userid = $_SESSION["userid"];
?>
<?php
if (isset($_GET['deleten'])) {
    $add_to_delete = $_GET['deleten'];
    $query = mysql_query("DELETE FROM indirizzo WHERE user_id=$userid and add_code=$add_to_delete") or die(mysql_error());
}

?>
<?php
/* Ottengo i dati inseriti nel form e li traduco in una istruzione mysql per
 * inserire un nuovo oggetto nel database.
 */
if (isset($_POST['via']) && isset($_POST['citta']) && isset($_POST['cap']) && isset($_POST['regione']) && isset($_POST["paese"])) /* se è stato cliccato il bottone per
 * inserire un nuovo prodotto
 */ {
    /*
     * prendiamo i dati dalla variabile _POST prodotta dal form. la funzione 
     * mysql_real_escape_string filtra di volta in volta il dato che a noi interessa
     * memorizzare nella variabile. Tale funzione produce un errore se viene 
     * utilizzata mentre non si è connessi al database 
     */
    // $product_code = mysql_real_escape_string($_POST['code']);
    $via = mysql_real_escape_string($_POST['via']);
    $citta = mysql_real_escape_string($_POST['citta']);
    $cap = mysql_real_escape_string($_POST['cap']);
    $regione = mysql_real_escape_string($_POST['regione']);
    $paese = mysql_real_escape_string($_POST['paese']);
    $civico = NULL;
    $appartamento = NULL;
    $provincia = NULL;
    if (isset($_POST["civico"])) {
        $civico = mysql_real_escape_string($_POST['civico']);
    }
    if (isset($_POST["appartamento"])) {
        $appartamento = mysql_real_escape_string($_POST['appartamento']);
    }
    if (isset($_POST["provincia"])) {
        $provincia = mysql_real_escape_string($_POST['provincia']);
    }

    //Controlliamo se nel database esistano altri oggetti uguali
    /*  $query = mysql_query("SELECT * FROM prodotto WHERE prod_code='$product_code' LIMIT 1");
      $matching = mysql_num_rows($query); // numero righe corrispondenti
      if ($matching > 0) {
      echo 'ERRORE: si sta tentando di aggiungere un altro oggetto col codice "&product_code" nel sistema, <a href="inventory_list.php">clicca qui</a>';
      exit();
      } */
    // Se non abbiamo trovato un oggetto uguale ne aggiungiamo uno nuovo al DB
    $sql = mysql_query("INSERT INTO indirizzo ( user_id, via, civico, appart, citta, cap, provincia, regione, paese) 
        VALUES ( '$userid', '$via', '$civico', '$appartamento', '$citta', '$cap', '$provincia','$regione', '$paese')") or die(mysql_error());
    /* $sql = mysql_query("INSERT INTO prodotto (prod_code, prod_name, instock, price, category, brand, description, date_added) 
      VALUES('$product_code, $product_name',1,'$price',
      '$subcategory','$brand', '$description',now())") or die(mysql_error()); */
    $deleten = mysql_insert_id();
   
    if (!$uploaded) {
        echo "ERRORE: non è riuscita la creazione dell'immagine";
    }
    /* Autorefresh per evitare che aggiornando la pagina dopo aver riempito il
     * form l'oggetto venga inserito due volte
     */
    header("location: address_list.php");
    exit();
}
?>


<?php
$query = mysql_query("SELECT * FROM indirizzo WHERE user_id=$userid ORDER BY add_code") or die("Err:" . mysql_error());
$addCount = mysql_num_rows($query); 
if ($addCount > 0) { 
   $address_list = "";
    while ($row = mysql_fetch_array($query)) {
        $n = $row["add_code"];
        $via = $row["via"];
        $citta = $row["citta"];
        $cap = $row["CAP"];
        $regione = $row["regione"];
        $paese = $row["paese"];
        $civico = $row ["civico"];
        $appartamento = $row["appart"];
        $provincia = $row["provincia"];
        $address_list .= "Indirizzo n.: $n -- via $via $civico $appartamento $citta $cap ($provincia)  -  Regione: $regione  -  Paese: $paese"
                . " &bull; "
                . "<a href='address_list.php?userid=$userid&deleten=$n'>cancella</a><br />";
    }
} else {
    $address_list = "Attualmente non hai registrato nemmeno un indirizzo";
}
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>I tuoi indirizzi  - NewEcommerce</title>
    <link rel="stylesheet" href="./style/style.css" type="text/css" media="screen" />
</head>

<body>
    <div align="center" id="mainWrapper">
        <?php include_once("template_header.php"); ?>
        <div id="pageContent"><br />
            <!-- Aggiungo un pulsante che faccia subito raggiungere la parte
            della pagina che contiene il form per aggiungee un nuovo
            elemento al'inventario
            -->
            <div align="right" style="margin-right:32px;"><a href="address_list.php#myForm">+ Aggiungi 
                    un nuovo indirizzo</a></div>
            <div align="left" style="margin-left:24px;">
                <h2>Lista inventario</h2>
                <?php
                /* stampo a schermo la lista dei prodotti nell'inventario
                 */
                echo $address_list;
                ?>
            </div>
            <hr />
            <!-- Aggiunta di un anchor per poter andare direttamente a 
            questo punto della pagina -->
            <a name="addressForm" id="addressForm"></a>
            <h3>
                &darr; Inserire i dati del nuovo indirizzo &darr;
            </h3>
            <!-- Creo un form appoggiato ad una tabella che permetta 
            l'aggiunta di un nuovo oggetto all'inventario in maniera
            semplice e comoda. Una volta inseriti i dati il sistema eseguirà
            il comando mysql per aggiungere l'oggetto nel database -->
            <form action="address_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                <table width="90%" border="0" cellspacing="0" cellpadding="6">

                    <tr>
                        <td width="20%" align="right">Via</td>
                        <td width="80%"><label>
                                <input name="via" type="text" id="via" size="32" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">N.Civico</td>
                        <td><label>
                                <input name="civico" type="text" id="civico" size="12" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Appartamento</td>
                        <td><label>
                                <input name="appartamento" type="text" id="appartamento" size="12" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Città</td>
                        <td><label>
                                <input name="citta" type="text" id="citta" size="64" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">C.A.P.</td>
                        <td><label>
                                <input name="cap" type="text" id="cap" size="5" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Provincia</td>
                        <td><label>
                                <input name="provincia" type="text" id="provincia" size="12" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Regione</td>
                        <td><label>
                                <input name="regione" type="text" id="regione" size="20" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Paese</td>
                        <td><label>
                                <input name="paese" type="text" id="paese" size="64" />
                            </label></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><label>
                                <input type="submit" name="button" id="button" value="Conferma dati" />
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

