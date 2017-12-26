CREATE TABLE IF NOT EXISTS `^ysb_badge_ranking` (
  `id` int(10) unsigned UNIQUE NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `badgeid` int(10) unsigned NOT NULL,
  `award_date` varchar(20),
  `show_flag` smallint unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;