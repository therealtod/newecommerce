<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS prodotto (
    prod_code int(8)  auto_increment NOT NULL,
    prod_name varchar(20) NOT NULL,
    instock int(4) NOT NULL,
    price int(8),
    cat_code int(8) NOT NULL,
    brand varchar (16) NOT NULL,
    description text,
    date_added date,
    PRIMARY KEY (prod_code),
    FOREIGN KEY(cat_code) REFERENCES categoria(cat_code)
    )";

if (mysql_query($sqlCommand)) 
{
    echo ("tabella PRODOTTO creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella PRODOTTO non creata"."<br>");
}

?>   

