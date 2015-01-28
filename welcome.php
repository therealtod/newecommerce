<?php
session_start();
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Welcome to our site! - NewEcommerce</title>
    <link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
    <div align="center" id="mainWrapper">
        <?php include ("./template_header.php"); ?>
        <div id="pageContent">
            <table width="100%" border="0 cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top">&nbsp;</td>
                    <td valign="top">
                        <p>
                            Grazie per esserti registrato!                        
                        </p>
                        Benvenuto in NewEcommerce
                        <p>
                            <a href="navigate_products.php">Naviga tra i nostri prodotti</a>
                        </p>
                    </td>
                    <td valign="top"></td>
                </tr>
            </table>

        </div>
        <?php include_once("template_footer.php"); ?>
    </div>
</body>
