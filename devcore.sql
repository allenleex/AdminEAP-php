/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50540
Source Host           : 127.0.0.1:3306
Source Database       : devcore

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-07-27 08:29:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `acl_classes`
-- ----------------------------
DROP TABLE IF EXISTS `acl_classes`;
CREATE TABLE `acl_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of acl_classes
-- ----------------------------

-- ----------------------------
-- Table structure for `acl_entries`
-- ----------------------------
DROP TABLE IF EXISTS `acl_entries`;
CREATE TABLE `acl_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) unsigned NOT NULL,
  `object_identity_id` int(10) unsigned DEFAULT NULL,
  `security_identity_id` int(10) unsigned NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) unsigned NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  KEY `IDX_46C8B806EA000B10` (`class_id`),
  KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  KEY `IDX_46C8B806DF9183C9` (`security_identity_id`),
  CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of acl_entries
-- ----------------------------

-- ----------------------------
-- Table structure for `acl_object_identities`
-- ----------------------------
DROP TABLE IF EXISTS `acl_object_identities`;
CREATE TABLE `acl_object_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_object_identity_id` int(10) unsigned DEFAULT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`),
  CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of acl_object_identities
-- ----------------------------

-- ----------------------------
-- Table structure for `acl_object_identity_ancestors`
-- ----------------------------
DROP TABLE IF EXISTS `acl_object_identity_ancestors`;
CREATE TABLE `acl_object_identity_ancestors` (
  `object_identity_id` int(10) unsigned NOT NULL,
  `ancestor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  KEY `IDX_825DE299C671CEA1` (`ancestor_id`),
  CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of acl_object_identity_ancestors
-- ----------------------------

