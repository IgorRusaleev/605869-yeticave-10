<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <tr class="rates__item rates__item--end">
            <?php foreach ($lot as $d): ?>
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?=htmlspecialchars($d['image']);?>" width="54" height="40" alt="<?=htmlspecialchars($d['name_lot']);?>">
                </div>
                <div>
                    <h3 class="rates__title">
                        <a href="<?="lot.php" . "?" . "id=" . $d['lot_id'];?>"><?=htmlspecialchars($d['name_lot']);?></a>
                        <p><?=htmlspecialchars($d['contact_information']);?></p>
                    </h3>
                </div>
            </td>
            <td class="rates__category">
                <?=$d['name_cat'];?>
            </td>
            <td class="rates__timer">
                <?php if ($d['user_winner'] == $d['user_id']): ?>
                    <div class="timer timer--win">Ставка выиграла</div>
                <?php elseif (date_create("now") < $d['expiration_date']): ?>
                    <div class="timer timer--end">Торги окончены</div>
                <?php else:?>
                    <div class="timer timer--finishing">
                        До завершения осталось:<br/>
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
                <?php endif; ?>
            </td>
            <td class="rates__price">
                <?=adding_ruble(htmlspecialchars($d['rate']));?>
            </td>
            <td class="rates__time">
                Ставка сделана:<br/>
                <?php if (get_dt_range($d['date_rate'])['day'] == 0): ?>
                <?php else:?>
                    <?=get_dt_range($d['date_rate'])['day'] . get_noun_plural_form(get_dt_range($d['date_rate'])['day'],' день ', ' дня ', ' дней ');?>
                <?php endif; ?>
                <?php if (get_dt_range($d['date_rate'])['hour'] == 0): ?>
                <?php else:?>
                    <?=get_dt_range($d['date_rate'])['hour'] . get_noun_plural_form(get_dt_range($d['date_rate'])['hour'],' час ', ' часа ', ' часов ');?>
                <?php endif; ?>
                <?=get_dt_range($d['date_rate'])['min'] . get_noun_plural_form(get_dt_range($d['date_rate'])['min'],' минута ', ' минуты ', ' минут ');?>
                назад
            </td>
            <?php endforeach;?>
        </tr>
    </table>
</section>