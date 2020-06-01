-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 01 2020 г., 19:29
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `article`
--

CREATE TABLE `article` (
  `id_article` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT 'New article',
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `article`
--

INSERT INTO `article` (`id_article`, `title`, `content`, `date`, `id_user`, `id_category`, `img`) VALUES
(1, 'Тестовая статья 1', 'Текст первой статьи', '2020-05-01 17:22:24', 3, 1, NULL),
(2, 'Тестовая статья 2', 'Текст второй тестовой статьи', '2020-05-01 17:22:24', 4, 2, NULL),
(3, 'Тестовая статья 3', 'Текст третьей статьи', '2020-05-01 18:09:07', 5, 3, NULL),
(4, 'Статья номер 4', 'Ого-го-го какая статья!', '2020-05-03 04:48:29', 3, 1, NULL),
(5, '555', 'Мои скрипты:\r\n\r\n\r\nINSERT INTO `article`( `title`, `content`,  `id_user`, `id_category`) VALUES (\'Тест 1\',\'Текст первой статьи\',\'2\',\'3\');\r\n$title = \'0\'; пременная для названия статьи.\r\n$content = \'0\';\r\nпеременная для контента.\r\n$id_user = \'0\'; переменная для айдишника автора.\r\n$id_category = \'0\';\r\nпеременная для айдишника категории.\r\nINSERT INTO `article`( `title`, `content`,  `id_user`, `id_category`) VALUES (\'$title\',\'$content\',\'$id_user\',\'$id_category\');\r\n\r\nSELECT title, content, name, date, title_category  FROM article INNER JOIN categories ON article.id_category = categories.id_category INNER JOIN users ON  users.id_user = article.id_user WHERE date>\'2020-04-30\';\r\n\r\n\r\nUPDATE `article` SET `title`= \'Тестовая статья 1\',`id_category`=\'1\' WHERE `id_user`= \'2\';\r\n$title_new = \'1\'; \r\nпременная для нового названия статьи.\r\n$id_user_new = \'\';\r\nпеременная для нового айдишника автора.\r\nUPDATE `article` SET `title`= \'$title_new\', `id_category`=\'$id_category_new\' WHERE `id_user`= \'$id_user_new\';', '2020-05-03 04:56:52', 1, 2, NULL),
(6, 'Вернуть одну ячейку', '$id_article = $query->fetchColumn();', '2020-05-03 05:20:24', 3, 3, NULL),
(7, 'статья', 'программирование ', '2020-05-03 05:02:37', 2, 3, NULL),
(8, 'cazino 777', '60 000 000 $', '2020-05-03 05:16:24', 2, 3, NULL),
(11, 'Acer Aspire 5 A517-51G-38Q8', '17.3\" 1920 x 1080 IPS, Intel Core i3 7020U 2300 МГц, 4 ГБ, HDD 1000 ГБ, граф. адаптер: NVIDIA GeForce MX130 2 ГБ, Linux, цвет крышки черный', '2020-05-03 07:33:40', 1, 1, '01.jpg'),
(12, 'Acer Aspire A517-51G-55A4', '17.3\" 1920 x 1080 IPS, Intel Core i3 7020U 2300 МГц, 4 ГБ, HDD 1000 ГБ, граф. адаптер: NVIDIA GeForce MX130 2 ГБ, Linux, цвет крышки черный', '2020-05-03 07:38:42', 3, 3, '00.jpg'),
(13, 'Новая статья', 'Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Деревни дорогу свою парадигматическая не это образ если ручеек имеет она до своих языком семь одна коварный лучше текст предложения что он грамматики, предупредила рекламных заманивший предупреждал всеми! Путь своих назад по всей это, послушавшись родного текстами вдали заманивший не пор возвращайся маленький даль, оксмокс однажды журчит рыбного эта океана там подпоясал вскоре за дорогу парадигматическая текст? Эта страну дал вопроса снова подзаголовок над несколько, свой повстречался, lorem сбить мир необходимыми буквоград. Большой свой рот, напоивший подпоясал заглавных лучше последний, предупреждал строчка послушавшись текста по всей которой всеми образ рыбными вскоре эта ipsum ему раз рыбного вершину текст, буквенных деревни силуэт моей пор.', '2020-05-04 11:01:49', 10, 4, '11.jpg'),
(14, 'New article', 'Скидка 10% на шины топовых брендов\r\nTigar, Hankook, GoodYear, Dunlop, Nokian!\r\n\r\nС 14 по 17 мая используйте промокод:\r\n	\r\n	ШИНА10\r\n	\r\n	\r\nА еще приятные бонусы:\r\nпри покупке любых шин вы получаете скидку до 40%\r\nна шиномонтаж на СТО, участвующих в акции!\r\nИ конечно, рассрочка до 24 месяцев (в зависимости от модели)', '2020-05-14 13:21:57', 7, 3, '02.jpg'),
(15, 'test', 'content', '2020-05-28 18:28:44', 3, 3, 'image'),
(16, 'test_5', 'content_3', '2020-05-28 18:28:45', 3, 3, 'image'),
(18, 'test', 'content', '2020-05-28 18:39:22', 3, 3, 'image'),
(19, 'ООП новая статья', 'Если параметр needle не является строкой, он преобразуется в целое число и трактуется как код символа. Это поведение устарело с PHP 7.3.0, и полагаться на него крайне не рекомендуется. В зависимости от предполагаемого поведения, параметр needle должен быть либо явно приведен к строке, либо должен быть выполнен явный вызов chr().', '2020-05-31 17:21:24', 6, 5, '12.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `title_category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id_category`, `title_category`) VALUES
(1, 'sport'),
(2, 'money'),
(3, 'Здоровье'),
(4, 'PHP'),
(5, 'PHP 2'),
(6, 'PHP 3'),
(7, 'Политика'),
(8, 'Курсы валют');

-- --------------------------------------------------------

--
-- Структура таблицы `texts`
--

CREATE TABLE `texts` (
  `id_text` int(20) NOT NULL,
  `text_name` varchar(30) NOT NULL,
  `text_content` text DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `texts`
--

INSERT INTO `texts` (`id_text`, `text_name`, `text_content`, `description`) VALUES
(1, '$image_header', 'header.jpg', 'картинка для хедера!'),
(2, '$image_footer', 'footer.jpg', 'картинка для футера'),
(3, '$title_1', 'PHP', 'Основной заголовок'),
(4, '$title_2', 'Первый уровень PHP', 'Заголовок дополнительный'),
(5, '$image_mail', 'mail.png', 'рисунок конверта  почтового ящика, используется при указании адреса почты'),
(6, '$vk', 'vk.jpg', 'Значок \"в контакте\"'),
(7, '$instagram', 'instagram.jpg', 'Рисунок-значок для инстаграма'),
(9, '$fb', 'facebook.jpg', 'картинка для фейсбука'),
(15, '$title_3', 'Заголовок 3', 'Заголовок 3');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `name`) VALUES
(1, 'Ivan Ivanovich'),
(2, 'Petr'),
(3, 'Иван Иванов'),
(4, 'Петр Петров'),
(5, 'Сидр Сидоров'),
(6, 'Виталий Игоревич'),
(7, 'хороший автор'),
(8, 'VIP'),
(9, 'Пупкин Василий'),
(10, 'Кипятков Иван Иванович'),
(11, 'Рабинович'),
(12, 'new'),
(13, 'Путин'),
(14, 'Голобородько'),
(15, 'Голобородько'),
(16, 'Голобородько'),
(17, 'Trumph'),
(70, 'the best - ЭТО BEST'),
(71, 'the best - ЭТО BEST'),
(72, 'Иде5олог');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_category` (`id_category`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Индексы таблицы `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`id_text`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `texts`
--
ALTER TABLE `texts`
  MODIFY `id_text` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
