<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS amministratore (
    id int(4) NOT NULL auto_increment,
    username varchar(24) NOT NULL,
    password varchar(32) NOT NULL,
    last_log_date date NOT NULL,
    email varchar (24) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
    ) ";

if (mysql_query($sqlCommand)) 
{
    echo ("tabella AMMINISTRATORE creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella AMMINISTRATORE non creata"."<br>");
}

?>   