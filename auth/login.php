<?php
session_start();
require __DIR__ . "/../config/database.php";
// require __DIR__ . "/../includes/header.php";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username=?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login_at'] = date("d/m/Y H:i:s");

        header("Location:/books/index.php");
        exit();
    }

    $error = "username/password salah";
}

?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="/styles.css">

<body class="login-page">


    <div class="login-box">
        <img src="/uploads/images/infinibook_crop.png" alt="logo" class="logo">
        <h1 class="title">INFINIBOOK</h1>
        <p>Digital Library</p>

    </div>
    <div class="login-card">
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="'admin'">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="'admin123'">
            </div>

            <button type="submit" class="login-button">LOGIN</button>
        </form>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>

        <?php endif; ?>
    </div>

    <footer class="login-footer">
        <div>
            <p> Creator: M. Gilang Hendrian N. | May 2026</p>
        </div>
    </footer>

</body>