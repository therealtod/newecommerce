<?php
session_start();
include "./storescripts/connect_to_mysql.php";
require ('./user_verify_script.php');
?>

<?php
$id = $_SESSION["userid"];
$sql = mysql_query("SELECT * FROM creditcard WHERE userid=$id LIMIT 1") or die (mysql_error());
$rowcount = mysql_num_rows($sql);
if ($rowcount > 0) {
    $row = mysql_fetch_array($sql);
    $creditcard = $row["cardnum"];
    $message = "Attualmente hai associato la seguente carta al tuo account: <b>$creditcard</b><br><br>"
            . "Per sostituirla, scrivi qui in basso il numero della nuova carta e conferma<br>";
} else {
    $message = "Non vi sono carte di credito associate al tuo utente, inseriscine una:";
}
?>
<?php
if (isset($_POST["creditcard"])) {
    $creditcard = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["creditcard"]);
    if ($rowcount == 0) {
        $query = mysql_query("INSERT INTO creditcard ( userid, cardnum )
            VALUES ($id, '$creditcard')") or die("Err:" . mysql_error());
    } else {
        $query = mysql_query("UPDATE creditcard SET cardnum='$creditcard' WHERE userid=$id") or die("Err:" . mysql_error());
        header ("location: user_creditcard.php");
    }
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

                <table width="90%" border="0" cellspacing="0" cellpadding="6">

            <form action="user_creditcard.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">

                    <tr>
<?php echo $message; ?>

                    <input name='creditcard' type='text' id='creditcard' size='64' />
                    </tr>

                    <tr>

                    <label>

                            <input type="submit" name="button" id="button" value="Conferma Modifiche" />
                        </label>
                    </tr>
            </form>
                    <p><tr>
                    <a href="user_panel.php">Torna al tuo Pannello utente</a></p></tr>
                
        </table>
        </div>
<?php include_once("template_footer.php"); ?>

    </div>
</body>
</html>
