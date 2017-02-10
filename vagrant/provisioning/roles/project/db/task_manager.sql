DROP DATABASE IF EXISTS `task-manager`;
CREATE DATABASE  IF NOT EXISTS `task-manager`;
USE `task-manager`;

DROP TABLE IF EXISTS `task`;

CREATE TABLE `task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  PRIMARY KEY (`id`));

INSERT INTO `task` (name, description, priority) VALUES
  ('Work', 'Tasks to do in work', 'low'),
  ('School', 'Tasks to do in school', 'medium'),
  ('Home', 'Tasks to do in home', 'high');