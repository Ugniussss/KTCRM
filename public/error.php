<?php
require "../private/autoload.php";
$user_data = check_login($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/index%20style.css">
    <title>Ivyko klaida</title>
</head>
<body>
<h1>Toks klientas tokiu pastu jau yra uzregistruotas!</h1>
<a href="newCustomer.php">Grizti atgal</a>
</body>
</html>
