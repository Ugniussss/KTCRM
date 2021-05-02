<?php
require_once "../private/autoload.php";
$user_data = check_login($connection);

$msg = "";
if (isset($_GET['id'])) {
    $stmt = $connection->prepare('SELECT * FROM grupes_klientai WHERE  ');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        echo $_GET['id'];
        exit('Toks klientas nebeegzistuoja');
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $connection->prepare('DELETE FROM grupes_klientai WHERE grupes_klientai.storage_id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Jus istrynete pasirinkta klienta';
            header("location: index.php");
        } else {
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/index%20style.css">
    <title>Istrynimas</title>
</head>
<body>
<div>
    <h2>Istrinti klienta? <?=$contact['customer_name']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Jus tikrai norite istrinti?</p>
        <div>
            <a href="deleteCustomerFromGroup.php?id=<?=$contact['id']?>&confirm=yes">Taip</a>
            <a href="deleteCustomerFromGroup.php?id=<?=$contact['id']?>&confirm=no">Ne</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>