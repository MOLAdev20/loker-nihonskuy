/*M!999999\- enable the sandbox mode */ 
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;
DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `facility` varchar(255) NOT NULL,
  `established` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
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
DROP TABLE IF EXISTS `urgent_vacancies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `urgent_vacancies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` bigint(20) unsigned NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urgent_vacancies_job_id_unique` (`job_id`),
  UNIQUE KEY `urgent_vacancies_order_unique` (`order`),
  CONSTRAINT `urgent_vacancies_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_certificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_certificate` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `certificate_type` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_certificate_user_id_foreign` (`user_id`),
  CONSTRAINT `user_certificate_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_document` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_document_user_id_foreign` (`user_id`),
  CONSTRAINT `user_document_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_education_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_education_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `education` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_of_entry` date NOT NULL,
  `date_of_graduation` date NOT NULL,
  `date_of_dropped_out` date DEFAULT NULL COMMENT 'Tahun dan bulan jika berhenti sekolah',
  `status` varchar(255) NOT NULL COMMENT 'Status di jenjang tersebut',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_education_history_user_id_foreign` (`user_id`),
  CONSTRAINT `user_education_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_interview_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_interview_answers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `work_history` text NOT NULL COMMENT 'Q1: Past work experience in Japan',
  `technical_skills` text NOT NULL COMMENT 'Q2: Skills mastered during previous work',
  `comm_challenges` text NOT NULL COMMENT 'Q3: Communication difficulties faced',
  `leave_reason` text NOT NULL COMMENT 'Q4: Reason for leaving previous job',
  `apply_reason` text NOT NULL COMMENT 'Q5: Reason for choosing this new field',
  `career_prep` text NOT NULL COMMENT 'Q6: Preparation made for this career change',
  `personality_review` text NOT NULL COMMENT 'Q7: How bosses/peers describe them',
  `problem_solving` text NOT NULL COMMENT 'Q8: How they handle difficulties and pressure',
  `stay_motivation` text NOT NULL COMMENT 'Q9: What kept them motivated to finish contract',
  `learning_goals` text NOT NULL COMMENT 'Q10: What they want to learn from this job',
  `japan_targets` text NOT NULL COMMENT 'Q11: Future targets while in Japan',
  `long_term_dream` text NOT NULL COMMENT 'Q12: Long term goals after returning to Indonesia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_interview_answers_user_id_foreign` (`user_id`),
  CONSTRAINT `user_interview_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profile` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID data profile user',
  `user_id` bigint(20) unsigned NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL COMMENT 'Foto Profile atau Pas Foto (氏名)',
  `full_name` varchar(255) NOT NULL COMMENT 'Nama lengkap (氏名)',
  `furigana_name` varchar(255) NOT NULL COMMENT 'Nama lengkap dalam bahasa Jepang (フリガナ)',
  `birth_date` date NOT NULL COMMENT 'Tanggal lahir (生年月日)',
  `gender` enum('male','female') NOT NULL COMMENT 'Jenis kelamin (性別)',
  `height` int(10) unsigned NOT NULL COMMENT 'Tinggi badan',
  `weight` int(10) unsigned NOT NULL COMMENT 'berat badan',
  `marital_status` enum('single','married','divorce') NOT NULL COMMENT 'Status pernikahan (婚姻)',
  `nationality` varchar(255) NOT NULL COMMENT 'Kewarganegaraan (国籍)',
  `domicile` varchar(255) NOT NULL COMMENT 'Domisili',
  `place_of_origin` varchar(255) NOT NULL COMMENT 'Tempat asal (出身地)',
  `current_address` text NOT NULL COMMENT 'Alamat sekarang (現住所)',
  `religion` varchar(50) NOT NULL COMMENT 'Agama (宗教)',
  `is_wearing_hijab` varchar(255) NOT NULL COMMENT 'Pakai hijab atau tidak (ヒジャブ)',
  `prayer_requirement` text NOT NULL COMMENT 'Kebutuhan waktu ibadah (お祈り)',
  `pork_tolerance` text NOT NULL COMMENT 'Skala toleransi babi',
  `alcohol_tolerance` text NOT NULL COMMENT 'Skala toleransi alkohol (飲酒への許容度)',
  `entry_date` date DEFAULT NULL COMMENT 'Tanggal masuk Jepang (入国日)',
  `visa_expiry_date` date DEFAULT NULL COMMENT 'Masa berlaku visa (在留カードの期限)',
  `current_visa_type` varchar(255) DEFAULT NULL,
  `jlpt_level` enum('N1','N2','N3','N4','N5','none') NOT NULL COMMENT 'Level bahasa Jepang (日本語能力)',
  `has_driver_license` varchar(255) NOT NULL COMMENT 'Punya SIM atau tidak (運転免許有無)',
  `work_start_date` varchar(255) NOT NULL COMMENT 'Kapan siap mulai kerja (就労開始可能日)',
  `technical_experience` text NOT NULL COMMENT 'Detail pengalaman magang/skill (技能実習経験)',
  `reason_for_leaving` text NOT NULL,
  `jikoshoukai` varchar(255) DEFAULT NULL,
  `jp_summary` text DEFAULT NULL,
  `jp_reason_for_leaving` text DEFAULT NULL,
  `jp_additional_info` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Record data dibuat',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Record data diupdate',
  PRIMARY KEY (`id`),
  KEY `user_profile_user_id_foreign` (`user_id`),
  CONSTRAINT `user_profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_working_experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_working_experience` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `field_of_work` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_of_join` date NOT NULL,
  `date_of_resign` date DEFAULT NULL,
  `employment_status` varchar(255) NOT NULL,
  `visa_type` varchar(255) DEFAULT NULL COMMENT 'Status izin tinggal/jenis visa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_working_experience_user_id_foreign` (`user_id`),
  CONSTRAINT `user_working_experience_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `ref_code` varchar(12) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `vacancies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacancies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `visa_type` varchar(255) NOT NULL,
  `placement` varchar(255) NOT NULL,
  `placement_branch` varchar(255) DEFAULT NULL,
  `job_type` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) NOT NULL,
  `gender_requirement` char(1) NOT NULL,
  `domicile_requirement` varchar(255) NOT NULL,
  `exp_requirement` varchar(255) DEFAULT NULL,
  `jlpt_requirement` enum('n5','n4','n3','n2','n1','all') NOT NULL,
  `kaiwa_requirement` enum('n5','n4','n3','n2','n1') DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `benefit` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `additional_information` longtext NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `company_web` varchar(255) DEFAULT NULL,
  `expired_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vacancies_job_code_unique` (`job_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

/*M!999999\- enable the sandbox mode */ 
SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2026_01_25_000000_create_vacancies_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2026_02_16_000000_create_admins_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2026_04_16_000001_create_user_profile_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2026_04_16_194037_create_table_education_history',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2026_04_16_211341_create_table_working_experience',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2026_04_16_230734_add_company_name_in_table_user_working_experience',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2026_04_19_000000_add_branch_in_vacancies',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2026_04_19_010000_add_ref_code_in_users',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2026_04_20_000001_add_tags_in_vacancies_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2026_04_29_111012_add_jlpt_requirement_in_vacancies',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2026_04_30_000001_add_kaiwa_requirement_in_vacancies',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2026_05_07_032559_add_exp_requirement_in_vacancies',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2026_05_08_013042_add_company_web_in_vacancies',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2026_05_25_083152_create_table_urgent_vacancies',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2026_05_26_072756_add_unique_indexes_to_urgent_vacancies_table',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2026_06_02_074831_add_2_columns_in_table_user_profile',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2026_06_04_055021_add_jp_lang_in_3_columns',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2026_06_10_072936_create_user_interview_answers_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2026_06_23_021126_create-user-document-table',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2026_06_23_085022_add_jikoshoukai_in_user_profile',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2026_06_25_081706_add_jikoshoukai_column_in_user_profile',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2026_06_25_084137_create_table_certificate',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2026_06_26_062833_create_table_company',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2026_07_02_000001_change_work_start_date_to_varchar_in_user_profile_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2026_07_06_114138_change_current_visa_type_to_default_null',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2026_07_06_114643_add_domicile_in_user_profile',22);
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
