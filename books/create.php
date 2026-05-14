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

    $errors= [];
    $cover_path="";

    if(isset($_FILES['cover'])){
        $allowed_type=['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/avif'];
        $max_size= 2 * 1024 * 1024; // Maximum 2MB
        $file_type=$_FILES['cover']['type'];
        $file_size=$_FILES['cover']['size'];

        // script below is to check whether the image uploaded type & size is listed in array above
        if(!in_array($file_type, $allowed_type)){
            $errors[] = "file format not supported";
        }else{
            // make a unique file name to avoid duplication
            $ext= pathinfo($_FILES['cover']['name'],PATHINFO_EXTENSION);
            $filename = 'books_' . uniqid() . '.' . strtolower($ext); // this creates a unique file name book_321654321.png (example)
            $dest = '../uploads/covers/' . $filename; // this store the file location to a variable
            if (move_uploaded_file($_FILES['cover']['tmp_name'],$dest)){
                $cover_path = $filename;
            } else {
                $errors[] = "failed to save file. Check permission folder uploads/covers/.";
            }
        }
    }

        // Cek field kosong
    if (empty(trim($_POST['title']))) {
        $errors[] = "title cannot be empty";
    }
    // Cek tipe data
    if (!is_numeric($_POST['year']) || $_POST['year'] < 0) {
        $errors[] = "year has to be a positive number";
    }
    if (!is_numeric($_POST['stock']) || $_POST['stock'] < 0) {
        $errors[] = "Stock has to be a positive number";
    }


// this script below, is to take the variable made above, and enter it into table books. the data should appear in books/index.php
// need to create script for making sure no empty inputs is taken, ' is allowed, etc
    if (empty($errors)) {
        $name = trim($_POST['name']);
        $price = (int) $_POST['year'];
        $stock = (int) $_POST['stock'];
    $stmt = $db->prepare("INSERT INTO books(title, author, category, year, stock, cover) VALUES(?,?,?,?,?,?)");
    $stmt->execute(
        [$title, $author, $category, $year, $stock, $cover_path]
    );

    $message = 'book successfully added';
    header("Location:./index.php?success=$message");
    exit();
    }
    foreach($errors as $error){
        echo '<div class="alert alert-danger">' . htmlspecialchars($error) .
            '</div>';
    }

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
        <input type="file" class="form-control" name="cover" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>


</form>
