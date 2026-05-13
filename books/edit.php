<?php 
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";

$id_book = (int)($_GET['id']??0);
$stmt = $db->prepare("SELECT * FROM books WHERE id=?");
$stmt->bind_param("i",$id_book);
$stmt->execute();

$result = $stmt->get_result();
$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD']=="POST"){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $stock = $_POST['stock'];

    $stmt = $db->prepare("UPDATE books SET title=?, author=?, category=?, year=?, stock=? WHERE id=?");
    $stmt -> bind_param(
        "sssiii",
        $title,
        $author,
        $category,
        $year,
        $stock,
        $id_book
    );

    $stmt->execute();

    $editmsg = 'Buku berhasil di edit';
    header("Location:./index.php?success=$editmsg");
    exit();
}


?>

<h1>Edit Produk</h1>

<!-- buat form untuk input produk baru-->
<form action="#" method="post" enctype="multipart/form-data">
    <!-- isi dengan form bootstrap-->

    <div class="mb-3">
        <label class="form-label">Judul Buku*</label>
        <input type="text" class="form-control" name="title" value=" <?=$book['title']?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Pengarang*</label>
        <input type="text" class="form-control" name="author" value=" <?=$book['author']?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select class="form-control" name="category" value=" <?=$book['category']?>">
            <option value="Novel">Novel</option>
            <option value="Horror">Horror</option>
            <option value="Biography">Biography</option>
            <option value="Others">Others</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Tahun Terbit</label>
        <input type="number" class="form-control" name="year" value=<?=$book['year']?>>
    </div>

    <div class="mb-3">
        <label class="form-label">Stok*</label>
        <input type="number" class="form-control" name="stock" value=" <?=$book['stock']?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Gambar produk</label>
        <input type="file" class="form-control" name="image_path" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>


</form>