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
    <!-- primary image -->
    <div>
        <?php if ($primaryImage): ?>
            <img src="assets/img/villa/<?= htmlspecialchars($primaryImage['image']) ?>"
                alt="<?= htmlspecialchars($villaDetail['name']) ?>">
        <?php else: ?>
            <p>Geen afbeelding beschikbaar</p>
        <?php endif; ?>
    </div>

    <!-- thumbnailImages -->
    <?php foreach ($thumbnailImages as $image): ?>
        <div>
            <img src="assets/img/villa/<?= htmlspecialchars($image['image']) ?>"
                alt="Villa Image"
                style="width: 300px; height: 300px;">
        </div>
    <?php endforeach; ?>
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
    <div>
        <!-- villa details -->
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
        <p>€ <?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></p>
        <!-- contact popup -->
        <div>
            <button id="openModal" class="">
                Contacteer ons nu!
            </button>
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
      <textarea name="vraag" placeholder="Your question*" class="modal-overlay__form-textarea" required></textarea>
      <button type="submit" class="modal-overlay__form-button">Send</button>
    </form>
  </div>
</div>


<!-- Modal Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openBtn = document.getElementById("openModal");
        const closeBtn = document.getElementById("closeModal");
        const modal = document.getElementById("contactModal");

        if (openBtn && closeBtn && modal) {
            openBtn.addEventListener("click", () => modal.classList.add("visible"));
            closeBtn.addEventListener("click", () => modal.classList.remove("visible"));
        }
    });
</script>


<?php } ?>
