<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($cats as $cat): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html">
                    <?=htmlspecialchars($cat['name_cat'] . ' (' . $cat['character_code'] . ')');?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($ads as $d): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=htmlspecialchars($d['image']);?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"> <?=$d['name_cat'];?> </span>
                    <h3 class="lot__title">
                        <a class="text-link" href="pages/lot.html">
                            <?=htmlspecialchars($d['name_lot']);?>
                        </a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost">
                                <?=adding_ruble(htmlspecialchars($d['initial_price']));?>
                            </span>
                        </div>
                        <div class="lot__timer timer"
                            <?php if (get_dt_range($d['expiration_date'])['hour'] < 1): ?>
                                class="timer--finishing"
                            <?php endif; ?>>Осталось времени:<br/>
                            <?=get_dt_range($d['expiration_date'])['hour'];?> часов
                            <?=get_dt_range($d['expiration_date'])['min'];?> минут
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>