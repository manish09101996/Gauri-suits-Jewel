-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gauri_suits_jewel
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'India',
  `type` enum('shipping','billing') NOT NULL DEFAULT 'shipping',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,1,'Simran','Kaur','+91 98123 45678','customer@example.com','House 412, Sector 8-B','Near Gurudwara Sahib','Chandigarh','Punjab','160009','India','shipping',1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,2,'Harleen','Dhillon','+91 98765 00112','harleen.dhillon@gmail.com','B-4/12 Vasant Vihar',NULL,'New Delhi','Delhi','110057','India','shipping',1,'2026-09-15 05:52:40','2026-09-15 05:52:40');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_roles`
--

DROP TABLE IF EXISTS `admin_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_admin_id_role_id_unique` (`admin_id`,`role_id`),
  KEY `admin_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `admin_roles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `admin_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,1,1,NULL,NULL);
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Gauri Master Admin','admin@gaurisuits.com','$2y$12$ixk9wCKjU8pCOh1DnFEE8.zAqGuAyqvqgKhwK4nsyDqVr9vTU453m','+91 98765 43210',NULL,'super_admin',1,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image_desktop` varchar(255) NOT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `type` enum('hero','promo','announcement','banner') NOT NULL DEFAULT 'hero',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'ROOTED IN TRADITION','THE VIRASAT HERITAGE EDIT','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=2000&auto=format&fit=crop','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=800&auto=format&fit=crop','http://localhost:8000/shop','EXPLORE COUTURE','hero',1,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,'HEIRLOOM KUNDAN & POLKI','TIMELESS BRIDAL JEWELS','https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2000&auto=format&fit=crop','https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=800&auto=format&fit=crop','http://localhost:8000/jewellery','SHOP JEWELLERY','hero',1,2,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `author_name` varchar(255) NOT NULL DEFAULT 'Gauri Editorial',
  `status` enum('draft','published') NOT NULL DEFAULT 'published',
  `published_at` timestamp NULL DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_admin_id_foreign` (`admin_id`),
  CONSTRAINT `blog_posts_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,1,'The Timeless Splendour of Punjabi Phulkari & Tilla Weaving','timeless-splendour-punjabi-phulkari-tilla-weaving','Exploring the rich generational heritage of Punjabi Phulkari embroidery, royal dabka needlework, and heirloom tilla threads.','<p>For centuries, the culture of Punjab has celebrated textile craftsmanship that weaves poetry into every thread. Among these treasured arts, <strong>Phulkari</strong> (literally translating to \"flower work\") and <strong>Kashmiri Tilla</strong> embroidery hold an unshakeable place of pride in royal bridal trousseaus.</p><p>At Gauri Suits & Jewel, each ensemble honors this heritage. Third-generation karigars in our workshops spend between 40 to 120 hours meticulously guiding metallic gold and silver threads across handwoven silk and micro-velvets.</p>','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1200&auto=format&fit=crop','Punjabi Suits, Phulkari, Heritage, Handloom','Gauri Editorial Atelier','published','2026-09-05 05:52:40',NULL,NULL,'2026-09-15 05:52:40','2026-09-15 05:52:40'),(2,1,'Bridal Jewellery Guide: Pairing Polki and Kundan with Royal Silhouettes','bridal-jewellery-guide-polki-kundan-royal-silhouettes','How to curate an iconic wedding day look by striking the perfect harmony between heavy zardozi embroidery and heirloom gemstones.','<p>Selecting wedding jewellery is one of the most sacred and cherished rituals for any bride. Today’s modern Punjabi bride seeks an opulent balance between traditional heritage and contemporary comfort.</p><p>When styling an intricately embroidered Rani Pink or Deep Crimson velvet ensemble, opting for an uncut Kundan choker with emerald bead drops creates a striking contrast that catches every ray of camera light.</p>','https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1200&auto=format&fit=crop','Jewellery, Bridal, Kundan, Styling Guide','Harmanpreet Kaur, Chief Stylist','published','2026-09-10 05:52:40',NULL,NULL,'2026-09-15 05:52:40','2026-09-15 05:52:40');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('gauri-suits-jewel-cache-all_settings','a:17:{s:10:\"store_name\";s:19:\"Gauri Suits & Jewel\";s:13:\"store_tagline\";s:49:\"Heritage Punjabi Couture & Bespoke Fine Jewellery\";s:13:\"contact_email\";s:19:\"care@gaurisuits.com\";s:13:\"contact_phone\";s:15:\"+91 98765 43210\";s:15:\"whatsapp_number\";s:12:\"919876543210\";s:13:\"store_address\";s:63:\"Heritage Couture Arcade, Sector 17-C, Chandigarh, Punjab 160017\";s:15:\"currency_symbol\";s:3:\"₹\";s:13:\"currency_code\";s:3:\"INR\";s:23:\"free_shipping_threshold\";s:4:\"2999\";s:18:\"flat_shipping_rate\";s:3:\"150\";s:11:\"cod_enabled\";s:1:\"1\";s:13:\"cod_max_limit\";s:5:\"25000\";s:15:\"razorpay_key_id\";s:23:\"rzp_test_gauri_mock_key\";s:19:\"razorpay_key_secret\";s:23:\"mock_secret_gauri_12345\";s:16:\"announcement_bar\";s:107:\"Complimentary Express Shipping Across India on Orders Above ₹2,999 | Worldwide Express Delivery Available\";s:13:\"instagram_url\";s:37:\"https://instagram.com/gaurisuitsjewel\";s:12:\"facebook_url\";s:36:\"https://facebook.com/gaurisuitsjewel\";}',2104830981),('gauri-suits-jewel-cache-setting_facebook_url','s:36:\"https://facebook.com/gaurisuitsjewel\";',2104830986),('gauri-suits-jewel-cache-setting_free_shipping_threshold','s:4:\"2999\";',2104830981),('gauri-suits-jewel-cache-setting_instagram_url','s:37:\"https://instagram.com/gaurisuitsjewel\";',2104830986),('gauri-suits-jewel-cache-setting_whatsapp_number','s:12:\"919876543210\";',2104830986);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `variant_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  KEY `cart_items_variant_id_foreign` (`variant_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (1,1,9,20,1,5999.00,'2026-09-15 01:47:11','2026-09-15 01:47:11'),(2,1,1,3,5,7499.00,'2026-09-15 02:35:47','2026-09-15 02:35:54'),(3,1,1,2,2,7499.00,'2026-09-15 02:35:56','2026-09-15 02:35:57'),(4,1,4,NULL,23,5499.00,'2026-09-15 04:15:43','2026-09-15 05:23:50'),(5,2,4,NULL,8,5499.00,'2026-09-15 05:46:21','2026-09-15 05:58:36'),(6,2,3,11,1,21999.00,'2026-09-15 05:50:46','2026-09-15 05:50:46');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `coupon_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_coupon_id_foreign` (`coupon_id`),
  KEY `carts_session_id_index` (`session_id`),
  CONSTRAINT `carts_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,NULL,'u10KqRTBkywj00v1zjhfUKsWx9DKYenM2Uv3t9bm',NULL,'2026-09-15 01:47:11','2026-09-15 01:47:11'),(2,NULL,'gzHXU6hMXOcKoUiJFHrk6IMebZ5xXa4Vnl714L1Z',NULL,'2026-09-15 05:46:21','2026-09-15 05:46:21');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,NULL,'Punjabi Suits','punjabi-suits','Authentic handcrafted Punjabi silhouettes, bespoke salwar kameez, and heirloom party wear.','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=800&auto=format&fit=crop',1,1,1,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,1,'Unstitched Suits','unstitched-suits','Pure Chanderi, Georgette, and Organza unstitched fabrics with intricate handwork.','https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=800&auto=format&fit=crop',1,1,2,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,1,'Stitched Patiala Suits','patiala-suits','Classic Punjabi Shahi Patiala suits paired with heavy phulkari and tilla borders.','https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=800&auto=format&fit=crop',1,1,3,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(4,1,'Bridal Anarkali Ensembles','anarkali-suits','Flared floor-length royal Kalidar Anarkalis embellished with Dabka and Zardozi.','https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=800&auto=format&fit=crop',1,1,4,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(5,1,'Velvet Festive Suits','velvet-suits','Opulent micro-velvet suits adorned with antique Kashmiri tilla work.','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=800&auto=format&fit=crop',1,1,5,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(6,NULL,'Fine Jewellery','jewellery','Heirloom Kundan, uncut Polki, Jadau, and Meenakari bridal jewellery.','https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=800&auto=format&fit=crop',1,1,6,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(7,6,'Necklaces & Chokers','kundan-necklaces','22K gold-plated Kundan chokers with emerald drops and cultured pearls.','https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop',1,1,1,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(8,6,'Nath & Nose Rings','nath-nose-rings','Exquisite bridal naths with delicate pearl chains.','https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop',1,1,2,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(9,6,'Maang Tikka & Passa','matha-patti-passa','Royal bridal headpieces, side passas, and maang tikkas.','https://images.unsplash.com/photo-1602751584552-8ba73aad10e1?q=80&w=600&auto=format&fit=crop',1,1,3,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(10,6,'Chandbalis & Jhumkas','chandbalis-jhumkas','Opulent statement earrings and traditional Punjabi jhumkis.','https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=600&auto=format&fit=crop',1,1,4,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(11,6,'Hathphool & Rings','hathphool-rings','Artisanal hand chains, finger rings, and meenakari cuffs.','https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=600&auto=format&fit=crop',1,1,5,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(12,6,'Payal & Anklets','payal-anklets','Bridal payals with chiming ghungroos and traditional silver accents.','https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',1,1,6,NULL,NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collection_product`
