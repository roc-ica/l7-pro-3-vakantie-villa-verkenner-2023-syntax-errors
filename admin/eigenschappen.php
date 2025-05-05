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
        <h1>Eigenschappen</h1>
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Acties</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $eigenschappen = $options->getEigenschappen(); ?>
                <?php foreach ($eigenschappen as $eigenschap) : ?>
                    <tr>
                        <td><?= $eigenschap->name ?></td>
                        <td><a href="eigenschappen_actions.php?id=<?= $eigenschap->id ?>">Bewerken</a></td>
                        <td><a href="eigenschappen_actions.php?id=<?= $eigenschap->id ?>&delete">Verwijderen</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="eigenschappen_actions.php" method="POST">
            <button type="submit">Toevoegen</button>
        </form>
    </section>
</body>

</html>