<?php
session_start();
include "user_verify_script.php"
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Pannello Utente - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>

<body>
    <div align="center" id="mainWrapper">
        <?php include_once("template_header.php"); ?>
        <div id="pageContent">
            <p><h2>Benvenuto nel pannello utente. </h2></p>
            <table id="panel_menu" width="800px">
                <tr id="panel_menu">
                    <td id="panel_td" width="25%"> <a href="./user_data.php"> <img src="./style/editPD.png" height="100px"> <br> Modifica i dati personali </a></td> 
                    <td id="panel_td" width="25%"><a href="./address_list.php"><img src="./style/category.png" height="100px"> <br> Modifica Indirizzi</a> </td> 
                    <td id="panel_td" width="25%"><a href="./my_purchases.php"><img src="./style/fatture.png" height="100px"> <br>I miei acquisti</a></td>
                    <td id="panel_td" width="25%"><a href="./user_creditcard.php"><img src="./style/creditcard.png" height="100px"> <br>Aggiorna/inserisci carta di credito</a></td>

            </table>
            <br>
            <br>
        </div>
        <?php include_once("template_footer.php"); ?>

    </div>

</body>
</html>
