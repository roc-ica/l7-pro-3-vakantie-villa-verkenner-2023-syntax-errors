<?php include_once 'includes/data.php'; ?>

<?php if (!isset($_GET['id'])): ?>
    <?php 
    // Fetch all villas and filters
    $filters = [
        'name'          => $_GET['name'] ?? null,
        'min_price'     => $_GET['min_price'] ?? null,
        'max_price'     => $_GET['max_price'] ?? null,
        'liggingsoptie' => (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie'])) ? $_GET['liggingsoptie'] : [],
        'eigenschap'    => (isset($_GET['eigenschap']) && is_array($_GET['eigenschap'])) ? $_GET['eigenschap'] : [],
    ];

    $villas = $villa->getVillas($filters);

    // Fetch liggingsopties and eigenschappen dynamically
    $liggingsoptiesClass = new Liggingsopties();
    $liggingsopties = $liggingsoptiesClass->getLiggingsopties();

    $eigenschappenClass = new Eigenschappen();
    $eigenschappen = $eigenschappenClass->getEigenschappen();
    ?>
    <section class="all-villas">
        <form method="GET" action="villa.php" class="all-villas__form-filters">
            <!-- Dynamic Ligging Options -->
            <fieldset class="all-villas__fieldset-liggings">
                <legend class="all-villas__legend">Ligging</legend>
                <?php foreach ($liggingsopties as $ligging): ?>
                    <label>
                        <input 
                            type="checkbox" 
                            name="liggingsoptie[]" 
                            value="<?= htmlspecialchars($ligging->id) ?>" 
                            <?= (isset($_GET['liggingsoptie']) && in_array($ligging->id, $_GET['liggingsoptie'])) ? 'checked' : '' ?> 
                            class="all-villas__input">
                        <?= htmlspecialchars($ligging->name) ?>
                    </label><br>
                <?php endforeach; ?>
            </fieldset>

            <!-- Dynamic Eigenschappen -->
            <fieldset class="all-villas__fieldset-eigenschappen">
                <legend>Eigenschappen</legend>
                <?php foreach ($eigenschappen as $eigenschap): ?>
                    <label>
                        <input 
                            type="checkbox" 
                            name="eigenschap[]" 
                            value="<?= htmlspecialchars($eigenschap->id) ?>" 
                            <?= (isset($_GET['eigenschap']) && in_array($eigenschap->id, $_GET['eigenschap'])) ? 'checked' : '' ?> 
                            class="all-villas__input">
                        <?= htmlspecialchars($eigenschap->name) ?>
                    </label><br>
                <?php endforeach; ?>
            </fieldset>

            <button type="submit" class="all-villas__button --primary">Zoeken</button>
        </form>
        <div class="all-villas__container">
            <form method="GET" action="villa.php" class="all-villas__form-search">
                <input type="text" name="name" placeholder="Zoek op naam" value="<?= htmlspecialchars($_GET['name'] ?? '') ?>" class="all-villas__input">
                <div class="all-villas__price-setting">
                    <input type="number" name="min_price" placeholder="Min. prijs" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>" class="all-villas__input">
                    <input type="number" name="max_price" placeholder="Max. prijs" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>" class="all-villas__input">
                    <button type="submit" class="all-villas__button --primary">Zoeken</button>
                </div>
            </form>
            <div class="all-villas__items">
                <?php foreach ($villas as $item): ?>
                    <div class="all-villas__item">
                        <a href="villa.php?id=<?= htmlspecialchars($item->id) ?>" class="all-villas__item-button">
                            <?php
                            $primaryImage = $villa->getPrimaryImage($item->id);
                            if ($primaryImage):
                            ?>
                                <img src="assets/img/villa/<?= htmlspecialchars($primaryImage) ?>" alt="<?= htmlspecialchars($item->name) ?>" class="all-villas__item-image">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/250x150?text=Geen+afbeelding" alt="Geen afbeelding" style="width:100%;height:auto;margin-bottom:10px;">
                            <?php endif; ?>

                            <h2 class="all-villas__item-title"><?= htmlspecialchars($item->name) ?></h2>
                            <p class="all-villas__item-adres"><?= htmlspecialchars(($item->street ?? '') . ' ' . ($item->number ?? '')) ?></p>
                            <p class="all-villas__item-postal"><?= htmlspecialchars($item->postal) ?></p>
                            <p class="all-villas__item-price">Prijs: €<?= htmlspecialchars(number_format($item->price, 2, ',', '.')) ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php else: ?>
    <?php include_once 'sections/villa_detail.php'; ?>
<?php endif; ?>