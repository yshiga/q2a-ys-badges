CREATE TABLE IF NOT EXISTS `^ysb_badges` (
  `badgeid` int(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userid` int(10) unsigned UNIQUE NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
