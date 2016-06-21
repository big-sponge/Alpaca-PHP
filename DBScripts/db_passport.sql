CREATE DATABASE `db_passport`;
use db_passport;



CREATE TABLE `tb_domain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO `tb_domain` VALUES ('18', 'www.baidu.com', '介绍');
INSERT INTO `tb_domain` VALUES ('19', 'www.baidu.com', '介绍');
INSERT INTO `tb_domain` VALUES ('20', 'pay.1010shuju.com', '介绍');
INSERT INTO `tb_domain` VALUES ('21', 'dsajkljl.com', '介绍');
INSERT INTO `tb_domain` VALUES ('22', 'pay.1010shuju.com', '介绍');
INSERT INTO `tb_domain` VALUES ('23', 'scf.1010shuju.com', '介绍');


CREATE TABLE `tb_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `relation_account` varchar(255) DEFAULT NULL,
  `bind_account` varchar(255) DEFAULT NULL,
  `domain_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `tb_relation` VALUES ('15', '20', 'lideshun', '18');
INSERT INTO `tb_relation` VALUES ('16', '20', '231321', '19');
INSERT INTO `tb_relation` VALUES ('17', '21', 'lideshun08', '20');
INSERT INTO `tb_relation` VALUES ('18', '21', 'lideshun02', '21');
INSERT INTO `tb_relation` VALUES ('19', '22', 'sub@qq.com', '22');
INSERT INTO `tb_relation` VALUES ('20', '22', 'sub@qq.com', '23');

CREATE TABLE `tb_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO `tb_user` VALUES ('20', 'lideshun');
INSERT INTO `tb_user` VALUES ('21', 'lideshun08');
INSERT INTO `tb_user` VALUES ('22', 'sub@qq.com');
