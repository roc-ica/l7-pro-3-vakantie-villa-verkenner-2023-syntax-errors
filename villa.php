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
            <section class="villa">
                <div class="images">

                </div>
                <div class="booking">

                </div>
            </section>
            <section class="content">
                <h2>Details</h2>
                <p><?= $villa->desc; ?></p>
                <h2>Facilities</h2>
                <ul>
                    <?php foreach ($options as $facility) { ?>
                        <li><?= $facility->name; ?></li>
                    <?php } ?>
                </ul>
            </section>

            <button onclick="printPdf('/pdf.php?id=<?= $_GET['id'] ?>')">Print</button>
        </main>
    <?php } ?>
    <?php include 'sections/footer.php'; ?>
</body>

</html>