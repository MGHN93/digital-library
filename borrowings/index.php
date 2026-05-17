<?php 
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../config/database.php";

$data= $db->query("SELECT * FROM borrowings");
$borrow= $data->fetch_all(MYSQLI_ASSOC);
// var_dump($borrow);

?>
<a href="./create.php" class="btn btn-primary">+ Catat Pinjam</a>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Judul Buku</th>
      <th scope="col">Peminjam</th>
      <th scope="col">Tgl Pinjam</th>
      <th scope="col">Status</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($borrow as $bor): ?>
    <tr>
      <th scope="row"><?= $bor['book_id'] ?></th>
      <td><?= $bor['borrower_name'] ?></td>
      <td><?= $bor['borrow_date'] ?></td>
      <td><?= $bor['status'] ?></td>
      <td>--</td>
    <?php endforeach; ?>
    </tr>
    
  </tbody>
</table>