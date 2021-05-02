<?php

require "../private/autoload.php";

$user_data = check_login($connection);

$stmt = $connection->prepare('SELECT * FROM grupes ORDER BY group_id');
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/index%20style.css">
    <title>Klientu grupavimas</title>
</head>
<body>
    <a href="newGroup.php">Sukurti grupe</a>
    <table>
        <thead>
        <tr>
            <td>Grupes id</td>
            <td>Grupes pavadinimas</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td><?=$group['group_id']?></td>
                <td><?=$group['group_name']?></td>
                <td>
                    <a href="insertingCustomersToGroups.php?id=<?=$group['group_id']?>">Edit</a>
                    <a href="deleteGroup.php?id=<?=$group['group_id']?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php">Grizti atgal</a>
</body>
</html>
