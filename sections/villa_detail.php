<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/data.php';

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

    <section class="villa-detail">
        <div class="villa-detail__images">
            <div class="villa-detail__image-primary">
                <?php if ($primaryImage): ?>
                    <img src="assets/img/villa/<?= htmlspecialchars($primaryImage['image']) ?>"
                         alt="<?= htmlspecialchars($villaDetail['name']) ?>">
                <?php else: ?>
                    <p>Geen afbeelding beschikbaar</p>
                <?php endif; ?>
            </div>

            <!-- Thumbnail Slider Container -->
            <div class="villa-detail__image-thumbnail-wrapper">
                <div id="villa-detail_thumbnail" class="villa-detail__image-thumbnail">
                    <?php foreach ($thumbnailImages as $image): ?>
                        <div class="villa-detail__each-image">
                            <img src="assets/img/villa/<?= htmlspecialchars($image['image']) ?>"
                                 alt="Villa Image">
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Navigation Controls -->
                <div class="slider-controls">
                    <button id="prev" class="slider-control slider-control--prev">Prev</button>
                    <button id="next" class="slider-control slider-control--next">Next</button>
                </div>
            </div>

        </div>

        <?php
        $message = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $naam = htmlspecialchars(trim($_POST['naam']));
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $villa_id = intval($_POST['villa']);
            $vraag = htmlspecialchars(trim($_POST['vraag']));

            if (!empty($naam) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($vraag)) {
                // Gebruik een veilige database-insert met prepared statements
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
                <h1 class="villas-details__villa-name"><?= htmlspecialchars($villaDetail['name']) ?></h1>
                <p class="villas-details__villa-description"/> <?= htmlspecialchars($villaDetail['desc']) ?></p>
                <!-- villa details -->
                <ul class="villa-detail__villa-list list">
                    <li class="list__street">📍 <?= htmlspecialchars($villaDetail['street'] . ' ' . $villaDetail['number']) ?></li>
                    <li class="list__price">💰 €<?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></li>
                    <li class="list__forsale">🏡 Te koop: <?= $villaDetail['forsale'] ? 'Ja' : 'Nee' ?></li>
                </ul>
            <br>
           </div>
            <!-- villa eigenschappen -->
            <ul class="villas-details__eigenschappen list">
                <?php if (!empty($villaEigenschappen)): ?>
                    <?php foreach ($villaEigenschappen as $eigenschap): ?>
                        <li class="list__eigenschappen"><?= htmlspecialchars($eigenschap->name) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Geen eigenschappen beschikbaar</li>
                <?php endif; ?>
            </ul>
            <!-- villa opties -->
            <ul class="villa-details__options list">
                <?php if (!empty($villaOpties)): ?>
                    <?php foreach ($villaOpties as $optie): ?>
                        <li class="list__option"><?= htmlspecialchars($optie->name) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Geen opties beschikbaar</li>
                <?php endif; ?>
            </ul>
            <p>€ <?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></p>
            <!-- contact popup -->
            <div>
                <button id="openModal" class="villa-detail__contact-button">
                    Contacteer ons nu!
                </button>
                <a href="/includes/generate_pdf.php?id=<?= $villaDetail['id'] ?>" target="_blank" class="villa-pdf_download-button">
                    Download PDF
                 </a>
            </div>
        </div>

        <!-- Contact Form Modal -->
        <div id="contactModal" class="modal-overlay">
            <div class="modal-overlay__container">
                <button id="closeModal" class="modal-overlay__close">&times;</button>

                <!-- Modal Title -->
                <h2 class="modal-overlay__title">
                    <span class="black">Get in</span> <span class="red">Touch</span>
                </h2>

                <!-- Subtitle -->
                <p class="modal-overlay__subtitle">
                    Have more questions? want to know if something is available?<br>
                    Feel free to contact us and we'll get back to you as soon as possible!
                </p>

                <?php if (!empty($message)) echo $message; ?>

                <!-- Contact Form -->
                <form action="" method="POST" class="modal-overlay__form">
                    <input type="text" name="naam" placeholder="Name *" class="modal-overlay__form-input" required>
                    <input type="email" name="email" placeholder="Email*" class="modal-overlay__form-input" required>
                    <p class="modal-overlay__villa-id">Villa ID: <?= $_GET['id'] ?></p>
                    <textarea name="vraag" placeholder="Your question*" class="modal-overlay__form-textarea"
                              required></textarea>
                    <button type="submit" class="modal-overlay__form-button">Send</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Modal Script -->
    <script src="/assets/js/villa_detail.js"></script>
<?php } ?>
