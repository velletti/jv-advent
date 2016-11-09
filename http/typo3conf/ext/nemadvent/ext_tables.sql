CREATE TABLE tx_nemadvent_domain_model_advent (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	date int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	desc_short text NOT NULL,
	desc_long mediumtext NOT NULL,
	solution mediumtext NOT NULL,

	image int(11) DEFAULT '0' NOT NULL,
	video text NOT NULL,
	viewed int(11) DEFAULT '0' NOT NULL,
	categories int(11) DEFAULT '0' NOT NULL,
	correct varchar(20) DEFAULT '',
	rangemin int(11) DEFAULT '0',
	rangemax int(11) DEFAULT '0',


	answer1 text,
	answer2 text,
	answer3 text,
	answer4 text,
	answer5 text, 
	storeonpid int(11) unsigned DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

CREATE TABLE tx_nemadvent_domain_model_adventcat (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	startdate int(11) DEFAULT '0' NOT NULL,
	enddate int(11) DEFAULT '0' NOT NULL,
	days int(11) DEFAULT '24' NOT NULL,		
	PRIMARY KEY (uid),
	KEY parent (pid)
);


CREATE TABLE tx_nemadvent_domain_model_user (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	question_date int(11) DEFAULT '0' NOT NULL,
	question_datef varchar(10) DEFAULT '01.01.1970' NOT NULL,
	
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	usergroup tinytext ,
	customerno varchar(50) DEFAULT '' NOT NULL,
	
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	advent_uid int(11) unsigned DEFAULT '0' NOT NULL,
	question_uid int(11) unsigned DEFAULT '0' NOT NULL,
	answer_uid int(11) unsigned DEFAULT '0' NOT NULL,
	points int(11) unsigned DEFAULT '0' NOT NULL,
	subpoints int(11) unsigned DEFAULT '0' NOT NULL,
	
	feuser_uid int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY fe_user (pid,advent_uid,feuser_uid)
);

CREATE TABLE tx_nemadvent_domain_model_winner (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	date int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	desc_short text NOT NULL,
	feuser_uid int(11) unsigned DEFAULT '0' NOT NULL,
	points int(11) unsigned DEFAULT '0' NOT NULL,
	sorting tinyint(4) unsigned DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);


CREATE TABLE tx_nemadvent_advent_adventcat_mm (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid,uid_local,uid_foreign)
);

#
# Table structure for table 'tx_nemadvent_cache'
#
CREATE TABLE tx_nemadvent_cache (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	identifier char(128) DEFAULT '0' NOT NULL,
	lifetime int(11) DEFAULT '0' NOT NULL,
	content blob NOT NULL ,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY identifier (identifier),
	KEY lifetime (lifetime)

);

