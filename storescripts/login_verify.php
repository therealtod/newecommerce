<?php
/*
 * Script che controlla se l'utente ha un cookie che lo identifica come admin.
 * Se ne è sprovvisto lo reindirizza alla pagina di login degli amministratori.
 */
session_start(); /*
 * necessario quando si vuole lavorare con le variabili di sessione
 */
$location_user_login = "location: ../login.php"; /*
 * location della pagina di login
 */
if (!isset($_SESSION["logged_user"]))
{
//header($location_admin_login);
exit();
}
/*IMPORTANTE: 
 */
/*
 */
$userid = preg_replace('#[^0-9]#i','',$_SESSION["id"]); 
$username = preg_replace('#[^A-Za-z0-9]#i','',$_SESSION)["username"];
$password = preg_replace('#[^A-Za-z0-9]#i','', $_SESSION ["password"]);

/*recuperiamo il file di connessione al database.
 */
include "../storescripts/connect_to_mysql.php"; 
/*ed effettuiamo la query
 */
$query = mysql_query ("SELECT * FROM utente WHERE id='$userid' AND username= '$username' AND password='$password' LIMIT 1");
$found = mysql_num_rows($query);
if ($found == 0)
{
    echo "Sembra che ci sia un problema. La tua sessione è stata terminata automaticamente.";
    exit();
}
?>