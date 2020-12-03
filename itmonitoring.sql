-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3307
-- Время создания: Дек 02 2020 г., 18:54
-- Версия сервера: 5.7.24
-- Версия PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `itmonitoring`
--

-- --------------------------------------------------------

--
-- Структура таблицы `it_admin`
--

CREATE TABLE `it_admin` (
  `id` int(16) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `it_admin`
--

INSERT INTO `it_admin` (`id`, `login`, `password`, `access_token`) VALUES
(1, 'admin', '123123123', '3d73b886c42bad172e81240c6ebaffa6');

-- --------------------------------------------------------

--
-- Структура таблицы `it_emails`
--

CREATE TABLE `it_emails` (
  `id` int(16) NOT NULL,
  `emails` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `it_emails`
--

INSERT INTO `it_emails` (`id`, `emails`) VALUES
(1, 'Qdasd@sadasd.ru'),
(2, 'sadfasdfsdf@sdfsdfsdf.ru'),
(3, 'radozato@gmail.com'),
(4, '123123123@gmail.com');

-- --------------------------------------------------------

--
-- Структура таблицы `it_pages`
--

CREATE TABLE `it_pages` (
  `id` int(16) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `header` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `mails` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `it_pages`
--

INSERT INTO `it_pages` (`id`, `page_name`, `name`, `header`, `title`, `description`, `address`, `phone`, `mails`) VALUES
(1, 'home', '', '', '12DEFENDOCS', '12НА СТРАЖЕ ИНФОРМАЦИИ', '', '', ''),
(2, 'about', '12DEFENDOCS', '12НАША ЦЕЛЬ', '', '12Это гарантия того, что вы максимально быстро начнете соблюдать все требования GDPR каждой страны ЕС с минимальными затратами на организацию этой работы. На данный момент продукт находится на стадии beta-тестирования.', '', '', ''),
(3, 'contact', '', '', '', '', '12123 Main Street city, AB 0123\r\n12345 Not Main Street city, CD 4567', '12012-345-6789\r\n12025-698-9658', '12s.kretsu@defendocs.com\r\n12info@defendocs.com'),
(4, 'subscribe', '', '', '12ПОДПИСАТЬСЯ', '12Подпишитесь на новости о продукте DefenDocs и будьте вкурсе актуальной информации', '', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `it_admin`
--
ALTER TABLE `it_admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `it_emails`
--
ALTER TABLE `it_emails`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `it_pages`
--
ALTER TABLE `it_pages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `it_admin`
--
ALTER TABLE `it_admin`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `it_emails`
--
ALTER TABLE `it_emails`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `it_pages`
--
ALTER TABLE `it_pages`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
