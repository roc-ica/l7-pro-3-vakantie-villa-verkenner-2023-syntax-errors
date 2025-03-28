
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
