<?php
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";

// Take all the books in database "perpustakaan"

$books = $db->query("SELECT * FROM books")->fetch_all(MYSQLI_ASSOC);
// var_dump($books);

?>




<h3>Daftar Buku</h3>
<a href="./create.php" class="btn btn-primary">Tambah Produk</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Cover</th>
            <th scope="col">Judul/Pengarang</th>
            <th scope="col">Kat.</th>
            <th scope="col">Stok</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- loop to enter all products from database to table below -->
        <?php
        foreach ($books as $b):
        ?>
            <tr>
                <th>Cover</th>
                <td><?= $b['title'].'/'.$b['author']; ?></td>
                <td><?= $b['category']; ?></td>
                <td><?= $b['stock'];  ?></td>
                <td>
                    <a href="edit.php?id=<?= $b['id']?>" class="btn btn-warning">EDIT</a>
                    <a href="delete.php?id=<?= $b['id']?>" class="btn btn-danger" onclick="return confirm('are you sure you want to delete?')">DELETE</a> 
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<?php
require __DIR__ . "/../includes/footer.php";
?>