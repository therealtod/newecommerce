<?php
require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS  indirizzo (
    add_code int(4)  auto_increment NOT NULL,
    user_id int(8) NOT NULL,
    via varchar(20) NOT NULL,
    civico int(6),
    appart varchar(10),
    citta varchar(20) NOT NULL,
    CAP int(5),
    provincia varchar(4),
    regione varchar (10),
    paese varchar (15),
    PRIMARY KEY (add_code,user_id),
    FOREIGN KEY (user_id) REFERENCES utente (id)
    )";
if (mysql_query($sqlCommand))
{
    echo ("tabella INDIRIZZO creata correttamente"."<br>");
}
else
{
    echo ("ERRORE FATALE, tabella INDIRIZZO non creata"."<br>");
}

?>
