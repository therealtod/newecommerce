<?php
session_start();
include "./storescripts/connect_to_mysql.php";
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Thanks - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
    <div align="center" id="mainWrapper">
        <?php include_once("./template_header.php"); ?>
        <div id="pageContent">
             <br>
            <br>
            <p> Grazie per aver effettuato l'acquisto presso il nostro store.
                Potrai tenere traccia della lista dei tuoi acquisti dal tuo <a href="user_panel.php"> pannello utente</a></p>
            <br>
            <br>
            
                
        </div><?php include_once("template_footer.php"); ?></div>
</body>
</html>