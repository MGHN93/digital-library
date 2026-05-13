<?php 
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";

// the script below is to get input from form below, insert it in a variable.

if ($_SERVER['REQUEST_METHOD']=="POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $stock = $_POST['stock'];

// this script below, is to take the variable made above, and enter it into table books. the data should appear in books/index.php
// need to create script for making sure no empty inputs is taken, ' is allowed, etc

    $stmt = $db->prepare("INSERT INTO books(title, author, category, year, stock) VALUES(?,?,?,?,?)");
    $stmt->execute(
        [$title, $author, $category, $year, $stock]
    );
    header("Location:./index.php");
    exit();
}

?>



<h1>Tambah Produk Baru</h1>

<!-- buat form untuk input produk baru-->
<form action="#" method="post" enctype="multipart/form-data">
    <!-- isi dengan form bootstrap-->

    <div class="mb-3">
        <label class="form-label">Judul Buku*</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="mb-3">
        <label class="form-label">Pengarang*</label>
        <input type="text" class="form-control" name="author">
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select class="form-control" name="category">
            <option value="Novel">Novel</option>
            <option value="Horror">Horror</option>
            <option value="Biography">Biography</option>
            <option value="Others">Others</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Tahun Terbit</label>
        <input type="number" class="form-control" name="year">
    </div>

    <div class="mb-3">
        <label class="form-label">Stok*</label>
        <input type="number" class="form-control" name="stock">
    </div>

    <div class="mb-3">
        <label class="form-label">Gambar produk</label>
        <input type="file" class="form-control" name="image_path" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>


</form>
