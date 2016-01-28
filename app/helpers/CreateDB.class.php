<?php

class CreateDB{
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function createDB($db = 'newshop'){
        $this->db->exec("
--
-- База данных: `newshop`
--
CREATE SCHEMA IF NOT EXISTS `$db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `address_UNIQUE` (`address`),
  KEY `fk_address_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(40) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(1) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_comment_user_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) DEFAULT NULL,
  `main` tinyint(1) DEFAULT '0',
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_image_product_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL,
  `status` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_order_user_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `phone`
--

CREATE TABLE IF NOT EXISTS `phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `number` varchar(45) DEFAULT NULL,
  `number_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `spec` text,
  `price` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `subcategory_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `fk_product_subcategory_idx` (`subcategory_id`),
  KEY `fk_product_category_idx` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory_name` varchar(40) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subcategory_category_idx` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `full_name` varchar(45) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `validated` tinyint(1) DEFAULT NULL,
  `validate_key` varchar(100) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `fk_phone_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `subcategory`
--
ALTER TABLE `subcategory`
  ADD CONSTRAINT `fk_subcategory_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;            
  ");
    }
}