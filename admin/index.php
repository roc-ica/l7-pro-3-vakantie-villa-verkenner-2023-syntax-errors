<?php include '../includes/data.php'; ?>
<?php Session::CheckSession(); ?>
<!DOCTYPE html>
<html lang="nl">
<?php include '../includes/head.php'; ?>

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
        <?php if (isset($_GET['villa']) && isset($_GET['id'])) { ?>
            <?php $v = $villa->getVilla($_GET['id']); ?>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $v->id ?>">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?= $v->name ?>">
                <label for="desc">Description</label>
                <textarea name="desc"><?= $v->desc ?></textarea>
                <label for="price">Price</label>
                <input type="text" name="price" value="<?= $v->price ?>">
                <button type="submit">Save</button>
            </form>
            <div class="images">
                <?php foreach ($villa->getVillaImages($v->id) as $i) { ?>
                    <img src="/assets/img/villa/<?= $i->image ?>" alt="<?= $v->name ?>">
                <?php } ?>
            </div>
        <?php } else { ?>
            <header class="search">
                <input type="text" placeholder="Search">
                <button>Zoeken</button>
                <button>Toevoegen</button>
            </header>
            <div class="cards">
                <?php foreach ($villa->getVillas() as $v) { ?>
                    <a class="card" href="?villa&id=<?= $v->id ?>">
                        <div>
                            <h2><?= $v->name ?></h2>
                            <p>€ <?= $v->price ?></p>
                        </div>
                        <img src="/assets/img/villa/<?= $villa->getPrimaryImage($v->id); ?>" alt="<?= $v->name ?>">
                    </a>
                <?php } ?>
            </div>
        <?php } ?>


    </section>

</body>

</html>