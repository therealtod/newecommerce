<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS metodopag (
    met_code int(4) NOT NULL auto_increment,
    met_name varchar(32) NOT NULL,
    met_num  varchar(32),
    met_info text NOT NULL,
    PRIMARY KEY (met_code)
    )";

if (mysql_query($sqlCommand)or die (mysql_error())) 
{
    echo ("tabella METODOPAG creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella METODOPAG non creata"."<br>");
}

?>   
