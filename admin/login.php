<?php include '../includes/data.php'; ?>
<?php Session::CheckLogin(); ?>
<!DOCTYPE html>
<html lang="nl">
<?php include '../includes/head.php'; ?>
<body>

    <?php if (isset($_POST['email']) && isset($_POST['password'])) {
        $admin->login($_POST);
    } ?>

    <h1>Login</h1>
    <form action="" method="post">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
    
</body>
</html>