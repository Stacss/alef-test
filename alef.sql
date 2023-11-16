-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 16 2023 г., 20:41
-- Версия сервера: 5.6.47-log
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cg84581_alef`
--

-- --------------------------------------------------------

--
-- Структура таблицы `attended_lectures`
--

CREATE TABLE `attended_lectures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `lecture_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `attended_lectures`
--

INSERT INTO `attended_lectures` (`id`, `student_id`, `lecture_id`, `created_at`, `updated_at`) VALUES
(1, 7, 1, NULL, NULL),
(2, 8, 1, NULL, NULL),
(3, 3, 12, NULL, NULL),
(4, 7, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'History', NULL, '2023-11-15 08:51:07'),
(4, 'четвертая', NULL, NULL),
(5, 'Math Class', '2023-11-15 08:25:06', '2023-11-15 08:25:06'),
(6, 'Rus Class', '2023-11-15 08:26:27', '2023-11-15 08:26:27'),
(7, 'bio Class', '2023-11-15 08:26:38', '2023-11-15 08:26:38'),
(8, 'It Class', '2023-11-15 08:26:42', '2023-11-15 08:26:42');

-- --------------------------------------------------------

--
-- Структура таблицы `group_lecture`
--

CREATE TABLE `group_lecture` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `lecture_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_number` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `group_lecture`
--

INSERT INTO `group_lecture` (`id`, `group_id`, `lecture_id`, `lesson_number`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 3, '2023-11-16 03:34:55', '2023-11-16 03:34:55'),
(16, 4, 2, 4, '2023-11-16 08:54:15', '2023-11-16 08:54:15'),
(18, 4, 1, 2, '2023-11-16 08:57:35', '2023-11-16 08:57:35');

-- --------------------------------------------------------

--
-- Структура таблицы `group_members`
--

CREATE TABLE `group_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `group_members`
--

INSERT INTO `group_members` (`id`, `student_id`, `group_id`, `created_at`, `updated_at`) VALUES
(18, 4, 4, '2023-11-15 02:08:26', '2023-11-15 02:08:26'),
(21, 5, 3, '2023-11-15 02:10:10', '2023-11-15 02:10:10'),
(22, 7, 8, NULL, NULL),
(23, 8, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `lectures`
--

CREATE TABLE `lectures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lectures`
--

INSERT INTO `lectures` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Органическая химия, метан', 'Описание Органическая химия, метан', NULL, NULL),
(2, 'Органическая химия, кетоны', 'описание Органическая химия, кетоны', NULL, NULL),
(3, 'коллоидная химия, ПАВ', 'Описание коллоидная химия, ПАВ', NULL, NULL),
(4, 'Неорганическая химия, валентность', 'описание Неорганическая химия, валентность', NULL, NULL),
(5, 'Физическая химия, вещество х', 'Описание Физическая химия, вещество х', NULL, NULL),
(6, 'Химия отравляющих веществ, бутулотоксины', 'Описание Химия отравляющих веществ, бутулотоксины', NULL, NULL),
(7, 'физика, трение', 'описание физика, трение', NULL, NULL),
(8, 'физика, сила тока', 'описание физика, сила тока', NULL, NULL),
(9, 'Физика, сопротивление', 'Описание Физика, сопротивление', NULL, NULL),
(10, 'Физика, диоды', 'Описание Физика, диоды', NULL, NULL),
(11, 'Электротехника, конденсаторы и их измерение микрофарады', 'Описание Электротехника, конденсаторы и их измерение микрофарады', NULL, NULL),
(12, 'Электротехника, резисторы, применение', 'описание Электротехника, резисторы, применение', NULL, NULL),
(13, 'Электротехника, транзистор, эмиттер коллектор база', 'Описание Электротехника, транзистор, эмиттер коллектор база', NULL, NULL),
(14, 'химия отравляющих веществ, синильная кислота 1', 'описание химия отравляющих веществ, синильная кислота 1', '2023-11-16 09:24:01', '2023-11-16 09:33:54');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2023_11_14_104201_create_students_table', 1),
(5, '2023_11_14_104341_create_groups_table', 1),
(6, '2023_11_14_104451_create_lectures_table', 1),
(7, '2023_11_14_132649_create_attended_lectures_table', 1),
(8, '2023_11_14_132945_create_group_members_table', 1),
(9, '2023_11_16_043141_update_lectures_table_make_name_unique', 2),
(10, '2023_11_16_044907_create_group_lecture_table', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(3, 'Ivan', 'ivan1@example.com', '2023-11-14 22:18:35', '2023-11-14 22:18:35'),
(4, 'Петя', 'ggg@gg.ty', NULL, NULL),
(5, 'Макс', 'wrkjb@ak.tu', NULL, NULL),
(6, 'Петр', 'Petor@gh.erg', NULL, NULL),
(7, 'Коля', 'Kola@rgj.fg', NULL, NULL),
(8, 'Миша', 'Mix@dfg.fg', NULL, NULL),
(9, 'Федя', 'FTDOR@FREG.FWE', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `attended_lectures`
--
ALTER TABLE `attended_lectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attended_lectures_student_id_foreign` (`student_id`),
  ADD KEY `attended_lectures_lecture_id_foreign` (`lecture_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_unique` (`name`);

--
-- Индексы таблицы `group_lecture`
--
ALTER TABLE `group_lecture`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_lecture_group_id_lecture_id_unique` (`group_id`,`lecture_id`),
  ADD KEY `group_lecture_lecture_id_foreign` (`lecture_id`);

--
-- Индексы таблицы `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_members_student_id_foreign` (`student_id`),
  ADD KEY `group_members_group_id_foreign` (`group_id`);

--
-- Индексы таблицы `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lectures_name_unique` (`name`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `attended_lectures`
--
ALTER TABLE `attended_lectures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `group_lecture`
--
ALTER TABLE `group_lecture`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `attended_lectures`
--
ALTER TABLE `attended_lectures`
  ADD CONSTRAINT `attended_lectures_lecture_id_foreign` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attended_lectures_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_lecture`
--
ALTER TABLE `group_lecture`
  ADD CONSTRAINT `group_lecture_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_lecture_lecture_id_foreign` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_members_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
