CREATE TABLE `articles` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`brief` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_articles_users1_idx` (`user_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `categories` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `files` (
`id` bigint(20) UNSIGNED NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`size` bigint(20) UNSIGNED NOT NULL,
`torrent_id` bigint(20) UNSIGNED NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_files_torrents1_idx` (`torrent_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `forums` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`position` int(11) NULL,
`num_topic` int(11) NULL DEFAULT NULL,
`num_post` int(11) NULL DEFAULT NULL,
`last_topic_id` int(11) NULL DEFAULT NULL,
`last_topic_name` varchar(255) NULL,
`last_topic_slug` varchar(255) NULL,
`last_topic_user_id` int(11) NULL DEFAULT NULL,
`last_topic_user_username` varchar(45) NULL DEFAULT NULL,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`parent_id` int(11) NULL DEFAULT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `groups` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`is_admin` tinyint(4) NOT NULL,
`is_modo` tinyint(4) NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `peers` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`peer_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`ip` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`port` smallint(5) UNSIGNED NOT NULL,
`uploaded` bigint(20) UNSIGNED NOT NULL,
`downloaded` bigint(20) UNSIGNED NOT NULL,
`left` bigint(20) UNSIGNED NOT NULL,
`seeder` tinyint(4) NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`torrent_id` bigint(20) UNSIGNED NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_peers_torrents1_idx` (`torrent_id`),
INDEX `fk_peers_users1_idx` (`user_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `permissions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`show_forum` tinyint(4) NOT NULL,
`read_topic` tinyint(4) NOT NULL,
`reply_topic` tinyint(4) NOT NULL,
`start_topic` tinyint(4) NOT NULL,
`upload` tinyint(4) NOT NULL,
`download` tinyint(4) NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`forum_id` int(11) NOT NULL,
`group_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_permissions_forums1_idx` (`forum_id`),
INDEX `fk_permissions_groups1_idx` (`group_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `posts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`user_id` int(11) NOT NULL,
`topic_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_forum_posts_users1_idx` (`user_id`),
INDEX `fk_posts_topics1_idx` (`topic_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `topics` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`state` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`num_post` int(11) NULL DEFAULT NULL,
`first_post_user_id` int(11) NULL DEFAULT NULL,
`last_post_user_id` int(11) NULL DEFAULT NULL,
`first_post_user_username` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`last_post_user_username` varchar(45) NULL DEFAULT NULL,
`views` int(11) NULL DEFAULT NULL,
`pinned` tinyint(4) NULL DEFAULT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`forum_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_topics_forums1_idx` (`forum_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `torrents` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`info_hash` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`file_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`num_files` int(11) NOT NULL,
`size` float NOT NULL,
`nfo` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`leechers` int(11) NOT NULL,
`seeders` int(11) NOT NULL,
`times_completed` int(11) NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
`category_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_table1_categories1_idx` (`category_id`),
INDEX `fk_torrents_users1_idx` (`user_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;

CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`email` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`password` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`passkey` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`uploaded` bigint(20) NOT NULL,
`downloaded` bigint(20) NOT NULL,
`remember_token` varchar(50) NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`group_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_users_groups_idx` (`group_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1;


ALTER TABLE `articles` ADD CONSTRAINT `fk_articles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `files` ADD CONSTRAINT `fk_files_torrents1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`);
ALTER TABLE `peers` ADD CONSTRAINT `fk_peers_torrents1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`);
ALTER TABLE `peers` ADD CONSTRAINT `fk_peers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `permissions` ADD CONSTRAINT `fk_permissions_forums1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`);
ALTER TABLE `permissions` ADD CONSTRAINT `fk_permissions_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);
ALTER TABLE `posts` ADD CONSTRAINT `fk_forum_posts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `posts` ADD CONSTRAINT `fk_posts_topics1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);
ALTER TABLE `topics` ADD CONSTRAINT `fk_topics_forums1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`);
ALTER TABLE `torrents` ADD CONSTRAINT `fk_table1_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
ALTER TABLE `torrents` ADD CONSTRAINT `fk_torrents_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `users` ADD CONSTRAINT `fk_users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

