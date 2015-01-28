<div id="pageFooter"> 
    <?php
    if (isset($_SESSION["admin_id"]))
    {
        ?>Benvenuto <?php echo $_SESSION["admin_name"]; ?> (Non sei tu? Clicca: <a href="admin_logout.php"> Logout </a>)
    <?php
    }
    else
    { ?>
        <a href="../login.php"> Login </a> | <a href="../sign_up.php"> Registrazione </a> | <a href="../storeadmin">Amministrazione</a>
  <?php }?>              </div>
<p> &copy; 2015 Adriano Todaro e Giuseppe Palazzotto</p>
