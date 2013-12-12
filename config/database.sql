
--
-- Tabellenstruktur für Tabelle `tl_es_webcheck`
--

CREATE TABLE `tl_es_webcheck` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `url` text NOT NULL,
  `teststring` text NOT NULL,
  `added` varchar(20) NOT NULL default '',
  `source` text NOT NULL,
  `date` varchar(10) NOT NULL default '',
  `time` varchar(8) NOT NULL default '',
  `reachable` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  default CHARSET=utf8;

-- --------------------------------------------------------
