<?php
session_start();
include "user_verify_script.php"
?>
<?php
// Chiedo comferma per iniziare la procedura di eliminazione del prodotto
if (isset($_GET['deleteid'])) {
    echo 'Vuoi veramente eliminare questo amministratore (CODICE ' . $_GET['deleteid'] . ')? '
            . '<a href="admin_list.php?yesdelete=' . $_GET['deleteid'] . '">Yes</a> | '
            . '<a href="admin_list.php">No</a>';
    exit();
}

if (isset($_GET['yesdelete'])) 
    { //se la risposta è affermativa procedo con l'eliminazione
    // remove item from system and delete its picture
    // delete from database
    $id_to_delete = $_GET['yesdelete'];
    $sql = mysql_query("DELETE FROM amministratore WHERE id='$id_to_delete' LIMIT 1") or die(mysql_error());
    
    
    /*ricarico la pagina attuale, sia che l'admin abbia deciso la cancellazione
     * dell'oggetto sia nel caso contrario.
     */
    header("location: admin_list.php");
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
    $email =  $_POST["email"];

    /* come nell'altra pagina includiamo lo script di connessione al database 
     * ed effettuiamo la query "di controllo"
     */
    include "../storescripts/connect_to_mysql.php";
    $query = mysql_query("SELECT id FROM amministratore WHERE username='$username' LIMIT 1") or die(mysql_error());
    $found = mysql_num_rows($query);
    if ($found == 1) 
        { 
        /* Se troviamo un utente già registrato nel nostro database con lo 
         * stesso username mandiamo un messaggio di errore e impediamo la 
         * registrazione
         */
        echo'ERRORE: esiste già un utente registrato con questo username, si'
        . 'prega di sceglierne un altro';
       // header("location: ./admin_edit.php");
        exit();
    } else {
        /*Aggiungiamo al database un nuovo utente con i dati appena inseriti
         * 
         */
        
        $sqlCommand = mysql_query("INSERT INTO amministratore ( username, password, email, last_log_date)
            VALUES ('$username', '$password', '$email', NOW()) ") or die(mysql_error());
                // header("location: ./admin_edit.php");
     
    }
}


?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestione Admin - NewEcommerce</title>
        <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
    </head>

    <body>
        <div align="center" id="mainWrapper">
            <?php include_once("template_header.php"); ?>
            <div id="pageContent"><br />
                <table id="lista admin" width="600px"><tr><td> Id </td><td>Username</td><td>email</td><td>Ultimo accesso</td> </tr> <?php
$sql = mysql_query("SELECT * FROM amministratore");
    $adminCount = mysql_num_rows($sql);
    if ($adminCount > 0) {
        echo "<h3>Lista Amministratori:</h3>";
        while ($row = mysql_fetch_array($sql)) {
         echo "<tr><td>";
            $id = $row["id"];
    echo "$id"."</td><td>";
    $admin_name = $row["username"];
    echo "$admin_name"."</td><td>";
    $email = $row["email"];            
    echo "$email"."</td><td>";
    $date = $row["last_log_date"];
        echo "$date"."&nbsp; &nbsp; &nbsp; <a href='admin_edit.php?pid=$id'>edit</a> &bull; "
                . "<a href='admin_list.php?deleteid=$id'>delete</a></td></tr>";
       
    }
    
        }
        else {
        echo"<h3>Non vi sono attualmente amministratori. Registrane uno!</h3>";
    }
?> </table>
                <div align="left" style="margin-left:24px;">
                    <tr style="text-align: center;"> <h3>
                    &darr; Inserire i dati del nuovo amministratore &darr;
                    </h3></tr>
                    <form id="form1" name="form1" method="post" action="admin_list.php">
                        Username:<br />
                        <input name="username" type="text" id="username" size="40"  />
                        <br /><br />
                        Password:<br />
                        <input name="password" type="password" id="password" size="40"  />
                        <br /><br />
                        Email:<br />
                        <input name="email" type="text" id="email" size="40"  />
                        <br /><br />
                      
                        <br />

                        <input type="submit" name="button" id="button" value="Conferma dati" />

                    </form>
                    <p>&nbsp; </p>
                </div>
                <br />
                <br />
                <br />
            </div>
            <?php include_once("template_footer.php");             ?>
        </div>
    </body>
</html>