<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?="$search"; ?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($lot as $d): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=htmlspecialchars($d['image']);?>" width="350" height="260" alt="<?=htmlspecialchars($d['name_lot']);?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$d['name_cat'];?></span>
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
                        <?php endif; ?>">Осталось времени:<br/>
                            <?=get_dt_range($d['expiration_date'])['hour'];?> ч.
                            <?=get_dt_range($d['expiration_date'])['min'];?> мин.
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach;?>
        </ul>
    </section>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev">
            <a href="/?page=<?php if ($cur_page > "1"): ?><?=$cur_page - '1';?><?php endif; ?>">Назад</a>
        </li>
        <?php foreach ($pages as $page): ?>
            <li class="pagination__item <?php if ($page == $cur_page): ?>pagination__item--active<?php endif; ?>">
                <a href="/?page=<?=$page;?>"><?=$page;?></a>
            </li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next">
            <a href="/?page=<?php if ($cur_page > "1"): ?><?=$cur_page < $pages_count;?><?php endif; ?>">Вперед</a>
        </li>
    </ul>
</div>