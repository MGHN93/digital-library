<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>header</title>

  <link rel="stylesheet" href="/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <nav class="custom-navbar">

    <div class="navbar-left">
      <div class="navbar-logo">
        <img src="/uploads/images/infinibook_crop.png" alt="logo">
        <p>INFINIBOOK</p>
      </div>
    </div>

    <div class="navbar-right">
      <div>
        <a href="/books/index.php">Buku</a>
        <a href="/borrowings/index.php">Peminjaman</a>
        <a href="#">Admin</a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="/auth/logout.php" >
            <button>LOGOUT</button>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>


  <div>