DROP TABLE IF EXISTS accounts;

CREATE TABLE `accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_name` varchar(50) NOT NULL,
  `opening_date` date NOT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `currency` varchar(3) NOT NULL,
  `opening_balance` decimal(28,8) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_user_id_foreign` (`user_id`),
  KEY `accounts_business_id_foreign` (`business_id`),
  CONSTRAINT `accounts_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS brands;

CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `logo` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS business;

CREATE TABLE `business` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `reg_no` varchar(191) DEFAULT NULL,
  `vat_id` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_type_id` bigint(20) unsigned DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `default` tinyint(4) NOT NULL DEFAULT 0,
  `custom_fields` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_user_id_foreign` (`user_id`),
  KEY `business_business_type_id_foreign` (`business_type_id`),
  CONSTRAINT `business_business_type_id_foreign` FOREIGN KEY (`business_type_id`) REFERENCES `business_types` (`id`) ON DELETE SET NULL,
  CONSTRAINT `business_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS business_settings;

CREATE TABLE `business_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_settings_business_id_foreign` (`business_id`),
  CONSTRAINT `business_settings_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS business_types;

CREATE TABLE `business_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS business_users;

CREATE TABLE `business_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `business_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `owner_id` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_users_user_id_foreign` (`user_id`),
  KEY `business_users_business_id_foreign` (`business_id`),
  KEY `business_users_role_id_foreign` (`role_id`),
  CONSTRAINT `business_users_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `business_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `business_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS currency;

CREATE TABLE `currency` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(3) NOT NULL,
  `exchange_rate` decimal(10,6) NOT NULL,
  `base_currency` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO currency VALUES('1','AED','3.672504','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('2','AFN','87.000368','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('3','ALL','101.280403','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('4','AMD','386.350403','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('5','ANG','1.802185','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('6','AOA','509.000367','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('7','ARS','222.340722','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('8','AUD','1.479050','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('9','AWG','1.802500','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('10','AZN','1.703970','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('11','BAM','1.773984','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('12','BBD','2.019075','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('13','BDT','106.485744','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('14','BGN','1.777044','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('15','BHD','0.376968','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('16','BIF','2088.000000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('17','BMD','1.000000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('18','BND','1.324450','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('19','BOB','6.908811','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('20','BRL','4.953104','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('21','BSD','1.000014','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('22','BTC','0.000035','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('23','BTN','81.675283','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('24','BWP','13.210097','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('25','BYN','2.524093','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('26','BYR','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('27','BZD','2.015692','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('28','CAD','1.347550','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('29','CDF','2045.726604','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('30','CHF','0.897381','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('31','CLF','0.028776','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('32','CLP','794.030396','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('33','CNY','6.910604','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('34','COP','4527.050000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('35','CRC','542.601914','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('36','CUC','1.000000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('37','CUP','26.500000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('38','CVE','100.350394','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('39','CZK','21.224040','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('40','DJF','177.720394','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('41','DKK','6.762204','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('42','DOP','54.420393','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('43','DZD','135.223014','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('44','EGP','30.271596','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('45','ERN','15.000000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('46','ETB','54.210392','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('47','EUR','0.892040','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('48','FJD','2.201250','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('49','FKP','0.790702','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('50','GBP','0.791202','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('51','GEL','2.485040','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('52','GGP','0.790702','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('53','GHS','11.803858','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('54','GIP','0.790702','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('55','GMD','60.203853','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('56','GNF','8655.000355','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('57','GTQ','7.805024','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('58','GYD','211.492063','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('59','HKD','7.849950','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('60','HNL','24.660389','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('61','HRK','6.816133','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('62','HTG','150.495696','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('63','HUF','337.560388','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('64','IDR','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('65','ILS','3.636190','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('66','IMP','0.790702','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('67','INR','81.729750','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('68','IQD','1310.000000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('69','IRR','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('70','ISK','136.203816','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('71','JEP','0.790702','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('72','JMD','153.978721','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('73','JOD','0.709504','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('74','JPY','134.835040','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('75','KES','136.503804','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('76','KGS','87.306040','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('77','KHR','4128.000351','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('78','KMF','446.950384','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('79','KPW','899.911942','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('80','KRW','1317.955039','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('81','KWD','0.306320','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('82','KYD','0.833386','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('83','KZT','443.260256','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('84','LAK','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('85','LBP','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('86','LKR','320.021043','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('87','LRD','165.903775','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('88','LSL','18.410382','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('89','LTL','2.952740','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('90','LVL','0.604890','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('91','LYD','4.745039','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('92','MAD','9.992039','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('93','MDL','17.839456','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('94','MGA','4412.503758','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('95','MKD','55.882340','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('96','MMK','2099.964172','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('97','MNT','3487.813217','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('98','MOP','8.083900','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('99','MRO','356.999828','0','1','2023-03-31 15:23:24','2023-03-31 15:23:24');
INSERT INTO currency VALUES('100','MUR','45.250379','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('101','MVR','15.350378','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('102','MWK','1022.503739','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('103','MXN','17.762504','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('104','MYR','4.437039','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('105','MZN','63.250377','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('106','NAD','18.410377','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('107','NGN','461.503727','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('108','NIO','36.550377','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('109','NOK','10.569604','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('110','NPR','130.680865','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('111','NZD','1.593626','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('112','OMR','0.385010','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('113','PAB','1.000000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('114','PEN','3.700250','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('115','PGK','3.520375','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('116','PHP','55.346039','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('117','PKR','283.503704','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('118','PLN','4.153071','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('119','PYG','7168.318987','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('120','QAR','3.641038','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('121','RON','4.472204','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('122','RSD','105.705530','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('123','RUB','77.815038','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('124','RWF','1118.500000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('125','SAR','3.751078','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('126','SBD','8.299327','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('127','SCR','13.929365','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('128','SDG','598.503678','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('129','SEK','10.219050','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('130','SGD','1.326104','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('131','SHP','1.216750','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('132','SLE','22.562222','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('133','SLL','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('134','SOS','569.503664','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('135','SRD','37.297038','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('136','STD','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('137','SVC','8.750153','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('138','SYP','2512.370381','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('139','SZL','18.395038','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('140','THB','33.720369','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('141','TJS','10.919876','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('142','TMT','3.500000','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('143','TND','3.031750','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('144','TOP','2.348950','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('145','TRY','19.516704','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('146','TTD','6.780937','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('147','TWD','30.593104','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('148','TZS','2355.000335','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('149','UAH','36.937310','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('150','UGX','3719.778500','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('151','USD','1.000000','1','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('152','UYU','39.093325','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('153','UZS','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('154','VEF','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('155','VES','25.026391','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('156','VND','9999.999999','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('157','VUV','118.540791','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('158','WST','2.712426','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('159','XAF','595.016735','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('160','XAG','0.038956','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('161','XAU','0.000496','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('162','XCD','2.702550','0','1','2023-03-31 15:23:24','2023-05-06 17:26:13');
INSERT INTO currency VALUES('163','XDR','0.739504','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('164','XOF','594.503597','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('165','XPF','108.750364','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('166','YER','250.350363','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('167','ZAR','18.221455','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('169','ZMW','17.997551','0','1','2023-03-31 15:23:24','2023-05-06 17:24:02');
INSERT INTO currency VALUES('170','ZWL','321.999592','0','1','2023-03-31 15:23:24','2023-03-31 15:23:24');
INSERT INTO currency VALUES('171','ZMK','9001.203589','0','1','2023-03-31 15:51:49','2023-05-06 17:24:02');



DROP TABLE IF EXISTS customers;

CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `currency` varchar(10) NOT NULL,
  `vat_id` varchar(191) DEFAULT NULL,
  `reg_no` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `profile_picture` varchar(191) DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `custom_fields` text DEFAULT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_user_id_foreign` (`user_id`),
  KEY `customers_business_id_foreign` (`business_id`),
  CONSTRAINT `customers_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS database_backups;

CREATE TABLE `database_backups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(191) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS email_subscribers;

CREATE TABLE `email_subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email_address` varchar(191) NOT NULL,
  `ip_address` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_subscribers_email_address_unique` (`email_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS email_templates;

