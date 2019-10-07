<div class="container">
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
            <?php foreach ($lot as $d): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?=htmlspecialchars($d['image']);?>" width="350" height="260" alt="<?=htmlspecialchars($d['name_lot']);?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"> <?=$d['name_cat'];?> </span>
                        <h3 class="lot__title">
                            <a class="text-link" href="<?="lot.php" . "?" . "id=" . $d['lot_id'];?>">
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
                            <div class="lot__timer timer
                            <?php if (get_dt_range($d['expiration_date'])['hour'] < 1): ?>
                            timer--finishing
                            <?php endif; ?>">До завершения осталось:<br/>
                                <?php if (get_dt_range($d['expiration_date'])['day'] == 0): ?>
                                <?php else:?>
                                    <?=get_dt_range($d['expiration_date'])['day'] . get_noun_plural_form(get_dt_range($d['expiration_date'])['day'],' день ', ' дня ', ' дней ');?>
                                <?php endif; ?>
                                <?php if (get_dt_range($d['expiration_date'])['hour'] == 0): ?>
                                <?php else:?>
                                    <?=get_dt_range($d['expiration_date'])['hour'] . get_noun_plural_form(get_dt_range($d['expiration_date'])['hour'],' час ', ' часа ', ' часов ');?>
                                <?php endif; ?>
                                <?=get_dt_range($d['expiration_date'])['min'] . get_noun_plural_form(get_dt_range($d['expiration_date'])['min'],' минута ', ' минуты ', ' минут ');?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </section>
    <ul class="pagination-list">
        <?php if ($cur_page == 1): ?>
            <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <?php else: ?>
            <li class="pagination-item pagination-item-next"><a href="/?page=<?=($cur_page - 1);?>">Назад</a></li>
        <?php endif; ?>
        <?php foreach ($pages as $page): ?>
            <li class="pagination__item <?php if ($page == $cur_page): ?>pagination__item--active<?php else: ?><?php endif; ?>">
                <a href="/?page=<?=$page;?>"><?=$page;?></a>
            </li>
        <?php endforeach; ?>
        <?php if ($pages_count == $cur_page): ?>
            <li class="pagination-item pagination-item-next"><a>Вперед</a></li>
        <?php else: ?>
            <li class="pagination-item pagination-item-next"><a href="/?page=<?=($cur_page + 1);?>">Вперед</a></li>
        <?php endif; ?>
    </ul>
</div>
