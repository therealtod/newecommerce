<?php
session_start();
include "./storescripts/connect_to_mysql.php";
           if (!isset($_SESSION["userid"]))
    {
        header("location: login.php"); 
    }
    else {
        $id= $_SESSION["userid"];
        
    }
   ?>
    <?php
$sql = mysql_query("SELECT * FROM utente WHERE id=$id LIMIT 1");
    $userCount = mysql_num_rows($sql);
    if ($userCount > 0) {
        while ($row = mysql_fetch_array($sql)) {
            $username = $row["username"];
            $name = $row["name"];
            $surname = $row["surname"];
            $cod_fisc = $row["cod_fisc"];
            $email = $row["email"];                              
    }
    
        }
        else {
        echo"<h3>Utente non esistente</h3>";
    }
?>


<?php
/* Cominciamo ad elaborare i dati del form solo se l'utente ha riempito entrambi
 * i campi.
 */

if(isset($_POST["username"]) || isset($_POST["passwordold"]) || isset($_POST["email"])){
if( isset($_POST["oldpassword"]) && isset($_POST["newpassword"]) ){
    $id = mysql_real_escape_string($_POST['thisID']);
    $newpassword = md5(preg_replace('#[^A-Za-z0-9]#i', '', $_POST["passwordnew"]));
    $query = mysql_query("UPDATE utente SET password='$newpassword' WHERE id='$id'") or die("Err:" . mysql_error());    
    $_SESSION["password"] = $newpassword;

}
    

if (isset($_POST["username"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); 

    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    
    $query = mysql_query("UPDATE utente SET username='$username' WHERE id='$id'") or die("Err:" . mysql_error());
    $_SESSION["username"] = $username;
}
if (isset($_POST["email"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $email =  preg_replace('#[^A-Za-z0-9@.]#i', '', $_POST["email"]);

    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    
    $query = mysql_query("UPDATE utente SET email='$email' WHERE id='$id'") or die("Err:" . mysql_error());
}

if (isset($_POST["name"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $name =  preg_replace('#[^A-Za-z0-9]#i', '', $_POST["name"]);

    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    
    $query = mysql_query("UPDATE utente SET name='$name' WHERE id='$id'") or die("Err:" . mysql_error());
}
if (isset($_POST["surname"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $surname =  preg_replace('#[^A-Za-z0-9]#i', '', $_POST["surname"]);

    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    
    $query = mysql_query("UPDATE utente SET surname='$surname' WHERE id='$id'") or die("Err:" . mysql_error());
}
if (isset($_POST["cod_fisc"])) {
    /*ai dati inseriti applichiamo lo stesso tipo di "filtraggio" che abbiamo
     * applicato nella pagina di amministrazione
     */
    $cod_fisc =  preg_replace('#[^A-Za-z0-9]#i', '', $_POST["cod_fisc"]);

    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    
    $query = mysql_query("UPDATE utente SET cod_fisc='$cod_fisc' WHERE id='$id'") or die("Err:" . mysql_error());
}
header("location: user_panel.php");
}

?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pannello Utente - <?php echo $_SESSION["username"]; ?>  - NewEcommerce</title>
        <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
    </head>

    <body>
        <div align="center" id="mainWrapper">
            <?php include_once("template_header.php"); ?>
            <div id="pageContent"><br />
                
                <h3> Benvenuto <font color="blue"> <?php echo $_SESSION["username"]; ?></font> qui puoi gestire i tuoi dati: </h3>
    
                <form action="user_data.php?pid=<?php echo $id; ?>" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                            <td width="30%" align="right">ID utente:</td>
                            <td width="80%">
                                    <b> <?php echo $id ?></b>
                                </td>
                        </tr><tr>
                            <td width="20%" align="right">Username</td>
                            <td width="80%"><label>
                                    <input name="username" type="text" id="username" size="64" value="<?php echo $username; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right">Nome</td>
                            <td width="80%"><label>
                                    <input name="name" type="text" id="name" size="64" value="<?php echo $name; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right">Cognome</td>
                            <td width="80%"><label>
                                    <input name="surname" type="text" id="surname" size="64" value="<?php echo $surname; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td width="20%" align="right">Codice Fiscale</td>
                            <td width="80%"><label>
                                    <input name="cod_fisc" type="text" id="cod_fisc" size="64" value="<?php echo $cod_fisc; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Email</td>
                            <td><label>
                 
                                    <input name="email" type="text" id="email" size="12" value="<?php echo $email; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Inserisci vecchia password</td>
                            <td><label>
                                    <input name="oldpassword" type="password" id="oldpassword" size="12" value="<?php echo $password; ?>" />
                                </label></td>
                        </tr>
                        <tr>
                            <td align="right">Vuoi aggiornare la password? Inseriscine una nuova</td>
                            <td><label>
                                    <input name="newpassword" type="password" id="newpasswordn" size="12" />
                                </label></td>
                        </tr>
                        
                        
                            <td><label>
                                    <input name="thisID" type="hidden" value="<?php echo $id; ?>" />
                                    <input type="submit" name="button" id="button" value="Conferma Modifiche" />
                                </label></td>
                        </tr>
                    </table>
                </form>

                </div>
                                           <?php include_once("template_footer.php");             ?>
                
            </div>
    </body>
</html>
