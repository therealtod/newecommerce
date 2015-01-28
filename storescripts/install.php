<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SIAcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<div id="install">
<?php
require "connect_to_mysql.php";
require "crea_tabella_amministratore.php";
require "crea_tabella_utente.php";
require "crea_tabella_categoria.php";
require "crea_tabella_prodotto.php";
require "crea_tabella_carrello.php";
require "crea_tabella_metodo_spedizione.php";
require "crea_tabella_indirizzo.php";
require "crea_tabella_transazione.php";
require "crea_tabella_transactioncart.php";


echo "<br>" . "Tutte le tabelle sono state create";
$adminpassword= md5("admin");
$utentepassword= md5("demo");
$sqlCommand = mysql_query("INSERT INTO amministratore ( username, password, email, last_log_date)
            VALUES ('admin', '$adminpassword', '', NOW()) ") or die(mysql_error());
$sqlCommand = mysql_query("INSERT INTO utente ( username, password, email, last_log_date)
            VALUES ('demo', '$utentepassword', '', NOW()) ") or die(mysql_error());
echo"<h3>Sono stati creati due account di test per il primo login. </h3> <br> Si consiglia di modificare la password di amministratore per sicurezza. <br> <b>Dati account amministratore:</b><br>Login: admin Password: admin<br><b>Dati account utente:</b><br> Login: demo Password: demo";

?> 
</div>