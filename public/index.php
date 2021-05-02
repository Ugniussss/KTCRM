<?php

    require "../private/autoload.php";
    $user_data = check_login($connection);

$stmt = $connection->prepare('SELECT * FROM klientai ORDER BY id');
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/index%20style.css">
    <title>Pagrindinis langas</title>
</head>
<body>
<div class="grid-container">
    <div class="item1"> Prisijunges vartotojas siuo metu: <?= $_SESSION['email']?>
    <a id="userlog" href="logout.php">Atsijungti</a>
    </div>
    <div class="item2">
    <a href="customerGroup.php">Klientu grupes</a><br>
    <a href="eventReminder.php">Ivykiu priminimas</a><br>
    <a href="autoEmail.php"> Laisku persiuntimo funkcija</a><br>
    </div>
    <div class="item3">
        <table>
            <thead>
            <tr>
                <td>#</td>
                <td>Vardas</td>
                <td>Pavarde</td>
                <td>Elektroninis pastas</td>
                <td>Telefono numeris</td>
                <td>Adresas</td>
                <td>Gyvenamoji salis</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?=$contact['id']?></td>
                    <td><?=$contact['customer_name']?></td>
                    <td><?=$contact['customer_surname']?></td>
                    <td><?=$contact['customer_email']?></td>
                    <td><?=$contact['phone_number']?></td>
                    <td><?=$contact['address']?></td>
                    <td><?=$contact['country']?></td>
                    <td>
                        <a href="updateCustomer.php?id=<?=$contact['id']?>"><img id="edit" src="../images/edit.png" alt="edit"></a>
                        <a href="deleteCustomer.php?id=<?=$contact['id']?>"><img id="delete" src="../images/delete.png" alt="delete"></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="newCustomer.php"><img id="addCust" src="../images/addCustomer.png" alt="addCust"></a>
    </div>
</div>
</body>
</html>
