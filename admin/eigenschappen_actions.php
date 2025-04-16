<?php

include '../includes/data.php';
Session::CheckSession();

if (isset($_GET['delete'])) {
    $options->deleteEigenschap($_GET['id']);
    header('Location: /admin/eigenschappen.php');
    exit;
}

if (isset($_POST['add'])) {
    $options->addEigenschap($_POST['add']);
    header('Location: /admin/eigenschappen.php');
    exit;
}

if (isset($_POST['edit'])) {
    $options->updateEigenschap($_GET['id'], $_POST['edit']);
    header('Location: /admin/eigenschappen.php');
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
            <?php $options = $options->getEigenschap($_GET['id']); ?>
            <form action="eigenschappen_actions.php?id=<?= $options->id ?>" method="POST">
                <input type="text" name="edit" value="<?= $options->name ?>" required>
                <button type="submit">Bewerken</button>
            </form>
            <form action="eigenschappen_actions.php?id=<?= $options->id ?>&delete" method="POST">
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
            <form action="eigenschappen_actions.php" method="POST">
                <input type="text" name="add" placeholder="Naam" required>
                <button type="submit">Toevoegen</button>
            </form>
        </section>
    </body>

    </html>
<?php } ?>
