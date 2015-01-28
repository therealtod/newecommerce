<?php
/*
 * Script che controlla se l'utente ha una variabile di sessione che lo identifica come utente registrato.
 * Se ne è sprovvisto lo reindirizza alla pagina di login.
 *
 * necessario quando si vuole lavorare con le variabili si sessione
 */
$location_login = "location: login.php"; 
 /* * location della pagina di login
 */
if (!isset($_SESSION["userid"]))
{
header($location_login);
exit();
}
/*IMPORTANTE: Adesso, evitiamo che un utente di crei da solo un cookie "SESSION"
 * e acceda a questa pagina evitando la procedura di login. Per fare ciò, 
 * verifichiamo che i valori del suo cookie corrispondano effettivamente ai 
 * dati di accesso di un amministratore fra quelli che abbiamo nel nostro
 * datase (effettuando una query con i dati che troviamo).
 */
/*Una volta che l'utente si è loggato con successo creo tre nuove variabili.
 * Con la funzione preg_replace filtro il contenuto dei campi di SESSION, per 
 * regioni di sicurezza, sostituendo ogni carattere non permesso con una stringa
 * nulla
 */
$userid = preg_replace('#[^0-9]#i','',$_SESSION["userid"]); 
$username = preg_replace('#[^A-Za-z0-9]#i','',$_SESSION)["username"];
$password = preg_replace('#[^A-Za-z0-9]#i','', $_SESSION ["password"]);

/*recuperiamo il file di connessione al database.
 */
include "./storescripts/connect_to_mysql.php"; 
/*ed effettuiamo la query
 */
$query = mysql_query ("SELECT * FROM utente WHERE id='$userid' AND username= '$username' AND password='$password' LIMIT 1");
$found = mysql_num_rows($query);
if ($found == 0)
{
    echo "Sembra che ci sia un problema con la tua sessione, per favore ripeti la procedura di login.";
    header($location_login);
    exit();
}
?>