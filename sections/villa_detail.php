<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/data.php';

$villaDetail = $villa->getVilla($_GET['id']);
$villaImages = $villa->getVillaImages($_GET['id']);
$villaEigenschappen = $options->getEigenschappenByVilla($_GET['id']);
$villaOpties = $liggingsopties->getLiggingsoptiesByVilla($_GET['id']);

if (!$villaDetail) {
    echo "<p style='padding:20px;'>Villa niet gevonden.</p>";
} else {
    // Filter de primaire afbeelding en thumbnails op basis van de property "primary"
    $primaryImage = array_filter($villaImages, function($img) {
        return isset($img->primary) && $img->primary == 1;
    });
    $primaryImage = reset($primaryImage);
    $thumbnailImages = array_filter($villaImages, function($img) {
        return isset($img->primary) && $img->primary == 0;
    });
?>
    <section class="villa-detail">
        <div class="villa-detail__images">
            <div class="villa-detail__image-primary">
                <?php if ($primaryImage && isset($primaryImage->image)): ?>
                    <img src="assets/img/villa/<?= htmlspecialchars($primaryImage->image) ?>" alt="<?= htmlspecialchars($villaDetail->name ?? '') ?>">
                <?php else: ?>
                    <p>Geen afbeelding beschikbaar</p>
                <?php endif; ?>
            </div>

            <div class="villa-detail__image-thumbnail-wrapper">
                <div id="villa-detail_thumbnail" class="villa-detail__image-thumbnail">
                    <?php foreach ($thumbnailImages as $image): ?>
                        <div class="villa-detail__each-image">
                            <img src="assets/img/villa/<?= htmlspecialchars($image->image ?? '') ?>" alt="Villa Image">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="villa-detail__slider slider-controls">
                    <button id="prev" class="slider-controls-prev">Prev</button>
                    <button id="next" class="slider-controls-next">Next</button>
                </div>
            </div>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $naam = htmlspecialchars(trim($_POST['naam']));
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $villa_id = intval($_POST['villa'] ?? 0); // Haal de villa ID op uit het formulier
            $vraag = htmlspecialchars(trim($_POST['vraag'] ?? ''));

            // Debug: Log de formulierdata
            error_log("Naam: $naam, Email: $email, Villa ID: $villa_id, Vraag: $vraag");

            if (!empty($naam) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($vraag)) {
                if ($contact->addContact($naam, $email, $villa_id, $vraag)) {
                    $message = "<p class='p-3 bg-green-100 text-green-700 rounded'>Bedankt voor je bericht! We nemen snel contact op.</p>";
                } else {
                    $message = "<p class='p-3 bg-red-100 text-red-700 rounded'>Er is iets misgegaan. Probeer het opnieuw.</p>";
                }
            } else {
                $message = "<p class='p-3 bg-red-100 text-red-700 rounded'>Vul alle velden correct in!</p>";
            }
        }
        ?>

        <div class="villa-detail__details">
            <div class="villas-detail__villa-general">
                <h1 class="villas-details__villa-name"><?= htmlspecialchars($villaDetail->name ?? '') ?></h1>
                <p class="villas-details__villa-description"><?= htmlspecialchars($villaDetail->desc ?? '') ?></p>
                <ul class="villa-detail__villa-list list">
                    <li class="list__street">📍 <?= htmlspecialchars(($villaDetail->street ?? '') . ' ' . ($villaDetail->number ?? '')) ?></li>
                    <li class="list__price">💰 €<?= htmlspecialchars(number_format($villaDetail->price ?? 0, 2, ',', '.')) ?></li>
                    <li class="list__forsale">🏡 Te koop: <?= !empty($villaDetail->forsale) ? 'Ja' : 'Nee' ?></li>
                </ul>
                <br>
            </div>
            <ul class="villas-details__eigenschappen list">
                <?php if (!empty($villaEigenschappen)): ?>
                    <?php foreach ($villaEigenschappen as $eigenschap): ?>
                        <li class="list__eigenschappen"><?= htmlspecialchars($eigenschap->name ?? '') ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Geen eigenschappen beschikbaar</li>
                <?php endif; ?>
            </ul>
            <ul class="villa-details__options list">
                <?php if (!empty($villaOpties)): ?>
                    <?php foreach ($villaOpties as $optie): ?>
                        <li class="list__option"><?= htmlspecialchars($optie->name ?? '') ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Geen opties beschikbaar</li>
                <?php endif; ?>
            </ul>
            <p>€ <?= htmlspecialchars(number_format($villaDetail->price ?? 0, 2, ',', '.')) ?></p>
            <div class="villa-detail__buttons">
                <button id="openModal" class="villa-detail__contact-button">
                    Contacteer ons nu!
                </button>
                <a href="/includes/generate_pdf.php?id=<?= htmlspecialchars($villaDetail->id ?? '') ?>" target="_blank" class="villa-detail__pdf-button">
                    Download PDF
                </a>
            </div>
        </div>

        <div id="contactModal" class="modal-overlay">
            <div class="modal-overlay__container">
                <button id="closeModal" class="modal-overlay__close">&times;</button>
                <h2 class="modal-overlay__title">
                    <span class="black">Get in</span> <span class="red">Touch</span>
                </h2>
                <p class="modal-overlay__subtitle">
                    Have more questions? want to know if something is available?<br>
                    Feel free to contact us and we'll get back to you as soon as possible!
                </p>
                <?php if (!empty($message)) echo $message; ?>
                <form action="" method="POST" class="modal-overlay__form">
                    <input type="hidden" name="villa" value="<?= htmlspecialchars($_GET['id'] ?? 0) ?>">
                    <p class="modal-overlay__villa-id">Villa ID: <?= htmlspecialchars($_GET['id'] ?? '') ?></p>
                    <input type="text" name="naam" placeholder="Name *" class="modal-overlay__form-input" required>
                    <input type="email" name="email" placeholder="Email*" class="modal-overlay__form-input" required>
                    <textarea name="vraag" placeholder="Your question*" class="modal-overlay__form-textarea" required></textarea>
                    <button type="submit" class="modal-overlay__form-button">Send</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/assets/js/villa_detail.js"></script>
<?php } ?>
