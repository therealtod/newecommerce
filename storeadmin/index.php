<?php
session_start();
include "user_verify_script.php"
?>
<?php 
$cleared="";
if(isset($_GET['n'])){
    $n=$_GET['n'];
    $cleared="Questa funzione cancella le righe della tabella carrello più vecchie di 1 settimana. <br> Sono state cancellate $n righe dalla tabella carrello.";
    
}
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Pannello Amministratori - NewEcommerce</title>
    <link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
    <div align="center" id="mainWrapper">
        <?php include_once("template_header.php"); ?>
        <div id="pageContent">
            <p><h2>Benvenuto nel pannello di amministrazione dello store. </h2></p>
            <table id="admin_menu" width="800px">
                <tr id="admin_menu">
                    <td id="admin_td"> <a href="./inventory_list.php"> <img src="../style/elencoprodotti.png" height="100px"> <br> Modifica Inventario </a></td> 
                    <td id="admin_td"><a href="./category_list.php"><img src="../style/category.png" height="100px"> <br> Modifica Categorie</a> </td> 
                    <td id="admin_td"> <a href="admin_list.php"><img src="../style/admin.png" height="100px"> <br>Modifica Amministratori</a></td> 
                    <td id="admin_td"><a href="./transactions_list.php"><img src="../style/fatture.png" height="100px"> <br>Fatture</td>
                </tr> 
                <tr><td id="admin_td"><a href="shipping_list.php"><img src="../style/shipping_method.png" height="100px"> <br>Metodi di Spedizione</a></td>
                    <td id="admin_td"><a href="./payment_list.php"><img src="../style/payment.png" height="100px"> <br>Metodi di Pagamento</td>
                            <td id="admin_td"><a href="../storescripts/empty_old_carts.php"><img src="../style/cleancart.png" height="100px"> <br>Pulisci tabella carrello</td>
</tr></table>
        <?php echo $cleared; ?>
        </div>
         <?php include_once("template_footer.php"); ?>

        </div>
        
    </body>
</html>
