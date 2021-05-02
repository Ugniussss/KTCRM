<?php
error_reporting(0);
function get_random_string($length): string

{
    $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','j','k','l','m','n','o','p','r','s','t','u','v','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $text = "";
    $length = rand(4,$length);
    for ($i=0;$i<$length;$i++)
    {
        $random = rand(0,61);
        $text .= $array[$random];
    }
    return $text;
}
function esc($word): string
{
    return addslashes($word);
}
function check_login($connection)
{
    if(isset($_SESSION['url_address']))
    {
        $arr['url_address'] = $_SESSION['url_address'];
        $query = "select * from vartotojai where url_address = :url_address limit 1";
        $stmt = $connection->prepare($query);
        $check = $stmt->execute($arr);

        if($check)
        {
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($data) && count($data) > 0)
            {
                return $data[0];
            }
        }
    }
    header("location: login.php");
    die;
}
