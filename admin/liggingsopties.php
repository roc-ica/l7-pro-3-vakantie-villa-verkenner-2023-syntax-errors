<?php
include '../includes/data.php';
Session::CheckSession();
?>
<!DOCTYPE html>
<html lang="nl">
<?php include '../includes/head.php'; ?>

<body class="villadmin">
    <?php include '../sections/admin_sidebar.php'; ?>
    <section class="content">
        <h1>Liggingseigenschappen</h1>
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php $eigenschappen = $liggingsopties->getLiggingsopties(); ?>
                <?php foreach ($eigenschappen as $options) : ?>
                    <tr>
                        <td><?= $options->name ?></td>
                        <td><a href="liggingsoptions_actions.php?id=<?= $options->id ?>">Bewerken</a></td>
                        <td><a href="liggingsoptions_actions.php?id=<?= $options->id ?>&delete">Verwijderen</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="liggingsoptions_actions.php" method="POST">
            <button type="submit">Toevoegen</button>
        </form>
    </section>
</body>

</html>