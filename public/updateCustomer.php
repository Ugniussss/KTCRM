<?php

require_once "../private/autoload.php";
$user_data = check_login($connection);

if (isset($_GET['id'])) {
    if (!empty($_POST)) {

        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
        $customer_surname = isset($_POST['customer_surname']) ? $_POST['customer_surname'] : '';
        $customer_email = isset($_POST['customer_email']) ? $_POST['customer_email'] : '';
        $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $country = isset($_POST['country']) ? $_POST['country'] : '';

        $stmt = $connection->prepare('UPDATE klientai SET id = ?, customer_name = ?, customer_surname = ?, customer_email = ?, phone_number = ?, address = ?, country = ? WHERE id = ?');
        $stmt->execute([$id, $customer_name, $customer_surname, $customer_email, $phone_number, $address, $country, $_GET['id']]);
    }
    $stmt = $connection->prepare('SELECT * FROM klientai WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Toks klientas su tokiu id neegzistuoja');
    }
}
else {
    exit('Klaida');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/index%20style.css">
    <title>Kliento duomenu atnaujinimas</title>
</head>
<body>
<h2>Atnaujinti duomenis #<?=$contact['id']?></h2>
<form action="updateCustomer.php?id=<?=$contact['id']?>" method="post">
    <label for="id">ID</label>
    <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id"> <br>
    <label for="customer_name">Vardas</label>
    <input type="text" name="customer_name" value="<?=$contact['customer_name']?>" id="customer_name"> <br>
    <label for="customer_surname">Pavarde</label>
    <input type="text" name="customer_surname" value="<?=$contact['customer_surname']?>" id="customer_surname"><br>
    <label for="customer_email">Elektroninis pastas</label>
    <input type="text" name="customer_email"  value="<?=$contact['customer_email']?>" id="customer_email"> <br>
    <label for="phone_number">Telefono numeris</label>
    <input type="text" name="phone_number" value="<?=$contact['phone_number']?>" id="phone_number"> <br>
    <label for="address">Adresas</label>
    <input type="text" name="address" value="<?=$contact['address']?>" id="address"> <br>
    <label for="country">Gyvenamoji salis</label>
    <input type="text" name="country"  value="<?=$contact['country']?>" id="country"><br>
    <input type="submit" value="Atnaujinti">
</form>
</body>
</html>

