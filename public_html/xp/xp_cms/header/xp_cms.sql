
CREATE TABLE IF NOT EXISTS `be_groups` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `tstamp` time NOT NULL,
  `creat` time NOT NULL,
  `display` tinyint(4) NOT NULL DEFAULT '0',
  `delete` tinyint(4) NOT NULL DEFAULT '0',
  `subgroup` varchar(255) NOT NULL,
  `allowed_languages` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `be_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tstamp` int(11) DEFAULT '0' NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '1',
  `starttime` int(11) DEFAULT '0' NOT NULL,
  `endtime` int(11) DEFAULT '0' NOT NULL,
  `language` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `lastlogin` int(11) DEFAULT '0' NOT NULL,
  `usergroup` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `realname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `login_ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `content` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `body_text` text,
  `col_pos` int(11) DEFAULT '0' NOT NULL,
  `header` varchar(225)  DEFAULT '' NOT NULL,
  `tstamp` int(11) DEFAULT '0' NOT NULL,
  `starttime` int(11) DEFAULT '0' NOT NULL,
  `endtime` int(11) DEFAULT '0' NOT NULL,
  `lastupdated` int(11) DEFAULT '0' NOT NULL,
  `display` int(11) DEFAULT '1' NOT NULL,
  `deleted` int(11) DEFAULT '0' NOT NULL,
  `content_type` varchar(225)  DEFAULT '' NOT NULL,
  `image` varchar(225) DEFAULT '' NOT NULL,
  `image_width` int(11) DEFAULT '0' NOT NULL,
  `image_height` int(11) DEFAULT '0' NOT NULL,
  `file_link` text  DEFAULT '' NOT NULL,
  `pid` int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `content` (`uid`, `body_text`, `col_pos`, `header`, `tstamp`, `starttime`, `endtime`, `lastupdated`, `display`, `deleted`, `content_type`, `image`, `image_width`, `image_height`, `file_link`, `pid`) VALUES
(1, 'just testing', 0, 'xp-cms test', 0, 0, 0, 0, 1, 0, '', '', 0, 0, '', 0);

CREATE TABLE IF NOT EXISTS `pages` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '' NOT NULL,
  `keyword` varchar(255) DEFAULT '' NOT NULL,
  `description` text,
  `author` varchar(50)  DEFAULT '' NOT NULL,
  `author_email` varchar(50)  DEFAULT '' NOT NULL,
  `subtitle` varchar(500)  DEFAULT '' NOT NULL,
  `crdate` int(11) DEFAULT '0' NOT NULL,
  `starttime` int(11) DEFAULT '0' NOT NULL,
  `endtime` int(11) DEFAULT '0' NOT NULL,
  `hidden` int(11) DEFAULT '0',
  `deleted` int(11) DEFAULT '0',
  `last_updated` int(11) DEFAULT '0' NOT NULL,
  `nav_title` varchar(50)  DEFAULT '' NOT NULL,
  `nav_hidden` int(11) DEFAULT '0' NOT NULL,
  `layout` varchar(50)  DEFAULT '' NOT NULL,
  `sys_language` varchar(20)  DEFAULT '' NOT NULL,
  `url` varchar(255)  DEFAULT '' NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `pages` (`uid`, `title`, `keyword`, `description`, `author`, `author_email`, `subtitle`, `crdate`, `starttime`, `endtime`, `hidden`, `deleted`, `last_updated`, `nav_title`, `nav_hidden`, `layout`, `sys_language`, `url`) VALUES
(1, 'home', 'home', 'home', 'xiaoling', 'pengmaradi@gmail.com', 'my home', 1371306371, 1371306371, 0, 0, 0,'','','','','',''),
(2, 'contact', 'contact', 'contact', 'xiaoling', 'pengmaradi@gmail.com', 'my contact', 1371306450, 1371306450, 0, 1, 0,'','','','','',''),
(3, 'links', 'links', 'links', 'xiaoling', 'pengmaradi@gmail.com', 'my links', 1371306478, 1371306478, 0, 1, 0,'','','','','',''),
(4, 'pages', 'create or edit pages', 'heir can we edit pages type, menu, name, etc', 'xiaoling peng', 'pengmaradi@gmail.com', 'pages', 1371931066, 0, 0, 0, 0,'','','','','',''),
(5, 'template', 'template', 'template', 'xiaoling peng', 'pengmaradi@gmail.com', 'template', 1371931349, 0, 0, 0, 0,'','','','','',''),
(6, 'files', 'files', 'files', 'xiaoling peng', 'pengmaradi@gmail.com', 'files', 1371931423, 0,'', 0, 0,'','','','','',''),
(7, 'configuration', 'configuration', 'configuration', 'xiaoling peng', 'pengmaradi@gmail.com', 'file', 1371931510, 0,'', 0, 0,'','','','','',''),
(8, 'useradmin', 'useradmin', 'useradmin', 'xiaoling peng', 'pengmaradi@gmail.com', 'file', 1371931559, 0,'', 0, 0,'','','','','',''),
(9, 'logout', 'logout', 'logout', 'xiaoling peng', 'pengmaradi@gmail.com', 'file', 1371931590, 0,'', 0, 0,'','','','','','');

