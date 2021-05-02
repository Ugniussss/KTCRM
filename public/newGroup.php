<?php

require "../private/autoload.php";

$user_data = check_login($connection);

$group_name = "";
$name_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST['group_name']);
    if(empty($input_name)){
        $name_err = "Iveskite grupes pavadinima.";
    }
    elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Iveskite taisyklinga grupes pavadinima";
    }
    else
    {
        $group_name = $input_name;
    }
    $stmt = $connection->prepare("SELECT group_name FROM grupes WHERE group_name = :group_name");
    $stmt->execute(['group_name' => $group_name]);
    $group = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($group) && !empty($group)){
        header("location: errorGroup.php");
        die();
    }
    if(empty($name_err))
    {
        $query = "INSERT INTO grupes (group_name) VALUES (:group_name)";
        if($stmt = $connection->prepare($query)){
            $stmt->bindParam(":group_name", $param_name);
            $param_name = $group_name;
            if($stmt->execute()){
                header("location: customerGroup.php");
                die();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Naujos grupes pridejimas</title>
</head>
<body>
<form action="newGroup.php" method="post">
    <div>
        <label><b>Grupe pavadinimas</b></label> <br>
        <input type="text" name="group_name" placeholder="Iveskite grupes pavadinima" value="<?php echo $group_name;?>">
        <span><?php echo $name_err;?></span>
    </div>
    <div>
        <input type="submit" value="Sukurti">
        <a href="customerGroup.php">Grizti atgal</a>
    </div>
</form>
</body>
</html>
