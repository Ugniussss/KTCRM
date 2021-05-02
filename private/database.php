<?php

define('DB_NAME', 'kt_crm');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');


$string = "mysql:host=localhost;dbname=kt_crm";
$connection = new PDO($string,DB_USER,DB_PASS);
if(!$connection = new PDO($string,DB_USER,DB_PASS))
{
    die("Nepavyko prisijungti");
}
