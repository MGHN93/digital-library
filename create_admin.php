<!-- visit url once to create admin, then don't run it again -->

<?php 
require __DIR__ . "/config/database.php";

$username = "admin";
$password = "admin123";

$hashed = password_hash($password, PASSWORD_BCRYPT);

$query = "INSERT INTO users(username, password) VALUES(?,?)";
$stmt = $db->prepare($query);
$stmt -> bind_param("ss",$username, $hashed);

if ($stmt->execute()){
    echo "Admin Successfully Created";
} else{
    echo "Failed:". $db->error;
}

?>

