<?php
session_start(); //facciamo in modo di poter maneggiare variabili di sessione
/* Se l'utente possiede già la variabile di login, non c'è ragione di ripetere
 * il processo di login. Lo spediamo direttamente alla pagina index per gli 
 * amministratori
 */
if (isset($_SESSION["userid"])) {
    header("location: index.php");
    exit();
}
?>




<?php
/* Cominciamo ad elaborare i dati del form solo se l'utente ha riempito entrambi
 * i campi.
 */
if (isset($_POST["username"]) && isset($_POST["password"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); 
    $password = md5(preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]));
    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    include "./storescripts/connect_to_mysql.php";
    $query = mysql_query("SELECT id, last_cart_mod_date FROM utente WHERE username='$username' AND password='$password' LIMIT 1");
    $found = mysql_num_rows($query);
    if ($found == 1) 
        { 
        /* 
         */
        while ($row = mysql_fetch_array($query)) {
            $userid = $row["id"];
            $cart_date =  strtotime($row["last_cart_mod_date"]);
        }
        $_SESSION["userid"] = $userid;
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        $query = mysql_query ("UPDATE utente SET last_log_date = NOW() WHERE id='$userid' LIMIT 1");
      if ($cart_date < strtotime (strtotime ('1 week ago', strtotime('now'))))
      {
          $query = mysql_query ("DELETE FROM carrello WHERE user_id= $userid");
      }
        if ($_GET["c"] = 1)
        {
            header("location: cart.php");
        }
        header("location: index.php");
        exit();
    } else {
        echo 'Username o password errati, riprovare. <a href="login.php">Clicca qui</a>';
        exit();
    }
}
?>
<!DOCTYPE html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login  - NewEcommerce</title>
        <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
    </head>

    <body>
        <div align="center" id="mainWrapper">
            <?php include_once("template_header.php"); ?>
            <div id="pageContent"><br />
                <div align="left" style="margin-left:24px;">
                    <h2>Prego, inserire i propri dati di accesso</h2>
                    <form id="loginform" name="loginform" method="post" action="login.php">
                        User Name:<br />
                        <input name="username" type="text" id="username" size="40" />
                        <br /><br />
                        Password:<br />
                        <input name="password" type="password" id="password" size="40" />
                        <br />
                        <br />
                        <br />

                        <input type="submit" name="button" id="button" value="Login" />

                    </form>
                </div>
                <br />
                <br />
                <br />
            </div>
                    <?php include_once("template_footer.php"); ?>
</div>
    </body>
</html>