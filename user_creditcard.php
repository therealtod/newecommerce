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
/* Cominciamo ad elaborare i dati del form solo se l'utente ha riempito entrambi
 * i campi.
 */
if(isset($_POST["creditcardnew"])){
    $creditcard = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["creditcardnew"]);
    $query = mysql_query("INSERT INTO creditcard ( userid, cardnum )
            VALUES ('$id', '$creditcard'") or die("Err:" . mysql_error());   

}

if(isset($_POST["creditcard"])){
    $creditcard = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["creditcard"]);
    $query = mysql_query("UPDATE creditcard SET card_num='$creditcard' WHERE userid='$id'") or die("Err:" . mysql_error());   

}
    

?>
    <?php
    $credit_card ="";
$sql = mysql_query("SELECT * FROM creditcard WHERE userid=$id LIMIT 1");
    $userCount = mysql_num_rows($sql);
    if ($userCount > 0) {
     $row = mysql_fetch_array($sql);
            $creditcard = $row["creditcard"];
            $credit_card .= "Attualmente hai associato la seguente carta al tuo utente: <b>$creditcard</b><br><br>"
                    ."vuoi aggiornarla? Inseriscine una nuova: <input name='creditcard' type='text' id='creditcard' size='64' />";
           
    }
        else {
            $credit_card .= "Non vi sono carte di credito associate al tuo utente, inseriscine una: "
                    . "<input name='creditcardnew' type='text' id='creditcard' size='64' />";
                
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
                
    
                <form action="user_creditcard.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                    <table width="90%" border="0" cellspacing="0" cellpadding="6">
                        
                        <tr>
                            <?php echo $credit_card; ?>
                        </tr>
                      
                        
                        
                            <td><label>
                                   
                                    <input type="submit" name="button" id="button" value="Conferma Modifiche" />
                                </label></td>
                        </tr>
                    </table>
                </form>
                <p>
                    <a href="user_panel.php">Torna al tuo Pannello utente</a></p>

                </div>
                                           <?php include_once("template_footer.php");             ?>
                
            </div>
    </body>
</html>
