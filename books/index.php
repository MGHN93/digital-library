<?php
require __DIR__ . "/../includes/auth_check.php";
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";

$search = $_GET['search'] ?? '';

// Take all the books in database "perpustakaan"

$books = $db->query("SELECT * FROM books")->fetch_all(MYSQLI_ASSOC);
// var_dump($books);

// pagination settings
$limit = 8; // number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// get total data
$total_result = $db->query("SELECT COUNT(*) as total FROM books");
$total_row = $total_result->fetch_assoc();
$total_books = $total_row['total'];

$total_pages = ceil($total_books / $limit);

// get data with limit
$books = $db->query("SELECT * FROM books LIMIT $start, $limit")->fetch_all(MYSQLI_ASSOC);

if ($search) {
    $keyword = "%$search%";

    // count total searched books

    $count_stmt = $db->prepare("SELECT COUNT(*) as total FROM books WHERE title LIKE ? OR author LIKE ?");
    $count_stmt->bind_param("ss", $keyword, $keyword);
    $count_stmt->execute();

    $total_result = $count_stmt->get_result();
    $total_row = $total_result->fetch_assoc();
    $total_books = $total_row['total'];


    // get searched books with pagination

    $stmt = $db->prepare("SELECT * FROM books WHERE title LIKE ? or author LIKE ? LIMIT ?,?");
    $stmt->bind_param("ssii", $keyword, $keyword, $start, $limit);
    $stmt->execute();

    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    // count all books
    $total_result = $db->query("SELECT COUNT(*) as total FROM books");
    $total_row = $total_result->fetch_assoc();
    $total_books = $total_row['total'];

    // get all books with pagination
    $books = $db->query("
        SELECT * FROM books
        LIMIT $start, $limit
    ")->fetch_all(MYSQLI_ASSOC);
}

$total_pages = ceil($total_books / $limit);

require __DIR__ . "/../includes/footer.php"

?>

<div class="book-page">
    <section class="book-header">
        <h3>Daftar Buku</h3>
        <a href="./create.php"><button>+Tambah Produk</button></a>
    </section>
    <form method="get" class="d-flex mb-3 gap-2" role="search">
        <input class="form-control" type="text" name="search" placeholder="search for books..." value="<?= htmlspecialchars($search) ?>" />
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">No.</th>
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
            $nomor = $start + 1;
            foreach ($books as $b):
            ?>
                <tr>
                    <th scope="row"><?= $nomor; ?></th>
                    <td>
                        <?php if ($b['cover']): ?>
                            <img src="../uploads/covers/<?= htmlspecialchars($b['cover']) ?>"
                                alt="<?= htmlspecialchars($b['title']) ?>" style="width:60px; height:60px; objec-fit:cover;">

                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $b['title'] . '/' . $b['author']; ?></td>
                    <td><?= $b['category']; ?></td>
                    <!-- <td><?= $b['stock'];  ?></td> -->
                    <td><?php if ($b['stock'] > 0): ?>
                            <span class="badge bg-success"><?= $b['stock'] ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger"><?= $b['stock'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $b['id'] ?>" class="btn btn-edit btn-warning">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="delete.php?id=<?= $b['id'] ?>" class="btn btn-delete btn-danger" onclick="return confirm('are you sure you want to delete?')">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </td>
                </tr>
            <?php
                $nomor += 1;
            endforeach;
            ?>
        </tbody>
    </table>

    <div class="mt-3">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-secondary">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" class="btn <?= $i == $page ? 'btn-primary' : 'btn-light' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-secondary">Next</a>
        <?php endif; ?>
    </div>

    <?php
    require __DIR__ . "/../includes/footer.php";
    ?>

</div>