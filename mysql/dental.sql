/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50725
Source Host           : localhost:3306
Source Database       : dental

Target Server Type    : MYSQL
Target Server Version : 50725
File Encoding         : 65001

Date: 2019-04-02 17:32:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dental_allergy_history
-- ----------------------------
DROP TABLE IF EXISTS `dental_allergy_history`;
CREATE TABLE `dental_allergy_history` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '过敏史表设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_appointment
-- ----------------------------
DROP TABLE IF EXISTS `dental_appointment`;
CREATE TABLE `dental_appointment` (
  `id` int(11) NOT NULL,
  `sick_id` int(11) DEFAULT NULL COMMENT '病历号',
  `apt_type` varchar(255) DEFAULT NULL COMMENT '预约类型',
  `apt_status` varchar(255) DEFAULT NULL COMMENT '预约状态',
  `tel_one` varchar(255) DEFAULT NULL COMMENT '电话一',
  `tel_two` varchar(255) DEFAULT NULL COMMENT '电话2',
  `sex` varchar(255) DEFAULT '2' COMMENT '性别 0 男 1 女  2默认 未填',
  `age` int(11) DEFAULT NULL COMMENT '年龄',
  `source` varchar(255) DEFAULT NULL COMMENT '患者来源',
  `doctor_id` int(11) DEFAULT NULL COMMENT '预约医生id  关联员工表',
  `type_id` int(11) DEFAULT '0' COMMENT '就诊类型 0 初诊 1 复诊',
  `comment` varchar(255) DEFAULT NULL COMMENT '患者备注',
  `apt_comment` varchar(255) DEFAULT NULL COMMENT '预约备注',
  `apt_date` datetime DEFAULT NULL COMMENT '预约日期',
  `time_frame_begin` datetime DEFAULT NULL COMMENT '时段开始',
  `time_frame_end` datetime DEFAULT NULL COMMENT '时段结束',
  `items` varchar(255) DEFAULT NULL COMMENT '预约事项',
  `create_time` datetime DEFAULT NULL,
  `create_author` varchar(255) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `modify_author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_area
-- ----------------------------
DROP TABLE IF EXISTS `dental_area`;
CREATE TABLE `dental_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地区主键id',
  `area_code` int(11) DEFAULT NULL COMMENT '地区编号',
  `area_name` varchar(255) DEFAULT NULL COMMENT '地区名称',
  `parent_id` int(11) DEFAULT NULL COMMENT '地区父id',
  `level` int(2) DEFAULT NULL COMMENT '地区级别 1-省、自治区、直辖市 2-地级市、地区、自治州、盟 3-市辖区、县级市、县',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_author` varchar(255) DEFAULT NULL,
  `modify_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modify_author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_base_consult
-- ----------------------------
DROP TABLE IF EXISTS `dental_base_consult`;
CREATE TABLE `dental_base_consult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '基本需求表设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_case
-- ----------------------------
DROP TABLE IF EXISTS `dental_case`;
CREATE TABLE `dental_case` (
  `id` int(11) NOT NULL,
  `case_status` varchar(255) DEFAULT NULL COMMENT '状态，0 初诊，1复诊',
  `case_doctor_id` varchar(255) DEFAULT NULL COMMENT '检查医生',
  `case_nurse_id` varchar(255) DEFAULT NULL COMMENT '护士',
  `case_date` datetime DEFAULT NULL COMMENT '就诊日期',
  `case_main` varchar(255) DEFAULT NULL COMMENT '主诉',
  `now_history` varchar(255) DEFAULT NULL COMMENT '现病史',
  `previous_history` varchar(255) DEFAULT NULL COMMENT '既往史',
  `allergy_history` varchar(255) DEFAULT NULL COMMENT '过敏史',
  `check_id` int(11) DEFAULT NULL COMMENT '检查 (关联病例图形表id)',
  `assist_id` int(11) DEFAULT NULL COMMENT '(关联病例图形表id)辅助检查',
  `diagnose_id` int(11) DEFAULT NULL COMMENT '(关联病例图形表id)诊断',
  `therapeutic_id` int(11) DEFAULT NULL COMMENT '(关联病例图形表id)治疗方案',
  `cure_id` int(11) DEFAULT NULL COMMENT '(关联病例图形表id) 治疗',
  `advice` varchar(255) DEFAULT NULL COMMENT '医嘱',
  `img` varchar(255) DEFAULT NULL COMMENT '患者影像',
  `create_time` datetime DEFAULT NULL,
  `create_author` varchar(255) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `modify_author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_clinic
-- ----------------------------
DROP TABLE IF EXISTS `dental_clinic`;
CREATE TABLE `dental_clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `cli_name` varchar(255) NOT NULL COMMENT '诊所名称',
  `cli_person` varchar(255) DEFAULT NULL COMMENT '诊所联系人',
  `cli_phone` varchar(255) DEFAULT NULL COMMENT '诊所联系电话',
  `cli_tel` varchar(255) DEFAULT NULL COMMENT '诊所联系电话2',
  `is_hospital` bit(1) DEFAULT b'0' COMMENT '是否设置为医院0 否，1是',
  `cli_email` varchar(255) DEFAULT NULL COMMENT '诊所邮箱',
  `start_time` varchar(255) DEFAULT NULL COMMENT '营业开始时间',
  `end_time` varchar(255) DEFAULT NULL COMMENT '营业结束时间',
  `province_id` int(11) DEFAULT NULL COMMENT '省关联的id',
  `city_id` int(11) DEFAULT NULL COMMENT '市关联的id',
  `area_id` int(11) DEFAULT NULL COMMENT '区关联的id',
  `addr` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `wifi_name` varchar(255) DEFAULT NULL COMMENT 'WIFI 名称',
  `wifi_pwd` varchar(255) DEFAULT NULL COMMENT 'WIFI 密码',
  `qq` varchar(255) DEFAULT NULL COMMENT 'QQ',
  `introduction` varchar(255) DEFAULT NULL COMMENT '诊所介绍',
  `activity` varchar(255) DEFAULT NULL COMMENT '诊所活动',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_company
-- ----------------------------
DROP TABLE IF EXISTS `dental_company`;
CREATE TABLE `dental_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cp_code` varchar(255) DEFAULT NULL COMMENT '公司代码',
  `cp_name` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `cp_logo` varchar(255) DEFAULT NULL COMMENT '公司logo',
  `cp_description` varchar(255) DEFAULT NULL COMMENT '公司简介',
  `cp_parentid` int(11) DEFAULT NULL COMMENT '公司父节点（子公司）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_consult
-- ----------------------------
DROP TABLE IF EXISTS `dental_consult`;
CREATE TABLE `dental_consult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) DEFAULT NULL COMMENT '病例号关联',
  `main_consult` varchar(255) DEFAULT NULL COMMENT '客户主诉',
  `base_consult_id` int(255) DEFAULT NULL COMMENT '关联表基本需求id',
  `potential_consult_id` int(11) DEFAULT NULL COMMENT '关联表潜在需求id',
  `doctor_sug` varchar(255) DEFAULT NULL COMMENT '医生方案',
  `record` varchar(255) DEFAULT NULL COMMENT '沟通记录',
  `service_sug` varchar(255) DEFAULT NULL COMMENT '服务建议',
  `mem_doctor_id` int(11) DEFAULT NULL COMMENT '接诊医生id 关联员工表',
  `mem_consult_id` int(11) DEFAULT NULL COMMENT '咨询人员id 关联员工表',
  `create_author` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `modify_author` varchar(255) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_employee
