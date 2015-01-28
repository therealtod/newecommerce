<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS transactioncart (
   trans_id int(32),
   item_n int(4) NOT NULL auto_increment,
   prod_name varchar(20) NOT NULL,
   price int(8) NOT NULL,
   quantity int(8) NOT NULL,
   brand varchar(16) NOT NULL,
   PRIMARY KEY (item_n, trans_id),
   FOREIGN KEY (trans_id) REFERENCES transazione (id)
    )";

if (mysql_query($sqlCommand)) 
{
    echo ("tabella TRANSACTIONCART creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella TRANSACTIONCART non creata"."<br>");
}
