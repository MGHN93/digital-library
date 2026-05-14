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

    $stmt = $db->prepare("UPDATE books SET title=?, author=?, category=?, year=?, stock=?, cover=? WHERE id=?");
    $stmt -> bind_param(
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
        <input type="number" class="form-control" name="stock" value="<?=$book['stock']?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Gambar produk</label>
        <input type="file" class="form-control" name="cover" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>


</form>