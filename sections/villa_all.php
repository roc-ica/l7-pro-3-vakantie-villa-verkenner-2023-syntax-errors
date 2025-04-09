<?php include_once 'includes/data.php'; ?>

<?php if (!isset($_GET['id'])): ?>
    <?php $villas = $villa->getVillas(); ?>
    <?php
    $filters = [
        'name' => $_GET['name'] ?? null,
        'min_price' => $_GET['min_price'] ?? null,
        'max_price' => $_GET['max_price'] ?? null,
        'liggingsoptie' => isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) ? $_GET['liggingsoptie'] : [],
        'eigenschap' => isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) ? $_GET['eigenschap'] : [],
    ];

    $villas = $villa->getVillas($filters);
    ?>
    <section class="all-villas">


        <form method="GET" action="villa.php" class="all-villas__form-filters">
            <fieldset class="all-villas__fieldset-liggings">
                <legend class="all-villas__legend">Ligging</legend>
                <label><input type="checkbox" name="liggingsoptie[]"
                              value="1" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(1, $_GET['liggingsoptie'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Dicht bij een bos</label><br>
                <label><input type="checkbox" name="liggingsoptie[]"
                              value="2" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(2, $_GET['liggingsoptie'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Dicht bij een stad</label><br>
                <label><input type="checkbox" name="liggingsoptie[]"
                              value="3" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(3, $_GET['liggingsoptie'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Dicht bij de zee</label><br>
                <label><input type="checkbox" name="liggingsoptie[]"
                              value="4" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(4, $_GET['liggingsoptie'])) ? 'checked' : '' ?>
                              class="all-villas__input"> In het heuvelland</label><br>
                <label><input type="checkbox" name="liggingsoptie[]"
                              value="5" <?= (isset($_GET['liggingsoptie']) && is_array($_GET['liggingsoptie']) && in_array(5, $_GET['liggingsoptie'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Aan het water</label>
            </fieldset>

            <fieldset class="all-villas__fieldset-eigenschappen">
                <legend>Eigenschappen</legend>
                <label><input type="checkbox" name="eigenschap[]"
                              value="1" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(1, $_GET['eigenschap'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Inclusief overname inventaris</label><br>
                <label><input type="checkbox" name="eigenschap[]"
                              value="2" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(2, $_GET['eigenschap'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Zwembad</label><br>
                <label><input type="checkbox" name="eigenschap[]"
                              value="3" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(3, $_GET['eigenschap'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Winkel(s) in de buurt</label><br>
                <label><input type="checkbox" name="eigenschap[]"
                              value="4" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(4, $_GET['eigenschap'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Entertainment in de buurt</label><br>
                <label><input type="checkbox" name="eigenschap[]"
                              value="5" <?= (isset($_GET['eigenschap']) && is_array($_GET['eigenschap']) && in_array(5, $_GET['eigenschap'])) ? 'checked' : '' ?>
                              class="all-villas__input"> Op een privépark</label>
            </fieldset>

            <button type="submit" class="all-villas__button --primary">Zoeken</button>
        </form>
        <div class="all-villas__container">
            <form method="GET" action="villa.php" class="all-villas__form-search">
                <input type="text" name="name" placeholder="Zoek op naam"
                       value="<?= htmlspecialchars($_GET['name'] ?? '') ?>" class="all-villas__input">
                <div class="all-villas__price-setting">
                    <input type="number" name="min_price" placeholder="Min. prijs"
                           value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>" class="all-villas__input">
                    <input type="number" name="max_price" placeholder="Max. prijs"
                           value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>" class="all-villas__input">
                </div>
            </form>
            <div class="all-villas__items">
                <?php foreach ($villas as $item): ?>
                    <div class="all-villas__item">
                        <a href="villa.php?id=<?= htmlspecialchars($item['id']) ?>" class="all-villas__item-button">
                            <?php
                            $primaryImage = $villa->getPrimaryImage($item['id']);
                            if ($primaryImage):
                                ?>
                                <img src="assets/img/villa/<?= htmlspecialchars($primaryImage) ?>"
                                     alt="<?= htmlspecialchars($item['name']) ?>" class="all-villas__item-image">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/250x150?text=Geen+afbeelding"
                                     alt="Geen afbeelding"
                                     style="width:100%;height:auto;margin-bottom:10px;">
                            <?php endif; ?>

                            <h2 class="all-villas__item-title"><?= htmlspecialchars($item['name']) ?></h2>
                            <p class="all-villas__item-adres"><?= htmlspecialchars($item['street'] . ' ' . $item['number']) ?></p>
                            <p class="all-villas__item-postal"><?= htmlspecialchars($item['postal']) ?></p>
                            <p class="all-villas__item-price">Prijs:
                                €<?= htmlspecialchars(number_format($item['price'], 2, ',', '.')) ?></p>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php else: ?>

    <?php include_once 'sections/villa_detail.php'; ?>

<?php endif; ?>