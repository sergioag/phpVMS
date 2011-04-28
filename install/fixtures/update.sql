-- It's sometimes missing;
INSERT INTO `phpvms_settings` VALUES(NULL , 'Total VA Hours', 'TOTAL_HOURS', '0', 'Your total hours', 0);
INSERT INTO `phpvms_settings` VALUES(NULL , 'phpVMS Version', 'PHPVMS_VERSION', '0', 'phpVMS Version', 1);

INSERT INTO `phpvms_groups` (`name`, `permissions`) VALUES ('Active Pilots', '0');
INSERT INTO `phpvms_groups` (`name`, `permissions`) VALUES ('Inactive Pilots', '0');

-- Remove deprecated settings;
DELETE FROM `phpvms_settings` WHERE `name`='NOTIFY_UPDATE';
DELETE FROM `phpvms_settings` WHERE `name`='GOOGLE_KEY';