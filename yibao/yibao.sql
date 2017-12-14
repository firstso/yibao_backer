
 CREATE DATABASE yibao DEFAULT CHARACTER SET UTF8 COLLATE utf8_general_ci;

 USE yibao;

 CREATE TABLE  `user` 
 (
 	`uid` MEDIUMINT UNSIGNED AUTO_INCREMENT ,
 	`sno` CHAR(20) NOT NULL  COMMENT '学号',
   `nickname` CHAR(20) NOT NULL COMMENT '昵称',
   `phone` CHAR(11) NOT NULL COMMENT '电话' ,
   `avatar_path`  VARCHAR(255) NOT NULL COMMENT '头像',
 	PRIMARY KEY(`uid`),
 	UNIQUE(`sno`)
 )ENGINE=InnoDB DEFAULT CHAR SET = 'UTF8';

 ALTER TABLE testalter_tbl ADD i INT AFTER c;
 TRUNCATE TABLE table1





create table admin(
	admin_id smallint unsigned not null auto_increment primary key comment '管理员编号',
	username varchar(30) not null default '' comment '管理员名称',
	password char(32) not null default '' comment '管理员密码',
	email varchar(50) not null default '' comment '管理员邮箱',
	add_time int unsigned not null default 0 comment '添加时间'
)ENGINE=InnoDB DEFAULT CHAR SET = 'UTF8';

insert into admin(username,password) values('admin','d8031a928a745c617fa4078f20b48655');
update admin set password = 'd18705bd4403f8611d236e38b310c692' where admin_id=1;

 CREATE TABLE  `admin` 
 (
 	`uid` MEDIUMINT UNSIGNED AUTO_INCREMENT ,
 	`sno` CHAR(20) NOT NULL  COMMENT '学号',
   `nickname` CHAR(20) NOT NULL COMMENT '昵称',
   `phone` CHAR(11) NOT NULL COMMENT '电话' ,
   `avatar_path`  VARCHAR(255) NOT NULL COMMENT '头像',
 	PRIMARY KEY(`uid`),
 	UNIQUE(`sno`)
 )ENGINE=InnoDB DEFAULT CHAR SET = 'UTF8';