<?php
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";

$id_book = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare("SELECT * FROM books WHERE id=?");
$stmt->bind_param("i", $id_book);
$stmt->execute();

$result = $stmt->get_result();
$book = $result->fetch_assoc();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $year = $_POST['year'];
    $stock = $_POST['stock'];

    
    $cover_path = $book['cover'];

    // Cek field kosong
    if (trim($_POST['title'])==='') {
        $errors['title'] = "title cannot be empty";
    }
    if (trim($_POST['author'])==='') {
        $errors['author'] = "author cannot be empty";
    }
    if (trim($_POST['stock'])==='') {
        $errors['stock'] = "stock cannot be empty";
    }
    // Cek tipe data
    if (!is_numeric($_POST['year']) || $_POST['year'] < 0) {
        $errors['year'] = "year has to be a positive number";
    }
    if (!is_numeric($_POST['stock']) || $_POST['stock'] < 0) {
        $errors[] = "Stock has to be a positive number";
    }


    if (isset($_FILES['cover'])) {
        $allowed_type = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/avif'];
        $max_size = 2 * 1024 * 1024; // Maximum 2MB
        $file_type = $_FILES['cover']['type'];
        $file_size = $_FILES['cover']['size'];

        // script below is to check whether the image uploaded type & size is listed in array above
        if (!in_array($file_type, $allowed_type)) {
            $errors[] = "file format not supported";
        } else {
            // make a unique file name to avoid duplication
            $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
            $filename = 'books_' . uniqid() . '.' . strtolower($ext); // this creates a unique file name book_321654321.png (example)
            $dest = '../uploads/covers/' . $filename; // this store the file location to a variable
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $dest)) {
                $cover_path = $filename;
            } else {
                $errors[] = "failed to save file. Check permission folder uploads/covers/.";
            }
        }
        // only update if no errors
        if (empty($errors)){
        $stmt = $db->prepare("UPDATE books SET title=?, author=?, category=?, year=?, stock=?, cover=? WHERE id=?");
        $stmt->bind_param(
            "sssissi",
            $title,
            $author,
            $category,
            $year,
            $stock,
            $cover_path,
            $id_book
        );

        $stmt->execute();


        $editmsg = 'Buku berhasil di edit';
        header("Location:./index.php?success=$editmsg");
        exit();
        }
    }
}
?>

<h1>Edit Produk</h1>

<!-- buat form untuk input produk baru-->
<form action="#" method="post" enctype="multipart/form-data">
    <!-- isi dengan form bootstrap-->
    
    <div class="mb-3">
        <label class="form-label">Judul Buku*</label>
        <input type="text" class="form-control" name="title" value=" <?= $book['title'] ?>">
    <?php if (isset($errors['title'])): ?>    
        <div class="alert alert-danger"><?= $errors['title'] ?></div>
    <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Pengarang*</label>
        <input type="text" class="form-control" name="author" value=" <?= $book['author'] ?>">
        <?php if (isset($errors['author'])): ?>    
        <div class="alert alert-danger"><?= $errors['author'] ?></div>
    <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select class="form-control" name="category" value=" <?= $book['category'] ?>">
            <option value="Novel">Novel</option>
            <option value="Horror">Horror</option>
            <option value="Biography">Biography</option>
            <option value="Others">Others</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Tahun Terbit</label>
        <input type="number" class="form-control" name="year" value=<?= $book['year'] ?>>
        <?php if (isset($errors['year'])): ?>    
        <div class="alert alert-danger"><?= $errors['year'] ?></div>
    <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Stok*</label>
        <input type="number" class="form-control" name="stock" value="<?= $book['stock'] ?>">
        <?php if (isset($errors['stock'])): ?>    
        <div class="alert alert-danger"><?= $errors['stock'] ?></div>
    <?php endif; ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Cover (opsional)</label>
        <input type="file" class="form-control" name="cover" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="button" class="btn btn-danger" onclick="history.back()">Cancel</button>


</form>