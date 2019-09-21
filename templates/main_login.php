<form class="form container" action="../login.php" method="post">
    <h2>Вход</h2>
    <div class="form__item
        <?php if (isset($errors['email'])): ?> form__item--invalid <?php endif; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=getPostVal('email'); ?>">
        <span class="form__error"><?=$errors['email'] ?? ""; ?></span>
    </div>
    <div class="form__item form__item--last
        <?php if (isset($errors['password'])): ?> form__item--invalid <?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=getPostVal('password'); ?>">
        <span class="form__error"><?=$errors['password'] ?? ""; ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>