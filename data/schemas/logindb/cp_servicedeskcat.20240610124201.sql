CREATE TABLE IF NOT EXISTS `cp_servicedeskcat` (
  `cat_id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `display` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `cp_servicedeskcat` (`cat_id`, `name`, `display`) VALUES
(1, 'Suporte Técnico', 1),
(2, 'Suporte Geral', 1),
(3, 'Reportar um Abuso', 1);
