<?php include 'includes/data.php'; ?>
<!DOCTYPE html>
<html lang="nl">
<?php include 'includes/head.php'; ?>

<body class="villa">
    <?php include 'sections/header.php'; ?>

    <?php if (!isset($_GET['id'])): ?>
    <?php $villas = $villa->getVillas(); ?>
    <div style="display:flex;flex-wrap:wrap;gap:15px;padding:20px;">
        <?php foreach ($villas as $item): ?>
            <div style="border:1px solid #ccc;padding:15px;width:250px;">
                <a href="villa.php?id=<?= htmlspecialchars($item['id']) ?>" style="text-decoration:none;color:black;">
                    <?php
                        $primaryImage = $villa->getPrimaryImage($item['id']);
                        if ($primaryImage):
                    ?>
                        <img src="assets/img/villa/<?= htmlspecialchars($primaryImage) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:100%;height:auto;margin-bottom:10px;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/250x150?text=Geen+afbeelding" alt="Geen afbeelding" style="width:100%;height:auto;margin-bottom:10px;">
                    <?php endif; ?>

                    <h2 style="margin:0 0 10px 0;font-size:18px;"><?= htmlspecialchars($item['name']) ?></h2>
                    <p style="margin:0;"><?= htmlspecialchars($item['street'] . ' ' . $item['number']) ?></p>
                    <p style="margin:0;"><?= htmlspecialchars($item['postal']) ?></p>
                    <p style="margin:10px 0 0 0;font-weight:bold;">Prijs: €<?= htmlspecialchars(number_format($item['price'], 2, ',', '.')) ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>

        <?php
        $villaDetail = $villa->getVilla($_GET['id']);
        $villaImages = $villa->getVillaImages($_GET['id']);

        if (!$villaDetail) {
            echo "<p style='padding:20px;'>Villa niet gevonden.</p>";
        } else {
        ?>
            <div style="padding:20px; background-color: red;">

                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    <?php foreach ($villaImages as $image): ?>
                        <img src="assets\img\villa\<?= htmlspecialchars($image['image']) ?>" alt="<?= htmlspecialchars($villaDetail['name']) ?>" style="max-width:300px;height:auto;border:1px solid #ddd;">
                    <?php endforeach; ?>
                </div>

                <h1><?= htmlspecialchars($villaDetail['name']) ?></h1>
                <p><?= htmlspecialchars($villaDetail['desc']) ?></p>
                <ul style="list-style:none;padding:0;">
                    <li>📍<?= htmlspecialchars($villaDetail['street'] . ' ' . $villaDetail['number']) ?></li>
                    <li style="padding-left:5px;">€<?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></li>
                    <li style="padding-left:5px;">Te koop: <?= $villaDetail['forsale'] ? 'Ja' : 'Nee' ?></li>
                </ul>
            </div>
        <?php } ?>
    <?php endif; ?>

    <?php include 'sections/footer.php'; ?>
</body>

</html>