<?php
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../includes/header.php";
require __DIR__ . "/../config/database.php";

// ALL DATA //

$data = $db->query("SELECT br.*,b.title AS book_title
FROM borrowings br
JOIN books b ON br.book_id = b.id
-- WHERE br.status = 'dipinjam'
ORDER BY br.borrow_date ASC");
$all = $data->fetch_all(MYSQLI_ASSOC);
// var_dump($borrow);

// DIKEMBALIKAN DATA //

$data1 = $db->query("SELECT br.*,b.title AS book_title
FROM borrowings br
JOIN books b ON br.book_id = b.id
WHERE br.status = 'dikembalikan'
ORDER BY br.borrow_date ASC");
$return = $data1->fetch_all(MYSQLI_ASSOC);
// var_dump($return);

// DIPINJAM DATA //

$data2 = $db->query("SELECT br.*,b.title AS book_title
FROM borrowings br
JOIN books b ON br.book_id = b.id
WHERE br.status = 'dipinjam'
ORDER BY br.borrow_date ASC");
$borrow = $data2->fetch_all(MYSQLI_ASSOC);
// var_dump($borrow);


$status = $_GET['status'] ?? '';
$display = [];
if ($status == 'dipinjam') {
  $display = $borrow;
} elseif ($status == 'dikembalikan') {
  $display = $return;
} else {
  $display = $all;
}

$nomor = 0;
?>
<div class="book-page">
  <section class="book-header">
    <h3>Peminjaman</h3>
    <a href="./create.php"><button>+ Catat Pinjam</button></a>
  </section>

  <table class="table">
    <thead>
      <div class="table-tab active">
        <?php if ($status == 'all' || $status == ''): ?>
          <a href="/borrowings/index.php?status=all" class="active">Semua</a>
        <?php else: ?>
          <a href="/borrowings/index.php?status=all">Semua</a>
        <?php endif; ?>

        <?php if ($status == 'dipinjam'): ?>
          <a href="/borrowings/index.php?status=dipinjam" class="active">Dipinjam</a>
        <?php else: ?>
          <a href="/borrowings/index.php?status=dipinjam">Dipinjam</a>
        <?php endif; ?>

        <?php if ($status == 'dikembalikan'): ?>
          <a href="/borrowings/index.php?status=dikembalikan" class="active">Dikembalikan</a>
        <?php else: ?>
          <a href="/borrowings/index.php?status=dikembalikan">Dikembalikan</a>
        <?php endif; ?>
      </div>
      <tr>
        <th scope="col">No.</th>
        <th scope="col">Judul Buku</th>
        <th scope="col">Peminjam</th>
        <th scope="col">Tgl Pinjam</th>
        <th scope="col">Status</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $nomors = $nomor + 1;
      foreach ($display as $al):
      ?>
        <tr>
          <th scope="row"><?= $nomors ?></th>
          <td scope="row"><?= $al['book_title'] ?></td>
          <td><?= $al['borrower_name'] ?></td>
          <td><?= $al['borrow_date'] ?></td>
          <td><?= $al['status'] ?></td>
          <td>
            <form action="return.php" method="POST">
              <input type="hidden" name="borrow_id" value="<?= $al['id'] ?>">
              <?php if ($al['status'] == 'dipinjam'): ?>
                <button type="submit" class="btn btn-return btn-success">
                  <i class="bi bi-box-arrow-in-left"></i>
                </button>

              <?php endif; ?>
            </form>

          </td>
        <?php
        $nomors += 1;
      endforeach;
        ?>
        </tr>

    </tbody>
  </table>
</div>

<?php
require __DIR__ . "/../includes/footer.php";
?>