<?php 
include('function.php');
$id = $_GET['id'];

deleteArticle($id);
header("location:admin-edit.php");  

?>