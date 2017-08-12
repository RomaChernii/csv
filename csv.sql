-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 12 2017 г., 10:07
-- Версия сервера: 5.7.14
-- Версия PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `csv`
--

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `product_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `quantity`
--

CREATE TABLE `quantity` (
  `q_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `wh_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `warehouses`
--

CREATE TABLE `warehouses` (
  `wh_id` int(11) NOT NULL,
  `warehouses` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Индексы таблицы `quantity`
--
ALTER TABLE `quantity`
  ADD PRIMARY KEY (`q_id`);

--
-- Индексы таблицы `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`wh_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=380;
--
-- AUTO_INCREMENT для таблицы `quantity`
--
ALTER TABLE `quantity`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT для таблицы `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `wh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=743;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
