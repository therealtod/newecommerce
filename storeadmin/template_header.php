


<div id="pageHeader"><table width="100%" border="0" cellspacing="0" cellpadding="12">
        <tr>
            <td width="32%"><a href="../index.php">  <td width="68%" align="right"> 
                <?php
                if (isset($_SESSION["userid"])) {
                    ?><a href="../cart.php"><?php
                } else {
                    ?> <a href="../login.php?c=1"> <?php }
                ?>
                        <img src="../style/cart.png" alt="cart" width="50" height="50" border="0" /><br>  Il tuo carrello</a>
            </td>

        </tr>
        <tr>
            <td id="menu" colspan="2"><a href="../index.php" target="_blank">Visualizza sito</a> &nbsp; &middot; &nbsp; <a href="index.php">Pannello di Amministrazione</a> &nbsp; &middot; &nbsp; </td>
        </tr>
    </table>
</div>




