<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS utente (
    id int(32) NOT NULL auto_increment,
    username varchar(24) NOT NULL,
    password varchar(32) NOT NULL,
    last_log_date date NOT NULL,
    last_cart_mod_date date NOT NULL,
    name varchar (24) NOT NULL,
    surname varchar (24) NOT NULL,
    cod_fisc varchar (20) NOT NULL,
    email varchar (20) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
    ) ";

if (mysql_query($sqlCommand)) 
{
    echo ("tabella UTENTE creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella UTENTE non creata"."<br>");
}

?>   