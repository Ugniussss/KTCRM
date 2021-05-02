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
<h1>Tokia grupe tokiu pavadinimu jau yra sukurta!</h1>
<a href="newGroup.php">Grizti atgal</a>
</body>
</html>
