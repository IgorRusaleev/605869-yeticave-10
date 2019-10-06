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
                        Минимальная ставка <span><?=adding_ruble($lot[0]['step_rate']);?></span>
                    </div>
                </div>
                <?php if (!isset($_SESSION['user'])): ?>
                    <?=""; ?>
                <?php else: ?>
                <form class="lot-item__form" action="<?="../" . "lot.php" . "?" . "id=" . $id;?>" method="post" autocomplete="off">
                    <p class="lot-item__form-item <?php if (isset($errors['cost'])): ?> form__item--invalid <?php endif; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=adding_ruble($lot[0]['step_rate']);?>" value="<?=getPostVal('cost'); ?>">
                        <span class="form__error"><?=$errors['cost'] ?? ""; ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
                <?php endif; ?>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= $number_rate;?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($history_rate as $h): ?>
                    <tr class="history__item">
                        <td class="history__name"><?=htmlspecialchars($h['name_user']);?></td>
                        <td class="history__price"><?=htmlspecialchars($h['rate']);?></td>
                        <td class="history__time">
                            <?php if (get_dt_range($h['date_rate'])['day'] == 0): ?>
                            <?php else:?>
                                <?=get_dt_range($h['date_rate'])['day'] . get_noun_plural_form(get_dt_range($h['date_rate'])['day'],' день ', ' дня ', ' дней ');?>
                            <?php endif; ?>
                            <?php if (get_dt_range($h['date_rate'])['hour'] == 0): ?>
                            <?php else:?>
                                <?=get_dt_range($h['date_rate'])['hour'] . get_noun_plural_form(get_dt_range($h['date_rate'])['hour'],' час ', ' часа ', ' часов ');?>
                            <?php endif; ?>
                            <?=get_dt_range($h['date_rate'])['min'] . get_noun_plural_form(get_dt_range($h['date_rate'])['min'],' минута ', ' минуты ', ' минут ');?>
                            назад
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>
    </div>
</section>