CREATE TABLE `email_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `email_body` text DEFAULT NULL,
  `sms_body` text DEFAULT NULL,
  `notification_body` text DEFAULT NULL,
  `shortcode` text DEFAULT NULL,
  `email_status` tinyint(4) NOT NULL DEFAULT 0,
  `sms_status` tinyint(4) NOT NULL DEFAULT 0,
  `notification_status` tinyint(4) NOT NULL DEFAULT 0,
  `template_mode` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = all, 1 = email, 2 = sms, 3 = notification',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO email_templates VALUES('1','Invite User','INVITE_USER','You\'ve been invited to collaborate','<h2>Invitation to collaborate</h2><p>{{businessName}} has invited you to collaborate as {{roleName}}</p><p>{{message}}</p><p>Accept the invitation by clicking the button below.</p><p><a href=\'{{actionUrl}}\' style=\'box-sizing: border-box; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;\'>Accept Invitation</a></p><p class=\'subcopy\' style=\'word-break: break-all; font-size: 14px;\'>If you\'re having trouble clicking the \'Accept Invitation\' button, copy and paste the URL below into your web browser: <a href=\'{{actionUrl}}\'>{{actionUrl}}</a></p>','','','{{businessName}} {{roleName}} {{message}} {{actionUrl}}','0','0','0','1','','');
INSERT INTO email_templates VALUES('2','New Invoice Created','NEW_INVOICE_CREATED','New Invoice Created','<div style=\'font-family: Arial, sans-serif; font-size: 14px;\'> <h2 style=\'color: #333333;\'>New Invoice Created</h2> <p>Dear {{customerName}},</p> <p>I am writing to let you know that a new invoice has been created for the Product/Service you ordered. The details of the invoice are as follows:</p> <ul> <li>Invoice number: <strong>{{invoiceNumber}}</strong></li> <li>Invoice date: <strong>{{invoiceDate}}</strong></li> <li>Due date: <strong>{{dueDate}}</strong></li> <li>Total amount due: <strong>{{dueAmount}}</strong></li> </ul> <p>To make the payment, please use the following details:</p> <p>{{invoiceLink}}</p> <p>Thank you for your business. We appreciate your prompt payment.</p> </div>','','','{{customerName}} {{invoiceNumber}} {{invoiceDate}} {{dueDate}} {{dueAmount}} {{invoiceLink}}','0','0','0','1','','');
INSERT INTO email_templates VALUES('3','New Quotation Created','NEW_QUOTATION_CREATED','New Quotation Created','<div style=\'font-family: Arial, sans-serif; font-size: 14px;\'> <h2 style=\'color: #333333;\'>New Quotation Created</h2> <p>Dear {{customerName}},</p> <p>I am pleased to inform you that we have created a new quotation for the Product/Service you requested. The details of the quotation are as follows:</p> <ul> <li>Quotation number: <strong>{{quotationNumber}}</strong></li> <li>Quotation date: <strong>{{quotationDate}}</strong></li> <li>Quotation expiry date: <strong>{{expiryDate}}</strong></li> <li>Total amount: <strong>{{amount}}</strong></li> </ul> <p>Please note that this quotation is valid until <strong>{{expiryDate}}</strong>. If you have any questions regarding the quotation, please do not hesitate to contact us.</p> <p><a href=\'{{quotationLink}}\'>View Quotation</a></p> <p>To proceed with the order, please confirm your acceptance of the quotation by replying to this email. Once we receive your confirmation, we will proceed with the order and send you the invoice.</p> <p>Thank you for your interest in our products/services. We look forward to doing business with you.</p> </div>','','','{{customerName}} {{quotationDate}} {{expiryDate}} {{amount}} {{quotationNumber}} {{quotationLink}}','0','0','0','1','','');
INSERT INTO email_templates VALUES('4','Invoice Payment Reminder','INVOICE_PAYMENT_REMINDER','Invoice Payment Reminder','<div style=\'font-family: Arial, sans-serif; font-size: 14px;\'> <h2 style=\'color: #333333;\'>Invoice Payment Reminder</h2> <p>Dear {{customerName}},</p> <p>I hope this email finds you well. This message is to remind you that the payment for invoice <strong>{{invoiceNumber}}</strong> is now due.</p> <p>The total amount due is <strong>{{dueAmount}}</strong>. Please ensure that the payment is made promptly to avoid any late fees or penalties.</p> <p>To make the payment, kindly use the following details:</p> <p>{{invoiceLink}}</p> <p>If you have already made the payment, please disregard this email.</p> <p>Thank you for your prompt attention to this matter. If you have any questions or concerns, please do not hesitate to contact me.</p></div>','','','{{customerName}} {{invoiceNumber}} {{invoiceDate}} {{dueDate}} {{dueAmount}} {{invoiceLink}}','0','0','0','1','','');
INSERT INTO email_templates VALUES('5','Invoice Payment Received','INVOICE_PAYMENT_RECEIVED','Invoice Payment Received','<div style=\'font-family: Arial, sans-serif; font-size: 14px;\'> <h2 style=\'color: #333333;\'>Invoice Payment Received</h2> <p>Dear {{customerName}},</p> <p>I am writing to confirm that we have received your payment for invoice <strong>{{invoiceNumber}}</strong>.</p> <p>The total amount received is <strong>{{amount}}</strong>.</p> <p>Thank you for your prompt payment. We value your business and look forward to working with you again in the future.</p> <p>If you have any questions or concerns, please do not hesitate to contact us.</p></div>','','','{{customerName}} {{amount}} {{invoiceDate}} {{paymentMethod}} {{invoiceNumber}} {{invoiceLink}}','0','0','0','1','','');
INSERT INTO email_templates VALUES('6','Trial Period Ended','TRIAL_PERIOD_ENDED','Dot Accounts Trial Ended','<div style=\'font-family: Arial, sans-serif; font-size: 14px;\'> <h2 style=\'color: #333333;\'>Dot Accounts Trial Ended</h2> <p>Dear {{customerName}},</p> <p>We hope this email finds you well. We wanted to remind you that your trial period has ended as of {{trialEndDate}}.</p> <p>We hope you found our service useful during the trial period. If you would like to continue using our service, please pay for subscription.</p> <p>If you have any questions or concerns, please do not hesitate to contact us. We are always here to help.</p> <p>Thank you for your interest in our service. We hope to continue serving you in the future.</p> </div>','','','{{customerName}} {{trialEndDate}} {{packageName}}','0','0','0','1','','');
INSERT INTO email_templates VALUES('7','Subscription Reminder','SUBSCRIPTION_REMINDER','Subscription Reminder','<div style=\'font-family: Arial, sans-serif; font-size: 14px;\'> <h2 style=\'color: #333333;\'>Dot Accounts Renewal Reminder </h2> <p>Dear {{customerName}},</p> <p>We hope this email finds you well. We wanted to remind you that your subscription is expiring on {{expiryDate}}.</p> <p>If you want to continue using our service, please renew your subscription by visiting our website and selecting a subscription plan that suits your needs.</p> <p>If you have already renewed your subscription, please disregard this email. Otherwise, please renew your subscription before the expiry date to avoid any interruption in your service.</p> <p>If you have any questions or concerns, please do not hesitate to contact us. We are always here to help.</p> <p>Thank you for choosing our service. We appreciate your business and look forward to continuing to serve you.</p> </div>','','','{{customerName}} {{expiryDate}} {{packageName}}','0','0','0','1','','');
INSERT INTO email_templates VALUES('8','Subscription Payment Confirmation','SUBSCRIPTION_PAYMENT_CONFIRMATION','Subscription Payment Confirmation','<div style=\'font-family: Arial, sans-serif; font-size: 14px;\'> <h2 style=\'color: #333333;\'>Dot Accounts Payment Confirmation</h2> <p>Dear {{customerName}},</p> <p>Thank you for renewing your subscription to (Package Name: {{packageName}}). Your payment has been received and your subscription has been renewed until {{expiryDate}}.</p> <p>You can now continue using our service without any interruption. If you have any questions or concerns, please do not hesitate to contact us. We are always here to help.</p> <p>Thank you for choosing our service. We appreciate your business and look forward to continuing to serve you.</p> </div>','','','{{customerName}} {{expiryDate}} {{packageName}}','0','0','0','1','','');



DROP TABLE IF EXISTS failed_jobs;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS faq_translations;

CREATE TABLE `faq_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `faq_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(191) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faq_translations_faq_id_locale_unique` (`faq_id`,`locale`),
  CONSTRAINT `faq_translations_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO faq_translations VALUES('1','2','English---us','What is a SaaS system?','SaaS stands for Software as a Service, which is a cloud computing model where software is provided over the internet, and users access it through a web browser without having to install or maintain any software locally.','2023-04-21 10:24:52','2023-04-21 10:24:52');
INSERT INTO faq_translations VALUES('2','3','English---us','How do I sign up for a SaaS system?','To sign up for a SaaS system, simply visit our website and click on the \"Sign Up\" or \"Get Started\" button. Follow the prompts to create an account, choose a subscription plan, and provide payment information.','2023-04-21 10:25:15','2023-04-21 10:25:15');



DROP TABLE IF EXISTS faqs;

CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO faqs VALUES('2','1','','2023-04-21 10:24:52','2023-04-21 10:24:52');
INSERT INTO faqs VALUES('3','1','','2023-04-21 10:25:15','2023-04-21 10:25:15');



DROP TABLE IF EXISTS feature_translations;

CREATE TABLE `feature_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feature_translations_feature_id_locale_unique` (`feature_id`,`locale`),
  CONSTRAINT `feature_translations_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO feature_translations VALUES('2','2','English---us','Invoice','Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.','2023-04-21 11:40:57','2023-04-24 06:59:41');
