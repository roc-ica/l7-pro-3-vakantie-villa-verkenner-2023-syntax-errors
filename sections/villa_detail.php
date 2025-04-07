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
        <!-- contact popup -->
        <div>
            <p>€ <?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></p>
            <button id="openModal" class="px-4 py-2 bg-red-600 text-white rounded">
                Contacteer ons nu!
            </button>
        </div>
    </div>

    <!-- Contact Form Modal -->
    <div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-2"><span class="text-black">Get in</span> <span class="text-red-600">Touch</span></h2>
            <p class="text-sm text-gray-600 mb-4">Heb je vragen? Neem contact op en we reageren zo snel mogelijk!</p>

         <!-- contact form -->
            <form action="" method="POST">
             <input type="text" name="naam" placeholder="Naam*" class="w-full p-2 mb-3 border rounded" required>
             <input type="email" name="email" placeholder="E-mail*" class="w-full p-2 mb-3 border rounded" required>
             <input type="hidden" name="villa" value="<?= $villa_id ?>">
             <p class="text-gray-700 text-sm">Villa ID: <?= $villa_id ?></p>
             <textarea name="vraag" placeholder="Jouw vraag*" class="w-full p-2 mb-3 border rounded" required></textarea>
             <button type="submit" class="w-full p-3 bg-red-600 text-white rounded">VERZENDEN</button>
         </form>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        document.getElementById("openModal").addEventListener("click", function () {
            document.getElementById("contactModal").classList.remove("hidden");
        });

        document.getElementById("closeModal").addEventListener("click", function () {
            document.getElementById("contactModal").classList.add("hidden");
        });
    </script>

<?php } ?>
