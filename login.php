<?php
require_once 'init.php';
    if (!$link) {
        $error = mysqli_connect_error();
        show_error($content, $error);
    }
    else {
        $sql = "SELECT * FROM category ORDER BY name_cat ASC";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $cats = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
    //  Проверяем, что форма была отправлена
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //  Определяем обязательные для заполнения поля, а также массив, где будут храниться ошибки
        $form = $_POST;
        $errors = [];
        //  Найдем в таблице users пользователя с переданным email.
        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $res = mysqli_query($link, $sql);
        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
        $email = $_POST["email"];
        $password = $_POST["password"];
        $required = ['email', 'password'];
        $rules = [
            'email' => function () use ($email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return null;
                } else {
                    return "E-mail адрес '$email' указан неверно";
                }
            },
            'password' => function () {
                return validateLength('password', 6, 20);
            }
        ];
        /*Применяем функции ко всем полям формы*/
        foreach ($_POST as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                /*Результат работы функций записывается в массив ошибок*/
                $errors[$key] = $rule();
            }
        }
        /*массив отфильтровываем, чтобы удалить от туда пустые значения и оставить только сообщения об ошибках*/
        $errors = array_filter($errors);
        /*проверяем существование каждого поля в списке обязательных к заполнению*/
        foreach ($required as $key) {
            if (empty($form[$key])) {
                /*если поле не заполнено, то добавляем ошибку валидации в список ошибок*/
                $errors[$key] = 'Все поля необходимо заполнить';
            }
            else {
                if (!count($errors) and $user) {
                    //  Проверяем, что сохраненный хеш пароля и введенный пароль из формы совпадают
                    if (password_verify($form['password'], $user['password'])) {
                        //  Если пароль совпадает, то для пользователя открываем сессию
                        $_SESSION['user'] = $user;
                    }
                    // иначе, если пароль неверный, и мы добавляем сообщение об этом в список ошибок
                    else {
                        $errors['password'] = 'Неверный пароль';
                    }
                }
                // Если пользователь не найден, то записываем это как ошибку валидации
                else {
                    if ($errors['email'] == null and $user['email'] !== $email) {
                        $errors['email'] = 'Такой пользователь не найден';
                    }
                }
            }
        }
        // Если были ошибки, значит мы снова должны показать форму входа, передав в шаблон список полученных ошибок
        if (count($errors)) {
            $page_content = include_template('main_login.php', ['form' => $form, 'errors' => $errors]);
        }
        //Если ошибок нет, значит аутентификация прошла успешно и пользователя можно перенаправить на главную страницу
        else {
            header("Location: /index.php");
            exit();
        }
    }
    //  Если форма не была отправлена, то проверяем существование сессии с пользователем.
     else {
            $page_content = include_template('main_login.php', []);

            //  Сессия есть - значит пользователь залогинен и ему можно показать главную страницу.
            if (isset($_SESSION['user'])) {
                header("Location: /index.php");
                exit();
            }
     }
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'cats' => $cats,
    'title' => 'Вход',
    'name_user' => $name_user
]);
print($layout_content);
?>