-- ----------------------------
-- Table structure for `acl_security_identities`
-- ----------------------------
DROP TABLE IF EXISTS `acl_security_identities`;
CREATE TABLE `acl_security_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of acl_security_identities
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_menus`
-- ----------------------------
DROP TABLE IF EXISTS `cms_menus`;
CREATE TABLE `cms_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标识',
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '中文名称',
  `route` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '路由',
  `routeArgs` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '路由参数',
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标',
  `badge` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标记',
  `badgeColor` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标记颜色',
  `pid` int(11) NOT NULL COMMENT '上级ID',
  `children` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '下级',
  `checked` tinyint(1) NOT NULL COMMENT '是否审核',
  `binary_tree` tinyint(1) NOT NULL COMMENT '二叉树标识,1为启用',
  `left_node` int(11) NOT NULL COMMENT '左节点',
  `right_node` int(11) NOT NULL COMMENT '右节点',
  `attributes` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '属性表字段',
  `status` tinyint(1) NOT NULL COMMENT '是否启用',
  `sort` int(11) NOT NULL COMMENT '排序',
  `issystem` tinyint(1) NOT NULL COMMENT '是否系统字段',
  `identifier` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '唯一标识',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `is_delete` tinyint(1) NOT NULL COMMENT '0正常，1假删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='菜单表';

-- ----------------------------
-- Records of cms_menus
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_models`
-- ----------------------------
DROP TABLE IF EXISTS `cms_models`;
CREATE TABLE `cms_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '字段名',
  `title` varchar(50) NOT NULL COMMENT '模型名称',
  `service` varchar(50) NOT NULL COMMENT '服务名',
  `bundle` varchar(50) NOT NULL COMMENT '所属bundle',
  `relation` varchar(50) NOT NULL COMMENT '继承',
  `engine` varchar(20) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  `associated` varchar(50) NOT NULL COMMENT '关联字段',
  `structure` tinyint(1) NOT NULL COMMENT '0横表,1纵表',
  `is_binary` tinyint(1) NOT NULL COMMENT '是否二叉树',
  `attribute_table` int(11) NOT NULL COMMENT '属性表',
  `status` varchar(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `mode` smallint(6) NOT NULL COMMENT '模式',
  `type` smallint(6) NOT NULL COMMENT '类型',
  `plan` smallint(6) NOT NULL COMMENT '方案ID',
  `sort` smallint(6) NOT NULL COMMENT '排序',
  `issystem` tinyint(1) NOT NULL COMMENT '是否系统字段',
  `checked` tinyint(1) NOT NULL COMMENT '是否审核',
  `identifier` varchar(50) NOT NULL COMMENT '唯一标识',
  `attributes` varchar(10) NOT NULL COMMENT '属性表字段',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `is_delete` tinyint(1) NOT NULL COMMENT '0正常，1假删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_models
-- ----------------------------
INSERT INTO `cms_models` VALUES ('1', 'users', '用户表', 'db.users', 'ManageBundle', '', 'MyISAM', '', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', '12a7e327ecfcc6e2b13c5227fe2bb6d2', '', '1500880548', '1500966284', '1');
INSERT INTO `cms_models` VALUES ('2', 'models', '模型表', 'db.models', 'ManageBundle', '', 'MyISAM', '', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', 'ad116a632e2c5068281524c40a24bf47', '', '1500952055', '1500952361', '0');
INSERT INTO `cms_models` VALUES ('3', 'model_attribute', '模型字段表', 'db.model_attribute', 'ManageBundle', '', 'MyISAM', '', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', 'a496b230026ec5087dff504c6279d249', '', '1500952430', '1500952430', '0');
INSERT INTO `cms_models` VALUES ('4', 'model_form', '表单表', 'db.model_form', 'ManageBundle', '', 'MyISAM', '', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', 'b7ddb12768d0ea458b86956c0b8b005d', '', '1500952455', '1501038295', '0');
INSERT INTO `cms_models` VALUES ('5', 'model_form_attr', '表单字段表', 'db.model_form_attr', 'ManageBundle', '', 'MyISAM', '', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', '849b7ca84a9990cde42f3e34f9475c03', '', '1500952474', '1501038308', '0');
INSERT INTO `cms_models` VALUES ('6', 'menus', '菜单表', 'db.menus', 'ManageBundle', '', 'MyISAM', '', '0', '1', '0', '1', '0', '0', '0', '0', '1', '0', '005269955d5fbcd2c39a2dbbd6c7f9fd', '', '1500976158', '1501036093', '0');
INSERT INTO `cms_models` VALUES ('7', 'clonebase', '克隆表', 'db.clonebase', 'ManageBundle', '', 'MyISAM', '', '0', '0', '0', '1', '0', '0', '0', '0', '1', '0', 'a35febf598b4b0b7819c58192cbbda2f', '', '1501039882', '1501039882', '0');

-- ----------------------------
-- Table structure for `cms_model_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `cms_model_attribute`;
CREATE TABLE `cms_model_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '字段名',
  `title` varchar(50) NOT NULL COMMENT '中方名称',
  `length` smallint(6) NOT NULL COMMENT '长度',
  `field` varchar(50) NOT NULL COMMENT '字段定义',
  `type` varchar(50) NOT NULL COMMENT '字段类型',
  `value` varchar(20) NOT NULL COMMENT '默认值',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `extra` varchar(100) NOT NULL COMMENT '参数',
  `model_id` int(11) NOT NULL COMMENT '模型ID',
  `checked` tinyint(1) NOT NULL COMMENT '是否审核',
  `sort` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '是否启用',
  `attributes` varchar(10) NOT NULL COMMENT '属性表字段',
  `issystem` tinyint(1) NOT NULL COMMENT '是否系统字段',
  `identifier` varchar(50) NOT NULL COMMENT '唯一标识',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `is_delete` tinyint(1) NOT NULL COMMENT '0正常，1假删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_model_attribute
-- ----------------------------
INSERT INTO `cms_model_attribute` VALUES ('1', 'name', '字段名', '50', 'string', 'string', '', '', '', '2', '0', '0', '1', '', '0', 'ie9a0bab6720dc539c2a', '1500537383', '1501035299', '0');
INSERT INTO `cms_model_attribute` VALUES ('2', 'title', '模型名称', '50', 'string', 'string', '', '', '', '2', '0', '0', '1', '', '0', 'c1a510fc99200968e767f7cfbf956978', '1500976443', '1501035307', '0');
INSERT INTO `cms_model_attribute` VALUES ('3', 'service', '服务名', '50', 'string', 'string', '', '', '', '2', '0', '0', '1', '', '0', 'eec908674ddae2c11e8a51d3ba2e177e', '1500976736', '1501035326', '0');
INSERT INTO `cms_model_attribute` VALUES ('4', 'bundle', '所属bundle', '50', 'string', 'string', '', '', '', '2', '0', '0', '1', '', '0', '2c346e43fbc3eac090d5f6534f55893d', '1500976830', '1501035334', '0');
INSERT INTO `cms_model_attribute` VALUES ('5', 'engine', '数据库引擎', '20', 'string', 'string', 'MyISAM', '', '', '2', '0', '0', '1', '', '0', '71f1c598806ba2eb7a480c538d1ead36', '1500976855', '1501035353', '0');
INSERT INTO `cms_model_attribute` VALUES ('6', 'associated', '关联字段', '50', 'string', 'string', '', '', '', '2', '0', '0', '1', '', '0', '0be0239f6e9b70e209cd1871c45698fd', '1500976881', '1501035360', '0');
INSERT INTO `cms_model_attribute` VALUES ('7', 'structure', '表类型', '1', 'boolean', 'bool', '', '0横表,1纵表', '', '2', '0', '0', '1', '', '0', 'e8b69fe15abde124d1b94fae83aac0da', '1500976947', '1501035436', '0');
INSERT INTO `cms_model_attribute` VALUES ('8', 'relation', '继承', '50', 'string', 'string', '', '', '', '2', '0', '0', '1', '', '0', '34d7d2e04ac90125a071a042b65fa1eb', '1500976974', '1501035375', '0');
INSERT INTO `cms_model_attribute` VALUES ('9', 'is_binary', '是否二叉树', '1', 'boolean', 'bool', '', '', '', '2', '0', '0', '1', '', '0', '983eb033427c948505ad0b2e6db6aa6c', '1500976998', '1501054433', '0');
INSERT INTO `cms_model_attribute` VALUES ('10', 'status', '是否启用', '1', 'string', 'string', '1', '', '', '2', '0', '0', '1', '', '0', 'e6146dd66f0c42734882dd2c1ac43d44', '1500977025', '1501052334', '0');
INSERT INTO `cms_model_attribute` VALUES ('11', 'sort', '排序', '3', 'smallint', 'smallint', '', '', '', '2', '0', '0', '1', '', '0', 'e96890e329507a90cc4866b2e7e16440', '1500977050', '1501035467', '0');
INSERT INTO `cms_model_attribute` VALUES ('12', 'mode', '模式', '3', 'smallint', 'smallint', '', '', '', '2', '0', '0', '1', '', '0', 'f21869ba650539cae2266fe34dcf5a04', '1500977072', '1501035482', '0');
INSERT INTO `cms_model_attribute` VALUES ('13', 'type', '类型', '3', 'smallint', 'smallint', '', '', '', '2', '0', '0', '1', '', '0', '377431b6a0742ee0a50c22a625134c80', '1500977094', '1501035493', '0');
INSERT INTO `cms_model_attribute` VALUES ('14', 'name', '名称', '50', 'string', 'string', '', '', '', '7', '0', '0', '1', '', '0', 'a2923a430aea8ebebc7084e6fb54be71', '1501040133', '1501040133', '0');
INSERT INTO `cms_model_attribute` VALUES ('15', 'name', '标识', '50', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', 'f857a21293541523a8d8b812d7c55f4e', '1501053310', '1501053310', '0');
INSERT INTO `cms_model_attribute` VALUES ('16', 'label', '中文名称', '50', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', 'a6e34df7a2704b23b68bea821ff27b47', '1501053387', '1501053387', '0');
INSERT INTO `cms_model_attribute` VALUES ('17', 'route', '路由', '100', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', 'c8362dbea7ee606a0a4da76c00d298f5', '1501053569', '1501053569', '0');
INSERT INTO `cms_model_attribute` VALUES ('18', 'routeArgs', '路由参数', '100', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', '8b13e1b610781e9f427924db4fbb6bd1', '1501053599', '1501053599', '0');
INSERT INTO `cms_model_attribute` VALUES ('19', 'icon', '图标', '50', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', '044696e8eddccc18a005944aa1faf29a', '1501053631', '1501053631', '0');
INSERT INTO `cms_model_attribute` VALUES ('20', 'badge', '标记', '50', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', 'dd911ed9d3359bdac0296615227e91f3', '1501053722', '1501053722', '0');
INSERT INTO `cms_model_attribute` VALUES ('21', 'badgeColor', '标记颜色', '50', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', 'df1ba74492aea3dcb9611ebfb923bcca', '1501053739', '1501053739', '0');
INSERT INTO `cms_model_attribute` VALUES ('22', 'pid', '上级ID', '10', 'integer', 'numeric', '', '', '', '6', '0', '0', '1', '', '0', 'ec942db3561d73a23ba93950ef71f24a', '1501053836', '1501053836', '0');
INSERT INTO `cms_model_attribute` VALUES ('23', 'children', '下级', '10', 'string', 'string', '', '', '', '6', '0', '0', '1', '', '0', '10990b3d9906b1572eb8e7a4f9f2af75', '1501053853', '1501053853', '0');
INSERT INTO `cms_model_attribute` VALUES ('24', 'attribute_table', '属性表', '10', 'integer', 'numeric', '', '', '', '2', '0', '0', '1', '', '0', 'bb1919458d08b0d440e704b1d0d9fce5', '1501054458', '1501054458', '0');
INSERT INTO `cms_model_attribute` VALUES ('25', 'plan', '方案ID', '3', 'smallint', 'smallint', '', '', '', '2', '0', '0', '1', '', '0', '0dbe57142a3f3dfe1bca4d965cb78a93', '1501055580', '1501055580', '0');
INSERT INTO `cms_model_attribute` VALUES ('26', 'name', '字段名', '50', 'string', 'string', '', '', '', '3', '0', '0', '1', '', '0', '0dbe57142a3f3dfe1bca4d965cb78a92', '1501055580', '1501055580', '0');
INSERT INTO `cms_model_attribute` VALUES ('27', 'title', '中方名称', '50', 'string', 'string', '', '', '', '3', '0', '0', '1', '', '0', '0edcbb98215f9877d2bb3fbd0c7da94c', '1501056529', '1501056529', '0');
INSERT INTO `cms_model_attribute` VALUES ('28', 'length', '长度', '3', 'smallint', 'smallint', '', '', '', '3', '0', '0', '1', '', '0', '11a4d33682e897f8dedb48c750c663df', '1501056550', '1501056550', '0');
INSERT INTO `cms_model_attribute` VALUES ('29', 'field', '字段定义', '50', 'string', 'string', '', '', '', '3', '0', '0', '1', '', '0', '52b6de40b3f42318cf043bd6a74b87a4', '1501056568', '1501056568', '0');
INSERT INTO `cms_model_attribute` VALUES ('30', 'type', '字段类型', '50', 'string', 'string', '', '', '', '3', '0', '0', '1', '', '0', '8b67545fd02b12f3f82da52633a69a1e', '1501056584', '1501056584', '0');
INSERT INTO `cms_model_attribute` VALUES ('31', 'value', '默认值', '20', 'string', 'string', '', '', '', '3', '0', '0', '1', '', '0', '3a105e189a4b67176ac7510d22ca6af4', '1501056601', '1501056601', '0');
INSERT INTO `cms_model_attribute` VALUES ('32', 'remark', '备注', '50', 'string', 'string', '', '', '', '3', '0', '0', '1', '', '0', 'c7a7d3beb9c3c3e69740fdc7b9bd1564', '1501056622', '1501056622', '0');
INSERT INTO `cms_model_attribute` VALUES ('33', 'extra', '参数', '100', 'string', 'string', '', '', '', '3', '0', '0', '1', '', '0', '6cb05899e4f0e93a55419653a59e68f1', '1501056641', '1501056641', '0');
INSERT INTO `cms_model_attribute` VALUES ('34', 'model_id', '模型ID', '10', 'integer', 'numeric', '', '', '', '3', '0', '0', '1', '', '0', 'b92564a68226c1431ed091578072590d', '1501056664', '1501056664', '0');

-- ----------------------------
-- Table structure for `cms_model_form`
-- ----------------------------
DROP TABLE IF EXISTS `cms_model_form`;
CREATE TABLE `cms_model_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL COMMENT '备注',
  `model_id` int(10) NOT NULL COMMENT '模型ID',
  `bindform` int(10) NOT NULL COMMENT '关联表单',
  `bindfield` varchar(50) NOT NULL COMMENT '关联字段',
  `parent_form` varchar(100) NOT NULL COMMENT '继承表单',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `type` tinyint(1) NOT NULL COMMENT '类型,0横表,1纵表',
  `status` tinyint(1) NOT NULL COMMENT '1启用，0禁用',
  `sort` smallint(3) NOT NULL COMMENT '排序',
  `fmgroup` smallint(3) NOT NULL COMMENT '1=继承 2=区块文档 3=文档 4=推送 5=会员认证 6=会员组',
  `url` varchar(100) NOT NULL COMMENT '链接',
  `initcondition` varchar(200) NOT NULL,
  `initmodel` varchar(50) NOT NULL COMMENT '初始化模型',
  `checked` tinyint(1) NOT NULL COMMENT '是否审核',
  `attributes` varchar(10) NOT NULL,
  `issystem` tinyint(1) NOT NULL COMMENT '是否系统字段',
  `identifier` varchar(50) NOT NULL COMMENT '唯一标识',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `is_delete` tinyint(1) NOT NULL COMMENT '0正常，1假删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_model_form
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_model_form_attr`
-- ----------------------------
DROP TABLE IF EXISTS `cms_model_form_attr`;
CREATE TABLE `cms_model_form_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '表单字段名称',
  `type` varchar(50) NOT NULL,
  `label` varchar(50) NOT NULL COMMENT '表单字段label',
  `attr` varchar(200) NOT NULL COMMENT '表单字段属性',
  `choices` varchar(200) NOT NULL COMMENT '下拉框参数',
  `required` tinyint(1) NOT NULL COMMENT '0否，1是',
  `entitypath` varchar(100) NOT NULL COMMENT 'entity路径',
  `property` varchar(100) NOT NULL COMMENT 'entity关联字段名',
  `query_builder` varchar(200) NOT NULL COMMENT '查询规则',
  `model_form_id` int(10) NOT NULL COMMENT '关联表单ID',
  `validate_rule` varchar(100) NOT NULL COMMENT '验证规则',
  `error_info` varchar(50) NOT NULL COMMENT '出错提示',
  `auto_type` varchar(50) NOT NULL COMMENT '自动完成方式function比函数,field字段,string字符串',
  `value` varchar(50) NOT NULL COMMENT '默认值',
  `isonly` tinyint(1) NOT NULL COMMENT '是否唯一，0否，1是',
  `bundle` varchar(50) NOT NULL COMMENT '所属Bundle',
  `dealhtml` varchar(100) NOT NULL COMMENT 'HTML处理',
  `dealhtmltags` varchar(100) NOT NULL COMMENT 'HTML处理项',
  `checked` tinyint(1) NOT NULL COMMENT '是否审核',
  `attributes` varchar(10) NOT NULL,
  `issystem` tinyint(1) NOT NULL,
  `identifier` varchar(50) NOT NULL COMMENT '唯一标识',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_model_form_attr
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_users`
-- ----------------------------
DROP TABLE IF EXISTS `cms_users`;
CREATE TABLE `cms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` tinyint(1) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `login_salt` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `loginip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `logintime` int(11) NOT NULL,
  `token` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3AF03EC5F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cms_users
-- ----------------------------
INSERT INTO `cms_users` VALUES ('1', '1', 'house', '9cf280660a4c70b1dc29ff87cb99228c', 'sabcfgiofw', 'house@163.com', '13763118691', '', '2b711c790b', 'zh_CN', '127.0.0.1', '1501060972', 'af9a0bab6720dc539c4a2c998d9f28', 'ie9a0bab6720dc539c4a', '1', '1500537381', '1500537381', '0');
INSERT INTO `cms_users` VALUES ('2', '0', 'anday', '9cf280660a4c70b1dc29ff87cb99228c', 'sabcfgi1fw', 'anday@163.com', '13576650098', '', 'fa12bcdf21', 'zh_CN2', '', '1500519356', 'af9a0bab6720dc539c4a2c998d9f22', 'ie9a0bab6720dc539c4b', '1', '1500537383', '1500537383', '0');
