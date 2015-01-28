<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS carrello (
    cart_element int(4) NOT NULL auto_increment,
    prod_code int(4) NOT NULL,
    user_id int(32) NOT NULL,
    quantity int (8) NOT NULL,
    PRIMARY KEY (cart_element, user_id),
    FOREIGN KEY (prod_code) REFERENCES prodotto(prod_code),
    FOREIGN KEY(user_id) REFERENCES utente(id)
    )";

if (mysql_query($sqlCommand) or die (mysql_error())) 
{
    echo ("tabella CARRELLO creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella CARRELLO non creata"."<br>");
}

?>   

