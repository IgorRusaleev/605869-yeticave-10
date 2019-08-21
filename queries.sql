/*Создание таблицы категорий*/
INSERT INTO category SET
                         name_cat = 'Доски и лыжи',
                         character_code = 'boards';
INSERT INTO category SET
                         name_cat = 'Крепления',
                         character_code = 'attachment';
INSERT INTO category SET
                         name_cat = 'Ботинки',
                         character_code = 'boards';
INSERT INTO category SET
                         name_cat = 'Одежда',
                         character_code = 'clothing';
INSERT INTO category SET
                         name_cat = 'Инструменты',
                         character_code = 'tools';
INSERT INTO category SET
                         name_cat = 'Разное',
                         character_code = 'other';

/*Создание таблицы пользователей*/
INSERT INTO user SET
                     registration_date = '2018-11-27',
                     email = 'V_Ivanov@index.ru',
                     name_user = 'Василий Иванов',
                     password = 'V_Ivanov',
                     contact_information = '555-555-55';
INSERT INTO user SET
                     registration_date = '2018-11-28',
                     email = 'P_Ivanov@index.ru',
                     name_user = 'Петр Иванов',
                     password = 'P_Ivanov',
                     contact_information = '553-555-73';

/*Создание таблицы списка объявлений*/
INSERT INTO lot SET
                    creation_date = '2019-05-13',
                    name_lot  = '2014 Rossignol District Snowboard',
                    image = 'img/lot-1.jpg',
                    initial_price = '10999',
                    completion_date = '2019-12-30',
                    user_id = '1',
                    category_id = '1';
INSERT INTO lot SET
                    creation_date = '2019-05-21',
                    name_lot  = 'DC Ply Mens 2016/2017 Snowboard',
                    image = 'img/lot-2.jpg',
                    initial_price = '159999',
                    completion_date = '2019-11-27',
                    user_id = '2',
                    category_id = '1';
INSERT INTO lot SET
                    creation_date = '2019-06-13',
                    name_lot  = 'Крепления Union Contact Pro 2015 года размер L/XL',
                    image = 'img/lot-3.jpg',
                    initial_price = '8000',
                    completion_date = '2019-11-16',
                    user_id = '3',
                    category_id = '2';
INSERT INTO lot SET
                    creation_date = '2019-06-24',
                    name_lot  = 'Ботинки для сноуборда DC Mutiny Charocal',
                    image = 'img/lot-4.jpg',
                    initial_price = '10999',
                    completion_date = '2019-12-21',
                    user_id = '2',
                    category_id = '3';
INSERT INTO lot SET
                    creation_date = '2019-07-03',
                    name_lot  = 'Куртка для сноуборда DC Mutiny Charocal',
                    image = 'img/lot-5.jpg',
                    initial_price = '7500',
                    completion_date = '2019-11-13',
                    user_id = '3',
                    category_id = '4';
INSERT INTO lot SET
                    creation_date = '2019-07-03',
                    name_lot  = 'Маска Oakley Canopy',
                    image = 'img/lot-6.jpg',
                    initial_price = '5400',
                    completion_date = '2019-12-11',
                    user_id = '2',
                    category_id = '6';

/*Добавление ставок*/
INSERT INTO rate SET
                     date = '2019-05-21',
                     rate  = '11000.00',
                     user_id = '2',
                     lot_id = '1';
INSERT INTO rate SET
                     date = '2019-05-22',
                     rate  = '1500.00',
                     user_id = '3',
                     lot_id = '1';

/*Получение всех категорий*/
SELECT * FROM category ORDER BY name_cat ASC;

/*Получение самых новых, открытых лотов*/
SELECT initial_price, image, rate, name_cat FROM  category c
INNER JOIN lot l ON c.category_id = l.category_id
INNER JOIN rate r ON l.user_id = r.user_id;

/*Показ лота по его id*/
SELECT  lot_id, name_cat FROM category c
INNER  JOIN lot l ON c.category_id = l.category_id;

/*Обновление названия лота по его идентификатору*/
SELECT * FROM lot ORDER BY lot_id ASC;

/*Получение списока ставок для лота по его идентификатору с сортировкой по дате*/
SELECT * FROM rate ORDER BY date ASC;