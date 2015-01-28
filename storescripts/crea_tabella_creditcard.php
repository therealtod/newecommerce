<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS creditcard (
    userid int(4) NOT NULL,
    cardnum varchar(24) NOT NULL,
    PRIMARY KEY (cardnum),
    FOREIGN KEY (userid) REFERENCES utente (id)
    ) ";

if (mysql_query($sqlCommand)) 
{
    echo ("tabella CREDITCARD creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella CREDITCARD non creata"."<br>");
}

?>   