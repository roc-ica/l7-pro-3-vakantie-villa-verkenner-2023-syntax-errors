<?php include 'includes/data.php'; ?>
<!DOCTYPE html>
<html lang="nl">
<?php include 'includes/head.php'; ?>

<body class="villa">
    <?php include 'sections/header.php'; ?>
    <?php if (!isset($_GET['id'])) { ?>

    <?php } else { ?>
        <?php $villa = $villa->getVilla($_GET['id']); ?>
        <section class="banner">
            <h1><?= $villa->name; ?></h1>
        </section>

        <main id="villa">
            <h2><?= $villa->name; ?></h2>
            <img src="/assets/img/villa/<?= $villa->image; ?>" alt="<?= $villa->name; ?>">
            <p><?= $villa->desc; ?></p>
            <p>Price: &euro;<?= $villa->price; ?> per night</p>
            <a href="contact.php">Book now</a>
            <button onclick="printPdf('/pdf.php?id=<?= $_GET['id'] ?>')">Print</button>
        </main>
    <?php } ?>
    <?php include 'sections/footer.php'; ?>
</body>

</html>