CREATE TABLE IF NOT EXISTS `fe_pages` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `author` varchar(50) NOT NULL DEFAULT '',
  `author_email` varchar(50) NOT NULL DEFAULT '',
  `subtitle` varchar(500) NOT NULL DEFAULT '',
  `crdate` int(11) NOT NULL DEFAULT '0',
  `starttime` int(11) NOT NULL DEFAULT '0',
  `endtime` int(11) NOT NULL DEFAULT '0',
  `hidden` int(11) DEFAULT '0',
  `deleted` int(11) DEFAULT '0',
  `last_updated` int(11) NOT NULL DEFAULT '0',
  `nav_title` varchar(50) NOT NULL DEFAULT '',
  `nav_hidden` int(11) NOT NULL DEFAULT '0',
  `layout` varchar(50) NOT NULL DEFAULT '',
  `sys_language` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `fe_pages` 
(`uid`, `title`, `keyword`, `description`, `author`, `author_email`, `subtitle`, `crdate`, `starttime`, `endtime`, `hidden`, `deleted`, `last_updated`, `nav_title`, `nav_hidden`, `layout`, `sys_language`, `url`, `lft`, `rgt`) 
VALUES
(1, 'xpcms menu', '', NULL, '', '', '', 0, 0, 0, 0, 0, 0, '', 1, '', '', 'xpcms-menu', 1, 2);

CREATE TABLE IF NOT EXISTS `sys_language` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(50)  DEFAULT '' NOT NULL,
  `flag` varchar(2)  DEFAULT '' NOT NULL,
  `lang_isocode` varchar(3)  DEFAULT '' NOT NULL,
  `hidden` int(11) DEFAULT '0' NOT NULL,
  `tstamp` int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `page_type` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `sys_lanage` int(11) NOT NULL DEFAULT '0',
  `label` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `page_type` (`uid`, `type`, `name`, `description`, `sys_lanage`, `label`) VALUES
(1, 1, 'text', 'this field is only for text', 0, 'STANDART'),
(2, 2, 'image', 'this field is only for image', 0, 'STANDART'),
(3, 3, 'file links', 'this field is only for file links', 0, 'LISTS'),
(4, 4, 'contact', 'this field is only for form', 0, 'FORMS'),
(5, 5, 'login', 'this field is only for login', 0, 'FORMS'),
(6, 6, 'search', 'this field is only for search form', 0, 'FORMS'),
(7, 7, 'slider', 'this field is only for media', 0, 'SPECIALS');

CREATE TABLE IF NOT EXISTS `template` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `template` varchar(250) NOT NULL,
  `header` varchar(250) NOT NULL,
  `content` varchar(250) NOT NULL,
  `footer` varchar(250) NOT NULL,
  `sidebar` varchar(250) NOT NULL,
  `last_update` varchar(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

INSERT INTO `template` (`uid`, `template`, `header`, `content`, `footer`, `sidebar`, `last_update`) VALUES
(1, '{"template" : 1}', '{"logo" : 1,"title" : 1,"hmenu" : 1,"search" : 1,"hlogin" : 1}', '{"cmenu" : 0,"rootline" : 0}', '{"fmenu" : 0,"flogin" : 0}', '{"sidebar" : 0,"plugin" : 0}', '1378150791');

CREATE TABLE IF NOT EXISTS `web_info` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `web_title` varchar(50) NOT NULL,
  `web_description` text NOT NULL,
  `web_copyright` varchar(250) NOT NULL,
  `web_address` varchar(250) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `body_color` varchar(15) NOT NULL,
  `header_color` varchar(15) NOT NULL,
  `content_color` varchar(15) NOT NULL,
  `footer_color` varchar(15) NOT NULL,
  `google_analitytis` text NOT NULL,
  `key_words` text NOT NULL,
  `social_netzwork` text NOT NULL,
  `last_update` varchar(20) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `web_info` (`uid`, `web_title`, `web_description`, `web_copyright`, `web_address`, `icon`, `logo`, `body_color`, `header_color`, `content_color`, `footer_color`, `google_analitytis`, `key_words`, `social_netzwork`, `last_update`) VALUES
(1, 'cms', 'testing', 'at ...', 'address', 'xp_cms_icon.jpg', 'xp_cms_logo.jpg', 'ffffff', 'f5f7fa', 'ffffff', 'edfaf1', 'function', 'hey1,key2', 'put your sozial netwerk code hier', '1378151889');

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `file_type` varchar(100) CHARACTER SET utf8 NOT NULL,
  `file_path` varchar(80) CHARACTER SET utf8 NOT NULL,
  `file_size` varchar(20) CHARACTER SET utf8 NOT NULL,
  `image_width` int(11) NOT NULL,
  `image_height` int(11) NOT NULL,
  `up_time` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;