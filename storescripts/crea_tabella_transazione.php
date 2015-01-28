<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS transazione (
    id int(32) NOT NULL auto_increment,
    user_id int(32) NOT NULL,
    data date NOT NULL,
    pay_name varchar(32) NOT NULL,
    ship_name varchar(20) NOT NULL,
    ship_price int (3) NOT NULL,
    PRIMARY KEY (id)
    )";

if (mysql_query($sqlCommand) or die (mysql_error())) 
{
    echo ("tabella TRANSAZIONE creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella TRANSAZIONE non creata"."<br>");
}

?>   