INSERT INTO feature_translations VALUES('3','3','English---us','Online Payment','Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.','2023-04-24 06:54:38','2023-04-24 06:54:38');
INSERT INTO feature_translations VALUES('4','4','English---us','Estimate','Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.','2023-04-24 06:55:12','2023-04-24 06:55:12');
INSERT INTO feature_translations VALUES('5','5','English---us','Purchase','Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.','2023-04-24 06:55:34','2023-04-24 06:55:34');
INSERT INTO feature_translations VALUES('6','6','English---us','Invoice Templates','Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.','2023-04-24 06:56:29','2023-04-24 07:00:15');
INSERT INTO feature_translations VALUES('7','7','English---us','Reports RBR','Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.','2023-04-24 06:56:55','2023-07-18 23:32:06');



DROP TABLE IF EXISTS features;

CREATE TABLE `features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(191) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO features VALUES('2','<i class=\"bi bi-receipt\"></i>','1','','2023-04-21 11:40:57','2023-04-24 06:51:57');
INSERT INTO features VALUES('3','<i class=\"bi bi-stripe\"></i>','1','','2023-04-24 06:54:38','2023-04-24 07:01:23');
INSERT INTO features VALUES('4','<i class=\"bi bi-receipt-cutoff\"></i>','1','','2023-04-24 06:55:12','2023-04-24 06:55:12');
INSERT INTO features VALUES('5','<i class=\"bi bi-bag\"></i>','1','','2023-04-24 06:55:34','2023-04-24 06:55:34');
INSERT INTO features VALUES('6','<i class=\"bi bi-palette\"></i>','1','','2023-04-24 06:56:29','2023-04-24 06:56:29');
INSERT INTO features VALUES('7','<i class=\"bi bi-bar-chart\"></i>','1','','2023-04-24 06:56:55','2023-04-24 06:56:55');



DROP TABLE IF EXISTS invoice_item_taxes;

CREATE TABLE `invoice_item_taxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `invoice_item_id` bigint(20) unsigned NOT NULL,
  `tax_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` decimal(28,8) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_item_taxes_invoice_id_foreign` (`invoice_id`),
  KEY `invoice_item_taxes_invoice_item_id_foreign` (`invoice_item_id`),
  KEY `invoice_item_taxes_user_id_foreign` (`user_id`),
  KEY `invoice_item_taxes_business_id_foreign` (`business_id`),
  CONSTRAINT `invoice_item_taxes_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_item_taxes_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_item_taxes_invoice_item_id_foreign` FOREIGN KEY (`invoice_item_id`) REFERENCES `invoice_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_item_taxes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS invoice_items;

