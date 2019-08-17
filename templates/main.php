<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($cats as $cat): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"> <?=htmlspecialchars($cat);?> </a>
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
                    <img src="<?=htmlspecialchars($d['Picture_URL']);?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"> <?=$d['cat'];?> </span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"> <?=htmlspecialchars($d['name']);?> </a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"> <?=adding_ruble(htmlspecialchars($d['Price']));?> </span>
                        </div>
                        <div class="lot__timer timer">
                            <?=(get_dt_range($d['expiration_date'])['hour']);?>часов
                            <?=get_dt_range($d['expiration_date'])['min']);?>минут
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>