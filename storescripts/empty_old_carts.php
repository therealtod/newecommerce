<?php
require ('./connect_to_mysql.php');
?>
<?php
$query = mysql_query("SELECT id, last_cart_mod_date FROM utente");
while ($row = mysql_fetch_array($query))
{
    $userid = $row["id"];
    $cart_date =  strtotime($row["last_cart_mod_date"]);
    if ($cart_date < strtotime (strtotime ('1 week ago', strtotime('now'))))
      {
          $query = mysql_query ("DELETE FROM carrello WHERE user_id= $userid");
      }
}
header ('location: ./index.php');
?>