-- ----------------------------
DROP TABLE IF EXISTS `dental_employee`;
CREATE TABLE `dental_employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cli_no` int(11) DEFAULT NULL COMMENT '诊所id（关联诊所id）',
  `no` int(11) NOT NULL COMMENT '员工编号',
  `name` varchar(255) NOT NULL COMMENT '员工姓名',
  `phone` varchar(255) NOT NULL COMMENT '手机号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `present` bit(1) DEFAULT b'1' COMMENT '在职情况 0 ，离职，1在职',
  `create_time` datetime DEFAULT NULL,
  `create_author` varchar(255) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `modify_author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_employee_role
-- ----------------------------
DROP TABLE IF EXISTS `dental_employee_role`;
CREATE TABLE `dental_employee_role` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL COMMENT '员工id',
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_impression
-- ----------------------------
DROP TABLE IF EXISTS `dental_impression`;
CREATE TABLE `dental_impression` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '印象表设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_medical_information
-- ----------------------------
DROP TABLE IF EXISTS `dental_medical_information`;
CREATE TABLE `dental_medical_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) DEFAULT NULL COMMENT '关联会员id',
  `patient_source_id` varchar(11) DEFAULT NULL COMMENT '关联患者来源表id',
  `patient_category_id` varchar(11) DEFAULT NULL COMMENT '关联患者分类表id',
  `allergy_history_id` varchar(11) DEFAULT NULL COMMENT '关联过敏史表id',
  `previous_history_id` varchar(11) DEFAULT NULL COMMENT '关联既往史表id',
  `brush_day_times` int(2) DEFAULT NULL COMMENT '每天刷牙次数',
  `brush_minutes_times` int(2) DEFAULT NULL COMMENT '每次刷牙多少分钟',
  `smoke_day_times` int(2) DEFAULT NULL COMMENT '每天吸烟多少次',
  `teeth_habits_id` int(11) DEFAULT NULL COMMENT '洁牙习惯关联表id',
  `first_visit_doctory` varchar(255) DEFAULT NULL COMMENT '初诊医生id（关联员工表）',
  `first_visit_date` datetime DEFAULT NULL COMMENT '初诊日期',
  `subs_visit_doctory` int(11) DEFAULT NULL COMMENT '复诊医生id（关联员工表）',
  `subs_visit_date` datetime DEFAULT NULL COMMENT '复诊日期',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_author` varchar(255) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `modify_author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_member
