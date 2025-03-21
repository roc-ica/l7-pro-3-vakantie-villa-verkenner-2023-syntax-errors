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
            $primaryImage = array_filter($villaImages, fn($img) => $img["primary"] == 1);
            $primaryImage = reset($primaryImage);
            $thumbnailImages = array_filter($villaImages, fn($img) => $img["primary"] == 0);
        ?>

            <div class="max-w-7xl mx-auto py-10 px-4 flex flex-col md:flex-row gap-6">
                <!-- Linkerkant -->
                <div class="w-full md:w-2/3">
                    <?php if ($primaryImage): ?>
                        <img src="assets/img/villa/<?= htmlspecialchars($primaryImage['image']) ?>"
                            alt="<?= htmlspecialchars($villaDetail['name']) ?>"
                            class="w-full h-96 object-cover rounded-xl shadow-lg border border-gray-200">
                    <?php else: ?>
                        <p class="text-red-500">Geen afbeelding beschikbaar</p>
                    <?php endif; ?>

                    <!-- ✅ Thumbnail Slider -->
                    <div class="max-w-6xl mx-auto">
                        <h3 class="text-lg font-semibold text-gray-700 text-center mb-3">Meer Afbeeldingen</h3>
                        <div class="owl-carousel owl-theme">
                            <?php foreach ($thumbnailImages as $image): ?>
                                <div class="item">
                                    <img src="assets/img/villa/<?= htmlspecialchars($image['image']) ?>"
                                        alt="Villa Image"
                                        class="h-24 w-32 object-cover rounded-lg shadow-md border border-gray-300 cursor-pointer hover:opacity-80 transition">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- ✅ Rechterkant -->
                <div class="w-full md:w-1/3 space-y-4">
                    <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($villaDetail['name']) ?></h1>
                    <p class="text-gray-600"><?= htmlspecialchars($villaDetail['desc']) ?></p>

                    <ul class="list-disc list-inside text-gray-700 list-none">
                        <li>📍 <?= htmlspecialchars($villaDetail['street'] . ' ' . $villaDetail['number']) ?></li>
                        <li>💰 €<?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></li>
                        <li>🏡 Te koop: <?= $villaDetail['forsale'] ? 'Ja' : 'Nee' ?></li>
                    </ul>

                    <p class="text-2xl font-semibold text-red-500">€ <?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></p>
                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        Contacteer ons nu!
                    </button>
                </div>
            </div>

        <?php } ?>

    <?php endif; ?>

    <?php include 'sections/footer.php'; ?>
</body>

</html>