<?php
session_start(); 
/*if (isset($_SESSION["manager"])) {
    header("location: index.php");
    exit();
}*/
?>




<?php
/* Cominciamo ad elaborare i dati del form solo se l'utente ha riempito entrambi
 * i campi.
 */
if (isset($_POST["username"]) && isset($_POST["password"]) 
        && isset($_POST["name"]) && isset($_POST["surname"])
        && isset($_POST["fiscode"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); 
    $password = md5(preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]));
    $name = preg_replace('#[^A-Za-z]#i','',$_POST["name"]);
    $surname = preg_replace('#[^A-Za-z]#i','',$_POST["surname"]);
    $fiscode = preg_replace('#[^A-Za-z0-9]#i','',$_POST["fiscode"]);
    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    include "./storescripts/connect_to_mysql.php";
    $query = mysql_query("SELECT id FROM utente WHERE username='$username' LIMIT 1") or die(mysql_error());
    $found = mysql_num_rows($query);
    if ($found == 1) 
        { 
        /* Se troviamo un utente già registrato nel nostro database con lo 
         * stesso username mandiamo un messaggio di errore e impediamo la 
         * registrazione
         */
        echo'ERRORE: esiste già un utente registrato con questo username, si'
        . 'prega di sceglierne un altro';
        exit();
    } else {
        /*Aggiungiamo al database un nuovo utente con i dati appena inseriti
         * 
         */
        
        $sqlCommand = mysql_query("INSERT INTO utente ( username, password, name, surname, cod_fisc, last_log_date, last_cart_mod_date)
            VALUES ('$username', '$password', '$name', '$surname', '$fiscode', NOW(), NOW()) ") or die(mysql_error());

      //  $query = mysql_query("SELECT id FROM utente WHERE username = ". $username) or die (mysql_error());
      //  $row = mysql_fetch_row($query);
      //  $id = $row["id"];
    //    $sqlCommand2 = mysql_query("INSERT INTO carrello (user_id)
     //           VALUES ('$id')") or die (mysql_error());
        
        session_start();
        $query = mysql_query("SELECT id FROM utente WHERE username='$username' AND password='$password' LIMIT 1");
        while ($row = mysql_fetch_array($query)) {
            $userid = $row["id"];
        }
        $_SESSION["userid"] = $userid;
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        
        header("location: ./welcome.php");
    }
}


?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Registrazione nuovo utente  - NewEcommerce</title>
        <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
    </head>

    <body>
        <div align="center" id="mainWrapper">
            <?php include_once("template_header.php"); ?>
            <div id="pageContent"><br />
                <div align="left" style="margin-left:24px;">
                    <h2>Prego, inserire i dati del nuovo utente</h2>
                    <form id="form1" name="form1" method="post" action="sign_up.php">
                        Nome:<br />
                        <input name="name" type="text" id="name" size="40"  />
                        <br /><br />
                        Cognome:<br />
                        <input name="surname" type="text" id="surname" size="40"  />
                        <br /><br />
                        Codice Fiscale:<br />
                        <input name="fiscode" type="text" id="fiscode" size="40"  />
                        <br /><br />
                        User Name:<br />
                        <input name="username" type="text" id="username" size="40" />
                        <br /><br />
                        Password:<br />
                        <input name="password" type="password" id="password" size="40" />
                        <br />
                        <br />
                        <br />

                        <input type="submit" name="button" id="button" value="Conferma dati" />

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