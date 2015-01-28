<?php session_start() ?>
<?php
require ('./storescripts/connect_to_mysql.php');
?>
<?php
$query = mysql_query("SELECT name, cat_code FROM categoria") or die (mysql_error());
?>



<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Prodotti  - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
    <div align="center" id="mainWrapper">

        <?php include_once("./template_header.php"); ?>
        <div id="pageContent">
            <h3>Apri una categoria o scegli un prodotto:</h3>
            <table id="navigateproducts">
                <tr> <?php
                    $countrow = 0;
                    while ($row = mysql_fetch_array($query)) {
                        $countrow = $countrow + 1;
                        if ($countrow < 12) {
                            ?> 
                    <td id="navigateproducts_td"> <a href="navigate_products.php?p=<?php echo $row["cat_code"]; ?>"><?php echo $row["name"]; ?> <br><img src="style/category.png" height="30px"></a> 
                            </td>
                            <?php
                        } else {
                            $countrow = 0;
                            echo "</tr><tr>";
                        }
                        ?>  
                        <?php
                    }
                    ?>
            
                </tr></table>
            <br>
                        <table id="navigateproducts" weight="80%">

            <tr>
                    <?php
                    if (isset($_GET["p"])) {
                     /*   $query2 = mysql_query("SELECT * FROM categoria WHERE cat_code = 2 LIMIT 1") or die (mysql_error());
                        $row2 = mysql_fetch_array($query2);
                        echo '<h3>'.$row2["name"].'</h3>';*/
                        $query = mysql_query("SELECT * FROM prodotto WHERE cat_code = " . $_GET["p"]) or die (mysql_error());
                        $num_prod = mysql_num_rows($query);
                        $count_prod = 0;
                                                  if($num_prod>0){
                        while ($row = mysql_fetch_array($query)) {
                            $count_prod = $count_prod + 1;
                            if ($count_prod < 9) {
                                ?>

                                <td id="navigateproducts_td">  <a href="display_product.php?p=<?php echo $row["prod_code"]; ?>"><?php echo $row["prod_name"]; ?> <?php echo "</a> - €" . $row["price"]; ?><br> <a href="display_product.php?p=<?php echo $row["prod_code"]; ?>"> <img src="inventory_images/<?php echo $row["prod_code"]; ?>.jpg" height="80px">  </a>
                                </td>

                                <?php
                            } else {
                                $count_prod = 0;
                                ?> <td id="navigateproducts_td"> <a href="display_product.php?p=<?php echo $row["prod_code"]; ?>"><?php echo $row["prod_name"]; ?> <?php echo "</a> - €" . $row["price"]; ?><br> <a href="display_product.php?p=<?php echo $row["prod_code"]; ?>"> <img src="inventory_images/<?php echo $row["prod_code"]; ?>.jpg" height="80px">  </a>
                                </td><?php
                                echo "</tr><tr>";
                            }
                            ?>  

                            <?php
                        }
                    }
                    else {
                        echo "Non vi sono prodotti in questa categoria";
                    }
                            }
                            
                    
                    ?>
                </tr>

            </table>
        </div>
        <?php include_once("template_footer.php"); ?>
    </div>
</body>


