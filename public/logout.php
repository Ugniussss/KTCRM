<?php

require "../private/autoload.php";

if(isset($_SESSION['url_address']))
{
    unset($_SESSION['url_address']);
}
if(isset($_SESSION['email']))
{
    unset($_SESSION['email']);
}

header("location: index.php");
die;