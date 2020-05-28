<?php 

$host = "mysql:host=localhost;dbname=samplaces;port=8889";
$user = "root";
$senha = "root";


try{
    $db = new PDO($host, $user, $senha);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
} catch(PDOExeption $e){
    echo "Erro";
    echo $e->getMessage();
    exit;
}


?>