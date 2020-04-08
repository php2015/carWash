/*
Navicat MySQL Data Transfer

Source Server         : phpstudy
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : carwash

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-10-16 16:32:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dp_admin_access
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_access`;
CREATE TABLE `dp_admin_access` (
  `module` varchar(16) NOT NULL DEFAULT '' COMMENT '模型名称',
  `group` varchar(16) NOT NULL DEFAULT '' COMMENT '权限分组标识',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `nid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '授权节点id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='统一授权表';

-- ----------------------------
-- Records of dp_admin_access
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_action
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_action`;
CREATE TABLE `dp_admin_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(16) NOT NULL DEFAULT '' COMMENT '所属模块名',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` varchar(80) NOT NULL DEFAULT '' COMMENT '行为标题',
  `remark` varchar(128) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text NOT NULL COMMENT '行为规则',
  `log` text NOT NULL COMMENT '日志规则',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='系统行为表';

-- ----------------------------
-- Records of dp_admin_action
-- ----------------------------
INSERT INTO `dp_admin_action` VALUES ('1', 'user', 'user_add', '添加用户', '添加用户', '', '[user|get_nickname] 添加了用户：[record|get_nickname]', '1', '1480156399', '1480163853');
INSERT INTO `dp_admin_action` VALUES ('2', 'user', 'user_edit', '编辑用户', '编辑用户', '', '[user|get_nickname] 编辑了用户：[details]', '1', '1480164578', '1480297748');
INSERT INTO `dp_admin_action` VALUES ('3', 'user', 'user_delete', '删除用户', '删除用户', '', '[user|get_nickname] 删除了用户：[details]', '1', '1480168582', '1480168616');
INSERT INTO `dp_admin_action` VALUES ('4', 'user', 'user_enable', '启用用户', '启用用户', '', '[user|get_nickname] 启用了用户：[details]', '1', '1480169185', '1480169185');
INSERT INTO `dp_admin_action` VALUES ('5', 'user', 'user_disable', '禁用用户', '禁用用户', '', '[user|get_nickname] 禁用了用户：[details]', '1', '1480169214', '1480170581');
INSERT INTO `dp_admin_action` VALUES ('6', 'user', 'user_access', '用户授权', '用户授权', '', '[user|get_nickname] 对用户：[record|get_nickname] 进行了授权操作。详情：[details]', '1', '1480221441', '1480221563');
INSERT INTO `dp_admin_action` VALUES ('7', 'user', 'role_add', '添加角色', '添加角色', '', '[user|get_nickname] 添加了角色：[details]', '1', '1480251473', '1480251473');
INSERT INTO `dp_admin_action` VALUES ('8', 'user', 'role_edit', '编辑角色', '编辑角色', '', '[user|get_nickname] 编辑了角色：[details]', '1', '1480252369', '1480252369');
INSERT INTO `dp_admin_action` VALUES ('9', 'user', 'role_delete', '删除角色', '删除角色', '', '[user|get_nickname] 删除了角色：[details]', '1', '1480252580', '1480252580');
INSERT INTO `dp_admin_action` VALUES ('10', 'user', 'role_enable', '启用角色', '启用角色', '', '[user|get_nickname] 启用了角色：[details]', '1', '1480252620', '1480252620');
INSERT INTO `dp_admin_action` VALUES ('11', 'user', 'role_disable', '禁用角色', '禁用角色', '', '[user|get_nickname] 禁用了角色：[details]', '1', '1480252651', '1480252651');
INSERT INTO `dp_admin_action` VALUES ('12', 'user', 'attachment_enable', '启用附件', '启用附件', '', '[user|get_nickname] 启用了附件：附件ID([details])', '1', '1480253226', '1480253332');
INSERT INTO `dp_admin_action` VALUES ('13', 'user', 'attachment_disable', '禁用附件', '禁用附件', '', '[user|get_nickname] 禁用了附件：附件ID([details])', '1', '1480253267', '1480253340');
INSERT INTO `dp_admin_action` VALUES ('14', 'user', 'attachment_delete', '删除附件', '删除附件', '', '[user|get_nickname] 删除了附件：附件ID([details])', '1', '1480253323', '1480253323');
INSERT INTO `dp_admin_action` VALUES ('15', 'admin', 'config_add', '添加配置', '添加配置', '', '[user|get_nickname] 添加了配置，[details]', '1', '1480296196', '1480296196');
INSERT INTO `dp_admin_action` VALUES ('16', 'admin', 'config_edit', '编辑配置', '编辑配置', '', '[user|get_nickname] 编辑了配置：[details]', '1', '1480296960', '1480296960');
INSERT INTO `dp_admin_action` VALUES ('17', 'admin', 'config_enable', '启用配置', '启用配置', '', '[user|get_nickname] 启用了配置：[details]', '1', '1480298479', '1480298479');
INSERT INTO `dp_admin_action` VALUES ('18', 'admin', 'config_disable', '禁用配置', '禁用配置', '', '[user|get_nickname] 禁用了配置：[details]', '1', '1480298506', '1480298506');
INSERT INTO `dp_admin_action` VALUES ('19', 'admin', 'config_delete', '删除配置', '删除配置', '', '[user|get_nickname] 删除了配置：[details]', '1', '1480298532', '1480298532');
INSERT INTO `dp_admin_action` VALUES ('20', 'admin', 'database_export', '备份数据库', '备份数据库', '', '[user|get_nickname] 备份了数据库：[details]', '1', '1480298946', '1480298946');
INSERT INTO `dp_admin_action` VALUES ('21', 'admin', 'database_import', '还原数据库', '还原数据库', '', '[user|get_nickname] 还原了数据库：[details]', '1', '1480301990', '1480302022');
INSERT INTO `dp_admin_action` VALUES ('22', 'admin', 'database_optimize', '优化数据表', '优化数据表', '', '[user|get_nickname] 优化了数据表：[details]', '1', '1480302616', '1480302616');
INSERT INTO `dp_admin_action` VALUES ('23', 'admin', 'database_repair', '修复数据表', '修复数据表', '', '[user|get_nickname] 修复了数据表：[details]', '1', '1480302798', '1480302798');
INSERT INTO `dp_admin_action` VALUES ('24', 'admin', 'database_backup_delete', '删除数据库备份', '删除数据库备份', '', '[user|get_nickname] 删除了数据库备份：[details]', '1', '1480302870', '1480302870');
INSERT INTO `dp_admin_action` VALUES ('25', 'admin', 'hook_add', '添加钩子', '添加钩子', '', '[user|get_nickname] 添加了钩子：[details]', '1', '1480303198', '1480303198');
INSERT INTO `dp_admin_action` VALUES ('26', 'admin', 'hook_edit', '编辑钩子', '编辑钩子', '', '[user|get_nickname] 编辑了钩子：[details]', '1', '1480303229', '1480303229');
INSERT INTO `dp_admin_action` VALUES ('27', 'admin', 'hook_delete', '删除钩子', '删除钩子', '', '[user|get_nickname] 删除了钩子：[details]', '1', '1480303264', '1480303264');
INSERT INTO `dp_admin_action` VALUES ('28', 'admin', 'hook_enable', '启用钩子', '启用钩子', '', '[user|get_nickname] 启用了钩子：[details]', '1', '1480303294', '1480303294');
INSERT INTO `dp_admin_action` VALUES ('29', 'admin', 'hook_disable', '禁用钩子', '禁用钩子', '', '[user|get_nickname] 禁用了钩子：[details]', '1', '1480303409', '1480303409');
INSERT INTO `dp_admin_action` VALUES ('30', 'admin', 'menu_add', '添加节点', '添加节点', '', '[user|get_nickname] 添加了节点：[details]', '1', '1480305468', '1480305468');
INSERT INTO `dp_admin_action` VALUES ('31', 'admin', 'menu_edit', '编辑节点', '编辑节点', '', '[user|get_nickname] 编辑了节点：[details]', '1', '1480305513', '1480305513');
INSERT INTO `dp_admin_action` VALUES ('32', 'admin', 'menu_delete', '删除节点', '删除节点', '', '[user|get_nickname] 删除了节点：[details]', '1', '1480305562', '1480305562');
INSERT INTO `dp_admin_action` VALUES ('33', 'admin', 'menu_enable', '启用节点', '启用节点', '', '[user|get_nickname] 启用了节点：[details]', '1', '1480305630', '1480305630');
INSERT INTO `dp_admin_action` VALUES ('34', 'admin', 'menu_disable', '禁用节点', '禁用节点', '', '[user|get_nickname] 禁用了节点：[details]', '1', '1480305659', '1480305659');
INSERT INTO `dp_admin_action` VALUES ('35', 'admin', 'module_install', '安装模块', '安装模块', '', '[user|get_nickname] 安装了模块：[details]', '1', '1480307558', '1480307558');
INSERT INTO `dp_admin_action` VALUES ('36', 'admin', 'module_uninstall', '卸载模块', '卸载模块', '', '[user|get_nickname] 卸载了模块：[details]', '1', '1480307588', '1480307588');
INSERT INTO `dp_admin_action` VALUES ('37', 'admin', 'module_enable', '启用模块', '启用模块', '', '[user|get_nickname] 启用了模块：[details]', '1', '1480307618', '1480307618');
INSERT INTO `dp_admin_action` VALUES ('38', 'admin', 'module_disable', '禁用模块', '禁用模块', '', '[user|get_nickname] 禁用了模块：[details]', '1', '1480307653', '1480307653');
INSERT INTO `dp_admin_action` VALUES ('39', 'admin', 'module_export', '导出模块', '导出模块', '', '[user|get_nickname] 导出了模块：[details]', '1', '1480307682', '1480307682');
INSERT INTO `dp_admin_action` VALUES ('40', 'admin', 'packet_install', '安装数据包', '安装数据包', '', '[user|get_nickname] 安装了数据包：[details]', '1', '1480308342', '1480308342');
INSERT INTO `dp_admin_action` VALUES ('41', 'admin', 'packet_uninstall', '卸载数据包', '卸载数据包', '', '[user|get_nickname] 卸载了数据包：[details]', '1', '1480308372', '1480308372');
INSERT INTO `dp_admin_action` VALUES ('42', 'admin', 'system_config_update', '更新系统设置', '更新系统设置', '', '[user|get_nickname] 更新了系统设置：[details]', '1', '1480309555', '1480309642');

-- ----------------------------
-- Table structure for dp_admin_attachment
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_attachment`;
CREATE TABLE `dp_admin_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `module` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名，由哪个模块上传的',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件链接',
  `mime` varchar(128) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `ext` char(8) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT 'sha1 散列值',
  `driver` varchar(16) NOT NULL DEFAULT 'local' COMMENT '上传驱动',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `width` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '图片宽度',
  `height` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '原图路径',
  `handle_type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片处理类型 2补白,3截取,6压缩',
  `cut_size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片处理后的尺寸',
  PRIMARY KEY (`id`),
  KEY `awidth` (`width`) USING BTREE COMMENT '宽度索引',
  KEY `aheight` (`height`) USING BTREE COMMENT '高度索引',
  KEY `apath` (`path`) USING BTREE COMMENT '高度索引',
  KEY `amd5` (`md5`) USING BTREE COMMENT 'md5索引'
) ENGINE=MyISAM AUTO_INCREMENT=200 DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of dp_admin_attachment
-- ----------------------------
INSERT INTO `dp_admin_attachment` VALUES ('14', '1', 'intro.jpg', 'carwash', 'uploads/images/20180905/85e61eb5f12231b427a724e32d527508.jpg', 'uploads/images/20180905/thumb/85e61eb5f12231b427a724e32d527508.jpg', '', 'image/jpeg', 'jpg', '3689', 'b0df9388cc7e49c158337f79cae599ca', '1c2d9409b8a192a4dcb6ca533a81d97df7c3c743', 'local', '0', '1536129099', '1536129099', '100', '1', '80', '80', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('13', '1', 'face.jpg', 'carwash', 'uploads/images/20180905/83dd02f9407f87882a9062adcdcc0128.jpg', 'uploads/images/20180905/thumb/83dd02f9407f87882a9062adcdcc0128.jpg', '', 'image/jpeg', 'jpg', '9897', '1e060075f2b21d8e18920cefffaf15a4', 'a9977651784fbbd384b19ce4bb7a3f0ef57531ec', 'local', '0', '1536128770', '1536128770', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('12', '1', '0fafe72de56e4518157b3ab26a3dc1bb139c5c09acb6-qGQq3G_sq320.jpg', 'carwash', 'uploads/images/20180903/01c4f86e1d1a33da79c852894188705a.jpg', 'uploads/images/20180903/thumb/01c4f86e1d1a33da79c852894188705a.jpg', '', 'image/jpeg', 'jpg', '40480', '542f30e95b6ade1dd8e01312e8cc649f', '6b58474decb04dcf52e8eb3df1e4adbae00913dd', 'local', '0', '1535947112', '1535947112', '100', '1', '320', '320', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('11', '1', 'timg.jpg', 'carwash', 'uploads/images/20180903/206e9626a251fa289e9b05d9a438ad1e.jpg', 'uploads/images/20180903/thumb/206e9626a251fa289e9b05d9a438ad1e.jpg', '', 'image/jpeg', 'jpg', '73598', 'c77c29ad253cefa4e141586eaa242467', '984289aaeac3664c40a23c1b6f0784e8937553b0', 'local', '0', '1535947107', '1535947107', '100', '1', '1024', '685', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('8', '1', '8fc3486a5c0e04209a43b3ba2415389153daa40360a5-EdIfBv_sq320.jpg', 'carwash', 'uploads/images/20180903/ae22aae4ec7177e8838e0d3294a9eede.jpg', 'uploads/images/20180903/thumb/ae22aae4ec7177e8838e0d3294a9eede.jpg', '', 'image/jpeg', 'jpg', '15785', '6dc18c592907d942bc78fa3bf870fd08', '10e62c3eee36f9c5590b83c71fc4b6c09992fa01', 'local', '0', '1535947068', '1535947068', '100', '1', '320', '320', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('9', '1', '642235086ceca8ab6d9ca38651af303f3992a05119a96-4K2MNP_sq320.jpg', 'carwash', 'uploads/images/20180903/f80e8a9ad042c5739df85af3f49d70b2.jpg', 'uploads/images/20180903/thumb/f80e8a9ad042c5739df85af3f49d70b2.jpg', '', 'image/jpeg', 'jpg', '36245', '7789262efc4b968cb86fa0292f6cc18e', '74797806d57bc9f26dfa197a34a16af4379b1c7b', 'local', '0', '1535947106', '1535947106', '100', '1', '320', '320', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('10', '1', 'timg (1).jpg', 'carwash', 'uploads/images/20180903/dff3d1c5f9e0ef54f353cdf5ee98b447.jpg', 'uploads/images/20180903/thumb/dff3d1c5f9e0ef54f353cdf5ee98b447.jpg', '', 'image/jpeg', 'jpg', '22358', '1869e757b6b82d32c29fc308901d4880', '66c2a22acbf37dbadf2e3c0ad2447154536fbb5c', 'local', '0', '1535947106', '1535947106', '100', '1', '500', '375', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('15', '1', 'u=26840145,173788882&fm=26&gp=0.jpg', 'carwash', 'uploads/images/20180905/a976d8bf44f8c818e6909be4b202cb83.jpg', 'uploads/images/20180905/thumb/a976d8bf44f8c818e6909be4b202cb83.jpg', '', 'image/jpeg', 'jpg', '24037', 'db28f7560547ad3ab1721fc8783d5b4e', '7e28d0ea0a710d357362f7d5acb33fda2c8b358c', 'local', '0', '1536131740', '1536131740', '100', '1', '500', '310', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('16', '1', 'u=1095796692,1243030003&fm=200&gp=0.jpg', 'carwash', 'uploads/images/20180905/97d1de23b533f2ebf30b8e07b5c2985c.jpg', 'uploads/images/20180905/thumb/97d1de23b533f2ebf30b8e07b5c2985c.jpg', '', 'image/jpeg', 'jpg', '34113', '9b77ecf121077416851e4fbb6edef344', '8990e74f3e59513bd0e7cc1a76123f9f956ccc6f', 'local', '0', '1536131744', '1536131744', '100', '1', '500', '333', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('17', '1', 'u=1310248337,4225955283&fm=26&gp=0.jpg', 'carwash', 'uploads/images/20180905/273b2e24f1150f03fbbccb50070411fb.jpg', 'uploads/images/20180905/thumb/273b2e24f1150f03fbbccb50070411fb.jpg', '', 'image/jpeg', 'jpg', '29365', '858d262d6427788a7aeee873d0eed08f', 'ea5ae2f65581ba87008ee78c1152dec4f98ee957', 'local', '0', '1536131744', '1536131744', '100', '1', '468', '219', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('18', '1', 'u=1895991766,2439590693&fm=200&gp=0.jpg', 'carwash', 'uploads/images/20180905/1d7b980b8f42acc377f71ab4ebeeddff.jpg', 'uploads/images/20180905/thumb/1d7b980b8f42acc377f71ab4ebeeddff.jpg', '', 'image/jpeg', 'jpg', '39384', '6feb08c44117fe18181bdc83c353c451', '06b352dbbef30f5d81828fd648e48c68d8fb6e62', 'local', '0', '1536131745', '1536131745', '100', '1', '500', '333', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('19', '1', '下载.jpg', 'carwash', 'uploads/images/20180905/cb336b19bc5f1a9a64de6a7989ce355e.jpg', 'uploads/images/20180905/thumb/cb336b19bc5f1a9a64de6a7989ce355e.jpg', '', 'image/jpeg', 'jpg', '54443', '090203f2c6e8a80fcf81956df33922e9', '5814538e628c4eeabb7db34827f52c42d09c188b', 'local', '0', '1536131917', '1536131917', '100', '1', '474', '220', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('20', '1', 'background.jpg', 'carwash', 'uploads/images/20180905/c8bad219a97be67d1e14b0d262b131e3.jpg', 'uploads/images/20180905/thumb/c8bad219a97be67d1e14b0d262b131e3.jpg', '', 'image/jpeg', 'jpg', '10015', '6d5a316a4da6fd2fadfe970f7589945f', 'f4ee1dc02a659ee793fdad808eb78cd44c64f626', 'local', '0', '1536135959', '1536135959', '100', '1', '1024', '576', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('21', '1', 'u=2726111264,504523095&fm=26&gp=0.jpg', 'carwash', 'uploads/images/20180905/404e48b46c954a7e92f3a3334ee6a63f.jpg', 'uploads/images/20180905/thumb/404e48b46c954a7e92f3a3334ee6a63f.jpg', '', 'image/jpeg', 'jpg', '27813', 'fb38e79d7806042a2178a378023501a7', 'f88b9efd1ec338f1b196c5a8f2ccc90870978469', 'local', '0', '1536138223', '1536138223', '100', '1', '500', '308', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('22', '1', 'u=2183025435,2049527703&fm=200&gp=0.jpg', 'carwash', 'uploads/images/20180905/201f7c24026c94d49777b379d20c2989.jpg', 'uploads/images/20180905/thumb/201f7c24026c94d49777b379d20c2989.jpg', '', 'image/jpeg', 'jpg', '42789', '5f17b7e952ea75510b2998c352c81c43', 'f19a34c26a528d2ac3889f66c0c6b7624f6d4b78', 'local', '0', '1536138236', '1536138236', '100', '1', '500', '333', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('23', '1', 'dandelion.png', 'carwash', 'uploads/images/20180905/ff212a219752e3611be28856207699dc.png', 'uploads/images/20180905/thumb/ff212a219752e3611be28856207699dc.png', '', 'image/png', 'png', '1587', '5dd121c55920251eee24f84f03882ae5', 'af201d0a50ac25676b98305044dd05e064a8a346', 'local', '0', '1536140722', '1536140722', '100', '1', '30', '30', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('24', '1', 'u=2789612190,3291840295&fm=26&gp=0.jpg', 'carwash', 'uploads/images/20180905/ced4934cda672bb678dd14b2b91aecb6.jpg', 'uploads/images/20180905/thumb/ced4934cda672bb678dd14b2b91aecb6.jpg', '', 'image/jpeg', 'jpg', '36247', '0f7921f5a1e85b8870de4832274667ea', 'a399fa8607d2e542f7ff63288e0db53919367b6f', 'local', '0', '1536143065', '1536143065', '100', '1', '500', '373', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('25', '1', '微信截图_20180906142516.png', 'carwash', 'uploads/images/20180906/b1e4b2a23fbad091f8f4708a71e0e173.png', 'uploads/images/20180906/thumb/b1e4b2a23fbad091f8f4708a71e0e173.png', '', 'image/png', 'png', '1828', 'b8e78c10a8d281a1070caebffea32c80', '34cbcd43539552a88a251bfe631a0b53328d7dfa', 'local', '0', '1536215454', '1536215454', '100', '1', '116', '106', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('26', '1', '微信截图_20180906142627.png', 'carwash', 'uploads/images/20180906/f59b83e8c731266c2a63761c29b8e6cc.png', 'uploads/images/20180906/thumb/f59b83e8c731266c2a63761c29b8e6cc.png', '', 'image/png', 'png', '2077', 'bcb8c54ccd48cc39e0f9835b2d5cba46', '01c710a4e9fe0e4db95f2892cc55dc9cd348e12a', 'local', '0', '1536215980', '1536215980', '100', '1', '121', '111', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('27', '1', 'cover.jpg', 'carwash', 'uploads/images/20180906/9996b29a063c5480de70f7c3ef92a46f.jpg', 'uploads/images/20180906/thumb/9996b29a063c5480de70f7c3ef92a46f.jpg', '', 'image/jpeg', 'jpg', '3966', '35d603395ff29122584efc8e3144dfe2', '3d081f8f71babb3573f50edac8c5b2c9ce6c35ec', 'local', '0', '1536216600', '1536216600', '100', '1', '103', '103', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('28', '1', 'super_far.jpg', 'carwash', 'uploads/images/20180906/21b0dd4f384633a9b848f251b7568f25.jpg', 'uploads/images/20180906/thumb/21b0dd4f384633a9b848f251b7568f25.jpg', '', 'image/jpeg', 'jpg', '5249', 'f8f02bbccf00a5d75b03152813937f91', '7d33d1ee244a6a8981870bf8e2b1d95e99458640', 'local', '0', '1536216732', '1536216732', '100', '1', '156', '156', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('29', '1', 'clsr.jpg', 'carwash', 'uploads/images/20180906/b21e21f9fe5b68e1327a2558701d2084.jpg', 'uploads/images/20180906/thumb/b21e21f9fe5b68e1327a2558701d2084.jpg', '', 'image/jpeg', 'jpg', '26065', '2d572c60892d391fd9cf4458a8f9c542', '2a0ce0e88d60c393dedb5bb9fffbf0f51c4e8a9a', 'local', '0', '1536216850', '1536216850', '100', '1', '210', '210', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('30', '1', '微信截图_20180906142636.png', 'carwash', 'uploads/images/20180906/19c64f63b72dcdc4f4690aa291d8ebaf.png', 'uploads/images/20180906/thumb/19c64f63b72dcdc4f4690aa291d8ebaf.png', '', 'image/png', 'png', '1680', 'a6b145003691c67dd7519bdc86bd053a', '438cccf53128a9750c06afbd7078ad3bf8aaa1f0', 'local', '0', '1536227770', '1536227770', '100', '1', '110', '111', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('31', '1', '微信截图_20180906142620.png', 'carwash', 'uploads/images/20180906/28c4d0a33e629ef356e23c33f7213733.png', 'uploads/images/20180906/thumb/28c4d0a33e629ef356e23c33f7213733.png', '', 'image/png', 'png', '2437', '2089775b0da11149c14cac82c1b4f34d', '459d82380be813d1b3fc47cae70e3ba6bcf51215', 'local', '0', '1536227773', '1536227773', '100', '1', '118', '129', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('32', '1', '微信截图_20180906142530.png', 'carwash', 'uploads/images/20180906/e6244c6b63029e5ce3a8bb2917b652cb.png', 'uploads/images/20180906/thumb/e6244c6b63029e5ce3a8bb2917b652cb.png', '', 'image/png', 'png', '2322', 'de9a128ae2444676b2d7106716fc1aee', '1c36639f68ad440e05a8fb28ca8f301aea92148d', 'local', '0', '1536227777', '1536227777', '100', '1', '119', '123', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('33', '1', '微信截图_20180906142644.png', 'carwash', 'uploads/images/20180906/509c7a9309d8c441099633a877a69327.png', 'uploads/images/20180906/thumb/509c7a9309d8c441099633a877a69327.png', '', 'image/png', 'png', '2070', '5d07b0deaa5bb8103f3c051315c552f5', 'ab800f63a14e298c88fe113c8f0774a7fde5e83b', 'local', '0', '1536227993', '1536227993', '100', '1', '119', '112', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('34', '1', '微信截图_20180906142651.png', 'carwash', 'uploads/images/20180906/929affc2b82cb83b71bb30bd87259002.png', 'uploads/images/20180906/thumb/929affc2b82cb83b71bb30bd87259002.png', '', 'image/png', 'png', '1827', '287c0794f1db311d928914a70e732613', '5adaff5f9a50f075be6a5c39175fa7a15bd724f8', 'local', '0', '1536227993', '1536227993', '100', '1', '123', '122', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('35', '1', '下载 (1).jpg', 'carwash', 'uploads/images/20180911/51bd26b1386ae9c2a02ade53300ed735.jpg', 'uploads/images/20180911/thumb/51bd26b1386ae9c2a02ade53300ed735.jpg', '', 'image/jpeg', 'jpg', '18427', '08d14eb097df72c29e4f679f8bd11562', 'bf7a651baa7586a8432755028d041f6bb8917df3', 'local', '0', '1536657124', '1536657124', '100', '1', '334', '220', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('36', '1', 'demo.jpg', 'carwash', 'uploads/images/20180912/b8bf098c1fe16933888070e7f2861eea.jpg', 'uploads/images/20180912/thumb/b8bf098c1fe16933888070e7f2861eea.jpg', '', 'image/jpeg', 'jpg', '206115', 'f4cfba7ac85456c610a5f6fe39763b69', '4285980dd5177a793a202bf06b76679c0e5e909f', 'local', '0', '1536718655', '1536718655', '100', '1', '1023', '509', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('37', '1', '微信截图_20180906142522.png', 'carwash', 'uploads/images/20180913/e7112874c015e7267f435c3b05a933ae.png', 'uploads/images/20180913/thumb/e7112874c015e7267f435c3b05a933ae.png', '', 'image/png', 'png', '1207', '99341fb22c1dcbe83fc6cddb24860709', 'b261ffce784ce33e3c30a04967f9c2199cf1a302', 'local', '0', '1536834028', '1536834028', '100', '1', '99', '107', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('38', '1', '微信截图_20180906142604.png', 'carwash', 'uploads/images/20180913/1d4ae0c8d5c536b37c6dc6613900e88d.png', 'uploads/images/20180913/thumb/1d4ae0c8d5c536b37c6dc6613900e88d.png', '', 'image/png', 'png', '1714', '66ff9e433748115a5fafef364c92970f', '9085fb1b711fe2888223915e1eda26e602f7a9e7', 'local', '0', '1536834029', '1536834029', '100', '1', '106', '112', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('39', '1', '微信截图_20180906142611.png', 'carwash', 'uploads/images/20180913/a916f3df9fd12cacbf7c4c5a1b007f3f.png', 'uploads/images/20180913/thumb/a916f3df9fd12cacbf7c4c5a1b007f3f.png', '', 'image/png', 'png', '1726', '1d0468eb9e7d30f8e306fa078eed2f60', '23101647e0826a7df37eac809c5096b54cd2a6bf', 'local', '0', '1536834029', '1536834029', '100', '1', '102', '120', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('40', '1', '微信截图_20180906142541.png', 'carwash', 'uploads/images/20180913/3f190c877703194cd64842a1c080e46b.png', 'uploads/images/20180913/thumb/3f190c877703194cd64842a1c080e46b.png', '', 'image/png', 'png', '1309', 'f9754774b7c367f8da345a77676c44d1', '7588afe38da775f6b0e7ec235f298f7e80422ba2', 'local', '0', '1536834032', '1536834032', '100', '1', '111', '112', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('41', '0', '屏幕截图(1).png', 'lckjapp', 'uploads/images/20180918/bf2abda9e8f46ae030cd2d25ea21e088.png', '', '', 'image/png', 'png', '4389684', '52e0721b65010c10449df5532c53ee5e', '8814f46857e30695e0f3f7c476eb09a92aaa5bce', 'local', '0', '1537241055', '1537241055', '100', '1', '1920', '1080', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('42', '0', '1537241067303.jpeg', 'lckjapp', 'uploads/images/20180918/6ce6d0bd7febff18e10abacf7c4963de.jpeg', '', '', 'multipart/form-data', 'jpeg', '307665', '7db0ff54d3e56ead2586b9f45b2e021a', 'bc81bf12143420140b43a6533b620a02961fed34', 'local', '0', '1537241065', '1537241065', '100', '1', '600', '600', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('43', '0', 'u=2363597230,699645826&fm=27&gp=0.jpg', 'lckjapp', 'uploads/images/20180918/8cc0b4cec65d02d2d89f2697c9ae41ad.jpg', '', '', 'image/jpeg', 'jpg', '36231', '582a85f2823f81c191956fba3aa218d2', 'f6c83279be1edf25507c76d3a82780304ca22e1d', 'local', '0', '1537245717', '1537245717', '100', '1', '450', '375', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('44', '0', '1537247918713.png', 'lckjapp', 'uploads/images/20180918/d8047936d0d3d01f2ce0d0edc2abea0a.png', '', '', 'multipart/form-data', 'png', '2442527', '973e7a7785a0b481dcdc9449e2cdfca1', 'e48651ca102aa600150451da072c24809dac8f11', 'local', '0', '1537247921', '1537247921', '100', '1', '1512', '1512', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('45', '0', '微信截图_20180906142657.png', 'lckjapp', 'uploads/images/20180918/6edb4c52ad4abc6a2b765e9810273d33.png', '', '', 'image/png', 'png', '2497', 'bea977ddd1480881cba7fc3871cc88ea', '8cee718c717e28800bd2aeb69c97a6137782e35e', 'local', '0', '1537273339', '1537273339', '100', '1', '112', '121', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('46', '0', '1537359756075.png', 'lckjapp', 'uploads/images/20180919/a2c9f36848f7702d138e92439bf2785b.png', '', '', 'multipart/form-data', 'png', '118606', '14260523985086874b840dd2475d69af', 'd1dc1c73f0766aab83f63260901eff2cb2dffe51', 'local', '0', '1537359757', '1537359757', '100', '1', '1080', '1080', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('47', '0', '1537360305695.png', 'lckjapp', 'uploads/images/20180919/809ddf9508ed367cf68c9759a7870839.png', '', '', 'multipart/form-data', 'png', '2913772', 'af8f766976a5f0b4ce055969ecd0fe34', 'de82ef51f4c21abd83c4b10b1b35f1e0144261ee', 'local', '0', '1537360308', '1537360308', '100', '1', '1512', '1512', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('48', '0', '1537361170425.png', 'lckjapp', 'uploads/images/20180919/d32e29a0a88245ce5c3bc5a0af249373.png', '', '', 'multipart/form-data', 'png', '2361553', 'ccbe9e117b22acf822efd6491445357f', '3fe542e303bf6a90d21ba1cc22c8d5ffc3c84467', 'local', '0', '1537361173', '1537361173', '100', '1', '1512', '1512', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('49', '0', '1537429802716.jpg', 'lckjapp', 'uploads/images/20180920/15b4a603ec8497bc178923cef8259c8f.jpg', '', '', 'multipart/form-data', 'jpg', '597714', '8da234bf0ecbf22dd4bd1160b05d1494', '4b96b77a7af19cf415746a7aa6dc65bd2f07e664', 'local', '0', '1537429802', '1537429802', '100', '1', '720', '720', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('50', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/8099b552401d146a4f9f0c7eaf5b3afb.jpg', '', '', 'image/jpeg', 'jpg', '53406', 'b94ecf4ae3a61abac84e34e6a584022e', '028418ec7b5bc44d4e759a0131e1b6af7b21e03a', 'local', '0', '1537512452', '1537512452', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('51', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/1b6c4a17c944ab7e8fe8b6cd60dd0590.jpg', '', '', 'image/jpeg', 'jpg', '36544', '179198328c4d7f64e754cf13403e6332', 'efd526e5f57c671615d2b5e9d5fb5ab3b9d73266', 'local', '0', '1537512496', '1537512496', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('52', '0', '1537512541017.png', 'lckjapp', 'uploads/images/20180921/2a3ec6e11c65a5376e0653582c42f5ec.png', '', '', 'multipart/form-data', 'png', '3570746', '152ec3494d5f67f2a6bc8b380616afe3', 'a242f4bb481602c8074c182abb6852361a442998', 'local', '0', '1537512545', '1537512545', '100', '1', '1512', '1512', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('53', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/acc2b0632afa99ae0f2bf6060d1708bf.jpg', '', '', 'image/jpeg', 'jpg', '47262', 'f5e58d3fddbd87a9d18b7e65ca09850f', 'ea95a25c6eb6295848a668467a01167aa4ed500b', 'local', '0', '1537512718', '1537512718', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('54', '0', '1537512966520.png', 'lckjapp', 'uploads/images/20180921/4c6d13b773b16867f593aa3af7b9fef5.png', '', '', 'multipart/form-data', 'png', '1967058', 'd8639650af00d6c42cdf4afd9c63f88b', 'a0e2b019ad24989e8b4e653de86e7505e46731b8', 'local', '0', '1537512979', '1537512979', '100', '1', '1512', '1134', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('55', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/6140e564e6b42fed07eab329c689c686.jpg', '', '', 'image/jpeg', 'jpg', '75563', '9fe0dde20ff8fa66f5e5310aca94706c', 'bcc8f079ab494953e2bc79e540199179571e0ec2', 'local', '0', '1537514659', '1537514659', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('56', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/28ad8a15315c7fc905cdd26d3b001c24.jpg', '', '', 'image/jpeg', 'jpg', '42374', '5559b8ba2a5db335afe681a36b82a6e2', '729ed4af341b94a851c20cbcd2cbc0ddf3cfb477', 'local', '0', '1537516897', '1537516897', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('57', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/4aca16d24144fc5159817193f22c21ba.jpg', '', '', 'image/jpeg', 'jpg', '38036', '6fd63d58dcf66663751d2194a6240239', 'eb4b6fd6764bf76317a5f732afa9b2ba8a02a654', 'local', '0', '1537516962', '1537516962', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('58', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/2e91dbfc0eee30e100cdb079c15041ba.jpg', '', '', 'image/jpeg', 'jpg', '37687', 'cb49c65ff080dafe4341d5e80cfb6c9b', '6e848580602dacd0cefc96ee2367e9a64e68c95a', 'local', '0', '1537517179', '1537517179', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('59', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/f52d97825ae9236fdd9f340e129b8d94.jpg', '', '', 'image/jpeg', 'jpg', '62295', '52fd26e5652378f0e0325cfd980e1ff6', '117f78b7f2f3c434dc28857e6b2d3456c8a24173', 'local', '0', '1537517283', '1537517283', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('60', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180921/46e631dc4d5d88edb03510bfd60396e7.jpg', '', '', 'image/jpeg', 'jpg', '39808', '934959510918b79ea588c52557ef6edb', 'a31356d5d0918d00a609c0b5af3a2bc2f0f6a370', 'local', '0', '1537517602', '1537517602', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('61', '1', '微信截图_20180906142723.png', 'carwash', 'uploads/images/20180926/7971d1134fcd1436f78ba38a0508c4ad.png', 'uploads/images/20180926/thumb/7971d1134fcd1436f78ba38a0508c4ad.png', '', 'image/png', 'png', '1739', '9716f2a6b406b9ef82b6527fac8bc1e4', '0918a78e2861e34b9d21692f25ba90c63853ad93', 'local', '0', '1537933544', '1537933544', '100', '1', '126', '133', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('62', '1', '微信截图_20180906142703.png', 'carwash', 'uploads/images/20180926/db2f7ccf88c863cdd1ad980857165297.png', 'uploads/images/20180926/thumb/db2f7ccf88c863cdd1ad980857165297.png', '', 'image/png', 'png', '1935', 'edb538f2672eee6d2b09842e4df15027', 'c0326c9447f8f16cce44a19249d5088a343889af', 'local', '0', '1537934409', '1537934409', '100', '1', '108', '127', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('63', '1', '微信截图_20180906142709.png', 'carwash', 'uploads/images/20180926/52a4be6b62ee032841d252debad5d1e2.png', 'uploads/images/20180926/thumb/52a4be6b62ee032841d252debad5d1e2.png', '', 'image/png', 'png', '2027', 'a0d418f35899170d448f26226c1aecb3', '446ccdef7831f9bccc50bcbcacf607fbde8d8d01', 'local', '0', '1537934409', '1537934409', '100', '1', '125', '144', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('64', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/20e55186d5f67fdbc39b1cbd77a13792.jpg', '', '', 'image/jpeg', 'jpg', '60548', '435fb2e69253d616ff4a9f03f8e6a4d0', 'ddd0641b3b1fc7cedd7c247b55e0fc66c1ef89f9', 'local', '0', '1538138815', '1538138815', '100', '1', '748', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('65', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/15eb4682224faf0967bed47d07c5f90c.jpg', '', '', 'image/jpeg', 'jpg', '43430', 'c10b0c36b2fd13df034d8bf17d556c71', 'c1dbedb8df735125d557bb3c12b92bc07480fa2b', 'local', '0', '1538138912', '1538138912', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('66', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/d345bf0c39fb3831e4779844e8d01ca1.jpg', '', '', 'image/jpeg', 'jpg', '75642', '3691b421e9bc42fdc256673550b419a9', 'ebdabe7bafeb0ded2c47bd0e743b0ce9842c7ea7', 'local', '0', '1538139016', '1538139016', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('67', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/eda7889618e3070d4f1dfb38e7afe098.jpg', '', '', 'image/jpeg', 'jpg', '72183', '54087c45fe3b3ceccfcce688b22b68d6', 'e3b393f594d23c53bca39c9e083ecc0c425d965e', 'local', '0', '1538139082', '1538139082', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('68', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/150f8d738f3c2941293f8f5b5e6c0bf0.jpg', '', '', 'image/jpeg', 'jpg', '67781', '27036f20571409f85e58add6daf1d78a', '3ee1ca964027ec8a913c2c390d5161e54ddcdeab', 'local', '0', '1538139250', '1538139250', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('69', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/d18cfec6ca6b77cdec046a7012778a7f.jpg', '', '', 'image/jpeg', 'jpg', '72054', '606b951ed6650ea96545b27d231a92ac', '68d52070318d405c73cceaf60b1a07878c2777b1', 'local', '0', '1538139278', '1538139278', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('70', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/f93a91ed4b806a1d807e20580734242c.jpg', '', '', 'image/jpeg', 'jpg', '65094', 'd2e2507b74522d96f3b7ad454c1e38e4', '25f4c81fa0285525fa3282a3403973f986ee9d1d', 'local', '0', '1538139371', '1538139371', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('71', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/c207bed4907be70979c5e7eacd268328.jpg', '', '', 'image/jpeg', 'jpg', '62934', '9d61cf234e973c569085d75c1e1a3ec8', '9290fb193dca27d00e10bafab7851e3c033950bb', 'local', '0', '1538139386', '1538139386', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('72', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180928/c1e9807881afd25e3d9a4508d152f99b.jpg', '', '', 'image/jpeg', 'jpg', '66952', '455f97822183c3a8204e687c784b429a', '959a0aa63a8ae1c04261868c1bbde57e1835c5a2', 'local', '0', '1538139407', '1538139407', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('73', '0', '1538141123959.png', 'lckjapp', 'uploads/images/20180928/b0c3c0793f297dad4a33be584da6aaab.png', '', '', 'multipart/form-data', 'png', '2570241', 'c63f501a9b0e163aaa8c5dc1a6cd8edb', '1aed6ca8cdb066e0ef8ec2c84d832ece0f3cdd1d', 'local', '0', '1538141123', '1538141123', '100', '1', '1512', '1512', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('74', '0', 'hyd.png', 'lckjapp', 'uploads/images/20180929/ce42abc7b9077802072f20d48995d691.png', '', '', 'image/png', 'png', '190761', '96ccb15b126c8516495356df02cf8535', '02ef8497724de346a5a6c494424f2dec68d8bf96', 'local', '0', '1538192053', '1538192053', '100', '1', '1240', '1754', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('75', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/5026dc35c949678712b2b3e55af56702.jpg', '', '', 'image/jpeg', 'jpg', '44753', '98d80828de9ba7e1b342544b6bdfae35', '3954c4c7e143ee414b49c532dc4bf0c3edfd891c', 'local', '0', '1538193697', '1538193697', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('76', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/49669ff0e65dbb8512361d79ab9822a8.jpg', '', '', 'image/jpeg', 'jpg', '52542', '78fc506357a56ec19f528a90585c4f3d', '395323998585ce62a2d30b79d378605c74185e6e', 'local', '0', '1538193887', '1538193887', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('77', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/d4aeaff0a5bc4f683e154b4df4bbf888.jpg', '', '', 'image/jpeg', 'jpg', '79012', '061ab5a0597efbdf46863c358c117b9d', '7e2cb358387bfef2f3e48171b14200995d3b6989', 'local', '0', '1538194293', '1538194293', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('78', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/cbfcdf12a1dec96bc7be80a7dc645f24.jpg', '', '', 'image/jpeg', 'jpg', '82995', 'a9f6a394d787942f5bb30c1eba03ecc7', '6ee1b16959e5a11bb8a70b7ed4db7bb1d62f344e', 'local', '0', '1538203581', '1538203581', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('79', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/3f99554d64748f7cc432635587c0e963.jpg', '', '', 'image/jpeg', 'jpg', '74962', 'e8f1bc5f6d21ceb10eac138ea0137d46', '20f93b4ba568ba19e668996874025bb0f890e61a', 'local', '0', '1538203667', '1538203667', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('80', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/9b9cd385207ad5bc1c0eed9b8070433c.jpg', '', '', 'image/jpeg', 'jpg', '71825', '0c5fc8afbf84b8c3408deba7ef1cf533', '7f13d84ff772e8c1f7c5e62b8bc00cb87c40569d', 'local', '0', '1538203783', '1538203783', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('81', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/b3f2e09fcb9c5d976e401b506f214099.jpg', '', '', 'image/jpeg', 'jpg', '81437', 'd7b7817462f552af10eb4a709685f3f2', 'a697a269d6996d781c1b6add05f47c05445d0c2f', 'local', '0', '1538203913', '1538203913', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('82', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/f37080a2c88b25cfbd57e9295c57ad82.jpg', '', '', 'image/jpeg', 'jpg', '57499', 'cb9897815535217e499ad8afcffdda3c', 'de3a56f2aca4fac60f62eac7f3fa757633f29eca', 'local', '0', '1538204161', '1538204161', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('83', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/9a3886fbecbaa2b630c9291adbdefbc7.jpg', '', '', 'image/jpeg', 'jpg', '76177', '408368e50562a6e6c9f31c920e9c0a25', '74252dcf0b52fdc3def89ebe7907a434559bf120', 'local', '0', '1538204328', '1538204328', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('84', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/4222daca8ab062861406130755ace1c8.jpg', '', '', 'image/jpeg', 'jpg', '64525', '6b8c922991addf5d6b99ffb5d6c53188', 'e2f22a521da4da01d4b45c6a41f77d2e9466b7ba', 'local', '0', '1538204334', '1538204334', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('85', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/bb1b2d181e38c3b4b4126a7ff67aaa20.jpg', '', '', 'image/jpeg', 'jpg', '65732', 'ebc92bc3eea4a84ca14ff5ce7e750887', '877e87e8f77405e9640d802ac9c24776bcee3e11', 'local', '0', '1538204339', '1538204339', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('86', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/37351d8d1f30c9f980d99f09a24d8bcf.jpg', '', '', 'image/jpeg', 'jpg', '95167', '8069bcceb78fb29db059996561c603e4', 'd0c820ed522e7658277a9da4e7779f29291c5afb', 'local', '0', '1538204378', '1538204378', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('87', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180929/abed1566124b7cf3d6a0a762cb89252f.jpg', '', '', 'image/jpeg', 'jpg', '66952', '0de2f2453794d4d8a5ddbf95ef26721b', '715c53acb98608d755ccb0844047498ebb83de69', 'local', '0', '1538204385', '1538204385', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('88', '0', '1538277173999.png', 'lckjapp', 'uploads/images/20180930/9d0fd18ab2e01454c9154313999f36c9.png', '', '', 'multipart/form-data', 'png', '102743', 'fc61c2b59cacf95714c6eca13e269a11', '12d2efc5cedf4bca520d5ad045f61f2ada308037', 'local', '0', '1538277173', '1538277173', '100', '1', '942', '942', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('89', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180930/9597ff1b84ef079d637f8316a3f1b8cd.jpg', '', '', 'image/jpeg', 'jpg', '62817', '9b9c5f4564d1bc2f515a3f01e8af32a7', '8b79f5e7d2205bbdbcb1a97ff869ffa98f197dfd', 'local', '0', '1538299174', '1538299174', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('90', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180930/bad409b337f1451a0fb10d46240be740.jpg', '', '', 'image/jpeg', 'jpg', '41385', '1e73c243bbc658c355a0cbb3748ae3a2', '05c9e4e765b9fe82208902e4d42ba06352073802', 'local', '0', '1538299205', '1538299205', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('91', '0', '11111.jpg', 'lckjapp', 'uploads/images/20180930/ba096eaa00bf3aa854464536391b0f65.jpg', '', '', 'image/jpeg', 'jpg', '51822', 'e976551f4a8aaabbbb15fdd15eee2484', 'bd6ca52aac435d76fe9806cf9858b9fa766afb16', 'local', '0', '1538299339', '1538299339', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('92', '0', '11111.jpg', 'lckjapp', 'uploads/images/20181008/71e4caaa4eb5e1f8949fc64be13bd76d.jpg', '', '', 'image/jpeg', 'jpg', '64547', '86ec165d551458f7f2511320f7c98dde', 'cd9b3ca6ac668003f11872eaa1558e2f2145ac38', 'local', '0', '1538990032', '1538990032', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('93', '1', '3f547f4deb34e07b6fdc29d151f13f13.jpg', '', 'upload/temp/3f547f4deb34e07b6fdc29d151f13f13.jpg', '', '', 'image/jpeg', 'jpeg', '287086', '3a020bd0a40e7b7bc57409100ed3d7ac', 'b38fd0acda4bd3748a291ea858bd523bd1fd5ac0', 'local', '0', '1538992453', '1538992453', '100', '1', '1024', '703', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('94', '1', '2f965f36506795e96e0b6e995a3f7cca.jpg', '', 'upload/temp/2f965f36506795e96e0b6e995a3f7cca.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1538993179', '1538993179', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('95', '1', '151f4979a87583e1cc6a9eaf5f77ec3a.jpg', '', 'upload/temp/151f4979a87583e1cc6a9eaf5f77ec3a.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1538993220', '1538993220', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('96', '1', 'e212234c6bf777c197717943d27686e6.jpg', '', 'upload/temp/e212234c6bf777c197717943d27686e6.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539050869', '1539050869', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('97', '1', '8f79f4ff10d54ade60a1371a4159971a.jpg', '', 'upload/temp/8f79f4ff10d54ade60a1371a4159971a.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539050883', '1539050883', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('98', '1', 'ea091cee1f031787bc067245d62488a7.jpg', '', 'upload/temp/ea091cee1f031787bc067245d62488a7.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539051208', '1539051208', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('99', '1', '40f54b4c7b4eaf8cd9ba845c924505a2.jpg', '', 'upload/temp/40f54b4c7b4eaf8cd9ba845c924505a2.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539051211', '1539051211', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('100', '1', '10ed8e9e5bcd4945d6bcbaecaad3bdd9.jpg', '', 'upload/temp/10ed8e9e5bcd4945d6bcbaecaad3bdd9.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539051222', '1539051222', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('101', '1', 'e990dba1247bc9b56205eb3c147cf521.jpg', '', 'upload/temp/e990dba1247bc9b56205eb3c147cf521.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539051254', '1539051254', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('102', '1', 'b7b040d3c94cc18374d45a9c50d1907a.jpg', '', 'upload/temp/b7b040d3c94cc18374d45a9c50d1907a.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539051256', '1539051256', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('103', '1', '008e820b7b11b09f4f6684002c20662a.jpg', '', 'upload/temp/008e820b7b11b09f4f6684002c20662a.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539051305', '1539051305', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('104', '1', '8b516c00a5936e03b7f081c05e8b0c3e.jpg', '', 'upload/temp/8b516c00a5936e03b7f081c05e8b0c3e.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539051308', '1539051308', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('105', '1', '4df21add94c3fcff3f8bdf6c263078df.jpg', '', 'upload/temp/4df21add94c3fcff3f8bdf6c263078df.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539051553', '1539051553', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('106', '1', 'fe0896024a4329258036e3800980df25.jpg', '', 'upload/temp/fe0896024a4329258036e3800980df25.jpg', '', '', 'image/jpeg', 'jpeg', '48908', '4e16efb3f7f1cc58ecfd5261fe1f938f', 'ed35e6c63bda568030ff68cd1ff8895f9f208002', 'local', '0', '1539053420', '1539053420', '100', '1', '1024', '768', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('107', '1', '7c2440d7168e3d25555a57cee0b3b863a5b4cf46130bfc-ViM0sD_fw658.png', 'carwash', 'uploads/images/20181009/cccbb9235a81a420a30ea3990c403387.png', 'uploads/images/20181009/thumb/cccbb9235a81a420a30ea3990c403387.png', '', 'image/png', 'png', '286195', '0772f2d10b2b150012a572f3123d57b5', '8aa13edb4b52ca538d2fb2e6b250e10e1cdc454e', 'local', '0', '1539053628', '1539053628', '100', '1', '658', '467', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('108', '1', '477ca8cade628154455e73bbc98fa12a.jpg', '', 'upload/temp/477ca8cade628154455e73bbc98fa12a.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539053864', '1539053864', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('109', '1', '7695f8cf7f1fd10e01c7f7325aaefa9a.jpg', '', 'upload/temp/7695f8cf7f1fd10e01c7f7325aaefa9a.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539053888', '1539053888', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('110', '1', 'ef93f85c988159114d4b6ee13e36537a.jpg', '', 'upload/temp/ef93f85c988159114d4b6ee13e36537a.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539053890', '1539053890', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('111', '1', 'e0f3979a3b6167ee48a734708d132c1f.jpg', '', 'upload/temp/e0f3979a3b6167ee48a734708d132c1f.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539054200', '1539054200', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('112', '1', '996bd450436d9d86c1905b31cdb79c6b.jpg', '', 'upload/temp/996bd450436d9d86c1905b31cdb79c6b.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539054336', '1539054336', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('113', '0', '11111.jpg', 'lckjapp', 'uploads/images/20181009/f3cd5b219373740b8236bb32e85923ac.jpg', '', '', 'image/jpeg', 'jpg', '59710', '8f84f1a4a92904dc84550b77d053c85d', '74a66070f893da5ba795c220263d13658beceee3', 'local', '0', '1539074233', '1539074233', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('114', '0', '11111.jpg', 'lckjapp', 'uploads/images/20181009/76c3529913a9b9501f40a6118df5bd0b.jpg', '', '', 'image/jpeg', 'jpg', '86052', '6ffde1f5827032b60d02d0590ce86026', '4e11e162d8e89a376f2843d49747b4add656ef1f', 'local', '0', '1539075133', '1539075133', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('115', '0', '11111.jpg', 'lckjapp', 'uploads/images/20181009/98a9ad28f054b1f945bcb19cdf2d9a5c.jpg', '', '', 'image/jpeg', 'jpg', '62959', '7b2436a270b77301b82df9c82304926b', '8c0e6652aad1b3887f3c6da6e2186119f80ccefb', 'local', '0', '1539075195', '1539075195', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('116', '1', '29d8eedfd38fae961dcc63c4ec1e8107.jpg', '', 'upload/temp/29d8eedfd38fae961dcc63c4ec1e8107.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539166017', '1539166017', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('117', '1', 'fa1d225d4e1ce033ffd18eed90dc1815.jpg', '', 'upload/temp/fa1d225d4e1ce033ffd18eed90dc1815.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539167794', '1539167794', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('118', '1', '0a5fa3e8a89476b9a6f6e5845a765af7.jpg', '', 'upload/temp/0a5fa3e8a89476b9a6f6e5845a765af7.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539167854', '1539167854', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('119', '1', '2eeb578b562c2db2a0ff277b61fdf9dd.jpg', '', 'upload/temp/2eeb578b562c2db2a0ff277b61fdf9dd.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539229424', '1539229424', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('120', '1', 'eb5ae04b9afc1795faf226fa7ffbc1c7.jpg', '', 'upload/temp/eb5ae04b9afc1795faf226fa7ffbc1c7.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539229451', '1539229451', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('121', '0', '1539229728429.png', 'lckjapp', 'uploads/images/20181011/5b4ff8aaf81750f88dcc68c2ba6f5148.png', '', '', 'multipart/form-data', 'png', '835', 'b49c4caca7da267a21be90f429dffa4e', '984c9aceffe3dcef5db898171d99bf509c920e22', 'local', '0', '1539229725', '1539229725', '100', '1', '24', '24', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('122', '1', '34b35a932061b539bc078f2ef1ac4c12.jpg', '', 'upload/temp/34b35a932061b539bc078f2ef1ac4c12.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539230151', '1539230151', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('123', '1', 'timg (2).jpg', 'carwash', 'uploads/images/20181011/d807ad084db5a23b80589160812f0f2d.jpg', 'uploads/images/20181011/thumb/d807ad084db5a23b80589160812f0f2d.jpg', '', 'image/jpeg', 'jpg', '61527', 'c3ce4aeb0c4d09a7d37fd27bb71628a0', '86a95d047d7b96d71985e2247e0d6d14b75ed6e1', 'local', '0', '1539233571', '1539233571', '100', '1', '1024', '676', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('124', '1', '1926cacc41fddd0a2f896a7bc72f4aaf.jpg', '', 'upload/temp/1926cacc41fddd0a2f896a7bc72f4aaf.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539244807', '1539244807', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('125', '1', '8c1f1e0b76213af167a9bc3f3ae17e83.jpg', '', 'upload/temp/8c1f1e0b76213af167a9bc3f3ae17e83.jpg', '', '', 'image/jpeg', 'jpeg', '79176', 'd7f022532f357f8f43cef5283ca47fbc', '9e469fe40c03eb1bf9b5cc59a4cad5bffd318869', 'local', '0', '1539244874', '1539244874', '100', '1', '1024', '699', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('126', '1', 'acafd86c65647004a6466691f710d289.jpg', '', 'upload/temp/acafd86c65647004a6466691f710d289.jpg', '', '', 'image/jpeg', 'jpeg', '164707', '71d3c7662ecf61513ce22d345415f274', '4c2819b9252d2f9fff265ef5caf3a0efbf871f94', 'local', '0', '1539244892', '1539244892', '100', '1', '1024', '705', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('127', '1', 'timg (1).jpg', 'carwash', 'uploads/images/20181011/ddc79dd0293b15eb0523fda2c9895f47.jpg', 'uploads/images/20181011/thumb/ddc79dd0293b15eb0523fda2c9895f47.jpg', '', 'image/jpeg', 'jpg', '87855', '6f1c54b9b6e52d74c895d2c214101522', '75aa885bedbf9bec3f99272c9ae4228f75026414', 'local', '0', '1539244917', '1539244917', '100', '1', '1024', '768', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('128', '1', '3119a1934fecc1629e217c07ff5de324.jpg', '', 'upload/temp/3119a1934fecc1629e217c07ff5de324.jpg', '', '', 'image/jpeg', 'jpeg', '89296', '36799c1fb2dcbde56ed61efb2ef6f217', '484f9a73e9eddc6dd2869953ffa1e1b0e591eb4a', 'local', '0', '1539246867', '1539246867', '100', '1', '1280', '720', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('129', '1', 'a6ec7b1cc7d765ae55e1f10cf3ca8b0b.jpg', '', 'upload/temp/a6ec7b1cc7d765ae55e1f10cf3ca8b0b.jpg', '', '', 'image/jpeg', 'jpeg', '108957', 'f996695d3e2b5bd3f509b5f1de1066ee', 'a718be187cb4897337afd1acbe76c7bcd475b1a6', 'local', '0', '1539325952', '1539325952', '100', '1', '658', '931', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('130', '1', '6a3cc6731d4ef76b8946680bfb2a02d8.jpg', '', 'upload/temp/6a3cc6731d4ef76b8946680bfb2a02d8.jpg', '', '', 'image/jpeg', 'jpeg', '24037', 'db28f7560547ad3ab1721fc8783d5b4e', '7e28d0ea0a710d357362f7d5acb33fda2c8b358c', 'local', '0', '1539326066', '1539326066', '100', '1', '500', '310', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('131', '1', '31158ea1aeb77f5cee7c280af95ae826.jpg', '', 'upload/temp/31158ea1aeb77f5cee7c280af95ae826.jpg', '', '', 'image/jpeg', 'jpeg', '9437', 'bd3d5cedf493ef6595b265683fc62492', 'a16ca02c20cce430f70a290be72219ea31c7929d', 'local', '0', '1539327401', '1539327401', '100', '1', '500', '313', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('132', '1', '8fbdd357c2d40a44e015324d4fd63601.jpg', '', 'upload/temp/8fbdd357c2d40a44e015324d4fd63601.jpg', '', '', 'image/jpeg', 'jpeg', '34113', '9b77ecf121077416851e4fbb6edef344', '8990e74f3e59513bd0e7cc1a76123f9f956ccc6f', 'local', '0', '1539327503', '1539327503', '100', '1', '500', '333', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('133', '1', '2bec165edf929a28ea029b9aacd907a9.jpg', '', 'upload/temp/2bec165edf929a28ea029b9aacd907a9.jpg', '', '', 'image/jpeg', 'jpeg', '24037', 'db28f7560547ad3ab1721fc8783d5b4e', '7e28d0ea0a710d357362f7d5acb33fda2c8b358c', 'local', '0', '1539327973', '1539327973', '100', '1', '500', '310', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('134', '1', '9a2e3f69994933275e2a063ee8364bb1.jpg', '', 'upload/temp/9a2e3f69994933275e2a063ee8364bb1.jpg', '', '', 'image/jpeg', 'jpeg', '86438', '5ac688084885087030152f7d7358cefa', '22634c5713d39f765beff7bbed9db19fb13694b4', 'local', '0', '1539328371', '1539328371', '100', '1', '600', '832', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('135', '1', 'db427c806d812c3da3d771b338085153.png', '', 'upload/temp/db427c806d812c3da3d771b338085153.png', '', '', 'image/png', 'png', '286195', '0772f2d10b2b150012a572f3123d57b5', '8aa13edb4b52ca538d2fb2e6b250e10e1cdc454e', 'local', '0', '1539328525', '1539328525', '100', '1', '658', '467', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('136', '1', '0273f1396bb1c0de74458ef9148319d5.png', '', 'upload/temp/0273f1396bb1c0de74458ef9148319d5.png', '', '', 'image/png', 'png', '58768', '0cd8ef16cfa5d7fe62a5596daf3cda95', 'c6816acbb081cf4da4e0df12b772854e9c158e9c', 'local', '0', '1539334452', '1539334452', '100', '1', '1262', '796', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('137', '1', '11cd968c59f44ad3f845d948a98b870d.jpg', '', 'upload/temp/11cd968c59f44ad3f845d948a98b870d.jpg', '', '', 'image/jpeg', 'jpeg', '24037', 'db28f7560547ad3ab1721fc8783d5b4e', '7e28d0ea0a710d357362f7d5acb33fda2c8b358c', 'local', '0', '1539335916', '1539335916', '100', '1', '500', '310', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('138', '1', '1e7d00551d542ab947234c3831f00950.png', '', 'upload/temp/1e7d00551d542ab947234c3831f00950.png', '', '', 'image/png', 'png', '286195', '0772f2d10b2b150012a572f3123d57b5', '8aa13edb4b52ca538d2fb2e6b250e10e1cdc454e', 'local', '0', '1539336732', '1539336732', '100', '1', '658', '467', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('139', '1', 'd81fbee874421ce9665f97cff14b610c.jpg', '', 'upload/temp/d81fbee874421ce9665f97cff14b610c.jpg', '', '', 'image/jpeg', 'jpeg', '73567', '3c838b462f09bdc3ce4c665cfee4a869', 'e0cd9f8208951549d45b1ed85a5ae3b3b61ff585', 'local', '0', '1539337311', '1539337311', '100', '1', '559', '639', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('140', '1', 'img_ccbc_bank.png', 'carwash', 'uploads/images/20181015/fc68a495b67ebc88fd500ddc0f4f6bf4.png', 'uploads/images/20181015/thumb/fc68a495b67ebc88fd500ddc0f4f6bf4.png', '', 'image/png', 'png', '40331', '541896b3d78d32a8ef961d6ba1c05d8c', 'f0011231382f335b4aab97a184a0327a89807df6', 'local', '0', '1539584521', '1539584521', '100', '1', '1332', '401', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('141', '1', '默认银行.png', 'carwash', 'uploads/images/20181015/107e2fa222b13811174695ff88f59c51.png', 'uploads/images/20181015/thumb/107e2fa222b13811174695ff88f59c51.png', '', 'image/png', 'png', '23566', '2e72b9c4eb020b79ade964302b633f8c', 'bb64ed0d8cbc8bc291be60e897fbc4a21e3c305d', 'local', '0', '1539586526', '1539586526', '100', '1', '693', '208', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('142', '1', '建设银行.png', 'carwash', 'uploads/images/20181015/11f452b533d41e3af7751aa78116d3ca.png', 'uploads/images/20181015/thumb/11f452b533d41e3af7751aa78116d3ca.png', '', 'image/png', 'png', '30765', 'b4fe6ea2626a09641a745e5b5ffbd220', '1afc97c82b27688f00e6209d6b707d463de5321f', 'local', '0', '1539586537', '1539586537', '100', '1', '693', '208', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('143', '1', '农业银行.png', 'carwash', 'uploads/images/20181015/fae2b651430ef82921deb4b3fc1e3fa7.png', 'uploads/images/20181015/thumb/fae2b651430ef82921deb4b3fc1e3fa7.png', '', 'image/png', 'png', '35729', '3c8f4a02fdeca2c043fb9c10d4ff4469', '07a38622f0580d7da2e13e098338d92d9b39829d', 'local', '0', '1539586546', '1539586546', '100', '1', '693', '208', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('144', '1', '中国银行.png', 'carwash', 'uploads/images/20181015/c83016915a053743c2de44cf99303885.png', 'uploads/images/20181015/thumb/c83016915a053743c2de44cf99303885.png', '', 'image/png', 'png', '31438', 'fb2be196161629a9e7e44e6d517e70e5', '25c6df60ebb1c847c4cdc5d89985d10205c0478d', 'local', '0', '1539586558', '1539586558', '100', '1', '693', '208', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('145', '1', '重庆银行.png', 'carwash', 'uploads/images/20181015/ddd094d13017f7e582d45cd68a8334c1.png', 'uploads/images/20181015/thumb/ddd094d13017f7e582d45cd68a8334c1.png', '', 'image/png', 'png', '35205', '0c6a5d89e43a6e99a8d9f803221cdda0', 'f0c1cf41c183e076e4ec723679bb58889ed63aee', 'local', '0', '1539586582', '1539586582', '100', '1', '693', '208', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('146', '1', '建设银行 (2).png', 'carwash', 'uploads/images/20181015/65584e0a1428a396f071179f56191622.png', 'uploads/images/20181015/thumb/65584e0a1428a396f071179f56191622.png', '', 'image/png', 'png', '4640', 'd288e39a0e7ea38a801e386d53f2e768', '83df6b1ef122130e659d34c2b207d3ca09e66465', 'local', '0', '1539588052', '1539588052', '100', '1', '100', '99', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('147', '1', '农业银行 (2).png', 'carwash', 'uploads/images/20181015/75b0ac4471e58dc7edc04bf1d7b1fc2b.png', 'uploads/images/20181015/thumb/75b0ac4471e58dc7edc04bf1d7b1fc2b.png', '', 'image/png', 'png', '5228', '44e924efe16fef45bb7dd873cc9cc8eb', 'e907f5bb59fe9e8529d30a526fdc49d7a1e783cf', 'local', '0', '1539588063', '1539588063', '100', '1', '100', '99', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('148', '1', '中国银行 (2).png', 'carwash', 'uploads/images/20181015/830ed1ff2b0f2879a43425a33f021427.png', 'uploads/images/20181015/thumb/830ed1ff2b0f2879a43425a33f021427.png', '', 'image/png', 'png', '5223', 'd7746c9c86937abcefc651adefd48864', '69ee24a7b64865dda8fe933597c467f511b015d2', 'local', '0', '1539588075', '1539588075', '100', '1', '100', '99', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('149', '1', '工商银行.png', 'carwash', 'uploads/images/20181015/3343960442aef90cf72644f75f03cdbd.png', 'uploads/images/20181015/thumb/3343960442aef90cf72644f75f03cdbd.png', '', 'image/png', 'png', '5043', '9950a3f5f4299d1587504f3baa906ea7', 'a8240d5fe3b24dcb545d40ae280cdc5b4c5f8ea3', 'local', '0', '1539588108', '1539588108', '100', '1', '100', '99', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('150', '1', '建设.png', 'carwash', 'uploads/images/20181015/f575d0f4f54d441493d342df1c9186ee.png', 'uploads/images/20181015/thumb/f575d0f4f54d441493d342df1c9186ee.png', '', 'image/png', 'png', '79656', 'a4ac33eeef9186f13beb549d7acfa99d', 'c90d8fa67e61d7084631f9ce76dad72884d54865', 'local', '0', '1539590622', '1539590622', '100', '1', '1332', '400', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('151', '1', '农业.png', 'carwash', 'uploads/images/20181015/17bac628c1f37c5a5cc1bb238580ba5b.png', 'uploads/images/20181015/thumb/17bac628c1f37c5a5cc1bb238580ba5b.png', '', 'image/png', 'png', '87925', 'd3c0632835be50484dc72ce089457085', 'ac78ee52ff338ab5822b6ed209585b2b929e7d52', 'local', '0', '1539590636', '1539590636', '100', '1', '1332', '400', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('152', '1', '中国.png', 'carwash', 'uploads/images/20181015/e1375b6f734c879c293cd1e3873e3ee6.png', 'uploads/images/20181015/thumb/e1375b6f734c879c293cd1e3873e3ee6.png', '', 'image/png', 'png', '80137', 'dbda96380231e23b488211789a1c22b5', '0a535fb28d74059fd26d17de6dc65769078a14f6', 'local', '0', '1539590645', '1539590645', '100', '1', '1332', '400', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('153', '0', '11111.jpg', 'lckjapp', 'uploads/images/20181015/09020ae9ba4c93e4ef30785ccd444b39.jpg', '', '', 'image/jpeg', 'jpg', '60086', '6de4f716eef93734461ef5a4fda3a941', 'd1111eb59244ca0d3f7c561f93d7e5d56c4f17fb', 'local', '0', '1539594606', '1539594606', '100', '1', '750', '750', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('154', '1', 'bbbec030565f10067d73bf34b40e1b41.png', '', 'upload/temp/bbbec030565f10067d73bf34b40e1b41.png', '', '', 'image/png', 'png', '5519', 'ed8b7157d2188bcd906279e34b514835', '27c7abf0d21275bb920b17905a87aabeba2e9a16', 'local', '0', '1539595468', '1539595468', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('155', '0', '100_thumb_200_200_bbbec030565f10067d73bf34b40e1b41.png', '', 'upload/cut/100/100_thumb_200_200_bbbec030565f10067d73bf34b40e1b41.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595475', '0', '100', '1', '200', '200', '154', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('156', '1', '711cf101e01b8afd52c2fc4598d294bf.png', '', 'upload/temp/711cf101e01b8afd52c2fc4598d294bf.png', '', '', 'image/png', 'png', '9475', '6f1b193e88977de602f18df97ddc3266', '0d2295a786ca4cc4b44199c9f12bcc116fd7987f', 'local', '0', '1539595585', '1539595585', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('157', '0', '100_thumb_200_200_711cf101e01b8afd52c2fc4598d294bf.png', '', 'upload/cut/100/100_thumb_200_200_711cf101e01b8afd52c2fc4598d294bf.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595586', '0', '100', '1', '200', '200', '156', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('158', '1', '27fb45e7bc5ba8ea624aa690ef166b39.png', '', 'upload/temp/27fb45e7bc5ba8ea624aa690ef166b39.png', '', '', 'image/png', 'png', '11123', '365dff933d28b675105ebd1c52000de4', 'dda34560f86c4bb8d50dfc508550d4181e6c8186', 'local', '0', '1539595602', '1539595602', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('159', '0', '100_thumb_200_200_27fb45e7bc5ba8ea624aa690ef166b39.png', '', 'upload/cut/100/100_thumb_200_200_27fb45e7bc5ba8ea624aa690ef166b39.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595602', '0', '100', '1', '200', '200', '158', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('160', '1', '980667ee9646d12d293ec97553a33c6f.png', '', 'upload/temp/980667ee9646d12d293ec97553a33c6f.png', '', '', 'image/png', 'png', '7948', '494d8141fb5c1225abba41ffcec0b86e', 'dcc426cb98962c50a7877130bcbdba7ed4768d73', 'local', '0', '1539595618', '1539595618', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('161', '0', '100_thumb_200_200_980667ee9646d12d293ec97553a33c6f.png', '', 'upload/cut/100/100_thumb_200_200_980667ee9646d12d293ec97553a33c6f.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595619', '0', '100', '1', '200', '200', '160', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('162', '1', '81652a66f75db8a249a160eae43d4839.png', '', 'upload/temp/81652a66f75db8a249a160eae43d4839.png', '', '', 'image/png', 'png', '13876', '16decedc7ee54ae3a60eeaaac5787ef2', 'fa4eb11801a8f00a57016201a96f7ded9b0f78b5', 'local', '0', '1539595640', '1539595640', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('163', '0', '100_thumb_200_200_81652a66f75db8a249a160eae43d4839.png', '', 'upload/cut/100/100_thumb_200_200_81652a66f75db8a249a160eae43d4839.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595641', '0', '100', '1', '200', '200', '162', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('164', '1', 'f2b8949ca26681f74359c1cc40ffc73d.png', '', 'upload/temp/f2b8949ca26681f74359c1cc40ffc73d.png', '', '', 'image/png', 'png', '4232', '18388bcd72c56c6aaf75966c63634284', '5a2f4ef1a3b06d2ffbac79492b478dbc74c6e146', 'local', '0', '1539595654', '1539595654', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('165', '0', '100_thumb_200_200_f2b8949ca26681f74359c1cc40ffc73d.png', '', 'upload/cut/100/100_thumb_200_200_f2b8949ca26681f74359c1cc40ffc73d.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595654', '0', '100', '1', '200', '200', '164', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('166', '1', '7aa72fb8e0dd0732d02e2c968175a81f.png', '', 'upload/temp/7aa72fb8e0dd0732d02e2c968175a81f.png', '', '', 'image/png', 'png', '11292', '94b2d51f1d312d329d94060dc2a25ba2', '78fb6fdff811249c059242af408aead06f36bcc6', 'local', '0', '1539595668', '1539595668', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('167', '0', '100_thumb_200_200_7aa72fb8e0dd0732d02e2c968175a81f.png', '', 'upload/cut/100/100_thumb_200_200_7aa72fb8e0dd0732d02e2c968175a81f.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595669', '0', '100', '1', '200', '200', '166', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('168', '1', '8998eed8b48b91f72eb2acf77e25f035.png', '', 'upload/temp/8998eed8b48b91f72eb2acf77e25f035.png', '', '', 'image/png', 'png', '11037', 'aadf530eaa923ca627f36f2b2f691bba', '2b966dfc0188bb24a2980bc74cf8d4e66bc2f499', 'local', '0', '1539595683', '1539595683', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('169', '0', '100_thumb_200_200_8998eed8b48b91f72eb2acf77e25f035.png', '', 'upload/cut/100/100_thumb_200_200_8998eed8b48b91f72eb2acf77e25f035.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595684', '0', '100', '1', '200', '200', '168', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('170', '1', 'd5d2e3de2bb1687e868cc731512cceef.png', '', 'upload/temp/d5d2e3de2bb1687e868cc731512cceef.png', '', '', 'image/png', 'png', '16174', '40f17180391463aec6841cbc83fe4297', '9a5cf7988668b76fb7e997938b1ba7f5967b0369', 'local', '0', '1539595701', '1539595701', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('171', '0', '100_thumb_200_200_d5d2e3de2bb1687e868cc731512cceef.png', '', 'upload/cut/100/100_thumb_200_200_d5d2e3de2bb1687e868cc731512cceef.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595701', '0', '100', '1', '200', '200', '170', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('172', '1', 'af4f80f7fb73f573f57f110bdea38097.png', '', 'upload/temp/af4f80f7fb73f573f57f110bdea38097.png', '', '', 'image/png', 'png', '5767', '0e733fa4597de17928f9090261a1fe67', 'b22b5c88450fb9b3d4b4175e71798b4d42ae075c', 'local', '0', '1539595716', '1539595716', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('173', '0', '100_thumb_200_200_af4f80f7fb73f573f57f110bdea38097.png', '', 'upload/cut/100/100_thumb_200_200_af4f80f7fb73f573f57f110bdea38097.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595717', '0', '100', '1', '200', '200', '172', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('174', '1', 'fe4d1e3a4cd76278af30e7ae6c7d4c48.png', '', 'upload/temp/fe4d1e3a4cd76278af30e7ae6c7d4c48.png', '', '', 'image/png', 'png', '5661', '8c3e5d481af4272175b7c5d7f80d3107', '9f2df38ef1e5bd7c6e432596b2e088ac3e4e1b75', 'local', '0', '1539595732', '1539595732', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('175', '0', '100_thumb_200_200_fe4d1e3a4cd76278af30e7ae6c7d4c48.png', '', 'upload/cut/100/100_thumb_200_200_fe4d1e3a4cd76278af30e7ae6c7d4c48.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595732', '0', '100', '1', '200', '200', '174', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('176', '1', '0a20e4d679bf2b26970e08953019c067.png', '', 'upload/temp/0a20e4d679bf2b26970e08953019c067.png', '', '', 'image/png', 'png', '9124', '8d960c42a411507efca67ed9af208740', '8c5a93094fda297fd08851781ea8d0ae8fb39563', 'local', '0', '1539595748', '1539595748', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('177', '0', '100_thumb_200_200_0a20e4d679bf2b26970e08953019c067.png', '', 'upload/cut/100/100_thumb_200_200_0a20e4d679bf2b26970e08953019c067.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595749', '0', '100', '1', '200', '200', '176', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('178', '1', '3a6bac90e5f0c604769f6fa47448297e.png', '', 'upload/temp/3a6bac90e5f0c604769f6fa47448297e.png', '', '', 'image/png', 'png', '7908', '67ee128e640501b95d0e53e5d08d65ac', 'cd6399dd9455a5f9fa3e594915fefdeb045cebc5', 'local', '0', '1539595766', '1539595766', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('179', '0', '100_thumb_200_200_3a6bac90e5f0c604769f6fa47448297e.png', '', 'upload/cut/100/100_thumb_200_200_3a6bac90e5f0c604769f6fa47448297e.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595767', '0', '100', '1', '200', '200', '178', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('180', '1', 'aa42f6f404f644895e1e0594d2042ff5.png', '', 'upload/temp/aa42f6f404f644895e1e0594d2042ff5.png', '', '', 'image/png', 'png', '10730', '143857e0093eba9e22a0e5da3c27fd87', '923482df771b145461d82e7156298874194156a5', 'local', '0', '1539595780', '1539595780', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('181', '0', '100_thumb_200_200_aa42f6f404f644895e1e0594d2042ff5.png', '', 'upload/cut/100/100_thumb_200_200_aa42f6f404f644895e1e0594d2042ff5.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595781', '0', '100', '1', '200', '200', '180', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('182', '1', 'b2459bacb0c2a93116143c29082193e5.png', '', 'upload/temp/b2459bacb0c2a93116143c29082193e5.png', '', '', 'image/png', 'png', '12153', 'de8f9191cbd5075d14ae319db317bf4f', 'abcbd6f23da20f50fc69ed77ef453a8e8bae6428', 'local', '0', '1539595795', '1539595795', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('183', '0', '100_thumb_200_200_b2459bacb0c2a93116143c29082193e5.png', '', 'upload/cut/100/100_thumb_200_200_b2459bacb0c2a93116143c29082193e5.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539595796', '0', '100', '1', '200', '200', '182', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('184', '1', '76cb743a34cced33490543bb2fd09d0b.png', '', 'upload/temp/76cb743a34cced33490543bb2fd09d0b.png', '', '', 'image/png', 'png', '7645', 'b7367b18b78d9749a6fed08fe5b50b37', 'a3bf3d31ee945a7a8c550226c7af915c3d4fd96e', 'local', '0', '1539596770', '1539596770', '100', '1', '200', '200', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('185', '0', '100_thumb_200_200_76cb743a34cced33490543bb2fd09d0b.png', '', 'upload/cut/100/100_thumb_200_200_76cb743a34cced33490543bb2fd09d0b.png', '', '', 'image/png', 'png', '0', '', '', 'local', '0', '1539596772', '0', '100', '1', '200', '200', '184', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('186', '1', '9b361c8602e848994428a0b991be62bc.jpg', '', 'upload/temp/9b361c8602e848994428a0b991be62bc.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539596822', '1539596822', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('187', '0', '100_thumb_200_200_9b361c8602e848994428a0b991be62bc.jpg', '', 'upload/cut/100/100_thumb_200_200_9b361c8602e848994428a0b991be62bc.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539596823', '0', '100', '1', '200', '200', '186', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('188', '0', '100_thumb_690_300_fe0896024a4329258036e3800980df25.jpg', '', 'upload/cut/100/100_thumb_690_300_fe0896024a4329258036e3800980df25.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539597730', '0', '100', '1', '690', '300', '106', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('189', '0', '1539598515367.jpg', 'lckjapp', 'uploads/images/20181015/068c69259711f99667dc45c48be381e4.jpg', '', '', 'multipart/form-data', 'jpg', '116843', 'a355bb689279c74b5fcda4376570dbef', '395a93e2819f1472bf1166418c5f544ccd95d985', 'local', '0', '1539598509', '1539598509', '100', '1', '960', '960', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('190', '0', '100_thumb_690_300_8c1f1e0b76213af167a9bc3f3ae17e83.jpg', '', 'upload/cut/100/100_thumb_690_300_8c1f1e0b76213af167a9bc3f3ae17e83.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539598636', '0', '100', '1', '690', '300', '125', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('191', '0', '100_thumb_690_300_acafd86c65647004a6466691f710d289.jpg', '', 'upload/cut/100/100_thumb_690_300_acafd86c65647004a6466691f710d289.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539598653', '0', '100', '1', '690', '300', '126', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('192', '1', '01489a59ffae0d56b60f1b645fd0e45d.jpg', '', 'upload/temp/01489a59ffae0d56b60f1b645fd0e45d.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539598795', '1539598795', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('193', '0', '100_thumb_200_200_01489a59ffae0d56b60f1b645fd0e45d.jpg', '', 'upload/cut/100/100_thumb_200_200_01489a59ffae0d56b60f1b645fd0e45d.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539598796', '0', '100', '1', '200', '200', '192', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('194', '1', 'd204e7a849b319ddf9d645edbb24f8c8.jpg', '', 'upload/temp/d204e7a849b319ddf9d645edbb24f8c8.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539598997', '1539598997', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('195', '0', '100_thumb_200_200_d204e7a849b319ddf9d645edbb24f8c8.jpg', '', 'upload/cut/100/100_thumb_200_200_d204e7a849b319ddf9d645edbb24f8c8.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539598998', '0', '100', '1', '200', '200', '194', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('196', '1', '34007790c59297e38832f49cd817c533.jpg', '', 'upload/temp/34007790c59297e38832f49cd817c533.jpg', '', '', 'image/jpeg', 'jpeg', '137276', '98f7285bacaf396321fa7d5d5689affa', '55a7a5045c2d93dbd71937b8ab0ddbc1acf22939', 'local', '0', '1539673570', '1539673570', '100', '1', '800', '565', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('197', '0', '100_thumb_690_300_34007790c59297e38832f49cd817c533.jpg', '', 'upload/cut/100/100_thumb_690_300_34007790c59297e38832f49cd817c533.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539673571', '0', '100', '1', '690', '300', '196', '6', '100');
INSERT INTO `dp_admin_attachment` VALUES ('198', '1', '0116be0fb922f2b6eb00909962886b25.jpg', '', 'upload/temp/0116be0fb922f2b6eb00909962886b25.jpg', '', '', 'image/jpeg', 'jpeg', '161828', 'b0c5691ade747e94febe1986d9d13e24', 'b41f9ae02cca2261643505ba1eb0a1742e6b84c4', 'local', '0', '1539673583', '1539673583', '100', '1', '800', '647', '0', '0', '0');
INSERT INTO `dp_admin_attachment` VALUES ('199', '0', '100_thumb_690_300_0116be0fb922f2b6eb00909962886b25.jpg', '', 'upload/cut/100/100_thumb_690_300_0116be0fb922f2b6eb00909962886b25.jpg', '', '', 'image/jpeg', 'jpeg', '0', '', '', 'local', '0', '1539673584', '0', '100', '1', '690', '300', '198', '6', '100');

-- ----------------------------
-- Table structure for dp_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_config`;
CREATE TABLE `dp_admin_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
  `group` varchar(32) NOT NULL DEFAULT '' COMMENT '配置分组',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '类型',
  `value` text NOT NULL COMMENT '配置值',
  `options` text NOT NULL COMMENT '配置项',
  `tips` varchar(256) NOT NULL DEFAULT '' COMMENT '配置提示',
  `ajax_url` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框ajax地址',
  `next_items` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框的下级下拉框名，多个以逗号隔开',
  `param` varchar(32) NOT NULL DEFAULT '' COMMENT '联动下拉框请求参数名',
  `format` varchar(32) NOT NULL DEFAULT '' COMMENT '格式，用于格式文本',
  `table` varchar(32) NOT NULL DEFAULT '' COMMENT '表名，只用于快速联动类型',
  `level` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '联动级别，只用于快速联动类型',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT '键字段，只用于快速联动类型',
  `option` varchar(32) NOT NULL DEFAULT '' COMMENT '值字段，只用于快速联动类型',
  `pid` varchar(32) NOT NULL DEFAULT '' COMMENT '父级id字段，只用于快速联动类型',
  `ak` varchar(32) NOT NULL DEFAULT '' COMMENT '百度地图appkey',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of dp_admin_config
-- ----------------------------
INSERT INTO `dp_admin_config` VALUES ('1', 'web_site_status', '站点开关', 'base', 'switch', '1', '', '站点关闭后将不能访问，后台可正常登录', '', '', '', '', '', '2', '', '', '', '', '1475240395', '1477403914', '1', '1');
INSERT INTO `dp_admin_config` VALUES ('2', 'web_site_title', '站点标题', 'base', 'text', '海豚PHP', '', '调用方式：<code>config(\'web_site_title\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475240646', '1477710341', '2', '1');
INSERT INTO `dp_admin_config` VALUES ('3', 'web_site_slogan', '站点标语', 'base', 'text', '海豚PHP，极简、极速、极致', '', '站点口号，调用方式：<code>config(\'web_site_slogan\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475240994', '1477710357', '3', '1');
INSERT INTO `dp_admin_config` VALUES ('4', 'web_site_logo', '站点LOGO', 'base', 'image', '', '', '', '', '', '', '', '', '2', '', '', '', '', '1475241067', '1475241067', '4', '1');
INSERT INTO `dp_admin_config` VALUES ('5', 'web_site_description', '站点描述', 'base', 'textarea', '', '', '网站描述，有利于搜索引擎抓取相关信息', '', '', '', '', '', '2', '', '', '', '', '1475241186', '1475241186', '6', '1');
INSERT INTO `dp_admin_config` VALUES ('6', 'web_site_keywords', '站点关键词', 'base', 'text', '海豚PHP、PHP开发框架、后台框架', '', '网站搜索引擎关键字', '', '', '', '', '', '2', '', '', '', '', '1475241328', '1475241328', '7', '1');
INSERT INTO `dp_admin_config` VALUES ('7', 'web_site_copyright', '版权信息', 'base', 'text', 'Copyright © 2015-2017 DolphinPHP All rights reserved.', '', '调用方式：<code>config(\'web_site_copyright\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475241416', '1477710383', '8', '1');
INSERT INTO `dp_admin_config` VALUES ('8', 'web_site_icp', '备案信息', 'base', 'text', '', '', '调用方式：<code>config(\'web_site_icp\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475241441', '1477710441', '9', '1');
INSERT INTO `dp_admin_config` VALUES ('9', 'web_site_statistics', '站点统计', 'base', 'textarea', '', '', '网站统计代码，支持百度、Google、cnzz等，调用方式：<code>config(\'web_site_statistics\')</code>', '', '', '', '', '', '2', '', '', '', '', '1475241498', '1477710455', '10', '1');
INSERT INTO `dp_admin_config` VALUES ('10', 'config_group', '配置分组', 'system', 'array', 'base:基本\r\nsystem:系统\r\nupload:上传\r\ndevelop:开发\r\ndatabase:数据库', '', '', '', '', '', '', '', '2', '', '', '', '', '1475241716', '1477649446', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('11', 'form_item_type', '配置类型', 'system', 'array', 'text:单行文本\r\ntextarea:多行文本\r\nstatic:静态文本\r\npassword:密码\r\ncheckbox:复选框\r\nradio:单选按钮\r\ndate:日期\r\ndatetime:日期+时间\r\nhidden:隐藏\r\nswitch:开关\r\narray:数组\r\nselect:下拉框\r\nlinkage:普通联动下拉框\r\nlinkages:快速联动下拉框\r\nimage:单张图片\r\nimages:多张图片\r\nfile:单个文件\r\nfiles:多个文件\r\nueditor:UEditor 编辑器\r\nwangeditor:wangEditor 编辑器\r\neditormd:markdown 编辑器\r\nckeditor:ckeditor 编辑器\r\nicon:字体图标\r\ntags:标签\r\nnumber:数字\r\nbmap:百度地图\r\ncolorpicker:取色器\r\njcrop:图片裁剪\r\nmasked:格式文本\r\nrange:范围\r\ntime:时间', '', '', '', '', '', '', '', '2', '', '', '', '', '1475241835', '1495853193', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('12', 'upload_file_size', '文件上传大小限制', 'upload', 'text', '0', '', '0为不限制大小，单位：kb', '', '', '', '', '', '2', '', '', '', '', '1475241897', '1477663520', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('13', 'upload_file_ext', '允许上传的文件后缀', 'upload', 'tags', 'doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,rar,zip,gz,bz2,7z', '', '多个后缀用逗号隔开，不填写则不限制类型', '', '', '', '', '', '2', '', '', '', '', '1475241975', '1477649489', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('14', 'upload_image_size', '图片上传大小限制', 'upload', 'text', '0', '', '0为不限制大小，单位：kb', '', '', '', '', '', '2', '', '', '', '', '1475242015', '1477663529', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('15', 'upload_image_ext', '允许上传的图片后缀', 'upload', 'tags', 'gif,jpg,jpeg,bmp,png', '', '多个后缀用逗号隔开，不填写则不限制类型', '', '', '', '', '', '2', '', '', '', '', '1475242056', '1477649506', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('16', 'list_rows', '分页数量', 'system', 'number', '20', '', '每页的记录数', '', '', '', '', '', '2', '', '', '', '', '1475242066', '1476074507', '101', '1');
INSERT INTO `dp_admin_config` VALUES ('17', 'system_color', '后台配色方案', 'system', 'radio', 'default', 'default:Default\r\namethyst:Amethyst\r\ncity:City\r\nflat:Flat\r\nmodern:Modern\r\nsmooth:Smooth', '', '', '', '', '', '', '2', '', '', '', '', '1475250066', '1477316689', '102', '1');
INSERT INTO `dp_admin_config` VALUES ('18', 'develop_mode', '开发模式', 'develop', 'radio', '1', '0:关闭\r\n1:开启', '', '', '', '', '', '', '2', '', '', '', '', '1476864205', '1476864231', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('19', 'app_trace', '显示页面Trace', 'develop', 'radio', '0', '0:否\r\n1:是', '', '', '', '', '', '', '2', '', '', '', '', '1476866355', '1476866355', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('21', 'data_backup_path', '数据库备份根路径', 'database', 'text', '../data/', '', '路径必须以 / 结尾', '', '', '', '', '', '2', '', '', '', '', '1477017745', '1477018467', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('22', 'data_backup_part_size', '数据库备份卷大小', 'database', 'text', '20971520', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '', '', '', '', '', '2', '', '', '', '', '1477017886', '1477017886', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('23', 'data_backup_compress', '数据库备份文件是否启用压缩', 'database', 'radio', '1', '0:否\r\n1:是', '压缩备份文件需要PHP环境支持 <code>gzopen</code>, <code>gzwrite</code>函数', '', '', '', '', '', '2', '', '', '', '', '1477017978', '1477018172', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('24', 'data_backup_compress_level', '数据库备份文件压缩级别', 'database', 'radio', '9', '1:最低\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '', '', '', '', '', '2', '', '', '', '', '1477018083', '1477018083', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('25', 'top_menu_max', '顶部导航模块数量', 'system', 'text', '10', '', '设置顶部导航默认显示的模块数量', '', '', '', '', '', '2', '', '', '', '', '1477579289', '1477579289', '103', '1');
INSERT INTO `dp_admin_config` VALUES ('26', 'web_site_logo_text', '站点LOGO文字', 'base', 'image', '', '', '', '', '', '', '', '', '2', '', '', '', '', '1477620643', '1477620643', '5', '1');
INSERT INTO `dp_admin_config` VALUES ('27', 'upload_image_thumb', '缩略图尺寸', 'upload', 'text', '', '', '不填写则不生成缩略图，如需生成 <code>300x300</code> 的缩略图，则填写 <code>300,300</code> ，请注意，逗号必须是英文逗号', '', '', '', '', '', '2', '', '', '', '', '1477644150', '1477649513', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('28', 'upload_image_thumb_type', '缩略图裁剪类型', 'upload', 'radio', '1', '1:等比例缩放\r\n2:缩放后填充\r\n3:居中裁剪\r\n4:左上角裁剪\r\n5:右下角裁剪\r\n6:固定尺寸缩放', '该项配置只有在启用生成缩略图时才生效', '', '', '', '', '', '2', '', '', '', '', '1477646271', '1477649521', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('29', 'upload_thumb_water', '添加水印', 'upload', 'switch', '0', '', '', '', '', '', '', '', '2', '', '', '', '', '1477649648', '1477649648', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('30', 'upload_thumb_water_pic', '水印图片', 'upload', 'image', '', '', '只有开启水印功能才生效', '', '', '', '', '', '2', '', '', '', '', '1477656390', '1477656390', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('31', 'upload_thumb_water_position', '水印位置', 'upload', 'radio', '9', '1:左上角\r\n2:上居中\r\n3:右上角\r\n4:左居中\r\n5:居中\r\n6:右居中\r\n7:左下角\r\n8:下居中\r\n9:右下角', '只有开启水印功能才生效', '', '', '', '', '', '2', '', '', '', '', '1477656528', '1477656528', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('32', 'upload_thumb_water_alpha', '水印透明度', 'upload', 'text', '50', '', '请输入0~100之间的数字，数字越小，透明度越高', '', '', '', '', '', '2', '', '', '', '', '1477656714', '1477661309', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('33', 'wipe_cache_type', '清除缓存类型', 'system', 'checkbox', 'TEMP_PATH', 'TEMP_PATH:应用缓存\r\nLOG_PATH:应用日志\r\nCACHE_PATH:项目模板缓存', '清除缓存时，要删除的缓存类型', '', '', '', '', '', '2', '', '', '', '', '1477727305', '1477727305', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('34', 'captcha_signin', '后台验证码开关', 'system', 'switch', '0', '', '后台登录时是否需要验证码', '', '', '', '', '', '2', '', '', '', '', '1478771958', '1478771958', '99', '1');
INSERT INTO `dp_admin_config` VALUES ('35', 'home_default_module', '前台默认模块', 'system', 'select', 'index', '', '前台默认访问的模块，该模块必须有Index控制器和index方法', '', '', '', '', '', '0', '', '', '', '', '1486714723', '1486715620', '104', '1');
INSERT INTO `dp_admin_config` VALUES ('36', 'minify_status', '开启minify', 'system', 'switch', '0', '', '开启minify会压缩合并js、css文件，可以减少资源请求次数，如果不支持minify，可关闭', '', '', '', '', '', '0', '', '', '', '', '1487035843', '1487035843', '99', '1');
INSERT INTO `dp_admin_config` VALUES ('37', 'upload_driver', '上传驱动', 'upload', 'radio', 'local', 'local:本地', '图片或文件上传驱动', '', '', '', '', '', '0', '', '', '', '', '1501488567', '1501490821', '100', '1');
INSERT INTO `dp_admin_config` VALUES ('38', 'system_log', '系统日志', 'system', 'switch', '1', '', '是否开启系统日志功能', '', '', '', '', '', '0', '', '', '', '', '1512635391', '1512635391', '99', '1');
INSERT INTO `dp_admin_config` VALUES ('39', 'asset_version', '资源版本号', 'develop', 'text', '20180327', '', '可通过修改版号强制用户更新静态文件', '', '', '', '', '', '0', '', '', '', '', '1522143239', '1522143239', '100', '1');

-- ----------------------------
-- Table structure for dp_admin_hook
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_hook`;
CREATE TABLE `dp_admin_hook` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `plugin` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子来自哪个插件',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子描述',
  `system` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统钩子',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='钩子表';

-- ----------------------------
-- Records of dp_admin_hook
-- ----------------------------
INSERT INTO `dp_admin_hook` VALUES ('1', 'admin_index', '', '后台首页', '1', '1468174214', '1477757518', '1');
INSERT INTO `dp_admin_hook` VALUES ('2', 'plugin_index_tab_list', '', '插件扩展tab钩子', '1', '1468174214', '1468174214', '1');
INSERT INTO `dp_admin_hook` VALUES ('3', 'module_index_tab_list', '', '模块扩展tab钩子', '1', '1468174214', '1468174214', '1');
INSERT INTO `dp_admin_hook` VALUES ('4', 'page_tips', '', '每个页面的提示', '1', '1468174214', '1468174214', '1');
INSERT INTO `dp_admin_hook` VALUES ('5', 'signin_footer', '', '登录页面底部钩子', '1', '1479269315', '1479269315', '1');
INSERT INTO `dp_admin_hook` VALUES ('6', 'signin_captcha', '', '登录页面验证码钩子', '1', '1479269315', '1479269315', '1');
INSERT INTO `dp_admin_hook` VALUES ('7', 'signin', '', '登录控制器钩子', '1', '1479386875', '1479386875', '1');
INSERT INTO `dp_admin_hook` VALUES ('8', 'upload_attachment', '', '附件上传钩子', '1', '1501493808', '1501493808', '1');
INSERT INTO `dp_admin_hook` VALUES ('9', 'page_plugin_js', '', '页面插件js钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('10', 'page_plugin_css', '', '页面插件css钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('11', 'signin_sso', '', '单点登录钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('12', 'signout_sso', '', '单点退出钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('13', 'user_add', '', '添加用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('14', 'user_edit', '', '编辑用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('15', 'user_delete', '', '删除用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('16', 'user_enable', '', '启用用户钩子', '1', '1503633591', '1503633591', '1');
INSERT INTO `dp_admin_hook` VALUES ('17', 'user_disable', '', '禁用用户钩子', '1', '1503633591', '1503633591', '1');

-- ----------------------------
-- Table structure for dp_admin_hook_plugin
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_hook_plugin`;
CREATE TABLE `dp_admin_hook_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hook` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子id',
  `plugin` varchar(32) NOT NULL DEFAULT '' COMMENT '插件标识',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='钩子-插件对应表';

-- ----------------------------
-- Records of dp_admin_hook_plugin
-- ----------------------------
INSERT INTO `dp_admin_hook_plugin` VALUES ('1', 'admin_index', 'SystemInfo', '1477757503', '1477757503', '1', '1');
INSERT INTO `dp_admin_hook_plugin` VALUES ('2', 'admin_index', 'DevTeam', '1477755780', '1477755780', '2', '1');

-- ----------------------------
-- Table structure for dp_admin_icon
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_icon`;
CREATE TABLE `dp_admin_icon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '图标名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图标css地址',
  `prefix` varchar(32) NOT NULL DEFAULT '' COMMENT '图标前缀',
  `font_family` varchar(32) NOT NULL DEFAULT '' COMMENT '字体名',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图标表';

-- ----------------------------
-- Records of dp_admin_icon
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_icon_list
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_icon_list`;
CREATE TABLE `dp_admin_icon_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属图标id',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '图标标题',
  `class` varchar(255) NOT NULL DEFAULT '' COMMENT '图标类名',
  `code` varchar(128) NOT NULL DEFAULT '' COMMENT '图标关键词',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='详细图标列表';

-- ----------------------------
-- Records of dp_admin_icon_list
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_log`;
CREATE TABLE `dp_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` longtext NOT NULL COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- ----------------------------
-- Records of dp_admin_log
-- ----------------------------
INSERT INTO `dp_admin_log` VALUES ('1', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：总平台', '1', '1535701182');
INSERT INTO `dp_admin_log` VALUES ('2', '39', '1', '2130706433', 'admin_module', '0', '超级管理员 导出了模块：门户', '1', '1535706767');
INSERT INTO `dp_admin_log` VALUES ('3', '30', '1', '2130706433', 'admin_menu', '236', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(0),节点标题(商家管理),节点链接(carwash/business/index)', '1', '1535707168');
INSERT INTO `dp_admin_log` VALUES ('4', '30', '1', '2130706433', 'admin_menu', '237', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(236),节点标题(商家列表),节点链接()', '1', '1535707204');
INSERT INTO `dp_admin_log` VALUES ('5', '30', '1', '2130706433', 'admin_menu', '238', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(237),节点标题(商家列表),节点链接(carwash/business/index)', '1', '1535707252');
INSERT INTO `dp_admin_log` VALUES ('6', '30', '1', '2130706433', 'admin_menu', '239', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(238),节点标题(新增商家),节点链接(carwash/business/add)', '1', '1535707335');
INSERT INTO `dp_admin_log` VALUES ('7', '36', '1', '2130706433', 'admin_module', '0', '超级管理员 卸载了模块：carwash', '1', '1535707342');
INSERT INTO `dp_admin_log` VALUES ('8', '35', '1', '2130706433', 'admin_module', '0', '超级管理员 安装了模块：总平台', '1', '1535707434');
INSERT INTO `dp_admin_log` VALUES ('9', '30', '1', '2130706433', 'admin_menu', '240', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(0),节点标题(商家管理),节点链接(carwash/business/index)', '1', '1535707808');
INSERT INTO `dp_admin_log` VALUES ('10', '30', '1', '2130706433', 'admin_menu', '241', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(商家列表),节点链接()', '1', '1535707856');
INSERT INTO `dp_admin_log` VALUES ('11', '30', '1', '2130706433', 'admin_menu', '242', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(241),节点标题(商家列表),节点链接(carwash/business/index)', '1', '1535707885');
INSERT INTO `dp_admin_log` VALUES ('12', '30', '1', '2130706433', 'admin_menu', '243', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(商家列表),节点链接(carwash/business/index)', '1', '1535707911');
INSERT INTO `dp_admin_log` VALUES ('13', '30', '1', '2130706433', 'admin_menu', '244', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(新增商家),节点链接(carwash/business/add)', '1', '1535708051');
INSERT INTO `dp_admin_log` VALUES ('14', '31', '1', '2130706433', 'admin_menu', '241', '超级管理员 编辑了节点：节点ID(241)', '1', '1535708066');
INSERT INTO `dp_admin_log` VALUES ('15', '31', '1', '2130706433', 'admin_menu', '242', '超级管理员 编辑了节点：节点ID(242)', '1', '1535708079');
INSERT INTO `dp_admin_log` VALUES ('16', '30', '1', '2130706433', 'admin_menu', '245', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(0),节点标题(用户管理),节点链接(carwash/admin/User)', '1', '1535708864');
INSERT INTO `dp_admin_log` VALUES ('17', '30', '1', '2130706433', 'admin_menu', '246', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(245),节点标题(用户列表),节点链接(carwash/admin/User)', '1', '1535709097');
INSERT INTO `dp_admin_log` VALUES ('18', '31', '1', '2130706433', 'admin_menu', '245', '超级管理员 编辑了节点：节点ID(245)', '1', '1535709637');
INSERT INTO `dp_admin_log` VALUES ('19', '31', '1', '2130706433', 'admin_menu', '245', '超级管理员 编辑了节点：节点ID(245)', '1', '1535709711');
INSERT INTO `dp_admin_log` VALUES ('20', '31', '1', '2130706433', 'admin_menu', '245', '超级管理员 编辑了节点：节点ID(245)', '1', '1535709748');
INSERT INTO `dp_admin_log` VALUES ('21', '31', '1', '2130706433', 'admin_menu', '245', '超级管理员 编辑了节点：节点ID(245)', '1', '1535710258');
INSERT INTO `dp_admin_log` VALUES ('22', '31', '1', '2130706433', 'admin_menu', '246', '超级管理员 编辑了节点：节点ID(246)', '1', '1535710404');
INSERT INTO `dp_admin_log` VALUES ('23', '31', '1', '2130706433', 'admin_menu', '240', '超级管理员 编辑了节点：节点ID(240)', '1', '1535940541');
INSERT INTO `dp_admin_log` VALUES ('24', '31', '1', '2130706433', 'admin_menu', '242', '超级管理员 编辑了节点：节点ID(242)', '1', '1535940553');
INSERT INTO `dp_admin_log` VALUES ('25', '31', '1', '2130706433', 'admin_menu', '243', '超级管理员 编辑了节点：节点ID(243)', '1', '1535940564');
INSERT INTO `dp_admin_log` VALUES ('26', '31', '1', '2130706433', 'admin_menu', '244', '超级管理员 编辑了节点：节点ID(244)', '1', '1535940575');
INSERT INTO `dp_admin_log` VALUES ('27', '30', '1', '2130706433', 'admin_menu', '247', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(查看收款类别),节点链接(carwash/seller/accounttype)', '1', '1535967212');
INSERT INTO `dp_admin_log` VALUES ('28', '30', '1', '2130706433', 'admin_menu', '248', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(查看营业项目),节点链接(carwash/seller/showservice)', '1', '1535973682');
INSERT INTO `dp_admin_log` VALUES ('29', '30', '1', '2130706433', 'admin_menu', '249', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(查看商家余额),节点链接(carwash/seller/showyue)', '1', '1535975700');
INSERT INTO `dp_admin_log` VALUES ('30', '31', '1', '2130706433', 'admin_menu', '240', '超级管理员 编辑了节点：节点ID(240)', '1', '1536026315');
INSERT INTO `dp_admin_log` VALUES ('31', '30', '1', '2130706433', 'admin_menu', '250', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(查看商家服务),节点链接(carwash/seller/showsellerservice)', '1', '1536027044');
INSERT INTO `dp_admin_log` VALUES ('32', '34', '1', '2130706433', 'admin_menu', '249', '超级管理员 禁用了节点：节点ID(249),节点标题(查看商家余额),节点链接(carwash/seller/showyue)', '1', '1536027051');
INSERT INTO `dp_admin_log` VALUES ('33', '33', '1', '2130706433', 'admin_menu', '249', '超级管理员 启用了节点：节点ID(249),节点标题(查看商家余额),节点链接(carwash/seller/showyue)', '1', '1536027054');
INSERT INTO `dp_admin_log` VALUES ('34', '31', '1', '2130706433', 'admin_menu', '249', '超级管理员 编辑了节点：节点ID(249)', '1', '1536027068');
INSERT INTO `dp_admin_log` VALUES ('35', '31', '1', '2130706433', 'admin_menu', '248', '超级管理员 编辑了节点：节点ID(248)', '1', '1536027079');
INSERT INTO `dp_admin_log` VALUES ('36', '31', '1', '2130706433', 'admin_menu', '247', '超级管理员 编辑了节点：节点ID(247)', '1', '1536027091');
INSERT INTO `dp_admin_log` VALUES ('37', '31', '1', '2130706433', 'admin_menu', '240', '超级管理员 编辑了节点：节点ID(240)', '1', '1536027133');
INSERT INTO `dp_admin_log` VALUES ('38', '30', '1', '2130706433', 'admin_menu', '251', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(246),节点标题(购买记录),节点链接(carwash/user/history)', '1', '1536029786');
INSERT INTO `dp_admin_log` VALUES ('39', '30', '1', '2130706433', 'admin_menu', '252', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(246),节点标题(查看卡种),节点链接(carwash/user/cards)', '1', '1536029954');
INSERT INTO `dp_admin_log` VALUES ('40', '31', '1', '2130706433', 'admin_menu', '245', '超级管理员 编辑了节点：节点ID(245)', '1', '1536030022');
INSERT INTO `dp_admin_log` VALUES ('41', '30', '1', '2130706433', 'admin_menu', '253', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(246),节点标题(导出excel),节点链接(carwash/user/userExcel)', '1', '1536030157');
INSERT INTO `dp_admin_log` VALUES ('42', '30', '1', '2130706433', 'admin_menu', '254', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(服务管理),节点链接()', '1', '1536030931');
INSERT INTO `dp_admin_log` VALUES ('43', '31', '1', '2130706433', 'admin_menu', '254', '超级管理员 编辑了节点：节点ID(254)', '1', '1536032296');
INSERT INTO `dp_admin_log` VALUES ('44', '30', '1', '2130706433', 'admin_menu', '255', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(254),节点标题(评价列表),节点链接(carwash/evaluate/index)', '1', '1536032338');
INSERT INTO `dp_admin_log` VALUES ('45', '30', '1', '2130706433', 'admin_menu', '256', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(编辑商家服务),节点链接(carwash/seller/editsellerservice)', '1', '1536032505');
INSERT INTO `dp_admin_log` VALUES ('46', '30', '1', '2130706433', 'admin_menu', '257', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(255),节点标题(评论显示/隐藏),节点链接(carwash/evaluate/operation)', '1', '1536042589');
INSERT INTO `dp_admin_log` VALUES ('47', '30', '1', '2130706433', 'admin_menu', '258', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(广告管理),节点链接()', '1', '1536047348');
INSERT INTO `dp_admin_log` VALUES ('48', '30', '1', '2130706433', 'admin_menu', '259', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(258),节点标题(广告列表),节点链接(carwash/advert/index)', '1', '1536047392');
INSERT INTO `dp_admin_log` VALUES ('49', '30', '1', '2130706433', 'admin_menu', '260', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(241),节点标题(订单记录),节点链接(carwash/seller/orderrecord)', '1', '1536047753');
INSERT INTO `dp_admin_log` VALUES ('50', '30', '1', '2130706433', 'admin_menu', '261', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(咨询管理),节点链接()', '1', '1536048572');
INSERT INTO `dp_admin_log` VALUES ('51', '30', '1', '2130706433', 'admin_menu', '262', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(261),节点标题(咨讯分类),节点链接(carwash/consult/index)', '1', '1536048625');
INSERT INTO `dp_admin_log` VALUES ('52', '30', '1', '2130706433', 'admin_menu', '263', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(261),节点标题(资讯列表),节点链接(carwash/consult/consuList)', '1', '1536048679');
INSERT INTO `dp_admin_log` VALUES ('53', '30', '1', '2130706433', 'admin_menu', '264', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(260),节点标题(导出EXCEL),节点链接(carwash/seller/exportorderdata)', '1', '1536052349');
INSERT INTO `dp_admin_log` VALUES ('54', '30', '1', '2130706433', 'admin_menu', '265', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(262),节点标题(增加分类),节点链接(carwash/consult/add)', '1', '1536053747');
INSERT INTO `dp_admin_log` VALUES ('55', '31', '1', '2130706433', 'admin_menu', '241', '超级管理员 编辑了节点：节点ID(241)', '1', '1536058252');
INSERT INTO `dp_admin_log` VALUES ('56', '30', '1', '2130706433', 'admin_menu', '266', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(导出商家EXCEL),节点链接(carwash/seller/exportsellerdata)', '1', '1536059969');
INSERT INTO `dp_admin_log` VALUES ('57', '31', '1', '2130706433', 'admin_menu', '242', '超级管理员 编辑了节点：节点ID(242)', '1', '1536061592');
INSERT INTO `dp_admin_log` VALUES ('58', '30', '1', '2130706433', 'admin_menu', '267', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(编辑商家),节点链接(carwash/seller/editseller)', '1', '1536061621');
INSERT INTO `dp_admin_log` VALUES ('59', '30', '1', '2130706433', 'admin_menu', '268', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(263),节点标题(编辑资讯),节点链接(carwash/consult/editconsult)', '1', '1536116424');
INSERT INTO `dp_admin_log` VALUES ('60', '30', '1', '2130706433', 'admin_menu', '269', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(263),节点标题(新增资讯),节点链接(carwash/consult/addConsult)', '1', '1536135857');
INSERT INTO `dp_admin_log` VALUES ('61', '30', '1', '2130706433', 'admin_menu', '270', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(获取省份城市),节点链接(carwash/seller/getprovinces)', '1', '1536135944');
INSERT INTO `dp_admin_log` VALUES ('62', '30', '1', '2130706433', 'admin_menu', '271', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(获取首页服务),节点链接(carwash/seller/gethomepagecate)', '1', '1536135982');
INSERT INTO `dp_admin_log` VALUES ('63', '30', '1', '2130706433', 'admin_menu', '272', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(258),节点标题(广告分类),节点链接(carwash/Advert/index)', '1', '1536137419');
INSERT INTO `dp_admin_log` VALUES ('64', '30', '1', '2130706433', 'admin_menu', '273', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(272),节点标题(增加分类),节点链接(carwash/advert/add)', '1', '1536138072');
INSERT INTO `dp_admin_log` VALUES ('65', '31', '1', '2130706433', 'admin_menu', '259', '超级管理员 编辑了节点：节点ID(259)', '1', '1536138665');
INSERT INTO `dp_admin_log` VALUES ('66', '30', '1', '2130706433', 'admin_menu', '274', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(校验商家数据),节点链接(carwash/seller/validatedata)', '1', '1536139223');
INSERT INTO `dp_admin_log` VALUES ('67', '30', '1', '2130706433', 'admin_menu', '275', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(259),节点标题(编辑广告),节点链接(carwash/advert/editAdv)', '1', '1536140506');
INSERT INTO `dp_admin_log` VALUES ('68', '30', '1', '2130706433', 'admin_menu', '276', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(259),节点标题(增加广告),节点链接(carwash/advert/addAdvert)', '1', '1536144288');
INSERT INTO `dp_admin_log` VALUES ('69', '30', '1', '2130706433', 'admin_menu', '277', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(订单管理),节点链接(carwash/userorder/orderrecord)', '1', '1536145126');
INSERT INTO `dp_admin_log` VALUES ('70', '31', '1', '2130706433', 'admin_menu', '260', '超级管理员 编辑了节点：节点ID(260)', '1', '1536145142');
INSERT INTO `dp_admin_log` VALUES ('71', '30', '1', '2130706433', 'admin_menu', '278', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(277),节点标题(订单列表),节点链接(carwash/seller/orderrecord)', '1', '1536145239');
INSERT INTO `dp_admin_log` VALUES ('72', '31', '1', '2130706433', 'admin_menu', '277', '超级管理员 编辑了节点：节点ID(277)', '1', '1536145253');
INSERT INTO `dp_admin_log` VALUES ('73', '30', '1', '2130706433', 'admin_menu', '279', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(278),节点标题(导出订单),节点链接(carwash/seller/exportorderdata)', '1', '1536145293');
INSERT INTO `dp_admin_log` VALUES ('74', '31', '1', '2130706433', 'admin_menu', '260', '超级管理员 编辑了节点：节点ID(260)', '1', '1536145824');
INSERT INTO `dp_admin_log` VALUES ('75', '32', '1', '2130706433', 'admin_menu', '264', '超级管理员 删除了节点：节点ID(264),节点标题(导出EXCEL),节点链接(carwash/seller/exportorderdata)', '1', '1536145867');
INSERT INTO `dp_admin_log` VALUES ('76', '31', '1', '2130706433', 'admin_menu', '279', '超级管理员 编辑了节点：节点ID(279)', '1', '1536145950');
INSERT INTO `dp_admin_log` VALUES ('77', '31', '1', '2130706433', 'admin_menu', '278', '超级管理员 编辑了节点：节点ID(278)', '1', '1536145998');
INSERT INTO `dp_admin_log` VALUES ('78', '31', '1', '2130706433', 'admin_menu', '279', '超级管理员 编辑了节点：节点ID(279)', '1', '1536146016');
INSERT INTO `dp_admin_log` VALUES ('79', '30', '1', '2130706433', 'admin_menu', '280', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(获取首页服务名称),节点链接(carwash/seller/gethomepagecatename)', '1', '1536147647');
INSERT INTO `dp_admin_log` VALUES ('80', '30', '1', '2130706433', 'admin_menu', '281', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(删除商家服务),节点链接(carwash/seller/delsellerservice)', '1', '1536148606');
INSERT INTO `dp_admin_log` VALUES ('81', '30', '1', '2130706433', 'admin_menu', '282', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(财务管理),节点链接()', '1', '1536202948');
INSERT INTO `dp_admin_log` VALUES ('82', '30', '1', '2130706433', 'admin_menu', '283', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(282),节点标题(手续费比例控制),节点链接(carwash/finance/index)', '1', '1536203154');
INSERT INTO `dp_admin_log` VALUES ('83', '30', '1', '2130706433', 'admin_menu', '284', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(首页服务分类),节点链接()', '1', '1536203672');
INSERT INTO `dp_admin_log` VALUES ('84', '30', '1', '2130706433', 'admin_menu', '285', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(284),节点标题(类别列表),节点链接(carwash/homepagecate/showpagecate)', '1', '1536203766');
INSERT INTO `dp_admin_log` VALUES ('85', '30', '1', '2130706433', 'admin_menu', '286', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(284),节点标题(新增类别),节点链接(carwash/homepagecate/addpagecate)', '1', '1536203839');
INSERT INTO `dp_admin_log` VALUES ('86', '31', '1', '2130706433', 'admin_menu', '284', '超级管理员 编辑了节点：节点ID(284)', '1', '1536203880');
INSERT INTO `dp_admin_log` VALUES ('87', '31', '1', '2130706433', 'admin_menu', '286', '超级管理员 编辑了节点：节点ID(286)', '1', '1536204068');
INSERT INTO `dp_admin_log` VALUES ('88', '30', '1', '2130706433', 'admin_menu', '287', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(282),节点标题(银行卡管理),节点链接(carwash/finance/bankCardList)', '1', '1536205744');
INSERT INTO `dp_admin_log` VALUES ('89', '31', '1', '2130706433', 'admin_menu', '286', '超级管理员 编辑了节点：节点ID(286)', '1', '1536209938');
INSERT INTO `dp_admin_log` VALUES ('90', '31', '1', '2130706433', 'admin_menu', '278', '超级管理员 编辑了节点：节点ID(278)', '1', '1536214024');
INSERT INTO `dp_admin_log` VALUES ('91', '31', '1', '2130706433', 'admin_menu', '279', '超级管理员 编辑了节点：节点ID(279)', '1', '1536214036');
INSERT INTO `dp_admin_log` VALUES ('92', '31', '1', '2130706433', 'admin_menu', '285', '超级管理员 编辑了节点：节点ID(285)', '1', '1536214064');
INSERT INTO `dp_admin_log` VALUES ('93', '31', '1', '2130706433', 'admin_menu', '286', '超级管理员 编辑了节点：节点ID(286)', '1', '1536214086');
INSERT INTO `dp_admin_log` VALUES ('94', '30', '1', '2130706433', 'admin_menu', '288', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(287),节点标题(编辑银行卡),节点链接(carwash/finance/editCard)', '1', '1536215896');
INSERT INTO `dp_admin_log` VALUES ('95', '30', '1', '2130706433', 'admin_menu', '289', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(287),节点标题(新增银行卡),节点链接(carwash/finance/addCard)', '1', '1536216187');
INSERT INTO `dp_admin_log` VALUES ('96', '31', '1', '2130706433', 'admin_menu', '285', '超级管理员 编辑了节点：节点ID(285)', '1', '1536216217');
INSERT INTO `dp_admin_log` VALUES ('97', '31', '1', '2130706433', 'admin_menu', '286', '超级管理员 编辑了节点：节点ID(286)', '1', '1536216228');
INSERT INTO `dp_admin_log` VALUES ('98', '30', '1', '2130706433', 'admin_menu', '290', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(282),节点标题(提现记录),节点链接(carwash/finance/finanList)', '1', '1536217015');
INSERT INTO `dp_admin_log` VALUES ('99', '31', '1', '2130706433', 'admin_menu', '286', '超级管理员 编辑了节点：节点ID(286)', '1', '1536217125');
INSERT INTO `dp_admin_log` VALUES ('100', '30', '1', '2130706433', 'admin_menu', '291', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(285),节点标题(删除首页服务类别),节点链接(carwash/homepage_cate/delhomepagecate)', '1', '1536218549');
INSERT INTO `dp_admin_log` VALUES ('101', '31', '1', '2130706433', 'admin_menu', '284', '超级管理员 编辑了节点：节点ID(284)', '1', '1536223176');
INSERT INTO `dp_admin_log` VALUES ('102', '31', '1', '2130706433', 'admin_menu', '285', '超级管理员 编辑了节点：节点ID(285)', '1', '1536223969');
INSERT INTO `dp_admin_log` VALUES ('103', '31', '1', '2130706433', 'admin_menu', '285', '超级管理员 编辑了节点：节点ID(285)', '1', '1536224614');
INSERT INTO `dp_admin_log` VALUES ('104', '31', '1', '2130706433', 'admin_menu', '291', '超级管理员 编辑了节点：节点ID(291)', '1', '1536224626');
INSERT INTO `dp_admin_log` VALUES ('105', '30', '1', '2130706433', 'admin_menu', '292', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(284),节点标题(商家服务列表),节点链接(carwash/seller_service/sellerlist)', '1', '1536224830');
INSERT INTO `dp_admin_log` VALUES ('106', '31', '1', '2130706433', 'admin_menu', '286', '超级管理员 编辑了节点：节点ID(286)', '1', '1536224870');
INSERT INTO `dp_admin_log` VALUES ('107', '31', '1', '2130706433', 'admin_menu', '292', '超级管理员 编辑了节点：节点ID(292)', '1', '1536224982');
INSERT INTO `dp_admin_log` VALUES ('108', '30', '1', '2130706433', 'admin_menu', '293', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(卡种管理),节点链接()', '1', '1536229849');
INSERT INTO `dp_admin_log` VALUES ('109', '30', '1', '2130706433', 'admin_menu', '294', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(293),节点标题(新增卡种),节点链接(carwash/platformcard/add)', '1', '1536230362');
INSERT INTO `dp_admin_log` VALUES ('110', '31', '1', '2130706433', 'admin_menu', '294', '超级管理员 编辑了节点：节点ID(294)', '1', '1536230398');
INSERT INTO `dp_admin_log` VALUES ('111', '30', '1', '2130706433', 'admin_menu', '295', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(290),节点标题(导出提现记录),节点链接(carwash/finance/finanExcel)', '1', '1536285843');
INSERT INTO `dp_admin_log` VALUES ('112', '30', '1', '2130706433', 'admin_menu', '296', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(290),节点标题(驳回提现),节点链接(carwash/finance/reject)', '1', '1536286830');
INSERT INTO `dp_admin_log` VALUES ('113', '30', '1', '2130706433', 'admin_menu', '297', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(293),节点标题(在售卡种),节点链接(carwash/platformcard/onsalecard)', '1', '1536290813');
INSERT INTO `dp_admin_log` VALUES ('114', '31', '1', '2130706433', 'admin_menu', '297', '超级管理员 编辑了节点：节点ID(297)', '1', '1536290840');
INSERT INTO `dp_admin_log` VALUES ('115', '30', '1', '2130706433', 'admin_menu', '298', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(297),节点标题(编辑卡信息),节点链接(carwash/platformcard/editcard)', '1', '1536301090');
INSERT INTO `dp_admin_log` VALUES ('116', '31', '1', '2130706433', 'admin_menu', '298', '超级管理员 编辑了节点：节点ID(298)', '1', '1536301124');
INSERT INTO `dp_admin_log` VALUES ('117', '31', '1', '2130706433', 'admin_menu', '298', '超级管理员 编辑了节点：节点ID(298)', '1', '1536302248');
INSERT INTO `dp_admin_log` VALUES ('118', '31', '1', '2130706433', 'admin_menu', '298', '超级管理员 编辑了节点：节点ID(298)', '1', '1536302261');
INSERT INTO `dp_admin_log` VALUES ('119', '31', '1', '2130706433', 'admin_menu', '298', '超级管理员 编辑了节点：节点ID(298)', '1', '1536302427');
INSERT INTO `dp_admin_log` VALUES ('120', '30', '1', '2130706433', 'admin_menu', '299', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(297),节点标题(查看购买记录),节点链接(carwash/platform_card/buyhistory)', '1', '1536304126');
INSERT INTO `dp_admin_log` VALUES ('121', '31', '1', '2130706433', 'admin_menu', '299', '超级管理员 编辑了节点：节点ID(299)', '1', '1536304145');
INSERT INTO `dp_admin_log` VALUES ('122', '30', '1', '2130706433', 'admin_menu', '300', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(290),节点标题(批量打款),节点链接(carwash/finance/batchRemit)', '1', '1536306759');
INSERT INTO `dp_admin_log` VALUES ('123', '30', '1', '2130706433', 'admin_menu', '301', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(293),节点标题(卡种列表),节点链接(carwash/platform_card/carlist)', '1', '1536309261');
INSERT INTO `dp_admin_log` VALUES ('124', '31', '1', '2130706433', 'admin_menu', '301', '超级管理员 编辑了节点：节点ID(301)', '1', '1536309304');
INSERT INTO `dp_admin_log` VALUES ('125', '30', '1', '2130706433', 'admin_menu', '302', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(关于我们),节点链接()', '1', '1536311620');
INSERT INTO `dp_admin_log` VALUES ('126', '30', '1', '2130706433', 'admin_menu', '303', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(302),节点标题(地域配置),节点链接(carwash/territory/index)', '1', '1536311852');
INSERT INTO `dp_admin_log` VALUES ('127', '31', '1', '2130706433', 'admin_menu', '278', '超级管理员 编辑了节点：节点ID(278)', '1', '1536317634');
INSERT INTO `dp_admin_log` VALUES ('128', '30', '1', '2130706433', 'admin_menu', '304', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(277),节点标题(平台订单),节点链接(carwash/user_order/platformlist)', '1', '1536318333');
INSERT INTO `dp_admin_log` VALUES ('129', '30', '1', '2130706433', 'admin_menu', '305', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(304),节点标题(导出平台订单),节点链接(carwash/user_order/exportplatformlist)', '1', '1536321361');
INSERT INTO `dp_admin_log` VALUES ('130', '30', '1', '2130706433', 'admin_menu', '306', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(241),节点标题(银行卡管理),节点链接(carwash/seller/bank)', '1', '1536321688');
INSERT INTO `dp_admin_log` VALUES ('131', '30', '1', '2130706433', 'admin_menu', '307', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(获取所有的商家),节点链接(carwash/seller/catallseller)', '1', '1536322088');
INSERT INTO `dp_admin_log` VALUES ('132', '30', '1', '2130706433', 'admin_menu', '308', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(306),节点标题(新增银行卡),节点链接(carwash/seller/addbank)', '1', '1536322607');
INSERT INTO `dp_admin_log` VALUES ('133', '30', '1', '2130706433', 'admin_menu', '309', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(306),节点标题(获取开户银行),节点链接(carwash/seller/bankofdeposit)', '1', '1536324045');
INSERT INTO `dp_admin_log` VALUES ('134', '30', '1', '2130706433', 'admin_menu', '310', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(查询商家是否已有启用状态的账号存在),节点链接(carwash/seller/querycashaccountisexist)', '1', '1536326485');
INSERT INTO `dp_admin_log` VALUES ('135', '31', '1', '2130706433', 'admin_menu', '306', '超级管理员 编辑了节点：节点ID(306)', '1', '1536327437');
INSERT INTO `dp_admin_log` VALUES ('136', '31', '1', '2130706433', 'admin_menu', '308', '超级管理员 编辑了节点：节点ID(308)', '1', '1536545156');
INSERT INTO `dp_admin_log` VALUES ('137', '31', '1', '2130706433', 'admin_menu', '306', '超级管理员 编辑了节点：节点ID(306)', '1', '1536545228');
INSERT INTO `dp_admin_log` VALUES ('138', '30', '1', '2130706433', 'admin_menu', '311', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(306),节点标题(校验银行卡号),节点链接(carwash/seller/validatebanknum)', '1', '1536546791');
INSERT INTO `dp_admin_log` VALUES ('139', '30', '1', '2130706433', 'admin_menu', '312', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(303),节点标题(获取子目录),节点链接(carwash/territory/ajax_)', '1', '1536550708');
INSERT INTO `dp_admin_log` VALUES ('140', '32', '1', '2130706433', 'admin_menu', '312', '超级管理员 删除了节点：节点ID(312),节点标题(获取子目录),节点链接(carwash/territory/ajax_)', '1', '1536550815');
INSERT INTO `dp_admin_log` VALUES ('141', '30', '1', '2130706433', 'admin_menu', '313', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(306),节点标题(删除提现账户),节点链接(carwash/seller/delcashaccount)', '1', '1536551934');
INSERT INTO `dp_admin_log` VALUES ('142', '30', '1', '2130706433', 'admin_menu', '314', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(306),节点标题(编辑提现账号),节点链接(carwash/seller/editcashaccount)', '1', '1536561285');
INSERT INTO `dp_admin_log` VALUES ('143', '31', '1', '2130706433', 'admin_menu', '286', '超级管理员 编辑了节点：节点ID(286)', '1', '1536564348');
INSERT INTO `dp_admin_log` VALUES ('144', '31', '1', '2130706433', 'admin_menu', '285', '超级管理员 编辑了节点：节点ID(285)', '1', '1536566896');
INSERT INTO `dp_admin_log` VALUES ('145', '30', '1', '2130706433', 'admin_menu', '315', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(303),节点标题(编辑城市名称),节点链接(carwash/Territory/editCity)', '1', '1536571579');
INSERT INTO `dp_admin_log` VALUES ('146', '31', '1', '2130706433', 'admin_menu', '315', '超级管理员 编辑了节点：节点ID(315)', '1', '1536571618');
INSERT INTO `dp_admin_log` VALUES ('147', '30', '1', '2130706433', 'admin_menu', '316', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(285),节点标题(编辑服务类别),节点链接(carwash/seller_service/edithomepagecate)', '1', '1536573270');
INSERT INTO `dp_admin_log` VALUES ('148', '30', '1', '2130706433', 'admin_menu', '317', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(303),节点标题(新增城市),节点链接(carwash/Territory/addCity)', '1', '1536573817');
INSERT INTO `dp_admin_log` VALUES ('149', '30', '1', '2130706433', 'admin_menu', '318', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(303),节点标题(删除城市),节点链接(carwash/Territory/deleteCity)', '1', '1536574966');
INSERT INTO `dp_admin_log` VALUES ('150', '30', '1', '2130706433', 'admin_menu', '319', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(303),节点标题(管理二级城市),节点链接(carwash/Territory/manageCity)', '1', '1536631738');
INSERT INTO `dp_admin_log` VALUES ('151', '31', '1', '2130706433', 'admin_menu', '318', '超级管理员 编辑了节点：节点ID(318)', '1', '1536637237');
INSERT INTO `dp_admin_log` VALUES ('152', '30', '1', '2130706433', 'admin_menu', '320', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(302),节点标题(平台客服),节点链接(carwash/Territory/servlist)', '1', '1536646359');
INSERT INTO `dp_admin_log` VALUES ('153', '30', '1', '2130706433', 'admin_menu', '321', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(292),节点标题(删除商家服务),节点链接(carwash/seller_service/delsellerservice)', '1', '1536646658');
INSERT INTO `dp_admin_log` VALUES ('154', '30', '1', '2130706433', 'admin_menu', '322', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(292),节点标题(编辑商家服务),节点链接(carwash/seller_service/editsellerservice)', '1', '1536647293');
INSERT INTO `dp_admin_log` VALUES ('155', '30', '1', '2130706433', 'admin_menu', '323', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(320),节点标题(新增/编辑客服),节点链接(carwash/Territory/addeditserv)', '1', '1536647606');
INSERT INTO `dp_admin_log` VALUES ('156', '31', '1', '2130706433', 'admin_menu', '323', '超级管理员 编辑了节点：节点ID(323)', '1', '1536647691');
INSERT INTO `dp_admin_log` VALUES ('157', '30', '1', '2130706433', 'admin_menu', '324', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(240),节点标题(后台管理),节点链接()', '1', '1536648898');
INSERT INTO `dp_admin_log` VALUES ('158', '31', '1', '2130706433', 'admin_menu', '324', '超级管理员 编辑了节点：节点ID(324)', '1', '1536648917');
INSERT INTO `dp_admin_log` VALUES ('159', '31', '1', '2130706433', 'admin_menu', '324', '超级管理员 编辑了节点：节点ID(324)', '1', '1536648944');
INSERT INTO `dp_admin_log` VALUES ('160', '30', '1', '2130706433', 'admin_menu', '325', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(324),节点标题(后台首页),节点链接(carwash/index/index)', '1', '1536649103');
INSERT INTO `dp_admin_log` VALUES ('161', '30', '1', '2130706433', 'admin_menu', '326', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(324),节点标题(信封图片),节点链接(carwash/index/letter.jpg)', '1', '1536651454');
INSERT INTO `dp_admin_log` VALUES ('162', '32', '1', '2130706433', 'admin_menu', '326', '超级管理员 删除了节点：节点ID(326),节点标题(信封图片),节点链接(carwash/index/letter.jpg)', '1', '1536651464');
INSERT INTO `dp_admin_log` VALUES ('163', '30', '1', '2130706433', 'admin_menu', '327', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(242),节点标题(修改店长密码),节点链接(carwash/seller/editshopownerpwd)', '1', '1536835732');
INSERT INTO `dp_admin_log` VALUES ('164', '30', '1', '2130706433', 'admin_menu', '328', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(302),节点标题(服务协议),节点链接(carwash/territory/servAgreement)', '1', '1537151955');
INSERT INTO `dp_admin_log` VALUES ('165', '31', '1', '2130706433', 'admin_menu', '328', '超级管理员 编辑了节点：节点ID(328)', '1', '1537151988');
INSERT INTO `dp_admin_log` VALUES ('166', '30', '1', '2130706433', 'admin_menu', '329', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(328),节点标题(添加服务协议),节点链接(carwash/territory/operationserv)', '1', '1537152340');
INSERT INTO `dp_admin_log` VALUES ('167', '30', '1', '3232235585', 'admin_menu', '330', '超级管理员 添加了节点：所属模块(carwash),所属节点ID(292),节点标题(审核服务状态),节点链接(carwash/seller_service/editServiceStatus)', '1', '1537327322');
INSERT INTO `dp_admin_log` VALUES ('168', '31', '1', '3232235585', 'admin_menu', '261', '超级管理员 编辑了节点：节点ID(261)', '1', '1539673291');

-- ----------------------------
-- Table structure for dp_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_menu`;
CREATE TABLE `dp_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单id',
  `module` varchar(16) NOT NULL DEFAULT '' COMMENT '模块名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '菜单标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url_type` varchar(16) NOT NULL DEFAULT '' COMMENT '链接类型（link：外链，module：模块）',
  `url_value` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `url_target` varchar(16) NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank,_self',
  `online_hide` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '网站上线后是否隐藏',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `system_menu` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `params` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=331 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of dp_admin_menu
-- ----------------------------
INSERT INTO `dp_admin_menu` VALUES ('1', '0', 'admin', '首页', 'fa fa-fw fa-home', 'module_admin', 'admin/index/index', '_self', '0', '1467617722', '1477710540', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('2', '1', 'admin', '快捷操作', 'fa fa-fw fa-folder-open-o', 'module_admin', '', '_self', '0', '1467618170', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('3', '2', 'admin', '清空缓存', 'fa fa-fw fa-trash-o', 'module_admin', 'admin/index/wipecache', '_self', '0', '1467618273', '1489049773', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('4', '0', 'admin', '系统', 'fa fa-fw fa-gear', 'module_admin', 'admin/system/index', '_self', '0', '1467618361', '1477710540', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('5', '4', 'admin', '系统功能', 'si si-wrench', 'module_admin', '', '_self', '0', '1467618441', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('6', '5', 'admin', '系统设置', 'fa fa-fw fa-wrench', 'module_admin', 'admin/system/index', '_self', '0', '1467618490', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('7', '5', 'admin', '配置管理', 'fa fa-fw fa-gears', 'module_admin', 'admin/config/index', '_self', '0', '1467618618', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('8', '7', 'admin', '新增', '', 'module_admin', 'admin/config/add', '_self', '0', '1467618648', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('9', '7', 'admin', '编辑', '', 'module_admin', 'admin/config/edit', '_self', '0', '1467619566', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('10', '7', 'admin', '删除', '', 'module_admin', 'admin/config/delete', '_self', '0', '1467619583', '1477710695', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('11', '7', 'admin', '启用', '', 'module_admin', 'admin/config/enable', '_self', '0', '1467619609', '1477710695', '4', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('12', '7', 'admin', '禁用', '', 'module_admin', 'admin/config/disable', '_self', '0', '1467619637', '1477710695', '5', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('13', '5', 'admin', '节点管理', 'fa fa-fw fa-bars', 'module_admin', 'admin/menu/index', '_self', '0', '1467619882', '1477710695', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('14', '13', 'admin', '新增', '', 'module_admin', 'admin/menu/add', '_self', '0', '1467619902', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('15', '13', 'admin', '编辑', '', 'module_admin', 'admin/menu/edit', '_self', '0', '1467620331', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('16', '13', 'admin', '删除', '', 'module_admin', 'admin/menu/delete', '_self', '0', '1467620363', '1477710695', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('17', '13', 'admin', '启用', '', 'module_admin', 'admin/menu/enable', '_self', '0', '1467620386', '1477710695', '4', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('18', '13', 'admin', '禁用', '', 'module_admin', 'admin/menu/disable', '_self', '0', '1467620404', '1477710695', '5', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('19', '68', 'user', '权限管理', 'fa fa-fw fa-key', 'module_admin', '', '_self', '0', '1467688065', '1477710702', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('20', '19', 'user', '用户管理', 'fa fa-fw fa-user', 'module_admin', 'user/index/index', '_self', '0', '1467688137', '1477710702', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('21', '20', 'user', '新增', '', 'module_admin', 'user/index/add', '_self', '0', '1467688177', '1477710702', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('22', '20', 'user', '编辑', '', 'module_admin', 'user/index/edit', '_self', '0', '1467688202', '1477710702', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('23', '20', 'user', '删除', '', 'module_admin', 'user/index/delete', '_self', '0', '1467688219', '1477710702', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('24', '20', 'user', '启用', '', 'module_admin', 'user/index/enable', '_self', '0', '1467688238', '1477710702', '4', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('25', '20', 'user', '禁用', '', 'module_admin', 'user/index/disable', '_self', '0', '1467688256', '1477710702', '5', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('211', '64', 'admin', '日志详情', '', 'module_admin', 'admin/log/details', '_self', '0', '1480299320', '1480299320', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('32', '4', 'admin', '扩展中心', 'si si-social-dropbox', 'module_admin', '', '_self', '0', '1467688853', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('33', '32', 'admin', '模块管理', 'fa fa-fw fa-th-large', 'module_admin', 'admin/module/index', '_self', '0', '1467689008', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('34', '33', 'admin', '导入', '', 'module_admin', 'admin/module/import', '_self', '0', '1467689153', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('35', '33', 'admin', '导出', '', 'module_admin', 'admin/module/export', '_self', '0', '1467689173', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('36', '33', 'admin', '安装', '', 'module_admin', 'admin/module/install', '_self', '0', '1467689192', '1477710695', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('37', '33', 'admin', '卸载', '', 'module_admin', 'admin/module/uninstall', '_self', '0', '1467689241', '1477710695', '4', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('38', '33', 'admin', '启用', '', 'module_admin', 'admin/module/enable', '_self', '0', '1467689294', '1477710695', '5', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('39', '33', 'admin', '禁用', '', 'module_admin', 'admin/module/disable', '_self', '0', '1467689312', '1477710695', '6', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('40', '33', 'admin', '更新', '', 'module_admin', 'admin/module/update', '_self', '0', '1467689341', '1477710695', '7', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('41', '32', 'admin', '插件管理', 'fa fa-fw fa-puzzle-piece', 'module_admin', 'admin/plugin/index', '_self', '0', '1467689527', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('42', '41', 'admin', '导入', '', 'module_admin', 'admin/plugin/import', '_self', '0', '1467689650', '1477710695', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('43', '41', 'admin', '导出', '', 'module_admin', 'admin/plugin/export', '_self', '0', '1467689665', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('44', '41', 'admin', '安装', '', 'module_admin', 'admin/plugin/install', '_self', '0', '1467689680', '1477710695', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('45', '41', 'admin', '卸载', '', 'module_admin', 'admin/plugin/uninstall', '_self', '0', '1467689700', '1477710695', '4', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('46', '41', 'admin', '启用', '', 'module_admin', 'admin/plugin/enable', '_self', '0', '1467689730', '1477710695', '5', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('47', '41', 'admin', '禁用', '', 'module_admin', 'admin/plugin/disable', '_self', '0', '1467689747', '1477710695', '6', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('48', '41', 'admin', '设置', '', 'module_admin', 'admin/plugin/config', '_self', '0', '1467689789', '1477710695', '7', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('49', '41', 'admin', '管理', '', 'module_admin', 'admin/plugin/manage', '_self', '0', '1467689846', '1477710695', '8', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('50', '5', 'admin', '附件管理', 'fa fa-fw fa-cloud-upload', 'module_admin', 'admin/attachment/index', '_self', '0', '1467690161', '1477710695', '4', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('51', '70', 'admin', '文件上传', '', 'module_admin', 'admin/attachment/upload', '_self', '0', '1467690240', '1489049773', '1', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('52', '50', 'admin', '下载', '', 'module_admin', 'admin/attachment/download', '_self', '0', '1467690334', '1477710695', '2', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('53', '50', 'admin', '启用', '', 'module_admin', 'admin/attachment/enable', '_self', '0', '1467690352', '1477710695', '3', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('54', '50', 'admin', '禁用', '', 'module_admin', 'admin/attachment/disable', '_self', '0', '1467690369', '1477710695', '4', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('55', '50', 'admin', '删除', '', 'module_admin', 'admin/attachment/delete', '_self', '0', '1467690396', '1477710695', '5', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('56', '41', 'admin', '删除', '', 'module_admin', 'admin/plugin/delete', '_self', '0', '1467858065', '1477710695', '11', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('57', '41', 'admin', '编辑', '', 'module_admin', 'admin/plugin/edit', '_self', '0', '1467858092', '1477710695', '10', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('60', '41', 'admin', '新增', '', 'module_admin', 'admin/plugin/add', '_self', '0', '1467858421', '1477710695', '9', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('61', '41', 'admin', '执行', '', 'module_admin', 'admin/plugin/execute', '_self', '0', '1467879016', '1477710695', '14', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('62', '13', 'admin', '保存', '', 'module_admin', 'admin/menu/save', '_self', '0', '1468073039', '1477710695', '6', '1', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('64', '5', 'admin', '系统日志', 'fa fa-fw fa-book', 'module_admin', 'admin/log/index', '_self', '0', '1476111944', '1477710695', '6', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('65', '5', 'admin', '数据库管理', 'fa fa-fw fa-database', 'module_admin', 'admin/database/index', '_self', '0', '1476111992', '1477710695', '8', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('66', '32', 'admin', '数据包管理', 'fa fa-fw fa-database', 'module_admin', 'admin/packet/index', '_self', '0', '1476112326', '1477710695', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('67', '19', 'user', '角色管理', 'fa fa-fw fa-users', 'module_admin', 'user/role/index', '_self', '0', '1476113025', '1477710702', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('68', '0', 'user', '用户', 'fa fa-fw fa-user', 'module_admin', 'user/index/index', '_self', '0', '1476193348', '1477710540', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('69', '32', 'admin', '钩子管理', 'fa fa-fw fa-anchor', 'module_admin', 'admin/hook/index', '_self', '0', '1476236193', '1477710695', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('70', '2', 'admin', '后台首页', 'fa fa-fw fa-tachometer', 'module_admin', 'admin/index/index', '_self', '0', '1476237472', '1489049773', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('71', '67', 'user', '新增', '', 'module_admin', 'user/role/add', '_self', '0', '1476256935', '1477710702', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('72', '67', 'user', '编辑', '', 'module_admin', 'user/role/edit', '_self', '0', '1476256968', '1477710702', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('73', '67', 'user', '删除', '', 'module_admin', 'user/role/delete', '_self', '0', '1476256993', '1477710702', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('74', '67', 'user', '启用', '', 'module_admin', 'user/role/enable', '_self', '0', '1476257023', '1477710702', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('75', '67', 'user', '禁用', '', 'module_admin', 'user/role/disable', '_self', '0', '1476257046', '1477710702', '5', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('76', '20', 'user', '授权', '', 'module_admin', 'user/index/access', '_self', '0', '1476375187', '1477710702', '6', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('77', '69', 'admin', '新增', '', 'module_admin', 'admin/hook/add', '_self', '0', '1476668971', '1477710695', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('78', '69', 'admin', '编辑', '', 'module_admin', 'admin/hook/edit', '_self', '0', '1476669006', '1477710695', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('79', '69', 'admin', '删除', '', 'module_admin', 'admin/hook/delete', '_self', '0', '1476669375', '1477710695', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('80', '69', 'admin', '启用', '', 'module_admin', 'admin/hook/enable', '_self', '0', '1476669427', '1477710695', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('81', '69', 'admin', '禁用', '', 'module_admin', 'admin/hook/disable', '_self', '0', '1476669564', '1477710695', '5', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('183', '66', 'admin', '安装', '', 'module_admin', 'admin/packet/install', '_self', '0', '1476851362', '1477710695', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('184', '66', 'admin', '卸载', '', 'module_admin', 'admin/packet/uninstall', '_self', '0', '1476851382', '1477710695', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('185', '5', 'admin', '行为管理', 'fa fa-fw fa-bug', 'module_admin', 'admin/action/index', '_self', '0', '1476882441', '1477710695', '7', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('186', '185', 'admin', '新增', '', 'module_admin', 'admin/action/add', '_self', '0', '1476884439', '1477710695', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('187', '185', 'admin', '编辑', '', 'module_admin', 'admin/action/edit', '_self', '0', '1476884464', '1477710695', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('188', '185', 'admin', '启用', '', 'module_admin', 'admin/action/enable', '_self', '0', '1476884493', '1477710695', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('189', '185', 'admin', '禁用', '', 'module_admin', 'admin/action/disable', '_self', '0', '1476884534', '1477710695', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('190', '185', 'admin', '删除', '', 'module_admin', 'admin/action/delete', '_self', '0', '1476884551', '1477710695', '5', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('191', '65', 'admin', '备份数据库', '', 'module_admin', 'admin/database/export', '_self', '0', '1476972746', '1477710695', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('192', '65', 'admin', '还原数据库', '', 'module_admin', 'admin/database/import', '_self', '0', '1476972772', '1477710695', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('193', '65', 'admin', '优化表', '', 'module_admin', 'admin/database/optimize', '_self', '0', '1476972800', '1477710695', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('194', '65', 'admin', '修复表', '', 'module_admin', 'admin/database/repair', '_self', '0', '1476972825', '1477710695', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('195', '65', 'admin', '删除备份', '', 'module_admin', 'admin/database/delete', '_self', '0', '1476973457', '1477710695', '5', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('210', '41', 'admin', '快速编辑', '', 'module_admin', 'admin/plugin/quickedit', '_self', '0', '1477713981', '1477713981', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('209', '185', 'admin', '快速编辑', '', 'module_admin', 'admin/action/quickedit', '_self', '0', '1477713939', '1477713939', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('208', '7', 'admin', '快速编辑', '', 'module_admin', 'admin/config/quickedit', '_self', '0', '1477713808', '1477713808', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('207', '69', 'admin', '快速编辑', '', 'module_admin', 'admin/hook/quickedit', '_self', '0', '1477713770', '1477713770', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('212', '2', 'admin', '个人设置', 'fa fa-fw fa-user', 'module_admin', 'admin/index/profile', '_self', '0', '1489049767', '1489049773', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('213', '70', 'admin', '检查版本更新', '', 'module_admin', 'admin/index/checkupdate', '_self', '0', '1490588610', '1490588610', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('214', '68', 'user', '消息管理', 'fa fa-fw fa-comments-o', 'module_admin', '', '_self', '0', '1520492129', '1520492129', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('215', '214', 'user', '消息列表', 'fa fa-fw fa-th-list', 'module_admin', 'user/message/index', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('216', '215', 'user', '新增', '', 'module_admin', 'user/message/add', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('217', '215', 'user', '编辑', '', 'module_admin', 'user/message/edit', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('218', '215', 'user', '删除', '', 'module_admin', 'user/message/delete', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('219', '215', 'user', '启用', '', 'module_admin', 'user/message/enable', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('220', '215', 'user', '禁用', '', 'module_admin', 'user/message/disable', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('221', '215', 'user', '快速编辑', '', 'module_admin', 'user/message/quickedit', '_self', '0', '1520492195', '1520492195', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('222', '2', 'admin', '消息中心', 'fa fa-fw fa-comments-o', 'module_admin', 'admin/message/index', '_self', '0', '1520495992', '1520496254', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('223', '222', 'admin', '删除', '', 'module_admin', 'admin/message/delete', '_self', '0', '1520495992', '1520496263', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('224', '222', 'admin', '启用', '', 'module_admin', 'admin/message/enable', '_self', '0', '1520495992', '1520496270', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('225', '32', 'admin', '图标管理', 'fa fa-fw fa-tint', 'module_admin', 'admin/icon/index', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('226', '225', 'admin', '新增', '', 'module_admin', 'admin/icon/add', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('227', '225', 'admin', '编辑', '', 'module_admin', 'admin/icon/edit', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('228', '225', 'admin', '删除', '', 'module_admin', 'admin/icon/delete', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('229', '225', 'admin', '启用', '', 'module_admin', 'admin/icon/enable', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('230', '225', 'admin', '禁用', '', 'module_admin', 'admin/icon/disable', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('231', '225', 'admin', '快速编辑', '', 'module_admin', 'admin/icon/quickedit', '_self', '0', '1520908295', '1520908295', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('232', '225', 'admin', '图标列表', '', 'module_admin', 'admin/icon/items', '_self', '0', '1520923368', '1520923368', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('233', '225', 'admin', '更新图标', '', 'module_admin', 'admin/icon/reload', '_self', '0', '1520931908', '1520931908', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('234', '20', 'user', '快速编辑', '', 'module_admin', 'user/index/quickedit', '_self', '0', '1526028258', '1526028258', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('235', '67', 'user', '快速编辑', '', 'module_admin', 'user/role/quickedit', '_self', '0', '1526028282', '1526028282', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('243', '242', 'carwash', '商家列表', 'fa fa-fw fa-th', 'module_admin', 'carwash/seller/index', '_self', '0', '1535707911', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('242', '241', 'carwash', '商家列表', 'fa fa-fw fa-th', 'module_admin', 'carwash/seller/index', '_self', '0', '1535707886', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('241', '240', 'carwash', '商家管理', 'fa fa-fw fa-th', 'module_admin', '', '_self', '0', '1535707856', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('240', '0', 'carwash', '总平台', 'fa fa-fw fa-home', 'module_admin', 'carwash/seller/index', '_self', '0', '1535707808', '1536027133', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('244', '242', 'carwash', '新增商家', 'fa fa-fw fa-plus-square', 'module_admin', 'carwash/seller/add', '_self', '0', '1535708051', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('245', '240', 'carwash', '用户管理', 'fa fa-fw fa-user', 'module_admin', '', '_self', '0', '1535708864', '1536647307', '5', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('246', '245', 'carwash', '用户列表', 'fa fa-fw fa-align-justify', 'module_admin', 'carwash/user/index', '_self', '0', '1535709097', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('247', '242', 'carwash', '查看收款类别', 'fa fa-fw fa-eye', 'module_admin', 'carwash/seller/accounttype', '_self', '0', '1535967212', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('248', '242', 'carwash', '查看营业项目', 'fa fa-fw fa-eye', 'module_admin', 'carwash/seller/showservice', '_self', '0', '1535973682', '1536647307', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('249', '242', 'carwash', '查看商家余额', 'fa fa-fw fa-eye', 'module_admin', 'carwash/seller/showyue', '_self', '0', '1535975700', '1536647307', '5', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('253', '246', 'carwash', '导出excel', 'fa fa-fw fa-twitter', 'module_admin', 'carwash/user/userexcel', '_self', '0', '1536030157', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('250', '242', 'carwash', '查看商家服务', 'fa fa-fw fa-eye', 'module_admin', 'carwash/seller/showsellerservice', '_self', '0', '1536027045', '1536647307', '6', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('251', '245', 'carwash', '购买记录', 'fa fa-fw fa-plus-circle', 'module_admin', 'carwash/user/history', '_self', '0', '1536029787', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('252', '245', 'carwash', '查看卡种', 'fa fa-fw fa-credit-card', 'module_admin', 'carwash/user/cards', '_self', '0', '1536029954', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('254', '240', 'carwash', '评价管理', 'fa fa-fw fa-group', 'module_admin', '', '_self', '0', '1536030932', '1536647307', '6', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('255', '254', 'carwash', '评价列表', 'fa fa-fw fa-envelope', 'module_admin', 'carwash/evaluate/index', '_self', '0', '1536032338', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('256', '242', 'carwash', '编辑商家服务', 'fa fa-fw fa-pencil', 'module_admin', 'carwash/seller/editsellerservice', '_self', '0', '1536032505', '1536647307', '7', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('257', '255', 'carwash', '评论显示/隐藏', 'fa fa-fw fa-comments', 'module_admin', 'carwash/evaluate/operation', '_self', '0', '1536042589', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('258', '240', 'carwash', '广告管理', 'fa fa-fw fa-file-photo-o', 'module_admin', '', '_self', '0', '1536047348', '1536647307', '7', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('259', '258', 'carwash', '广告列表', 'fa fa-fw fa-picture-o', 'module_admin', 'carwash/advert/advlist', '_self', '0', '1536047392', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('260', '242', 'carwash', '查看商家订单', 'fa fa-fw fa-bar-chart', 'module_admin', 'carwash/seller/catsellerorder', '_self', '0', '1536047754', '1536647307', '14', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('261', '240', 'carwash', '资讯管理', 'fa fa-fw fa-qq', 'module_admin', '', '_self', '0', '1536048572', '1539673291', '8', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('262', '261', 'carwash', '咨讯分类', 'fa fa-fw fa-share-alt', 'module_admin', 'carwash/consult/index', '_self', '0', '1536048626', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('263', '261', 'carwash', '资讯列表', 'fa fa-fw fa-reorder', 'module_admin', 'carwash/consult/consulist', '_self', '0', '1536048680', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('280', '242', 'carwash', '获取首页服务名称', 'fa fa-fw fa-unlock', 'module_admin', 'carwash/seller/gethomepagecatename', '_self', '0', '1536147647', '1536647307', '12', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('265', '262', 'carwash', '增加分类', 'fa fa-fw fa-plus', 'module_admin', 'carwash/consult/add', '_self', '0', '1536053747', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('266', '242', 'carwash', '导出商家EXCEL', 'fa fa-fw fa-print', 'module_admin', 'carwash/seller/exportsellerdata', '_self', '0', '1536059969', '1536647307', '8', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('267', '242', 'carwash', '编辑商家', 'fa fa-fw fa-pencil', 'module_admin', 'carwash/seller/editseller', '_self', '0', '1536061621', '1536647307', '9', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('268', '263', 'carwash', '编辑资讯', '', 'module_admin', 'carwash/consult/editconsult', '_self', '0', '1536116424', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('269', '263', 'carwash', '新增资讯', 'fa fa-fw fa-plus', 'module_admin', 'carwash/consult/addconsult', '_self', '0', '1536135857', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('270', '242', 'carwash', '获取省份城市', 'fa fa-fw fa-unlock', 'module_admin', 'carwash/seller/getprovinces', '_self', '0', '1536135944', '1536647307', '10', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('271', '242', 'carwash', '获取首页服务', 'fa fa-fw fa-unlock', 'module_admin', 'carwash/seller/gethomepagecate', '_self', '0', '1536135982', '1536647307', '11', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('272', '258', 'carwash', '广告分类', 'fa fa-fw fa-gift', 'module_admin', 'carwash/advert/index', '_self', '0', '1536137419', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('273', '272', 'carwash', '增加分类', 'fa fa-fw fa-plus', 'module_admin', 'carwash/advert/add', '_self', '0', '1536138073', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('274', '242', 'carwash', '校验商家数据', 'fa fa-fw fa-star-half', 'module_admin', 'carwash/seller/validatedata', '_self', '0', '1536139223', '1536647307', '13', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('275', '259', 'carwash', '编辑广告', '', 'module_admin', 'carwash/advert/editadv', '_self', '0', '1536140506', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('276', '259', 'carwash', '增加广告', 'fa fa-fw fa-picture-o', 'module_admin', 'carwash/advert/addadvert', '_self', '0', '1536144289', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('277', '240', 'carwash', '订单管理', 'fa fa-fw fa-line-chart', 'module_admin', '', '_self', '0', '1536145126', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('278', '277', 'carwash', '服务订单', 'fa fa-fw fa-bar-chart', 'module_admin', 'carwash/user_order/orderrecord', '_self', '0', '1536145239', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('279', '278', 'carwash', '导出订单', 'fa fa-fw fa-print', 'module_admin', 'carwash/user_order/exportorderdata', '_self', '0', '1536145293', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('281', '242', 'carwash', '删除商家服务', 'fa fa-fw fa-remove', 'module_admin', 'carwash/seller/delsellerservice', '_self', '0', '1536148606', '1536647307', '15', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('282', '240', 'carwash', '财务管理', 'fa fa-fw fa-home', 'module_admin', '', '_self', '0', '1536202948', '1536647307', '9', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('283', '282', 'carwash', '手续费比例控制', 'fa fa-fw fa-calculator', 'module_admin', 'carwash/finance/index', '_self', '0', '1536203154', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('284', '240', 'carwash', '服务管理', 'fa fa-fw fa-medium', 'module_admin', '', '_self', '0', '1536203672', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('285', '284', 'carwash', '服务类别管理', 'fa fa-fw fa-th-large', 'module_admin', 'carwash/seller_service/showhomepagecate', '_self', '0', '1536203767', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('286', '285', 'carwash', '新增服务类别', 'fa fa-fw fa-plus-square', 'module_admin', 'carwash/seller_service/add', '_self', '0', '1536203839', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('287', '282', 'carwash', '银行卡管理', 'fa fa-fw fa-vcard-o', 'module_admin', 'carwash/finance/bankcardlist', '_self', '0', '1536205745', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('290', '282', 'carwash', '提现记录', 'fa fa-fw fa-key', 'module_admin', 'carwash/finance/finanlist', '_self', '0', '1536217015', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('288', '287', 'carwash', '编辑银行卡', 'fa fa-fw fa-calendar-o', 'module_admin', 'carwash/finance/editcard', '_self', '0', '1536215896', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('289', '287', 'carwash', '新增银行卡', 'fa fa-fw fa-plus', 'module_admin', 'carwash/finance/addcard', '_self', '0', '1536216187', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('291', '285', 'carwash', '删除首页服务类别', 'fa fa-fw fa-remove', 'module_admin', 'carwash/seller_service/delhomepagecate', '_self', '0', '1536218549', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('292', '284', 'carwash', '商家服务列表', 'fa fa-fw fa-th-large', 'module_admin', 'carwash/seller_service/sellerservicelist', '_self', '0', '1536224830', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('293', '240', 'carwash', '卡种管理', 'fa fa-fw fa-credit-card', 'module_admin', '', '_self', '0', '1536229850', '1536647307', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('294', '297', 'carwash', '新增卡种', 'fa fa-fw fa-plus-square', 'module_admin', 'carwash/platform_card/add', '_self', '0', '1536230362', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('295', '290', 'carwash', '导出提现记录', 'fa fa-fw fa-share', 'module_admin', 'carwash/finance/finanexcel', '_self', '0', '1536285843', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('296', '290', 'carwash', '驳回提现', 'fa fa-fw fa-warning', 'module_admin', 'carwash/finance/reject', '_self', '0', '1536286830', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('297', '293', 'carwash', '在售卡种', 'fa fa-fw fa-credit-card', 'module_admin', 'carwash/platform_card/onsalecard', '_self', '0', '1536290813', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('298', '297', 'carwash', '查看卡信息', 'fa fa-fw fa-eye', 'module_admin', 'carwash/platform_card/catcardinfo', '_self', '0', '1536301091', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('299', '297', 'carwash', '查看购买记录', 'fa fa-fw fa-id-card-o', 'module_admin', 'carwash/platform_card/buyhistory', '_self', '0', '1536304126', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('300', '290', 'carwash', '批量打款', 'fa fa-fw fa-plus-square', 'module_admin', 'carwash/finance/batchremit', '_self', '0', '1536306760', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('301', '293', 'carwash', '卡种列表', 'fa fa-fw fa-credit-card-alt', 'module_admin', 'carwash/platform_card/cardlist', '_self', '0', '1536309262', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('302', '240', 'carwash', '关于我们', 'fa fa-fw fa-child', 'module_admin', '', '_self', '0', '1536311620', '1536647307', '10', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('303', '302', 'carwash', '地域配置', 'fa fa-fw fa-taxi', 'module_admin', 'carwash/territory/index', '_self', '0', '1536311852', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('304', '277', 'carwash', '平台订单', 'fa fa-fw fa-pied-piper-pp', 'module_admin', 'carwash/user_order/platformlist', '_self', '0', '1536318333', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('305', '304', 'carwash', '导出平台订单', 'fa fa-fw fa-print', 'module_admin', 'carwash/user_order/exportplatformlist', '_self', '0', '1536321361', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('306', '241', 'carwash', '提现账号管理', 'fa fa-fw fa-credit-card', 'module_admin', 'carwash/seller/cashaccountlist', '_self', '0', '1536321688', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('307', '242', 'carwash', '获取所有的商家', 'fa fa-fw fa-list-ul', 'module_admin', 'carwash/seller/catallseller', '_self', '0', '1536322088', '1536647307', '16', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('308', '306', 'carwash', '新增提现账户', 'fa fa-fw fa-plus-square', 'module_admin', 'carwash/seller/addcashaccount', '_self', '0', '1536322607', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('309', '306', 'carwash', '获取开户银行', 'fa fa-fw fa-bank', 'module_admin', 'carwash/seller/bankofdeposit', '_self', '0', '1536324045', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('310', '242', 'carwash', '查询商家是否已有启用状态的账号存在', 'fa fa-fw fa-search', 'module_admin', 'carwash/seller/querycashaccountisexist', '_self', '0', '1536326485', '1536647307', '17', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('311', '306', 'carwash', '校验银行卡号', 'fa fa-fw fa-check-square-o', 'module_admin', 'carwash/seller/validatebanknum', '_self', '0', '1536546791', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('313', '306', 'carwash', '删除提现账户', 'fa fa-fw fa-remove', 'module_admin', 'carwash/seller/delcashaccount', '_self', '0', '1536551934', '1536647307', '5', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('314', '306', 'carwash', '编辑提现账号', 'fa fa-fw fa-pencil', 'module_admin', 'carwash/seller/editcashaccount', '_self', '0', '1536561285', '1536647307', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('315', '303', 'carwash', '编辑城市', 'fa fa-fw fa-adjust', 'module_admin', 'carwash/territory/editcity', '_self', '0', '1536571580', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('316', '285', 'carwash', '编辑服务类别', 'fa fa-fw fa-pencil', 'module_admin', 'carwash/seller_service/edithomepagecate', '_self', '0', '1536573270', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('317', '303', 'carwash', '新增城市', '', 'module_admin', 'carwash/territory/addcity', '_self', '0', '1536573817', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('318', '303', 'carwash', '删除城市', '', 'module_admin', 'carwash/territory/delcity', '_self', '0', '1536574967', '1536647307', '3', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('319', '303', 'carwash', '管理二级城市', '', 'module_admin', 'carwash/territory/managecity', '_self', '0', '1536631738', '1536647307', '4', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('320', '302', 'carwash', '平台客服', 'fa fa-fw fa-user', 'module_admin', 'carwash/territory/servlist', '_self', '0', '1536646359', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('321', '292', 'carwash', '删除商家服务', 'fa fa-fw fa-remove', 'module_admin', 'carwash/seller_service/delsellerservice', '_self', '0', '1536646658', '1536647307', '2', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('322', '292', 'carwash', '编辑商家服务', 'fa fa-fw fa-pencil', 'module_admin', 'carwash/seller_service/editsellerservice', '_self', '0', '1536647293', '1536647307', '1', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('323', '320', 'carwash', '客服操作', '', 'module_admin', 'carwash/territory/addeditserv', '_self', '0', '1536647606', '1536647692', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('324', '240', 'carwash', '后台管理', 'fa fa-fw fa-rocket', 'module_admin', '', '_self', '0', '1536648898', '1536648944', '-100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('325', '324', 'carwash', '后台首页', 'fa fa-fw fa-camera', 'module_admin', 'carwash/index/index', '_self', '0', '1536649104', '1536649104', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('327', '242', 'carwash', '修改店长密码', 'fa fa-fw fa-key', 'module_admin', 'carwash/seller/editshopownerpwd', '_self', '0', '1536835733', '1536835733', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('328', '302', 'carwash', '服务协议', 'fa fa-fw fa-fa', 'module_admin', 'carwash/territory/servagreement', '_self', '0', '1537151956', '1537151988', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('329', '328', 'carwash', '添加服务协议', '', 'module_admin', 'carwash/territory/operationserv', '_self', '0', '1537152340', '1537152340', '100', '0', '1', '');
INSERT INTO `dp_admin_menu` VALUES ('330', '292', 'carwash', '审核服务状态', 'fa fa-fw fa-edit', 'module_admin', 'carwash/seller_service/editservicestatus', '_self', '0', '1537327322', '1537327322', '100', '0', '1', '');

-- ----------------------------
-- Table structure for dp_admin_message
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_message`;
CREATE TABLE `dp_admin_message` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid_receive` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接收消息的用户id',
  `uid_send` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送消息的用户id',
  `type` varchar(128) NOT NULL DEFAULT '' COMMENT '消息分类',
  `content` text NOT NULL COMMENT '消息内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `read_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息表';

-- ----------------------------
-- Records of dp_admin_message
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_module
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_module`;
CREATE TABLE `dp_admin_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名称（标识）',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模块标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `description` text NOT NULL COMMENT '描述',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text COMMENT '配置信息',
  `access` text COMMENT '授权配置',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '模块唯一标识符',
  `system_module` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统模块',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='模块表';

-- ----------------------------
-- Records of dp_admin_module
-- ----------------------------
INSERT INTO `dp_admin_module` VALUES ('1', 'admin', '系统', 'fa fa-fw fa-gear', '系统模块，DolphinPHP的核心模块', 'DolphinPHP', 'http://www.dolphinphp.com', '', '', '1.0.0', 'admin.dolphinphp.module', '1', '1468204902', '1468204902', '100', '1');
INSERT INTO `dp_admin_module` VALUES ('2', 'user', '用户', 'fa fa-fw fa-user', '用户模块，DolphinPHP自带模块', 'DolphinPHP', 'http://www.dolphinphp.com', '', '', '1.0.0', 'user.dolphinphp.module', '1', '1468204902', '1468204902', '100', '1');
INSERT INTO `dp_admin_module` VALUES ('4', 'carwash', '总平台', '', '总平台模块', 'ywdeng', '', '', '', '1.0.0', 'carwash.deng.module', '0', '1535707435', '1535707477', '100', '1');

-- ----------------------------
-- Table structure for dp_admin_packet
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_packet`;
CREATE TABLE `dp_admin_packet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '数据包名',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '数据包标题',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者url',
  `version` varchar(16) NOT NULL,
  `tables` text NOT NULL COMMENT '数据表名',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据包表';

-- ----------------------------
-- Records of dp_admin_packet
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_pictures
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_pictures`;
CREATE TABLE `dp_admin_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '对应主表图片ID',
  `path` varchar(255) NOT NULL DEFAULT '0' COMMENT '图片路径',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '图片处理方式 2补白,3截取,6压缩',
  `size` int(11) NOT NULL DEFAULT '0',
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1 COMMENT='上传图片副表';

-- ----------------------------
-- Records of dp_admin_pictures
-- ----------------------------
INSERT INTO `dp_admin_pictures` VALUES ('62', '1', 'upload/cut/100/100_crop_690_300_f232b4d7928d42e83208e7cbed4e5b3e.jpg', '3', '100', '690', '300', '1536029391');
INSERT INTO `dp_admin_pictures` VALUES ('63', '1', 'upload/cut/50/50_crop_690_300_f232b4d7928d42e83208e7cbed4e5b3e.jpg', '3', '50', '690', '300', '1536029391');
INSERT INTO `dp_admin_pictures` VALUES ('64', '1', 'upload/cut/10/10_crop_690_300_f232b4d7928d42e83208e7cbed4e5b3e.jpg', '3', '10', '690', '300', '1536029391');
INSERT INTO `dp_admin_pictures` VALUES ('65', '1', 'upload/cut/100/100_thumb_690_300_f232b4d7928d42e83208e7cbed4e5b3e.jpg', '6', '100', '690', '300', '1536634191');
INSERT INTO `dp_admin_pictures` VALUES ('66', '1', 'upload/cut/50/50_thumb_690_300_f232b4d7928d42e83208e7cbed4e5b3e.jpg', '6', '50', '690', '300', '1536634191');
INSERT INTO `dp_admin_pictures` VALUES ('67', '1', 'upload/cut/10/10_thumb_690_300_f232b4d7928d42e83208e7cbed4e5b3e.jpg', '6', '10', '690', '300', '1536634191');
INSERT INTO `dp_admin_pictures` VALUES ('68', '93', 'upload/cut/100/100_write_690_300_3f547f4deb34e07b6fdc29d151f13f13.jpg', '2', '100', '690', '300', '1538992456');
INSERT INTO `dp_admin_pictures` VALUES ('69', '93', 'upload/cut/50/50_write_690_300_3f547f4deb34e07b6fdc29d151f13f13.jpg', '2', '50', '690', '300', '1538992456');
INSERT INTO `dp_admin_pictures` VALUES ('70', '93', 'upload/cut/10/10_write_690_300_3f547f4deb34e07b6fdc29d151f13f13.jpg', '2', '10', '690', '300', '1538992456');
INSERT INTO `dp_admin_pictures` VALUES ('71', '36', 'upload/cut/100/100_thumb_690_300_demo.jpg', '6', '100', '690', '300', '1538992576');
INSERT INTO `dp_admin_pictures` VALUES ('72', '36', 'upload/cut/50/50_thumb_690_300_demo.jpg', '6', '50', '690', '300', '1538992576');
INSERT INTO `dp_admin_pictures` VALUES ('73', '36', 'upload/cut/10/10_thumb_690_300_demo.jpg', '6', '10', '690', '300', '1538992576');
INSERT INTO `dp_admin_pictures` VALUES ('74', '93', 'upload/cut/100/100_crop_690_300_3f547f4deb34e07b6fdc29d151f13f13.jpg', '3', '100', '690', '300', '1538992845');
INSERT INTO `dp_admin_pictures` VALUES ('75', '93', 'upload/cut/50/50_crop_690_300_3f547f4deb34e07b6fdc29d151f13f13.jpg', '3', '50', '690', '300', '1538992845');
INSERT INTO `dp_admin_pictures` VALUES ('76', '93', 'upload/cut/10/10_crop_690_300_3f547f4deb34e07b6fdc29d151f13f13.jpg', '3', '10', '690', '300', '1538992845');
INSERT INTO `dp_admin_pictures` VALUES ('77', '94', 'upload/cut/100/100_write_690_300_2f965f36506795e96e0b6e995a3f7cca.jpg', '2', '100', '690', '300', '1538993188');
INSERT INTO `dp_admin_pictures` VALUES ('78', '94', 'upload/cut/50/50_write_690_300_2f965f36506795e96e0b6e995a3f7cca.jpg', '2', '50', '690', '300', '1538993188');
INSERT INTO `dp_admin_pictures` VALUES ('79', '94', 'upload/cut/10/10_write_690_300_2f965f36506795e96e0b6e995a3f7cca.jpg', '2', '10', '690', '300', '1538993188');
INSERT INTO `dp_admin_pictures` VALUES ('80', '94', 'upload/cut/100/100_crop_690_300_2f965f36506795e96e0b6e995a3f7cca.jpg', '3', '100', '690', '300', '1538993209');
INSERT INTO `dp_admin_pictures` VALUES ('81', '94', 'upload/cut/50/50_crop_690_300_2f965f36506795e96e0b6e995a3f7cca.jpg', '3', '50', '690', '300', '1538993209');
INSERT INTO `dp_admin_pictures` VALUES ('82', '94', 'upload/cut/10/10_crop_690_300_2f965f36506795e96e0b6e995a3f7cca.jpg', '3', '10', '690', '300', '1538993209');
INSERT INTO `dp_admin_pictures` VALUES ('83', '95', 'upload/cut/100/100_crop_690_300_151f4979a87583e1cc6a9eaf5f77ec3a.jpg', '3', '100', '690', '300', '1538993225');
INSERT INTO `dp_admin_pictures` VALUES ('84', '95', 'upload/cut/50/50_crop_690_300_151f4979a87583e1cc6a9eaf5f77ec3a.jpg', '3', '50', '690', '300', '1538993225');
INSERT INTO `dp_admin_pictures` VALUES ('85', '95', 'upload/cut/10/10_crop_690_300_151f4979a87583e1cc6a9eaf5f77ec3a.jpg', '3', '10', '690', '300', '1538993225');
INSERT INTO `dp_admin_pictures` VALUES ('86', '96', 'upload/cut/100/100_write_690_300_e212234c6bf777c197717943d27686e6.jpg', '2', '100', '690', '300', '1539050875');
INSERT INTO `dp_admin_pictures` VALUES ('87', '96', 'upload/cut/50/50_write_690_300_e212234c6bf777c197717943d27686e6.jpg', '2', '50', '690', '300', '1539050875');
INSERT INTO `dp_admin_pictures` VALUES ('88', '96', 'upload/cut/10/10_write_690_300_e212234c6bf777c197717943d27686e6.jpg', '2', '10', '690', '300', '1539050875');
INSERT INTO `dp_admin_pictures` VALUES ('89', '106', 'upload/cut/100/100_thumb_690_300_fe0896024a4329258036e3800980df25.jpg', '6', '100', '690', '300', '1539053422');
INSERT INTO `dp_admin_pictures` VALUES ('90', '106', 'upload/cut/50/50_thumb_690_300_fe0896024a4329258036e3800980df25.jpg', '6', '50', '690', '300', '1539053422');
INSERT INTO `dp_admin_pictures` VALUES ('91', '106', 'upload/cut/10/10_thumb_690_300_fe0896024a4329258036e3800980df25.jpg', '6', '10', '690', '300', '1539053422');
INSERT INTO `dp_admin_pictures` VALUES ('92', '111', 'upload/cut/100/100_thumb_690_300_e0f3979a3b6167ee48a734708d132c1f.jpg', '6', '100', '690', '300', '1539054201');
INSERT INTO `dp_admin_pictures` VALUES ('93', '111', 'upload/cut/50/50_thumb_690_300_e0f3979a3b6167ee48a734708d132c1f.jpg', '6', '50', '690', '300', '1539054201');
INSERT INTO `dp_admin_pictures` VALUES ('94', '111', 'upload/cut/10/10_thumb_690_300_e0f3979a3b6167ee48a734708d132c1f.jpg', '6', '10', '690', '300', '1539054201');
INSERT INTO `dp_admin_pictures` VALUES ('95', '112', 'upload/cut/100/100_thumb_690_300_996bd450436d9d86c1905b31cdb79c6b.jpg', '6', '100', '690', '300', '1539054337');
INSERT INTO `dp_admin_pictures` VALUES ('96', '112', 'upload/cut/50/50_thumb_690_300_996bd450436d9d86c1905b31cdb79c6b.jpg', '6', '50', '690', '300', '1539054337');
INSERT INTO `dp_admin_pictures` VALUES ('97', '112', 'upload/cut/10/10_thumb_690_300_996bd450436d9d86c1905b31cdb79c6b.jpg', '6', '10', '690', '300', '1539054337');
INSERT INTO `dp_admin_pictures` VALUES ('98', '117', 'upload/cut/100/100_thumb_690_300_fa1d225d4e1ce033ffd18eed90dc1815.jpg', '6', '100', '690', '300', '1539167797');
INSERT INTO `dp_admin_pictures` VALUES ('99', '117', 'upload/cut/50/50_thumb_690_300_fa1d225d4e1ce033ffd18eed90dc1815.jpg', '6', '50', '690', '300', '1539167797');
INSERT INTO `dp_admin_pictures` VALUES ('100', '117', 'upload/cut/100/100_thumb_690_300_996bd450436d9d86c1905b31cdb79c6b.jpg', '6', '10', '690', '300', '1539167797');
INSERT INTO `dp_admin_pictures` VALUES ('101', '119', 'upload/cut/100/100_thumb_690_300_2eeb578b562c2db2a0ff277b61fdf9dd.jpg', '6', '100', '690', '300', '1539229425');
INSERT INTO `dp_admin_pictures` VALUES ('102', '120', 'upload/cut/100/100_thumb_690_300_eb5ae04b9afc1795faf226fa7ffbc1c7.jpg', '6', '100', '690', '300', '1539229452');
INSERT INTO `dp_admin_pictures` VALUES ('103', '122', 'upload/cut/100/100_thumb_690_300_34b35a932061b539bc078f2ef1ac4c12.jpg', '6', '100', '690', '300', '1539230152');
INSERT INTO `dp_admin_pictures` VALUES ('104', '125', 'upload/cut/100/100_thumb_690_300_8c1f1e0b76213af167a9bc3f3ae17e83.jpg', '6', '100', '690', '300', '1539244899');
INSERT INTO `dp_admin_pictures` VALUES ('105', '126', 'upload/cut/100/100_thumb_690_300_acafd86c65647004a6466691f710d289.jpg', '6', '100', '690', '300', '1539244899');
INSERT INTO `dp_admin_pictures` VALUES ('106', '128', 'upload/cut/100/100_thumb_690_300_3119a1934fecc1629e217c07ff5de324.jpg', '6', '100', '690', '300', '1539246875');
INSERT INTO `dp_admin_pictures` VALUES ('107', '128', 'upload/cut/100/100_write_690_300_3119a1934fecc1629e217c07ff5de324.jpg', '2', '100', '690', '300', '1539247655');
INSERT INTO `dp_admin_pictures` VALUES ('108', '129', 'upload/cut/100/100_thumb_200_200_a6ec7b1cc7d765ae55e1f10cf3ca8b0b.jpg', '6', '100', '200', '200', '1539325955');
INSERT INTO `dp_admin_pictures` VALUES ('109', '130', 'upload/cut/100/100_thumb_200_200_6a3cc6731d4ef76b8946680bfb2a02d8.jpg', '6', '100', '200', '200', '1539326068');
INSERT INTO `dp_admin_pictures` VALUES ('110', '132', 'upload/cut/100/100_thumb_200_200_8fbdd357c2d40a44e015324d4fd63601.jpg', '6', '100', '200', '200', '1539327505');
INSERT INTO `dp_admin_pictures` VALUES ('111', '133', 'upload/cut/100/100_thumb_200_200_2bec165edf929a28ea029b9aacd907a9.jpg', '6', '100', '200', '200', '1539327975');
INSERT INTO `dp_admin_pictures` VALUES ('112', '106', 'upload/cut/100/100_write_200_200_fe0896024a4329258036e3800980df25.jpg', '2', '100', '200', '200', '1539328528');
INSERT INTO `dp_admin_pictures` VALUES ('113', '135', 'upload/cut/100/100_thumb_200_200_db427c806d812c3da3d771b338085153.png', '6', '100', '200', '200', '1539328528');
INSERT INTO `dp_admin_pictures` VALUES ('114', '134', 'upload/cut/100/100_thumb_200_200_9a2e3f69994933275e2a063ee8364bb1.jpg', '6', '100', '200', '200', '1539334091');
INSERT INTO `dp_admin_pictures` VALUES ('115', '136', 'upload/cut/100/100_thumb_200_200_0273f1396bb1c0de74458ef9148319d5.png', '6', '100', '200', '200', '1539334455');
INSERT INTO `dp_admin_pictures` VALUES ('116', '137', 'upload/cut/100/100_thumb_200_200_11cd968c59f44ad3f845d948a98b870d.jpg', '6', '100', '200', '200', '1539335944');
INSERT INTO `dp_admin_pictures` VALUES ('117', '125', 'upload/cut/100/100_write_200_200_8c1f1e0b76213af167a9bc3f3ae17e83.jpg', '2', '100', '200', '200', '1539336151');
INSERT INTO `dp_admin_pictures` VALUES ('118', '106', 'upload/cut/100/100_thumb_200_200_fe0896024a4329258036e3800980df25.jpg', '6', '100', '200', '200', '1539336736');
INSERT INTO `dp_admin_pictures` VALUES ('119', '125', 'upload/cut/100/100_thumb_200_200_8c1f1e0b76213af167a9bc3f3ae17e83.jpg', '6', '100', '200', '200', '1539336736');
INSERT INTO `dp_admin_pictures` VALUES ('120', '138', 'upload/cut/100/100_thumb_200_200_1e7d00551d542ab947234c3831f00950.png', '6', '100', '200', '200', '1539336737');
INSERT INTO `dp_admin_pictures` VALUES ('121', '131', 'upload/cut/100/100_thumb_200_200_31158ea1aeb77f5cee7c280af95ae826.jpg', '6', '100', '200', '200', '1539337143');
INSERT INTO `dp_admin_pictures` VALUES ('122', '139', 'upload/cut/100/100_thumb_200_200_d81fbee874421ce9665f97cff14b610c.jpg', '6', '100', '200', '200', '1539337313');

-- ----------------------------
-- Table structure for dp_admin_plugin
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_plugin`;
CREATE TABLE `dp_admin_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '插件名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '插件标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `description` text NOT NULL COMMENT '插件描述',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text NOT NULL COMMENT '配置信息',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '插件唯一标识符',
  `admin` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台管理',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of dp_admin_plugin
-- ----------------------------
INSERT INTO `dp_admin_plugin` VALUES ('1', 'SystemInfo', '系统环境信息', 'fa fa-fw fa-info-circle', '在后台首页显示服务器信息', '蔡伟明', 'http://www.caiweiming.com', '{\"display\":\"1\",\"width\":\"6\"}', '1.0.0', 'system_info.ming.plugin', '0', '1477757503', '1477757503', '100', '1');
INSERT INTO `dp_admin_plugin` VALUES ('2', 'DevTeam', '开发团队成员信息', 'fa fa-fw fa-users', '开发团队成员信息', '蔡伟明', 'http://www.caiweiming.com', '{\"display\":\"1\",\"width\":\"6\"}', '1.0.0', 'dev_team.ming.plugin', '0', '1477755780', '1477755780', '100', '1');

-- ----------------------------
-- Table structure for dp_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_role`;
CREATE TABLE `dp_admin_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级角色',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '角色描述',
  `menu_auth` text NOT NULL COMMENT '菜单权限',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `access` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否可登录后台',
  `default_module` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '默认访问模块',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of dp_admin_role
-- ----------------------------
INSERT INTO `dp_admin_role` VALUES ('1', '0', '超级管理员', '系统默认创建的角色，拥有最高权限', '', '0', '1476270000', '1468117612', '1', '1', '0');

-- ----------------------------
-- Table structure for dp_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_user`;
CREATE TABLE `dp_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(96) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `email_bind` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否绑定邮箱地址',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `mobile_bind` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否绑定手机号码',
  `avatar` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '头像',
  `money` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `role` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `group` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '部门id',
  `signup_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '注册ip',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  `last_login_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '登录ip',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of dp_admin_user
-- ----------------------------
INSERT INTO `dp_admin_user` VALUES ('1', 'admin', '超级管理员', '$2y$10$Brw6wmuSLIIx3Yabid8/Wu5l8VQ9M/H/CG3C9RqN9dUCwZW3ljGOK', '', '0', '', '0', '0', '0.00', '0', '1', '0', '0', '1476065410', '1539673157', '1539673157', '3232235584', '100', '1');

-- ----------------------------
-- Table structure for dp_bank_card
-- ----------------------------
DROP TABLE IF EXISTS `dp_bank_card`;
CREATE TABLE `dp_bank_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '银行名称',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '银行标识icon',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '银行卡背景图',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0禁用,1启用',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除0不删,1删',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_bank_card
-- ----------------------------
INSERT INTO `dp_bank_card` VALUES ('1', '工商银行', '197', '199', '1', '1536214520', '1539673587', '0');
INSERT INTO `dp_bank_card` VALUES ('2', '建设银行', '146', '150', '1', '1536214520', '1539590623', '0');
INSERT INTO `dp_bank_card` VALUES ('3', '农业银行', '147', '151', '1', '1536216670', '1539590637', '0');
INSERT INTO `dp_bank_card` VALUES ('4', '中国银行', '148', '152', '1', '1536216733', '1539590649', '0');
INSERT INTO `dp_bank_card` VALUES ('5', '重庆银行', '', '145', '1', '1536216851', '1539586583', '1');

-- ----------------------------
-- Table structure for dp_cash_account
-- ----------------------------
DROP TABLE IF EXISTS `dp_cash_account`;
CREATE TABLE `dp_cash_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家账号提现表id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `account_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '账号类别,1支付宝,2微信,3银行卡',
  `account` varchar(50) NOT NULL DEFAULT '' COMMENT '账号',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `account_name` varchar(17) NOT NULL DEFAULT '' COMMENT '持卡人姓名',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `bank` varchar(255) NOT NULL COMMENT '开户行',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0禁用,1启用)',
  `bank_card_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开户行id',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除,0不删除,1删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_cash_account
-- ----------------------------
INSERT INTO `dp_cash_account` VALUES ('1', '1', '1', '1274124881@qq.com', '15878945612', 'ali', '1536551302', '', '1', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('2', '1', '2', '15802343884', '15878945612', 'weixin', '1536551338', '', '1', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('3', '1', '3', '6230664831010409342', '15123363369', 'bank', '1536563564', '', '1', '1', '500268199807087564', '0');
INSERT INTO `dp_cash_account` VALUES ('4', '2', '1', '15123363368', '15123363368', '陈鑫', '0', '', '0', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('5', '2', '2', '15123363369', '15123363369', '陈鑫', '1537253452', '', '0', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('6', '3', '1', '15123363369', '15123363369', '陈鑫想', '1537272341', '', '0', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('7', '3', '3', '15123363369', '15123363369', '陈鑫想', '1537272413', '', '0', '2', '500231199602233173', '0');
INSERT INTO `dp_cash_account` VALUES ('8', '20', '3', '6452542452452452452', '15888888888', '彭林', '1537334113', '', '0', '4', '500238199010111337', '0');
INSERT INTO `dp_cash_account` VALUES ('9', '20', '2', '54545254', '15255555555', '彭林', '1537334262', '', '0', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('10', '20', '1', '444544', '15844444444', '陈鑫', '1537334295', '', '0', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('11', '24', '1', '111222', '18738277443', '刘亚东', '1537865610', '', '0', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('12', '24', '2', '啦啦啦123', '18738277443', '刘亚东', '1537867177', '', '0', '0', '', '0');
INSERT INTO `dp_cash_account` VALUES ('14', '24', '3', '6217002463695875662', '18738277443', '刘亚东', '1537867808', '', '0', '1', '410527199202100179', '0');

-- ----------------------------
-- Table structure for dp_cash_scale
-- ----------------------------
DROP TABLE IF EXISTS `dp_cash_scale`;
CREATE TABLE `dp_cash_scale` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '提现比例',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现手续费比例',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_cash_scale
-- ----------------------------
INSERT INTO `dp_cash_scale` VALUES ('2', '100.00', '1.00', '1536205411');

-- ----------------------------
-- Table structure for dp_collect
-- ----------------------------
DROP TABLE IF EXISTS `dp_collect`;
CREATE TABLE `dp_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '收藏时间',
  `is_remove` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否移除,0移除,1移除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_collect
-- ----------------------------
INSERT INTO `dp_collect` VALUES ('1', '1', '1', '0', '1');
INSERT INTO `dp_collect` VALUES ('2', '1', '2', '0', '1');
INSERT INTO `dp_collect` VALUES ('3', '3', '1', '1537964702', '0');
INSERT INTO `dp_collect` VALUES ('4', '1', '30', '1538036339', '1');
INSERT INTO `dp_collect` VALUES ('5', '1', '29', '1538036382', '1');
INSERT INTO `dp_collect` VALUES ('6', '1', '26', '1538108939', '1');
INSERT INTO `dp_collect` VALUES ('7', '1', '23', '1538108947', '1');
INSERT INTO `dp_collect` VALUES ('8', '1', '27', '1538109918', '0');
INSERT INTO `dp_collect` VALUES ('9', '1', '11', '1538110169', '0');
INSERT INTO `dp_collect` VALUES ('10', '1', '19', '1538111110', '0');
INSERT INTO `dp_collect` VALUES ('11', '5', '11', '1538300978', '0');
INSERT INTO `dp_collect` VALUES ('12', '5', '1', '1538300980', '0');
INSERT INTO `dp_collect` VALUES ('13', '5', '30', '1538300982', '0');
INSERT INTO `dp_collect` VALUES ('14', '5', '29', '1538300984', '0');
INSERT INTO `dp_collect` VALUES ('15', '5', '27', '1538300986', '0');
INSERT INTO `dp_collect` VALUES ('16', '5', '26', '1538300989', '0');
INSERT INTO `dp_collect` VALUES ('17', '5', '23', '1538300994', '0');
INSERT INTO `dp_collect` VALUES ('18', '5', '22', '1538300997', '0');
INSERT INTO `dp_collect` VALUES ('19', '5', '18', '1538301000', '0');
INSERT INTO `dp_collect` VALUES ('20', '6', '1', '1539065474', '0');
INSERT INTO `dp_collect` VALUES ('21', '6', '11', '1539067287', '0');
INSERT INTO `dp_collect` VALUES ('22', '6', '2', '1539067960', '0');
INSERT INTO `dp_collect` VALUES ('23', '5', '34', '1539314303', '0');

-- ----------------------------
-- Table structure for dp_comment
-- ----------------------------
DROP TABLE IF EXISTS `dp_comment`;
CREATE TABLE `dp_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `user_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户订单id',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `seller_service_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家服务id',
  `comment_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '评价类型,1差评,2一般,3好评',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评价内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评价时间',
  `is_release` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态,0显示,1屏蔽',
  `seller_reply_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家回复表id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_comment
-- ----------------------------
INSERT INTO `dp_comment` VALUES ('1', '1', '1', '1', '15123363369', '1', '3', '洗车洗得很好', '1535940814', '1', '32');
INSERT INTO `dp_comment` VALUES ('2', '2', '1', '2', '15123363368', '1', '3', '评价', '1535940814', '0', '26');
INSERT INTO `dp_comment` VALUES ('3', '1', '1', '3', '15123363369', '2', '1', '哈哈,真垃圾', '1538036561', '0', '25');
INSERT INTO `dp_comment` VALUES ('4', '1', '1', '3', '15123363369', '2', '1', '哈哈,真垃圾', '1538037169', '0', '25');
INSERT INTO `dp_comment` VALUES ('5', '1', '1', '1', '15123363369', '1', '3', '洗车不错', '1538124421', '0', '32');
INSERT INTO `dp_comment` VALUES ('6', '1', '1', '3', '15123363369', '2', '2', '我的', '1538124547', '0', '25');
INSERT INTO `dp_comment` VALUES ('7', '1', '1', '3', '15123363369', '2', '2', '我婆且行且珍惜', '1538124619', '0', '25');
INSERT INTO `dp_comment` VALUES ('8', '1', '1', '3', '15123363369', '2', '2', '一这破这是我朋友', '1538124749', '0', '25');
INSERT INTO `dp_comment` VALUES ('9', '1', '1', '3', '15123363369', '2', '2', '鱼香婆婆谢谢宋', '1538125100', '0', '25');
INSERT INTO `dp_comment` VALUES ('10', '1', '20', '4', '15123363369', '1', '2', '又送王孙去', '1538205759', '0', '0');
INSERT INTO `dp_comment` VALUES ('11', '1', '20', '14', '15123363369', '9', '2', '我肚痛', '1538225763', '0', '0');
INSERT INTO `dp_comment` VALUES ('12', '1', '20', '15', '15123363369', '9', '2', '唯我独尊在一起', '1538226011', '0', '0');
INSERT INTO `dp_comment` VALUES ('13', '6', '1', '73', '13996379929', '2', '1', '民警中', '1538295622', '0', '0');
INSERT INTO `dp_comment` VALUES ('14', '5', '20', '75', '17708323304', '9', '2', '我现在', '1538302113', '0', '0');
INSERT INTO `dp_comment` VALUES ('15', '5', '20', '75', '17708323304', '9', '2', '我现在', '1538302120', '0', '0');
INSERT INTO `dp_comment` VALUES ('16', '1', '20', '16', '15123363369', '9', '3', '太好了太好了太好了', '1539078535', '0', '0');
INSERT INTO `dp_comment` VALUES ('17', '1', '20', '18', '15123363369', '9', '3', '真的太好了', '1539079353', '0', '0');
INSERT INTO `dp_comment` VALUES ('18', '1', '20', '17', '15123363369', '9', '3', '点', '1539079533', '0', '0');
INSERT INTO `dp_comment` VALUES ('19', '6', '20', '80', '13996379929', '9', '3', '不错', '1539143374', '0', '33');

-- ----------------------------
-- Table structure for dp_contactus
-- ----------------------------
DROP TABLE IF EXISTS `dp_contactus`;
CREATE TABLE `dp_contactus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '联系我们id',
  `phone` char(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0不启用,1启用',
  `is_delete` tinyint(1) NOT NULL COMMENT '是否删除0不删,1删',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_contactus
-- ----------------------------
INSERT INTO `dp_contactus` VALUES ('1', '15123363369', '1536646495', '陈鑫', '1', '1');
INSERT INTO `dp_contactus` VALUES ('2', '15123363368', '1536648118', '盲僧', '1', '1');
INSERT INTO `dp_contactus` VALUES ('3', '123456', '1536648474', '测试', '0', '1');
INSERT INTO `dp_contactus` VALUES ('4', '15123363369', '1536648802', '测试', '1', '0');

-- ----------------------------
-- Table structure for dp_homepage_area
-- ----------------------------
DROP TABLE IF EXISTS `dp_homepage_area`;
CREATE TABLE `dp_homepage_area` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '首页地域id',
  `area_code` varchar(11) NOT NULL DEFAULT '0' COMMENT '地区区号',
  `pinyin` char(1) NOT NULL DEFAULT '' COMMENT '地域名首位拼音',
  `areaname` varchar(50) NOT NULL DEFAULT '' COMMENT '地域名称',
  `create_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区域父级id',
  `area_path` varchar(100) NOT NULL DEFAULT '' COMMENT '区域分类路径',
  `is_release` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用,0表示不启用,1表示启用',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除,0表示不删除,1表示删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_homepage_area
-- ----------------------------
INSERT INTO `dp_homepage_area` VALUES ('15', '500000', 'Z', '重庆', '1536734580', '0', '', '1', '0');
INSERT INTO `dp_homepage_area` VALUES ('16', '500103', 'Y', '渝中区', '1536734589', '15', '', '1', '0');
INSERT INTO `dp_homepage_area` VALUES ('17', '510000', 'S', '四川省', '1536734604', '0', '', '1', '0');
INSERT INTO `dp_homepage_area` VALUES ('18', '510100', 'C', '成都市', '1536734613', '17', '', '1', '0');

-- ----------------------------
-- Table structure for dp_homepage_carousel
-- ----------------------------
DROP TABLE IF EXISTS `dp_homepage_carousel`;
CREATE TABLE `dp_homepage_carousel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `homepage_carouselcate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '轮播分类id',
  `adname` varchar(255) NOT NULL DEFAULT '' COMMENT '轮播名称',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '轮播图片',
  `order_num` int(11) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `linkurl` varchar(200) NOT NULL DEFAULT '' COMMENT '跳转链接',
  `location` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '图片位置,1商家端,2用户端',
  `link_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '链接方式,0内联,1外联',
  `expire_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '有效时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除,0表示不删除,1表示删除',
  `is_release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用,0表示不启用,1表示启用',
  `url_dev` varchar(255) NOT NULL COMMENT '链接名称描述',
  `dev` varchar(255) NOT NULL COMMENT '描述信息',
  `android_path` varchar(255) NOT NULL COMMENT '安卓path链接',
  `ios_path` varchar(255) NOT NULL COMMENT '苹果path链接',
  `type` varchar(50) NOT NULL COMMENT '[''shop'' => ''商家信息'', ''serve'' => ''服务信息'', ''join'' => ''商家入驻'', ''card'' => ''卡包中心'']',
  `info_id` int(11) NOT NULL COMMENT '内联信息id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_homepage_carousel
-- ----------------------------
INSERT INTO `dp_homepage_carousel` VALUES ('10', '1', '首页图片1', '36', '0', 'https://www.baidu.com', '2', '1', '0', '1537863036', '0', '1', '', '', '', '', 'web', '0');
INSERT INTO `dp_homepage_carousel` VALUES ('11', '1', '首页图片2', '36', '0', '', '2', '0', '0', '1537864121', '0', '1', '', '', 'anroid', 'ios', 'shop', '1');
INSERT INTO `dp_homepage_carousel` VALUES ('12', '1', '卡包的跳转', '36', '0', '', '2', '0', '0', '1538211966', '0', '1', '', '', '', '', 'card', '2');
INSERT INTO `dp_homepage_carousel` VALUES ('13', '1', '图片插件测试', '96', '1', 'http://www.baidu.com', '2', '1', '0', '1539050931', '1', '1', '', '', '', '', 'web', '0');
INSERT INTO `dp_homepage_carousel` VALUES ('14', '1', 'ces', '111', '0', '', '2', '1', '0', '1539054206', '1', '1', '', '', '', '', 'web', '0');
INSERT INTO `dp_homepage_carousel` VALUES ('15', '1', 'ces', '112', '0', '', '2', '1', '0', '1539054342', '0', '1', '', '', '', '', 'web', '0');
INSERT INTO `dp_homepage_carousel` VALUES ('16', '1', '新插件测试', '195', '0', '', '2', '1', '0', '1539598919', '0', '1', '', '', '', '', 'web', '0');

-- ----------------------------
-- Table structure for dp_homepage_carouselcate
-- ----------------------------
DROP TABLE IF EXISTS `dp_homepage_carouselcate`;
CREATE TABLE `dp_homepage_carouselcate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `order_num` int(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `is_rease` tinyint(1) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_homepage_carouselcate
-- ----------------------------
INSERT INTO `dp_homepage_carouselcate` VALUES ('1', '用户端轮播图', '0', '1537862251', '1', '0');

-- ----------------------------
-- Table structure for dp_homepage_cate
-- ----------------------------
DROP TABLE IF EXISTS `dp_homepage_cate`;
CREATE TABLE `dp_homepage_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catename` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类父级id',
  `path` varchar(50) NOT NULL DEFAULT '0' COMMENT '分类路径',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '类别图片',
  `order_num` int(11) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用,0表示不启用,1表示启用',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除,0表示不删除,1表示删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_homepage_cate
-- ----------------------------
INSERT INTO `dp_homepage_cate` VALUES ('1', '洗车', '0', '0', '185', '100', '1536216084', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('2', '打蜡', '0', '0', '171', '100', '1536216084', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('3', '封釉', '0', '0', '175', '100', '1536216084', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('4', '抛光', '0', '0', '177', '100', '1536566437', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('5', '抛光的二级分类', '4', '0,4', '179', '100', '1536566532', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('6', '精洗', '1', '0,1', '161', '100', '1536633400', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('7', '打蜡的二级', '2', '0,2', '173', '100', '1536633434', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('8', '彩绘', '0', '0', '181', '100', '1536657099', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('9', '测试顶级分类的二级分类', '8', '0,8', '183', '100', '1536657177', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('10', '贴膜', '0', '0', '163', '100', '1536819974', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('11', '维修', '0', '0', '165', '100', '1536819974', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('12', '美容', '0', '0', '167', '100', '1536819974', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('13', '镀膜', '0', '0', '169', '100', '1536819974', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('14', '测试图片插件', '0', '0', '157', '100', '1539337148', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('15', '除尘', '0', '0', '155', '100', '1539595496', '1', '0');
INSERT INTO `dp_homepage_cate` VALUES ('16', '翻新', '0', '0', '155', '100', '1539597773', '1', '0');

-- ----------------------------
-- Table structure for dp_hotsearch
-- ----------------------------
DROP TABLE IF EXISTS `dp_hotsearch`;
CREATE TABLE `dp_hotsearch` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '热搜表id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `keywords` text NOT NULL COMMENT '关键字',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '搜索时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_hotsearch
-- ----------------------------
INSERT INTO `dp_hotsearch` VALUES ('4', '2', '陈奕迅', '0');
INSERT INTO `dp_hotsearch` VALUES ('5', '2', '李宗盛', '0');
INSERT INTO `dp_hotsearch` VALUES ('6', '2', '李宗盛', '0');
INSERT INTO `dp_hotsearch` VALUES ('7', '2', '李宗盛', '0');
INSERT INTO `dp_hotsearch` VALUES ('59', '1', '江北', '1538967579');
INSERT INTO `dp_hotsearch` VALUES ('68', '6', '陈奕迅', '1539065927');
INSERT INTO `dp_hotsearch` VALUES ('69', '6', '江北', '1539067157');
INSERT INTO `dp_hotsearch` VALUES ('70', '6', '陈奕迅', '1539068342');
INSERT INTO `dp_hotsearch` VALUES ('71', '6', '江北', '1539224043');
INSERT INTO `dp_hotsearch` VALUES ('72', '6', '江北', '1539225905');
INSERT INTO `dp_hotsearch` VALUES ('73', '1', '江北', '1539227054');
INSERT INTO `dp_hotsearch` VALUES ('74', '1', '江北', '1539227131');
INSERT INTO `dp_hotsearch` VALUES ('75', '1', '江北', '1539227175');
INSERT INTO `dp_hotsearch` VALUES ('76', '1', '江北', '1539228400');
INSERT INTO `dp_hotsearch` VALUES ('77', '1', '江北', '1539228414');
INSERT INTO `dp_hotsearch` VALUES ('78', '1', '江北', '1539228555');
INSERT INTO `dp_hotsearch` VALUES ('79', '6', '江北', '1539233504');
INSERT INTO `dp_hotsearch` VALUES ('80', '6', '江北', '1539233633');
INSERT INTO `dp_hotsearch` VALUES ('81', '6', '江北', '1539233684');
INSERT INTO `dp_hotsearch` VALUES ('82', '6', '江北', '1539233706');
INSERT INTO `dp_hotsearch` VALUES ('83', '6', '江北', '1539233710');
INSERT INTO `dp_hotsearch` VALUES ('84', '0', '测', '1539242716');
INSERT INTO `dp_hotsearch` VALUES ('85', '0', '测', '1539242723');
INSERT INTO `dp_hotsearch` VALUES ('86', '0', '测', '1539242840');
INSERT INTO `dp_hotsearch` VALUES ('87', '0', '江', '1539243298');
INSERT INTO `dp_hotsearch` VALUES ('88', '6', '江', '1539243338');
INSERT INTO `dp_hotsearch` VALUES ('91', '6', '江', '1539244617');
INSERT INTO `dp_hotsearch` VALUES ('93', '6', '江', '1539327334');
INSERT INTO `dp_hotsearch` VALUES ('94', '6', '江', '1539675240');
INSERT INTO `dp_hotsearch` VALUES ('95', '6', '江', '1539675420');
INSERT INTO `dp_hotsearch` VALUES ('96', '6', '江', '1539675436');
INSERT INTO `dp_hotsearch` VALUES ('97', '6', '江', '1539675473');
INSERT INTO `dp_hotsearch` VALUES ('98', '6', '江', '1539675630');
INSERT INTO `dp_hotsearch` VALUES ('99', '6', '江', '1539675905');
INSERT INTO `dp_hotsearch` VALUES ('100', '6', '江', '1539676045');
INSERT INTO `dp_hotsearch` VALUES ('101', '6', '江', '1539677412');
INSERT INTO `dp_hotsearch` VALUES ('102', '6', '江北', '1539677426');
INSERT INTO `dp_hotsearch` VALUES ('103', '6', '江', '1539677430');
INSERT INTO `dp_hotsearch` VALUES ('104', '6', '江', '1539678105');
INSERT INTO `dp_hotsearch` VALUES ('105', '6', '测', '1539678167');
INSERT INTO `dp_hotsearch` VALUES ('106', '6', '测', '1539678459');
INSERT INTO `dp_hotsearch` VALUES ('107', '6', '江', '1539678462');

-- ----------------------------
-- Table structure for dp_information
-- ----------------------------
DROP TABLE IF EXISTS `dp_information`;
CREATE TABLE `dp_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资讯列表id',
  `information_cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '资讯分类id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '资讯标题',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '资讯缩略图',
  `source` varchar(255) NOT NULL DEFAULT '' COMMENT '资讯来源',
  `detail` text NOT NULL COMMENT '资讯详情',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `click_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `is_release` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布,0表示不发布,1表示发布',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除,0表示不删除,1表示删除',
  `order_num` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `information` (`title`,`source`(191)) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_information
-- ----------------------------
INSERT INTO `dp_information` VALUES ('1', '12', '资讯title1', '13', '百度', '资讯内容1', '1536055509', '0', '1', '1', '102');
INSERT INTO `dp_information` VALUES ('2', '11', '资讯title2', '20', '腾讯', '<p><img src=\"/uploads/images/20180912/b8bf098c1fe16933888070e7f2861eea.jpg\" title=\"demo.jpg\" alt=\"\"/></p><p>哈哈哈</p><p><img src=\"/uploads/images/20180912/b8bf098c1fe16933888070e7f2861eea.jpg\" title=\"demo.jpg\" alt=\"\"/></p>', '1536135966', '0', '1', '1', '10');
INSERT INTO `dp_information` VALUES ('3', '12', '资讯title3', '23', '阿里巴巴', '资讯内容3', '1536140726', '0', '1', '1', '3');
INSERT INTO `dp_information` VALUES ('4', '1', '1', '36', '1', '<p><img src=\"/uploads/images/20180912/b8bf098c1fe16933888070e7f2861eea.jpg\" title=\"demo.jpg\" alt=\"\"/></p>', '1537869929', '0', '0', '1', '0');
INSERT INTO `dp_information` VALUES ('5', '1', '恻然', '187', '承', '<p>v</p>', '1539229460', '0', '1', '0', '0');
INSERT INTO `dp_information` VALUES ('6', '11', '自我概况', '193', '测试', '<p>方法</p>', '1539598802', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for dp_information_cate
-- ----------------------------
DROP TABLE IF EXISTS `dp_information_cate`;
CREATE TABLE `dp_information_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资讯分类id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '资讯分类名',
  `order_num` int(1) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_rease` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用,0表示不启用,1表示启用',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除,0表示不删除,1表示删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_information_cate
-- ----------------------------
INSERT INTO `dp_information_cate` VALUES ('1', '资讯分类1', '1', '1536055509', '1', '0');
INSERT INTO `dp_information_cate` VALUES ('11', '资讯分类2', '2', '1536055509', '1', '0');
INSERT INTO `dp_information_cate` VALUES ('12', '资讯分类3', '3', '1536132038', '1', '0');
INSERT INTO `dp_information_cate` VALUES ('13', '资讯分类4', '4', '1536138230', '1', '0');

-- ----------------------------
-- Table structure for dp_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `dp_order_detail`;
CREATE TABLE `dp_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单流水id',
  `order_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单类型,1用户购买卡,2用户购买服务',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_order_detail
-- ----------------------------
INSERT INTO `dp_order_detail` VALUES ('10', '2', '14', '1537529423');
INSERT INTO `dp_order_detail` VALUES ('11', '2', '15', '1537532363');
INSERT INTO `dp_order_detail` VALUES ('12', '2', '16', '1537532421');
INSERT INTO `dp_order_detail` VALUES ('13', '2', '17', '1537532437');
INSERT INTO `dp_order_detail` VALUES ('14', '2', '18', '1537532442');
INSERT INTO `dp_order_detail` VALUES ('15', '2', '19', '1537532969');
INSERT INTO `dp_order_detail` VALUES ('16', '2', '20', '1537533127');
INSERT INTO `dp_order_detail` VALUES ('17', '2', '21', '1537533453');
INSERT INTO `dp_order_detail` VALUES ('19', '2', '23', '1537537005');
INSERT INTO `dp_order_detail` VALUES ('20', '2', '24', '1537537344');
INSERT INTO `dp_order_detail` VALUES ('21', '2', '25', '1537537605');
INSERT INTO `dp_order_detail` VALUES ('22', '2', '26', '1537537618');
INSERT INTO `dp_order_detail` VALUES ('23', '2', '27', '1537537622');
INSERT INTO `dp_order_detail` VALUES ('24', '2', '28', '1537537666');
INSERT INTO `dp_order_detail` VALUES ('25', '2', '29', '1537537678');
INSERT INTO `dp_order_detail` VALUES ('26', '2', '30', '1537537873');
INSERT INTO `dp_order_detail` VALUES ('27', '2', '31', '1537538268');
INSERT INTO `dp_order_detail` VALUES ('28', '2', '32', '1537538275');
INSERT INTO `dp_order_detail` VALUES ('29', '2', '33', '1537538290');
INSERT INTO `dp_order_detail` VALUES ('30', '2', '34', '1537538293');
INSERT INTO `dp_order_detail` VALUES ('31', '2', '35', '1537538297');
INSERT INTO `dp_order_detail` VALUES ('32', '2', '36', '1537538300');
INSERT INTO `dp_order_detail` VALUES ('33', '2', '37', '1537538303');
INSERT INTO `dp_order_detail` VALUES ('34', '2', '38', '1537538307');
INSERT INTO `dp_order_detail` VALUES ('35', '2', '39', '1537538310');
INSERT INTO `dp_order_detail` VALUES ('36', '2', '40', '1537538311');
INSERT INTO `dp_order_detail` VALUES ('37', '2', '41', '1537538313');
INSERT INTO `dp_order_detail` VALUES ('38', '2', '42', '1537538541');
INSERT INTO `dp_order_detail` VALUES ('39', '2', '43', '1537538937');
INSERT INTO `dp_order_detail` VALUES ('40', '2', '44', '1537538939');
INSERT INTO `dp_order_detail` VALUES ('41', '2', '45', '1537538941');
INSERT INTO `dp_order_detail` VALUES ('42', '2', '46', '1537538942');
INSERT INTO `dp_order_detail` VALUES ('43', '2', '47', '1537538943');
INSERT INTO `dp_order_detail` VALUES ('44', '2', '48', '1537538944');
INSERT INTO `dp_order_detail` VALUES ('45', '2', '49', '1537538945');
INSERT INTO `dp_order_detail` VALUES ('46', '2', '50', '1537538946');
INSERT INTO `dp_order_detail` VALUES ('47', '2', '51', '1537538947');
INSERT INTO `dp_order_detail` VALUES ('48', '2', '52', '1537538949');
INSERT INTO `dp_order_detail` VALUES ('49', '2', '53', '1537538951');
INSERT INTO `dp_order_detail` VALUES ('50', '2', '54', '1537539349');
INSERT INTO `dp_order_detail` VALUES ('51', '2', '55', '1537539351');
INSERT INTO `dp_order_detail` VALUES ('52', '2', '56', '1537539352');
INSERT INTO `dp_order_detail` VALUES ('53', '2', '57', '1537539353');
INSERT INTO `dp_order_detail` VALUES ('54', '2', '58', '1537539357');
INSERT INTO `dp_order_detail` VALUES ('55', '2', '59', '1537841375');
INSERT INTO `dp_order_detail` VALUES ('56', '1', '7', '1538124491');
INSERT INTO `dp_order_detail` VALUES ('57', '1', '8', '1538125244');
INSERT INTO `dp_order_detail` VALUES ('58', '1', '9', '1538207444');
INSERT INTO `dp_order_detail` VALUES ('59', '1', '10', '1538211598');
INSERT INTO `dp_order_detail` VALUES ('60', '1', '11', '1538211625');
INSERT INTO `dp_order_detail` VALUES ('61', '1', '12', '1538219209');
INSERT INTO `dp_order_detail` VALUES ('62', '1', '13', '1538220134');
INSERT INTO `dp_order_detail` VALUES ('63', '2', '60', '1538229156');
INSERT INTO `dp_order_detail` VALUES ('64', '2', '61', '1538229527');
INSERT INTO `dp_order_detail` VALUES ('65', '1', '14', '1538272275');
INSERT INTO `dp_order_detail` VALUES ('66', '1', '15', '1538272282');
INSERT INTO `dp_order_detail` VALUES ('67', '1', '16', '1538272290');
INSERT INTO `dp_order_detail` VALUES ('68', '1', '17', '1538272295');
INSERT INTO `dp_order_detail` VALUES ('69', '2', '62', '1538272441');
INSERT INTO `dp_order_detail` VALUES ('70', '2', '63', '1538274753');
INSERT INTO `dp_order_detail` VALUES ('71', '2', '64', '1538275771');
INSERT INTO `dp_order_detail` VALUES ('72', '2', '65', '1538276653');
INSERT INTO `dp_order_detail` VALUES ('73', '2', '66', '1538276772');
INSERT INTO `dp_order_detail` VALUES ('74', '2', '67', '1538277345');
INSERT INTO `dp_order_detail` VALUES ('75', '1', '18', '1538283682');
INSERT INTO `dp_order_detail` VALUES ('76', '1', '19', '1538283687');
INSERT INTO `dp_order_detail` VALUES ('77', '2', '68', '1538288288');
INSERT INTO `dp_order_detail` VALUES ('78', '2', '69', '1538288349');
INSERT INTO `dp_order_detail` VALUES ('79', '2', '70', '1538288362');
INSERT INTO `dp_order_detail` VALUES ('80', '2', '71', '1538288525');
INSERT INTO `dp_order_detail` VALUES ('81', '2', '72', '1538289843');
INSERT INTO `dp_order_detail` VALUES ('82', '1', '20', '1538290576');
INSERT INTO `dp_order_detail` VALUES ('83', '2', '73', '1538290674');
INSERT INTO `dp_order_detail` VALUES ('84', '2', '74', '1538290832');
INSERT INTO `dp_order_detail` VALUES ('85', '2', '75', '1538291999');
INSERT INTO `dp_order_detail` VALUES ('86', '2', '76', '1538292075');
INSERT INTO `dp_order_detail` VALUES ('87', '2', '77', '1538292147');
INSERT INTO `dp_order_detail` VALUES ('88', '1', '21', '1538300379');
INSERT INTO `dp_order_detail` VALUES ('89', '1', '22', '1538300385');
INSERT INTO `dp_order_detail` VALUES ('90', '1', '23', '1538968244');
INSERT INTO `dp_order_detail` VALUES ('91', '1', '24', '1538979982');
INSERT INTO `dp_order_detail` VALUES ('92', '2', '78', '1539141699');
INSERT INTO `dp_order_detail` VALUES ('93', '2', '79', '1539141743');
INSERT INTO `dp_order_detail` VALUES ('94', '2', '80', '1539143278');
INSERT INTO `dp_order_detail` VALUES ('95', '1', '25', '1539243817');
INSERT INTO `dp_order_detail` VALUES ('96', '1', '26', '1539243942');
INSERT INTO `dp_order_detail` VALUES ('97', '1', '27', '1539244312');
INSERT INTO `dp_order_detail` VALUES ('98', '1', '28', '1539244327');
INSERT INTO `dp_order_detail` VALUES ('99', '1', '29', '1539244357');
INSERT INTO `dp_order_detail` VALUES ('100', '1', '30', '1539251353');
INSERT INTO `dp_order_detail` VALUES ('101', '1', '31', '1539251477');
INSERT INTO `dp_order_detail` VALUES ('102', '1', '32', '1539251689');
INSERT INTO `dp_order_detail` VALUES ('103', '1', '33', '1539310907');
INSERT INTO `dp_order_detail` VALUES ('104', '1', '34', '1539654937');
INSERT INTO `dp_order_detail` VALUES ('105', '1', '35', '1539660008');
INSERT INTO `dp_order_detail` VALUES ('106', '1', '36', '1539670448');
INSERT INTO `dp_order_detail` VALUES ('107', '1', '37', '1539673557');
INSERT INTO `dp_order_detail` VALUES ('108', '1', '38', '1539673934');
INSERT INTO `dp_order_detail` VALUES ('109', '1', '39', '1539674177');
INSERT INTO `dp_order_detail` VALUES ('110', '1', '40', '1539674247');
INSERT INTO `dp_order_detail` VALUES ('111', '1', '41', '1539674314');
INSERT INTO `dp_order_detail` VALUES ('112', '1', '42', '1539674411');
INSERT INTO `dp_order_detail` VALUES ('113', '1', '43', '1539674727');
INSERT INTO `dp_order_detail` VALUES ('114', '1', '44', '1539674833');
INSERT INTO `dp_order_detail` VALUES ('115', '1', '45', '1539674895');
INSERT INTO `dp_order_detail` VALUES ('116', '1', '46', '1539676723');

-- ----------------------------
-- Table structure for dp_platform_card
-- ----------------------------
DROP TABLE IF EXISTS `dp_platform_card`;
CREATE TABLE `dp_platform_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '卡id',
  `cardname` varchar(100) NOT NULL DEFAULT '' COMMENT '卡名称',
  `total_value` varchar(10) NOT NULL DEFAULT '' COMMENT '卡总权益值',
  `card_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '卡类型,1权益卡,2次数卡',
  `period` int(11) NOT NULL DEFAULT '0' COMMENT '消费周期',
  `monthly_times` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '单月可使用次数',
  `cash_pay_value` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现金价值',
  `sale_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '销售状态,0禁止销售,1允许销售',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_platform_card
-- ----------------------------
INSERT INTO `dp_platform_card` VALUES ('1', '权益卡测试1', '50000', '1', '30', '10', '100.00', '1', '1536290644');
INSERT INTO `dp_platform_card` VALUES ('2', '权益卡测试2', '100', '1', '60', '10', '100.00', '1', '1536290676');
INSERT INTO `dp_platform_card` VALUES ('3', '次数卡测试1', '30', '2', '90', '30', '200.00', '1', '1536290702');
INSERT INTO `dp_platform_card` VALUES ('4', '次数卡测试2', '12', '2', '30', '10', '150.00', '1', '1536292326');
INSERT INTO `dp_platform_card` VALUES ('7', '次数', '10', '2', '30', '10', '200.00', '1', '1536314193');
INSERT INTO `dp_platform_card` VALUES ('8', '0920权益卡', '150', '1', '60', '10', '150.00', '0', '1537414840');
INSERT INTO `dp_platform_card` VALUES ('9', '次数', '5', '2', '30', '5', '200.00', '1', '1536314193');
INSERT INTO `dp_platform_card` VALUES ('10', '次卡0927', '100', '2', '180', '30', '500.00', '1', '1538034807');
INSERT INTO `dp_platform_card` VALUES ('11', '权益0928', '500', '1', '90', '10', '500.00', '1', '1538102133');

-- ----------------------------
-- Table structure for dp_platform_detail
-- ----------------------------
DROP TABLE IF EXISTS `dp_platform_detail`;
CREATE TABLE `dp_platform_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '平台流水id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `card_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '卡id',
  `card_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '卡类别,1权益卡,2次数卡',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商户id',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `is_balance` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '进账or出账,1进账,2出账',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `platfoemdetail` (`user_id`,`card_id`,`card_type`,`seller_id`,`amount`,`is_balance`,`create_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_platform_detail
-- ----------------------------

-- ----------------------------
-- Table structure for dp_position_history
-- ----------------------------
DROP TABLE IF EXISTS `dp_position_history`;
CREATE TABLE `dp_position_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '定位历史id',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `latitude` varchar(200) NOT NULL DEFAULT '' COMMENT '地名',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '定位时间',
  `pinyin` char(1) NOT NULL COMMENT '城市拼音',
  `area_code` varchar(50) NOT NULL COMMENT '区域id',
  PRIMARY KEY (`id`),
  KEY `position` (`latitude`(191)) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_position_history
-- ----------------------------
INSERT INTO `dp_position_history` VALUES ('12', '1', '四川', '1538116773', '', '510000');
INSERT INTO `dp_position_history` VALUES ('13', '1', '四川', '1538116892', '', '510000');
INSERT INTO `dp_position_history` VALUES ('14', '1', '四川', '1538130873', '', '510000');
INSERT INTO `dp_position_history` VALUES ('15', '1', '成都', '1538130915', '', '510166');
INSERT INTO `dp_position_history` VALUES ('16', '1', '成都', '1538130998', '', '510166');
INSERT INTO `dp_position_history` VALUES ('17', '1', '成都', '1538135276', 'C', '510166');
INSERT INTO `dp_position_history` VALUES ('18', '1', '成都', '1538190196', 'C', '510000');
INSERT INTO `dp_position_history` VALUES ('19', '1', '渝中区', '1538190873', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('20', '1', '重庆市', '1538190938', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('21', '1', '重庆', '1538190950', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('22', '1', '四川省', '1538191206', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('23', '1', '四川省', '1538191327', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('24', '1', '重庆市', '1538191338', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('25', '1', '四川省', '1538191546', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('26', '1', '重庆', '1538191548', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('27', '1', '重庆市', '1538192097', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('28', '1', '重庆市', '1538192106', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('29', '1', '渝中区', '1538192107', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('30', '1', '四川省', '1538192108', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('31', '1', '重庆市', '1538192118', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('32', '1', '渝中区', '1538192154', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('33', '1', '渝中区', '1538192241', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('34', '1', '重庆市', '1538192304', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('35', '1', '成都', '1538192551', 'C', '510000');
INSERT INTO `dp_position_history` VALUES ('36', '1', '重庆市', '1538200684', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('37', '6', '重庆市', '1538219309', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('38', '6', '四川省', '1538272408', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('39', '6', '重庆市', '1538296209', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('40', '1', '重庆', '1538967665', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('41', '6', '重庆市', '1538988178', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('42', '5', '重庆市', '1539136289', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('43', '5', '四川省', '1539136301', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('44', '5', '重庆', '1539136311', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('45', '6', '四川省', '1539163666', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('46', '6', '重庆市', '1539163716', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('47', '6', '渝中区', '1539163740', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('48', '6', '重庆市', '1539163840', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('49', '5', '重庆市', '1539243703', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('50', '5', '四川省', '1539243742', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('51', '5', '重庆市', '1539243781', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('52', '5', '渝中区', '1539244418', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('53', '5', '重庆市', '1539244528', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('54', '6', '重庆市', '1539326065', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('55', '6', '重庆', '1539326160', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('56', '6', '四川省', '1539326182', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('57', '6', '重庆', '1539329185', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('58', '6', '重庆市', '1539339170', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('59', '7', '四川省', '1539571333', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('60', '7', '四川省', '1539571336', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('61', '7', '重庆', '1539571353', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('62', '7', '渝中区', '1539571363', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('63', '7', '四川省', '1539571377', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('64', '7', '成都市', '1539571381', 'C', '510100');
INSERT INTO `dp_position_history` VALUES ('65', '7', '重庆', '1539571421', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('66', '7', '重庆', '1539571425', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('67', '7', '重庆', '1539573934', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('68', '7', '渝中区', '1539573938', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('69', '7', '重庆', '1539573940', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('70', '7', '四川省', '1539584987', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('71', '7', '重庆市', '1539584993', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('72', '7', '渝中区', '1539585006', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('73', '7', '四川省', '1539585147', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('74', '7', '重庆', '1539585198', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('75', '7', '四川省', '1539585475', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('76', '7', '重庆', '1539585494', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('77', '7', '四川省', '1539585591', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('78', '7', '重庆市', '1539585594', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('79', '7', '四川省', '1539585817', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('80', '7', '重庆', '1539596828', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('81', '7', '四川省', '1539596868', 'S', '510000');
INSERT INTO `dp_position_history` VALUES ('82', '5', '重庆', '1539598352', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('83', '5', '渝中区', '1539598356', 'Y', '500103');
INSERT INTO `dp_position_history` VALUES ('84', '5', '重庆市', '1539599163', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('85', '5', '重庆市', '1539599168', 'Z', '500103');
INSERT INTO `dp_position_history` VALUES ('86', '6', '重庆市', '1539675847', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('87', '6', '重庆市', '1539675854', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('88', '6', '重庆市', '1539675856', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('89', '6', '重庆市', '1539675862', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('90', '6', '重庆市', '1539675877', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('91', '6', '重庆市', '1539676391', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('92', '6', '重庆市', '1539676395', 'Z', '500000');
INSERT INTO `dp_position_history` VALUES ('93', '6', '重庆市', '1539676404', 'Z', '500000');

-- ----------------------------
-- Table structure for dp_seller
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller`;
CREATE TABLE `dp_seller` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家id',
  `sellername` varchar(60) NOT NULL DEFAULT '' COMMENT '商家名称',
  `shopkeeper` varchar(60) NOT NULL DEFAULT '' COMMENT '店主姓名',
  `provinces_id` int(11) NOT NULL DEFAULT '0' COMMENT '省份城市id',
  `address` varchar(150) NOT NULL DEFAULT '' COMMENT '详细地址',
  `area_code` char(6) NOT NULL DEFAULT '' COMMENT '身份证前6位',
  `lonlat` varchar(100) NOT NULL DEFAULT '' COMMENT '商家经纬度',
  `lat` double(10,6) NOT NULL DEFAULT '0.000000' COMMENT '经度',
  `lon` double(10,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '纬度',
  `lat_floor` tinyint(4) NOT NULL DEFAULT '0' COMMENT '精确的经度值',
  `lon_floor` tinyint(4) NOT NULL DEFAULT '0' COMMENT '精确的纬度',
  `homepage_cate_parent_id` varchar(200) NOT NULL DEFAULT '' COMMENT '营业项目id',
  `contactphone` char(11) NOT NULL DEFAULT '' COMMENT '店铺联系电话',
  `vmphone` char(11) NOT NULL DEFAULT '' COMMENT '业务经理电话',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `is_review` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已加盟,0待处理,1审核通过',
  `order_num` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '申请时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始营业时间',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束营业时间',
  `is_disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否下架,0不下架,1下架',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页推荐,0不推荐,1推荐',
  `seller_pic1` varchar(100) NOT NULL DEFAULT '' COMMENT '营业执照',
  `seller_pic2` varchar(100) NOT NULL DEFAULT '' COMMENT '店铺图片',
  `seller_pic3` varchar(100) NOT NULL DEFAULT '' COMMENT '店铺介绍图',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现比例',
  PRIMARY KEY (`id`),
  KEY `smobile` (`contactphone`) USING BTREE,
  KEY `slonlat` (`lonlat`) USING BTREE,
  KEY `slat` (`lat`) USING BTREE,
  KEY `slon` (`lon`) USING BTREE,
  KEY `slatfoolr` (`lat_floor`) USING BTREE,
  KEY `slonfoolr` (`lon_floor`) USING BTREE,
  KEY `sname` (`sellername`) USING BTREE,
  KEY `hcid` (`homepage_cate_parent_id`(191)) USING BTREE,
  KEY `isreview` (`is_review`) USING BTREE COMMENT '//是否加盟(0待处理,1已加盟)',
  KEY `isdisabled` (`is_disabled`) USING BTREE COMMENT '是否下架(0不下架,1下架)'
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller
-- ----------------------------
INSERT INTO `dp_seller` VALUES ('1', '江北红火洗车行', '江北店长', '15', '重庆市江北区五里店', '500105', '106.565500,29.585157', '29.544606', '106.531535', '29', '106', '1,2,7', '18215467894', '15878941237', '重庆市江北区五里店优质洗车', '1', '98', '1535945339', '1536889705', '1538183281', '1538215681', '0', '1', '17', '48,64,19', '77', '0.01');
INSERT INTO `dp_seller` VALUES ('2', '弹子石洗车', '南岸店长', '15', '重庆市南岸区南坪街道', '500108', '106.576939,29.536921', '29.536921', '106.576939', '29', '106', '1,2', '18745678945', '17899994561', '测试图片重庆市江北区五里店', '1', '100', '1535947120', '1535945339', '1536109200', '1536156000', '0', '1', '12', '9,10,11', '18', '0.02');
INSERT INTO `dp_seller` VALUES ('3', '洗车人家', '大头', '1', '重庆市江北区观音桥', '500105', '106.532536,29.572119', '29.572119', '106.532536', '29', '106', '1', '18745610344', '17898745612', '测试获取经纬度,省份,营业项目', '1', '100', '1536133904', '1536141237', '1536109200', '1536152400', '0', '1', '12', '9,10,11', '8', '0.02');
INSERT INTO `dp_seller` VALUES ('4', '俊豪', '军军', '2', '重庆市弹子石街道', '500108', '106.590347,29.582271', '29.582271', '106.590347', '29', '106', '1,2', '18726457894', '15878945612', '优质服务', '0', '100', '1536138238', '1536138238', '1536094800', '1536109200', '0', '0', '19', '17,18,22', '21', '0.10');
INSERT INTO `dp_seller` VALUES ('5', 'aaa', 'asasd', '2', '重庆市南岸区南坪街道', '500108', '106.569758,29.530616', '29.530616', '106.569758', '29', '106', '1,2', '17894561234', '17894561234', '测试', '1', '100', '1536141703', '1536141703', '1536098400', '1536152400', '0', '1', '18', '16,17,18', '19', '0.00');
INSERT INTO `dp_seller` VALUES ('6', '全文', '驱蚊器', '2', '四川省成都市高新区天府新谷', '510107', '104.055144,30.586356', '30.586356', '104.055144', '30', '104', '1', '18202333555', '18202333555', '测试', '1', '100', '1536143071', '1536143071', '1536109200', '1536152400', '0', '1', '18', '18,22,21', '24', '0.00');
INSERT INTO `dp_seller` VALUES ('7', '测试0906', '0906', '2', '四川省成都市高新区天府新谷', '510107', '104.055144,30.586356', '30.586356', '104.055144', '30', '104', '1', '18745612345', '18745612345', '测试 0906', '1', '100', '1536227935', '1536227935', '1536195600', '1536238800', '0', '0', '30', '31,26,30', '32', '0.01');
INSERT INTO `dp_seller` VALUES ('8', '阿斯顿撒', '十大', '2', '重庆市渝北区江北机场', '500112', '106.638484,29.716444', '29.716444', '106.638484', '29', '106', '2,3', '18202444555', '18202444555', '阿斯顿撒多', '1', '100', '1536228057', '1536228072', '1536195600', '1536238800', '0', '1', '26', '30,33,34', '26', '0.09');
INSERT INTO `dp_seller` VALUES ('11', '规划法规', 'id为11的商家', '17', '重庆市江北区', '500105', '106.574271,29.606703', '29.606703', '106.574271', '29', '106', '1,2,3', '17623763507', '17623763507', '测试', '1', '97', '1536834746', '1536889664', '1536879600', '1536930000', '0', '1', '31', '37,38,39', '40', '0.01');
INSERT INTO `dp_seller` VALUES ('14', '店主', 'bb', '1', '重庆云阳', '500235', '108.697324,30.930613', '30.930613', '108.697324', '30', '108', '1,5,7', '15878944561', '', '', '1', '100', '1537193148', '1537193148', '0', '0', '0', '0', '9', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('15', '店主aabbcc', 'aabbcc', '1', '重庆云阳', '500235', '108.697324,30.930613', '30.930613', '108.697324', '30', '108', '1,2,3', '18845671234', '', '', '1', '100', '1537238914', '1537238914', '0', '0', '0', '0', '9', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('16', '我也是', '我在', '17', '重庆市渝中区较场口88号', '500103', '106.574840,29.553832', '29.553832', '106.574840', '29', '106', '1,2', '17708323309', '', '', '1', '100', '1537247929', '1537247929', '0', '0', '0', '0', '44', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('17', '托物', '左右', '15', '重庆市渝中区较场口88号', '500103', '106.574840,29.553832', '29.553832', '106.574840', '29', '106', '1,2', '17708359074', '', '', '1', '100', '1537248503', '1537248503', '0', '0', '0', '0', '44', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('18', '专业实习', '我在', '15', '重庆市渝中区较场口88号', '500103', '106.574840,29.553832', '29.553832', '106.574840', '29', '106', '1', '17708938504', '', '', '1', '100', '1537248866', '1537248866', '0', '0', '0', '0', '44', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('19', '测试店铺', '测试', '15', '重庆市渝中区较场口88号', '500103', '106.574840,29.553832', '29.553832', '106.574840', '29', '106', '1,2', '17708323304', '', '', '1', '100', '1537249658', '1537249658', '0', '0', '0', '0', '44', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('20', '反对广告', '小李', '17', '青羊区', '510105', '104.062499,30.674406', '30.674406', '104.062499', '30', '104', '4,3,2,1,8,10', '13996379929', '', '', '1', '100', '1537250618', '1537250618', '0', '0', '0', '0', '42', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('21', '规范化符合', '山东省的', '15', '沙坪坝区', '500106', '106.456878,29.541145', '29.541145', '106.456878', '29', '106', '3', '15856789876', '', '', '1', '100', '1537253122', '1537253122', '0', '0', '0', '0', '42', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('22', '我肚痛', '测试', '15', '重庆市渝中区较场口89号', '500103', '106.575513,29.552624', '29.552624', '106.575513', '29', '106', '1,3', '17708323306', '', '', '1', '100', '1537253972', '1537253972', '0', '0', '0', '0', '44', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('23', '测测', 'c测测', '1', '重庆市渝中区', '500103', '106.568892,29.552750', '29.552750', '106.568892', '29', '106', '1', '15578941258', '', '', '1', '100', '1537266730', '1537266730', '0', '0', '0', '0', '0', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('24', '考虑考虑', '阿里健康', '15', '重庆市渝北区', '500112', '106.631187,29.718143', '29.718143', '106.631187', '29', '106', '1,2,8,4,3,', '18738277443', '', '', '1', '100', '1537517018', '1537517018', '1538186352', '1538222352', '0', '0', '57', '91,86,84', '87', '0.00');
INSERT INTO `dp_seller` VALUES ('25', '旅途', '考虑考虑', '15', '重庆市渝北区', '500112', '106.631187,29.718143', '29.718143', '106.631187', '29', '106', '2,8,3,', '18728745632', '', '', '1', '100', '1537517606', '1537517606', '0', '0', '0', '0', '60', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('26', '测试十三', '全文', '15', '重庆市渝中区', '500103', '106.568892,29.552750', '29.552750', '106.568892', '29', '106', '1,2', '18778945612', '15878945612', '备注', '1', '100', '1537933741', '1537933741', '1537923600', '1537966800', '0', '0', '26', '25,38,39', '61', '0.01');
INSERT INTO `dp_seller` VALUES ('27', '测试十三所所所所', '三生三世', '15', '重庆市渝中区解放碑', '500103', '106.572744,29.552596', '29.552596', '106.572744', '29', '106', '1,2', '15978956547', '17789787879', '备注', '1', '100', '1537936816', '1537936816', '1537923600', '1537966800', '0', '0', '26', '62,63,61', '39', '0.01');
INSERT INTO `dp_seller` VALUES ('28', '打算大', '梵蒂冈反对官方', '17', '沙坪坝去区', '500106', '106.462681,29.557204', '29.557204', '106.462681', '29', '106', '1,2,3,4', '13996379927', '', '', '0', '100', '1537960364', '1537960364', '0', '0', '0', '0', '42', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('29', '入驻入驻', '入驻入驻', '15', '重庆市江北区观音桥', '500105', '106.532536,29.572119', '29.572119', '106.532536', '29', '106', '1,2', '15578945623', '', '', '1', '100', '1538029048', '1538029048', '0', '0', '0', '0', '26', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('30', '入驻入驻1', '入驻1', '15', '重庆市江北区观音桥', '500105', '106.532536,29.572119', '29.572119', '106.532536', '29', '106', '1,2,3', '15678964512', '15678964512', '入驻入驻1', '1', '100', '1538029299', '1538029299', '1538010000', '1538053200', '0', '0', '26', '26,30,33', '31', '0.01');
INSERT INTO `dp_seller` VALUES ('31', '红红活活', '小邓', '15', '重庆市沙坪坝区', '500106', '106.456878,29.541145', '29.541145', '106.456878', '29', '106', '2,1,4,12,13,8,10,11,3', '15866666666', '', '', '0', '100', '1539230160', '1539230160', '0', '0', '0', '0', '42', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('32', '五里店的商家', '五里店', '15', '重庆市江北区五里店', '500105', '106.565500,29.585157', '29.585157', '106.565500', '29', '106', '1,11,12', '15677779999', '15677779999', '测试测试', '1', '100', '1539233598', '1539233598', '1539219600', '1539262800', '0', '0', '123', '16,18,22', '24', '0.01');
INSERT INTO `dp_seller` VALUES ('33', '测试上传图片插件', '上传图片插件测试', '15', '重庆市江北区五里店', '500105', '106.565500,29.585157', '29.585157', '106.565500', '29', '106', '12', '18877779999', '18877779999', '图片上传插件测试', '1', '100', '1539245305', '1539245305', '1539205200', '1539270000', '0', '0', '125', '126,125,106', '89', '0.01');
INSERT INTO `dp_seller` VALUES ('34', '测试图片上传插件', '图片上传插件测试', '15', '重庆市江北区五里店', '500105', '106.565500,29.585157', '29.585157', '106.565500', '29', '106', '1', '18898987878', '18898987878', '测试图片上传插件', '1', '100', '1539251444', '1539251444', '1539205200', '1539266400', '0', '0', '107', '104,89,105', '104', '0.01');
INSERT INTO `dp_seller` VALUES ('35', '测试测试', '测测测', '15', '重庆市南岸区弹子石星泽汇', '500108', '106.591196,29.580432', '29.580432', '106.591196', '29', '106', '8,10', '15566664444', '15566664444', '啛啛喳喳错错错错错错错错', '1', '100', '1539317059', '1539336931', '1539291600', '1539356400', '0', '0', '89', '118,119,120', '109', '0.01');
INSERT INTO `dp_seller` VALUES ('36', '举高高', 'lyd', '15', '重庆渝北区新溉大道', '500112', '106.540261,29.599167', '29.599167', '106.540261', '29', '106', '2,8,4,12,13,', '17623464030', '', '', '0', '100', '1539594610', '1539594610', '0', '0', '0', '0', '153', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('37', '测试店铺', '测试', '15', '沙坪坝区', '500106', '106.456878,29.541145', '29.541145', '106.456878', '29', '106', '4,12,15', '15869696969', '', '', '0', '100', '1539598512', '1539598512', '0', '0', '0', '0', '189', '', '', '0.00');
INSERT INTO `dp_seller` VALUES ('38', '图片上传', '图片上传', '15', '重庆市江北区五里店', '500105', '106.565500,29.585157', '29.585157', '106.565500', '29', '106', '16', '15577779999', '15577779999', '奥术大师多撒大所', '1', '100', '1539598684', '1539598684', '1539565200', '1539615600', '0', '0', '190', '188,190,191', '190', '0.01');

-- ----------------------------
-- Table structure for dp_seller_balance
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_balance`;
CREATE TABLE `dp_seller_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家收支id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `seller_service_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家服务id',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '记录金额',
  `is_balance` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '进账or出账',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '记录时间',
  `cash_account_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '提现id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_balance
-- ----------------------------
INSERT INTO `dp_seller_balance` VALUES ('5', '1', '0', '100.00', '1', '1536302311', '1');
INSERT INTO `dp_seller_balance` VALUES ('8', '1', '0', '20.00', '2', '1536305776', '1');
INSERT INTO `dp_seller_balance` VALUES ('9', '1', '0', '30.00', '1', '1536310529', '5');
INSERT INTO `dp_seller_balance` VALUES ('10', '1', '0', '40.00', '2', '1536310552', '5');
INSERT INTO `dp_seller_balance` VALUES ('11', '1', '0', '10.00', '2', '1537273002', '11');
INSERT INTO `dp_seller_balance` VALUES ('12', '1', '0', '10.00', '2', '1537273049', '12');
INSERT INTO `dp_seller_balance` VALUES ('13', '20', '0', '10.00', '1', '0', '14');
INSERT INTO `dp_seller_balance` VALUES ('14', '20', '0', '10.00', '2', '0', '13');
INSERT INTO `dp_seller_balance` VALUES ('15', '1', '0', '20.00', '2', '1537345999', '15');
INSERT INTO `dp_seller_balance` VALUES ('16', '1', '0', '20.00', '2', '1537346032', '16');
INSERT INTO `dp_seller_balance` VALUES ('17', '1', '0', '50.00', '1', '1537347992', '9');
INSERT INTO `dp_seller_balance` VALUES ('18', '20', '0', '10.00', '1', '1537348271', '13');
INSERT INTO `dp_seller_balance` VALUES ('19', '1', '0', '100.00', '1', '1537351841', '7');
INSERT INTO `dp_seller_balance` VALUES ('20', '1', '0', '20.00', '2', '1537408941', '17');
INSERT INTO `dp_seller_balance` VALUES ('21', '1', '0', '20.00', '2', '1537409042', '18');
INSERT INTO `dp_seller_balance` VALUES ('22', '20', '0', '6.00', '2', '1537426906', '19');
INSERT INTO `dp_seller_balance` VALUES ('23', '20', '0', '1.00', '2', '1537427002', '20');
INSERT INTO `dp_seller_balance` VALUES ('24', '20', '0', '1.00', '2', '1537429108', '21');
INSERT INTO `dp_seller_balance` VALUES ('25', '20', '0', '1.00', '2', '1537429148', '22');
INSERT INTO `dp_seller_balance` VALUES ('26', '20', '0', '1000.00', '1', '1537429556', '23');
INSERT INTO `dp_seller_balance` VALUES ('27', '20', '0', '20.00', '2', '1537429720', '24');
INSERT INTO `dp_seller_balance` VALUES ('70', '20', '9', '500.00', '1', '1537529423', '0');
INSERT INTO `dp_seller_balance` VALUES ('71', '20', '9', '500.00', '1', '1537532363', '0');
INSERT INTO `dp_seller_balance` VALUES ('72', '20', '9', '500.00', '1', '1537532421', '0');
INSERT INTO `dp_seller_balance` VALUES ('73', '20', '9', '500.00', '1', '1537532437', '0');
INSERT INTO `dp_seller_balance` VALUES ('74', '20', '9', '500.00', '1', '1537532442', '0');
INSERT INTO `dp_seller_balance` VALUES ('75', '20', '9', '500.00', '1', '1537532969', '0');
INSERT INTO `dp_seller_balance` VALUES ('76', '20', '9', '500.00', '1', '1537533127', '0');
INSERT INTO `dp_seller_balance` VALUES ('77', '20', '9', '500.00', '1', '1537533453', '0');
INSERT INTO `dp_seller_balance` VALUES ('79', '20', '9', '500.00', '1', '1537537005', '0');
INSERT INTO `dp_seller_balance` VALUES ('80', '20', '9', '500.00', '1', '1537537344', '0');
INSERT INTO `dp_seller_balance` VALUES ('81', '20', '9', '500.00', '1', '1537537605', '0');
INSERT INTO `dp_seller_balance` VALUES ('82', '20', '9', '500.00', '1', '1537537618', '0');
INSERT INTO `dp_seller_balance` VALUES ('83', '20', '9', '500.00', '1', '1537537622', '0');
INSERT INTO `dp_seller_balance` VALUES ('84', '20', '9', '500.00', '1', '1537537666', '0');
INSERT INTO `dp_seller_balance` VALUES ('85', '20', '9', '500.00', '1', '1537537678', '0');
INSERT INTO `dp_seller_balance` VALUES ('86', '20', '9', '500.00', '1', '1537537873', '0');
INSERT INTO `dp_seller_balance` VALUES ('87', '20', '9', '500.00', '1', '1537538268', '0');
INSERT INTO `dp_seller_balance` VALUES ('88', '20', '9', '500.00', '1', '1537538274', '0');
INSERT INTO `dp_seller_balance` VALUES ('89', '20', '9', '500.00', '1', '1537538290', '0');
INSERT INTO `dp_seller_balance` VALUES ('90', '20', '9', '500.00', '1', '1537538293', '0');
INSERT INTO `dp_seller_balance` VALUES ('91', '20', '9', '500.00', '1', '1537538297', '0');
INSERT INTO `dp_seller_balance` VALUES ('92', '20', '9', '500.00', '1', '1537538300', '0');
INSERT INTO `dp_seller_balance` VALUES ('93', '20', '9', '500.00', '1', '1537538303', '0');
INSERT INTO `dp_seller_balance` VALUES ('94', '20', '9', '500.00', '1', '1537538307', '0');
INSERT INTO `dp_seller_balance` VALUES ('95', '20', '9', '500.00', '1', '1537538310', '0');
INSERT INTO `dp_seller_balance` VALUES ('96', '20', '9', '500.00', '1', '1537538311', '0');
INSERT INTO `dp_seller_balance` VALUES ('97', '20', '9', '500.00', '1', '1537538313', '0');
INSERT INTO `dp_seller_balance` VALUES ('98', '20', '9', '500.00', '1', '1537538541', '0');
INSERT INTO `dp_seller_balance` VALUES ('99', '20', '9', '500.00', '1', '1537538936', '0');
INSERT INTO `dp_seller_balance` VALUES ('100', '20', '9', '500.00', '1', '1537538939', '0');
INSERT INTO `dp_seller_balance` VALUES ('101', '20', '9', '500.00', '1', '1537538940', '0');
INSERT INTO `dp_seller_balance` VALUES ('102', '24', '9', '500.00', '1', '1537538942', '0');
INSERT INTO `dp_seller_balance` VALUES ('103', '20', '9', '500.00', '1', '1537538943', '0');
INSERT INTO `dp_seller_balance` VALUES ('104', '20', '9', '500.00', '1', '1537538944', '0');
INSERT INTO `dp_seller_balance` VALUES ('105', '20', '9', '500.00', '1', '1537538945', '0');
INSERT INTO `dp_seller_balance` VALUES ('106', '20', '9', '500.00', '1', '1537538946', '0');
INSERT INTO `dp_seller_balance` VALUES ('107', '20', '9', '500.00', '1', '1537538947', '0');
INSERT INTO `dp_seller_balance` VALUES ('108', '20', '9', '500.00', '1', '1537538949', '0');
INSERT INTO `dp_seller_balance` VALUES ('109', '20', '9', '500.00', '1', '1537538951', '0');
INSERT INTO `dp_seller_balance` VALUES ('110', '20', '9', '500.00', '1', '1537539349', '0');
INSERT INTO `dp_seller_balance` VALUES ('111', '20', '9', '500.00', '1', '1537539351', '0');
INSERT INTO `dp_seller_balance` VALUES ('112', '20', '9', '500.00', '1', '1537539352', '0');
INSERT INTO `dp_seller_balance` VALUES ('113', '20', '9', '500.00', '1', '1537539353', '0');
INSERT INTO `dp_seller_balance` VALUES ('114', '20', '9', '500.00', '1', '1537539357', '0');
INSERT INTO `dp_seller_balance` VALUES ('115', '20', '9', '500.00', '1', '1537841375', '0');
INSERT INTO `dp_seller_balance` VALUES ('116', '24', '0', '20.00', '2', '1537879927', '25');
INSERT INTO `dp_seller_balance` VALUES ('117', '24', '0', '20.00', '2', '1537880020', '26');
INSERT INTO `dp_seller_balance` VALUES ('118', '24', '0', '20.00', '2', '1537880097', '27');
INSERT INTO `dp_seller_balance` VALUES ('119', '24', '0', '10.00', '2', '1537880214', '28');
INSERT INTO `dp_seller_balance` VALUES ('120', '24', '0', '10.00', '2', '1537880551', '29');
INSERT INTO `dp_seller_balance` VALUES ('121', '24', '0', '10.00', '2', '1537880559', '30');
INSERT INTO `dp_seller_balance` VALUES ('122', '20', '9', '500.00', '1', '1538229156', '0');
INSERT INTO `dp_seller_balance` VALUES ('123', '20', '9', '500.00', '1', '1538229527', '0');
INSERT INTO `dp_seller_balance` VALUES ('124', '20', '9', '500.00', '1', '1538272441', '0');
INSERT INTO `dp_seller_balance` VALUES ('128', '20', '9', '500.00', '1', '1538274753', '0');
INSERT INTO `dp_seller_balance` VALUES ('141', '20', '9', '500.00', '1', '1538275771', '0');
INSERT INTO `dp_seller_balance` VALUES ('142', '20', '9', '500.00', '1', '1538276653', '0');
INSERT INTO `dp_seller_balance` VALUES ('143', '20', '9', '500.00', '1', '1538276772', '0');
INSERT INTO `dp_seller_balance` VALUES ('144', '20', '9', '500.00', '1', '1538277345', '0');
INSERT INTO `dp_seller_balance` VALUES ('145', '20', '9', '500.00', '1', '1538288288', '0');
INSERT INTO `dp_seller_balance` VALUES ('146', '20', '9', '500.00', '1', '1538288349', '0');
INSERT INTO `dp_seller_balance` VALUES ('147', '20', '9', '500.00', '1', '1538288362', '0');
INSERT INTO `dp_seller_balance` VALUES ('148', '20', '9', '500.00', '1', '1538288525', '0');
INSERT INTO `dp_seller_balance` VALUES ('149', '20', '9', '500.00', '1', '1538289843', '0');
INSERT INTO `dp_seller_balance` VALUES ('150', '1', '2', '201.01', '1', '1538290674', '0');
INSERT INTO `dp_seller_balance` VALUES ('151', '24', '11', '90.00', '1', '1538290832', '0');
INSERT INTO `dp_seller_balance` VALUES ('152', '20', '9', '500.00', '1', '1538291999', '0');
INSERT INTO `dp_seller_balance` VALUES ('153', '1', '2', '201.01', '1', '1538292075', '0');
INSERT INTO `dp_seller_balance` VALUES ('154', '1', '2', '201.01', '1', '1538292147', '0');
INSERT INTO `dp_seller_balance` VALUES ('155', '20', '0', '1.00', '2', '1539074159', '31');
INSERT INTO `dp_seller_balance` VALUES ('156', '20', '0', '10.21', '2', '1539074559', '32');
INSERT INTO `dp_seller_balance` VALUES ('157', '20', '0', '9.00', '2', '1539074972', '33');
INSERT INTO `dp_seller_balance` VALUES ('158', '20', '0', '25.95', '2', '1539074992', '34');
INSERT INTO `dp_seller_balance` VALUES ('159', '20', '0', '10.00', '2', '1539075574', '35');
INSERT INTO `dp_seller_balance` VALUES ('160', '20', '0', '10.00', '2', '1539075954', '36');
INSERT INTO `dp_seller_balance` VALUES ('161', '20', '0', '10.00', '2', '1539076006', '37');
INSERT INTO `dp_seller_balance` VALUES ('162', '20', '0', '10.00', '2', '1539076035', '38');
INSERT INTO `dp_seller_balance` VALUES ('163', '20', '0', '10.00', '2', '1539076044', '39');
INSERT INTO `dp_seller_balance` VALUES ('164', '20', '0', '10.00', '2', '1539076057', '40');
INSERT INTO `dp_seller_balance` VALUES ('165', '20', '0', '11.00', '2', '1539076115', '41');
INSERT INTO `dp_seller_balance` VALUES ('166', '20', '0', '11.00', '2', '1539076121', '42');
INSERT INTO `dp_seller_balance` VALUES ('167', '20', '0', '10.61', '2', '1539077315', '43');
INSERT INTO `dp_seller_balance` VALUES ('168', '20', '0', '10.61', '2', '1539078027', '44');
INSERT INTO `dp_seller_balance` VALUES ('169', '20', '0', '6.00', '2', '1539079534', '45');
INSERT INTO `dp_seller_balance` VALUES ('170', '20', '0', '29826.00', '2', '1539079543', '46');
INSERT INTO `dp_seller_balance` VALUES ('171', '20', '9', '50000.00', '1', '1539079555', '0');
INSERT INTO `dp_seller_balance` VALUES ('172', '20', '9', '500.00', '1', '1539141699', '0');
INSERT INTO `dp_seller_balance` VALUES ('173', '20', '9', '500.00', '1', '1539141743', '0');
INSERT INTO `dp_seller_balance` VALUES ('174', '20', '0', '9.00', '2', '1539142843', '47');
INSERT INTO `dp_seller_balance` VALUES ('175', '20', '0', '666.00', '2', '1539143088', '48');
INSERT INTO `dp_seller_balance` VALUES ('176', '20', '0', '666.00', '1', '1539143123', '48');
INSERT INTO `dp_seller_balance` VALUES ('177', '20', '0', '666.00', '2', '1539143143', '48');
INSERT INTO `dp_seller_balance` VALUES ('178', '20', '9', '500.00', '1', '1539143278', '0');

-- ----------------------------
-- Table structure for dp_seller_cash
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_cash`;
CREATE TABLE `dp_seller_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家提现id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `cash_account_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家提现账号表id',
  `nowbalance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '当前余额',
  `cash_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `cash_fee` varchar(50) NOT NULL DEFAULT '' COMMENT '提现手续费',
  `fact_cash_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '应打款金额',
  `cash_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '提现状态,1未处理,2已驳回,3已打款',
  `cash_time` int(11) NOT NULL DEFAULT '0' COMMENT '提现时间',
  `make_time` int(11) unsigned NOT NULL COMMENT '打款时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_cash
-- ----------------------------
INSERT INTO `dp_seller_cash` VALUES ('1', '1', '1', '30.00', '20.00', '0.2', '19.80', '3', '1536302564', '1536305776');
INSERT INTO `dp_seller_cash` VALUES ('3', '1', '1', '5000.00', '3000.00', '30', '2970.00', '2', '1536310529', '0');
INSERT INTO `dp_seller_cash` VALUES ('4', '1', '1', '3000.00', '2000.00', '20', '1980.00', '3', '1536310529', '1536310453');
INSERT INTO `dp_seller_cash` VALUES ('5', '1', '1', '600.00', '100.00', '1', '99.00', '3', '1536310529', '1536310552');
INSERT INTO `dp_seller_cash` VALUES ('6', '1', '1', '500.00', '100.00', '1', '99.00', '3', '1536310529', '1536310552');
INSERT INTO `dp_seller_cash` VALUES ('7', '1', '1', '200.00', '100.00', '1', '99.00', '2', '1537351841', '0');
INSERT INTO `dp_seller_cash` VALUES ('8', '1', '5', '20.00', '50.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('9', '1', '5', '20.00', '50.00', '0.5', '49.50', '2', '1537347992', '0');
INSERT INTO `dp_seller_cash` VALUES ('10', '1', '3', '60.00', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('11', '1', '3', '60.00', '10.00', '0.1', '9.90', '3', '0', '1537348255');
INSERT INTO `dp_seller_cash` VALUES ('12', '1', '3', '50.00', '10.00', '0.1', '9.90', '3', '0', '1537351827');
INSERT INTO `dp_seller_cash` VALUES ('13', '20', '3', '100.00', '10.00', '0.1', '9.90', '2', '1537348271', '0');
INSERT INTO `dp_seller_cash` VALUES ('14', '20', '3', '500.00', '10.00', '', '0.00', '2', '1536310529', '0');
INSERT INTO `dp_seller_cash` VALUES ('15', '1', '1', '30.00', '20.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('16', '1', '1', '10.00', '20.00', '0.2', '19.80', '3', '0', '1537348107');
INSERT INTO `dp_seller_cash` VALUES ('17', '1', '1', '140.00', '20.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('18', '1', '1', '120.00', '20.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('19', '20', '10', '4.00', '6.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('20', '20', '10', '3.00', '1.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('21', '20', '10', '2.00', '1.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('22', '20', '10', '1.00', '1.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('23', '20', '10', '0.00', '1.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('24', '20', '10', '981.00', '20.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('25', '24', '12', '480.00', '20.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('26', '24', '14', '460.00', '20.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('27', '24', '11', '440.00', '20.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('28', '24', '11', '430.00', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('29', '24', '12', '420.00', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('30', '24', '12', '410.00', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('31', '20', '10', '29980.00', '1.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('32', '20', '10', '29969.00', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('33', '20', '10', '29960.00', '9.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('34', '20', '10', '29934.00', '25.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('35', '20', '10', '29924.00', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('36', '20', '10', '29914.84', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('37', '20', '10', '29904.84', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('38', '20', '10', '29894.84', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('39', '20', '10', '29884.84', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('40', '20', '10', '29874.84', '10.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('41', '20', '10', '29863.84', '11.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('42', '20', '10', '29852.84', '11.00', '0.11', '10.89', '3', '0', '1539142915');
INSERT INTO `dp_seller_cash` VALUES ('43', '20', '10', '29842.39', '10.61', '0.1061', '10.50', '3', '0', '1539077877');
INSERT INTO `dp_seller_cash` VALUES ('44', '20', '10', '29831.39', '10.61', '0.11', '10.50', '3', '0', '1539078096');
INSERT INTO `dp_seller_cash` VALUES ('45', '20', '10', '29826.00', '6.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('46', '20', '10', '0.00', '29826.00', '298.26', '29527.74', '3', '0', '1539143052');
INSERT INTO `dp_seller_cash` VALUES ('47', '20', '10', '50991.00', '9.00', '', '0.00', '1', '0', '0');
INSERT INTO `dp_seller_cash` VALUES ('48', '20', '8', '50325.00', '666.00', '6.66', '659.34', '3', '1539143123', '1539143143');

-- ----------------------------
-- Table structure for dp_seller_comment
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_comment`;
CREATE TABLE `dp_seller_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_comment
-- ----------------------------
INSERT INTO `dp_seller_comment` VALUES ('1', '哈哈,谢谢', '1537329457');
INSERT INTO `dp_seller_comment` VALUES ('2', '不好就别来了', '1537329523');
INSERT INTO `dp_seller_comment` VALUES ('3', '不好就别来了', '1537329566');
INSERT INTO `dp_seller_comment` VALUES ('4', '不好就别来了', '1537329627');
INSERT INTO `dp_seller_comment` VALUES ('5', '不好就别来了', '1537329639');
INSERT INTO `dp_seller_comment` VALUES ('6', '不好就别来了', '1537329671');
INSERT INTO `dp_seller_comment` VALUES ('7', '不好就别来了', '0');
INSERT INTO `dp_seller_comment` VALUES ('8', '不好就别来了', '1537329967');
INSERT INTO `dp_seller_comment` VALUES ('9', '不好就别来', '1537339974');
INSERT INTO `dp_seller_comment` VALUES ('10', '不好就别来了wocao', '1537339994');
INSERT INTO `dp_seller_comment` VALUES ('11', '不好就别来了卧槽', '1537340001');
INSERT INTO `dp_seller_comment` VALUES ('12', '不好就别来了草拟吗', '1537340008');
INSERT INTO `dp_seller_comment` VALUES ('13', '不好就别来了草', '1537340017');
INSERT INTO `dp_seller_comment` VALUES ('14', '不好就别来了,草', '1537340023');
INSERT INTO `dp_seller_comment` VALUES ('15', '不好就别来了卧槽', '1537340043');
INSERT INTO `dp_seller_comment` VALUES ('16', '不好就别来了草拟吗', '1537340054');
INSERT INTO `dp_seller_comment` VALUES ('17', '不好就别来了草拟吗', '1537340103');
INSERT INTO `dp_seller_comment` VALUES ('18', '不好就别来了草拟吗', '1537341272');
INSERT INTO `dp_seller_comment` VALUES ('19', '测试回复', '1537347062');
INSERT INTO `dp_seller_comment` VALUES ('20', '测试回复', '1537353682');
INSERT INTO `dp_seller_comment` VALUES ('21', '', '1537511918');
INSERT INTO `dp_seller_comment` VALUES ('22', '123', '1537511931');
INSERT INTO `dp_seller_comment` VALUES ('23', '123', '1537511992');
INSERT INTO `dp_seller_comment` VALUES ('24', '哈哈哈哈', '1537512601');
INSERT INTO `dp_seller_comment` VALUES ('25', '一这破这是我朋友', '1538207167');
INSERT INTO `dp_seller_comment` VALUES ('26', '咯偶图据了解', '1538207408');
INSERT INTO `dp_seller_comment` VALUES ('27', '哈哈哈哈', '1538289514');
INSERT INTO `dp_seller_comment` VALUES ('28', '哈哈哈哈1', '1538291048');
INSERT INTO `dp_seller_comment` VALUES ('29', '哈哈哈哈1', '1538291089');
INSERT INTO `dp_seller_comment` VALUES ('30', '哦豁', '1538291115');
INSERT INTO `dp_seller_comment` VALUES ('31', '哦豁11213', '1538291820');
INSERT INTO `dp_seller_comment` VALUES ('32', '哦豁11213', '1538291873');
INSERT INTO `dp_seller_comment` VALUES ('33', '明明', '1539143397');

-- ----------------------------
-- Table structure for dp_seller_message
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_message`;
CREATE TABLE `dp_seller_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家消息中心id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `seller_service_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家服务id',
  `sellername` varchar(100) NOT NULL DEFAULT '' COMMENT '商家名称',
  `servicename` varchar(100) NOT NULL DEFAULT '' COMMENT '服务名称',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` varchar(255) NOT NULL COMMENT '消息内容',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `user_order_id` int(11) NOT NULL COMMENT '用户订单id',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读,0未读,1已读',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1代表提现类型(10发起提现,11提现到账,12提现驳回),2代表用户评论,3代表订单通知,4代表审核 40代表审核待处理,41代表审核通过,42审核驳回',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_message
-- ----------------------------
INSERT INTO `dp_seller_message` VALUES ('1', '1', '0', '', '', '发起提现', '尊敬的ali,您于2018-09-19 16:33:52发起提现号为16的提现已发起,请知晓', '1537346032', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('2', '1', '0', '', '', '提现驳回', '尊敬的店主,您于2018-09-19 17:06:32发起的提现被驳回,驳回原因为:驳回测试', '1537347992', '0', '1', '12');
INSERT INTO `dp_seller_message` VALUES ('3', '1', '0', '', '', '提现到账', '尊敬的店主,您于2018-09-19 17:08:27发起的提现已打款,请知晓~', '1537348107', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('4', '1', '0', '', '', '提现到账', '尊敬的店主,您于2018-09-19 17:10:55发起的提现已打款,请知晓~', '1537348255', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('5', '20', '0', '', '', '提现驳回', '尊敬的店主,您于2018-09-19 17:11:11发起的提现被驳回,驳回原因为:驳回', '1537348271', '0', '1', '12');
INSERT INTO `dp_seller_message` VALUES ('7', '1', '0', '', '', '提现到账', '尊敬的店主,您于2018-09-19 18:10:27发起的提现已打款,请知晓~', '1537351827', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('8', '1', '0', '', '', '提现驳回', '尊敬的店主,您于2018-09-19 18:10:41发起的提现被驳回,驳回原因为:驳回没理由', '1537358188', '0', '1', '12');
INSERT INTO `dp_seller_message` VALUES ('13', '1', '1', '江北红火洗车行', '李大大洗车', '服务审核通过', '尊敬的江北红火洗车行,您提交的服务:江北红火洗车行。审核已通过,请知晓', '1537358188', '0', '1', '41');
INSERT INTO `dp_seller_message` VALUES ('14', '1', '1', '江北红火洗车行', '李大大洗车', '订单通知', '订单测试', '1537358188', '0', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('15', '1', '0', '', '', '发起提现', '尊敬的ali,您于2018-09-20 10:02:21发起提现号为17的提现已发起,请知晓', '1537408941', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('16', '1', '0', '', '', '发起提现', '尊敬的ali,您于2018-09-20 10:04:02发起提现号为18的提现已发起,请知晓', '1537409042', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('17', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-09-20 15:01:46发起提现号为19的提现已发起,请知晓', '1537426906', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('18', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-09-20 15:03:22发起提现号为20的提现已发起,请知晓', '1537427002', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('19', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-09-20 15:38:28发起提现号为21的提现已发起,请知晓', '1537429108', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('20', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-09-20 15:39:08发起提现号为22的提现已发起,请知晓', '1537429108', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('21', '20', '0', '江北红火洗车行', '李大大洗车', '发起提现', '尊敬的陈鑫,您于2018-09-20 15:45:56发起提现号为23的提现已发起,请知晓', '1537430591', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('22', '20', '0', '江北红火洗车行', '李大大洗车', '发起提现', '尊敬的陈鑫,您于2018-09-20 15:48:40发起提现号为24的提现已发起,请知晓', '1537430591', '0', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('23', '20', '9', '反对广告', '很好看', '服务审核通过', '尊敬的反对广告,您提交的服务:反对广告。审核已通过,请知晓', '1537510604', '0', '1', '41');
INSERT INTO `dp_seller_message` VALUES ('24', '20', '5', '反对广告', 'dsf', '服务被驳回', '尊敬的反对广告,您添加的服务:反对广告。已被驳回,请知晓', '1537511081', '0', '1', '40');
INSERT INTO `dp_seller_message` VALUES ('25', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537529320', '10', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('26', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537529350', '11', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('27', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537529392', '12', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('28', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537529413', '13', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('29', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537529423', '14', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('30', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537532363', '15', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('31', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537532421', '16', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('32', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537532437', '17', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('33', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537532442', '18', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('34', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537532969', '19', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('35', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537533127', '20', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('36', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537533453', '21', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('37', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537536986', '22', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('38', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537005', '23', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('39', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537344', '24', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('40', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537605', '25', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('41', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537618', '26', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('42', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537622', '27', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('43', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537666', '28', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('44', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537678', '29', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('45', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537537873', '30', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('46', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538268', '31', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('47', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538275', '32', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('48', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538290', '33', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('49', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538293', '34', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('50', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538297', '35', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('51', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538301', '36', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('52', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538303', '37', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('53', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538307', '38', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('54', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538310', '39', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('55', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538311', '40', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('56', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538313', '41', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('57', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538541', '42', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('58', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538937', '43', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('59', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538939', '44', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('60', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538941', '45', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('61', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538942', '46', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('62', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538943', '47', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('63', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538944', '48', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('64', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538945', '49', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('65', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538946', '50', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('66', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538948', '51', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('67', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538949', '52', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('68', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537538951', '53', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('69', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537539349', '54', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('70', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537539351', '55', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('71', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537539352', '56', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('72', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537539353', '57', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('73', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537539357', '58', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('74', '20', '9', '', '9', '订单通知', '陈鑫1购买了您的9请知晓', '1537841375', '59', '1', '0');
INSERT INTO `dp_seller_message` VALUES ('75', '24', '0', '', '', '发起提现', '尊敬的刘亚东,您于2018-09-25 20:52:07发起提现号为25的提现已发起,请知晓', '1537879927', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('76', '24', '0', '', '', '发起提现', '尊敬的刘亚东,您于2018-09-25 20:53:40发起提现号为26的提现已发起,请知晓', '1537880020', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('77', '24', '0', '', '', '发起提现', '尊敬的刘亚东,您于2018-09-25 20:54:57发起提现号为27的提现已发起,请知晓', '1537880097', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('78', '24', '0', '', '', '发起提现', '尊敬的刘亚东,您于2018-09-25 20:56:54发起提现号为28的提现已发起,请知晓', '1537880214', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('79', '24', '0', '', '', '发起提现', '尊敬的刘亚东,您于2018-09-25 21:02:31发起提现号为29的提现已发起,请知晓', '1537880551', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('80', '24', '0', '', '', '发起提现', '尊敬的刘亚东,您于2018-09-25 21:02:39发起提现号为30的提现已发起,请知晓', '1537880559', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('81', '20', '9', '测测测0929', '很好看', '订单通知', '我是购买了您的很好看请知晓', '1538229156', '60', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('82', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538229527', '61', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('83', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538272441', '62', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('84', '20', '9', '测测测0929', '很好看', '订单通知', '我是购买了您的很好看请知晓', '1538274754', '63', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('85', '20', '9', '测测测0929', '很好看', '订单通知', '我是购买了您的很好看请知晓', '1538275771', '64', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('86', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538276653', '65', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('87', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538276772', '66', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('88', '20', '9', '测测测0929', '很好看', '订单通知', '我是购买了您的很好看请知晓', '1538277345', '67', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('89', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538288288', '68', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('90', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538288349', '69', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('91', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538288362', '70', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('92', '20', '9', '', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538288525', '71', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('93', '20', '9', '反对广告', '很好看', '订单通知', '哈哈购买了您的很好看请知晓', '1538289843', '72', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('94', '1', '2', '', '李小小洗车', '订单通知', '哈哈购买了您的李小小洗车请知晓', '1538290674', '73', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('95', '24', '11', '', '亏咯旅途图', '订单通知', '哈哈购买了您的亏咯旅途图请知晓', '1538290832', '74', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('96', '20', '9', '反对广告', '很好看', '订单通知', '幼儿园购买了您的很好看请知晓', '1538291999', '75', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('97', '1', '2', '', '李小小洗车', '订单通知', '哈哈购买了您的李小小洗车请知晓', '1538292075', '76', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('98', '1', '2', '', '李小小洗车', '订单通知', '哈哈购买了您的李小小洗车请知晓', '1538292147', '77', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('99', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 16:35:59发起提现号为31的提现已发起,请知晓', '1539074159', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('100', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 16:42:39发起提现号为32的提现已发起,请知晓', '1539074559', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('101', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 16:49:32发起提现号为33的提现已发起,请知晓', '1539074972', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('102', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 16:49:52发起提现号为34的提现已发起,请知晓', '1539074992', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('103', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 16:59:34发起提现号为35的提现已发起,请知晓', '1539075574', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('104', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:05:54发起提现号为36的提现已发起,请知晓', '1539075954', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('105', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:06:46发起提现号为37的提现已发起,请知晓', '1539076006', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('106', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:07:15发起提现号为38的提现已发起,请知晓', '1539076035', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('107', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:07:24发起提现号为39的提现已发起,请知晓', '1539076044', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('108', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:07:37发起提现号为40的提现已发起,请知晓', '1539076057', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('109', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:08:35发起提现号为41的提现已发起,请知晓', '1539076115', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('110', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:08:41发起提现号为42的提现已发起,请知晓', '1539076121', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('111', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:28:35发起提现号为43的提现已发起,请知晓', '1539077315', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('112', '20', '0', '', '', '提现到账', '尊敬的店主,您于2018-10-09 17:37:57发起的提现已打款,请知晓~', '1539077877', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('113', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 17:40:27发起提现号为44的提现已发起,请知晓', '1539078027', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('114', '20', '0', '', '', '提现到账', '尊敬的店主,您于2018-10-09 17:41:36发起的提现已打款,请知晓~', '1539078096', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('115', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 18:05:34发起提现号为45的提现已发起,请知晓', '1539079534', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('116', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-09 18:05:43发起提现号为46的提现已发起,请知晓', '1539079543', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('117', '20', '9', '反对广告', '服务名:很好看', '订单通知', '哈哈购买了您的服务名:很好看请知晓', '1539141699', '78', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('118', '20', '9', '反对广告', '服务名:很好看', '订单通知', '哈哈购买了您的服务名:很好看请知晓', '1539141743', '79', '1', '3');
INSERT INTO `dp_seller_message` VALUES ('119', '20', '0', '', '', '发起提现', '尊敬的陈鑫,您于2018-10-10 11:40:43发起提现号为47的提现已发起,请知晓', '1539142843', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('120', '20', '0', '', '', '提现到账', '尊敬的店主,您于2018-10-10 11:41:55发起的提现已打款,请知晓~', '1539142915', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('121', '20', '0', '', '', '提现到账', '尊敬的店主,您于2018-10-10 11:44:12发起的提现已打款,请知晓~', '1539143052', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('122', '20', '0', '', '', '发起提现', '尊敬的彭林,您于2018-10-10 11:44:48发起提现号为48的提现已发起,请知晓', '1539143088', '0', '1', '10');
INSERT INTO `dp_seller_message` VALUES ('123', '20', '0', '', '', '提现驳回', '尊敬的店主,您于2018-10-10 11:45:23发起的提现被驳回,驳回原因为:不打款', '1539143123', '0', '1', '12');
INSERT INTO `dp_seller_message` VALUES ('124', '20', '0', '', '', '提现到账', '尊敬的店主,您于2018-10-10 11:45:43发起的提现已打款,请知晓~', '1539143143', '0', '1', '11');
INSERT INTO `dp_seller_message` VALUES ('125', '20', '9', '', '服务名:很好看', '订单通知', '哈哈购买了您的服务名:很好看请知晓', '1539143278', '80', '1', '3');

-- ----------------------------
-- Table structure for dp_seller_picture
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_picture`;
CREATE TABLE `dp_seller_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家图片id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `pic_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '图片类型,1店铺图片,2商家介绍图,3营业执照',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_picture
-- ----------------------------
INSERT INTO `dp_seller_picture` VALUES ('1', '4', '1', '9,10,11');
INSERT INTO `dp_seller_picture` VALUES ('2', '4', '2', '12');
INSERT INTO `dp_seller_picture` VALUES ('3', '4', '3', '8');
INSERT INTO `dp_seller_picture` VALUES ('4', '3', '1', '17,18,19');
INSERT INTO `dp_seller_picture` VALUES ('5', '3', '2', '17');
INSERT INTO `dp_seller_picture` VALUES ('6', '3', '3', '18');

-- ----------------------------
-- Table structure for dp_seller_position
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_position`;
CREATE TABLE `dp_seller_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '职位id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `position` varchar(100) NOT NULL DEFAULT '' COMMENT '职位名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `role_node` varchar(100) NOT NULL DEFAULT '' COMMENT '权限节点',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用,0启用,1禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_position
-- ----------------------------
INSERT INTO `dp_seller_position` VALUES ('2', '1', '店主', '1535947450', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('10', '11', '店主', '0', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('12', '1', '三当家', '1536915264', '1,2,3,4,5,6,7,8', '0');
INSERT INTO `dp_seller_position` VALUES ('14', '1', '大熊', '1536917074', '1,2,3', '0');
INSERT INTO `dp_seller_position` VALUES ('16', '15', '店主', '1537238914', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('17', '16', '店主', '1537247929', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('18', '17', '店主', '1537248503', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('19', '18', '店主', '1537248866', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('20', '19', '店主', '1537249658', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('21', '20', '店主', '1537250618', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('22', '21', '店主', '1537253122', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('23', '22', '店主', '1537253972', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('25', '23', '店主', '1537266730', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('28', '20', '精细工', '1537274245', '2,5', '0');
INSERT INTO `dp_seller_position` VALUES ('29', '20', '小店员', '1537342107', '4,6,7', '0');
INSERT INTO `dp_seller_position` VALUES ('30', '24', '店主', '1537517018', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('31', '25', '店主', '1537517606', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('32', '26', '店主', '1537933741', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('33', '27', '店主', '1537936816', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('34', '28', '店主', '1537960364', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('36', '24', '打蜡', '1537964449', '1,1,4,2', '0');
INSERT INTO `dp_seller_position` VALUES ('42', '24', '测试职位', '1538210611', '1,2,3,5,6,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('43', '29', '店主', '1538029048', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('44', '30', '店主', '1538029299', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('45', '24', '洗车', '1538210528', '3,2,1,9', '0');
INSERT INTO `dp_seller_position` VALUES ('46', '24', '修车', '1538210555', '1,2,3,9,5', '0');
INSERT INTO `dp_seller_position` VALUES ('47', '24', '主管', '1538210584', '1,2,3,5,6,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('48', '24', '副店长', '1538210611', '1,2,3,4,5,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('49', '20', '大哥', '1539069126', '1', '0');
INSERT INTO `dp_seller_position` VALUES ('50', '31', '店主', '1539230160', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('51', '32', '店主', '1539233598', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('52', '33', '店主', '1539245305', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('53', '34', '店主', '1539251444', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('54', '35', '店主', '1539317059', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('55', '36', '店主', '1539594610', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('56', '37', '店主', '1539598512', '1,2,3,4,5,6,7,8,9', '0');
INSERT INTO `dp_seller_position` VALUES ('57', '38', '店主', '1539598684', '1,2,3,4,5,6,7,8,9', '0');

-- ----------------------------
-- Table structure for dp_seller_reject
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_reject`;
CREATE TABLE `dp_seller_reject` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '提现驳回id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `relevant_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家/服务/提现id',
  `reject_reason` varchar(255) NOT NULL DEFAULT '0' COMMENT '驳回原因',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `reject_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '驳回类别',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '驳回时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_reject
-- ----------------------------
INSERT INTO `dp_seller_reject` VALUES ('3', '1', '3', '就不打款就不打款就不打款就不打款就不打款就不打款就不打款', '', '1', '1536302564');
INSERT INTO `dp_seller_reject` VALUES ('4', '1', '5', '没钱了', '', '1', '1536310529');
INSERT INTO `dp_seller_reject` VALUES ('5', '20', '14', '拒绝打款', '', '1', '1536310529');
INSERT INTO `dp_seller_reject` VALUES ('6', '1', '9', '驳回测试', '', '1', '1537347992');
INSERT INTO `dp_seller_reject` VALUES ('7', '20', '13', '驳回', '', '1', '1537348271');
INSERT INTO `dp_seller_reject` VALUES ('8', '1', '7', '驳回没理由', '', '1', '1537351841');
INSERT INTO `dp_seller_reject` VALUES ('9', '20', '48', '不打款', '', '1', '1539143123');

-- ----------------------------
-- Table structure for dp_seller_service
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_service`;
CREATE TABLE `dp_seller_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家服务id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `homepage_cate_parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '服务类别一级分类id',
  `homepage_cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '首页服务类别',
  `servicename` varchar(30) NOT NULL DEFAULT '' COMMENT '服务名称',
  `serviceprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '服务价格',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '服务备注',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) NOT NULL,
  `is_release` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态,0审核中,1审核通过,2驳回',
  `is_startrights` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启权益卡,0不开启,1开启',
  `is_timescard` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否支持次卡,0不支持,1支持',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除,0不删除,1删除',
  PRIMARY KEY (`id`),
  KEY `sellerservice` (`servicename`,`serviceprice`,`remark`(191),`create_time`,`is_release`,`is_timescard`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_service
-- ----------------------------
INSERT INTO `dp_seller_service` VALUES ('1', '1', '2', '7', '李大大洗车', '150.88', '李大大洗车', '1535947120', '1538040592', '1', '1', '1', '0');
INSERT INTO `dp_seller_service` VALUES ('2', '1', '1', '6', '李小小洗车', '201.01', '李大大洗车', '1535947120', '1536046353', '1', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('3', '1', '1', '6', 'po测试名称', '15.22', '服务详情', '1537273210', '0', '0', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('4', '1', '1', '2', '你们在', '200.00', '一直说我', '1537273210', '1537273210', '0', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('5', '20', '1', '2', 'dsf', '500.00', 'fgdfgdgdgdg', '1537506259', '1537506259', '2', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('6', '20', '1', '2', 'fdsfs', '800.00', 'dgdfgfdgdfdg', '1537506319', '1537506319', '0', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('7', '1', '1', '2', '啊啊啊', '255.00', '爸爸啊的呃呃呃噜啦噜啦嘞', '1537507821', '1537507821', '0', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('8', '1', '3', '6', '封锶服务', '200.00', '介绍', '1537508302', '1537508302', '0', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('9', '20', '1', '2', '服务名:很好看', '500.00', '士大夫第三方第三方第三方', '1537510558', '1537510558', '1', '1', '1', '0');
INSERT INTO `dp_seller_service` VALUES ('10', '20', '2', '7', '看了看', '80.00', '啊啊啊', '1537512681', '1537512681', '0', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('11', '24', '1', '3', '亏咯旅途图', '90.00', '可我图图找我', '1538120302', '1538120336', '1', '1', '0', '0');
INSERT INTO `dp_seller_service` VALUES ('12', '24', '3', '8', '哦句我老九门', '100.00', '咯渐酒空金榼咯大的哦哦渐酒', '1538124909', '1538124909', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for dp_seller_staff
-- ----------------------------
DROP TABLE IF EXISTS `dp_seller_staff`;
CREATE TABLE `dp_seller_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商家员工id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `seller_position_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '员工职位id',
  `staffname` varchar(48) NOT NULL DEFAULT '' COMMENT '员工姓名',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '员工手机号码',
  `password` varchar(100) NOT NULL DEFAULT '' COMMENT '默认密码',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_disabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否停用,0不停用,1停用',
  `is_shopkeeper` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是店长,0不是,1是',
  PRIMARY KEY (`id`),
  KEY `staffmobile` (`mobile`) USING BTREE,
  KEY `staffpwd` (`password`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_seller_staff
-- ----------------------------
INSERT INTO `dp_seller_staff` VALUES ('1', '1', '2', '江北店长', '18215467894', '$2y$10$zGvjIsTyFL72HQGn78HxIefTAlCG1mhcH9QrB4tfNslu/t7OtkX9q', '1535947120', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('4', '11', '10', 'id为9的商家', '17623763507', '$2y$10$Q4iQkwiuXHaMleG7HeT0peN5CXe2zKghvxNK2q6DRv/lKsUNShsuO', '0', '1536906625', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('8', '15', '16', 'aabbcc', '18845671234', '$2y$10$P4RgJrMpT8nor3lNREUZ2uf2PFrFcP0.oC.AADq2bSiAGjN62dBi6', '1537238914', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('9', '16', '17', '我在', '17708323309', '$2y$10$fagRM2OZKCMI0XIRJECRDeT.08atFkKnQ9XRWh7lODs4SLrJVIOky', '1537247929', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('10', '17', '18', '左右', '17708359074', '$2y$10$Prp.JBDs4fKC86pvu1aY7ubhylzjwpxBbSyHtXf.RBjwztB69fmUm', '1537248504', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('11', '18', '19', '我在', '17708938504', '$2y$10$2VuPRIX9WL/bgGj8b9dqKe8I6N.uK39vKVHj3Y/cGOMAPcYOKSufW', '1537248866', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('12', '19', '20', '测试', '17708323304', '$2y$10$89dljSKSIUvv53gujvvEVunaFXEpik3nt762.4t0LEpUwgwTsFnOm', '1537249658', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('13', '20', '21', '小李', '13996379929', '$2y$10$znKRjcyBDjxEmwQ01JNixOmz5LIJWtHEQOFOrafvqMVbqhLsvVwyq', '1537250618', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('14', '21', '22', '山东省的', '15856789876', '$2y$10$wjcuxhmbkby1nNEgnz3wNefzVRV6mrebDK1rLBhr3/YGnccw/KJbe', '1537253122', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('15', '22', '23', '测试', '17708323306', '$2y$10$Jgj9SZgO2MqIb5to6e0x7.UX8agQwaM28g57dr8SU/4yVib8JkpN6', '1537253972', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('16', '23', '25', 'c测测', '15578941258', '$2y$10$tAI9Lvz7cPS7Gdw37dKRl.2Ko3KzcfJx1i1qfqetagI6n/9Vezao.', '1537266730', '1537266730', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('17', '20', '26', '的撒旦撒', '15223049994', '$2y$10$wmc90rhxd3arg8nAVbIkx.O/5NpWXFJlrbtxg9Asm5jJvJLbjK4rO', '1537276565', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('19', '20', '26', '小红', '18966666666', '$2y$10$MnPvPTE0TSrlThjJXk2Gs.OvZP3eqVuVUJWsAp7o64RAP/V1x5ndK', '1537321605', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('20', '20', '28', '士大夫地方', '15878963589', '$2y$10$LodKtg1VLyaYwQhm6hEIjegvF3ZAwyenjROhuEJ2Nm8XS3UYQ.YQG', '1537349240', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('21', '20', '27', '郭德纲', '17877474455', '$2y$10$Bz7FqpNcIkiifBI41Hf1Q.lceGdGt9EpFTTtZsOKtbzzGXr9zZ6ai', '1537349510', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('22', '20', '27', '郭德纲', '17877474457', '$2y$10$/bqwLLzSJyYCLbCtVkhYfet/C2LDqT877vyGoF.VtDudWmm997Cn6', '1537349535', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('24', '20', '26', '捧场', '15899999999', '$2y$10$EDFfMOsPFkMLCS2ZPWhiMOnqRWVqqIccl3xmuDC1E7H0DhquLLXJK', '1537351041', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('25', '20', '26', '小彭', '15223049998', '$2y$10$lVBVunSvg6PM/H8ZjlN9XeQa9FslLjqUKiISRteqxFP4P8BPECedG', '1537352532', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('26', '20', '29', '的撒旦撒', '15223049994', '$2y$10$Et.C9RH3pfXbjOwiXLBgceiaHQWvnS6k2/vPE4CUgTpUEgMGnNLli', '1537428928', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('27', '20', '29', '的撒旦撒', '15223049998', '$2y$10$v5ovsrzEPNTSFHvM9HAW8unxcRWTvEUdr7Lj3YwptjFdruyLLZgWK', '1537428947', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('28', '24', '30', '阿里健康', '18738277443', '$2y$10$1wMQS1j7lDCJ.W7diMyNjurok0ic2D2Wln68fcCtyr9h8CqhiB/96', '1537517018', '1537517018', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('29', '25', '31', '考虑考虑', '18728745632', '$2y$10$2aUC6lkidq6oXiP4E9MdQueh9trg6e1011dLRWHFcURs.4656zxdi', '1537517606', '1537517606', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('30', '26', '32', '全文', '18778945612', '$2y$10$qgo.X41Kl.BXcJr6yL50X.vbpPOvhsfGqYMXxbF79OC1DKPvvlYh2', '1537933741', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('31', '27', '33', '三生三世', '15978956547', '$2y$10$zaIhIihIr6G./Blp9lX7oeIrVYb2PDuLfoI30hu23WzUFlJzBWxxy', '1537936816', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('32', '28', '34', '梵蒂冈反对官方', '13996379927', '$2y$10$.W6BF7eC4FJqok9zOhMjjeUkxW9A.HGfPtpgsAwao/qoN./ZcW3EK', '1537960364', '1537960364', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('33', '24', '38', '张三2', '15123363366', '$2y$10$MZM3dMTmGSG25o61D2BuYOEy4U3HZBwYHrNIlogN9azvhxLTH3A8e', '1537965969', '1538019960', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('34', '24', '37', '历史', '13658842589', '$2y$10$rQD8q/mFVuDgTC5JaOyxRuF4NEd5yoMhGq6S/ifsimYA86S02Jvre', '1537966068', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('35', '24', '35', '李四', '18738277441', '$2y$10$BhkiUTRyAMajzOuz54R0sehiPmF296sJ3fZa4s2gRdS6KIaj9N2L2', '1537968190', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('36', '24', '42', '小丹1', '13674998077', '$2y$10$TBTkkUE8oQlC21a8GWXNO.u.UJ.lcOfvCpKLEUeUGoydv9TCMOb/C', '1538014294', '1539069215', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('42', '24', '41', '李四', '13674998077', '$2y$10$51FZjosxRy68M5icAJosZebCQIdMFWYd53LYMe6rE8/iiEtJbKOmy', '1538016586', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('43', '24', '39', '李四', '13674998077', '$2y$10$jxiWZZaLnuhpZRK8obhIXOS.u63QkqHqM4UwL4pDuMKw3LvVm.Upm', '1538016595', '1538018144', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('44', '24', '38', '张三2', '15123363369', '$2y$10$a/qllPe3Ebp6Sq4pfWmnlO6cITXXzq0hdhnKWfJTWV8KR6AKXt9hy', '1538016801', '1538030631', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('45', '24', '38', '张三1', '15123363369', '$2y$10$n4ZsXwfNbtr/.IYDVSfX8O5yfj5um4WmuBqlyjRmU2GKnzEsqdp5i', '1538016888', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('48', '24', '41', '哈哈哈', '18738277443', '$2y$10$jRcrfXEF0mXx59mwOiyP.O1dhd.yIdnNeDx7ZMPWBDcpaPvp5XsEC', '1538018168', '1538019156', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('49', '29', '43', '入驻入驻', '15578945623', '$2y$10$j4iMCHvGn6CLU0Qh.hMlt.2zKc29wqnaepVBGlQY1AFHzNClgibMG', '1538029048', '1538029048', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('50', '30', '44', '入驻1', '15678964512', '$2y$10$nEUg86BQ0NZLeMni0SOr7uUh2Gdo4R45v1WkagRqmJjjcMSOxiRta', '1538029299', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('51', '1', '4', '小丹', '15888888888', '$2y$10$tRWw1vwEPPnMF0Og1SqNlOnonqLopR4k8u98y7yzNSpdmHvOsJrAm', '1538038095', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('52', '1', '15', '咯路', '15874586325', '$2y$10$jFtPw9.7Y59UFZf4P8d5Xed7vKkre7xbV/5TRyoRfZubz6GQO2KDq', '1538207259', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('53', '1', '14', '咯路', '15632586324', '$2y$10$wNy1lAan2lVM2cCAePoK7OeJbWmqqPbs9vKVttBLk2oFScYPEExqy', '1538211825', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('54', '24', '36', '谋略', '13658742587', '$2y$10$qTlZftwnyW1uezDarSmr9uk4rgxuS5xFRRUSm5YZ.zZrh103kiGfm', '1538296423', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('55', '24', '45', '安静', '15863247528', '$2y$10$mMEfZChNtre755eA5aJj/erYVPylD4eR7rXIvHL6GPJ1qwuQR3C3u', '1538296467', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('56', '24', '46', '叶绿体', '13587412354', '$2y$10$xAq7Ud2Su9SfqW9m6f9VAuN2ZSOZ9BxklLeOD0ojimC505SpiVumu', '1538296489', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('57', '24', '47', '最近', '18963521478', '$2y$10$sPv8eBkuJa2jyG3d5TPknudVkEikF0mIw1Iu2DHYn1slS5itxZRTG', '1538296522', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('58', '24', '48', '数据库', '17652845217', '$2y$10$7I4ElmgW/qcEXJlzOzNlxuZ2x3p/PrnqhmhOHHbjS.8D20B0P9SCO', '1538296542', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('62', '24', '42', '小丹132', '13674998071', '$2y$10$v80g5RGjinf/AX5Dw.ZbZO.qyiaDlxOuXTbD5/HNgLEcclqHAFVu.', '1539069892', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('63', '20', '49', '看看', '15455588888', '$2y$10$FOMuYoTCINiqbfmzRC7nD.mREw/Ox5N/WeRnSOuH5bTS/kZomSP56', '1539070301', '0', '0', '0');
INSERT INTO `dp_seller_staff` VALUES ('64', '31', '50', '小邓', '15866666666', '$2y$10$xWeFU75cns6rLeNYxX9l0.Ck0A.4Si8je0QcIjCxAq7ba3mtUnQFa', '1539230160', '1539230160', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('65', '32', '51', '五里店', '15677779999', '$2y$10$536UYICOwez84yrPaqWSZe7rvFbmbn6SYSt5wpgEFJCGx2ojKqr9S', '1539233598', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('66', '33', '52', '上传图片插件测试', '18877779999', '$2y$10$jAyM1/8Lexi9skKHwMTBb.OgMKuu1zzmcxM72K6SlujSkxMO1/AVe', '1539245305', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('67', '34', '53', '图片上传插件测试', '18898987878', '$2y$10$fNkx9LFWIArqcDBeGKt9ouQe20hNzzoVwWxFtN8Daf5dMik6xVaQK', '1539251444', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('68', '35', '54', '测测测', '15566664444', '$2y$10$pIsr29NEDNAM02089twsU.pG5EM8d0RfxHuoyhjDiJCyhGpwmnNbW', '1539317059', '0', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('69', '36', '55', 'lyd', '17623464030', '$2y$10$OouduczgK/uMe21Xv89G1uwFKxu9G7F7JAJlux0nOHrjTUuGu5BcO', '1539594611', '1539594611', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('70', '37', '56', '测试', '15869696969', '$2y$10$zuaoIkdxJwzhjza0L24tJuqcwybCMVN53eg/ON4RDc7IQBfk7v0na', '1539598512', '1539598512', '0', '1');
INSERT INTO `dp_seller_staff` VALUES ('71', '38', '57', '图片上传', '15577779999', '$2y$10$AIEvsFSQzibe1Pqp.dBJRuHsZTLIX9DvmJ0dQ1ZfidMzwbBGrsEaa', '1539598684', '0', '0', '1');

-- ----------------------------
-- Table structure for dp_service_protocol
-- ----------------------------
DROP TABLE IF EXISTS `dp_service_protocol`;
CREATE TABLE `dp_service_protocol` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '服务协议id',
  `protocol_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '协议类别,1用户注册协议,2商家入驻协议3帮助协议4卡包使用说明5关于我们',
  `content` text NOT NULL COMMENT '协议内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0代表不启用,1启用',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不删,1删',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_service_protocol
-- ----------------------------
INSERT INTO `dp_service_protocol` VALUES ('1', '1', '<p>一、总则\r\n1.1 保宝网的所有权和运营权归深圳市永兴元科技有限公司所有。 \r\n1.2 用户在注册之前，应当仔细阅读本协议，并同意遵守本协议后方可成为注册用户。一旦注册成功，则用户与保宝网之间自动形成协议关系，用户应当受本协议的约束。用户在使用特殊的服务或产品时，应当同意接受相关协议后方能使用。 \r\n1.3 本协议则可由保宝网随时更新，用户应当及时关注并同意本站不承担通知义务。本站的通知、公告、声明或其它类似内容是本协议的一部分。\r\n二、服务内容\r\n2.1 保宝网的具体内容由本站根据实际情况提供。 \r\n2.2 本站仅提供相关的网络服务，除此之外与相关网络服务有关的设备(如个人电脑、手机、及其他与接入互联网或移动网有关的装置)及所需的费用(如为接入互联网而支付的电话费及上网费、为使用移动网而支付的手机费)均应由用户自行负担。\r\n三、用户帐号\r\n3.1 经本站注册系统完成注册程序并通过身份认证的用户即成为正式用户，可以获得本站规定用户所应享有的一切权限；未经认证仅享有本站规定的部分会员权限。保宝网有权对会员的权限设计进行变更。 \r\n3.2 用户只能按照注册要求使用真实姓名，及身份证号注册。用户有义务保证密码和帐号的安全，用户利用该密码和帐号所进行的一切活动引起的任何损失或损害，由用户自行承担全部责任，本站不承担任何责任。如用户发现帐号遭到未授权的使用或发生其他任何安全问题，应立即修改帐号密码并妥善保管，如有必要，请通知本站。因黑客行为或用户的保管疏忽导致帐号非法使用，本站不承担任何责任。\r\n四、使用规则\r\n4.1 遵守中华人民共和国相关法律法规，包括但不限于《中华人民共和国计算机信息系统安全保护条例》、《计算机软件保护条例》、《最高人民法院关于审理涉及计算机网络著作权纠纷案件适用法律若干问题的解释(法释[2004]1号)》、《全国人大常委会关于维护互联网安全的决定》、《互联网电子公告服务管理规定》、《互联网新闻信息服务管理规定》、《互联网著作权行政保护办法》和《信息网络传播权保护条例》等有关计算机互联网规定和知识产权的法律和法规、实施办法。 \r\n4.2 用户对其自行发表、上传或传送的内容负全部责任，所有用户不得在本站任何页面发布、转载、传送含有下列内容之一的信息，否则本站有权自行处理并不通知用户：\r\n(1)违反宪法确定的基本原则的； \r\n(2)危害国家安全，泄漏国家机密，颠覆国家政权，破坏国家统一的； \r\n(3)损害国家荣誉和利益的； \r\n(4)煽动民族仇恨、民族歧视，破坏民族团结的； \r\n(5)破坏国家宗教政策，宣扬邪教和封建迷信的； \r\n(6)散布谣言，扰乱社会秩序，破坏社会稳定的；\r\n(7)散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的； \r\n(8)侮辱或者诽谤他人，侵害他人合法权益的； \r\n(9)煽动非法集会、结社、游行、示威、聚众扰乱社会秩序的； \r\n(10)以非法民间组织名义活动的；\r\n(11)含有法律、行政法规禁止的其他内容的。\r\n4.3 用户承诺对其发表或者上传于本站的所有信息(即属于《中华人民共和国著作权法》规定的作品，包括但不限于文字、图片、音乐、电影、表演和录音录像制品和电脑程序等)均享有完整的知识产权，或者已经得到相关权利人的合法授权；如用户违反本条规定造成本站被第三人索赔的，用户应全额补偿本站一切费用(包括但不限于各种赔偿费、诉讼代理费及为此支出的其它合理费用)； \r\n4.4 当第三方认为用户发表或者上传于本站的信息侵犯其权利，并根据《信息网络传播权保护条例》或者相关法律规定向本站发送权利通知书时，用户同意本站可以自行判断决定删除涉嫌侵权信息，除非用户提交书面证据材料排除侵权的可能性，本站将不会自动恢复上述删除的信息；\r\n(1)不得为任何非法目的而使用网络服务系统； \r\n(2)遵守所有与网络服务有关的网络协议、规定和程序； (3)不得利用本站进行任何可能对互联网的正常运转造成不利影响的行为； \r\n(4)不得利用本站进行任何不利于本站的行为。\r\n4.5 如用户在使用网络服务时违反上述任何规定，本站有权要求用户改正或直接采取一切必要的措施(包括但不限于删除用户张贴的内容、暂停或终止用户使用网络服务的权利)以减轻用户不当行为而造成的影响。\r\n五、隐私保护\r\n5.1 本站不对外公开或向第三方提供单个用户的注册资料及用户在使用网络服务时存储在本站的非公开内容，但下列情况除外：\r\n(1)事先获得用户的明确授权； \r\n(2)根据有关的法律法规要求；\r\n(3)按照相关政府主管部门的要求；\r\n(4)为维护社会公众的利益。\r\n5.2 本站可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与本站同等的保护用户隐私的责任，则本站有权将用户的注册资料等提供给该第三方。\r\n5.3 在不透露单个用户隐私资料的前提下，本站有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。\r\n六、版权声明\r\n6.1 本站的文字、图片、音频、视频等版权均归永兴元科技有限公司享有或与作者共同享有，未经本站许可，不得任意转载。 \r\n6.2 本站特有的标识、版面设计、编排方式等版权均属永兴元科技有限公司享有，未经本站许可，不得任意复制或转载。 \r\n6.3 使用本站的任何内容均应注明“来源于保宝网”及署上作者姓名，按法律规定需要支付稿酬的，应当通知本站及作者及支付稿酬，并独立承担一切法律责任。\r\n6.4 本站享有所有作品用于其它用途的优先权，包括但不限于网站、电子杂志、平面出版等，但在使用前会通知作者，并按同行业的标准支付稿酬。\r\n6.5 本站所有内容仅代表作者自己的立场和观点，与本站无关，由作者本人承担一切法律责任。 \r\n6.6 恶意转载本站内容的，本站保留将其诉诸法律的权利。\r\n七、责任声明\r\n7.1 用户明确同意其使用本站网络服务所存在的风险及一切后果将完全由用户本人承担，保宝网对此不承担任何责任。 \r\n7.2 本站无法保证网络服务一定能满足用户的要求，也不保证网络服务的及时性、安全性、准确性。 \r\n7.3 本站不保证为方便用户而设置的外部链接的准确性和完整性，同时，对于该等外部链接指向的不由本站实际控制的任何网页上的内容，本站不承担任何责任。\r\n7.4 对于因不可抗力或本站不能控制的原因造成的网络服务中断或其它缺陷，本站不承担任何责任，但将尽力减少因此而给用户造成的损失和影响。\r\n7.5 对于站向用户提供的下列产品或者服务的质量缺陷本身及其引发的任何损失，本站无需承担任何责任：\r\n(1)本站向用户免费提供的各项网络服务； \r\n(2)本站向用户赠送的任何产品或者服务。\r\n7.6 本站有权于任何时间暂时或永久修改或终止本服务(或其任何部分)，而无论其通知与否，本站对用户和任何第三人均无需承担任何责任。\r\n八、附则\r\n8.1 本协议的订立、执行和解释及争议的解决均应适用中华人民共和国法律。 \r\n8.2 如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。\r\n8.3 本协议解释权及修订权归深圳永兴元科技有限公司所有。1</p>', '1537152798', '1538014415', '1', '0');
INSERT INTO `dp_service_protocol` VALUES ('2', '3', '<p>protocol_type</p>', '1537857467', '0', '1', '1');
INSERT INTO `dp_service_protocol` VALUES ('4', '4', '<h2 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px 8px 0px 18px; font-size: 22px; float: left; line-height: 24px; font-weight: 400; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">简介</h2><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\"><span style=\"font-size: 16px;\">产品使用说明书是介绍产品安装、调试、使用、维修保养的应用文本。它是一种有关产品知识和使用须知的科技应用文体。一般按照用户的认知习惯和认知程度，按照一定次序准确阐述。 它广泛地使用在各类产品上，它是科技应用文中使用范围最广、适用面最大的一种文体。不同类型的产品，对产品说明书的要求也不一样，生活用产品及部分医药品的说明书内容简单，篇幅较短，具有广告色彩；生产、科研用产品、专用产品、仪器设备产品的说明书内容较为详细，具有一定格式。</span></p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h2 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px 8px 0px 18px; font-size: 22px; float: left; line-height: 24px; font-weight: 400; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">类型</h2><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">产品使用说明书有两类:一类是包装式，即是印在包装物上说明书；另一类是内装式，有专用纸张说明书、图表式说明书、装订成册的产品说明书，它们均装在包装物内。</p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h2 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px 8px 0px 18px; font-size: 22px; float: left; line-height: 24px; font-weight: 400; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">特点</h2><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">不管那种类型产品使用说明书均具有以下特点：&nbsp;<br/>　　一是知识性，要向用户真实地介绍有关产品的主要性能、用途、使用方法等产品知识。&nbsp;<br/>　　二是责任性，为取得用户信任，在产品说明书上要介绍产品名称、商标、批准文号、生产单位及联系地址、电话等。&nbsp;<br/>　　三是通俗性，产品说明书面向各种文化程度用户，位置通俗易懂，条理清晰，看了产品使用说明书便能操作使用，做到一看就知道“该怎样用”、“不该怎样用”。&nbsp;<br/>　　四是多样性，产品使用说明书样式多样，有单页、活页、卡片、小册子；印刷上有油印、彩印、塑面烫金。许多产品使用说明书附有图片，做到图文并茂。</p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h2 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px 8px 0px 18px; font-size: 22px; float: left; line-height: 24px; font-weight: 400; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">功能与作用</h2><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">产品使用说明书的主要功能是向用户介绍产品的用途、性能、使用和维护方法，以增进用户对产品的认识，掌握操作程序、使用和维护方法。所以，产品使用说明书在生产者和用户之间起到桥梁作用。还由于产品说明书编写科学合理，客观上起到广告宣传作用，具有特殊的广告效用，从而为产品广开销路。此外，产品使用说明书所介绍的产品知识直观性很强，有提供科技情报、传播科技知识作用。</p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h2 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px 8px 0px 18px; font-size: 22px; float: left; line-height: 24px; font-weight: 400; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">文本结构</h2><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">产品类型不同，产品使用说明书格式也不同，下面介绍生产、科研用产品的使用说明书文本结构：</p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h3 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px; font-size: 18px; font-weight: 400;\">标题</h3><p style=\"white-space: normal;\">直接注明产品的货名、型号、商标。</p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h3 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px; font-size: 18px; font-weight: 400;\">引言</h3><p style=\"white-space: normal;\"><br/>　　在正文之前简要介绍产品适用范围，使用对象等内容。</p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h3 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px; font-size: 18px; font-weight: 400;\">正文</h3><p style=\"white-space: normal;\">正文部分有以下几部分内容组成：&nbsp;<br/>　　产品的操作原理；&nbsp;<br/>　　技术指标，指反映产品特点和性能的数据；&nbsp;<br/>　　结构特点，通常采用实物图或产品结构图配合文字说明；&nbsp;<br/>　　操作、使用说明，操作中的各个步骤要有条理性；&nbsp;<br/>　　维修保养，故障排除。</p><p style=\"white-space: normal;\"><a class=\"lemma-anchor para-title\" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a><a class=\"lemma-anchor \" style=\"color: rgb(19, 110, 194); position: absolute; top: -50px;\"></a></p><h3 class=\"title-text\" style=\"white-space: normal; margin: 0px; padding: 0px; font-size: 18px; font-weight: 400;\">落款</h3><p style=\"white-space: normal;\">包括生产企业名称、地址、邮政编码、联系电话、电子邮箱等，以示对所生产产品负责。</p><p><br/></p>', '1538014625', '1538297910', '1', '0');
INSERT INTO `dp_service_protocol` VALUES ('5', '2', '<p>商家服务协议111</p>', '1538035075', '0', '1', '0');
INSERT INTO `dp_service_protocol` VALUES ('6', '5', '<p>关于我们的team</p>', '1538136926', '0', '1', '0');
INSERT INTO `dp_service_protocol` VALUES ('7', '3', '<p>帮助协议</p>', '1539140818', '0', '1', '0');

-- ----------------------------
-- Table structure for dp_user
-- ----------------------------
DROP TABLE IF EXISTS `dp_user`;
CREATE TABLE `dp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '用户手机号码',
  `head_img` varchar(50) NOT NULL DEFAULT '' COMMENT '用户头像',
  `loginpwd` varchar(100) NOT NULL DEFAULT '' COMMENT '登录密码',
  `paypwd` varchar(100) NOT NULL DEFAULT '' COMMENT '支付密码',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别,0保密,1男,2女',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_paypwd` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否设置支付密码,0未设置,1已设置',
  `is_disable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用,0表示不禁用,1表示禁用',
  PRIMARY KEY (`id`),
  KEY `umobile` (`mobile`) USING BTREE COMMENT '手机号索引',
  KEY `upaypwd` (`is_paypwd`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_user
-- ----------------------------
INSERT INTO `dp_user` VALUES ('1', '我是', '15123363369', '44', '$2y$10$v0Q1ZXklEHu5t3zFvGgHlu6gI9VQLhLOULicjYPoac485QIMa5mH2', '$2y$10$1wgfE2bnygDTuN1N8YrOzufmrm.pYdKdVSDEChXXmB6aq0jGn32Qm', '1', '1537804800', '1535947120', '1535947120', '1', '0');
INSERT INTO `dp_user` VALUES ('2', '陈鑫2', '15123363361', '', '$2y$10$uMk3a59IsiccqHNLlrZVDelO1UuDRdhFDAdjsYyAesWdufwRFVUKa', '$2y$10$nsfU012sJ7EkQjmOi065C.rNLEDMej02ypIeLnCqlIHUd7FK4HEJO', '1', '1535940814', '1535947120', '1535947120', '1', '0');
INSERT INTO `dp_user` VALUES ('3', '18202333444', '18202333444', '', '$2y$10$w9VOHzqk7JYyDkgsxeSOOOmCOQqggoxaYrU0zmeykWVIqqNPPR4Lq', '', '0', '0', '1537871946', '1537871946', '0', '0');
INSERT INTO `dp_user` VALUES ('4', '18202333555', '18202333555', '', '$2y$10$uMk3a59IsiccqHNLlrZVDelO1UuDRdhFDAdjsYyAesWdufwRFVUKa', '', '0', '0', '1537873706', '1537873706', '0', '0');
INSERT INTO `dp_user` VALUES ('5', '幼儿园', '17708323304', '121', '$2y$10$aXob3H8LEtHOY32Sd4EzDuaAwy/SMf9ekcFtHXTvgjcAQBUFTTqR2', '$2y$10$.n6e4nQT0lT28i7R0EpOEu45Gvu6uATPu4Zg3se8bwBCXRPZ6/3WG', '1', '1538236800', '1537931677', '1537931677', '1', '0');
INSERT INTO `dp_user` VALUES ('6', '天上无力', '13996379929', '42', '$2y$10$lrWWxJUl2GbkSyhF.WF1demTXpWSXnCmeHVKvr/jOp8/adXsCEJlm', '$2y$10$g.zXk6Lrk4hZjvbrBBvoE.DeaEFZnZuPT.QubE4tAKlWWAHGFI2GS', '1', '1539187200', '1537949308', '1537949308', '1', '0');
INSERT INTO `dp_user` VALUES ('7', '18502303697', '18502303697', '', '$2y$10$cOVdpWNRPHOiWBkKhkIuhu/QiWdlolauNkLUxIcWT8ZuGLrLhaXy6', '', '0', '0', '1539057618', '1539057618', '0', '0');
INSERT INTO `dp_user` VALUES ('8', '刘亚东', '18738277443', '115', '$2y$10$/t1A4sNYI/jRgOiWp8YfQ.l2HcnyVgtxhjkCpxE2tjqUFx8/qjLke', '', '0', '0', '1539074097', '1539074097', '0', '0');

-- ----------------------------
-- Table structure for dp_user_buycard
-- ----------------------------
DROP TABLE IF EXISTS `dp_user_buycard`;
CREATE TABLE `dp_user_buycard` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户购买卡记录id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `platform_card_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '卡id',
  `user_card_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户卡id',
  `number` char(15) NOT NULL DEFAULT '' COMMENT '订单号',
  `jiaoyi_number` varchar(50) NOT NULL DEFAULT '' COMMENT '第三方交易单号',
  `card_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '卡类型,1权益卡,2次数卡',
  `buy_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `buy_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式,1支付宝,2微信',
  `buy_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '购买状态,0成功,1失败',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买时间',
  PRIMARY KEY (`id`),
  KEY `buycard` (`card_type`,`buy_price`,`buy_type`,`buy_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_user_buycard
-- ----------------------------
INSERT INTO `dp_user_buycard` VALUES ('1', '1', '2', '3', 'buycard12123zhi', '支付宝123213123', '1', '100.00', '1', '0', '1536290644');
INSERT INTO `dp_user_buycard` VALUES ('2', '1', '3', '2', 'buycard12115664', '微信12312321', '2', '200.00', '2', '0', '1536290644');
INSERT INTO `dp_user_buycard` VALUES ('3', '1', '1', '1', 'buycard1214zhi', '支付宝123123123123', '1', '100.00', '1', '0', '1536290644');
INSERT INTO `dp_user_buycard` VALUES ('7', '1', '1', '8', '2018092805716', '383947', '1', '100.00', '1', '0', '1538125033');
INSERT INTO `dp_user_buycard` VALUES ('8', '1', '3', '9', '2018092805811', '830045', '2', '200.00', '1', '0', '1538125244');
INSERT INTO `dp_user_buycard` VALUES ('9', '1', '4', '10', '2018092905937', '296753', '2', '150.00', '0', '0', '1538207444');
INSERT INTO `dp_user_buycard` VALUES ('10', '6', '3', '11', '2018092906037', '990642', '2', '200.00', '1', '0', '1538211598');
INSERT INTO `dp_user_buycard` VALUES ('11', '6', '10', '12', '2018092906143', '512221', '2', '500.00', '0', '0', '1538211625');
INSERT INTO `dp_user_buycard` VALUES ('12', '6', '11', '13', '2018092906282', '923898', '1', '500.00', '0', '0', '1538219209');
INSERT INTO `dp_user_buycard` VALUES ('13', '6', '3', '14', '2018092906367', '763471', '2', '200.00', '1', '0', '1538220134');
INSERT INTO `dp_user_buycard` VALUES ('14', '6', '7', '15', '2018093006691', '923950', '2', '200.00', '0', '0', '1538272275');
INSERT INTO `dp_user_buycard` VALUES ('15', '6', '10', '16', '2018093006793', '999505', '2', '500.00', '1', '0', '1538272281');
INSERT INTO `dp_user_buycard` VALUES ('16', '6', '11', '17', '2018093006865', '617639', '1', '500.00', '1', '0', '1538272290');
INSERT INTO `dp_user_buycard` VALUES ('17', '6', '2', '18', '2018093006958', '735349', '1', '100.00', '1', '0', '1538272295');
INSERT INTO `dp_user_buycard` VALUES ('18', '5', '4', '19', '2018093007613', '517460', '2', '150.00', '0', '0', '1538283682');
INSERT INTO `dp_user_buycard` VALUES ('19', '5', '11', '20', '2018093007728', '393177', '1', '500.00', '1', '0', '1538283687');
INSERT INTO `dp_user_buycard` VALUES ('20', '6', '1', '21', '2018093008366', '509474', '1', '100.00', '0', '0', '1538290576');
INSERT INTO `dp_user_buycard` VALUES ('21', '6', '7', '22', '2018093008939', '547753', '2', '200.00', '1', '0', '1538300379');
INSERT INTO `dp_user_buycard` VALUES ('22', '6', '2', '23', '2018093009016', '164419', '1', '100.00', '1', '0', '1538300385');
INSERT INTO `dp_user_buycard` VALUES ('23', '6', '1', '24', '2018100809182', '189772', '1', '100.00', '1', '0', '1538968244');
INSERT INTO `dp_user_buycard` VALUES ('24', '6', '3', '25', '2018100809267', '812088', '2', '200.00', '0', '0', '1538979982');
INSERT INTO `dp_user_buycard` VALUES ('25', '5', '2', '26', '2018101109653', '483965', '1', '100.00', '0', '0', '1539243817');
INSERT INTO `dp_user_buycard` VALUES ('26', '5', '2', '27', '2018101109787', '266703', '1', '100.00', '0', '0', '1539243942');
INSERT INTO `dp_user_buycard` VALUES ('27', '5', '2', '28', '2018101109857', '886273', '1', '100.00', '1', '0', '1539244312');
INSERT INTO `dp_user_buycard` VALUES ('28', '5', '4', '29', '2018101109984', '538074', '2', '150.00', '0', '0', '1539244327');
INSERT INTO `dp_user_buycard` VALUES ('29', '5', '10', '30', '2018101110057', '483814', '2', '500.00', '1', '0', '1539244357');
INSERT INTO `dp_user_buycard` VALUES ('30', '6', '2', '31', '2018101110110', '686530', '1', '100.00', '0', '0', '1539251353');
INSERT INTO `dp_user_buycard` VALUES ('31', '6', '11', '32', '2018101110266', '185638', '1', '500.00', '0', '0', '1539251477');
INSERT INTO `dp_user_buycard` VALUES ('32', '6', '4', '33', '2018101110383', '864512', '2', '150.00', '0', '0', '1539251689');
INSERT INTO `dp_user_buycard` VALUES ('33', '5', '2', '34', '2018101210478', '315941', '1', '100.00', '1', '0', '1539310907');
INSERT INTO `dp_user_buycard` VALUES ('34', '5', '2', '35', '2018101610530', '427193', '1', '100.00', '1', '0', '1539654937');
INSERT INTO `dp_user_buycard` VALUES ('35', '5', '2', '36', '2018101610617', '362374', '1', '100.00', '1', '0', '1539660008');
INSERT INTO `dp_user_buycard` VALUES ('36', '5', '1', '37', '2018101610784', '437522', '1', '100.00', '0', '0', '1539670448');
INSERT INTO `dp_user_buycard` VALUES ('37', '7', '11', '38', '2018101610885', '113866', '1', '500.00', '1', '0', '1539673557');
INSERT INTO `dp_user_buycard` VALUES ('38', '7', '11', '39', '2018101610924', '877801', '1', '500.00', '0', '0', '1539673934');
INSERT INTO `dp_user_buycard` VALUES ('39', '1', '11', '40', '2018101611047', '625357', '1', '500.00', '1', '0', '1539674177');
INSERT INTO `dp_user_buycard` VALUES ('40', '7', '11', '41', '2018101611166', '355149', '1', '500.00', '1', '0', '1539674247');
INSERT INTO `dp_user_buycard` VALUES ('41', '1', '11', '42', '2018101611231', '560673', '1', '500.00', '0', '0', '1539674314');
INSERT INTO `dp_user_buycard` VALUES ('42', '1', '11', '43', '2018101611332', '648289', '1', '500.00', '1', '0', '1539674411');
INSERT INTO `dp_user_buycard` VALUES ('43', '1', '11', '44', '2018101611489', '467693', '1', '500.00', '0', '0', '1539674727');
INSERT INTO `dp_user_buycard` VALUES ('44', '1', '11', '45', '2018101611539', '686220', '1', '500.00', '1', '0', '1539674833');
INSERT INTO `dp_user_buycard` VALUES ('45', '1', '11', '46', '2018101611657', '466725', '1', '500.00', '1', '0', '1539674895');
INSERT INTO `dp_user_buycard` VALUES ('46', '1', '1', '47', '2018101611764', '480299', '1', '100.00', '0', '0', '1539676723');

-- ----------------------------
-- Table structure for dp_user_card
-- ----------------------------
DROP TABLE IF EXISTS `dp_user_card`;
CREATE TABLE `dp_user_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` char(15) NOT NULL DEFAULT '' COMMENT '卡号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `platform_card_id` int(11) NOT NULL DEFAULT '0' COMMENT '平台卡id',
  `balance_value` decimal(10,0) unsigned NOT NULL DEFAULT '0' COMMENT '用户卡权益值余额/剩余次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生效时间',
  `expire_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '消费状态,0正常,1消费完毕,2已过期',
  `month_balance_times` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '当月剩余使用次数(次卡才有)',
  PRIMARY KEY (`id`),
  KEY `usercard` (`balance_value`,`create_time`,`expire_time`,`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_user_card
-- ----------------------------
INSERT INTO `dp_user_card` VALUES ('1', 'QE2018090700454', '1', '1', '0', '1536290644', '1537858722', '2', '0');
INSERT INTO `dp_user_card` VALUES ('2', 'CS2018090700522', '1', '3', '22', '1536290644', '1569061187', '0', '22');
INSERT INTO `dp_user_card` VALUES ('3', 'QE2018090700467', '1', '2', '0', '1536290644', '1569061187', '1', '0');
INSERT INTO `dp_user_card` VALUES ('8', 'QE2018092801055', '1', '1', '48700', '1536490644', '1540742400', '0', '0');
INSERT INTO `dp_user_card` VALUES ('9', 'CS2018092801057', '1', '3', '30', '1538125244', '1545926400', '0', '30');
INSERT INTO `dp_user_card` VALUES ('10', 'CS2018092901154', '1', '4', '12', '1538207444', '1540828800', '0', '10');
INSERT INTO `dp_user_card` VALUES ('11', 'CS2018092901229', '0', '3', '30', '1538211598', '1546012800', '0', '30');
INSERT INTO `dp_user_card` VALUES ('12', 'CS2018092901327', '0', '10', '100', '1538211625', '1553788800', '0', '30');
INSERT INTO `dp_user_card` VALUES ('13', 'QE2018092901140', '0', '11', '500', '1538219209', '1546012800', '0', '0');
INSERT INTO `dp_user_card` VALUES ('14', 'CS2018092901462', '6', '3', '27', '1538220134', '1546012800', '0', '27');
INSERT INTO `dp_user_card` VALUES ('15', 'CS2018093001554', '6', '7', '6', '1538272275', '1540915200', '0', '6');
INSERT INTO `dp_user_card` VALUES ('16', 'CS2018093001617', '6', '10', '98', '1538272281', '1553875200', '0', '28');
INSERT INTO `dp_user_card` VALUES ('17', 'QE2018093001234', '6', '11', '0', '1538272290', '1546099200', '1', '0');
INSERT INTO `dp_user_card` VALUES ('18', 'QE2018093001373', '6', '2', '0', '1538272295', '1543507200', '1', '0');
INSERT INTO `dp_user_card` VALUES ('19', 'CS2018093001783', '5', '4', '12', '1538283682', '1540915200', '0', '10');
INSERT INTO `dp_user_card` VALUES ('20', 'QE2018093001456', '5', '11', '0', '1538283687', '1546099200', '1', '0');
INSERT INTO `dp_user_card` VALUES ('21', 'QE2018093001511', '6', '1', '48407', '1538290576', '1540915200', '0', '0');
INSERT INTO `dp_user_card` VALUES ('22', 'CS2018093001895', '6', '7', '10', '1538300379', '1540915200', '0', '10');
INSERT INTO `dp_user_card` VALUES ('23', 'QE2018093001674', '6', '2', '100', '1538300385', '1543507200', '0', '0');
INSERT INTO `dp_user_card` VALUES ('24', 'QE2018100801765', '6', '1', '50000', '1538968244', '1541606400', '0', '0');
INSERT INTO `dp_user_card` VALUES ('25', 'CS2018100801980', '6', '3', '30', '1538979982', '1546790400', '0', '30');
INSERT INTO `dp_user_card` VALUES ('26', 'QE2018101101836', '5', '2', '100', '1539243817', '1544457600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('27', 'QE2018101101985', '5', '2', '100', '1539243942', '1544457600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('28', 'QE2018101102015', '5', '2', '100', '1539244312', '1544457600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('29', 'CS2018101102054', '5', '4', '12', '1539244327', '1541865600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('30', 'CS2018101102180', '5', '10', '100', '1539244357', '1554825600', '0', '30');
INSERT INTO `dp_user_card` VALUES ('31', 'QE2018101102148', '6', '2', '100', '1539251353', '1544457600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('32', 'QE2018101102288', '6', '11', '500', '1539251477', '1547049600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('33', 'CS2018101102223', '6', '4', '12', '1539251689', '1541865600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('34', 'QE2018101202319', '5', '2', '100', '1539310907', '1544544000', '0', '10');
INSERT INTO `dp_user_card` VALUES ('35', 'QE2018101602470', '5', '2', '100', '1539654937', '1544889600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('36', 'QE2018101602563', '5', '2', '100', '1539660008', '1544889600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('37', 'QE2018101602668', '5', '1', '50000', '1539670448', '1542297600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('38', 'QE2018101602762', '7', '11', '500', '1539673557', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('39', 'QE2018101602820', '7', '11', '500', '1539673934', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('40', 'QE2018101602962', '1', '11', '500', '1539674177', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('41', 'QE2018101603092', '7', '11', '500', '1539674247', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('42', 'QE2018101603192', '1', '11', '500', '1539674314', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('43', 'QE2018101603294', '1', '11', '500', '1539674411', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('44', 'QE2018101603384', '1', '11', '500', '1539674727', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('45', 'QE2018101603494', '1', '11', '500', '1539674833', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('46', 'QE2018101603544', '1', '11', '500', '1539674895', '1547481600', '0', '10');
INSERT INTO `dp_user_card` VALUES ('47', 'QE2018101603647', '1', '1', '50000', '1539676723', '1542297600', '0', '10');

-- ----------------------------
-- Table structure for dp_user_card_statement
-- ----------------------------
DROP TABLE IF EXISTS `dp_user_card_statement`;
CREATE TABLE `dp_user_card_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户卡消费记录id',
  `card_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户卡类型',
  `user_card_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户卡表id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '消费时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_user_card_statement
-- ----------------------------
INSERT INTO `dp_user_card_statement` VALUES ('14', '1', '1', '1', '1537527703');
INSERT INTO `dp_user_card_statement` VALUES ('30', '1', '0', '1', '1537529423');
INSERT INTO `dp_user_card_statement` VALUES ('31', '1', '0', '1', '1537532363');
INSERT INTO `dp_user_card_statement` VALUES ('32', '1', '0', '1', '1537532421');
INSERT INTO `dp_user_card_statement` VALUES ('33', '1', '0', '1', '1537532437');
INSERT INTO `dp_user_card_statement` VALUES ('34', '1', '0', '1', '1537532442');
INSERT INTO `dp_user_card_statement` VALUES ('35', '1', '0', '1', '1537532969');
INSERT INTO `dp_user_card_statement` VALUES ('36', '1', '0', '1', '1537533127');
INSERT INTO `dp_user_card_statement` VALUES ('37', '1', '0', '1', '1537533453');
INSERT INTO `dp_user_card_statement` VALUES ('40', '2', '2', '1', '1537537344');
INSERT INTO `dp_user_card_statement` VALUES ('41', '2', '2', '1', '1537537605');
INSERT INTO `dp_user_card_statement` VALUES ('42', '2', '2', '1', '1537537618');
INSERT INTO `dp_user_card_statement` VALUES ('43', '2', '2', '1', '1537537622');
INSERT INTO `dp_user_card_statement` VALUES ('44', '2', '2', '1', '1537537666');
INSERT INTO `dp_user_card_statement` VALUES ('45', '2', '2', '1', '1537537678');
INSERT INTO `dp_user_card_statement` VALUES ('46', '2', '2', '1', '1537537873');
INSERT INTO `dp_user_card_statement` VALUES ('47', '2', '4', '1', '1537538268');
INSERT INTO `dp_user_card_statement` VALUES ('48', '2', '4', '1', '1537538274');
INSERT INTO `dp_user_card_statement` VALUES ('49', '2', '4', '1', '1537538290');
INSERT INTO `dp_user_card_statement` VALUES ('50', '2', '4', '1', '1537538293');
INSERT INTO `dp_user_card_statement` VALUES ('51', '2', '4', '1', '1537538297');
INSERT INTO `dp_user_card_statement` VALUES ('52', '2', '4', '1', '1537538300');
INSERT INTO `dp_user_card_statement` VALUES ('53', '2', '4', '1', '1537538303');
INSERT INTO `dp_user_card_statement` VALUES ('54', '2', '4', '1', '1537538307');
INSERT INTO `dp_user_card_statement` VALUES ('55', '2', '4', '1', '1537538310');
INSERT INTO `dp_user_card_statement` VALUES ('56', '2', '4', '1', '1537538311');
INSERT INTO `dp_user_card_statement` VALUES ('57', '2', '4', '1', '1537538313');
INSERT INTO `dp_user_card_statement` VALUES ('58', '2', '4', '1', '1537538541');
INSERT INTO `dp_user_card_statement` VALUES ('59', '2', '5', '1', '1537538936');
INSERT INTO `dp_user_card_statement` VALUES ('60', '2', '5', '1', '1537538939');
INSERT INTO `dp_user_card_statement` VALUES ('61', '2', '5', '1', '1537538940');
INSERT INTO `dp_user_card_statement` VALUES ('62', '2', '5', '1', '1537538942');
INSERT INTO `dp_user_card_statement` VALUES ('63', '2', '5', '1', '1537538943');
INSERT INTO `dp_user_card_statement` VALUES ('64', '2', '5', '1', '1537538944');
INSERT INTO `dp_user_card_statement` VALUES ('65', '2', '5', '1', '1537538945');
INSERT INTO `dp_user_card_statement` VALUES ('66', '2', '5', '1', '1537538946');
INSERT INTO `dp_user_card_statement` VALUES ('67', '2', '5', '1', '1537538947');
INSERT INTO `dp_user_card_statement` VALUES ('68', '2', '5', '1', '1537538949');
INSERT INTO `dp_user_card_statement` VALUES ('69', '2', '5', '1', '1537538951');
INSERT INTO `dp_user_card_statement` VALUES ('70', '2', '6', '1', '1537539349');
INSERT INTO `dp_user_card_statement` VALUES ('71', '2', '6', '1', '1537539351');
INSERT INTO `dp_user_card_statement` VALUES ('72', '2', '6', '1', '1537539352');
INSERT INTO `dp_user_card_statement` VALUES ('73', '2', '6', '1', '1537539353');
INSERT INTO `dp_user_card_statement` VALUES ('74', '2', '6', '1', '1537539357');
INSERT INTO `dp_user_card_statement` VALUES ('75', '2', '2', '1', '1537841375');
INSERT INTO `dp_user_card_statement` VALUES ('76', '2', '1', '1', '1538229156');
INSERT INTO `dp_user_card_statement` VALUES ('77', '2', '14', '6', '1538229527');
INSERT INTO `dp_user_card_statement` VALUES ('78', '2', '16', '6', '1538272441');
INSERT INTO `dp_user_card_statement` VALUES ('80', '1', '3', '1', '1538275771');
INSERT INTO `dp_user_card_statement` VALUES ('81', '1', '8', '1', '1538275771');
INSERT INTO `dp_user_card_statement` VALUES ('82', '1', '17', '6', '1538276653');
INSERT INTO `dp_user_card_statement` VALUES ('83', '2', '14', '6', '1538276772');
INSERT INTO `dp_user_card_statement` VALUES ('84', '1', '8', '1', '1538277345');
INSERT INTO `dp_user_card_statement` VALUES ('85', '2', '16', '6', '1538288288');
INSERT INTO `dp_user_card_statement` VALUES ('86', '2', '15', '6', '1538288349');
INSERT INTO `dp_user_card_statement` VALUES ('87', '2', '15', '6', '1538288362');
INSERT INTO `dp_user_card_statement` VALUES ('88', '2', '15', '6', '1538288525');
INSERT INTO `dp_user_card_statement` VALUES ('89', '2', '15', '6', '1538289843');
INSERT INTO `dp_user_card_statement` VALUES ('90', '1', '18', '6', '1538290674');
INSERT INTO `dp_user_card_statement` VALUES ('91', '1', '21', '6', '1538290674');
INSERT INTO `dp_user_card_statement` VALUES ('92', '1', '21', '6', '1538290832');
INSERT INTO `dp_user_card_statement` VALUES ('93', '1', '20', '5', '1538291999');
INSERT INTO `dp_user_card_statement` VALUES ('94', '1', '21', '6', '1538292075');
INSERT INTO `dp_user_card_statement` VALUES ('95', '1', '21', '6', '1538292147');
INSERT INTO `dp_user_card_statement` VALUES ('96', '1', '21', '6', '1539141699');
INSERT INTO `dp_user_card_statement` VALUES ('97', '2', '14', '6', '1539141743');
INSERT INTO `dp_user_card_statement` VALUES ('98', '1', '21', '6', '1539143278');

-- ----------------------------
-- Table structure for dp_user_consumerdetails
-- ----------------------------
DROP TABLE IF EXISTS `dp_user_consumerdetails`;
CREATE TABLE `dp_user_consumerdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户消费明细id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `points` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '消费积分,如果是次数转换为积分进行记录',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '消费时间',
  PRIMARY KEY (`id`),
  KEY `consumerdetail` (`points`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_user_consumerdetails
-- ----------------------------
INSERT INTO `dp_user_consumerdetails` VALUES ('8', '1', '14', '500.00', '1537529423');
INSERT INTO `dp_user_consumerdetails` VALUES ('9', '1', '15', '500.00', '1537532363');
INSERT INTO `dp_user_consumerdetails` VALUES ('10', '1', '16', '500.00', '1537532421');
INSERT INTO `dp_user_consumerdetails` VALUES ('11', '1', '17', '500.00', '1537532437');
INSERT INTO `dp_user_consumerdetails` VALUES ('12', '1', '18', '500.00', '1537532442');
INSERT INTO `dp_user_consumerdetails` VALUES ('13', '1', '19', '500.00', '1537532969');
INSERT INTO `dp_user_consumerdetails` VALUES ('14', '1', '20', '500.00', '1537533127');
INSERT INTO `dp_user_consumerdetails` VALUES ('15', '1', '21', '500.00', '1537533453');
INSERT INTO `dp_user_consumerdetails` VALUES ('17', '1', '23', '500.00', '1537537005');
INSERT INTO `dp_user_consumerdetails` VALUES ('18', '1', '24', '500.00', '1537537344');
INSERT INTO `dp_user_consumerdetails` VALUES ('19', '1', '25', '500.00', '1537537605');
INSERT INTO `dp_user_consumerdetails` VALUES ('20', '1', '26', '500.00', '1537537618');
INSERT INTO `dp_user_consumerdetails` VALUES ('21', '1', '27', '500.00', '1537537622');
INSERT INTO `dp_user_consumerdetails` VALUES ('22', '1', '28', '500.00', '1537537666');
INSERT INTO `dp_user_consumerdetails` VALUES ('23', '1', '29', '500.00', '1537537678');
INSERT INTO `dp_user_consumerdetails` VALUES ('24', '1', '30', '500.00', '1537537873');
INSERT INTO `dp_user_consumerdetails` VALUES ('25', '1', '31', '500.00', '1537538268');
INSERT INTO `dp_user_consumerdetails` VALUES ('26', '1', '32', '500.00', '1537538275');
INSERT INTO `dp_user_consumerdetails` VALUES ('27', '1', '33', '500.00', '1537538290');
INSERT INTO `dp_user_consumerdetails` VALUES ('28', '1', '34', '500.00', '1537538293');
INSERT INTO `dp_user_consumerdetails` VALUES ('29', '1', '35', '500.00', '1537538297');
INSERT INTO `dp_user_consumerdetails` VALUES ('30', '1', '36', '500.00', '1537538301');
INSERT INTO `dp_user_consumerdetails` VALUES ('31', '1', '37', '500.00', '1537538303');
INSERT INTO `dp_user_consumerdetails` VALUES ('32', '1', '38', '500.00', '1537538307');
INSERT INTO `dp_user_consumerdetails` VALUES ('33', '1', '39', '500.00', '1537538310');
INSERT INTO `dp_user_consumerdetails` VALUES ('34', '1', '40', '500.00', '1537538311');
INSERT INTO `dp_user_consumerdetails` VALUES ('35', '1', '41', '500.00', '1537538313');
INSERT INTO `dp_user_consumerdetails` VALUES ('36', '1', '42', '500.00', '1537538541');
INSERT INTO `dp_user_consumerdetails` VALUES ('37', '1', '43', '500.00', '1537538937');
INSERT INTO `dp_user_consumerdetails` VALUES ('38', '1', '44', '500.00', '1537538939');
INSERT INTO `dp_user_consumerdetails` VALUES ('39', '1', '45', '500.00', '1537538941');
INSERT INTO `dp_user_consumerdetails` VALUES ('40', '1', '46', '500.00', '1537538942');
INSERT INTO `dp_user_consumerdetails` VALUES ('41', '1', '47', '500.00', '1537538943');
INSERT INTO `dp_user_consumerdetails` VALUES ('42', '1', '48', '500.00', '1537538944');
INSERT INTO `dp_user_consumerdetails` VALUES ('43', '1', '49', '500.00', '1537538945');
INSERT INTO `dp_user_consumerdetails` VALUES ('44', '1', '50', '500.00', '1537538946');
INSERT INTO `dp_user_consumerdetails` VALUES ('45', '1', '51', '500.00', '1537538947');
INSERT INTO `dp_user_consumerdetails` VALUES ('46', '1', '52', '500.00', '1537538949');
INSERT INTO `dp_user_consumerdetails` VALUES ('47', '1', '53', '500.00', '1537538951');
INSERT INTO `dp_user_consumerdetails` VALUES ('48', '1', '54', '500.00', '1537539349');
INSERT INTO `dp_user_consumerdetails` VALUES ('49', '1', '55', '500.00', '1537539351');
INSERT INTO `dp_user_consumerdetails` VALUES ('50', '1', '56', '500.00', '1537539352');
INSERT INTO `dp_user_consumerdetails` VALUES ('51', '1', '57', '500.00', '1537539353');
INSERT INTO `dp_user_consumerdetails` VALUES ('52', '1', '58', '500.00', '1537539357');
INSERT INTO `dp_user_consumerdetails` VALUES ('53', '1', '59', '500.00', '1537841375');
INSERT INTO `dp_user_consumerdetails` VALUES ('54', '1', '60', '500.00', '1538229156');
INSERT INTO `dp_user_consumerdetails` VALUES ('55', '6', '61', '500.00', '1538229527');
INSERT INTO `dp_user_consumerdetails` VALUES ('56', '6', '62', '500.00', '1538272441');
INSERT INTO `dp_user_consumerdetails` VALUES ('57', '1', '63', '500.00', '1538274754');
INSERT INTO `dp_user_consumerdetails` VALUES ('58', '1', '64', '500.00', '1538275771');
INSERT INTO `dp_user_consumerdetails` VALUES ('59', '6', '65', '500.00', '1538276653');
INSERT INTO `dp_user_consumerdetails` VALUES ('60', '6', '66', '500.00', '1538276772');
INSERT INTO `dp_user_consumerdetails` VALUES ('61', '1', '67', '500.00', '1538277345');
INSERT INTO `dp_user_consumerdetails` VALUES ('62', '6', '68', '500.00', '1538288288');
INSERT INTO `dp_user_consumerdetails` VALUES ('63', '6', '69', '500.00', '1538288349');
INSERT INTO `dp_user_consumerdetails` VALUES ('64', '6', '70', '500.00', '1538288362');
INSERT INTO `dp_user_consumerdetails` VALUES ('65', '6', '71', '500.00', '1538288525');
INSERT INTO `dp_user_consumerdetails` VALUES ('66', '6', '72', '500.00', '1538289843');
INSERT INTO `dp_user_consumerdetails` VALUES ('67', '6', '73', '201.01', '1538290674');
INSERT INTO `dp_user_consumerdetails` VALUES ('68', '6', '74', '90.00', '1538290832');
INSERT INTO `dp_user_consumerdetails` VALUES ('69', '5', '75', '500.00', '1538291999');
INSERT INTO `dp_user_consumerdetails` VALUES ('70', '6', '76', '201.01', '1538292075');
INSERT INTO `dp_user_consumerdetails` VALUES ('71', '6', '77', '201.01', '1538292147');
INSERT INTO `dp_user_consumerdetails` VALUES ('72', '6', '78', '500.00', '1539141699');
INSERT INTO `dp_user_consumerdetails` VALUES ('73', '6', '79', '500.00', '1539141743');
INSERT INTO `dp_user_consumerdetails` VALUES ('74', '6', '80', '500.00', '1539143278');

-- ----------------------------
-- Table structure for dp_user_message
-- ----------------------------
DROP TABLE IF EXISTS `dp_user_message`;
CREATE TABLE `dp_user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '消息图标',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '消息标题',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '消息内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '消息发送时间',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读,0表示未读,1表示已读',
  `message_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '消息类型,1商家回复评论,2权益卡/次数卡,3扣款通知',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_card_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户卡id',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_user_message
-- ----------------------------
INSERT INTO `dp_user_message` VALUES ('17', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试1 在2018-09-21 21:47:46完成支付,请知晓', '1537537666', '1', '3', '1', '0', '28');
INSERT INTO `dp_user_message` VALUES ('18', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试1 在2018-09-21 21:47:58完成支付,请知晓', '1537537678', '1', '3', '1', '0', '29');
INSERT INTO `dp_user_message` VALUES ('19', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试1 在2018-09-21 21:51:13完成支付,请知晓', '1537537873', '1', '3', '1', '0', '30');
INSERT INTO `dp_user_message` VALUES ('20', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:57:48完成支付,请知晓', '1537538268', '1', '3', '1', '0', '31');
INSERT INTO `dp_user_message` VALUES ('21', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:57:55完成支付,请知晓', '1537538275', '1', '3', '1', '0', '32');
INSERT INTO `dp_user_message` VALUES ('22', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:10完成支付,请知晓', '1537538290', '1', '3', '1', '0', '33');
INSERT INTO `dp_user_message` VALUES ('23', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:13完成支付,请知晓', '1537538293', '1', '3', '1', '0', '34');
INSERT INTO `dp_user_message` VALUES ('24', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:17完成支付,请知晓', '1537538297', '1', '3', '1', '0', '35');
INSERT INTO `dp_user_message` VALUES ('25', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:21完成支付,请知晓', '1537538301', '1', '3', '1', '0', '36');
INSERT INTO `dp_user_message` VALUES ('26', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:23完成支付,请知晓', '1537538303', '1', '3', '1', '0', '37');
INSERT INTO `dp_user_message` VALUES ('27', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:27完成支付,请知晓', '1537538307', '1', '3', '1', '0', '38');
INSERT INTO `dp_user_message` VALUES ('28', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:30完成支付,请知晓', '1537538310', '1', '3', '1', '0', '39');
INSERT INTO `dp_user_message` VALUES ('29', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:31完成支付,请知晓', '1537538311', '1', '3', '1', '0', '40');
INSERT INTO `dp_user_message` VALUES ('30', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 21:58:33完成支付,请知晓', '1537538313', '1', '3', '1', '0', '41');
INSERT INTO `dp_user_message` VALUES ('32', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试2 在2018-09-21 22:02:21完成支付,请知晓', '1537538541', '1', '3', '1', '0', '42');
INSERT INTO `dp_user_message` VALUES ('33', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:08:57完成支付,请知晓', '1537538937', '1', '3', '1', '0', '43');
INSERT INTO `dp_user_message` VALUES ('34', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:08:59完成支付,请知晓', '1537538939', '1', '3', '1', '0', '44');
INSERT INTO `dp_user_message` VALUES ('35', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:01完成支付,请知晓', '1537538941', '1', '3', '1', '0', '45');
INSERT INTO `dp_user_message` VALUES ('36', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:02完成支付,请知晓', '1537538942', '1', '3', '1', '0', '46');
INSERT INTO `dp_user_message` VALUES ('37', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:03完成支付,请知晓', '1537538943', '1', '3', '1', '0', '47');
INSERT INTO `dp_user_message` VALUES ('38', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:04完成支付,请知晓', '1537538944', '1', '3', '1', '0', '48');
INSERT INTO `dp_user_message` VALUES ('39', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:05完成支付,请知晓', '1537538945', '1', '3', '1', '0', '49');
INSERT INTO `dp_user_message` VALUES ('40', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:06完成支付,请知晓', '1537538946', '1', '3', '1', '0', '50');
INSERT INTO `dp_user_message` VALUES ('41', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:08完成支付,请知晓', '1537538948', '1', '3', '1', '0', '51');
INSERT INTO `dp_user_message` VALUES ('42', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:09完成支付,请知晓', '1537538949', '1', '3', '1', '0', '52');
INSERT INTO `dp_user_message` VALUES ('43', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:09:11完成支付,请知晓', '1537538951', '1', '3', '1', '0', '53');
INSERT INTO `dp_user_message` VALUES ('44', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:15:49完成支付,请知晓', '1537539349', '1', '3', '1', '0', '54');
INSERT INTO `dp_user_message` VALUES ('45', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:15:51完成支付,请知晓', '1537539351', '1', '3', '1', '0', '55');
INSERT INTO `dp_user_message` VALUES ('46', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:15:52完成支付,请知晓', '1537539352', '1', '3', '1', '0', '56');
INSERT INTO `dp_user_message` VALUES ('47', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:15:53完成支付,请知晓', '1537539353', '1', '3', '1', '0', '57');
INSERT INTO `dp_user_message` VALUES ('48', '', '扣款通知', '尊敬的 陈鑫1您的 次数 在2018-09-21 22:15:57完成支付,请知晓', '1537539357', '1', '3', '1', '0', '58');
INSERT INTO `dp_user_message` VALUES ('49', '', '扣款通知', '尊敬的 陈鑫1您的 次数卡测试1 在2018-09-25 10:09:35完成支付,请知晓', '1537841375', '1', '3', '1', '0', '59');
INSERT INTO `dp_user_message` VALUES ('56', '', '权益卡已过期', '您的权益卡: QE2018090700454已于2018-09-25 14:58:42过期,请知晓', '1538102668', '1', '41', '1', '1', '0');
INSERT INTO `dp_user_message` VALUES ('57', '', '[江北红火洗车行]回复了您的评价', '一这破这是我朋友', '1538207167', '1', '1', '1', '0', '3');
INSERT INTO `dp_user_message` VALUES ('58', '', '[江北红火洗车行]回复了您的评价', '咯偶图据了解', '1538207408', '0', '1', '2', '0', '2');
INSERT INTO `dp_user_message` VALUES ('59', '', '扣款通知', '尊敬的 我是您的  在2018-09-29 21:52:36完成支付,请知晓', '1538229156', '1', '3', '1', '0', '60');
INSERT INTO `dp_user_message` VALUES ('60', '', '扣款通知', '尊敬的 哈哈您的 次数卡测试1 在2018-09-29 21:58:47完成支付,请知晓', '1538229527', '1', '3', '6', '0', '61');
INSERT INTO `dp_user_message` VALUES ('61', '', '扣款通知', '尊敬的 哈哈您的 次卡0927 在2018-09-30 09:54:01完成支付,请知晓', '1538272441', '1', '3', '6', '0', '62');
INSERT INTO `dp_user_message` VALUES ('62', '', '扣款通知', '尊敬的 我是您的 权益卡测试1 在2018-09-30 10:32:34完成支付,请知晓', '1538274754', '1', '3', '1', '0', '63');
INSERT INTO `dp_user_message` VALUES ('63', '', '扣款通知', '尊敬的 我是您的 权益卡测试1 在2018-09-30 10:49:31完成支付,请知晓', '1538275771', '1', '3', '1', '0', '64');
INSERT INTO `dp_user_message` VALUES ('64', '', '扣款通知', '尊敬的 哈哈您的 权益0928 在2018-09-30 11:04:13完成支付,请知晓', '1538276653', '1', '3', '6', '0', '65');
INSERT INTO `dp_user_message` VALUES ('65', '', '扣款通知', '尊敬的 哈哈您的 次数卡测试1 在2018-09-30 11:06:12完成支付,请知晓', '1538276772', '1', '3', '6', '0', '66');
INSERT INTO `dp_user_message` VALUES ('66', '', '扣款通知', '尊敬的 我是您的 权益卡测试1 在2018-09-30 11:15:45完成支付,请知晓', '1538277345', '1', '3', '1', '0', '67');
INSERT INTO `dp_user_message` VALUES ('67', '', '扣款通知', '尊敬的 哈哈您的 次卡0927 在2018-09-30 14:18:08完成支付,请知晓', '1538288289', '1', '3', '6', '0', '68');
INSERT INTO `dp_user_message` VALUES ('68', '', '扣款通知', '尊敬的 哈哈您的 次数 在2018-09-30 14:19:09完成支付,请知晓', '1538288349', '1', '3', '6', '0', '69');
INSERT INTO `dp_user_message` VALUES ('69', '', '扣款通知', '尊敬的 哈哈您的 次数 在2018-09-30 14:19:22完成支付,请知晓', '1538288362', '1', '3', '6', '0', '70');
INSERT INTO `dp_user_message` VALUES ('70', '', '扣款通知', '尊敬的 哈哈您的 次数 在2018-09-30 14:22:05完成支付,请知晓', '1538288525', '1', '3', '6', '0', '71');
INSERT INTO `dp_user_message` VALUES ('71', '', '[江北红火洗车行]回复了您的评价', '哈哈哈哈', '1538289514', '1', '1', '1', '0', '1');
INSERT INTO `dp_user_message` VALUES ('72', '', '扣款通知', '尊敬的 哈哈您的 次数 在2018-09-30 14:44:03完成支付,请知晓', '1538289843', '1', '3', '6', '0', '72');
INSERT INTO `dp_user_message` VALUES ('73', '', '扣款通知', '尊敬的 哈哈您的 权益卡测试1 在2018-09-30 14:57:54完成支付,请知晓', '1538290674', '1', '3', '6', '0', '73');
INSERT INTO `dp_user_message` VALUES ('74', '', '扣款通知', '尊敬的 哈哈您的 权益卡测试1 在2018-09-30 15:00:32完成支付,请知晓', '1538290832', '1', '3', '6', '0', '74');
INSERT INTO `dp_user_message` VALUES ('75', '', '[江北红火洗车行]回复了您的评价', '哈哈哈哈1', '1538291089', '1', '1', '1', '0', '1');
INSERT INTO `dp_user_message` VALUES ('76', '', '[江北红火洗车行]回复了您的评价', '哦豁', '1538291115', '1', '1', '1', '0', '1');
INSERT INTO `dp_user_message` VALUES ('77', '', '[江北红火洗车行]回复了您的评价', '哦豁11213', '1538291873', '1', '1', '1', '0', '1');
INSERT INTO `dp_user_message` VALUES ('78', '', '扣款通知', '尊敬的 幼儿园您的 权益0928 在2018-09-30 15:19:59完成支付,请知晓', '1538291999', '1', '3', '5', '0', '75');
INSERT INTO `dp_user_message` VALUES ('79', '', '扣款通知', '尊敬的 哈哈您的 权益卡测试1 在2018-09-30 15:21:15完成支付,请知晓', '1538292075', '1', '3', '6', '0', '76');
INSERT INTO `dp_user_message` VALUES ('80', '', '扣款通知', '尊敬的 哈哈您的 权益卡测试1 在2018-09-30 15:22:27完成支付,请知晓', '1538292147', '1', '3', '6', '0', '77');
INSERT INTO `dp_user_message` VALUES ('81', '', '扣款通知', '尊敬的 哈哈您的 权益卡测试1 在2018-10-10 11:21:39完成支付,请知晓', '1539141699', '1', '3', '6', '0', '78');
INSERT INTO `dp_user_message` VALUES ('82', '', '扣款通知', '尊敬的 哈哈您的 次数卡测试1 在2018-10-10 11:22:23完成支付,请知晓', '1539141743', '1', '3', '6', '0', '79');
INSERT INTO `dp_user_message` VALUES ('83', '', '扣款通知', '尊敬的 哈哈您的 权益卡测试1 在2018-10-10 11:47:58完成支付,请知晓', '1539143278', '1', '3', '6', '0', '80');
INSERT INTO `dp_user_message` VALUES ('84', '', '[反对广告]回复了您的评价', '明明', '1539143398', '1', '1', '6', '0', '80');

-- ----------------------------
-- Table structure for dp_user_order
-- ----------------------------
DROP TABLE IF EXISTS `dp_user_order`;
CREATE TABLE `dp_user_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `seller_service_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家服务id',
  `seller_staff_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商家员工id',
  `goodsname` varchar(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goodsprice` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '商品价格',
  `payprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `order_number` char(16) NOT NULL DEFAULT '' COMMENT '订单号',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `settlement_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '结算方式,1次数卡,2权益卡',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态,0支付失败,1支付成功,2未支付',
  `is_valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单是否有效,0有效,1无效',
  `is_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已评价,0未评价,1已评价',
  PRIMARY KEY (`id`),
  KEY `uoname` (`goodsname`(191)) USING BTREE,
  KEY `uoprice` (`goodsprice`) USING BTREE,
  KEY `yopayprice` (`payprice`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of dp_user_order
-- ----------------------------
INSERT INTO `dp_user_order` VALUES ('1', '1', '1', '1', '1', '李大大洗车1', '151', '151.00', 'cis124567897888', '1535947120', '2', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('2', '2', '1', '1', '1', '李大大洗车2', '152', '152.00', 'cis124567897888', '1535947120', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('3', '1', '1', '2', '3', '李大大洗车3', '153', '153.00', 'cis124567897888', '1536290644', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('4', '1', '20', '1', '1', '洗车', '100', '100.00', 'cis124567897888', '1536290644', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('14', '1', '20', '9', '0', '很好看', '500', '500.00', '2018092101091', '1537529423', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('15', '1', '20', '9', '0', '很好看', '500', '500.00', '2018092101162', '1537532363', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('16', '1', '20', '9', '0', '很好看', '500', '500.00', '2018092101298', '1537532421', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('17', '1', '20', '9', '0', '很好看', '500', '500.00', '2018092101312', '1537532437', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('18', '1', '20', '9', '0', '很好看', '500', '500.00', '2018092101429', '1537532442', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('19', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092101558', '1537532969', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('20', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092101685', '1537533127', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('21', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092101762', '1537533453', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('54', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092105081', '1537539349', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('55', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092105177', '1537539351', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('56', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092105287', '1537539352', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('57', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092105370', '1537539353', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('58', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092105460', '1537539357', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('59', '1', '20', '9', '0', '很好看', '500', '500.00', '2018092505565', '1537841375', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('60', '1', '20', '9', '13', '很好看', '500', '500.00', '2018092906487', '1538229156', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('61', '6', '20', '9', '13', '很好看', '500', '500.00', '2018092906510', '1538229527', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('62', '6', '20', '9', '13', '很好看啊', '500', '500.00', '2018093007075', '1538272441', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('63', '1', '20', '9', '13', '很好看', '500', '500.00', '2018093007186', '1538274753', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('64', '1', '20', '9', '13', '很好看', '500', '500.00', '2018093007279', '1538275771', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('65', '6', '20', '9', '13', '很好看', '500', '500.00', '2018093007314', '1538276653', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('66', '6', '20', '9', '13', '很好看', '500', '500.00', '2018093007430', '1538276772', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('67', '1', '20', '9', '13', '很好看', '500', '500.00', '2018093007545', '1538277345', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('68', '6', '20', '9', '13', '很好看1', '500', '500.00', '2018093007877', '1538288288', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('69', '6', '20', '9', '13', '很好看', '500', '500.00', '2018093007986', '1538288349', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('70', '6', '20', '9', '13', '很好看', '500', '500.00', '2018093008018', '1538288362', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('71', '6', '20', '9', '13', '很好看', '500', '500.00', '2018093008119', '1538288525', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('72', '6', '20', '9', '13', '很好看', '500', '500.00', '2018093008298', '1538289843', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('73', '6', '1', '2', '1', '李小小洗车', '201', '201.01', '2018093008488', '1538290674', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('74', '6', '24', '11', '28', '亏咯旅途图', '90', '90.00', '2018093008510', '1538290832', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('75', '5', '20', '9', '13', '很好看', '500', '500.00', '2018093008615', '1538291999', '1', '1', '0', '1');
INSERT INTO `dp_user_order` VALUES ('76', '6', '1', '2', '1', '李小小洗车', '201', '201.01', '2018093008722', '1538292075', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('77', '6', '1', '2', '1', '李小小洗车', '201', '201.01', '2018093008860', '1538292147', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('78', '6', '20', '9', '13', '服务名:很好看', '500', '500.00', '2018101009339', '1539141699', '1', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('79', '6', '20', '9', '13', '服务名:很好看', '500', '500.00', '2018101009419', '1539141743', '2', '1', '0', '0');
INSERT INTO `dp_user_order` VALUES ('80', '6', '20', '9', '13', '服务名:很好看', '500', '500.00', '2018101009567', '1539143278', '1', '1', '0', '1');
