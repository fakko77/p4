<?php 
include('function.php');
$idcom = $_GET['idcom'];
$idArticle =  $_GET['id'];
signaler($idcom);
header("location:post.php?id=$idArticle");  

?>