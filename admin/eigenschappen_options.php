<?php

include '../includes/data.php';
Session::CheckSession();

if (!isset($_GET['id'])) {
    header('Location: /admin/');
    exit;
}

if (isset($_GET['delete'])) {
    $options->deleteEigenschap($_GET['id']);
    header('Location: /admin/liggingsopties.php');
    exit;
}

?>

<?php if (isset($_GET['id'])) { ?>
    <!DOCTYPE html>
    <html lang="nl">
    <?php include '../includes/head.php'; ?>

    <body class="villadmin">
        <?php include '../sections/admin_sidebar.php'; ?>
        <section class="content">
            <!-- edit eigenschappen -->

        </section>
    </body>

    </html>
<?php } ?>
