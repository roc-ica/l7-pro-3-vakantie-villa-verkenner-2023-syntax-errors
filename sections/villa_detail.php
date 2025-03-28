<?php
include 'includes/Data.php'; // Zorg ervoor dat je database connectie is ingeladen

$villaDetail = $villa->getVilla($_GET['id']);
$villaImages = $villa->getVillaImages($_GET['id']);
$villaEigenschappen = $villa->getVillaEigenschappen($_GET['id']);

if (!$villaDetail) {
    echo "<p style='padding:20px;'>Villa niet gevonden.</p>";
} else {
    $primaryImage = array_filter($villaImages, fn($img) => $img["primary"] == 1);
    $primaryImage = reset($primaryImage);
    $thumbnailImages = array_filter($villaImages, fn($img) => $img["primary"] == 0);
}
// ✅ Formulier verwerking met beveiliging
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

<!-- ✅ Toon Succes- of Foutmelding -->
<?= $message ?>

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
     

    <!-- Rechterkant -->
    <div class="w-full md:w-2/4 space-y-4">
        <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($villaDetail['name']) ?></h1>
        <p class="text-gray-600"><?= htmlspecialchars($villaDetail['desc']) ?></p>

        <ul class="list-none text-gray-700">
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

        <div class="flex justify-between items-center">
            <p class="text-2xl font-semibold text-red-500">€ <?= htmlspecialchars(number_format($villaDetail['price'], 2, ',', '.')) ?></p>
            <button id="openModal" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                Contacteer ons nu!
            </button>
        </div>
    </div>
</div>
<div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
        <h2 class="text-xl font-bold"><span class="text-black">Get in</span> <span class="text-red-600">Touch</span></h2>
        <p class="text-sm text-gray-600 mb-4">Heb je vragen? Neem contact op en we reageren zo snel mogelijk!</p>
        
        <!-- ✅ Verbeterd Formulier -->
        <form action="" method="POST">
            <input type="text" name="naam" placeholder="Naam*" class="w-full p-2 mb-3 border rounded" required>
            <input type="email" name="email" placeholder="E-mail*" class="w-full p-2 mb-3 border rounded" required>
            <input type="hidden" name="villa" value="<?= $villa_id ?>">
            <p class="text-gray-700 text-sm">Villa ID: <?= $_GET['id'] ?></p>
            <textarea name="vraag" placeholder="Jouw vraag*" class="w-full p-2 mb-3 border rounded" required></textarea>
            <button type="submit" class="w-full p-3 bg-red-600 text-white rounded">VERZENDEN</button>
        </form>

        <!-- Close Button -->
        <button id="closeModal" class="absolute top-3 right-4 text-gray-500">&times;</button>
    </div>
</div>

<script>
    // JavaScript to open/close modal
    document.getElementById("openModal").addEventListener("click", function () {
        document.getElementById("contactModal").classList.remove("hidden");
    });

    document.getElementById("closeModal").addEventListener("click", function () {
        document.getElementById("contactModal").classList.add("hidden");
    });
</script>

<?php  ?>
