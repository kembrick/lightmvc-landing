CREATE TABLE `admin_users` (
                               `id` int NOT NULL,
                               `login` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
                               `password_hash` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                               `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                               `role` enum('superadmin','admin','manager') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admin',
                               `token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
                               `token_valid_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `front_infoblocks` (
                                    `id` smallint NOT NULL,
                                    `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `sysname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                                    `locked` int NOT NULL DEFAULT '1',
                                    `visible` int NOT NULL DEFAULT '1',
                                    `img` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `front_slider` (
                                `id` mediumint NOT NULL,
                                `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                `img_lnd` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                `img_prt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `ord` smallint NOT NULL DEFAULT '0',
                                `visible` smallint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `front_settings` (
                            `id` smallint NOT NULL,
                            `sysname` varchar(50) NOT NULL,
                            `title` varchar(150) DEFAULT NULL,
                            `type` varchar(50) DEFAULT NULL,
                            `val` text,
                            `locked` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `front_buttons` (
                                 `id` int UNSIGNED NOT NULL,
                                 `title` varchar(150) DEFAULT NULL,
                                 `url` varchar(255) DEFAULT NULL,
                                 `ord` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `admin_users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `login` (`login`);

ALTER TABLE `front_infoblocks`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `sysname` (`sysname`);

ALTER TABLE `front_slider`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `front_settings`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`sysname`);

ALTER TABLE `front_buttons`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `admin_users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `front_infoblocks`
    MODIFY `id` smallint NOT NULL AUTO_INCREMENT;

ALTER TABLE `front_slider`
    MODIFY `id` mediumint NOT NULL AUTO_INCREMENT;

ALTER TABLE `front_settings`
    MODIFY `id` smallint NOT NULL AUTO_INCREMENT;

ALTER TABLE `front_buttons`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
