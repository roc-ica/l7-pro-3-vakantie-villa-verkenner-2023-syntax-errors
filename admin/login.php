<?php
include '../includes/data.php';
Session::CheckLogin();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $admin->login($_POST);
    header('Location: /admin');
    exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<?php include '../includes/head.php'; ?>

<body class="login">
    <form action="" method="post">
        <h1>Login</h1>
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
</body>

</html>