--

DROP TABLE IF EXISTS `collection_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collection_product` (
  `collection_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`collection_id`,`product_id`),
  KEY `collection_product_product_id_foreign` (`product_id`),
  CONSTRAINT `collection_product_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `collection_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection_product`
--

LOCK TABLES `collection_product` WRITE;
/*!40000 ALTER TABLE `collection_product` DISABLE KEYS */;
INSERT INTO `collection_product` VALUES (1,1),(1,2),(1,3),(1,4),(1,7),(2,1),(2,6),(2,8),(2,9),(3,4),(3,5),(3,7),(3,10);
/*!40000 ALTER TABLE `collection_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `collections_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
INSERT INTO `collections` VALUES (1,'Virasat Bridal Edit 2026','virasat-bridal-edit-2026','An ode to ancestral grandeur with heavy Tilla embroidery and pure silk weaves.','https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1200&auto=format&fit=crop',1,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,'The Shahi Patiala Heritage','the-shahi-patiala-heritage','Authentic pleated silhouettes crafted by third-generation Punjabi master artisans.','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1200&auto=format&fit=crop',1,2,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,'Heirloom Kundan Treasures','heirloom-kundan-treasures','Handcrafted uncut Polki & Kundan jewels evoking the courts of Patiala and Lahore.','https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1200&auto=format&fit=crop',1,3,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon_usages`
--

DROP TABLE IF EXISTS `coupon_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_usages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupon_usages_coupon_id_foreign` (`coupon_id`),
  KEY `coupon_usages_user_id_foreign` (`user_id`),
  CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_usages`
--

LOCK TABLES `coupon_usages` WRITE;
/*!40000 ALTER TABLE `coupon_usages` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_usages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'GAURI10','percentage',10.00,1999.00,1000.00,'2026-08-15 05:52:39','2027-03-15 05:52:39',500,18,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,'ROYAL15','percentage',15.00,4999.00,2500.00,'2026-08-15 05:52:39','2027-03-15 05:52:39',200,12,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,'WEDDING500','fixed',500.00,3499.00,NULL,'2026-08-15 05:52:39','2027-03-15 05:52:39',300,25,1,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homepage_sections`
--

DROP TABLE IF EXISTS `homepage_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homepage_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homepage_sections_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homepage_sections`
--

LOCK TABLES `homepage_sections` WRITE;
/*!40000 ALTER TABLE `homepage_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `homepage_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_movements`
--

DROP TABLE IF EXISTS `inventory_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_movements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `variant_id` bigint(20) unsigned DEFAULT NULL,
  `type` enum('purchase','order','cancellation','return','manual_adjustment') NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'Can be negative or positive',
  `balance_after` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `reference_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_movements_variant_id_foreign` (`variant_id`),
  KEY `inventory_movements_product_id_created_at_index` (`product_id`,`created_at`),
  CONSTRAINT `inventory_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_movements_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_movements`
--

LOCK TABLES `inventory_movements` WRITE;
/*!40000 ALTER TABLE `inventory_movements` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_15_100001_create_admins_and_roles_tables',1),(5,'2026_09_15_100002_create_categories_and_collections_tables',1),(6,'2026_09_15_100003_create_products_and_variants_tables',1),(7,'2026_09_15_100004_create_orders_and_checkout_tables',1),(8,'2026_09_15_100005_create_engagement_and_cms_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `variant_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `variant_title` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_variant_id_foreign` (`variant_id`),
  KEY `order_items_order_id_product_id_index` (`order_id`,`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,NULL,'Gulab Noor Zardozi Patiala Suit','GS-PS-001',NULL,7499.00,1,7499.00,'2026-09-01 02:52:40','2026-09-01 02:52:40'),(2,1,3,NULL,'Sheesh Mahal Kalidar Bridal Anarkali','GS-AK-003',NULL,21999.00,1,21999.00,'2026-09-01 02:52:40','2026-09-01 02:52:40'),(3,2,2,NULL,'Noor-e-Kashmir Velvet Tilla Suit','GS-VS-002',NULL,10999.00,1,10999.00,'2026-09-04 21:52:40','2026-09-04 21:52:40'),(4,2,4,NULL,'Virasat Emerald Kundan Choker Set','GS-JW-004',NULL,5499.00,1,5499.00,'2026-09-04 21:52:40','2026-09-04 21:52:40'),(5,3,3,NULL,'Sheesh Mahal Kalidar Bridal Anarkali','GS-AK-003',NULL,21999.00,1,21999.00,'2026-09-11 22:52:40','2026-09-11 22:52:40'),(6,3,5,NULL,'Chandrika Pearl & Polki Chandbalis','GS-JW-005',NULL,2999.00,1,2999.00,'2026-09-11 22:52:40','2026-09-11 22:52:40'),(7,4,4,NULL,'Virasat Emerald Kundan Choker Set','GS-JW-004',NULL,5499.00,1,5499.00,'2026-09-14 03:52:40','2026-09-14 03:52:40'),(8,4,6,NULL,'Bagh-e-Punjab Pure Chanderi Unstitched Suit','GS-US-006',NULL,4299.00,1,4299.00,'2026-09-14 03:52:40','2026-09-14 03:52:40'),(9,5,5,NULL,'Chandrika Pearl & Polki Chandbalis','GS-JW-005',NULL,2999.00,1,2999.00,'2026-09-14 20:52:40','2026-09-14 20:52:40'),(10,5,7,NULL,'Shahi Jadau Matha Patti & Passa Duo','GS-JW-007',NULL,3899.00,1,3899.00,'2026-09-14 20:52:40','2026-09-14 20:52:40');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `guest_phone` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','processing','packed','shipped','out_for_delivery','delivered','cancelled','returned','refunded') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `subtotal` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `shipping_address_line1` varchar(255) NOT NULL,
  `shipping_address_line2` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_state` varchar(255) NOT NULL,
  `shipping_postal_code` varchar(255) NOT NULL,
  `shipping_country` varchar(255) NOT NULL DEFAULT 'India',
  `notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `is_manual` tinyint(1) NOT NULL DEFAULT 0,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_status_payment_status_index` (`status`,`payment_status`),
  KEY `orders_created_at_index` (`created_at`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'GSJ-20261001',1,NULL,NULL,'delivered','paid','razorpay',29498.00,0.00,NULL,0.00,0.00,29498.00,'Simran Kaur','+91 98123 45678','customer@example.com','House 412, Sector 8-B',NULL,'Chandigarh','Punjab','160009','India',NULL,NULL,0,NULL,NULL,'2026-09-01 02:52:40','2026-09-01 02:52:40'),(2,'GSJ-20261002',2,NULL,NULL,'delivered','paid','razorpay',16498.00,500.00,'WEDDING500',0.00,0.00,15998.00,'Harleen Dhillon','+91 98765 00112','harleen.dhillon@gmail.com','B-4/12 Vasant Vihar',NULL,'New Delhi','Delhi','110057','India',NULL,NULL,0,NULL,NULL,'2026-09-04 21:52:40','2026-09-04 21:52:40'),(3,'GSJ-20261003',1,NULL,NULL,'shipped','paid','razorpay',24998.00,0.00,NULL,0.00,0.00,24998.00,'Simran Kaur','+91 98123 45678','customer@example.com','House 412, Sector 8-B',NULL,'Chandigarh','Punjab','160009','India',NULL,NULL,0,NULL,NULL,'2026-09-11 22:52:40','2026-09-11 22:52:40'),(4,'GSJ-20261004',2,NULL,NULL,'processing','pending','cod',9798.00,500.00,'WEDDING500',0.00,0.00,9298.00,'Harleen Dhillon','+91 98765 00112','harleen.dhillon@gmail.com','B-4/12 Vasant Vihar',NULL,'New Delhi','Delhi','110057','India',NULL,NULL,0,NULL,NULL,'2026-09-14 03:52:40','2026-09-14 03:52:40'),(5,'GSJ-20261005',1,NULL,NULL,'confirmed','paid','razorpay',6898.00,0.00,NULL,0.00,0.00,6898.00,'Simran Kaur','+91 98123 45678','customer@example.com','House 412, Sector 8-B',NULL,'Chandigarh','Punjab','160009','India',NULL,NULL,0,NULL,NULL,'2026-09-14 20:52:40','2026-09-14 20:52:40');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'INR',
  `status` enum('pending','successful','failed','refunded') NOT NULL DEFAULT 'pending',
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  KEY `payments_razorpay_order_id_index` (`razorpay_order_id`),
  KEY `payments_razorpay_payment_id_index` (`razorpay_payment_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,'TXN_D00NTG0JHCNN','order_fotqglRy580tQU','pay_6MRKzQ8mjjaAxk',NULL,'razorpay',29498.00,'INR','successful',NULL,'2026-09-01 02:52:40','2026-09-01 02:52:40','2026-09-01 02:52:40'),(2,2,'TXN_G8ARV2PCMAON','order_NjXd2Ht8t6FUgo','pay_QLjfDMtwra5vCo',NULL,'razorpay',15998.00,'INR','successful',NULL,'2026-09-04 21:52:40','2026-09-04 21:52:40','2026-09-04 21:52:40'),(3,3,'TXN_MUEWJIUFZMXX','order_LZTr32tYksSUiD','pay_nk7l0DSoTIJPb3',NULL,'razorpay',24998.00,'INR','successful',NULL,'2026-09-11 22:52:40','2026-09-11 22:52:40','2026-09-11 22:52:40'),(4,5,'TXN_ECLQMIUX56WC','order_LyOmQ11IlO2EMd','pay_LgJgyqdnizZlpy',NULL,'razorpay',6898.00,'INR','successful',NULL,'2026-09-14 20:52:40','2026-09-14 20:52:40','2026-09-14 20:52:40');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop','Gulab Noor Zardozi Patiala Suit',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,1,'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=900&auto=format&fit=crop','Gulab Noor Zardozi Patiala Suit',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,2,'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop','Noor-e-Kashmir Velvet Tilla Suit',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(4,2,'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop','Noor-e-Kashmir Velvet Tilla Suit',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(5,3,'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=900&auto=format&fit=crop','Sheesh Mahal Kalidar Bridal Anarkali',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(6,3,'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=900&auto=format&fit=crop','Sheesh Mahal Kalidar Bridal Anarkali',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(7,4,'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop','Virasat Emerald Kundan Choker Set',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(8,4,'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=900&auto=format&fit=crop','Virasat Emerald Kundan Choker Set',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(9,5,'https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=900&auto=format&fit=crop','Chandrika Pearl & Polki Chandbalis',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(10,5,'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop','Chandrika Pearl & Polki Chandbalis',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(11,6,'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=900&auto=format&fit=crop','Bagh-e-Punjab Pure Chanderi Unstitched Suit',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(12,6,'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop','Bagh-e-Punjab Pure Chanderi Unstitched Suit',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(13,7,'https://images.unsplash.com/photo-1602751584552-8ba73aad10e1?q=80&w=900&auto=format&fit=crop','Shahi Jadau Matha Patti & Passa Duo',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(14,7,'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop','Shahi Jadau Matha Patti & Passa Duo',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(15,8,'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=900&auto=format&fit=crop','Nawabi Sapphire Blue Silk Gharara Set',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(16,8,'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=900&auto=format&fit=crop','Nawabi Sapphire Blue Silk Gharara Set',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(17,9,'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=900&auto=format&fit=crop','Noorjehan Mustard Handloom Georgette Suit',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(18,9,'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=900&auto=format&fit=crop','Noorjehan Mustard Handloom Georgette Suit',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(19,10,'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=900&auto=format&fit=crop','Pakeezah Navratan Meenakari Choker',0,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(20,10,'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=900&auto=format&fit=crop','Pakeezah Navratan Meenakari Choker',1,0,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `sku` varchar(255) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `colour` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_sku_unique` (`sku`),
  KEY `product_variants_product_id_size_colour_index` (`product_id`,`size`,`colour`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
INSERT INTO `product_variants` VALUES (1,1,'GS-PS-001-S','S','Rani Pink',8999.00,7499.00,5,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,1,'GS-PS-001-M','M','Rani Pink',8999.00,7499.00,8,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,1,'GS-PS-001-L','L','Rani Pink',8999.00,7499.00,7,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(4,1,'GS-PS-001-XL','XL','Rani Pink',8999.00,7499.00,5,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(5,2,'GS-VS-002-S','S','Royal Maroon',12999.00,10999.00,4,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(6,2,'GS-VS-002-M','M','Royal Maroon',12999.00,10999.00,6,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(7,2,'GS-VS-002-L','L','Royal Maroon',12999.00,10999.00,5,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(8,2,'GS-VS-002-XL','XL','Royal Maroon',12999.00,10999.00,3,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(9,3,'GS-AK-003-S','S','Ivory Gold',24999.00,21999.00,3,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(10,3,'GS-AK-003-M','M','Ivory Gold',24999.00,21999.00,4,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(11,3,'GS-AK-003-L','L','Ivory Gold',24999.00,21999.00,3,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(12,3,'GS-AK-003-XL','XL','Ivory Gold',24999.00,21999.00,2,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(13,6,'GS-US-006-UN','Unstitched (3 Pc)','Sage Green',4999.00,4299.00,40,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(14,8,'GS-GH-008-S','S','Sapphire Blue',11499.00,9999.00,3,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(15,8,'GS-GH-008-M','M','Sapphire Blue',11499.00,9999.00,5,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(16,8,'GS-GH-008-L','L','Sapphire Blue',11499.00,9999.00,4,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(17,8,'GS-GH-008-XL','XL','Sapphire Blue',11499.00,9999.00,3,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(18,9,'GS-PS-009-S','S','Mustard Yellow',6999.00,5999.00,5,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(19,9,'GS-PS-009-M','M','Mustard Yellow',6999.00,5999.00,7,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(20,9,'GS-PS-009-L','L','Mustard Yellow',6999.00,5999.00,6,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(21,9,'GS-PS-009-XL','XL','Mustard Yellow',6999.00,5999.00,4,1,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `fabric` varchar(255) DEFAULT NULL,
  `colour` varchar(255) DEFAULT NULL,
  `pattern` varchar(255) DEFAULT NULL,
  `work` varchar(255) DEFAULT NULL,
  `occasion` varchar(255) DEFAULT NULL,
  `care_instructions` text DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL COMMENT 'Weight in grams or kg',
  `stock` int(11) NOT NULL DEFAULT 0,
  `low_stock_threshold` int(11) NOT NULL DEFAULT 5,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'published',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 1,
  `is_sale` tinyint(1) NOT NULL DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_status_index` (`category_id`,`status`),
  KEY `products_is_featured_index` (`is_featured`),
  KEY `products_is_best_seller_index` (`is_best_seller`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Gulab Noor Zardozi Patiala Suit','gulab-noor-zardozi-patiala-suit','GS-PS-001','<p>Immerse yourself in royal Punjabi tradition with the Gulab Noor Zardozi Patiala Suit. Handcrafted in our Chandigarh atelier, this ensemble features a pure mulberry silk kurta adorned with painstaking Dabka, Pitta, and antique Zari embroidery along the jewel neckline, cuffs, and hem. Accompanied by a lavishly gathered pure silk Patiala salwar and a gossamer organza dupatta finished with scalloped Gota borders.</p>','Handcrafted Rani Pink mulberry silk kurta paired with an opulent shahi pleated salwar and scalloped organza dupatta.',8999.00,7499.00,4200.00,3,'Pure Mulberry Silk','Rani Pink','Hand Embroidered Floral Arabesque','Dabka, Zari & Sequins','Festive & Wedding','Strictly Dry Clean Only',1.20,25,5,'published',1,1,1,1,'Gulab Noor Zardozi Patiala Suit | Gauri Suits & Jewel','Handcrafted Rani Pink mulberry silk kurta paired with an opulent shahi pleated salwar and scalloped organza dupatta.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,'Noor-e-Kashmir Velvet Tilla Suit','noor-e-kashmir-velvet-tilla-suit','GS-VS-002','<p>Crafted for distinguished winter nuptials, the Noor-e-Kashmir suit features luxurious micro-velvet that drapes with stately grace. Artisans have hand-guided authentic silver and gold tilla threads across the neckline, front daman, and sleeves. Paired with tailored velvet pants and a pure tissue silk dupatta carrying hand-stitched borders.</p>','Regal deep maroon micro-velvet ensemble enriched with intricate antique gold Kashmiri tilla embroidery.',12999.00,10999.00,6000.00,5,'Micro Velvet 9000','Royal Maroon','Traditional Paisleys & Cypress Motifs','Antique Kashmiri Tilla Needlework','Winter Weddings & Receptions','Professional Dry Clean Only. Steam Iron with Cloth Cover.',1.80,18,5,'published',1,1,1,1,'Noor-e-Kashmir Velvet Tilla Suit | Gauri Suits & Jewel','Regal deep maroon micro-velvet ensemble enriched with intricate antique gold Kashmiri tilla embroidery.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,'Sheesh Mahal Kalidar Bridal Anarkali','sheesh-mahal-kalidar-bridal-anarkali','GS-AK-003','<p>The Sheesh Mahal Bridal Anarkali reflects timeless imperial panache. Hand-tailored in 28 dramatic Kalis (panels), it provides an ethereal swirl. Embellished with genuine silver Mukaish dots, resham highlights, and hand-cut mirrors along the hemline. Paired with a churidar and a double-shaded scalloped dupatta.</p>','Magnificent 28-kali flared ivory silk Anarkali woven with hand-beaten silver and gold Mukaish motifs.',24999.00,21999.00,12500.00,4,'Pure Chanderi Silk & Organza','Ivory Gold','Royal Mughal Floral Jali','Mukaish, Mirrorwork & Dabka Zari','Bridal, Anand Karaj & Sangeet','Preserve in Cotton Muslin. Strictly Dry Clean.',2.40,12,5,'published',1,1,1,1,'Sheesh Mahal Kalidar Bridal Anarkali | Gauri Suits & Jewel','Magnificent 28-kali flared ivory silk Anarkali woven with hand-beaten silver and gold Mukaish motifs.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(4,'Virasat Emerald Kundan Choker Set','virasat-emerald-kundan-choker-set','GS-JW-004','<p>Elegantly crafted by hereditary jewelry artisans in Punjab and Rajasthan. This opulent choker features precision-set uncut Kundan stones, emerald beads, and tiers of delicate freshwater pearls. Adjustable royal dori silk tassel fits comfortably on any neck.</p>','Heirloom 22K gold-plated Kundan choker necklace accompanied by matching chandelier earrings and a maang tikka.',6499.00,5499.00,2600.00,7,'22K Gold Plated Brass Core','Emerald Green & Ivory','Jadau Royal Setting','Uncut Glass Polki, Hydro Emeralds & Cultured Pearls','Bridal & Festive Celebrations','Store in airtight box. Keep away from water and perfume.',0.35,30,5,'published',1,1,1,1,'Virasat Emerald Kundan Choker Set | Gauri Suits & Jewel','Heirloom 22K gold-plated Kundan choker necklace accompanied by matching chandelier earrings and a maang tikka.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(5,'Chandrika Pearl & Polki Chandbalis','chandrika-pearl-polki-chandbalis','GS-JW-005','<p>A tribute to timeless Punjabi grandeur. These Chandbalis frame the face with gentle radiance. Finished with traditional red and green Meenakari at the reverse and micro-pearl hanging drops.</p>','Statement crescent moon-shaped Polki Chandbalis with fine Meenakari floral reverse artwork and pearl clusters.',3499.00,2999.00,1300.00,10,'Gold Plated Silver Alloy','Antique Gold & Pearl','Crescent Moon Chandbali','Handcrafted Kundan with Meenakari Enamelling at Back','Festive, Engagement, Sangeet','Wipe with soft chamois cloth. Avoid exposure to alcohol-based sprays.',0.15,45,5,'published',1,1,0,1,'Chandrika Pearl & Polki Chandbalis | Gauri Suits & Jewel','Statement crescent moon-shaped Polki Chandbalis with fine Meenakari floral reverse artwork and pearl clusters.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(6,'Bagh-e-Punjab Pure Chanderi Unstitched Suit','bagh-e-punjab-pure-chanderi-unstitched-suit','GS-US-006','<p>Tailor your silhouette precisely to your desire. Includes 2.5m pure Chanderi silk shirt with ornate neckline embroidery, 2.5m santoon salwar/trouser fabric, and a 2.5m lightweight handwoven dupatta with zardozi accents.</p>','3-piece luxury unstitched suit fabric featuring pure Chanderi silk with hand gota embroidery and matching Banarasi dupatta.',4999.00,4299.00,2200.00,2,'Pure Chanderi Silk with Santoon Bottom','Sage Green','Floral Botanical Resham Weave','Hand Gota Patti & Cutdana Detailing','Casual Chic, Mehendi, Pooja','Gentle Dry Clean Recommended',0.85,40,5,'published',0,1,1,1,'Bagh-e-Punjab Pure Chanderi Unstitched Suit | Gauri Suits & Jewel','3-piece luxury unstitched suit fabric featuring pure Chanderi silk with hand gota embroidery and matching Banarasi dupatta.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(7,'Shahi Jadau Matha Patti & Passa Duo','shahi-jadau-matha-patti-passa-duo','GS-JW-007','<p>Complete your bridal crowning majesty. Features a multi-tiered Kundan matha patti that gently frames the forehead and hair parting, alongside an artisanal side passa adorned with ruby red stones and pearl droplets.</p>','Traditional Punjabi bridal hair jewellery set featuring an intricately stone-encrusted Matha Patti and matching side Passa.',4499.00,3899.00,1900.00,9,'Gold Plated Alloy','Gold & Ruby Red','Bridal Crown Geometry','Jadau Stone Inlay with Pearl Strings','Bridal Anand Karaj & Nikah','Store flat in padded velvet jewellery box.',0.20,20,5,'published',0,0,1,1,'Shahi Jadau Matha Patti & Passa Duo | Gauri Suits & Jewel','Traditional Punjabi bridal hair jewellery set featuring an intricately stone-encrusted Matha Patti and matching side Passa.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(8,'Nawabi Sapphire Blue Silk Gharara Set','nawabi-sapphire-blue-silk-gharara-set','GS-GH-008','<p>Turn every head with royal sapphire blue radiance. The short tailored kurti is framed with delicate hand gota work, while the knee-gathered flared gharara swishes with majestic fullness at every step.</p>','Exquisite raw silk short kurti paired with a voluminous double-flared gharara and hand-dyed ombre chiffon dupatta.',11499.00,9999.00,5200.00,3,'Raw Silk & Chinon Chiffon','Royal Sapphire Blue','Gota Patti Floral Jaal','Hand Carved Gota Patti & Mukaish','Cocktail, Reception, Festive','Dry Clean Only',1.40,15,5,'published',1,0,1,1,'Nawabi Sapphire Blue Silk Gharara Set | Gauri Suits & Jewel','Exquisite raw silk short kurti paired with a voluminous double-flared gharara and hand-dyed ombre chiffon dupatta.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(9,'Noorjehan Mustard Handloom Georgette Suit','noorjehan-mustard-handloom-georgette-suit','GS-PS-009','<p>Celebrate joyous auspicious occasions in this sunshine yellow georgette masterpiece. Adorned with heritage Phulkari stitch craft, paired with a matching gathered salwar and a rich Banarasi weave dupatta.</p>','Festive yellow pure georgette Punjabi suit decorated with vibrant Phulkari inspired resham needlework and gold mirror lace.',6999.00,5999.00,3100.00,3,'Pure Viscose Georgette','Haldi Mustard Yellow','Zari Phulkari Motif','Resham Threadwork & Mirror Borders','Haldi, Mehendi, Baisakhi','Dry Clean Only',1.10,22,5,'published',1,1,0,1,'Noorjehan Mustard Handloom Georgette Suit | Gauri Suits & Jewel','Festive yellow pure georgette Punjabi suit decorated with vibrant Phulkari inspired resham needlework and gold mirror lace.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(10,'Pakeezah Navratan Meenakari Choker','pakeezah-navratan-meenakari-choker','GS-JW-010','<p>Echoing the royal courts of Punjab, this Navratan necklace brings together vibrant nine-colored gemstones representing harmony and prosperity. Versatile enough to pair with any shade of couture.</p>','Regal 9-gemstone Navratan choker necklace framed by handcrafted Kundan florals and pearl drops.',5999.00,4999.00,2400.00,7,'22K Matte Gold Finish','Multi-Colour Gemstones','Navratan Nine Gems Palette','Semi-Precious Gemstones & Jadau Setting','Weddings & Royal Trunk Shows','Wipe with cotton swab. Keep sealed.',0.28,15,5,'published',1,0,1,1,'Pakeezah Navratan Meenakari Choker | Gauri Suits & Jewel','Regal 9-gemstone Navratan choker necklace framed by handcrafted Kundan florals and pearl drops.',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reels`
--

DROP TABLE IF EXISTS `reels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reels_product_id_foreign` (`product_id`),
  CONSTRAINT `reels_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reels`
--

LOCK TABLES `reels` WRITE;
/*!40000 ALTER TABLE `reels` DISABLE KEYS */;
INSERT INTO `reels` VALUES (1,'Gulab Noor Zardozi Patiala in Motion','https://assets.mixkit.co/videos/preview/mixkit-woman-modeling-a-traditional-indian-dress-42415-large.mp4','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop',1,'http://localhost:8000/product/gulab-noor-zardozi-patiala-suit',1,1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,'Artisanal Emerald Kundan Choker','https://assets.mixkit.co/videos/preview/mixkit-golden-jewelry-necklace-and-earrings-43093-large.mp4','https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop',4,'http://localhost:8000/product/virasat-emerald-kundan-choker-set',1,2,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,'The Royal 28-Kali Bridal Flared Anarkali','https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-elegant-dress-41804-large.mp4','https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop',3,'http://localhost:8000/product/sheesh-mahal-kalidar-bridal-anarkali',1,3,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(4,'Noor-e-Kashmir Micro-Velvet Tilla Elegance','https://assets.mixkit.co/videos/preview/mixkit-woman-modeling-a-traditional-indian-dress-42415-large.mp4','https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop',2,'http://localhost:8000/product/noor-e-kashmir-velvet-tilla-suit',1,4,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(5,'Chandrika Meenakari Chandbalis Sway','https://assets.mixkit.co/videos/preview/mixkit-golden-jewelry-necklace-and-earrings-43093-large.mp4','https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=600&auto=format&fit=crop',5,'http://localhost:8000/product/chandrika-pearl-polki-chandbalis',1,5,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(6,'Heritage Courtyards of Patiala','https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-elegant-dress-41804-large.mp4','https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',6,'http://localhost:8000/product/bagh-e-punjab-pure-chanderi-unstitched-suit',1,6,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `reels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT 5,
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `is_verified_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_order_id_foreign` (`order_id`),
  KEY `reviews_product_id_status_index` (`product_id`,`status`),
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,1,NULL,'Simran Kaur','customer@example.com',5,'Breathtaking embroidery and royal flare!','The Gulab Noor suit surpassed all my expectations! The zari work on the rani pink silk is so neat, and the salwar flare is pure Punjabi grandeur. Arrived beautifully wrapped in a designer dust box within 3 days.','approved',1,'2026-09-10 05:52:40','2026-09-15 05:52:40','2026-09-15 05:52:40'),(2,2,2,NULL,'Harleen Dhillon','harleen.dhillon@gmail.com',5,'Pure luxury velvet! Worth every rupee.','Wore this velvet tilla suit to my brother’s winter reception in Chandigarh and received endless compliments. The weight of the fabric and the sheen of the gold tilla is unmatched.','approved',1,'2026-09-12 05:52:40','2026-09-15 05:52:40','2026-09-15 05:52:40'),(3,4,1,NULL,'Simran Kaur','customer@example.com',5,'Heirloom finish Kundan set','The green hydro-emeralds and pearls look just like real heirloom bridal jewellery. It felt substantial on the neck without being scratchy.','approved',1,'2026-09-07 05:52:40','2026-09-15 05:52:40','2026-09-15 05:52:40');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','Super Administrator','Full access to all administrative modules, settings, and orders.','2026-09-15 05:52:38','2026-09-15 05:52:38'),(2,'order_manager','Order & Inventory Manager','Manage orders, fulfillment, shipments, and stock movements.','2026-09-15 05:52:38','2026-09-15 05:52:38');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('gzHXU6hMXOcKoUiJFHrk6IMebZ5xXa4Vnl714L1Z',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoic1lsWGw2ckRlZVRTeTBhdkFDSk9OWkJwUUpRV2Y0M1RHckJTZlV1SCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly9sb2NhbGhvc3QvR2F1cmklMjBzdWl0cyUyMCYlMjBKZXdlbC9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6MTU6InJlY2VudGx5X3ZpZXdlZCI7YToyOntpOjA7aTo0O2k6MTtpOjM7fX0=',1789471723);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'store_name','Gauri Suits & Jewel','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,'store_tagline','Heritage Punjabi Couture & Bespoke Fine Jewellery','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(3,'contact_email','care@gaurisuits.com','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(4,'contact_phone','+91 98765 43210','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(5,'whatsapp_number','919876543210','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(6,'store_address','Heritage Couture Arcade, Sector 17-C, Chandigarh, Punjab 160017','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(7,'currency_symbol','₹','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(8,'currency_code','INR','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(9,'free_shipping_threshold','2999','shipping','2026-09-15 05:52:39','2026-09-15 05:52:39'),(10,'flat_shipping_rate','150','shipping','2026-09-15 05:52:39','2026-09-15 05:52:39'),(11,'cod_enabled','1','payment','2026-09-15 05:52:39','2026-09-15 05:52:39'),(12,'cod_max_limit','25000','payment','2026-09-15 05:52:39','2026-09-15 05:52:39'),(13,'razorpay_key_id','rzp_test_gauri_mock_key','payment','2026-09-15 05:52:39','2026-09-15 05:52:39'),(14,'razorpay_key_secret','mock_secret_gauri_12345','payment','2026-09-15 05:52:39','2026-09-15 05:52:39'),(15,'announcement_bar','Complimentary Express Shipping Across India on Orders Above ₹2,999 | Worldwide Express Delivery Available','general','2026-09-15 05:52:39','2026-09-15 05:52:39'),(16,'instagram_url','https://instagram.com/gaurisuitsjewel','social','2026-09-15 05:52:39','2026-09-15 05:52:39'),(17,'facebook_url','https://facebook.com/gaurisuitsjewel','social','2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `carrier` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `tracking_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','packed','shipped','in_transit','out_for_delivery','delivered') NOT NULL DEFAULT 'pending',
  `estimated_delivery` date DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipments_order_id_foreign` (`order_id`),
  CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipments`
--

LOCK TABLES `shipments` WRITE;
/*!40000 ALTER TABLE `shipments` DISABLE KEYS */;
INSERT INTO `shipments` VALUES (1,1,'BlueDart Express','BD78923410','https://www.bluedart.com/tracking','delivered',NULL,'2026-09-02 02:52:40','2026-09-04 02:52:40',NULL,'2026-09-01 02:52:40','2026-09-01 02:52:40'),(2,2,'BlueDart Express','BD78923411','https://www.bluedart.com/tracking','delivered',NULL,'2026-09-05 21:52:40','2026-09-07 21:52:40',NULL,'2026-09-04 21:52:40','2026-09-04 21:52:40'),(3,3,'BlueDart Express','BD78923412','https://www.bluedart.com/tracking','in_transit',NULL,'2026-09-12 22:52:40',NULL,NULL,'2026-09-11 22:52:40','2026-09-11 22:52:40');
/*!40000 ALTER TABLE `shipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_rates`
--

DROP TABLE IF EXISTS `shipping_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_rates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zone_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_order_amount` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estimated_days` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_rates_zone_id_foreign` (`zone_id`),
  CONSTRAINT `shipping_rates_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_rates`
--

LOCK TABLES `shipping_rates` WRITE;
/*!40000 ALTER TABLE `shipping_rates` DISABLE KEYS */;
INSERT INTO `shipping_rates` VALUES (1,1,'Standard Express Logistics',0.00,2998.99,150.00,'3-5 Business Days',1,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,1,'Complimentary Royal Delivery',2999.00,NULL,0.00,'2-4 Business Days',1,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `shipping_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_zones`
--

DROP TABLE IF EXISTS `shipping_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `states` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`states`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_zones`
--

LOCK TABLES `shipping_zones` WRITE;
/*!40000 ALTER TABLE `shipping_zones` DISABLE KEYS */;
INSERT INTO `shipping_zones` VALUES (1,'Domestic India (All States & UTs)','\"[\\\"Punjab\\\",\\\"Delhi\\\",\\\"Haryana\\\",\\\"Chandigarh\\\",\\\"Maharashtra\\\",\\\"Karnataka\\\",\\\"Rajasthan\\\",\\\"Uttar Pradesh\\\",\\\"Gujarat\\\",\\\"West Bengal\\\",\\\"Tamil Nadu\\\",\\\"Telangana\\\"]\"',1,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `shipping_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Simran Kaur','customer@example.com','+91 98123 45678',NULL,'active',NULL,'$2y$12$1ddOsGeDliHAoH670AS6tOyIkvmMEU6caNcPeK.zblwa8yBjAG7SK',NULL,'2026-09-15 05:52:39','2026-09-15 05:52:39'),(2,'Harleen Dhillon','harleen.dhillon@gmail.com','+91 98765 00112',NULL,'active',NULL,'$2y$12$ZRCzfFLssDlIwjnweHGwwe1QLIil2MocsQEUMkxHoigwgigjynsMK',NULL,'2026-09-15 05:52:40','2026-09-15 05:52:40');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_url` varchar(255) NOT NULL,
  `mobile_video_url` varchar(255) DEFAULT NULL,
  `poster_image` varchar(255) DEFAULT NULL,
  `cta_text` varchar(255) DEFAULT NULL,
  `cta_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'The Craft of Royal Patiala: Behind the Looms','Step inside our Chandigarh atelier where master artisans preserve centuries-old hand embroidery, dabka, and tilla weaving.','https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-elegant-dress-41804-large.mp4',NULL,'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1600&auto=format&fit=crop','Explore The Bridal Edit','http://localhost:8000/bridal-collection',1,1,'2026-09-15 05:52:39','2026-09-15 05:52:39');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_sessions`
--

DROP TABLE IF EXISTS `visitor_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `ip_hash` varchar(64) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `device_type` varchar(255) NOT NULL DEFAULT 'desktop',
  `current_url` text DEFAULT NULL,
  `referrer` text DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_sessions_session_id_index` (`session_id`),
  KEY `visitor_sessions_ip_hash_index` (`ip_hash`),
  KEY `visitor_sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_sessions`
--

LOCK TABLES `visitor_sessions` WRITE;
/*!40000 ALTER TABLE `visitor_sessions` DISABLE KEYS */;
INSERT INTO `visitor_sessions` VALUES (1,'u10KqRTBkywj00v1zjhfUKsWx9DKYenM2Uv3t9bm','eff8e7ca506627fe15dda5e0e512fcaad70b6d520f37cc76597fdb4f2d83a1a3','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','desktop','http://localhost/Gauri%20suits%20&%20Jewel/public','http://localhost/Gauri%20suits%20&%20Jewel/public/','2026-09-15 05:41:17','2026-09-15 01:02:55','2026-09-15 05:41:17'),(2,'gzHXU6hMXOcKoUiJFHrk6IMebZ5xXa4Vnl714L1Z','eff8e7ca506627fe15dda5e0e512fcaad70b6d520f37cc76597fdb4f2d83a1a3','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','desktop','http://localhost/Gauri%20suits%20&%20Jewel/public','http://localhost/Gauri%20suits%20&%20Jewel/public/product/virasat-emerald-kundan-choker-set','2026-09-15 05:58:42','2026-09-15 05:45:26','2026-09-15 05:58:42');
/*!40000 ALTER TABLE `visitor_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist_items`
--

DROP TABLE IF EXISTS `wishlist_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wishlist_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlist_items_wishlist_id_product_id_unique` (`wishlist_id`,`product_id`),
  KEY `wishlist_items_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlist_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlist_items_wishlist_id_foreign` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist_items`
--

LOCK TABLES `wishlist_items` WRITE;
/*!40000 ALTER TABLE `wishlist_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-15 17:15:27
