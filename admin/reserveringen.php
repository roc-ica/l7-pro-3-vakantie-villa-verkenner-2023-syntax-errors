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
        <h1>Reserveringen</h1>
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Villa</th>
                    <th>Vraag</th>
                </tr>
            </thead>
            <tbody>
                <?php $reserveringen = $contact->getContacts(); ?>
                <?php foreach ($reserveringen as $reservering) : ?>
                    <tr>
                        <td><?= $reservering->naam ?></td>
                        <td><?= $reservering->email ?></td>
                        <td><?= $reservering->villa ?></td>
                        <td><?= $reservering->vraag ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

</html>