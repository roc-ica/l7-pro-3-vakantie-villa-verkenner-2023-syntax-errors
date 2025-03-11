<?php include 'includes/data.php'; ?>
<!DOCTYPE html>
<html lang="nl">
<?php include 'includes/head.php'; ?>

<body class="villa">
    <?php include 'sections/header.php'; ?>

    <?php if (!isset($_GET['id'])) { ?>
        <?php $villas = $villa->getVillas(); ?>
        
    <?php } else { ?>
        <?php $villa = $villa->getVilla($_GET['id']); ?>
        
    <?php } ?>

    <?php include 'sections/footer.php'; ?>
</body>

</html>