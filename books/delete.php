<?php 
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";

$id_book = $_GET['id'];

$db->query("DELETE FROM books WHERE id=$id_book");

$delete_msg= 'produk berhasil di delete';
header("Location:./index.php?success=$delete_msg");

?>