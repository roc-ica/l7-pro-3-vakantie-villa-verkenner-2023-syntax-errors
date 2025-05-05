<?php

include '../includes/data.php';
Session::CheckSession();

if (isset($_GET['delete'])) {
    $villa->deleteVilla($_GET['id']);
    header('Location: /admin/');
    exit;
}

if (isset($_GET['forsale'])) {
    $villa->changeForSale($_GET['id']);
    header('Location: /admin/');
    exit;
}

if (isset($_POST['add'])) {
    $villa->addVilla($_POST, $_FILES);
    header('Location: /admin/');
    exit;
}

if (isset($_POST['edit'])) {
    $villa->updateVilla($_GET['id'], $_POST, $_FILES);
    header('Location: /admin/');
    exit;
}

$isEdit = isset($_GET['id']);
$villaData = $isEdit ? $villa->getVilla($_GET['id']) : null;
$images = $isEdit ? $villa->getVillaImages($_GET['id']) : [];

$selectedEigenschappen = $isEdit ? $options->getSelectedEigenschappen($_GET['id']) : [];
$selectedOpties = $isEdit ? $liggingsopties->getSelectedOpties($_GET['id']) : [];

$alleEigenschappen = $options->getEigenschappen();
$alleOpties = $liggingsopties->getLiggingsopties();
?>

<!DOCTYPE html>
<html lang="nl">
<?php include '../includes/head.php'; ?>
<body class="villadmin">
<?php include '../sections/admin_sidebar.php'; ?>

<section class="content">
    <form action="villa_actions.php<?= $isEdit ? '?id=' . $_GET['id'] : '' ?>" method="POST" enctype="multipart/form-data">
        <h2><?= $isEdit ? 'Villa bewerken' : 'Nieuwe villa toevoegen' ?></h2>

        <input type="text" name="name" placeholder="Naam" value="<?= $villaData->name ?? '' ?>" required><br>
        <input type="text" name="postal" placeholder="Postcode" value="<?= $villaData->postal ?? '' ?>" required><br>
        <input type="text" name="street" placeholder="Straat" value="<?= $villaData->street ?? '' ?>" required><br>
        <input type="text" name="number" placeholder="Huisnummer" value="<?= $villaData->number ?? '' ?>" required><br>
        <input type="number" step="0.01" name="price" placeholder="Prijs" value="<?= $villaData->price ?? '' ?>" required><br>
        <textarea name="desc" placeholder="Beschrijving"><?= $villaData->desc ?? '' ?></textarea><br>

        <h4>Eigenschappen</h4>
        <?php foreach ($alleEigenschappen as $eigenschap): ?>
            <label>
                <input type="checkbox" name="eigenschappen[]" value="<?= $eigenschap->id ?>" <?= in_array($eigenschap->id, $selectedEigenschappen) ? 'checked' : '' ?>>
                <?= htmlspecialchars($eigenschap->name) ?>
            </label><br>
        <?php endforeach; ?>

        <h4>Ligging opties</h4>
        <?php foreach ($alleOpties as $optie): ?>
            <label>
                <input type="checkbox" name="opties[]" value="<?= $optie->id ?>" <?= in_array($optie->id, $selectedOpties) ? 'checked' : '' ?>>
                <?= htmlspecialchars($optie->name) ?>
            </label><br>
        <?php endforeach; ?>

        <h4>Afbeeldingen uploaden</h4>
        <input type="file" name="images[]" multiple><br>
        <label>Markeer welke index "primary" is (begint bij 0):</label>
        <input type="number" name="primary" placeholder="Index (bijv. 0)"><br>

        <?php if ($isEdit && count($images)): ?>
            <h4>Bestaande afbeeldingen</h4>
            <?php foreach ($images as $img): ?>
                <div style="display:inline-block; margin:10px;">
                    <img src="/assets/img/villa/<?= htmlspecialchars($img->image) ?>" alt="" width="150"><br>
                    <label>
                        <input type="radio" name="set_primary" value="<?= $img->id ?>" <?= $img->primary ? 'checked' : '' ?>>
                        Markeer als primary
                    </label><br>
                    <label>
                        <input type="checkbox" name="delete_image[]" value="<?= $img->id ?>">
                        Verwijder
                    </label>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <br><br>
        <button type="submit" name="<?= $isEdit ? 'edit' : 'add' ?>">
            <?= $isEdit ? 'Villa bijwerken' : 'Villa toevoegen' ?>
        </button>
    </form>
</section>

</body>
</html>
