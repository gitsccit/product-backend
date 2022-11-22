-- MySQL dump 10.13  Distrib 8.0.31, for macos12 (x86_64)
--
-- Host: localhost    Database: product_backend
-- ------------------------------------------------------
-- Server version	5.6.47.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `active_backend_database`
--

DROP TABLE IF EXISTS `active_backend_database`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `active_backend_database`
(
    `name`      varchar(30) NOT NULL,
    `timestamp` timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners`
(
    `id`         int(10) unsigned               NOT NULL AUTO_INCREMENT,
    `image_id`   int(10) unsigned                        DEFAULT NULL COMMENT 'app server files id',
    `tile_id`    int(10) unsigned                        DEFAULT NULL COMMENT 'app server files id',
    `horizontal` enum ('left','center','right') NOT NULL DEFAULT 'left',
    `vertical`   enum ('top','middle','bottom') NOT NULL DEFAULT 'middle',
    `style`      enum ('tworow','onerow')       NOT NULL DEFAULT 'tworow',
    `sort`       int(10) unsigned               NOT NULL DEFAULT '0',
    `timestamp`  timestamp                      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bucket_categories`
--

DROP TABLE IF EXISTS `bucket_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bucket_categories`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
    `parent_id` int(10) unsigned          DEFAULT NULL,
    `tab_id`    int(10) unsigned          DEFAULT NULL,
    `name`      varchar(80)      NOT NULL,
    `sort`      int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_bucket_categories_bucket_categories` (`parent_id`),
    CONSTRAINT `FK_bucket_categories_bucket_categories` FOREIGN KEY (`parent_id`) REFERENCES `bucket_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buckets`
--

DROP TABLE IF EXISTS `buckets`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buckets`
(
    `id`                 int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `bucket_category_id` int(10) unsigned  NOT NULL,
    `tab_id`             int(10) unsigned           DEFAULT NULL,
    `plugin_id`          int(10) unsigned           DEFAULT NULL,
    `name`               varchar(80)                DEFAULT NULL COMMENT 'displayed in configurator; null to use top level category name',
    `description`        varchar(80)       NOT NULL COMMENT 'internal description for prodman',
    `multiple`           enum ('yes','no') NOT NULL DEFAULT 'no',
    `hidden`             enum ('yes','no') NOT NULL DEFAULT 'no',
    `compare`            enum ('yes','no') NOT NULL DEFAULT 'no',
    `notes`              text,
    `sort`               int(10) unsigned  NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_buckets_bucket_categories` (`bucket_category_id`),
    CONSTRAINT `FK_buckets_bucket_categories` FOREIGN KEY (`bucket_category_id`) REFERENCES `bucket_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4 COMMENT ='need to provide an include of related script code; today "notes" is processed as PHP code but this isn''t compliant';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buckets_groups`
--

DROP TABLE IF EXISTS `buckets_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buckets_groups`
(
    `bucket_id` int(10) unsigned NOT NULL,
    `group_id`  int(10) unsigned NOT NULL,
    KEY `FK_buckets_bucket_groups_bucket_groups` (`group_id`),
    KEY `FK_buckets_bucket_groups_buckets` (`bucket_id`),
    CONSTRAINT `FK_buckets_bucket_groups_bucket_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_buckets_bucket_groups_buckets` FOREIGN KEY (`bucket_id`) REFERENCES `buckets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customer_bom_detail_additional_skus`
--

DROP TABLE IF EXISTS `customer_bom_detail_additional_skus`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_bom_detail_additional_skus`
(
    `id`                     int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `customer_bom_detail_id` int(10) unsigned    NOT NULL,
    `sage_itemcode`          varchar(30)         NOT NULL,
    `quantity`               smallint(6)   DEFAULT NULL,
    `comment`                varchar(2048) DEFAULT NULL,
    `sort`                   tinyint(3) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_customer_bom_detail_additional_skus_customer_bom_details` (`customer_bom_detail_id`),
    CONSTRAINT `FK_customer_bom_detail_additional_skus_customer_bom_details` FOREIGN KEY (`customer_bom_detail_id`) REFERENCES `customer_bom_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customer_bom_details`
--

DROP TABLE IF EXISTS `customer_bom_details`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_bom_details`
(
    `id`              int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `customer_bom_id` int(10) unsigned    NOT NULL,
    `sequence`        tinyint(3) unsigned NOT NULL,
    `option`          tinyint(3) unsigned NOT NULL,
    `sage_itemcode`   varchar(30)         NOT NULL,
    `quantity`        smallint(5) unsigned         DEFAULT NULL,
    `comment`         varchar(2048)                DEFAULT NULL,
    `price`           double(8, 2)        NOT NULL DEFAULT '0.00',
    PRIMARY KEY (`id`),
    KEY `FK_customer_bom_details_customer_boms` (`customer_bom_id`),
    CONSTRAINT `FK_customer_bom_details_customer_boms` FOREIGN KEY (`customer_bom_id`) REFERENCES `customer_boms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customer_boms`
--

DROP TABLE IF EXISTS `customer_boms`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_boms`
(
    `id`                   int(10) unsigned      NOT NULL AUTO_INCREMENT,
    `customer_id`          int(10) unsigned      NOT NULL,
    `customer_category_id` int(10) unsigned               DEFAULT NULL,
    `name`                 varchar(60)           NOT NULL,
    `description`          text,
    `location_id`          int(10) unsigned               DEFAULT NULL,
    `image_id`             int(10) unsigned               DEFAULT NULL,
    `bstock`               enum ('yes','no')     NOT NULL DEFAULT 'no',
    `price`                double(8, 2) unsigned NOT NULL,
    `palletship`           enum ('yes','no')     NOT NULL DEFAULT 'no',
    `weight`               double(7, 2) unsigned NOT NULL,
    `length`               double(6, 2)          NOT NULL,
    `width`                double(6, 2)          NOT NULL,
    `height`               double(6, 2)          NOT NULL,
    `active`               enum ('yes','no')              DEFAULT 'no',
    `date_added`           timestamp             NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `timestamp`            timestamp             NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_customer_boms_customer_categories` (`customer_category_id`),
    KEY `FK_customer_boms_customers` (`customer_id`),
    KEY `FK_customer_boms_locations` (`location_id`),
    CONSTRAINT `FK_customer_boms_customer_categories` FOREIGN KEY (`customer_category_id`) REFERENCES `customer_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_customer_boms_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_customer_boms_locations` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customer_categories`
--

DROP TABLE IF EXISTS `customer_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_categories`
(
    `id`          int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `parent_id`   int(10) unsigned           DEFAULT NULL,
    `customer_id` int(10) unsigned  NOT NULL,
    `active`      enum ('yes','no') NOT NULL DEFAULT 'yes',
    `children`    int(10) unsigned  NOT NULL DEFAULT '0',
    `name`        varchar(80)       NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_customer_categories_customers` (`customer_id`),
    KEY `FK_customer_categories_customer_categories` (`parent_id`),
    CONSTRAINT `FK_customer_categories_customer_categories` FOREIGN KEY (`parent_id`) REFERENCES `customer_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_customer_categories_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customer_products`
--

DROP TABLE IF EXISTS `customer_products`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_products`
(
    `id`                   int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `customer_id`          int(10) unsigned  NOT NULL,
    `customer_category_id` int(10) unsigned           DEFAULT NULL,
    `product_id`           int(10) unsigned           DEFAULT NULL,
    `sage_itemcode`        varchar(30)                DEFAULT NULL,
    `notes`                text,
    `show_stock`           enum ('yes','no') NOT NULL DEFAULT 'no',
    `active`               enum ('yes','no') NOT NULL DEFAULT 'no',
    `date_added`           timestamp         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `timestamp`            timestamp         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_customer_products_customer_categories` (`customer_category_id`),
    KEY `FK_customer_products_customers` (`customer_id`),
    KEY `FK_customer_products_products` (`product_id`),
    CONSTRAINT `FK_customer_products_customer_categories` FOREIGN KEY (`customer_category_id`) REFERENCES `customer_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_customer_products_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_customer_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `perspective_id` int(10) unsigned DEFAULT NULL,
    `name`           varchar(50)      NOT NULL,
    `crm_account`    int(10) unsigned DEFAULT NULL,
    `sage_customer`  varchar(23)      DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_customers_perspectives` (`perspective_id`),
    CONSTRAINT `FK_customers_perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries`
(
    `id`                       int(10) unsigned NOT NULL AUTO_INCREMENT,
    `product_gallery_image_id` int(10) unsigned DEFAULT NULL,
    `browse_gallery_image_id`  int(10) unsigned DEFAULT NULL,
    `system_gallery_image_id`  int(10) unsigned DEFAULT NULL,
    `name`                     varchar(120)     NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_galleries_gallery_images` (`product_gallery_image_id`),
    KEY `FK_galleries_gallery_images_2` (`browse_gallery_image_id`),
    KEY `FK_galleries_gallery_images_3` (`system_gallery_image_id`),
    CONSTRAINT `FK_galleries_gallery_images` FOREIGN KEY (`product_gallery_image_id`) REFERENCES `gallery_images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_galleries_gallery_images_2` FOREIGN KEY (`browse_gallery_image_id`) REFERENCES `gallery_images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_galleries_gallery_images_3` FOREIGN KEY (`system_gallery_image_id`) REFERENCES `gallery_images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_images`
(
    `id`         int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `gallery_id` int(10) unsigned  NOT NULL,
    `file_id`    int(10) unsigned  NOT NULL COMMENT 'app files id',
    `active`     enum ('yes','no') NOT NULL DEFAULT 'yes',
    `sort`       int(10) unsigned  NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_gallery_images_galleries` (`gallery_id`),
    CONSTRAINT `FK_gallery_images_galleries` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `generics`
--

DROP TABLE IF EXISTS `generics`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `generics`
(
    `id`               int(10) unsigned                 NOT NULL AUTO_INCREMENT,
    `product_id`       int(10) unsigned                 NOT NULL,
    `sage_itemcode`    varchar(30)                      NOT NULL,
    `cost`             double(8, 2) unsigned            NOT NULL DEFAULT '0.00',
    `cost_maintenance` enum ('manual','channel','sage') NOT NULL DEFAULT 'manual',
    `prioritize`       enum ('yes','no')                NOT NULL DEFAULT 'no',
    `date_added`       timestamp                        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `timestamp`        timestamp                        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_generics_products` (`product_id`),
    CONSTRAINT `FK_generics_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `generics_products`
--

DROP TABLE IF EXISTS `generics_products`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `generics_products`
(
    `generic_id` int(10) unsigned NOT NULL,
    `product_id` int(10) unsigned NOT NULL,
    KEY `FK_generics_products_generics` (`generic_id`),
    KEY `FK_generics_products_products` (`product_id`),
    CONSTRAINT `FK_generics_products_generics` FOREIGN KEY (`generic_id`) REFERENCES `generics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_generics_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_items`
--

DROP TABLE IF EXISTS `group_items`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_items`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
    `group_id`   int(10) unsigned NOT NULL,
    `product_id` int(10) unsigned DEFAULT NULL,
    `system_id`  int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_group_items_groups` (`group_id`),
    KEY `FK_group_items_products` (`product_id`),
    KEY `FK_group_items_systems` (`system_id`),
    CONSTRAINT `FK_group_items_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_group_items_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_group_items_systems` FOREIGN KEY (`system_id`) REFERENCES `systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups`
(
    `id`     int(10) unsigned       NOT NULL AUTO_INCREMENT,
    `name`   varchar(80)            NOT NULL,
    `method` enum ('manual','auto') NOT NULL DEFAULT 'manual',
    `sort`   int(10) unsigned       NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `icons`
--

DROP TABLE IF EXISTS `icons`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `icons`
(
    `id`        int(10) unsigned                           NOT NULL AUTO_INCREMENT,
    `name`      varchar(50)                                NOT NULL,
    `image_id`  int(10) unsigned                                    DEFAULT NULL COMMENT 'app server file id',
    `style`     enum ('lowerleft','middleleft','topright') NOT NULL DEFAULT 'lowerleft',
    `sort`      int(10) unsigned                           NOT NULL DEFAULT '0',
    `timestamp` timestamp                                  NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `icons_kits`
--

DROP TABLE IF EXISTS `icons_kits`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `icons_kits`
(
    `icon_id` int(10) unsigned NOT NULL,
    `kit_id`  int(10) unsigned NOT NULL,
    KEY `FK_icons_kits_icons` (`icon_id`),
    KEY `FK_icons_kits_kits` (`kit_id`),
    CONSTRAINT `FK_icons_kits_icons` FOREIGN KEY (`icon_id`) REFERENCES `icons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_icons_kits_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kit_buckets`
--

DROP TABLE IF EXISTS `kit_buckets`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kit_buckets`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
    `kit_id`    int(10) unsigned NOT NULL,
    `bucket_id` int(10) unsigned NOT NULL,
    `quantity`  varchar(100)     NOT NULL,
    `minqty`    tinyint(3) unsigned DEFAULT NULL,
    `maxqty`    tinyint(3) unsigned DEFAULT NULL,
    `notes`     text,
    PRIMARY KEY (`id`),
    KEY `FK_kit_buckets_kits` (`kit_id`),
    KEY `FK_kit_buckets_buckets` (`bucket_id`),
    CONSTRAINT `FK_kit_buckets_buckets` FOREIGN KEY (`bucket_id`) REFERENCES `buckets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_kit_buckets_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kit_items`
--

DROP TABLE IF EXISTS `kit_items`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kit_items`
(
    `id`            int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `kit_id`        int(10) unsigned  NOT NULL,
    `group_item_id` int(10) unsigned  NOT NULL,
    `active`        enum ('yes','no') NOT NULL DEFAULT 'no',
    PRIMARY KEY (`id`),
    KEY `FK_kit_items_kits` (`kit_id`),
    KEY `FK_kit_items_bucket_items` (`group_item_id`),
    CONSTRAINT `FK_kit_items_bucket_items` FOREIGN KEY (`group_item_id`) REFERENCES `group_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_kit_items_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kit_option_code_items`
--

DROP TABLE IF EXISTS `kit_option_code_items`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kit_option_code_items`
(
    `id`                 int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `kit_option_code_id` int(10) unsigned    NOT NULL,
    `kit_item_id`        int(10) unsigned    NOT NULL,
    `position`           tinyint(3) unsigned NOT NULL,
    `part_number`        varchar(20) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_kit_option_code_items_kit_option_codes` (`kit_option_code_id`),
    KEY `FK_kit_option_code_items_kit_items` (`kit_item_id`),
    CONSTRAINT `FK_kit_option_code_items_kit_items` FOREIGN KEY (`kit_item_id`) REFERENCES `kit_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_kit_option_code_items_kit_option_codes` FOREIGN KEY (`kit_option_code_id`) REFERENCES `kit_option_codes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kit_option_codes`
--

DROP TABLE IF EXISTS `kit_option_codes`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kit_option_codes`
(
    `id`          int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `kit_id`      int(10) unsigned    NOT NULL,
    `part_number` varchar(50)         NOT NULL,
    `positions`   tinyint(3) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_kit_option_codes_kits` (`kit_id`),
    CONSTRAINT `FK_kit_option_codes_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kit_rule_details`
--

DROP TABLE IF EXISTS `kit_rule_details`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kit_rule_details`
(
    `id`            int(10) unsigned                                                                                    NOT NULL AUTO_INCREMENT,
    `kit_rule_id`   int(10) unsigned                                                                                    NOT NULL,
    `logic`         enum ('AND','OR','(',')','BUCKET_SELECTED','BUCKET_QUANTITY','PRODUCT_SELECTED','PRODUCT_QUANTITY') NOT NULL,
    `relation`      enum ('=','!=','<','<=','>=','>') DEFAULT NULL,
    `value`         int(10) unsigned                  DEFAULT NULL,
    `bucket_id`     int(10) unsigned                  DEFAULT NULL,
    `group_item_id` int(10) unsigned                  DEFAULT NULL,
    `sort`          int(10) unsigned                                                                                    NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_system_rule_details_group_items` (`group_item_id`),
    KEY `FK_system_rule_details_buckets` (`bucket_id`),
    KEY `FK_system_rule_details_system_rules` (`kit_rule_id`) USING BTREE,
    CONSTRAINT `FK_kit_rule_details_buckets` FOREIGN KEY (`bucket_id`) REFERENCES `buckets` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_kit_rule_details_group_items` FOREIGN KEY (`group_item_id`) REFERENCES `group_items` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_kit_rule_details_kit_rules` FOREIGN KEY (`kit_rule_id`) REFERENCES `kit_rules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kit_rules`
--

DROP TABLE IF EXISTS `kit_rules`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kit_rules`
(
    `id`          int(10) unsigned        NOT NULL AUTO_INCREMENT,
    `kit_id`      int(10) unsigned        NOT NULL,
    `name`        varchar(80)             NOT NULL,
    `action`      set ('WARNING','ERROR') NOT NULL,
    `description` text,
    PRIMARY KEY (`id`),
    KEY `FK_system_rules_systems` (`kit_id`) USING BTREE,
    CONSTRAINT `FK_kit_rules_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kits`
--

DROP TABLE IF EXISTS `kits`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kits`
(
    `id`             int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `name`           varchar(80)         NOT NULL,
    `build_time`     tinyint(3) unsigned NOT NULL DEFAULT '3',
    `sage_itemcode`  varchar(30)         NOT NULL DEFAULT 'KTBASIC',
    `product_rules`  enum ('yes','no')   NOT NULL DEFAULT 'yes',
    `sku_rules`      enum ('yes','no')   NOT NULL DEFAULT 'yes',
    `noise_level`    enum ('yes','no')   NOT NULL DEFAULT 'no',
    `power_estimate` enum ('yes','no')   NOT NULL DEFAULT 'no',
    `pallet_ship`    enum ('yes','no')   NOT NULL DEFAULT 'no',
    `spares_kit`     enum ('yes','no')            DEFAULT NULL,
    `ship_from_id`   int(10) unsigned             DEFAULT NULL,
    `ship_box_id`    int(10) unsigned             DEFAULT NULL,
    `length`         double(6, 2) unsigned        DEFAULT NULL,
    `width`          double(6, 2) unsigned        DEFAULT NULL,
    `height`         double(6, 2) unsigned        DEFAULT NULL,
    `active`         enum ('yes','no')   NOT NULL DEFAULT 'no',
    `date_added`     timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `timestamp`      timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_kits_locations` (`ship_from_id`),
    KEY `FK_kits_ship_boxes` (`ship_box_id`),
    CONSTRAINT `FK_kits_locations` FOREIGN KEY (`ship_from_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_kits_ship_boxes` FOREIGN KEY (`ship_box_id`) REFERENCES `ship_boxes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kits_plugins`
--

DROP TABLE IF EXISTS `kits_plugins`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kits_plugins`
(
    `kit_id`    int(10) unsigned NOT NULL,
    `plugin_id` int(10) unsigned NOT NULL,
    KEY `FK_kits_plugins_kits` (`kit_id`),
    KEY `FK_kits_plugins_plugins` (`plugin_id`),
    CONSTRAINT `FK_kits_plugins_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_kits_plugins_plugins` FOREIGN KEY (`plugin_id`) REFERENCES `plugins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kits_tags`
--

DROP TABLE IF EXISTS `kits_tags`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kits_tags`
(
    `id`     int(10) unsigned NOT NULL AUTO_INCREMENT,
    `kit_id` int(10) unsigned NOT NULL,
    `tag_id` int(10) unsigned NOT NULL,
    `value`  varchar(20) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_kits_tags_kits` (`kit_id`),
    KEY `FK_kits_tags_tags` (`tag_id`),
    CONSTRAINT `FK_kits_tags_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_kits_tags_tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`                varchar(50)      NOT NULL,
    `postal_code`         varchar(10) DEFAULT NULL,
    `country_code`        varchar(2)       NOT NULL,
    `sage_warehouse_code` varchar(3)  DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manufacturers`
--

DROP TABLE IF EXISTS `manufacturers`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manufacturers`
(
    `id`                 int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`               varchar(50)      NOT NULL,
    `countryoforigin_id` int(10) unsigned DEFAULT NULL,
    `image_id`           int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_manufacturers_locations` (`countryoforigin_id`),
    CONSTRAINT `FK_manufacturers_locations` FOREIGN KEY (`countryoforigin_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perspectives`
--

DROP TABLE IF EXISTS `perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perspectives`
(
    `id`     int(10) unsigned          NOT NULL AUTO_INCREMENT,
    `name`   varchar(80)               NOT NULL,
    `active` enum ('yes','no')         NOT NULL DEFAULT 'no',
    `type`   enum ('store','customer') NOT NULL DEFAULT 'store',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4 COMMENT ='an abstract way of grouping products, categories, and price levels for use by stores and customers';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `plugin_perspectives`
--

DROP TABLE IF EXISTS `plugin_perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plugin_perspectives`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `perspective_id` int(10) unsigned NOT NULL,
    `plugin_id`      int(10) unsigned NOT NULL,
    `name`           varchar(50)       DEFAULT NULL,
    `description`    varchar(250)      DEFAULT NULL,
    `active`         enum ('yes','no') DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_plugin_perspectives_perspectives` (`perspective_id`),
    KEY `FK_plugin_perspectives_plugins` (`plugin_id`),
    CONSTRAINT `FK_plugin_perspectives_perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_plugin_perspectives_plugins` FOREIGN KEY (`plugin_id`) REFERENCES `plugins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `plugins`
--

DROP TABLE IF EXISTS `plugins`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plugins`
(
    `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(50)      NOT NULL,
    `description` varchar(250)      DEFAULT NULL,
    `include`     varchar(250)      DEFAULT NULL,
    `active`      enum ('yes','no') DEFAULT 'no',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `price_level_perspectives`
--

DROP TABLE IF EXISTS `price_level_perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price_level_perspectives`
(
    `id`             int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `perspective_id` int(10) unsigned  NOT NULL,
    `price_level_id` int(10) unsigned  NOT NULL,
    `active`         enum ('yes','no') NOT NULL DEFAULT 'no',
    PRIMARY KEY (`id`),
    KEY `FK_price_level_perspectives_perspectives` (`perspective_id`),
    KEY `FK_price_level_perspectives_price_levels` (`price_level_id`),
    CONSTRAINT `FK_price_level_perspectives_perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_price_level_perspectives_price_levels` FOREIGN KEY (`price_level_id`) REFERENCES `price_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `price_levels`
--

DROP TABLE IF EXISTS `price_levels`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `price_levels`
(
    `id`     int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`   varchar(30)      NOT NULL,
    `markup` int(10) unsigned NOT NULL,
    `sort`   int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_additional_skus`
--

DROP TABLE IF EXISTS `product_additional_skus`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_additional_skus`
(
    `id`            int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `product_id`    int(10) unsigned             DEFAULT NULL,
    `quantity`      tinyint(3) unsigned NOT NULL DEFAULT '1',
    `sage_itemcode` varchar(30)                  DEFAULT NULL,
    `sage_comment`  varchar(250)                 DEFAULT NULL,
    `sort`          int(10) unsigned    NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_product_additional_skus_products` (`product_id`),
    CONSTRAINT `FK_product_additional_skus_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_categories`
(
    `id`                   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `parent_id`            int(10) unsigned          DEFAULT NULL,
    `url`                  varchar(80)      NOT NULL,
    `name`                 varchar(80)      NOT NULL,
    `description`          varchar(250)     NOT NULL,
    `active`               enum ('yes','no')         DEFAULT NULL,
    `gallery_priority`     int(10) unsigned NOT NULL DEFAULT '0',
    `show_related_systems` enum ('yes','no')         DEFAULT 'no',
    `children`             int(10) unsigned NOT NULL DEFAULT '0',
    `sort`                 int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_product_categories_product_categories` (`parent_id`),
    CONSTRAINT `FK_product_categories_product_categories` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_category_perspectives`
--

DROP TABLE IF EXISTS `product_category_perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_category_perspectives`
(
    `id`                   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `perspective_id`       int(10) unsigned NOT NULL,
    `product_category_id`  int(10) unsigned NOT NULL,
    `url`                  varchar(80)       DEFAULT NULL,
    `name`                 varchar(80)       DEFAULT NULL,
    `short_description`    varchar(50)       DEFAULT NULL,
    `description`          varchar(250)      DEFAULT NULL,
    `classification`       varchar(50)       DEFAULT NULL,
    `active`               enum ('yes','no') DEFAULT NULL,
    `show_related_systems` enum ('yes','no') DEFAULT NULL,
    `children`             int(10) unsigned  DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_product_category_perspectives_perspectives` (`perspective_id`),
    KEY `FK_product_category_perspectives_product_categories` (`product_category_id`),
    CONSTRAINT `FK_product_category_perspectives_perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_product_category_perspectives_product_categories` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_category_relations`
--

DROP TABLE IF EXISTS `product_category_relations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_category_relations`
(
    `product_category_id`         int(10) unsigned NOT NULL,
    `related_product_category_id` int(10) unsigned NOT NULL,
    KEY `FK_product_category_relations_product_categories` (`product_category_id`),
    KEY `FK_product_category_relations_product_categories_2` (`related_product_category_id`),
    CONSTRAINT `FK_product_category_relations_product_categories` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_product_category_relations_product_categories_2` FOREIGN KEY (`related_product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_perspectives`
--

DROP TABLE IF EXISTS `product_perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_perspectives`
(
    `id`                   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `perspective_id`       int(10) unsigned NOT NULL,
    `product_id`           int(10) unsigned NOT NULL,
    `url`                  varchar(80)       DEFAULT NULL,
    `name`                 varchar(120)      DEFAULT NULL,
    `description`          text,
    `show_related_systems` enum ('yes','no') DEFAULT NULL,
    `active`               enum ('yes','no') DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK__perspectives` (`perspective_id`),
    KEY `FK_product_perspectives_products` (`product_id`),
    CONSTRAINT `FK__perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_product_perspectives_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_price_levels`
--

DROP TABLE IF EXISTS `product_price_levels`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_price_levels`
(
    `id`             int(10) unsigned                  NOT NULL AUTO_INCREMENT,
    `price_level_id` int(10) unsigned                           DEFAULT NULL,
    `product_id`     int(10) unsigned                           DEFAULT NULL,
    `logic`          enum ('default','markup','fixed') NOT NULL DEFAULT 'default',
    `value`          double(11, 2)                              DEFAULT NULL,
    `price`          double(11, 2)                     NOT NULL DEFAULT '0.00' COMMENT 'this field is derived from fixedprice, or cost * markup',
    `timestamp`      timestamp                         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_product_price_levels_price_levels` (`price_level_id`),
    KEY `FK_product_price_levels_products` (`product_id`),
    CONSTRAINT `FK_product_price_levels_price_levels` FOREIGN KEY (`price_level_id`) REFERENCES `price_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_product_price_levels_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_replacements`
--

DROP TABLE IF EXISTS `product_replacements`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_replacements`
(
    `id`                     int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`                   varchar(120)     DEFAULT NULL,
    `product_category_path`  varchar(240)     DEFAULT NULL,
    `manufacturer`           varchar(50)      DEFAULT NULL,
    `part_number`            varchar(40)      DEFAULT NULL,
    `replacement_product_id` int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK__products` (`replacement_product_id`),
    CONSTRAINT `FK__products` FOREIGN KEY (`replacement_product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_rules`
--

DROP TABLE IF EXISTS `product_rules`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_rules`
(
    `id`                 int(10) unsigned                 NOT NULL AUTO_INCREMENT,
    `product_id`         int(10) unsigned                 NOT NULL,
    `name`               varchar(80)                      NOT NULL,
    `logic`              enum ('SELECTED','SELECTED_QTY') NOT NULL,
    `relation`           enum ('=','!=','<','<=','>=','>') DEFAULT NULL,
    `quantity`           tinyint(4)                        DEFAULT NULL,
    `condition`          enum ('OR','AND','QTY')          NOT NULL,
    `condition_relation` enum ('=','!=','<','<=','>=','>') DEFAULT NULL,
    `condition_quantity` tinyint(4)                        DEFAULT NULL,
    `action`             enum ('WARNING','ERROR')         NOT NULL,
    `description`        text,
    PRIMARY KEY (`id`),
    KEY `FK_product_rules_products` (`product_id`),
    CONSTRAINT `FK_product_rules_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_rules_products`
--

DROP TABLE IF EXISTS `product_rules_products`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_rules_products`
(
    `product_rule_id` int(10) unsigned NOT NULL,
    `product_id`      int(10) unsigned NOT NULL,
    KEY `FK_product_rules_products_product_rules` (`product_rule_id`),
    KEY `FK_product_rules_products_products` (`product_id`),
    CONSTRAINT `FK_product_rules_products_product_rules` FOREIGN KEY (`product_rule_id`) REFERENCES `product_rules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_product_rules_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_statuses`
--

DROP TABLE IF EXISTS `product_statuses`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_statuses`
(
    `id`      int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`    varchar(50)               DEFAULT NULL,
    `warning` enum ('yes','no')         DEFAULT 'no',
    `sowg`    enum ('yes','no')         DEFAULT 'no',
    `sort`    int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products`
(
    `id`                   int(10) unsigned                           NOT NULL AUTO_INCREMENT,
    `url`                  varchar(80)                                NOT NULL,
    `name`                 varchar(120)                               NOT NULL DEFAULT 'New Product',
    `description`          text,
    `product_category_id`  int(10) unsigned                                    DEFAULT NULL,
    `gallery_id`           int(10) unsigned                                    DEFAULT NULL,
    `manufacturer_id`      int(10) unsigned                                    DEFAULT NULL,
    `part_number`          varchar(40)                                NOT NULL,
    `sage_itemcode`        varchar(30)                                         DEFAULT NULL,
    `upc`                  varchar(14)                                         DEFAULT NULL,
    `status_id`            int(10) unsigned                                    DEFAULT NULL,
    `status_text`          varchar(130)                                        DEFAULT NULL,
    `tax`                  enum ('standard','service','nontax')                DEFAULT 'standard',
    `cost`                 double(8, 2)                               NOT NULL DEFAULT '0.00',
    `cost_maintenance`     enum ('manual','channel','sage')           NOT NULL DEFAULT 'manual',
    `generic`              enum ('yes','no')                          NOT NULL DEFAULT 'no',
    `noise_level`          tinyint(1)                                          DEFAULT '0',
    `generic_relations`    enum ('require','exclude')                 NOT NULL DEFAULT 'require',
    `kit_price_percent`    tinyint(3) unsigned                                 DEFAULT NULL,
    `show_related_systems` enum ('yes','no')                                   DEFAULT NULL,
    `ship_box_id`          int(10) unsigned                                    DEFAULT NULL,
    `ship_type`            enum ('standard','solo','combine','email') NOT NULL DEFAULT 'standard',
    `weight`               double(7, 2)                               NOT NULL DEFAULT '1.00',
    `length`               double(6, 2) unsigned                               DEFAULT NULL,
    `width`                double(6, 2) unsigned                               DEFAULT NULL,
    `height`               double(6, 2) unsigned                               DEFAULT NULL,
    `country_of_origin_id` int(10) unsigned                                    DEFAULT NULL,
    `ship_from_id`         int(10) unsigned                                    DEFAULT NULL,
    `lithium_battery`      enum ('yes','no')                          NOT NULL DEFAULT 'no',
    `watts`                double(6, 2) unsigned                               DEFAULT NULL,
    `system_use`           smallint(5) unsigned                       NOT NULL DEFAULT '0',
    `system_start`         smallint(5) unsigned                       NOT NULL DEFAULT '0',
    `active`               enum ('yes','no')                          NOT NULL DEFAULT 'no',
    `sort`                 int(10)                                    NOT NULL DEFAULT '0',
    `date_eol`             date                                                DEFAULT NULL,
    `date_added`           timestamp                                  NULL     DEFAULT CURRENT_TIMESTAMP,
    `timestamp`            timestamp                                  NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_products_locations` (`country_of_origin_id`),
    KEY `FK_products_locations_2` (`ship_from_id`),
    KEY `FK_products_product_categories` (`product_category_id`),
    KEY `FK_products_manufacturers` (`manufacturer_id`),
    KEY `FK_products_statuses` (`status_id`),
    KEY `FK_products_ship_boxes` (`ship_box_id`),
    KEY `url` (`url`),
    KEY `FK_products_galleries` (`gallery_id`),
    CONSTRAINT `FK_products_galleries` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_products_locations` FOREIGN KEY (`country_of_origin_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_products_locations_2` FOREIGN KEY (`ship_from_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_products_manufacturers` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_products_product_categories` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_products_ship_boxes` FOREIGN KEY (`ship_box_id`) REFERENCES `ship_boxes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_products_statuses` FOREIGN KEY (`status_id`) REFERENCES `product_statuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_relations`
--

DROP TABLE IF EXISTS `products_relations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_relations`
(
    `product_id` int(10) unsigned NOT NULL,
    `related_id` int(10) unsigned NOT NULL,
    KEY `FK_products_relations_products` (`product_id`),
    KEY `FK_products_relations_products_2` (`related_id`),
    CONSTRAINT `FK_products_relations_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_products_relations_products_2` FOREIGN KEY (`related_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `raid_maps`
--

DROP TABLE IF EXISTS `raid_maps`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `raid_maps`
(
    `id`                  int(10) unsigned                     NOT NULL AUTO_INCREMENT,
    `product_category_id` int(10) unsigned                                  DEFAULT NULL,
    `device`              enum ('Control','Drive','Backplane') NOT NULL,
    `interface`           enum ('SATA','SATA6','SAS','SAS6','SAS12','NVMe') DEFAULT NULL,
    `interface_spec_id`   int(10) unsigned                                  DEFAULT NULL,
    `interface2_spec_id`  int(10) unsigned                                  DEFAULT NULL,
    `name_spec_id`        int(10) unsigned                                  DEFAULT NULL,
    `raid_spec_id`        int(10) unsigned                                  DEFAULT NULL,
    `ports_spec_id`       int(10) unsigned                                  DEFAULT NULL,
    `devices_spec_id`     int(10) unsigned                                  DEFAULT NULL,
    `pergroup_spec_id`    int(10) unsigned                                  DEFAULT NULL,
    `capacity_spec_id`    int(10) unsigned                                  DEFAULT NULL,
    `backplane_spec_id`   int(10) unsigned                                  DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    KEY `FK_raid_maps_product_categories` (`product_category_id`) USING BTREE,
    KEY `FK_raid_maps_specifications` (`interface_spec_id`),
    KEY `FK_raid_maps_specifications_2` (`interface2_spec_id`),
    KEY `FK_raid_maps_specifications_3` (`name_spec_id`),
    KEY `FK_raid_maps_specifications_4` (`raid_spec_id`),
    KEY `FK_raid_maps_specifications_5` (`ports_spec_id`),
    KEY `FK_raid_maps_specifications_6` (`devices_spec_id`),
    KEY `FK_raid_maps_specifications_7` (`pergroup_spec_id`),
    KEY `FK_raid_maps_specifications_8` (`capacity_spec_id`),
    KEY `FK_raid_maps_specifications_9` (`backplane_spec_id`),
    CONSTRAINT `FK_raid_maps_product_categories` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications` FOREIGN KEY (`interface_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_2` FOREIGN KEY (`interface2_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_3` FOREIGN KEY (`name_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_4` FOREIGN KEY (`raid_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_5` FOREIGN KEY (`ports_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_6` FOREIGN KEY (`devices_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_7` FOREIGN KEY (`pergroup_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_8` FOREIGN KEY (`capacity_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_raid_maps_specifications_9` FOREIGN KEY (`backplane_spec_id`) REFERENCES `specifications` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_boxes`
--

DROP TABLE IF EXISTS `ship_boxes`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ship_boxes`
(
    `id`     int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`   varchar(30)      NOT NULL,
    `length` double(6, 2) DEFAULT NULL,
    `width`  double(6, 2) DEFAULT NULL,
    `height` double(6, 2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_boxes_ship_rates`
--

DROP TABLE IF EXISTS `ship_boxes_ship_rates`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ship_boxes_ship_rates`
(
    `ship_box_id`  int(10) unsigned NOT NULL,
    `ship_rate_id` int(10) unsigned NOT NULL,
    KEY `FK_ship_boxes_ship_rates_ship_boxes` (`ship_box_id`),
    KEY `FK_ship_boxes_ship_rates_ship_rates` (`ship_rate_id`),
    CONSTRAINT `FK_ship_boxes_ship_rates_ship_boxes` FOREIGN KEY (`ship_box_id`) REFERENCES `ship_boxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_ship_boxes_ship_rates_ship_rates` FOREIGN KEY (`ship_rate_id`) REFERENCES `ship_rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_rate_ship_region_prices`
--

DROP TABLE IF EXISTS `ship_rate_ship_region_prices`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ship_rate_ship_region_prices`
(
    `id`             int(10) unsigned       NOT NULL AUTO_INCREMENT,
    `ship_rate_id`   int(10) unsigned       NOT NULL,
    `ship_region_id` int(10) unsigned       NOT NULL,
    `price`          decimal(7, 2) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_ship_rate_ship_region_prices_ship_rates` (`ship_rate_id`),
    KEY `FK_ship_rate_ship_region_prices_ship_regions` (`ship_region_id`),
    CONSTRAINT `FK_ship_rate_ship_region_prices_ship_rates` FOREIGN KEY (`ship_rate_id`) REFERENCES `ship_rates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_ship_rate_ship_region_prices_ship_regions` FOREIGN KEY (`ship_region_id`) REFERENCES `ship_regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_rates`
--

DROP TABLE IF EXISTS `ship_rates`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ship_rates`
(
    `id`           int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`         varchar(30)      NOT NULL,
    `description`  varchar(120)     NOT NULL,
    `sage_shipvia` varchar(15)      NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_region_locations`
--

DROP TABLE IF EXISTS `ship_region_locations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ship_region_locations`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `ship_region_id` int(10) unsigned NOT NULL,
    `country`        varchar(3)       NOT NULL,
    `state`          varchar(2) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_ship_region_locations_ship_regions` (`ship_region_id`),
    CONSTRAINT `FK_ship_region_locations_ship_regions` FOREIGN KEY (`ship_region_id`) REFERENCES `ship_regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ship_regions`
--

DROP TABLE IF EXISTS `ship_regions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ship_regions`
(
    `id`            int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `name`          varchar(30)       NOT NULL,
    `ship_box_only` enum ('yes','no') NOT NULL DEFAULT 'no',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sku_rule_additional_skus`
--

DROP TABLE IF EXISTS `sku_rule_additional_skus`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sku_rule_additional_skus`
(
    `id`                int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `sku_rule_id`       int(10) unsigned           DEFAULT NULL,
    `quantity`          tinyint(4)                 DEFAULT NULL,
    `sage_itemcode`     varchar(30)       NOT NULL,
    `sku_rule_group_id` int(10) unsigned           DEFAULT NULL,
    `quantity_modifier` tinyint(4)                 DEFAULT NULL,
    `sell_price`        enum ('yes','no') NOT NULL DEFAULT 'no',
    PRIMARY KEY (`id`),
    KEY `FK_sku_rule_additional_skus_sku_rule_groups` (`sku_rule_group_id`),
    KEY `FK_sku_rule_additional_skus_sku_rules` (`sku_rule_id`),
    CONSTRAINT `FK_sku_rule_additional_skus_sku_rule_groups` FOREIGN KEY (`sku_rule_group_id`) REFERENCES `sku_rule_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_sku_rule_additional_skus_sku_rules` FOREIGN KEY (`sku_rule_id`) REFERENCES `sku_rules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sku_rule_categories`
--

DROP TABLE IF EXISTS `sku_rule_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sku_rule_categories`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
    `parent_id` int(10) unsigned          DEFAULT NULL,
    `name`      varchar(80)      NOT NULL,
    `sort`      int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_sku_rule_categories_sku_rule_categories` (`parent_id`),
    CONSTRAINT `FK_sku_rule_categories_sku_rule_categories` FOREIGN KEY (`parent_id`) REFERENCES `sku_rule_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sku_rule_group_skus`
--

DROP TABLE IF EXISTS `sku_rule_group_skus`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sku_rule_group_skus`
(
    `id`                int(10) unsigned NOT NULL AUTO_INCREMENT,
    `sku_rule_group_id` int(10) unsigned NOT NULL,
    `sage_itemcode`     varchar(30)      NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_sku_rule_group_skus_sku_rule_groups` (`sku_rule_group_id`),
    CONSTRAINT `FK_sku_rule_group_skus_sku_rule_groups` FOREIGN KEY (`sku_rule_group_id`) REFERENCES `sku_rule_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sku_rule_groups`
--

DROP TABLE IF EXISTS `sku_rule_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sku_rule_groups`
(
    `id`          int(10) unsigned       NOT NULL AUTO_INCREMENT,
    `sku_rule_id` int(10) unsigned       NOT NULL,
    `method`      enum ('manual','auto') NOT NULL DEFAULT 'manual',
    `spec_id`     int(10) unsigned                DEFAULT NULL,
    `value`       varchar(20)                     DEFAULT NULL,
    `sort`        int(10) unsigned       NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sku_rules`
--

DROP TABLE IF EXISTS `sku_rules`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sku_rules`
(
    `id`                   int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `sku_rule_category_id` int(10) unsigned                  DEFAULT NULL,
    `name`                 varchar(80)       NOT NULL,
    `scheduler_notes`      text,
    `sku_rule_group_id`    int(10) unsigned                  DEFAULT NULL,
    `eval_logic`           enum ('<','<=','=','!=','>','>=') DEFAULT NULL,
    `eval_quantity`        tinyint(3) unsigned               DEFAULT NULL,
    `active`               enum ('yes','no') NOT NULL        DEFAULT 'no',
    `sort`                 int(10) unsigned  NOT NULL        DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_sku_rules_sku_rule_categories` (`sku_rule_category_id`),
    KEY `FK_sku_rules_sku_rule_groups` (`sku_rule_group_id`),
    CONSTRAINT `FK_sku_rules_sku_rule_categories` FOREIGN KEY (`sku_rule_category_id`) REFERENCES `sku_rule_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_sku_rules_sku_rule_groups` FOREIGN KEY (`sku_rule_group_id`) REFERENCES `sku_rule_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sku_rules_files`
--

DROP TABLE IF EXISTS `sku_rules_files`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sku_rules_files`
(
    `sku_rule_id` int(10) unsigned NOT NULL,
    `file_id`     int(10) unsigned NOT NULL,
    KEY `FK_sku_rules_files_sku_rules` (`sku_rule_id`),
    CONSTRAINT `FK_sku_rules_files_sku_rules` FOREIGN KEY (`sku_rule_id`) REFERENCES `sku_rules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `spare_categories`
--

DROP TABLE IF EXISTS `spare_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spare_categories`
(
    `id`       int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `name`     varchar(50)         NOT NULL,
    `quantity` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `sort`     int(10) unsigned    NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `spare_category_relations`
--

DROP TABLE IF EXISTS `spare_category_relations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spare_category_relations`
(
    `spare_category_id`   int(10) unsigned NOT NULL,
    `product_category_id` int(10) unsigned NOT NULL,
    KEY `FK_spare_category_relations_spare_categories` (`spare_category_id`),
    KEY `FK_spare_category_relations_product_categories` (`product_category_id`),
    CONSTRAINT `FK_spare_category_relations_product_categories` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_spare_category_relations_spare_categories` FOREIGN KEY (`spare_category_id`) REFERENCES `spare_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `spares`
--

DROP TABLE IF EXISTS `spares`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spares`
(
    `id`                int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `product_id`        int(10) unsigned  NOT NULL,
    `spare_category_id` int(10) unsigned  NOT NULL,
    `related_id`        int(10) unsigned  NOT NULL,
    `active`            enum ('yes','no') NOT NULL DEFAULT 'no',
    PRIMARY KEY (`id`),
    KEY `FK_spares_products` (`product_id`),
    KEY `FK_spares_spare_categories` (`spare_category_id`),
    KEY `FK_spares_products_2` (`related_id`),
    CONSTRAINT `FK_spares_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
    CONSTRAINT `FK_spares_products_2` FOREIGN KEY (`related_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
    CONSTRAINT `FK_spares_spare_categories` FOREIGN KEY (`spare_category_id`) REFERENCES `spare_categories` (`id`) ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specification_fields`
--

DROP TABLE IF EXISTS `specification_fields`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specification_fields`
(
    `id`                          int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `specification_group_id`      int(10) unsigned           DEFAULT NULL,
    `specification_unit_group_id` int(10) unsigned           DEFAULT NULL,
    `techspec`                    enum ('yes','no') NOT NULL DEFAULT 'no',
    `name`                        varchar(60)       NOT NULL,
    `label`                       varchar(8)        NOT NULL,
    `description`                 varchar(120)      NOT NULL,
    `sort`                        int(10) unsigned  NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_specification_fields_specification_groups` (`specification_group_id`),
    KEY `FK_specification_fields_specification_unit_groups` (`specification_unit_group_id`),
    CONSTRAINT `FK_specification_fields_specification_groups` FOREIGN KEY (`specification_group_id`) REFERENCES `specification_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_specification_fields_specification_unit_groups` FOREIGN KEY (`specification_unit_group_id`) REFERENCES `specification_unit_groups` (`id`) ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specification_groups`
--

DROP TABLE IF EXISTS `specification_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specification_groups`
(
    `id`          int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `name`        varchar(60)       NOT NULL,
    `reserved`    enum ('yes','no') NOT NULL DEFAULT 'no',
    `description` varchar(120)      NOT NULL,
    `sort`        int(10) unsigned  NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specification_unit_groups`
--

DROP TABLE IF EXISTS `specification_unit_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specification_unit_groups`
(
    `id`   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(30)      NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specification_units`
--

DROP TABLE IF EXISTS `specification_units`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specification_units`
(
    `id`                          int(10) unsigned NOT NULL AUTO_INCREMENT,
    `specification_unit_group_id` int(10) unsigned NOT NULL,
    `symbol`                      varchar(5)       NOT NULL,
    `name`                        varchar(30)      NOT NULL,
    `description`                 varchar(30)      NOT NULL,
    `multiplier`                  decimal(20, 4)   NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_specification_units_specification_unit_groups` (`specification_unit_group_id`),
    CONSTRAINT `FK_specification_units_specification_unit_groups` FOREIGN KEY (`specification_unit_group_id`) REFERENCES `specification_unit_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specifications`
--

DROP TABLE IF EXISTS `specifications`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specifications`
(
    `id`                     int(10) unsigned    NOT NULL AUTO_INCREMENT,
    `product_id`             int(10) unsigned    NOT NULL,
    `specification_field_id` int(10) unsigned    NOT NULL,
    `sequence`               tinyint(3) unsigned NOT NULL DEFAULT '0',
    `specification_unit_id`  int(10) unsigned             DEFAULT NULL,
    `text_value`             varchar(120)        NOT NULL,
    `unit_value`             double(10, 2)                DEFAULT NULL,
    `sort`                   double(64, 2)                DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_specifications_products` (`product_id`),
    KEY `FK_specifications_specification_fields` (`specification_field_id`),
    KEY `FK_specifications_specification_units` (`specification_unit_id`),
    CONSTRAINT `FK_specifications_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_specifications_specification_fields` FOREIGN KEY (`specification_field_id`) REFERENCES `specification_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_specifications_specification_units` FOREIGN KEY (`specification_unit_id`) REFERENCES `specification_units` (`id`) ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_categories`
--

DROP TABLE IF EXISTS `system_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_categories`
(
    `id`                int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `parent_id`         int(10) unsigned           DEFAULT NULL,
    `url`               varchar(80)       NOT NULL,
    `name`              varchar(80)       NOT NULL,
    `short_description` varchar(50)       NOT NULL,
    `description`       varchar(250)      NOT NULL,
    `classification`    varchar(50)       NOT NULL,
    `force_perspective` int(10) unsigned           DEFAULT NULL,
    `banner_id`         int(10) unsigned           DEFAULT NULL,
    `spares_kits`       enum ('yes','no') NOT NULL DEFAULT 'no',
    `active`            enum ('yes','no') NOT NULL DEFAULT 'no',
    `children`          int(10) unsigned  NOT NULL DEFAULT '0',
    `sort`              int(10) unsigned  NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_system_categories_banners` (`banner_id`),
    KEY `FK_system_categories_perspectives` (`force_perspective`),
    KEY `FK_system_categories_system_categories` (`parent_id`),
    CONSTRAINT `FK_system_categories_banners` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_system_categories_perspectives` FOREIGN KEY (`force_perspective`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_system_categories_system_categories` FOREIGN KEY (`parent_id`) REFERENCES `system_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_category_perspectives`
--

DROP TABLE IF EXISTS `system_category_perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_category_perspectives`
(
    `id`                 int(10) unsigned NOT NULL AUTO_INCREMENT,
    `perspective_id`     int(10) unsigned NOT NULL,
    `system_category_id` int(10) unsigned NOT NULL,
    `url`                varchar(80)       DEFAULT NULL,
    `name`               varchar(80)       DEFAULT NULL,
    `description`        varchar(250)      DEFAULT NULL,
    `banner_id`          int(10) unsigned  DEFAULT NULL,
    `active`             enum ('yes','no') DEFAULT NULL,
    `children`           int(10) unsigned  DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_system_category_perspectives_banners` (`banner_id`),
    KEY `FK_system_category_perspectives_perspectives` (`perspective_id`),
    KEY `FK_system_category_perspectives_system_categories` (`system_category_id`),
    CONSTRAINT `FK_system_category_perspectives_banners` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `FK_system_category_perspectives_perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_system_category_perspectives_system_categories` FOREIGN KEY (`system_category_id`) REFERENCES `system_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_items`
--

DROP TABLE IF EXISTS `system_items`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_items`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
    `system_id` int(10) unsigned NOT NULL,
    `item_id`   int(10) unsigned NOT NULL,
    `quantity`  tinyint(4)       NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_system_items_systems` (`system_id`),
    KEY `FK_system_items_bucket_items` (`item_id`),
    CONSTRAINT `FK_system_items_bucket_items` FOREIGN KEY (`item_id`) REFERENCES `group_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_system_items_systems` FOREIGN KEY (`system_id`) REFERENCES `systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_perspectives`
--

DROP TABLE IF EXISTS `system_perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_perspectives`
(
    `id`               int(10) unsigned NOT NULL AUTO_INCREMENT,
    `perspective_id`   int(10) unsigned NOT NULL,
    `system_id`        int(10) unsigned NOT NULL,
    `price_lock`       enum ('yes','no') DEFAULT NULL,
    `url`              varchar(80)       DEFAULT NULL,
    `name`             varchar(80)       DEFAULT NULL,
    `name_line_1`      varchar(30)       DEFAULT NULL,
    `name_line_2`      varchar(50)       DEFAULT NULL,
    `description`      text,
    `meta_title`       varchar(90)       DEFAULT NULL,
    `meta_keywords`    text,
    `meta_description` text,
    `category_browse`  enum ('yes','no') DEFAULT NULL,
    `active`           enum ('yes','no') DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_system_perspectives_perspectives` (`perspective_id`),
    KEY `FK_system_perspectives_systems` (`system_id`),
    CONSTRAINT `FK_system_perspectives_perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_system_perspectives_systems` FOREIGN KEY (`system_id`) REFERENCES `systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_price_levels`
--

DROP TABLE IF EXISTS `system_price_levels`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_price_levels`
(
    `id`             int(10) unsigned                  NOT NULL AUTO_INCREMENT,
    `price_level_id` int(10) unsigned                           DEFAULT NULL,
    `system_id`      int(10) unsigned                           DEFAULT NULL,
    `logic`          enum ('default','markup','fixed') NOT NULL DEFAULT 'default',
    `value`          double(11, 2)                              DEFAULT NULL,
    `fpa`            double(11, 2)                              DEFAULT NULL COMMENT 'fixed price adjustment',
    `price`          double(11, 2)                              DEFAULT NULL COMMENT 'this field is derived from fixedprice, or cost * markup',
    `timestamp`      timestamp                         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_system_price_levels_price_levels` (`price_level_id`),
    KEY `FK_system_price_levels_products` (`system_id`),
    CONSTRAINT `FK_system_price_levels_price_levels` FOREIGN KEY (`price_level_id`) REFERENCES `price_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_system_price_levels_products` FOREIGN KEY (`system_id`) REFERENCES `systems` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_replacements`
--

DROP TABLE IF EXISTS `system_replacements`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_replacements`
(
    `id`                    int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`                  varchar(80)      DEFAULT NULL,
    `system_category_path`  varchar(240)     DEFAULT NULL,
    `replacement_system_id` int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK__systems` (`replacement_system_id`),
    CONSTRAINT `FK__systems` FOREIGN KEY (`replacement_system_id`) REFERENCES `systems` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `systems`
--

DROP TABLE IF EXISTS `systems`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `systems`
(
    `id`                 int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `kit_id`             int(10) unsigned  NOT NULL,
    `system_category_id` int(10) unsigned           DEFAULT NULL,
    `configurable`       enum ('yes','no') NOT NULL DEFAULT 'yes',
    `cost`               double(11, 2)              DEFAULT NULL,
    `price_lock`         enum ('yes','no') NOT NULL DEFAULT 'no',
    `url`                varchar(80)       NOT NULL,
    `name`               varchar(80)       NOT NULL,
    `name_line_1`        varchar(30)       NOT NULL,
    `name_line_2`        varchar(50)       NOT NULL,
    `description`        text,
    `meta_title`         varchar(90)                DEFAULT NULL,
    `meta_keywords`      text,
    `meta_description`   text,
    `force_perspective`  int(10) unsigned           DEFAULT NULL,
    `category_browse`    enum ('yes','no') NOT NULL DEFAULT 'no',
    `active`             enum ('yes','no') NOT NULL DEFAULT 'no',
    `sort`               int(10) unsigned  NOT NULL DEFAULT '0',
    `date_added`         timestamp         NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `timestamp`          timestamp         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_systems_kits` (`kit_id`),
    KEY `FK_systems_perspectives` (`force_perspective`),
    KEY `FK_systems_system_categories` (`system_category_id`),
    CONSTRAINT `FK_systems_kits` FOREIGN KEY (`kit_id`) REFERENCES `kits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_systems_perspectives` FOREIGN KEY (`force_perspective`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_systems_system_categories` FOREIGN KEY (`system_category_id`) REFERENCES `system_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_perspectives`
--

DROP TABLE IF EXISTS `tab_perspectives`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_perspectives`
(
    `id`             int(10) unsigned NOT NULL,
    `perspective_id` int(10) unsigned NOT NULL,
    `tab_id`         int(10) unsigned NOT NULL,
    `name`           varchar(50)      DEFAULT NULL,
    `description`    varchar(250)     DEFAULT NULL,
    `file_id`        int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_tab_perspectives_perspectives` (`perspective_id`),
    KEY `FK_tab_perspectives_tabs` (`tab_id`),
    CONSTRAINT `FK_tab_perspectives_perspectives` FOREIGN KEY (`perspective_id`) REFERENCES `perspectives` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_tab_perspectives_tabs` FOREIGN KEY (`tab_id`) REFERENCES `tabs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tabs`
--

DROP TABLE IF EXISTS `tabs`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tabs`
(
    `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(50)               DEFAULT NULL,
    `description` varchar(250)              DEFAULT NULL,
    `file_id`     int(10) unsigned          DEFAULT NULL,
    `plugin_id`   int(10) unsigned          DEFAULT NULL,
    `sort`        int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_tabs_plugins` (`plugin_id`),
    CONSTRAINT `FK_tabs_plugins` FOREIGN KEY (`plugin_id`) REFERENCES `plugins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag_categories`
--

DROP TABLE IF EXISTS `tag_categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag_categories`
(
    `id`   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(80)      NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag_categories_tag_groups`
--

DROP TABLE IF EXISTS `tag_categories_tag_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag_categories_tag_groups`
(
    `id`              int(10) unsigned NOT NULL AUTO_INCREMENT,
    `tag_category_id` int(10) unsigned NOT NULL,
    `tag_group_id`    int(10) unsigned NOT NULL,
    `sort`            int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_tag_categories_tag_groups_tag_categories` (`tag_category_id`),
    KEY `FK_tag_categories_tag_groups_tag_groups` (`tag_group_id`),
    CONSTRAINT `FK_tag_categories_tag_groups_tag_categories` FOREIGN KEY (`tag_category_id`) REFERENCES `tag_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_tag_categories_tag_groups_tag_groups` FOREIGN KEY (`tag_group_id`) REFERENCES `tag_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag_groups`
--

DROP TABLE IF EXISTS `tag_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag_groups`
(
    `id`            int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `name`          varchar(80)       NOT NULL,
    `display_value` enum ('yes','no') NOT NULL DEFAULT 'no',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags`
(
    `id`           int(10) unsigned NOT NULL AUTO_INCREMENT,
    `tag_group_id` int(10) unsigned          DEFAULT NULL,
    `name`         varchar(50)      NOT NULL,
    `image_id`     int(10) unsigned          DEFAULT NULL,
    `sort`         int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `FK_tags_tags` (`tag_group_id`) USING BTREE,
    CONSTRAINT `FK_tags_tag_groups` FOREIGN KEY (`tag_group_id`) REFERENCES `tag_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `view_kit_browse_tags`
--

DROP TABLE IF EXISTS `view_kit_browse_tags`;
/*!50001 DROP VIEW IF EXISTS `view_kit_browse_tags`*/;
SET @saved_cs_client = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_kit_browse_tags` AS
SELECT 1 AS `kit_id`,
       1 AS `category`,
       1 AS `group`,
       1 AS `name`,
       1 AS `value`,
       1 AS `image_id`
        */;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_kit_card_tags`
--

DROP TABLE IF EXISTS `view_kit_card_tags`;
/*!50001 DROP VIEW IF EXISTS `view_kit_card_tags`*/;
SET @saved_cs_client = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_kit_card_tags` AS
SELECT 1 AS `kit_id`,
       1 AS `name`,
       1 AS `value`
        */;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_kit_tags`
--

DROP TABLE IF EXISTS `view_kit_tags`;
/*!50001 DROP VIEW IF EXISTS `view_kit_tags`*/;
SET @saved_cs_client = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_kit_tags` AS
SELECT 1 AS `kit_id`,
       1 AS `category`,
       1 AS `group`,
       1 AS `name`,
       1 AS `value`,
       1 AS `image_id`
        */;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_product_browse_images`
--

DROP TABLE IF EXISTS `view_product_browse_images`;
/*!50001 DROP VIEW IF EXISTS `view_product_browse_images`*/;
SET @saved_cs_client = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_product_browse_images` AS
SELECT 1 AS `product_id`,
       1 AS `image_id`
        */;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_system_browse_images`
--

DROP TABLE IF EXISTS `view_system_browse_images`;
/*!50001 DROP VIEW IF EXISTS `view_system_browse_images`*/;
SET @saved_cs_client = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_system_browse_images` AS
SELECT 1 AS `system_id`,
       1 AS `image_id`
        */;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_system_system_images`
--

DROP TABLE IF EXISTS `view_system_system_images`;
/*!50001 DROP VIEW IF EXISTS `view_system_system_images`*/;
SET @saved_cs_client = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_system_system_images` AS
SELECT 1 AS `system_id`,
       1 AS `image_id`
        */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_kit_browse_tags`
--

/*!50001 DROP VIEW IF EXISTS `view_kit_browse_tags`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8mb4 */;
/*!50001 SET character_set_results = utf8mb4 */;
/*!50001 SET collation_connection = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`scc`@`%` SQL SECURITY DEFINER */ /*!50001 VIEW `view_kit_browse_tags` AS
select `view_kit_tags`.`kit_id`   AS `kit_id`,
       `view_kit_tags`.`category` AS `category`,
       `view_kit_tags`.`group`    AS `group`,
       `view_kit_tags`.`name`     AS `name`,
       `view_kit_tags`.`value`    AS `value`,
       `view_kit_tags`.`image_id` AS `image_id`
from `view_kit_tags`
where (`view_kit_tags`.`category` = 'Support')
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;

--
-- Final view structure for view `view_kit_card_tags`
--

/*!50001 DROP VIEW IF EXISTS `view_kit_card_tags`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8mb4 */;
/*!50001 SET character_set_results = utf8mb4 */;
/*!50001 SET collation_connection = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`scc`@`%` SQL SECURITY DEFINER */ /*!50001 VIEW `view_kit_card_tags` AS
select `view_kit_tags`.`kit_id` AS `kit_id`, `view_kit_tags`.`name` AS `name`, `view_kit_tags`.`value` AS `value`
from `view_kit_tags`
where (`view_kit_tags`.`category` = 'Support Badge')
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;

--
-- Final view structure for view `view_kit_tags`
--

/*!50001 DROP VIEW IF EXISTS `view_kit_tags`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8mb4 */;
/*!50001 SET character_set_results = utf8mb4 */;
/*!50001 SET collation_connection = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`scc`@`%` SQL SECURITY DEFINER */ /*!50001 VIEW `view_kit_tags` AS
select `kt`.`kit_id`                                          AS `kit_id`,
       `tc`.`name`                                            AS `category`,
       `tg`.`name`                                            AS `group`,
       `t`.`name`                                             AS `name`,
       if((`tg`.`display_value` = 'yes'), `kt`.`value`, NULL) AS `value`,
       `t`.`image_id`                                         AS `image_id`
from ((((`kits_tags` `kt` join `tags` `t` on ((`t`.`id` = `kt`.`tag_id`))) join `tag_groups` `tg`
        on ((`tg`.`id` = `t`.`tag_group_id`))) join `tag_categories_tag_groups` `tctg`
       on ((`tctg`.`tag_group_id` = `tg`.`id`))) join `tag_categories` `tc` on ((`tc`.`id` = `tctg`.`tag_category_id`)))
order by `tc`.`name`, `tctg`.`sort`, `t`.`sort`, `t`.`name`
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;

--
-- Final view structure for view `view_product_browse_images`
--

/*!50001 DROP VIEW IF EXISTS `view_product_browse_images`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8mb4 */;
/*!50001 SET character_set_results = utf8mb4 */;
/*!50001 SET collation_connection = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`scc`@`%` SQL SECURITY DEFINER */ /*!50001 VIEW `view_product_browse_images` AS
select `p`.`id` AS `product_id`, `i`.`file_id` AS `image_id`
from ((`products` `p` join `galleries` `g` on ((`g`.`id` = `p`.`gallery_id`))) join `gallery_images` `i`
      on ((`i`.`id` = `g`.`product_gallery_image_id`)))
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;

--
-- Final view structure for view `view_system_browse_images`
--

/*!50001 DROP VIEW IF EXISTS `view_system_browse_images`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8mb4 */;
/*!50001 SET character_set_results = utf8mb4 */;
/*!50001 SET collation_connection = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`scc`@`%` SQL SECURITY DEFINER */ /*!50001 VIEW `view_system_browse_images` AS
select `s`.`id` AS `system_id`, `i`.`file_id` AS `image_id`
from ((((((`systems` `s` join `system_items` `si` on ((`si`.`system_id` = `s`.`id`))) join `group_items` `gi`
          on ((`gi`.`id` = `si`.`item_id`))) join `products` `p`
         on ((`p`.`id` = `gi`.`product_id`))) join `galleries` `g`
        on ((`g`.`id` = `p`.`gallery_id`))) join `gallery_images` `i`
       on ((`i`.`id` = `g`.`browse_gallery_image_id`))) join `product_categories` `pc`
      on ((`pc`.`id` = `p`.`product_category_id`)))
where ((`g`.`browse_gallery_image_id` is not null) and (`i`.`active` = 'yes'))
order by `pc`.`gallery_priority` desc, `p`.`cost` desc, `p`.`sort`
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;

--
-- Final view structure for view `view_system_system_images`
--

/*!50001 DROP VIEW IF EXISTS `view_system_system_images`*/;
/*!50001 SET @saved_cs_client = @@character_set_client */;
/*!50001 SET @saved_cs_results = @@character_set_results */;
/*!50001 SET @saved_col_connection = @@collation_connection */;
/*!50001 SET character_set_client = utf8mb4 */;
/*!50001 SET character_set_results = utf8mb4 */;
/*!50001 SET collation_connection = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM = UNDEFINED */ /*!50013 DEFINER =`scc`@`%` SQL SECURITY DEFINER */ /*!50001 VIEW `view_system_system_images` AS
select `s`.`id` AS `system_id`, `i`.`file_id` AS `image_id`
from ((((((`systems` `s` join `system_items` `si` on ((`si`.`system_id` = `s`.`id`))) join `group_items` `gi`
          on ((`gi`.`id` = `si`.`item_id`))) join `products` `p`
         on ((`p`.`id` = `gi`.`product_id`))) join `galleries` `g`
        on ((`g`.`id` = `p`.`gallery_id`))) join `gallery_images` `i`
       on ((`i`.`id` = `g`.`system_gallery_image_id`))) join `product_categories` `pc`
      on ((`pc`.`id` = `p`.`product_category_id`)))
where ((`g`.`system_gallery_image_id` is not null) and (`i`.`active` = 'yes'))
order by `pc`.`gallery_priority` desc, `p`.`cost` desc, `p`.`sort`
        */;
/*!50001 SET character_set_client = @saved_cs_client */;
/*!50001 SET character_set_results = @saved_cs_results */;
/*!50001 SET collation_connection = @saved_col_connection */;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2022-11-21 15:36:53
