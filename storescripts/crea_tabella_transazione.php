<?php

require_once 'connect_to_mysql.php';

$sqlCommand = "CREATE TABLE IF NOT EXISTS transazione (
    id int(32) NOT NULL auto_increment,
    user_id int(32) NOT NULL,
    data date NOT NULL,
    pay_code int(4) NOT NULL,
    cc_num varchar (24),
    ship_name varchar(20) NOT NULL,
    ship_price int (3) NOT NULL,
    ship_address int(4) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (ship_address) REFERENCES indirizzo (add_code)
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