CREATE TABLE `invoice_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_cost` decimal(28,8) NOT NULL,
  `sub_total` decimal(28,8) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  KEY `invoice_items_product_id_foreign` (`product_id`),
  KEY `invoice_items_user_id_foreign` (`user_id`),
  KEY `invoice_items_business_id_foreign` (`business_id`),
  CONSTRAINT `invoice_items_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS invoice_templates;

CREATE TABLE `invoice_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `body` longtext NOT NULL,
  `editor` longtext NOT NULL,
  `custom_css` text DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `business_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_templates_user_id_foreign` (`user_id`),
  KEY `invoice_templates_business_id_foreign` (`business_id`),
  CONSTRAINT `invoice_templates_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_templates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS invoices;

CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `order_number` varchar(100) DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `sub_total` decimal(28,8) NOT NULL,
  `grand_total` decimal(28,8) NOT NULL,
  `converted_total` decimal(28,8) DEFAULT NULL,
  `paid` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `discount` decimal(28,8) DEFAULT NULL,
  `discount_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Percentage | 1 = Fixed',
  `discount_value` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `template_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Predefined | 1 = Dynamic',
  `template` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `short_code` varchar(191) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `email_send` tinyint(4) NOT NULL DEFAULT 0,
  `email_send_at` datetime DEFAULT NULL,
  `is_recurring` tinyint(4) NOT NULL DEFAULT 0,
  `recurring_completed` int(11) NOT NULL DEFAULT 0,
  `recurring_start` date DEFAULT NULL,
  `recurring_end` date DEFAULT NULL,
  `recurring_value` int(11) DEFAULT NULL,
  `recurring_type` varchar(20) DEFAULT NULL,
  `recurring_invoice_date` date DEFAULT NULL,
  `recurring_due_date` varchar(20) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_customer_id_foreign` (`customer_id`),
  KEY `invoices_user_id_foreign` (`user_id`),
  KEY `invoices_business_id_foreign` (`business_id`),
  CONSTRAINT `invoices_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS migrations;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO migrations VALUES('1','2014_10_12_000000_create_users_table','1');
INSERT INTO migrations VALUES('2','2014_10_12_100000_create_password_reset_tokens_table','1');
INSERT INTO migrations VALUES('3','2019_08_19_000000_create_failed_jobs_table','1');
INSERT INTO migrations VALUES('4','2019_09_01_080940_create_settings_table','1');
INSERT INTO migrations VALUES('5','2019_09_01_080941_create_setting_translations','1');
INSERT INTO migrations VALUES('6','2020_07_02_145857_create_database_backups_table','1');
INSERT INTO migrations VALUES('7','2021_07_02_145504_create_pages_table','1');
INSERT INTO migrations VALUES('8','2021_07_02_145952_create_page_translations_table','1');
INSERT INTO migrations VALUES('9','2021_08_07_111236_create_currency_table','1');
INSERT INTO migrations VALUES('10','2021_08_08_132702_create_payment_gateways_table','1');
INSERT INTO migrations VALUES('11','2021_10_22_070458_create_email_templates_table','1');
INSERT INTO migrations VALUES('12','2022_08_09_160105_create_notifications_table','1');
INSERT INTO migrations VALUES('13','2023_03_16_070314_create_packages_table','1');
INSERT INTO migrations VALUES('14','2023_03_16_165256_create_subscription_payments_table','1');
INSERT INTO migrations VALUES('15','2023_03_16_175321_create_business_types_table','1');
INSERT INTO migrations VALUES('16','2023_03_17_141421_create_business_table','1');
INSERT INTO migrations VALUES('17','2023_03_17_142542_create_business_settings_table','1');
INSERT INTO migrations VALUES('18','2023_03_19_082601_create_roles_table','1');
INSERT INTO migrations VALUES('19','2023_03_19_082603_create_business_users_table','1');
INSERT INTO migrations VALUES('20','2023_03_19_143240_create_permissions_table','1');
INSERT INTO migrations VALUES('21','2023_03_20_155534_create_user_invitations_table','1');
INSERT INTO migrations VALUES('22','2023_03_24_082007_create_customers_table','1');
INSERT INTO migrations VALUES('23','2023_03_24_144435_create_vendors_table','1');
INSERT INTO migrations VALUES('24','2023_03_24_153805_create_product_units_table','1');
INSERT INTO migrations VALUES('25','2023_03_24_164804_create_transaction_categories_table','1');
INSERT INTO migrations VALUES('26','2023_03_24_165807_create_products_table','1');
INSERT INTO migrations VALUES('27','2023_03_25_104515_create_taxes_table','1');
INSERT INTO migrations VALUES('28','2023_03_25_142805_create_invoices_table','1');
INSERT INTO migrations VALUES('29','2023_03_25_142811_create_invoice_items_table','1');
INSERT INTO migrations VALUES('30','2023_03_25_142828_create_invoice_item_taxes_table','1');
INSERT INTO migrations VALUES('31','2023_03_29_074346_create_quotations_table','1');
INSERT INTO migrations VALUES('32','2023_03_29_074359_create_quotation_items_table','1');
INSERT INTO migrations VALUES('33','2023_03_29_074418_create_quotation_item_taxes_table','1');
INSERT INTO migrations VALUES('34','2023_03_29_171700_create_invoice_templates_table','1');
INSERT INTO migrations VALUES('35','2023_04_06_111313_create_purchases_table','1');
INSERT INTO migrations VALUES('36','2023_04_06_111323_create_purchase_items_table','1');
INSERT INTO migrations VALUES('37','2023_04_06_111333_create_purchase_item_taxes_table','1');
INSERT INTO migrations VALUES('38','2023_04_06_111434_create_accounts_table','1');
INSERT INTO migrations VALUES('39','2023_04_07_080205_create_transaction_methods_table','1');
INSERT INTO migrations VALUES('40','2023_04_07_080306_create_transactions_table','1');
INSERT INTO migrations VALUES('41','2023_04_18_010306_create_faqs_table','1');
INSERT INTO migrations VALUES('42','2023_04_18_020307_create_faq_translations_table','1');
INSERT INTO migrations VALUES('43','2023_04_21_111229_create_features_table','1');
INSERT INTO migrations VALUES('44','2023_04_21_111241_create_feature_translations_table','1');
INSERT INTO migrations VALUES('45','2023_04_21_151904_create_testimonials_table','1');
INSERT INTO migrations VALUES('46','2023_04_21_151921_create_testimonial_translations_table','1');
INSERT INTO migrations VALUES('47','2023_04_21_154002_create_teams_table','1');
INSERT INTO migrations VALUES('48','2023_04_21_154010_create_team_translations_table','1');
INSERT INTO migrations VALUES('49','2023_04_21_160041_create_posts_table','1');
INSERT INTO migrations VALUES('50','2023_04_21_160048_create_post_translations_table','1');
INSERT INTO migrations VALUES('51','2023_04_21_163645_create_brands_table','1');
INSERT INTO migrations VALUES('52','2023_04_24_142555_create_post_comments_table','1');
INSERT INTO migrations VALUES('53','2023_05_02_144104_create_email_subscribers_table','1');
INSERT INTO migrations VALUES('54','2023_05_25_083601_update_business_table','1');
INSERT INTO migrations VALUES('55','2023_05_29_170209_update_products_and_transactions_table','1');



DROP TABLE IF EXISTS notifications;

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS packages;

CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `package_type` varchar(30) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_popular` tinyint(4) NOT NULL DEFAULT 0,
  `discount` decimal(10,2) DEFAULT NULL,
  `trial_days` int(11) NOT NULL DEFAULT 0,
  `user_limit` varchar(191) DEFAULT NULL,
  `invoice_limit` varchar(191) DEFAULT NULL,
  `quotation_limit` varchar(191) DEFAULT NULL,
  `recurring_invoice` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = Yes | 0 = No',
  `customer_limit` varchar(191) DEFAULT NULL,
  `business_limit` varchar(191) DEFAULT NULL,
  `invoice_builder` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = Yes | 0 = No',
  `online_invoice_payment` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = Yes | 0 = No',
  `others` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO packages VALUES('1','Starter','monthly','10.00','1','0','10.00','7','2','50','50','0','20','2','0','0','','2023-03-16 14:19:59','2023-05-05 08:29:09');
INSERT INTO packages VALUES('2','Standard','monthly','20.00','1','1','10.00','0','5','100','100','1','50','3','0','1','','2023-03-16 14:30:29','2023-05-04 10:08:35');
INSERT INTO packages VALUES('3','Professional','monthly','30.00','1','0','5.00','0','10','500','500','1','100','10','1','1','','2023-03-16 14:33:39','2023-03-16 14:33:39');
INSERT INTO packages VALUES('4','Starter','yearly','100.00','1','0','0.00','0','5','1000','1000','0','100','5','0','0','','2023-03-16 14:40:50','2023-03-16 14:40:50');
INSERT INTO packages VALUES('5','Standard','yearly','210.00','1','1','5.00','0','10','2000','200','1','200','20','1','1','','2023-03-16 14:46:19','2023-03-16 14:50:49');
INSERT INTO packages VALUES('6','Professional','yearly','300.00','1','0','0.00','0','20','-1','-1','1','-1','20','1','1','','2023-03-16 14:48:56','2023-03-16 14:48:56');
INSERT INTO packages VALUES('7','Lifetime Gold','lifetime','499.00','1','0','0.00','0','10','-1','-1','1','-1','-1','1','1','','2023-04-24 07:15:56','2023-04-24 07:15:56');



DROP TABLE IF EXISTS page_translations;

