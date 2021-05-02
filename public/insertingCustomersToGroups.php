<?php
require "../private/autoload.php";

$user_data = check_login($connection);

$stmt = $connection->prepare('SELECT * FROM klientai ORDER BY id');
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$group_id = $_GET['id'];

$statement = $connection->prepare("SELECT klientai.id, klientai.customer_name, klientai.customer_surname, klientai.customer_email, klientai.phone_number, klientai.address, klientai.country   FROM klientai INNER JOIN grupes_klientai ON  klientai.id=grupes_klientai.customer_id WHERE group_id = '$group_id' ORDER BY id");
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $group_id = false;
    $customer_id = $_POST["customer_id"];
    if(empty($customer_id))
    {
        echo "nepasirinkote kuri klienta ideti";
    }
    if(isset($_GET['id'])){
        $group_id = $_GET['id'];
    }
    $stmt = $connection->prepare("SELECT customer_id FROM grupes_klientai WHERE customer_id = :customer_id");
    $stmt->execute(['customer_id' => $customer_id]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($customer) && !empty($customer)){
        header("location: insertingCustomersToGroups.php?id=$group_id");
        exit();
    }

    if(!empty($customer_id) && !empty($group_id))
    {
        $query = "INSERT INTO grupes_klientai (group_id, customer_id) VALUES (:group_id, :customer_id)";
        if($stmt = $connection->prepare($query)){
            $stmt->bindParam(":group_id", $param_group_id);
            $stmt->bindParam(":customer_id", $param_customer_id);

            $param_group_id = $group_id;
            $param_customer_id = $customer_id;

            if($stmt->execute()){
                header("location: insertingCustomersToGroups.php?id=$group_id");
                exit();
            }
        }
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/index%20style.css">
    <title>Klientu suskirstymas</title>
</head>
<body>
<div class="grid-container">
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
                        <form action="" method="POST">
                            <input type="checkbox" name="customer_id" value="<?=$contact['id']?>">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <input type="submit" value="Prideti i grupe">
        </form>
    </div>
    <div class="item2">
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
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?=$customer['id']?></td>
                    <td><?=$customer['customer_name']?></td>
                    <td><?=$customer['customer_surname']?></td>
                    <td><?=$customer['customer_email']?></td>
                    <td><?=$customer['phone_number']?></td>
                    <td><?=$customer['address']?></td>
                    <td><?=$customer['country']?></td>
                    <td><a href="deleteCustomerFromGroup.php?id=<?=$storages['storage_id']?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<a href="customerGroup.php">Grizti atgal</a>
</body>
</html>
