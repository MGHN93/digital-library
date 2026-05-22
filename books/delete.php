<?php
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";

$id_book = $_GET['id'];

// get book cover first

$stmt = $db->prepare("SELECT cover FROM books WHERE id=?");
$stmt->bind_param("i", $id_book);
$stmt->execute();

$result = $stmt->get_result();
$book = $result->fetch_assoc();

if ($book) {
    // delete image file
    if ($book['cover']) {
        $file = __DIR__ . "/../uploads/covers/" . $book['cover'];

        if (file_exists($file)) {
            unlink($file);
        }

        $del_stmt = $db->prepare("DELETE FROM books WHERE id=?");
        $del_stmt->bind_param("i", $id_book);
        $del_stmt->execute();
    }
}




$delete_msg = 'book has been deleted';
header("Location:./index.php?success=$delete_msg");
