<section class="lot-item container">
    <h2><?=$lot[0]["name_lot"];?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="../<?=$lot[0]["image"];?>" width="730" height="548" alt="<?=$lot[0]["name_lot"];?>">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot[0]["name_cat"];?></span></p>
            <p class="lot-item__description"><?=$lot[0]["description"];?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot__timer timer
                <?php if (get_dt_range($lot[0]["expiration_date"])['hour'] < 1): ?>
                timer--finishing
                <?php endif; ?>">Осталось времени:<br/>
                    <?=get_dt_range($lot[0]["expiration_date"])["hour"];?> ч.
                    <?=get_dt_range($lot[0]["expiration_date"])["min"];?> мин.
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=adding_ruble($lot[0]['initial_price']);?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=adding_ruble($lot[0]['step_rate']);?></span>
                    </div>
                </div>
                <?php if ($is_auth = 1): ?>
                <form class="lot-item__form" action="../lot.php" method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item form__item--invalid">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=adding_ruble($lot[0]['step_rate']);?>">
                        <span class="form__error">Введите наименование лота</span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>