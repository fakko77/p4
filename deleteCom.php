<?php 
include('function.php');
$idcom = $_GET['idcom'];
$id =  $_GET['id'];

echo $id;
echo $idcom;

deleteCom($idcom);
header("location:admin-com.php?id=$id");  

?>