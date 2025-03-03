CREATE TABLE `mt_footer_content` (
    `id` int NOT NULL,
    `type` enum('link','email','phone','logo') NOT NULL,
    `content` varchar(255) NOT NULL,
    `placeholder` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mt_navigation_links` (
    `id` int NOT NULL,
    `name` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mt_sections` (
    `id` int NOT NULL,
    `name` varchar(255) NOT NULL,
    `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
    `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mt_section_instances` (
    `id` int NOT NULL,
    `section_id` int NOT NULL,
    `display_order` int NOT NULL,
    `unique_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `mt_footer_content`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `mt_navigation_links`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `mt_sections`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`),

ALTER TABLE `mt_section_instances`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `unique_id` (`unique_id`),
    ADD KEY `section_id` (`section_id`);

ALTER TABLE `mt_section_instances`
    ADD CONSTRAINT `mt_section_instances_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `mt_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
