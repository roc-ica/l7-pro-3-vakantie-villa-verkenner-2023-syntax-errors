<?php
$villaDetail = $villa->getVilla($_GET['id']);
$villaImages = $villa->getVillaImages($_GET['id']);
$villaEigenschappen = $options->getEigenschappenByVilla($_GET['id']);
$villaOpties = $liggingsopties->getLiggingsoptiesByVilla($_GET['id']);

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

<div>
    <!-- villa details -->
    <h1><?= htmlspecialchars($villaDetail['name']) ?></h1>
    <p><?= htmlspecialchars($villaDetail['desc']) ?></p>
    <ul>
        <li>📍 <?= htmlspecialchars($villaDetail['street'] . ' ' . $villaDetail['number']) ?></li>
        <li>💰 €<?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></li>
        <li>🏡 Te koop: <?= $villaDetail['forsale'] ? 'Ja' : 'Nee' ?></li>
    </ul>
    <!-- thumbnailImages -->
     
     
    <br>
    <!-- villa eigenschappen -->
    <ul>
        <?php if (!empty($villaEigenschappen)): ?>
            <?php foreach ($villaEigenschappen as $eigenschap): ?>
                <li><?= htmlspecialchars($eigenschap->name) ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Geen eigenschappen beschikbaar</li>
        <?php endif; ?>
    </ul>
    <!-- villa opties -->
    <ul>
        <?php if (!empty($villaOpties)): ?>
            <?php foreach ($villaOpties as $optie): ?>
                <li><?= htmlspecialchars($optie->name) ?></li>
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
