CREATE TABLE `admin_users` (
                               `id` int NOT NULL,
                               `login` varchar(100) NOT NULL,
                               `password_hash` varchar(100) NOT NULL,
                               `email` varchar(100) DEFAULT NULL,
                               `role` enum('superadmin','admin','manager') NOT NULL DEFAULT 'admin',
                               `token` varchar(100) DEFAULT NULL,
                               `token_valid_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `front_infoblocks` (
                                    `id` smallint NOT NULL,
                                    `title` varchar(150) DEFAULT NULL,
                                    `name` varchar(50) DEFAULT NULL,
                                    `content` mediumtext ,
                                    `locked` int NOT NULL DEFAULT '1',
                                    `visible` int NOT NULL DEFAULT '1',
                                    `img` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `front_slider` (
                                `id` mediumint NOT NULL,
                                `title` varchar(50) DEFAULT NULL,
                                `img_lnd` varchar(100) DEFAULT NULL,
                                `img_prt` varchar(100) DEFAULT NULL,
                                `url` varchar(255) DEFAULT NULL,
                                `ord` smallint NOT NULL DEFAULT '0',
                                `visible` smallint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `front_settings` (
                            `id` int UNSIGNED NOT NULL,
                            `name` varchar(50) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `admin_users`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `login` (`login`);

ALTER TABLE `front_infoblocks`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `sysname` (`name`);

ALTER TABLE `front_slider`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `front_settings`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`);

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


-- Демо-данные

CREATE TABLE `front_demo` (
                              `id` int UNSIGNED NOT NULL,
                              `name` varchar(150) DEFAULT NULL,
                              `img` varchar(100) DEFAULT NULL,
                              `content` text,
                              `visible` tinyint DEFAULT NULL,
                              `ord` int DEFAULT NULL,
                              `pagename` varchar(150) DEFAULT NULL,
                              `dt` date DEFAULT NULL,
                              `radio` enum('Test1','Test2') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `front_demo`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `front_demo`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `front_demo` ADD `parent_id` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `radio`;
ALTER TABLE `front_demo` ADD INDEX(`parent_id`);
ALTER TABLE `front_demo` ADD `cat_id` INT NULL AFTER `parent_id`;
ALTER TABLE `front_demo` ADD INDEX(`cat_id`);

CREATE TABLE `front_demo_images` (
                                       `id` int UNSIGNED NOT NULL,
                                       `group_id` int UNSIGNED NOT NULL,
                                       `name` varchar(100) NOT NULL
) ENGINE=InnoDB;
ALTER TABLE `front_demo_images`
    ADD PRIMARY KEY (`id`),
    ADD KEY `main_id` (`group_id`);
ALTER TABLE `front_demo_images`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `front_demo_images`
    ADD CONSTRAINT `demo_images_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `front_demo` (`id`) ON DELETE CASCADE;

CREATE TABLE `front_demo_groups` (
                                        `id` int UNSIGNED NOT NULL,
                                        `group_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `front_demo_groups`
    ADD UNIQUE KEY `id_ware` (`id`,`group_id`),
    ADD KEY `id_group` (`group_id`);
ALTER TABLE `front_demo_groups`
    ADD CONSTRAINT `front_demo_groups_ibfk_1` FOREIGN KEY (`id`) REFERENCES `front_demo` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `front_demo_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `front_settings` (`id`) ON DELETE CASCADE;