-- ----------------------------
DROP TABLE IF EXISTS `dental_member`;
CREATE TABLE `dental_member` (
  `id` int(11) NOT NULL,
  `case_no` varchar(255) DEFAULT NULL COMMENT '病例编号',
  `name` varchar(255) DEFAULT NULL COMMENT '患者姓名',
  `sex` varchar(255) DEFAULT '' COMMENT '性别0，男；1，女',
  `age` int(11) DEFAULT NULL COMMENT '年龄',
  `birthday` varchar(255) DEFAULT NULL COMMENT '出生年月日',
  `mem_level_id` varchar(255) DEFAULT NULL COMMENT '关联会员等级表id',
  `mem_card` varchar(255) DEFAULT NULL COMMENT '会员卡号',
  `profession_id` varchar(255) DEFAULT NULL COMMENT '关联职业表id',
  `society_no` int(11) DEFAULT NULL COMMENT '社保编号',
  `email` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL COMMENT '患者分组 0 最近患者，1黑名单，2，治疗完成',
  `content` varchar(255) DEFAULT NULL COMMENT '患者备注',
  `introducer` varchar(255) DEFAULT NULL COMMENT '介绍人',
  `counselor_id` varchar(255) DEFAULT NULL COMMENT '咨询师,关联员工表id',
  `address_id` varchar(255) DEFAULT NULL COMMENT '关联常用联系地址id',
  `impression_id` int(11) DEFAULT NULL COMMENT '关联患者印象表id',
  `grid_consulting_id` varchar(255) DEFAULT NULL COMMENT '电网咨询，关联员工表id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_member_address
-- ----------------------------
DROP TABLE IF EXISTS `dental_member_address`;
CREATE TABLE `dental_member_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '常用地址表设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_member_level
-- ----------------------------
DROP TABLE IF EXISTS `dental_member_level`;
CREATE TABLE `dental_member_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '会员等级设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_patient_category
-- ----------------------------
DROP TABLE IF EXISTS `dental_patient_category`;
CREATE TABLE `dental_patient_category` (
  `id` int(11) NOT NULL,
  `patient_category` varchar(255) DEFAULT NULL COMMENT '患者分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_patient_source
-- ----------------------------
DROP TABLE IF EXISTS `dental_patient_source`;
CREATE TABLE `dental_patient_source` (
  `id` int(11) NOT NULL COMMENT '患者来源编号',
  `patient_source` varchar(255) DEFAULT NULL COMMENT '患者来源名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_potential_consult
-- ----------------------------
DROP TABLE IF EXISTS `dental_potential_consult`;
CREATE TABLE `dental_potential_consult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '潜在需求表设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_previous_history
-- ----------------------------
DROP TABLE IF EXISTS `dental_previous_history`;
CREATE TABLE `dental_previous_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '既往史表设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_privilege
-- ----------------------------
DROP TABLE IF EXISTS `dental_privilege`;
CREATE TABLE `dental_privilege` (
  `id` int(11) NOT NULL,
  `pri_name` varchar(255) DEFAULT NULL COMMENT '权限名称',
  `pri_description` varchar(255) DEFAULT NULL COMMENT '权限描述',
  `pri_parentid` int(11) DEFAULT NULL COMMENT '父节点',
  `pri_level` varchar(255) DEFAULT NULL COMMENT '菜单级数',
  `pri_icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `pri_url` varchar(255) DEFAULT NULL COMMENT '菜单url',
  `pri_module` varchar(255) DEFAULT NULL COMMENT '模块',
  `pri_action` varchar(255) DEFAULT NULL COMMENT '功能',
  `pri_api` varchar(255) DEFAULT NULL COMMENT 'api 接口',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_author` varchar(255) DEFAULT NULL COMMENT '创建人',
  `modify_time` datetime DEFAULT NULL COMMENT '修改时间',
  `modify_author` varchar(255) DEFAULT NULL COMMENT '修改人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_profession
-- ----------------------------
DROP TABLE IF EXISTS `dental_profession`;
CREATE TABLE `dental_profession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '职业表设置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_region
-- ----------------------------
DROP TABLE IF EXISTS `dental_region`;
CREATE TABLE `dental_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_code` varchar(255) DEFAULT NULL COMMENT '大区代码',
  `region_name` varchar(255) DEFAULT NULL COMMENT '大区名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_role
-- ----------------------------
DROP TABLE IF EXISTS `dental_role`;
CREATE TABLE `dental_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `role_description` varchar(255) DEFAULT NULL COMMENT '角色描述（职位）',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `creater` varchar(255) DEFAULT NULL COMMENT '创建人',
  `modify_time` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `modifier` varchar(255) DEFAULT NULL COMMENT '修改人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_role_privilege
-- ----------------------------
DROP TABLE IF EXISTS `dental_role_privilege`;
CREATE TABLE `dental_role_privilege` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `pri_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_teeth_habits
-- ----------------------------
DROP TABLE IF EXISTS `dental_teeth_habits`;
CREATE TABLE `dental_teeth_habits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '洁牙习惯',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_teeth_img
-- ----------------------------
DROP TABLE IF EXISTS `dental_teeth_img`;
CREATE TABLE `dental_teeth_img` (
  `id` int(11) NOT NULL,
  `sick_no` int(11) DEFAULT NULL COMMENT '病历号',
  `typeid` int(11) DEFAULT NULL COMMENT '分类',
  `right_top` varchar(255) DEFAULT NULL,
  `right_bottom` varchar(255) DEFAULT NULL,
  `left_top` varchar(255) DEFAULT NULL,
  `left_bottom` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_author` varchar(255) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `modify_author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_visit_plan
-- ----------------------------
DROP TABLE IF EXISTS `dental_visit_plan`;
CREATE TABLE `dental_visit_plan` (
  `id` int(11) NOT NULL,
  `sick_id` int(11) DEFAULT NULL COMMENT '关联病例号id',
  `visit_time` datetime DEFAULT NULL COMMENT '回访时间',
  `visit_person` varchar(255) DEFAULT NULL COMMENT '回访人员',
  `main_doctor` varchar(255) DEFAULT NULL COMMENT '主治医生',
  `visit_status` varchar(255) DEFAULT NULL COMMENT '回访状态0 已回访，1做计划，2待跟进',
  `visit_comment` varchar(255) DEFAULT NULL COMMENT '回访内容',
  `visit_result` varchar(255) DEFAULT NULL COMMENT '回访结果',
  `visit_sound` varchar(255) DEFAULT NULL COMMENT '回访录音',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dental_log
-- 日志表,记录日常操作记录
-- ----------------------------
DROP TABLE IF EXISTS `operation_logs`;
CREATE TABLE `operation_logs` (
  `id` int(11) NOT NULL,
  `ct_user` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '操作人',
  `ct_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '操作时间',
  `patient` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '相关患者',
  `module` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '功能模块',
  `platform` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '操作平台',
  `operation_type` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '操作类型',
  `operation_content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '操作内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
