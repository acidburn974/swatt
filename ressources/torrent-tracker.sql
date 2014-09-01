CREATE TABLE `users` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`username` varchar(40) NOT NULL,
`email` varchar(80) NOT NULL,
`password` varchar(255) NOT NULL,
`passkey` varchar(255) NULL,
`role` varchar(10) NOT NULL DEFAULT 'user',
`ip` varchar(255) NULL,
`uploaded` int(11) NOT NULL DEFAULT 0,
`downloaded` int(11) NOT NULL,
`remember_token` varchar(50) NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `torrents` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`slug` varchar(255) NOT NULL,
`description` text NOT NULL,
`info_hash` varchar(40) NOT NULL,
`file_name` varchar(255) NOT NULL,
`file_count` int(3) UNSIGNED NOT NULL,
`announce` varchar(255) NOT NULL,
`size` float(11,0) UNSIGNED NOT NULL,
`nfo` text NOT NULL,
`leechers` int(11) UNSIGNED NOT NULL,
`seeders` int(11) UNSIGNED NOT NULL,
`times_completed` int(5) NOT NULL,
`created_by` varchar(255) NOT NULL,
`category_id` int(5) UNSIGNED NOT NULL,
`user_id` int(11) UNSIGNED NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `peers` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`peer_id` varchar(40) NOT NULL,
`ip` varchar(64) NOT NULL,
`port` smallint(2) UNSIGNED NOT NULL,
`uploaded` bigint(20) UNSIGNED NOT NULL,
`downloaded` bigint(20) NOT NULL,
`left` bigint(20) UNSIGNED NOT NULL,
`seeder` tinyint(1) NOT NULL,
`connectable` tinyint(1) NOT NULL,
`client` varchar(60) NOT NULL,
`user_id` bigint(20) UNSIGNED NOT NULL,
`torrent_id` bigint(20) UNSIGNED NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `files` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`size` bigint(20) UNSIGNED NOT NULL,
`torrent_id` bigint(20) UNSIGNED NOT NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `categories` (
`id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`slug` varchar(255) NOT NULL,
`image` varchar(255) NOT NULL,
PRIMARY KEY (`id`) 
);

CREATE TABLE `posts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`slug` varchar(255) NOT NULL,
`brief` text NOT NULL,
`content` longtext NOT NULL,
`user_id` bigint(20) UNSIGNED NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`) 
);


ALTER TABLE `torrents` ADD CONSTRAINT `fk_torrents_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `files` ADD CONSTRAINT `fk_files_torrents_1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`);
ALTER TABLE `torrents` ADD CONSTRAINT `fk_torrents_categories_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
ALTER TABLE `peers` ADD CONSTRAINT `fk_peers_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `peers` ADD CONSTRAINT `fk_peers_torrents_1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`);
ALTER TABLE `posts` ADD CONSTRAINT `fk_posts_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

