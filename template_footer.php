<div id="pageFooter"> 
    <?php
    if (isset($_SESSION["userid"]))
    {
        $id= $_SESSION["userid"];
        $username = $_SESSION["username"]
                ?>Benvenuto <?php echo $username; ?> (Non sei tu? Clicca: <a href="logout.php"> Logout </a> ) -  <a href="./user_panel.php?">   Modifica i tuoi dati</a>
    <?php
    }
    else
    { ?>
                <a href="login.php"> Login </a> | <a href="sign_up.php"> Registrazione </a> | <a href="./storeadmin/admin_login.php">Amministrazione</a>

  <?php }?>   </div>
<p> &copy; 2015 Adriano Todaro e Giuseppe Palazzotto </p>
