CREATE TABLE /*TABLE_PREFIX*/dln_user_premium (
	id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    premium_type CHAR(3) NULL,
    create_time DATETIME,
    expire_time DATETIME,
    money BIGINT(20),
    notes nvarchar(255),

        PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';