<?php

require_once "../private/autoload.php";

$Error = "";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] == $_POST['token'])
{
    $email = $_POST['email'];
    $password = ($_POST['password']);
    if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $email))
    {
        $Error = "Iveskite teisinga elektronini pasta: ";
    }
    if($Error == "") {

        $arr['email'] = $email;
        $arr['password'] = $password;
        $query = "select * from vartotojai where email = :email && password = :password limit 1 ";
        $stmt = $connection->prepare($query);
        $check = $stmt->execute($arr);

        if($check)
        {
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($data) && count($data) > 0)
            {
                    $data = $data[0];
                    $_SESSION['email'] = $data->email;
                    $_SESSION['url_address'] = $data->url_address;
                    header("Location: index.php");
                    die;
            }
        }
    }

    $Error = "Vartotojo pastas arba slaptazodis ivestas neteisingai";

}
    $_SESSION['token'] = get_random_string(60);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/login%20style.css">
    <title>Prisijungimas</title>
</head>
<body>
<form method="post">
    <div><?php
        if(isset($Error) && $Error != "")
        {
            echo $Error;
        }
        ?></div>
    <div class="login">
    <div id="title">Prisijungimas</div>
    <input type="email" name="email" placeholder="Iveskite elektronini pasta" required> <br>
    <input type="password" name="password" placeholder="Iveskite slaptazodi" required><br><br>
    <input type="hidden" name="token" value="<?=$_SESSION['token']?>"required>
    <input type="submit" value="Prisijungti">
        <a href="signup.php" class="link">Nesate uzsiregistrave?</a>
    </div>
</form>
</body>
</html>