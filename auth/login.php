<?php
session_start();
require __DIR__ . "/../config/database.php";
require __DIR__ . "/../includes/header.php";
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

    if ($user && password_verify($password, $user['password'])){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['login_at'] = date("d/m/Y H:i:s");
    
    header("Location:/books/index.php");
    exit();
}

$error = "user tidak ada";
}

?>
<h1>LOGIN</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <button type="submit" class="btn btn-primary">LOGIN</button>
</form>


