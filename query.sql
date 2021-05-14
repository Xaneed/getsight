SELECT
	`users`.`id` AS `user_id`,
	`users`.`login`,
	`users`.`password`,
	`objects`.`id` AS `object_id`,
	`objects`.`name`,
	`objects`.`status`
FROM `objects`
LEFT JOIN `users` ON `users`.`object_id` = `objects`.`id`
WHERE `object_id`=1