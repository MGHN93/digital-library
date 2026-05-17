<?php
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../config/database.php";

$data = $db->query("SELECT br.*,b.title AS book_title
FROM borrowings br
JOIN books b ON br.book_id = b.id
WHERE br.status = 'dipinjam'
ORDER BY br.borrow_date ASC");
$borrow = $data->fetch_all(MYSQLI_ASSOC);
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
    <?php foreach ($borrow as $bor): ?>
      <tr>
        <th scope="row"><?= $bor['book_title'] ?></th>
        <td><?= $bor['borrower_name'] ?></td>
        <td><?= $bor['borrow_date'] ?></td>
        <td><?= $bor['status'] ?></td>
        <td>
          <form action="return.php" method="POST">
            <input type="hidden" name="borrow_id" value="<?= $bor['id'] ?>">
            <?php if ($bor['status'] == 'dipinjam'): ?>
              <button type="submit" class="btn btn-success">Kembalikan</button>

            <?php endif; ?>
          </form>

        </td>
      <?php endforeach; ?>
      </tr>

  </tbody>
</table>