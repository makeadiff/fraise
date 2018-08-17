-- Donut_Network
--   id
--   name
--   email
--   phone
--   relationship parent,sibling,acquaintance,friend,relative,other
--   donor_status lead,pitched,disagreed,donated
--   pledged_amount
--   pledge_type nach,cash/cheque,online,other
--   collection_by self,handover_to_mad
--   address MEDIUMTEXT
--   added_by_user_id
--   follow_up_on
--   collect_on
--   added_on
--
--
-- Donut_NetworkData
--   id
--   donut_network_id
--   name
--   value
--   datamysqmy
--   added_on



SELECT user.name AS Volunteer_Name,
	user.email AS Volunteer_Email,
	user.user_type AS Volunteer_User_Type,
	SUM(DD.amount) AS Amount_Donutted,
	COUNT(DD.Donor_id) AS Number_Of_Donors,
	UG2018.role as 'Role 2018',
	UG2017.role as 'Role 2017'
FROM User user
LEFT JOIN Donut_Donation DD on user.id=DD.fundraiser_user_id
LEFT JOIN Donut_Donor DDR on DD.Donor_id=DDR.id
LEFT JOIN (
  SELECT UG.user_id as user_id, GROUP_CONCAT(G.name) as role
  FROM UserGroup UG
  INNER JOIN `Group` G ON G.id = UG.group_id
	WHERE UG.year = 2018
	GROUP BY UG.user_id
) UG2018 ON UG2018.user_id = user.id
LEFT JOIN (
  SELECT UG.user_id as user_id, GROUP_CONCAT(G.name) as role
  FROM UserGroup UG
  INNER JOIN `Group` G ON G.id = UG.group_id
	WHERE UG.year = 2017
	GROUP BY UG.user_id
) UG2017 ON UG2017.user_id = user.id
WHERE DD.added_on>='2017-08-01'
GROUP BY  user.name,user.email,user.user_type order by SUM(DD.amount) DESC


CREATE TABLE IF NOT EXISTS `Donut_Network` (
	`id` INT (11)  unsigned NOT NULL auto_increment,
	`name` VARCHAR (100)   NOT NULL,
	`email` VARCHAR (100)  NULL,
	`phone` VARCHAR (100)   NOT NULL,
	`relationship` ENUM ('parent','sibling','acquaintance','friend','relative','other') DEFAULT NULL  NULL,
	`donor_status` ENUM ('lead','pledged','disagreed','donated') DEFAULT 'lead'  NOT NULL,
	`pledged_amount` VARCHAR (100)    NULL,
	`pledge_type` ENUM ('nach','cash/cheque','online','other') DEFAULT NULL  NULL,
	`collection_by` ENUM ('self','handover_to_mad') DEFAULT 'self'   NULL,
	`address` MEDIUMTEXT   NULL,
	`added_by_user_id` INT (11)  unsigned NOT NULL,
	`follow_up_on` DATETIME   NULL,
	`collect_on` DATETIME    NULL,
	`added_on` DATETIME    NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`added_by_user_id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `Donut_NetworkData` (
	`id` INT (11)  unsigned NOT NULL auto_increment,
	`donut_network_id` INT (11)  unsigned NOT NULL,
	`name` VARCHAR (100)   NOT NULL,
	`value` VARCHAR (100)   NOT NULL,
	`data` MEDIUMTEXT    NULL,
	`added_on` DATETIME    NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`donut_network_id`)
) DEFAULT CHARSET=utf8 ;



select
	count(distinct User.id) from
		User
		inner join UserGroup UG on UG.user_id = User.id
		inner join `Group` G on G.id = UG.group_id where G.type = "volunteer" and G.group_type = "normal" and UG.year = 2017 and User.status = 1 and User.user_type <> "alumni"
