<?php
$villaDetail = $villa->getVilla($_GET['id']);
$villaImages = $villa->getVillaImages($_GET['id']);
$villaEigenschappen = $options->getEigenschappenByVilla($_GET['id']);
// $villaOpties = $villa->getVillaOpties($_GET['id']);

if (!$villaDetail) {
    echo "<p style='padding:20px;'>Villa niet gevonden.</p>";
} else {    
    $primaryImage = array_filter($villaImages, fn($img) => $img["primary"] == 1);
    $primaryImage = reset($primaryImage);
    $thumbnailImages = array_filter($villaImages, fn($img) => $img["primary"] == 0);
?>
<!-- primary image -->
<div>
    <?php if ($primaryImage): ?>
        <img src="assets/img/villa/<?= htmlspecialchars($primaryImage['image']) ?>"
            alt="<?= htmlspecialchars($villaDetail['name']) ?>"
            >
    <?php else: ?>
        <p>Geen afbeelding beschikbaar</p>
    <?php endif; ?>
</div>
<!-- villa details -->
<div>
    <h1><?= htmlspecialchars($villaDetail['name']) ?></h1>
    <p><?= htmlspecialchars($villaDetail['desc']) ?></p>
    <ul>
        <li>📍 <?= htmlspecialchars($villaDetail['street'] . ' ' . $villaDetail['number']) ?></li>
        <li>💰 €<?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></li>
        <li>🏡 Te koop: <?= $villaDetail['forsale'] ? 'Ja' : 'Nee' ?></li>
    </ul>
    <br>
    <!-- villa eigenschappen -->
    <ul>
        <?php if (!empty($villaEigenschappen)): ?>
            <?php foreach ($villaEigenschappen as $eigenschap): ?>
                <li><?= htmlspecialchars($eigenschap->name)?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Geen eigenschappen beschikbaar</li>
        <?php endif; ?>
    </ul>
    <!-- villa opties -->
    <ul>
        <?php if (!empty($villaOpties)): ?>
            <?php foreach ($villaOpties as $optie): ?>
                <li><?= htmlspecialchars($optie['name']) ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Geen opties beschikbaar</li>
        <?php endif; ?>
    </ul>
    <!-- contact popup -->
    <div>
        <p>€ <?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></p>
        <button>
            Contacteer ons nu!
        </button>
    </div>
</div>

<?php } ?>

<?php

// if (!isset($_GET['id']) || empty($_GET['id'])) {
//     echo "<p>Invalid villa ID.</p>";
//     include 'section/footer.php';
//     exit();
// }

// $villaId = intval($_GET['id']);
// $villaDetails = $villa->getVillaById($villaId);

// if (!$villaDetails) {
//     echo "<p>Villa not found.</p>";
//     include 'footer.php';
//     exit();
// }
// ?>

<!-- <div class="villa-detail-container">
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
</div> -->

<?php include 'footer.php'; ?>