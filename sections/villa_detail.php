<?php
$villaDetail = $villa->getVilla($_GET['id']);
$villaImages = $villa->getVillaImages($_GET['id']);
$villaEigenschappen = $villa->getVillaEigenschappen($_GET['id']);
// $villaOpties = $villa->getVillaOpties($_GET['id']);

if (!$villaDetail) {
    echo "<p style='padding:20px;'>Villa niet gevonden.</p>";
} else {
    $primaryImage = array_filter($villaImages, fn($img) => $img["primary"] == 1);
    $primaryImage = reset($primaryImage);
    $thumbnailImages = array_filter($villaImages, fn($img) => $img["primary"] == 0);
?>

    <div class="max-w-7xl mx-auto py-10 px-4 flex flex-col md:flex-row gap-6">
        <!-- Linkerkant -->
        <div class="w-full md:w-2/4">
            <?php if ($primaryImage): ?>
                <img src="assets/img/villa/<?= htmlspecialchars($primaryImage['image']) ?>"
                    alt="<?= htmlspecialchars($villaDetail['name']) ?>"
                    class="w-full h-96 object-cover rounded-xl shadow-lg border border-gray-200">
            <?php else: ?>
                <p class="text-red-500">Geen afbeelding beschikbaar</p>
            <?php endif; ?>

            <!-- Slider -->
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
        <div class="w-full md:w-2/4 space-y-4">
            <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($villaDetail['name']) ?></h1>
            <p class="text-gray-600"><?= htmlspecialchars($villaDetail['desc']) ?></p>

            <ul class="list-disc list-inside text-gray-700 list-none">
                <li>📍 <?= htmlspecialchars($villaDetail['street'] . ' ' . $villaDetail['number']) ?></li>
                <li>💰 €<?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></li>
                <li>🏡 Te koop: <?= $villaDetail['forsale'] ? 'Ja' : 'Nee' ?></li>
            </ul>

            <br>

            <ul class="list-disc list-inside text-gray-700">
                <?php if (!empty($villaEigenschappen)): ?>
                    <?php foreach ($villaEigenschappen as $eigenschap): ?>
                        <li>✅ <?= htmlspecialchars($eigenschap['name']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-gray-500">Geen eigenschappen beschikbaar</li>
                <?php endif; ?>
            </ul>

            <!-- opties -->

            <!-- <ul class="list-disc list-inside text-gray-700">
                <?php if (!empty($villaOpties)): ?>
                    <?php foreach ($villaOpties as $optie): ?>
                        <li>✅ <?= htmlspecialchars($optie['name']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="text-gray-500">Geen opties beschikbaar</li>
                <?php endif; ?>
            </ul> -->


            <div class="flex justify-between items-center">
                <p class="text-2xl font-semibold text-red-500">€ <?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></p>
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Contacteer ons nu!
                </button>
            </div>
        </div>
    </div>

<?php } ?>
=======

<?php
// includes for the villa detail page
include 'sections/navigation.php';
include 'sections/header.php';
include 'includes/data.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Invalid villa ID.</p>";
    include 'section/footer.php';
    exit();
}

$villaId = intval($_GET['id']);
$villaDetails = $villa->getVillaById($villaId);

if (!$villaDetails) {
    echo "<p>Villa not found.</p>";
    include 'footer.php';
    exit();
}
?>

<!-- sections for the villa detail page  -->
<div class="villa-detail-container">
    <div class="villa-image">
        <img src="<?php echo htmlspecialchars($villaDetails['image']); ?>" alt="Villa Image">
    </div>
    <div class="villa-info">
        <h1><?php echo htmlspecialchars($villaDetails['name']); ?></h1>
        <p><strong>Price:</strong> <?php echo htmlspecialchars($villaDetails['price']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($villaDetails['location']); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($villaDetails['description'])); ?></p>
        <p><strong>Amenities:</strong> <?php echo htmlspecialchars($options->getAmenities($villaId)); ?></p>
        <p><strong>Nearby Locations:</strong> <?php echo htmlspecialchars($liggingsopties->getNearby($villaId)); ?></p>
    </div>
</div>

<?php include 'footer.php'; ?>
