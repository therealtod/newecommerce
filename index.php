<?php
session_start();
include "./storescripts/connect_to_mysql.php";
?>
<?php
/* In questo blocco php c'è una procedura che permette di visualizzare l'intero
 * inventario sotto forma di lista
 */
/* per il momento inizializzo la variabile con una stringa vuota
 */
$product_list = "";
/* effettuo una query sulla tabella dei prodotti
 */
$query = mysql_query("SELECT * FROM prodotto ORDER BY date_added DESC LIMIT 18") or die("Err:" . mysql_error());
$productCount = mysql_num_rows($query); // conto il numero di oggetti trovati
if ($productCount > 0) { //se trovo almeno un oggetto nell'inventario
    /*
     * Costruisco la mia lista di prodotti (finchè ne trovo nell'inventario).
     * Creo delle variabili che conterranno i dati dei prodotti che vado 
     * leggendo nella lista, e le concateno nella variabile principale
     */
    $count_vet=0;
    while ($row = mysql_fetch_array($query)) {
        $id = $row["prod_code"];
        $product_name = $row["prod_name"];
        $price = $row["price"];
        $product_list .= '<td id="vetrina_td"><a href="display_product.php?p='.$id.'"> <strong>'.$product_name.'</strong> </a> - €'.$price .'</br></br><a href="display_product.php?p='.$id.'"><img src="inventory_images/'.$id.'.jpg" width="80px"></a></td>';
        $count_vet=$count_vet+1;
        if($count_vet>5){
               $product_list .= '</tr><tr>';
               $count_vet=0;
        }
    }
} else {
    $product_list = "Nessun prodotto nel nostro store per il momento";
}
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Home - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
    <div align="center" id="mainWrapper">
        <?php include_once("./template_header.php"); ?>
        <div id="pageContent">
            <table id="vetrina" width="800px"><tr><h3>Ecco i nuovi arrivi</h3>
                <p>Cerchi altri prodotti? <a href="navigate_products.php">Naviga nelle nostre categorie!</a></p><?php
                            echo $product_list;
                            ?></tr>
                <br>
                
        
        </div>
            

        </table>
        <br>
                <p>Cerchi altri prodotti? <a href="navigate_products.php">Naviga nelle nostre categorie!</a></p><br>
                <br>
                <br>
                
    </div><?php include_once("template_footer.php"); ?>
</body>
</html>