CREATE TABLE IF NOT EXISTS `^ysb_badge_master` (
  `badgeid` int(10) unsigned UNIQUE NOT NULL,
  `actionid` int(10) unsigned NOT NULL,
  `action_level_1` smallint unsigned NOT NULL,
  `action_level_2` smallint unsigned NOT NULL,
  `action_level_3` smallint unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
