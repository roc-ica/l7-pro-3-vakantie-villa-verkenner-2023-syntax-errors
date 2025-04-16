<?php

include '../includes/data.php';
Session::CheckSession();

if (isset($_GET['delete'])) {
    $liggingsopties->deleteLiggingsoptie($_GET['id']);
    header('Location: /admin/liggingsopties.php');
    exit;
}

if (isset($_POST['add'])) {
    $liggingsopties->addLiggingsoptie($_POST['add']);
    header('Location: /admin/liggingsopties.php');
    exit;
}

if (isset($_POST['edit'])) {
    $liggingsopties->updateLiggingsoptie($_GET['id'], name: $_POST['edit']);
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
            <?php $options = $liggingsopties->getLiggingsoptie($_GET['id']); ?>
            <form action="liggingsopties_actions.php?id=<?= $options->id ?>" method="POST">
                <input type="text" name="edit" value="<?= $options->name ?>" required>
                <button type="submit">Bewerken</button>
            </form>
            <form action="liggingsopties_actions.php?id=<?= $options->id ?>&delete" method="POST">
                <button type="submit">Verwijderen</button>
            </form>
        </section>
    </body>

    </html>
<?php } else { ?>
    <!DOCTYPE html>
    <html lang="nl">
    <?php include '../includes/head.php'; ?>

    <body class="villadmin">
        <?php include '../sections/admin_sidebar.php'; ?>
        <section class="content">
            <form action="liggingsopties_actions.php" method="POST">
                <input type="text" name="add" placeholder="Naam" required>
                <button type="submit">Toevoegen</button>
            </form>
        </section>
    </body>

    </html>
<?php } ?>
