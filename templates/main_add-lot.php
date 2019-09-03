    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($cats as $cat): ?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="pages/all-lots.html">
                        <?=htmlspecialchars($cat['name_cat'] . ' (' . $cat['character_code'] . ')');?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form form--add-lot container form--invalid" action="" method="post" enctype="multipart/form-data">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item">
                <?php $classname = isset($errors['name_lot']) ? "form__item--invalid" : ""; ?>
                <label for="name_lot">Наименование <sup>*</sup></label>
                <input id="name_lot" type="text" name="name_lot" placeholder="Введите наименование лота" value="<?=getPostVal('name_lot'); ?>">
                <span class="form__error">Введите наименование лота</span>
            </div>
            <div class="form__item">
                <label for="category">Категория <sup>*</sup></label>
                <?php $classname = isset($errors['category_id']) ? "form__item--invalid" : ""; ?>
                <select class="<?= $classname; ?>" id="category_id" name="category_id">
                    <option>Выберите категорию</option>
                    <?php foreach ($cats as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>"
                        <?php if ($cat['category_id'] == $lot['category_id']): ?>selected<?php endif; ?>>
                        <?=htmlspecialchars($cat['name_cat'] . ' (' . $cat['character_code'] . ')');?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error">Выберите категорию</span>
            </div>
        </div>
        <div class="form__item form__item--wide">
            <?php $classname = isset($errors['description']) ? "form__item--invalid" : ""; ?>
            <label for="description">Описание <sup>*</sup></label>
            <textarea id="description" placeholder="Напишите описание лота" name="description">
                <?=getPostVal('description'); ?>
            </textarea>
            <span class="form__error">Напишите описание лота</span>
        </div>
        <div class="form__item form__item--file">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="image" id="image" value="">
                <label for="image" class="">
                    Добавить
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small">
                <?php $classname = isset($errors['initial_price']) ? "form__item--invalid" : ""; ?>
                <label for="initial_price">Начальная цена <sup>*</sup></label>
                <input id="initial_price" type="text" name="initial_price" placeholder="0" value="<?=getPostVal('initial_price'); ?>">
                <span class="form__error">Введите начальную цену</span>
            </div>
            <div class="form__item form__item--small">
                <?php $classname = isset($errors['step_rate']) ? "form__item--invalid" : ""; ?>
                <label for="step_rate">Шаг ставки <sup>*</sup></label>
                <input id="step_rate" type="text" name="step_rate" placeholder="0" value="<?=getPostVal('step_rate'); ?>">
                <span class="form__error">Введите шаг ставки</span>
            </div>
            <div class="form__item">
                <?php $classname = isset($errors['expiration_date']) ? "form__item--invalid" : ""; ?>
                <label for="expiration_date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="expiration_date" type="text" name="expiration_date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=getPostVal('expiration_date'); ?>">
                <span class="form__error">Введите дату завершения торгов</span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, заполните форму корректно.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>