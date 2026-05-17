<?php 
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";

$borrow_id = $_POST['borrow_id'];
var_dump($borrow_id);

// ambil book_id dari tabel borrowings
$get_stmt = $db->prepare(" SELECT book_id 
    FROM borrowings 
    WHERE id = ?
");
$get_stmt->bind_param('i', $borrow_id);
$get_stmt->execute();

$result = $get_stmt->get_result();
$data = $result->fetch_assoc();

$book_id = $data['book_id'];


$borrow_stmt=$db->prepare("UPDATE borrowings
SET STATUS = 'dikembalikan', return_date = CURDATE() 
WHERE id=?");

$borrow_stmt->bind_param('i',$borrow_id);
$borrow_stmt->execute();

$update_stmt=$db->prepare("UPDATE books SET 
stock = stock + 1 WHERE id = ?");

$update_stmt->bind_param('i', $book_id);
$update_stmt->execute();

$message = "Buku berhasil dikembalikan";

header("Location: index.php");

exit();
?>