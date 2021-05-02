<?php

    require "../private/autoload.php";

    $Error = "";
    $email = "";
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $email = $_POST['email'];
        $password = esc($_POST['password']);
        $passwordRepeat = esc($_POST['passwordRepeat']);
        $url_address = get_random_string(60);

        if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $email))
        {
            $Error = "Iveskite teisinga elektronini pasta: ";
        }
        $arr = false;
        $arr['email'] = $email;
        $query = "select * from vartotojai where email = :email limit 1";
        $stmt = $connection->prepare($query);
        $check = $stmt->execute($arr);
        if($check)
        {
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($data) && count($data) > 0)
            {
                $Error = "Toks pastas jau uzregistruotas, bandykite kita";
            }
        }
        if($Error == "") {
            $arr['email'] = $email;
            $arr['url_address'] = $url_address;
            if($password !== $passwordRepeat){
                $Error = "Jusu slaptazodziai nesutampa";
            }
            else{
                $arr['password'] = $password;
                $query = "insert into vartotojai (url_address,email,password) values (:url_address,:email,:password)";
                $stmt = $connection->prepare($query);
                $stmt->execute($arr);
            }

        }
        if($Error == "")
        {
            header("Location: login.php");
            die;
        }

    }





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/signup%20style.css">
    <title>Registracija</title>
</head>
<body>
    <form method="post">
        <div><?php
            if(isset($Error) && $Error != "")
            {
                echo $Error;
            }
            ?></div>
        <div class="signup">
        <div id="title">Naujojo vartotojo sukurimas:</div>
        <input type="email" name="email" value="<?=$email?>" placeholder="Iveskite elektronini pasta" required> <br>
        <input type="password" name="password" placeholder="Iveskite slaptazodi" required><br>
        <input type="password" name="passwordRepeat" placeholder="Pakartokite slaptazodi" required><br><br>
        <input type="submit" value="Registruotis">
            <a href="login.php" class="link">Jau esate uzsiregistrave?</a>
        </div>
    </form>
</body>
</html>