CREATE TABLE `page_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(191) NOT NULL,
  `title` text NOT NULL,
  `body` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_translations_page_id_locale_unique` (`page_id`,`locale`),
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO page_translations VALUES('4','3','English---us','Terms & Condition','<h2>Terms and Conditions</h2>
<p>Welcome to our website. By accessing and using our website, you agree to comply with and be bound by the following terms and conditions:</p>
<p> </p>
<h3>1. Intellectual Property</h3>
<p>All content on this website, including but not limited to text, graphics, logos, images, and software, is the property of our company and is protected by intellectual property laws.</p>
<p> </p>
<h3>2. Use of Website</h3>
<p>You may use our website for personal and non-commercial purposes only. You may not use our website for any illegal or unauthorized purpose, including but not limited to transmitting harmful code or attempting to gain unauthorized access to our systems.</p>
<p> </p>
<h3>3. Privacy</h3>
<p>We respect your privacy and will handle your personal information in accordance with our Privacy Policy. By using our website, you consent to the collection, use, and disclosure of your personal information as described in our Privacy Policy.</p>
<p> </p>
<h3>4. Links to Third-Party Websites</h3>
<p>Our website may contain links to third-party websites. We do not endorse or control the content or policies of these websites, and your use of such websites is at your own risk.</p>
<p> </p>
<h3>5. Disclaimer of Warranties</h3>
<p>Our website is provided on an \"as is\" and \"as available\" basis, without warranties of any kind, including but not limited to implied warranties of merchantability, fitness for a particular purpose, and non-infringement. We do not guarantee that our website will be uninterrupted, error-free, or free from harmful code.</p>
<p> </p>
<h3>6. Limitation of Liability</h3>
<p>In no event shall our company be liable for any direct, indirect, incidental, consequential, special, or exemplary damages arising out of or in connection with your use of our website, even if we have been advised of the possibility of such damages.</p>
<p> </p>
<h3>7. Governing Law</h3>
<p>These terms and conditions shall be governed by and construed in accordance with the laws of [insert applicable jurisdiction].</p>
<p> </p>
<h3>8. Changes to Terms and Conditions</h3>
<p>We reserve the right to modify or update these terms and conditions at any time, without prior notice. Your continued use of our website after any changes to these terms and conditions will constitute your acceptance of such changes.</p>
<p> </p>
<h3>9. Contact Us</h3>
<p>If you have any questions or concerns about these terms and conditions, please contact us at [insert contact information].</p>','2023-04-24 08:53:24','2023-04-24 10:07:21');
INSERT INTO page_translations VALUES('5','4','English---us','Privacy Policy','<h2>Privacy Policy</h2>
<p>We are committed to protecting your privacy. This privacy policy explains how we collect, use, and disclose your personal information when you use our website:</p>
<p> </p>
<h3>1. Information We Collect</h3>
<p>We may collect various types of information from you, including but not limited to:</p>
<ul>
<li>Personal information such as your name, email address, and contact details.</li>
<li>Usage information such as your IP address, browser type, and pages visited on our website.</li>
<li>Cookies and other tracking technologies that may be used to collect information about your browsing behavior on our website.</li>
</ul>
<h3> </h3>
<h3>2. Use of Information</h3>
<p>We may use your personal information for the following purposes:</p>
<ul>
<li>To provide and improve our services, products, and website.</li>
<li>To communicate with you and respond to your inquiries.</li>
<li>To send you promotional offers and updates with your consent, which you may opt out of at any time.</li>
<li>To comply with legal and regulatory requirements.</li>
</ul>
<h3> </h3>
<h3>3. Disclosure of Information</h3>
<p>We may disclose your personal information to third parties in the following circumstances:</p>
<ul>
<li>To service providers who assist us in operating our website and conducting our business.</li>
<li>To comply with legal and regulatory requirements, or to protect our rights and property.</li>
<li>With your consent, or as otherwise required or permitted by law.</li>
</ul>
<h3> </h3>
<h3>4. Security</h3>
<p>We take appropriate measures to protect the security of your personal information, but please be aware that no method of transmission over the internet or electronic storage is completely secure.</p>
<h3> </h3>
<h3>5. Links to Third-Party Websites</h3>
<p>Our website may contain links to third-party websites. We do not endorse or control the content or policies of these websites, and our privacy policy does not apply to them. Please review the privacy policies of these third-party websites before providing them with any personal information.</p>
<h3> </h3>
<h3>6. Children\'s Privacy</h3>
<p>Our website is not intended for children under the age of 13. We do not knowingly collect personal information from children under the age of 13. If we become aware that we have collected personal information from a child under the age of 13, we will take steps to delete such information.</p>
<h3> </h3>
<h3>7. Changes to Privacy Policy</h3>
<p>We reserve the right to modify or update this privacy policy at any time, without prior notice. Your continued use of our website after any changes to this privacy policy will constitute your acceptance of such changes.</p>
<h3> </h3>
<h3>8. Contact Us</h3>
<p>If you have any questions or concerns about our privacy policy, please contact us at [insert contact information].</p>','2023-04-24 08:54:30','2023-04-24 10:09:16');



DROP TABLE IF EXISTS pages;

CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO pages VALUES('3','terms-condition','1','2023-04-24 08:53:24','2023-04-24 08:53:24');
INSERT INTO pages VALUES('4','privacy-policy','1','2023-04-24 08:54:30','2023-04-24 08:54:30');



DROP TABLE IF EXISTS password_reset_tokens;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS payment_gateways;

CREATE TABLE `payment_gateways` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_crypto` tinyint(4) NOT NULL DEFAULT 0,
  `parameters` text DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO payment_gateways VALUES('1','PayPal','PayPal','paypal.png','0','0','{\"client_id\":\"\",\"client_secret\":\"\",\"environment\":\"sandbox\"}','','','');
INSERT INTO payment_gateways VALUES('2','Stripe','Stripe','stripe.png','0','0','{\"secret_key\":\"\",\"publishable_key\":\"\"}','','','');
INSERT INTO payment_gateways VALUES('3','Razorpay','Razorpay','razorpay.png','0','0','{\"razorpay_key_id\":\"\",\"razorpay_key_secret\":\"\"}','','','');
INSERT INTO payment_gateways VALUES('4','Paystack','Paystack','paystack.png','0','0','{\"paystack_public_key\":\"\",\"paystack_secret_key\":\"\"}','','','');
INSERT INTO payment_gateways VALUES('5','Flutterwave','Flutterwave','flutterwave.png','0','0','{\"public_key\":\"\",\"secret_key\":\"\",\"encryption_key\":\"\",\"environment\":\"sandbox\"}','','','');
INSERT INTO payment_gateways VALUES('6','Mollie','Mollie','Mollie.png','0','0','{\"api_key\":\"\"}','','','');
INSERT INTO payment_gateways VALUES('7','Instamojo','Instamojo','instamojo.png','0','0','{\"api_key\":\"\",\"auth_token\":\"\",\"salt\":\"\",\"environment\":\"sandbox\"}','','','');



DROP TABLE IF EXISTS permissions;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) NOT NULL,
  `permission` varchar(191) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_user_id_foreign` (`user_id`),
  CONSTRAINT `permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS post_comments;

CREATE TABLE `post_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(191) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_comments_user_id_foreign` (`user_id`),
  KEY `post_comments_post_id_foreign` (`post_id`),
  KEY `post_comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `post_comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `post_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS post_translations;

CREATE TABLE `post_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `short_description` text NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_translations_post_id_locale_unique` (`post_id`,`locale`),
  CONSTRAINT `post_translations_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO post_translations VALUES('4','3','English---us','There are many variations of passages of Lorem Ipsum available','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>','2023-04-24 08:05:19','2023-04-24 08:05:19');
INSERT INTO post_translations VALUES('5','4','English---us','It is a long established fact that a reader will be distracted','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
<p> </p>
<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.</p>','2023-04-24 08:06:20','2023-04-24 08:06:20');
INSERT INTO post_translations VALUES('6','5','English---us','Where does it come from?','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur','<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>
<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>','2023-04-24 08:06:46','2023-04-24 08:06:46');



DROP TABLE IF EXISTS posts;

CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO posts VALUES('3','there-are-many-variations-of-passages-of-lorem-ipsum-available','default.png','1','1','2023-04-24 08:05:19','2023-04-24 08:05:19');
INSERT INTO posts VALUES('4','it-is-a-long-established-fact-that-a-reader-will-be-distracted','default.png','1','1','2023-04-24 08:06:20','2023-04-24 08:06:20');
INSERT INTO posts VALUES('5','where-does-it-come-from-','default.png','1','1','2023-04-24 08:06:46','2023-04-24 08:06:46');



DROP TABLE IF EXISTS product_units;

CREATE TABLE `product_units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unit` varchar(30) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_units_user_id_foreign` (`user_id`),
  KEY `product_units_business_id_foreign` (`business_id`),
  CONSTRAINT `product_units_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_units_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS products;

CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `type` varchar(10) NOT NULL COMMENT 'product || service',
  `product_unit_id` bigint(20) unsigned DEFAULT NULL,
  `purchase_cost` decimal(28,8) DEFAULT NULL,
  `selling_price` decimal(28,8) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `stock_management` tinyint(4) NOT NULL DEFAULT 0,
  `stock` decimal(10,2) DEFAULT NULL,
  `allow_for_selling` tinyint(4) NOT NULL DEFAULT 0,
  `allow_for_purchasing` tinyint(4) NOT NULL DEFAULT 0,
  `income_category_id` bigint(20) unsigned DEFAULT NULL,
  `expense_category_id` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_product_unit_id_foreign` (`product_unit_id`),
  KEY `products_user_id_foreign` (`user_id`),
  KEY `products_business_id_foreign` (`business_id`),
  KEY `products_income_category_id_foreign` (`income_category_id`),
  KEY `products_expense_category_id_foreign` (`expense_category_id`),
  CONSTRAINT `products_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_expense_category_id_foreign` FOREIGN KEY (`expense_category_id`) REFERENCES `transaction_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_income_category_id_foreign` FOREIGN KEY (`income_category_id`) REFERENCES `transaction_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_product_unit_id_foreign` FOREIGN KEY (`product_unit_id`) REFERENCES `product_units` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS purchase_item_taxes;

CREATE TABLE `purchase_item_taxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) unsigned NOT NULL,
  `purchase_item_id` bigint(20) unsigned NOT NULL,
  `tax_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` decimal(28,8) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_item_taxes_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_item_taxes_purchase_item_id_foreign` (`purchase_item_id`),
  KEY `purchase_item_taxes_user_id_foreign` (`user_id`),
  KEY `purchase_item_taxes_business_id_foreign` (`business_id`),
  CONSTRAINT `purchase_item_taxes_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_item_taxes_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_item_taxes_purchase_item_id_foreign` FOREIGN KEY (`purchase_item_id`) REFERENCES `purchase_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_item_taxes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS purchase_items;

CREATE TABLE `purchase_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_cost` decimal(28,8) NOT NULL,
  `sub_total` decimal(28,8) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_items_product_id_foreign` (`product_id`),
  KEY `purchase_items_user_id_foreign` (`user_id`),
  KEY `purchase_items_business_id_foreign` (`business_id`),
  CONSTRAINT `purchase_items_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS purchases;

CREATE TABLE `purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) unsigned NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `bill_no` varchar(100) DEFAULT NULL,
  `po_so_number` varchar(100) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `due_date` date NOT NULL,
  `sub_total` decimal(28,8) NOT NULL,
  `grand_total` decimal(28,8) NOT NULL,
  `converted_total` decimal(28,8) DEFAULT NULL,
  `paid` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `discount` decimal(28,8) DEFAULT NULL,
  `discount_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Percentage | 1 = Fixed',
  `discount_value` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `template_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Predefined | 1 = Dynamic',
  `template` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `short_code` varchar(191) DEFAULT NULL,
  `email_send` tinyint(4) NOT NULL DEFAULT 0,
  `email_send_at` datetime DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_vendor_id_foreign` (`vendor_id`),
  KEY `purchases_user_id_foreign` (`user_id`),
  KEY `purchases_business_id_foreign` (`business_id`),
  CONSTRAINT `purchases_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS quotation_item_taxes;

CREATE TABLE `quotation_item_taxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint(20) unsigned NOT NULL,
  `quotation_item_id` bigint(20) unsigned NOT NULL,
  `tax_id` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` decimal(28,8) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotation_item_taxes_quotation_id_foreign` (`quotation_id`),
  KEY `quotation_item_taxes_quotation_item_id_foreign` (`quotation_item_id`),
  KEY `quotation_item_taxes_user_id_foreign` (`user_id`),
  KEY `quotation_item_taxes_business_id_foreign` (`business_id`),
  CONSTRAINT `quotation_item_taxes_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotation_item_taxes_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotation_item_taxes_quotation_item_id_foreign` FOREIGN KEY (`quotation_item_id`) REFERENCES `quotation_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotation_item_taxes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS quotation_items;

CREATE TABLE `quotation_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_cost` decimal(28,8) NOT NULL,
  `sub_total` decimal(28,8) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotation_items_quotation_id_foreign` (`quotation_id`),
  KEY `quotation_items_product_id_foreign` (`product_id`),
  KEY `quotation_items_user_id_foreign` (`user_id`),
  KEY `quotation_items_business_id_foreign` (`business_id`),
  CONSTRAINT `quotation_items_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotation_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotation_items_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotation_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS quotations;

CREATE TABLE `quotations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `quotation_number` varchar(100) NOT NULL,
  `po_so_number` varchar(100) DEFAULT NULL,
  `quotation_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `sub_total` decimal(28,8) NOT NULL,
  `grand_total` decimal(28,8) NOT NULL,
  `converted_total` decimal(28,8) DEFAULT NULL,
  `discount` decimal(28,8) DEFAULT NULL,
  `discount_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Percentage | 1 = Fixed',
  `discount_value` decimal(10,2) DEFAULT NULL,
  `template_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Predefined | 1 = Dynamic',
  `template` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `short_code` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotations_customer_id_foreign` (`customer_id`),
  KEY `quotations_user_id_foreign` (`user_id`),
  KEY `quotations_business_id_foreign` (`business_id`),
  CONSTRAINT `quotations_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_user_id_foreign` (`user_id`),
  CONSTRAINT `roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS setting_translations;

CREATE TABLE `setting_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `setting_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_translations_setting_id_locale_unique` (`setting_id`,`locale`),
  CONSTRAINT `setting_translations_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO setting_translations VALUES('3','27','English---us','{\"title\":\"Home - Dot Accounts\",\"hero_heading\":\"Start Your Business & Manage Business With Dot Accounts\",\"hero_sub_heading\":\"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.\",\"get_started_text\":\"Get Started\",\"get_started_link\":\"\",\"features_status\":\"1\",\"features_heading\":\"Explore Our Features\",\"features_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"pricing_status\":\"1\",\"pricing_heading\":\"Check Our Pricing\",\"pricing_sub_heading\":\"Best pricing plan for all level of customers. Choose the best one for your business.\",\"blog_status\":\"1\",\"blog_heading\":\"Recent posts form our Blog\",\"blog_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"testimonials_status\":\"1\",\"testimonials_heading\":\"What Customers Say About Us\",\"testimonials_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"newsletter_status\":\"1\",\"newsletter_heading\":\"Subscribe Our Newsletter\",\"newsletter_sub_heading\":\"We care about privacy, and will never share your data.\"}','2023-04-22 10:50:19','2023-05-19 17:03:23');
INSERT INTO setting_translations VALUES('5','35','English---us','{\"title\":\"About Us\",\"section_1_heading\":\"What is Dot Accounts?\",\"section_1_content\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<\\/p>\\r\\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<\\/p>\",\"section_2_heading\":\"Who We Are?\",\"section_2_content\":\"<p class=\\\"lead\\\">Insight loan advisors is completely independent loan advising service and our directory of lenders gives you all the information lorem ipsums sitamets.<\\/p>\\r\\n<div class=\\\"content\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Consv peent esque urna. Ac eu fringilla intea dger egadv estas ut. Sed vulutate aenean nunc quis a urna morbi id vitae. Vulpuate nisl<\\/div>\",\"section_3_heading\":\"What We Offer?\",\"section_3_content\":\"<p class=\\\"lead\\\">Our loan sanction is one of the quicke with eas documentation and doorstep lorem ipsum serviceullam dolor sitisi.<\\/p>\\r\\n<div class=\\\"content\\\">\\r\\n<ul>\\r\\n<li>Habit building in essential steps choose habit<\\/li>\\r\\n<li>Get an overview of Habit Calendars Latest Posts<\\/li>\\r\\n<li>Start building habit with Habitify on platform<\\/li>\\r\\n<\\/ul>\\r\\n<\\/div>\",\"team_status\":\"1\",\"team_heading\":\"People Behind Us\",\"team_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 14:51:55','2023-04-23 14:51:55');
INSERT INTO setting_translations VALUES('6','37','English---us','{\"title\":\"Pricing\",\"pricing_heading\":\"Check Our Pricing\",\"pricing_sub_heading\":\"Best pricing plan for all level of customers. Choose the best one for your business.\"}','2023-04-23 15:03:41','2023-04-24 10:49:49');
INSERT INTO setting_translations VALUES('7','38','English---us','{\"title\":\"Features\",\"features_status\":\"1\",\"features_heading\":\"Explore Our Features\",\"features_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:04:16','2023-04-23 15:04:16');
INSERT INTO setting_translations VALUES('8','39','English---us','{\"title\":\"Blogs\",\"blogs_status\":\"1\",\"blogs_heading\":\"Recent posts form our Blog\",\"blogs_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:06:31','2023-04-23 15:06:31');
INSERT INTO setting_translations VALUES('9','40','English---us','{\"title\":\"FAQ\",\"features_status\":\"1\",\"features_heading\":\"Frequently Asked Questions\",\"features_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:08:17','2023-04-23 15:08:17');
INSERT INTO setting_translations VALUES('10','41','English---us','{\"title\":\"FAQ\",\"faq_status\":\"1\",\"faq_heading\":\"Frequently Asked Questions\",\"faq_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:10:21','2023-04-23 15:10:21');
INSERT INTO setting_translations VALUES('11','42','English---us','{\"title\":\"Get in touch\",\"contact_form_heading\":\"Let\\u2019s get connected\",\"contact_form_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"contact_info_heading\":[\"Still Have Questions?\",\"Opening hours\",\"Office Address\"],\"contact_info_content\":[\" <span>Call Us We Will Be Happy To Help\\r\\n<br><a href=\\\"tel:+3301563965\\\">+3301563965<\\/a><\\/span>\",\"<span>Monday - Friday\\r\\n<br>9AM - 8PM (Eastern Time)<\\/span>\",\"<span>\\r\\n34 Balonne Street<br>\\r\\nDeauville, New South Wales<br>\\r\\nCountry  Australia\\r\\n<\\/span>\"],\"facebook_link\":\"#\",\"linkedin_link\":\"#\",\"twitter_link\":\"#\",\"youtube_link\":\"#\"}','2023-04-23 15:15:58','2023-04-23 15:59:36');
INSERT INTO setting_translations VALUES('12','43','English---us','{\"top_header_color\":\"#5034fc\",\"footer_color\":\"#061E5C\",\"widget_1_heading\":\"About Us\",\"widget_1_content\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\"widget_2_heading\":\"Customer Service\",\"widget_2_menus\":[\"faq\",\"contact\",\"terms-condition\",\"privacy-policy\"],\"widget_3_heading\":\"Quick Explore\",\"widget_3_menus\":[\"home\",\"about\",\"features\",\"pricing\",\"blogs\"],\"copyright_text\":\"<p>Copyright \\u00a9 2023 <a href=\\\"#\\\" target=\\\"_blank\\\">Hobby Tech<\\/a>  -  All Rights Reserved.<\\/p>\",\"custom_css\":\"\",\"custom_js\":\"\"}','2023-04-23 17:27:32','2023-07-18 23:35:38');
INSERT INTO setting_translations VALUES('13','55','Spanish---es','{\"cookie_message\":\"Usamos cookies para mejorar su experiencia de navegaci\\u00f3n, mostrar anuncios o contenido personalizados y analizar nuestro tr\\u00e1fico. Al hacer clic en \\\"Aceptar\\\", acepta nuestro uso de cookies.\"}','2023-05-18 08:26:05','2023-05-18 08:26:48');
INSERT INTO setting_translations VALUES('14','55','English---us','{\"cookie_consent_status\":\"1\",\"cookie_message\":\"We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking \\\"Accept\\\", you consent to our use of cookies.\"}','2023-05-18 08:26:10','2023-05-19 17:10:12');



DROP TABLE IF EXISTS settings;

CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings VALUES('1','mail_type','smtp','','');
INSERT INTO settings VALUES('2','backend_direction','ltr','','');
INSERT INTO settings VALUES('3','email_verification','0','','');
INSERT INTO settings VALUES('4','member_signup','1','','');
INSERT INTO settings VALUES('5','language','English---us','','');
INSERT INTO settings VALUES('6','currency','USD','','');
INSERT INTO settings VALUES('7','company_name','RBR','2023-07-17 19:21:06','2023-07-17 19:21:06');
INSERT INTO settings VALUES('8','site_title','ERP','2023-07-17 19:21:06','2023-07-17 19:21:06');
INSERT INTO settings VALUES('9','phone','01729762344','2023-07-17 19:21:06','2023-07-17 19:21:06');
INSERT INTO settings VALUES('10','email','rbraju3m@gmail.com','2023-07-17 19:21:06','2023-07-17 19:21:06');
INSERT INTO settings VALUES('11','timezone','Asia/Dhaka','2023-07-17 19:21:06','2023-07-17 19:21:06');
INSERT INTO settings VALUES('27','home_page','{\"title\":\"Home - Dot Accounts\",\"hero_heading\":\"Start Your Business & Manage Business With Dot Accounts\",\"hero_sub_heading\":\"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.\",\"get_started_text\":\"Get Started\",\"get_started_link\":\"\",\"features_status\":\"1\",\"features_heading\":\"Explore Our Features\",\"features_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"pricing_status\":\"1\",\"pricing_heading\":\"Check Our Pricing\",\"pricing_sub_heading\":\"Best pricing plan for all level of customers. Choose the best one for your business.\",\"blog_status\":\"1\",\"blog_heading\":\"Recent posts form our Blog\",\"blog_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"testimonials_status\":\"1\",\"testimonials_heading\":\"What Customers Say About Us\",\"testimonials_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"newsletter_status\":\"1\",\"newsletter_heading\":\"Subscribe Our Newsletter\",\"newsletter_sub_heading\":\"We care about privacy, and will never share your data.\"}','2023-04-22 10:50:19','2023-05-19 17:03:23');
INSERT INTO settings VALUES('35','about_page','{\"title\":\"About Us\",\"section_1_heading\":\"What is Dot Accounts?\",\"section_1_content\":\"<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<\\/p>\\r\\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<\\/p>\",\"section_2_heading\":\"Who We Are?\",\"section_2_content\":\"<p class=\\\"lead\\\">Insight loan advisors is completely independent loan advising service and our directory of lenders gives you all the information lorem ipsums sitamets.<\\/p>\\r\\n<div class=\\\"content\\\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Consv peent esque urna. Ac eu fringilla intea dger egadv estas ut. Sed vulutate aenean nunc quis a urna morbi id vitae. Vulpuate nisl<\\/div>\",\"section_3_heading\":\"What We Offer?\",\"section_3_content\":\"<p class=\\\"lead\\\">Our loan sanction is one of the quicke with eas documentation and doorstep lorem ipsum serviceullam dolor sitisi.<\\/p>\\r\\n<div class=\\\"content\\\">\\r\\n<ul>\\r\\n<li>Habit building in essential steps choose habit<\\/li>\\r\\n<li>Get an overview of Habit Calendars Latest Posts<\\/li>\\r\\n<li>Start building habit with Habitify on platform<\\/li>\\r\\n<\\/ul>\\r\\n<\\/div>\",\"team_status\":\"1\",\"team_heading\":\"People Behind Us\",\"team_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 14:51:55','2023-04-23 14:59:05');
INSERT INTO settings VALUES('37','pricing_page','{\"title\":\"Pricing\",\"pricing_heading\":\"Check Our Pricing\",\"pricing_sub_heading\":\"Best pricing plan for all level of customers. Choose the best one for your business.\"}','2023-04-23 15:03:41','2023-04-24 10:49:49');
INSERT INTO settings VALUES('38','features_page','{\"title\":\"Features\",\"features_status\":\"1\",\"features_heading\":\"Explore Our Features\",\"features_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:04:16','2023-04-23 15:04:16');
INSERT INTO settings VALUES('39','blogs_page','{\"title\":\"Blogs\",\"blogs_status\":\"1\",\"blogs_heading\":\"Recent posts form our Blog\",\"blogs_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:06:31','2023-04-23 15:06:31');
INSERT INTO settings VALUES('40','feq_page','{\"title\":\"FAQ\",\"features_status\":\"1\",\"features_heading\":\"Frequently Asked Questions\",\"features_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:08:17','2023-04-23 15:08:17');
INSERT INTO settings VALUES('41','faq_page','{\"title\":\"FAQ\",\"faq_status\":\"1\",\"faq_heading\":\"Frequently Asked Questions\",\"faq_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\"}','2023-04-23 15:10:21','2023-04-23 15:10:21');
INSERT INTO settings VALUES('42','contact_page','{\"title\":\"Get in touch\",\"contact_form_heading\":\"Let\\u2019s get connected\",\"contact_form_sub_heading\":\"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.\",\"contact_info_heading\":[\"Still Have Questions?\",\"Opening hours\",\"Office Address\"],\"contact_info_content\":[\" <span>Call Us We Will Be Happy To Help\\r\\n<br><a href=\\\"tel:+3301563965\\\">+3301563965<\\/a><\\/span>\",\"<span>Monday - Friday\\r\\n<br>9AM - 8PM (Eastern Time)<\\/span>\",\"<span>\\r\\n34 Balonne Street<br>\\r\\nDeauville, New South Wales<br>\\r\\nCountry  Australia\\r\\n<\\/span>\"],\"facebook_link\":\"#\",\"linkedin_link\":\"#\",\"twitter_link\":\"#\",\"youtube_link\":\"#\"}','2023-04-23 15:15:58','2023-04-23 15:59:36');
INSERT INTO settings VALUES('43','header_footer_page','{\"top_header_color\":\"#5034fc\",\"footer_color\":\"#061E5C\",\"widget_1_heading\":\"About Us\",\"widget_1_content\":\"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\",\"widget_2_heading\":\"Customer Service\",\"widget_2_menus\":[\"faq\",\"contact\",\"terms-condition\",\"privacy-policy\"],\"widget_3_heading\":\"Quick Explore\",\"widget_3_menus\":[\"home\",\"about\",\"features\",\"pricing\",\"blogs\"],\"copyright_text\":\"<p>Copyright \\u00a9 2023 <a href=\\\"#\\\" target=\\\"_blank\\\">Hobby Tech<\\/a>  -  All Rights Reserved.<\\/p>\",\"custom_css\":\"\",\"custom_js\":\"\"}','2023-04-23 17:27:32','2023-07-18 23:35:38');
INSERT INTO settings VALUES('55','gdpr_cookie_consent_page','{\"cookie_consent_status\":\"1\",\"cookie_message\":\"We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking \\\"Accept\\\", you consent to our use of cookies.\"}','2023-05-18 08:26:05','2023-05-19 17:10:12');



DROP TABLE IF EXISTS subscription_payments;

CREATE TABLE `subscription_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `order_id` varchar(191) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `package_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscription_payments_user_id_foreign` (`user_id`),
  CONSTRAINT `subscription_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS taxes;

CREATE TABLE `taxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `tax_number` varchar(50) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taxes_user_id_foreign` (`user_id`),
  KEY `taxes_business_id_foreign` (`business_id`),
  CONSTRAINT `taxes_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `taxes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS team_translations;

CREATE TABLE `team_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `role` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_translations_team_id_locale_unique` (`team_id`,`locale`),
  CONSTRAINT `team_translations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO team_translations VALUES('1','1','English---us','Jhon Doe','Founder & CEO','Serial angel investor and entrepreneur, Jack has founded multiple successful startups prior to Sigma.','2023-04-21 15:51:25','2023-04-24 10:41:11');
INSERT INTO team_translations VALUES('5','5','English---us','Robert Costa','Technical Director','Serial angel investor and entrepreneur, Jack has founded multiple successful startups prior to Sigma.','2023-04-24 10:43:54','2023-04-24 10:43:54');
INSERT INTO team_translations VALUES('6','6','English---us','Holly Lee','Support Enginner','Serial angel investor and entrepreneur, Jack has founded multiple successful startups prior to Sigma.','2023-04-24 10:44:15','2023-04-24 10:44:15');



DROP TABLE IF EXISTS teams;

CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO teams VALUES('1','default/client-placeholder.png','2023-04-21 15:51:25','2023-04-24 10:43:04');
INSERT INTO teams VALUES('5','default/client-placeholder.png','2023-04-24 10:43:54','2023-04-24 10:43:54');
INSERT INTO teams VALUES('6','default/client-placeholder.png','2023-04-24 10:44:15','2023-04-24 10:44:15');



DROP TABLE IF EXISTS testimonial_translations;

CREATE TABLE `testimonial_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `testimonial_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `testimonial` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `testimonial_translations_testimonial_id_locale_unique` (`testimonial_id`,`locale`),
  CONSTRAINT `testimonial_translations_testimonial_id_foreign` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO testimonial_translations VALUES('1','1','English---us','Jhon Doe','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','2023-04-21 15:26:57','2023-04-21 15:26:57');
INSERT INTO testimonial_translations VALUES('2','1','Spanish---es','Jhon Doe','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','2023-04-21 15:36:25','2023-04-21 15:36:25');
INSERT INTO testimonial_translations VALUES('3','2','English---us','Jack Johnston','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','2023-04-24 08:24:31','2023-04-24 08:24:31');
INSERT INTO testimonial_translations VALUES('4','3','English---us','Axar Patel','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','2023-04-24 08:25:20','2023-04-24 08:25:20');
INSERT INTO testimonial_translations VALUES('5','4','English---us','Kathrina','Lorem Ipsum is simply dummy text of the printing and typesetting industry.','2023-04-24 08:29:09','2023-04-24 08:29:09');



DROP TABLE IF EXISTS testimonials;

CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO testimonials VALUES('1','default/client-placeholder.png','2023-04-21 15:26:57','2023-04-24 08:30:51');
INSERT INTO testimonials VALUES('2','default/client-placeholder.png','2023-04-24 08:24:31','2023-04-24 08:31:06');
INSERT INTO testimonials VALUES('3','default/client-placeholder.png','2023-04-24 08:25:20','2023-04-24 08:31:13');
INSERT INTO testimonials VALUES('4','default/client-placeholder.png','2023-04-24 08:29:09','2023-04-24 08:31:21');



DROP TABLE IF EXISTS transaction_categories;

CREATE TABLE `transaction_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `color` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(15) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_categories_user_id_foreign` (`user_id`),
  KEY `transaction_categories_business_id_foreign` (`business_id`),
  CONSTRAINT `transaction_categories_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS transaction_methods;

CREATE TABLE `transaction_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS transactions;

CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `trans_date` datetime NOT NULL,
  `account_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_category_id` bigint(20) unsigned DEFAULT NULL,
  `dr_cr` varchar(2) NOT NULL,
  `type` varchar(20) NOT NULL COMMENT 'income|expense|transfer|others',
  `amount` decimal(28,8) NOT NULL,
  `currency_rate` decimal(28,8) NOT NULL,
  `ref_amount` decimal(28,8) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `reference` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `attachment` varchar(191) DEFAULT NULL,
  `ref_id` bigint(20) DEFAULT NULL,
  `ref_type` varchar(191) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `vendor_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  KEY `transactions_business_id_foreign` (`business_id`),
  KEY `transactions_account_id_foreign` (`account_id`),
  KEY `transactions_transaction_category_id_foreign` (`transaction_category_id`),
  CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_transaction_category_id_foreign` FOREIGN KEY (`transaction_category_id`) REFERENCES `transaction_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS user_invitations;

CREATE TABLE `user_invitations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `sender_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `user_type` varchar(20) NOT NULL COMMENT 'admin | user',
  `membership_type` varchar(50) DEFAULT NULL COMMENT 'trial | member',
  `package_id` bigint(20) DEFAULT NULL,
  `subscription_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `profile_picture` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `t_email_send_at` timestamp NULL DEFAULT NULL,
  `s_email_send_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `provider_id` varchar(191) DEFAULT NULL,
  `custom_fields` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users VALUES('1','Rashedul Raju','rbraju3m@gmail.com','admin','','','','1','default.png','2023-07-17 19:08:37','$2y$10$NbgZ6Q2A0Wzt1ZeP/EAf1e3jjo4QMuX3VF.TOw6t8rFINqacwuOK6','','','','','','','','','','','','ZI6B1GFJ7gN0EBIdhgNNIhzSHz1HHIHaK8yPXVsfwkV4pkUtjuMgNzSFUHSR','2023-07-17 19:08:37','2023-07-17 19:08:37');
INSERT INTO users VALUES('2','Demo User','demo@gmail.com','user','member','1','2023-07-18','1','default.png','','$2y$10$N0KhJJb4tE4XtRxFGr3nS.EdlBraMuKZ2WD87atVjncsYmOvYHhLS','','','','','','2023-08-18','','','','','','','2023-07-18 23:29:44','2023-07-18 23:29:44');



DROP TABLE IF EXISTS vendors;

CREATE TABLE `vendors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `business_id` bigint(20) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `registration_no` varchar(191) DEFAULT NULL,
  `vat_id` varchar(191) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `currency` varchar(10) NOT NULL,
  `city` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `profile_picture` varchar(191) DEFAULT NULL,
  `custom_fields` text DEFAULT NULL,
  `created_user_id` bigint(20) DEFAULT NULL,
  `updated_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendors_user_id_foreign` (`user_id`),
  KEY `vendors_business_id_foreign` (`business_id`),
  CONSTRAINT `vendors_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




