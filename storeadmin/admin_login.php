<?php
session_start(); //facciamo in modo di poter maneggiare variabili di sessione
/* Se l'utente possiede già la variabile di login, non c'è ragione di ripetere
 * il processo di login. Lo spediamo direttamente alla pagina index per gli 
 * amministratori
 */
if (isset($_SESSION["admin_id"])) {
  header("location: index.php");
   exit();
}
?>




<?php
/* Cominciamo ad elaborare i dati del form solo se l'utente ha riempito entrambi
 * i campi.
 */
if (isset($_POST["admin_name"]) && isset($_POST["admin_password"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["admin_name"]); 
    $password = md5(preg_replace('#[^A-Za-z0-9]#i', '', $_POST["admin_password"]));
    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    include "../storescripts/connect_to_mysql.php";
    $query = mysql_query("SELECT id FROM amministratore WHERE username='$manager' AND password='$password' LIMIT 1");
    $found = mysql_num_rows($query);
    if ($found == 1) 
        { 
        /* Se abbiamo trovato una corrispondenza fra le credenziali inserite e i
         * dati contenuti nel nostro database, ammettiamo l'utente alla pagina 
         * di amministrazione dotandolo della variabile di sessione 
         * correttamente settata.
         */
        while ($row = mysql_fetch_array($query)) {
            $admin_id = $row["id"];
        }
        $_SESSION["admin_id"] = $admin_id;
        $_SESSION["admin_name"] = $manager;
        $_SESSION["admin_password"] = $password;
        $query= mysql_query("UPDATE amministratore SET last_log_date = NOW() WHERE id='$admin_id' LIMIT 1");
        header("location: ./index.php");
        exit();
    } else {
        echo 'I dati inseriti non sono corretti, riprovare. <a href="index.php">Click Here</a>';
        exit();
    }
}
?>
<!DOCTYPE html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pagina di Login per amministratori  - NewEcommerce</title>
        <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
    </head>

    <body>
        <div align="center" id="mainWrapper">
            <?php include_once("template_header.php"); ?>
            <div id="pageContent"><br />
                <div align="left" style="margin-left:24px;">
                    <h2>Prego, inserire i propri dati di accesso</h2>
                    <form id="form1" name="form1" method="post" action="admin_login.php">
                        User Name:<br />
                        <input name="admin_name" type="text" id="username" size="40" />
                        <br /><br />
                        Password:<br />
                        <input name="admin_password" type="password" id="password" size="40" />
                        <br />
                        <br />
                        <br />

                        <input type="submit" name="button" id="button" value="Log In" />

                    </form>
                    <p>&nbsp; </p>
                </div>
                <br />
                <br />
                <br />
            </div>
            <?php include_once("template_footer.php"); ?>
        </div>
    </body>
</html>
