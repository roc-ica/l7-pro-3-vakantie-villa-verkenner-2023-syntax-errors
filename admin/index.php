<?php include '../includes/data.php'; ?>
<?php Session::CheckSession(); ?>
<!DOCTYPE html>
<html lang="nl">
<?php include '../includes/head.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['villa']) && isset($_POST['id'])) {
        
    } else if (isset($_GET['eigenschappen'])) {
        $options->addEigenschap($_POST['name']);
    } else if (isset($_GET['liggingsopties'])) {
        $liggingsopties->addLiggingsoptie($_POST['name']);
    }
}

?>

<body class="villadmin">
    <section class="sidebar">
        <h1>Vill<span>a</span>dmin</h1>
        <nav>
            <ul>
                <li><a href="/admin">Villa's</a></li>
                <li><a href="?eigenschappen">Eigenschappen</a></li>
                <li><a href="?liggingsopties">Liggingsopties</a></li>
                <li><a href="?reserveringen">Reserveringen</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </section>
    <section class="content">
        <?php if (isset($_GET['eigenschappen'])) { ?>
            <h1>Eigenschappen</h1>
            <?php var_dump($options->getEigenschappen()); ?>
            <form method="POST" action="?eigenschappen">
                <input type="text" name="name" placeholder="Naam van de eigenschap">
                <button type="submit">Toevoegen</button>
            </form>
        <?php } else if (isset($_GET['liggingsopties'])) { ?>
            <h1>Liggingsopties</h1>
            <?php var_dump($liggingsopties->getLiggingsopties()); ?>
            <form method="POST" action="?liggingsopties">
                <input type="text" name="name" placeholder="Naam van de liggingsoptie">
                <button type="submit">Toevoegen</button>
            </form>
        <?php } else if (isset($_GET['reserveringen'])) { ?>
            <h1>Reserveringen</h1>
            <?php var_dump($contact->getContacts()); ?>
        <?php } else if (isset($_GET['villa']) && isset($_GET['id'])) { ?>
            <?php $v = $villa->getVilla($_GET['id']); ?>
        <?php } else { ?>
            <header class="search">
                <input type="text" placeholder="Search">
                <button>Zoeken</button>
                <button>Toevoegen</button>
            </header>
            <div class="cards">
                <?php foreach ($villa->getVillas() as $v) { ?>
                    <a class="card" href="?villa&id=<?= htmlspecialchars($v['id']) ?>">
                        <div>
                            <h2><?= htmlspecialchars($v['name']) ?></h2>
                            <p>€ <?= htmlspecialchars(number_format($v['price'], 2, ',', '.')) ?></p>
                        </div>
                        <img src="/assets/img/villa/<?= htmlspecialchars($villa->getPrimaryImage($v['id'])); ?>" alt="<?= htmlspecialchars($v['name']) ?>">
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </section>
</body>
</html>