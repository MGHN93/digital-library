<?php
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../config/database.php";

// script below is to get id and title of books in table books that has stock greater than 0

$result = $db->query("SELECT id, title FROM books WHERE stock >0");
$data = $result->fetch_all(MYSQLI_ASSOC);

// Script below is to get user input from form below and insert into variable
if ($_SERVER['REQUEST_METHOD']=="POST"){
    $titles=$_POST['title'];
    $names=$_POST['name'];    
    $dates=$_POST['date'];

// script below is to insert variable froms script abvoe into table borrowings
$stmt= $db->prepare("INSERT INTO borrowings (book_id, borrower_name, borrow_date, status) VALUES (?,?,?,'dipinjam')");
$stmt->bind_param("iss",$titles,$names,$dates);
$stmt->execute();

// reduce stock for every borrowed book in table books
$stock_stmt=$db->prepare("UPDATE books SET stock = stock -1 WHERE id = ? AND stock > 0");
$stock_stmt->bind_param("i", $titles);
$stock_stmt->execute();

header("Location: index.php");
exit();

}

?>


<h1>Catat Peminjaman</h1>

<form method="POST">
    <div class="mb-3">
        <label for="title" class="from-label">Judul</label>
        <select class="form-select" name="title" id="book-select">
            <option value=""></option>
            <?php foreach ($data as $d): ?>
                <option value="<?=($d['id']) ?>">
                    <?= htmlspecialchars($d['title']) ?>
                </option>
            <?php endforeach ?>


        </select>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Nama Peminjam</label>
        <input type="text" title="name" name="name" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Tanggal Pinjam</label>
        <input type="date" title="date" name="date" class="form-control" id="exampleInputPassword1">
    </div>
    <button type="submit" class="btn btn-primary">Catat Pinjam</button>
    <button type="button" class="btn btn-danger" onclick="history.back()">Cancel</button>
</form>