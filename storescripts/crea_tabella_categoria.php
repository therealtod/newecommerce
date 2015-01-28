<?php
require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS categoria (
    cat_code int(8)  auto_increment NOT NULL,
    name varchar(24) NOT NULL,
    PRIMARY KEY (cat_code),
    UNIQUE KEY nome (name)
    )";
if (mysql_query($sqlCommand)) 
{
    echo ("tabella CATEGORIA creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella CATEGORIA non creata"."<br>");
}

?>
