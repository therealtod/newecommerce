
<?php
session_start();
unset($_SESSION["userid"]);
$_SESSION["username"] = "guest"; 
?>

Sei stato disconnesso con successo.

<?php
header ("location: index.php");
?>