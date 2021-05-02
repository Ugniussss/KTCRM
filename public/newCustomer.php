<?php

require "../private/autoload.php";

$user_data = check_login($connection);

$customer_name = $customer_surname = $customer_email = "";
$phone_number = $address = $country = "";
$name_err = "";
$surname_err = "";
$email_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["customer_name"]);
    if(empty($input_name)){
        $name_err = "Iveskite varda.";
    }
    elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Iveskite taisyklinga varda";
    }
    else
    {
        $customer_name = $input_name;
    }
    $input_surname = trim($_POST["customer_surname"]);
    if(empty($input_surname))
    {
        $surname_err = "Iveskite pavarde.";
    }
    elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $surname_err = "Iveskite taisyklinga pavarde";
    }
    else
    {
        $customer_surname = $input_surname;
    }

    $input_email = trim($_POST["customer_email"]);
    if(empty($input_email)){
        $email_err = "Iveskite elektronini pasta";
    }
    elseif(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $input_email))
    {
        $email_err = "Iveskite taisyklinga elektronini pasta";
    }
    else
    {
        $customer_email = $input_email;
    }
    $stmt = $connection->prepare("SELECT customer_email FROM klientai WHERE customer_email = :customer_email");
    $stmt->execute(['customer_email' => $customer_email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($user) && !empty($user)){
        header("location: error.php");
        die();
    }
    $phone_number = trim($_POST["phone_number"]);
    $address = trim($_POST["address"]);
    $country = trim($_POST["country"]);
    if(empty($name_err) && empty($surname_err) && empty($email_err)){

        $query = "INSERT INTO klientai (customer_name, customer_surname, customer_email, phone_number, address, country) VALUES (:customer_name, :customer_surname, :customer_email, :phone_number, :address, :country)";
        if($stmt = $connection->prepare($query)){

            $stmt->bindParam(":customer_name", $param_name);
            $stmt->bindParam(":customer_surname", $param_surname);
            $stmt->bindParam(":customer_email", $param_email);
            $stmt->bindParam(":phone_number", $param_number);
            $stmt->bindParam(":address", $param_address);
            $stmt->bindParam(":country", $param_country);

            $param_name = $customer_name;
            $param_surname = $customer_surname;
            $param_email = $customer_email;
            $param_number = $phone_number;
            $param_address = $address;
            $param_country = $country;

            if($stmt->execute()){
                header("location: index.php");
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
    <title>Naujo kliento pridejimas</title>
</head>
<body>
<form action="newCustomer.php" method="post">
    <div>
    <label><b>Kliento vardas</b></label> <br>
    <input type="text" name="customer_name" placeholder="Iveskite kliento varda" value="<?php echo $customer_name;?>">
        <span><?php echo $name_err;?></span>
    </div>
    <div>
    <label><b>Kliento pavarde</b></label> <br>
    <input type="text" name="customer_surname" placeholder="Iveskite kliento pavarde" value="<?php echo $customer_surname;?>">
        <span><?php echo $surname_err;?></span>
    </div>
    <div>
    <label><b>Kliento elektroninis pastas</b></label><br>
    <input type="email" name="customer_email" placeholder="Iveskite kliento pasta" value="<?php echo $customer_email; ?>">
        <span><?php echo $email_err;?></span>
    </div>
    <div>
    <label>Kliento telefono numeri</label> <br>
    <input type="text" name="phone_number" placeholder="Iveskite kliento numeri">
    </div>
    <div>
    <label>Kliento adresas</label> <br>
    <input type="text" name="address" placeholder="Iveskite kliento adresa">
    </div>
    <div>
    <label>Kliento salis</label> <br>
    <input type="text" name="country" placeholder="Iveskite kliento sali"><br>
        <input type="submit" value="Sukurti">
        <a href="index.php">Grizti atgal</a>
    </div>
</form>
</body>
</html>