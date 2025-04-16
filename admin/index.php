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
        <?php $villas = $villa->getVillas([]); ?>
        <h1>Villas</h1>
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Prijs</th>
                    <th>Locatie</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($villas as $villa) : ?>
                    <tr>
                        <td><?= $villa->name ?></td>
                        <td><?= $villa->price ?></td>
                        <td><?= $villa->postal . ' ' . $villa->number ?></td>
                        <td><a href="villa_actions.php?id=<?= $villa->id ?>">Bewerken</a></td>
                        <td><a href="villa_actions.php?id=<?= $villa->id ?>&delete">Verwijderen</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="villa_actions.php" method="POST">
            <button type="submit">Toevoegen</button>
        </form>
    </section>
</body>

</html>