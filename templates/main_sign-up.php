<?php if (!isset($_SESSION['user'])): ?>
    <?php
    header('http_response_code(403)');
    die();
    ?>
<?php else: ?>
    <form class="form container
    <?php if (count($errors)): ?>
    form--invalid
    <?php endif; ?>" action="../sign-up.php" method="post" enctype="multipart/form-data">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item
    <?php if (isset($errors['email'])): ?>
    form__item--invalid
    <?php endif; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=getPostVal('email'); ?>">
        <span class="form__error"><?=$errors['email'] ?? ""; ?></span>
    </div>
    <div class="form__item
    <?php if (isset($errors['password'])): ?>
    form__item--invalid
    <?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password'] ?? ""; ?></span>
    </div>
    <div class="form__item
    <?php if (isset($errors['name_user'])): ?>
    form__item--invalid
    <?php endif; ?>">
        <label for="name_user">Имя <sup>*</sup></label>
        <input id="name_user" type="text" name="name_user" placeholder="Введите имя" value="<?=getPostVal('name_user'); ?>">
        <span class="form__error"><?=$errors['name_user'] ?? ""; ?></span>
    </div>
    <div class="form__item
    <?php if (isset($errors['contact_information'])): ?>
    form__item--invalid
    <?php endif; ?>">
        <label for="contact_information">Контактные данные <sup>*</sup></label>
        <textarea id="contact_information" name="contact_information" placeholder="Напишите как с вами связаться"><?=getPostVal('contact_information'); ?></textarea>
        <span class="form__error"><?=$errors['contact_information'] ?? ""; ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
<?php endif; ?>


