<?php 
/*!
 * Jetpack CRM
 * https://jetpackcrm.com
 * V1.20
 *
 * Copyright 2020 Automattic
 *
 * Date: 01/11/16
 */

defined( 'ZEROBSCRM_PATH' ) || exit( 0 );

/* ======================================================
  Table Creation
   ====================================================== */

global $wpdb, $ZBSCRM_t;
// Table names
// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
$ZBSCRM_t['contacts']              = $wpdb->prefix . 'zbs_contacts';
$ZBSCRM_t['customfields']          = $wpdb->prefix . 'zbs_customfields';
$ZBSCRM_t['meta']                  = $wpdb->prefix . 'zbs_meta';
$ZBSCRM_t['tags']                  = $wpdb->prefix . 'zbs_tags';
$ZBSCRM_t['taglinks']              = $wpdb->prefix . 'zbs_tags_links';
$ZBSCRM_t['settings']              = $wpdb->prefix . 'zbs_settings';
$ZBSCRM_t['segments']              = $wpdb->prefix . 'zbs_segments';
$ZBSCRM_t['segmentsconditions']    = $wpdb->prefix . 'zbs_segments_conditions';
$ZBSCRM_t['adminlog']              = $wpdb->prefix . 'zbs_admlog';
$ZBSCRM_t['temphash']              = $wpdb->prefix . 'zbs_temphash';
$ZBSCRM_t['objlinks']              = $wpdb->prefix . 'zbs_object_links';
$ZBSCRM_t['aka']                   = $wpdb->prefix . 'zbs_aka';
$ZBSCRM_t['externalsources']       = $wpdb->prefix . 'zbs_externalsources';
$ZBSCRM_t['tracking']              = $wpdb->prefix . 'zbs_tracking';
$ZBSCRM_t['logs']                  = $wpdb->prefix . 'zbs_logs';
$ZBSCRM_t['system_mail_templates'] = $wpdb->prefix . 'zbs_sys_email';
$ZBSCRM_t['system_mail_hist']      = $wpdb->prefix . 'zbs_sys_email_hist';
$ZBSCRM_t['cronmanagerlogs']       = $wpdb->prefix . 'zbs_sys_cronmanagerlogs';
$ZBSCRM_t['companies']             = $wpdb->prefix . 'zbs_companies';
$ZBSCRM_t['quotes']                = $wpdb->prefix . 'zbs_quotes';
$ZBSCRM_t['quotetemplates']        = $wpdb->prefix . 'zbs_quotes_templates';
$ZBSCRM_t['invoices']              = $wpdb->prefix . 'zbs_invoices';
$ZBSCRM_t['transactions']          = $wpdb->prefix . 'zbs_transactions';
$ZBSCRM_t['lineitems']             = $wpdb->prefix . 'zbs_lineitems';
$ZBSCRM_t['forms']                 = $wpdb->prefix . 'zbs_forms';
$ZBSCRM_t['events']                = $wpdb->prefix . 'zbs_events';
$ZBSCRM_t['eventreminders']        = $wpdb->prefix . 'zbs_event_reminders';
$ZBSCRM_t['tax']                   = $wpdb->prefix . 'zbs_tax_table';
$ZBSCRM_t['security_log']          = $wpdb->prefix . 'zbs_security_log';
$ZBSCRM_t['automation-workflows']  = $wpdb->prefix . 'zbs_workflows';
// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

/**
 * Core-fired Database structure check
 * ... currently used to check tables exist
 */
function zeroBSCRM_database_check(){

  #} Check + create
  zeroBSCRM_checkTablesExist();

}

/**
 * creates the ZBS Database Tables
 *
 */
function zeroBSCRM_createTables(){

  global $wpdb, $ZBSCRM_t;

  // Require upgrade.php so we can use dbDelta
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

  // Where available we force InnoDB
  $storageEngineLine = ''; if (zeroBSCRM_DB_canInnoDB()) $storageEngineLine = 'ENGINE = InnoDB';

  // Collation & Character Set
  $collation = 'utf8_general_ci';
  $characterSet = 'utf8';

  // We'll collect any errors as we go, exposing, if there are any, on system status page
  global $zbsDB_lastError,$zbsDB_creationErrors;

    // we log the last error before we start, in case another plugin has left an error in the buffer
    $zbsDB_lastError = ''; if (isset($wpdb->last_error)) $zbsDB_lastError = $wpdb->last_error;
    $zbsDB_creationErrors = array();

  // Contacts
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['contacts'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsc_status` VARCHAR(100) NULL,
  `zbsc_email` VARCHAR(200) NULL,
  `zbsc_prefix` VARCHAR(30) NULL,
  `zbsc_fname` VARCHAR(100) NULL,
  `zbsc_lname` VARCHAR(100) NULL,
  `zbsc_addr1` VARCHAR(200) NULL,
  `zbsc_addr2` VARCHAR(200) NULL,
  `zbsc_city` VARCHAR(200) NULL,
  `zbsc_county` VARCHAR(200) NULL,
  `zbsc_country` VARCHAR(200) NULL,
  `zbsc_postcode` VARCHAR(50) NULL,
  `zbsc_secaddr1` VARCHAR(200) NULL,
  `zbsc_secaddr2` VARCHAR(200) NULL,
  `zbsc_seccity` VARCHAR(200) NULL,
  `zbsc_seccounty` VARCHAR(200) NULL,
  `zbsc_seccountry` VARCHAR(200) NULL,
  `zbsc_secpostcode` VARCHAR(50) NULL,
  `zbsc_hometel` VARCHAR(40) NULL,
  `zbsc_worktel` VARCHAR(40) NULL,
  `zbsc_mobtel` VARCHAR(40) NULL,    
  `zbsc_wpid` INT NULL DEFAULT NULL,
  `zbsc_avatar` VARCHAR(300) NULL,
  `zbsc_tw` VARCHAR(100) NULL,
  `zbsc_li` VARCHAR(300) NULL,
  `zbsc_fb` VARCHAR(200) NULL,
  `zbsc_created` INT(14) NOT NULL,
  `zbsc_lastupdated` INT(14) NOT NULL,
  `zbsc_lastcontacted` INT(14) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX (`zbsc_email`, `zbsc_wpid`),
  KEY `zbsc_status` (`zbsc_status`) USING BTREE)
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // Custom Fields
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['customfields'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbscf_objtype` INT(4) NOT NULL,
  `zbscf_objid` INT(32) NOT NULL,
  `zbscf_objkey` VARCHAR(100) NOT NULL,
  `zbscf_objval` VARCHAR(2000) NULL DEFAULT NULL,
  `zbscf_created` INT(14) NOT NULL,
  `zbscf_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `TYPEIDKEY` (`zbscf_objtype` ASC, `zbscf_objid` ASC, `zbscf_objkey` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";"; 
  zeroBSCRM_db_runDelta($sql); 


  // Tags
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['tags'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbstag_objtype` INT NOT NULL,
  `zbstag_name` VARCHAR(200) NOT NULL,
  `zbstag_slug` VARCHAR(200) NOT NULL,
  `zbstag_created` INT(14) NOT NULL,
  `zbstag_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";"; 
  zeroBSCRM_db_runDelta($sql); 

  // Tag Relationships (Links)
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['taglinks'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbstl_objtype` INT(4) NOT NULL,
  `zbstl_objid` INT NOT NULL,
  `zbstl_tagid` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX (`zbstl_objid`),
  INDEX (`zbstl_tagid`),
  KEY `zbstl_tagid+zbstl_objtype` (`zbstl_tagid`,`zbstl_objtype`) USING BTREE)
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";"; 
  zeroBSCRM_db_runDelta($sql); 

  // Settings
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['settings'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsset_key` VARCHAR(100) NOT NULL DEFAULT -1,
  `zbsset_val` LONGTEXT NULL DEFAULT NULL,
  `zbsset_created` INT(14) NOT NULL,
  `zbsset_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `zbsset_key` (`zbsset_key`),
  INDEX (`zbs_owner`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  // Meta Key-Value pairs
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['meta'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsm_objtype` INT NOT NULL,
  `zbsm_objid` INT NOT NULL,
  `zbsm_key` VARCHAR(255) NOT NULL,
  `zbsm_val` LONGTEXT NULL DEFAULT NULL,
  `zbsm_created` INT(14) NOT NULL,
  `zbsm_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `zbsm_objid+zbsm_key+zbsm_objtype` (`zbsm_objid`,`zbsm_key`,`zbsm_objtype`) USING BTREE)
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  #} Segments
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['segments'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsseg_name` VARCHAR(120) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `zbsseg_slug` VARCHAR(45) NOT NULL,
  `zbsseg_matchtype` VARCHAR(10) NOT NULL,
  `zbsseg_created` INT(14) NOT NULL,
  `zbsseg_lastupdated` INT(14) NOT NULL,
  `zbsseg_compilecount` INT NULL DEFAULT 0,
  `zbsseg_lastcompiled` INT(14) NOT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  // Segments: Conditions
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['segmentsconditions'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbscondition_segmentid` INT NOT NULL,
  `zbscondition_type` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `zbscondition_op` VARCHAR(50) NULL,
  `zbscondition_val` VARCHAR(250) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  `zbscondition_val_secondary` VARCHAR(250) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  // Admin Logs
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['adminlog'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsadmlog_status` INT(3) NOT NULL,
  `zbsadmlog_cat` VARCHAR(20) NULL DEFAULT NULL,
  `zbsadmlog_str` VARCHAR(500) NULL DEFAULT NULL,
  `zbsadmlog_time` INT(14) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  // Temporary Hashes
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['temphash'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbstemphash_status` INT NULL DEFAULT -1,
  `zbstemphash_objtype` VARCHAR(50) NOT NULL,
  `zbstemphash_objid` INT NULL DEFAULT NULL,
  `zbstemphash_objhash` VARCHAR(256) NULL DEFAULT NULL,
  `zbstemphash_created` INT(14) NOT NULL,
  `zbstemphash_lastupdated` INT(14) NOT NULL,
  `zbstemphash_expiry` INT(14) NOT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  // Object Relationships (Links)
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['objlinks'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsol_objtype_from` INT(4) NOT NULL,
  `zbsol_objtype_to` INT(4) NOT NULL,
  `zbsol_objid_from` INT NOT NULL,
  `zbsol_objid_to` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX (`zbsol_objid_from`),
  INDEX (`zbsol_objid_to`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  #} AKA (Aliases)
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['aka'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `aka_type` INT NULL,
  `aka_id` INT NOT NULL,
  `aka_alias` VARCHAR(200) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  `aka_created` INT(14) NULL,
  `aka_lastupdated` INT(14) NULL,
  PRIMARY KEY (`ID`),
  INDEX (`aka_id`, `aka_alias`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 
  
  #} External sources
  // NOTE:! Modified in 2.97.5 migration
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['externalsources'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbss_objtype` INT(3) NOT NULL DEFAULT '-1',
  `zbss_objid` INT(32) NOT NULL,
  `zbss_source` VARCHAR(20) NOT NULL,
  `zbss_uid` VARCHAR(300) NOT NULL,
  `zbss_origin` VARCHAR(400) NULL DEFAULT NULL,
  `zbss_created` INT(14) NOT NULL,
  `zbss_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX (`zbss_objid`),
  INDEX (`zbss_origin`),
  KEY `zbss_uid+zbss_source+zbss_objtype` (`zbss_uid`,`zbss_source`,`zbss_objtype`) USING BTREE)
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  #} Tracking (web hit info)
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['tracking'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbst_contactid` INT NOT NULL,
  `zbst_action` VARCHAR(50) NOT NULL,
  `zbst_action_detail` LONGTEXT NOT NULL,
  `zbst_referrer` VARCHAR(300) NOT NULL,
  `zbst_utm_source` VARCHAR(200) NOT NULL,
  `zbst_utm_medium` VARCHAR(200) NOT NULL,
  `zbst_utm_name` VARCHAR(200) NOT NULL,
  `zbst_utm_term` VARCHAR(200) NOT NULL,
  `zbst_utm_content` VARCHAR(200) NOT NULL,
  `zbst_created` INT(14) NOT NULL,
  `zbst_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  #} Logs
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['logs'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsl_objtype` INT NOT NULL,
  `zbsl_objid` INT NOT NULL,
  `zbsl_type` VARCHAR(200) NOT NULL,
  `zbsl_shortdesc` VARCHAR(300) NULL,
  `zbsl_longdesc` LONGTEXT NULL,
	`zbsl_pinned` INT(1) NULL,
  `zbsl_created` INT(14) NOT NULL,
  `zbsl_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX (`zbsl_objid`),
  INDEX `zbsl_created` (`zbsl_created`) USING BTREE)
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  // System Email Templates
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['system_mail_templates'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsmail_active` INT NOT NULL,
  `zbsmail_id` INT NOT NULL,
  `zbsmail_deliverymethod` VARCHAR(200) NOT NULL,
  `zbsmail_fromname` VARCHAR(200) NULL,
  `zbsmail_fromaddress` VARCHAR(200) NULL,
  `zbsmail_replyto` VARCHAR(200) NULL,
  `zbsmail_ccto` VARCHAR(200) NULL,
  `zbsmail_bccto` VARCHAR(200) NULL,
  `zbsmail_subject` VARCHAR(200) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL DEFAULT NULL,
  `zbsmail_body` LONGTEXT NULL DEFAULT NULL,
  `zbsmail_created` INT(14) NOT NULL,
  `zbsmail_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // System Email History
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['system_mail_hist'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` int(11) DEFAULT NULL,
  `zbs_team` int(11) DEFAULT NULL,
  `zbs_owner` int(11) NOT NULL,
  `zbsmail_type` int(11) NOT NULL,
  `zbsmail_sender_thread` int(11) NOT NULL,
  `zbsmail_sender_email` varchar(200) NOT NULL,
  `zbsmail_sender_wpid` int(11) NOT NULL,
  `zbsmail_sender_mailbox_id` int(11) NOT NULL,
  `zbsmail_sender_mailbox_name` varchar(200) DEFAULT NULL,
  `zbsmail_receiver_email` varchar(200) NOT NULL,
  `zbsmail_sent` int(11) NOT NULL,
  `zbsmail_target_objid` int(11) NOT NULL,
  `zbsmail_assoc_objid` int(11) NOT NULL,
  `zbsmail_subject` varchar(200) DEFAULT NULL,
  `zbsmail_content` longtext,
  `zbsmail_hash` varchar(128) DEFAULT NULL,
  `zbsmail_status` varchar(120) DEFAULT NULL,
  `zbsmail_sender_maildelivery_key` varchar(200) DEFAULT NULL,
  `zbsmail_starred` int(11) DEFAULT NULL,
  `zbsmail_opened` int(11) NOT NULL,
  `zbsmail_clicked` int(11) NOT NULL,
  `zbsmail_firstopened` int(14) NOT NULL,
  `zbsmail_lastopened` int(14) NOT NULL,
  `zbsmail_lastclicked` int(14) NOT NULL,
  `zbsmail_created` int(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX (`zbsmail_sender_wpid`),
  INDEX (`zbsmail_sender_mailbox_id`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql); 

  // cron Manager Logs
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['cronmanagerlogs'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` int(11) DEFAULT NULL,
  `zbs_team` int(11) DEFAULT NULL,
  `zbs_owner` int(11) NOT NULL,
  `job` VARCHAR(100) NOT NULL,
  `jobstatus` INT(3) NULL,
  `jobstarted` INT(14) NOT NULL,
  `jobfinished` INT(14) NOT NULL,
  `jobnotes` LONGTEXT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  
  // Tax Table
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['tax'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` int(11) DEFAULT NULL,
  `zbs_team` int(11) DEFAULT NULL,
  `zbs_owner` int(11) NOT NULL,
  `zbsc_tax_name` VARCHAR(100) NULL,
  `zbsc_rate` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbsc_created` INT(14) NOT NULL,
  `zbsc_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";"; 
  zeroBSCRM_db_runDelta($sql); 

  // Companies (DB3.0+)
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['companies'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsco_status` VARCHAR(50) NULL DEFAULT NULL,
  `zbsco_name` VARCHAR(100) NULL DEFAULT NULL,
  `zbsco_email` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_addr1` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_addr2` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_city` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_county` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_country` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_postcode` VARCHAR(50) NULL DEFAULT NULL,
  `zbsco_secaddr1` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_secaddr2` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_seccity` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_seccounty` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_seccountry` VARCHAR(200) NULL DEFAULT NULL,
  `zbsco_secpostcode` VARCHAR(50) NULL DEFAULT NULL,
  `zbsco_maintel` VARCHAR(40) NULL DEFAULT NULL,
  `zbsco_sectel` VARCHAR(40) NULL DEFAULT NULL,
  `zbsco_wpid` INT NULL DEFAULT NULL,
  `zbsco_avatar` VARCHAR(300) NULL DEFAULT NULL,
  `zbsco_tw` VARCHAR(100) NULL,
  `zbsco_li` VARCHAR(300) NULL,
  `zbsco_fb` VARCHAR(200) NULL,
  `zbsco_created` INT(14) NOT NULL,
  `zbsco_lastupdated` INT(14) NOT NULL,
  `zbsco_lastcontacted` INT(14) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `wpid` (`zbsco_wpid` ASC),
  INDEX `name` (`zbsco_name` ASC),
  INDEX `email` (`zbsco_email` ASC),
  INDEX `created` (`zbsco_created` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // Tasks (DB3.0+)
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['events'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbse_title` VARCHAR(255) NULL DEFAULT NULL,
  `zbse_desc` LONGTEXT NULL DEFAULT NULL,
  `zbse_start` INT(14) NOT NULL,
  `zbse_end` INT(14) NOT NULL,
  `zbse_complete` TINYINT(1) NOT NULL DEFAULT -1,
  `zbse_show_on_portal` TINYINT(1) NOT NULL DEFAULT -1,
  `zbse_show_on_cal` TINYINT(1) NOT NULL DEFAULT -1,
  `zbse_created` INT(14) NOT NULL,
  `zbse_lastupdated` INT(14) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `title` (`zbse_title` ASC),
  INDEX `startint` (`zbse_start` ASC),
  INDEX `endint` (`zbse_end` ASC),
  INDEX `created` (`zbse_created` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // Task Reminders (DB3.0+)
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['eventreminders'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbser_event` INT NOT NULL,
  `zbser_remind_at` INT NOT NULL DEFAULT -1,
  `zbser_sent` TINYINT NOT NULL DEFAULT -1,
  `zbser_created` INT(14) NOT NULL,
  `zbser_lastupdated` INT(14) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // Forms
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['forms'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsf_title` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_style` VARCHAR(20) NOT NULL,
  `zbsf_views` INT(10) NULL DEFAULT 0,
  `zbsf_conversions` INT(10) NULL DEFAULT 0,
  `zbsf_label_header` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_subheader` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_firstname` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_lastname` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_email` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_message` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_button` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_successmsg` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_label_spammsg` VARCHAR(200) NULL DEFAULT NULL,
  `zbsf_include_terms_check` TINYINT(1) NOT NULL DEFAULT -1,
  `zbsf_terms_url` VARCHAR(300) NULL DEFAULT NULL,
  `zbsf_redir_url` VARCHAR(300) NULL DEFAULT NULL,
  `zbsf_font` VARCHAR(100) NULL DEFAULT NULL,
  `zbsf_colour_bg` VARCHAR(100) NULL DEFAULT NULL,
  `zbsf_colour_font` VARCHAR(100) NULL DEFAULT NULL,
  `zbsf_colour_emphasis` VARCHAR(100) NULL DEFAULT NULL,
  `zbsf_created` INT(14) NOT NULL,
  `zbsf_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `title` (`zbsf_title` ASC),
  INDEX `created` (`zbsf_created` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // Invoices
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['invoices'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsi_id_override` VARCHAR(128) NULL DEFAULT NULL,
  `zbsi_parent` INT NULL DEFAULT NULL,
  `zbsi_status` VARCHAR(50) NOT NULL,
  `zbsi_hash` VARCHAR(64) NULL DEFAULT NULL,
  `zbsi_send_attachments` TINYINT(1) NOT NULL DEFAULT -1,
  `zbsi_pdf_template` VARCHAR(128) NULL DEFAULT NULL,
  `zbsi_portal_template` VARCHAR(128) NULL DEFAULT NULL,
  `zbsi_email_template` VARCHAR(128) NULL DEFAULT NULL,
  `zbsi_invoice_frequency` INT(4) NULL DEFAULT -1,
  `zbsi_currency` VARCHAR(4) NOT NULL DEFAULT -1,
  `zbsi_pay_via` INT(4) NULL DEFAULT NULL,
  `zbsi_logo_url` VARCHAR(300) NULL DEFAULT NULL,
  `zbsi_address_to_objtype` INT(2) NOT NULL DEFAULT -1,
  `zbsi_addressed_from` VARCHAR(600) NULL DEFAULT NULL,
  `zbsi_addressed_to` VARCHAR(600) NULL DEFAULT NULL,
  `zbsi_allow_partial` TINYINT(1) NOT NULL DEFAULT -1,
  `zbsi_allow_tip` TINYINT(1) NOT NULL DEFAULT -1,
  `zbsi_hours_or_quantity` TINYINT(1) NOT NULL DEFAULT 1,
  `zbsi_date` INT(14) NOT NULL,
  `zbsi_due_date` INT(14) NULL DEFAULT NULL,
  `zbsi_paid_date` INT(14) NULL DEFAULT -1,
  `zbsi_hash_viewed` INT(14) NULL DEFAULT -1,
  `zbsi_hash_viewed_count` INT(10) NULL DEFAULT 0,
  `zbsi_portal_viewed` INT(14) NULL DEFAULT -1,
  `zbsi_portal_viewed_count` INT(10) NULL DEFAULT 0,
  `zbsi_net` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbsi_discount` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsi_discount_type` VARCHAR(20) NULL DEFAULT NULL,
  `zbsi_shipping` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsi_shipping_taxes` VARCHAR(40) NULL DEFAULT NULL,
  `zbsi_shipping_tax` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsi_taxes` VARCHAR(40) NULL DEFAULT NULL,
  `zbsi_tax` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsi_total` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbsi_created` INT(14) NOT NULL,
  `zbsi_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `idoverride` (`zbsi_id_override` ASC),
  INDEX `parent` (`zbsi_parent` ASC),
  INDEX `status` (`zbsi_status` ASC),
  INDEX `hash` (`zbsi_hash` ASC),
  INDEX `created` (`zbsi_created` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // Line Items (DB3.0+)
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['lineitems'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsli_order` INT NULL DEFAULT NULL,
  `zbsli_title` VARCHAR(300) NULL DEFAULT NULL,
  `zbsli_desc` VARCHAR(300) NULL DEFAULT NULL,
  `zbsli_quantity` decimal(18,2) NULL DEFAULT NULL,
  `zbsli_price` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbsli_currency` VARCHAR(4) NOT NULL DEFAULT -1,
  `zbsli_net` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbsli_discount` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsli_fee` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsli_shipping` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsli_shipping_taxes` VARCHAR(40) NULL DEFAULT NULL,
  `zbsli_shipping_tax` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsli_taxes` VARCHAR(40) NULL DEFAULT NULL,
  `zbsli_tax` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsli_total` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbsli_created` INT(14) NOT NULL,
  `zbsli_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `order` (`zbsli_order` ASC),
  INDEX `created` (`zbsli_created` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);
    
  // Quotes (DB3.0+)
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['quotes'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsq_id_override` VARCHAR(128) NULL DEFAULT NULL,
  `zbsq_title` VARCHAR(255) NULL DEFAULT NULL,
  `zbsq_currency` VARCHAR(4) NOT NULL DEFAULT -1,
  `zbsq_value` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsq_date` INT(14) NOT NULL,
  `zbsq_template` VARCHAR(200) NULL DEFAULT NULL,
  `zbsq_content` LONGTEXT NULL DEFAULT NULL,
  `zbsq_notes` LONGTEXT NULL DEFAULT NULL,
  `zbsq_hash` VARCHAR(64) NULL DEFAULT NULL,
  `zbsq_send_attachments` TINYINT(1) NOT NULL DEFAULT -1,
  `zbsq_lastviewed` INT(14) NULL DEFAULT -1,
  `zbsq_viewed_count` INT(10) NULL DEFAULT 0,
  `zbsq_accepted` INT(14) NULL DEFAULT -1,
  `zbsq_acceptedsigned` VARCHAR(200) NULL DEFAULT NULL,
  `zbsq_acceptedip` VARCHAR(64) NULL DEFAULT NULL,
  `zbsq_created` INT(14) NOT NULL,
  `zbsq_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `title` (`zbsq_title` ASC),
  INDEX `dateint` (`zbsq_date` ASC),
  INDEX `hash` (`zbsq_hash` ASC),
  INDEX `created` (`zbsq_created` ASC),
  INDEX `accepted` (`zbsq_accepted` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);
    
  // Quote Templates (DB3.0+)
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['quotetemplates'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbsqt_title` VARCHAR(255) NULL DEFAULT NULL,
  `zbsqt_value` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbsqt_date_str` VARCHAR(20) NULL DEFAULT NULL,
  `zbsqt_date` INT(14) NULL DEFAULT NULL,
  `zbsqt_content` LONGTEXT NULL DEFAULT NULL,
  `zbsqt_notes` LONGTEXT NULL DEFAULT NULL,
  `zbsqt_currency` VARCHAR(4) NOT NULL DEFAULT -1,
  `zbsqt_created` INT(14) NOT NULL,
  `zbsqt_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `title` (`zbsqt_title` ASC),
  INDEX `created` (`zbsqt_created` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);
    
  // Transactions (DB3.0+)
   $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['transactions'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbst_status` VARCHAR(50) NOT NULL,
  `zbst_type` VARCHAR(50) DEFAULT NULL,
  `zbst_ref` VARCHAR(120) NOT NULL,
  `zbst_origin` VARCHAR(100) NULL DEFAULT NULL,
  `zbst_parent` INT NULL DEFAULT NULL,
  `zbst_hash` VARCHAR(64) NULL DEFAULT NULL,
  `zbst_title` VARCHAR(200) NULL DEFAULT NULL,
  `zbst_desc` VARCHAR(200) NULL DEFAULT NULL,
  `zbst_date` INT(14) NULL DEFAULT NULL,
  `zbst_customer_ip` VARCHAR(45) NULL DEFAULT NULL,
  `zbst_currency` VARCHAR(4) NOT NULL DEFAULT -1,
  `zbst_net` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbst_fee` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbst_discount` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbst_shipping` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbst_shipping_taxes` VARCHAR(40) NULL DEFAULT NULL,
  `zbst_shipping_tax` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbst_taxes` VARCHAR(40) NULL DEFAULT NULL,
  `zbst_tax` DECIMAL(18,2) NULL DEFAULT 0.00,
  `zbst_total` DECIMAL(18,2) NOT NULL DEFAULT 0.00,
  `zbst_date_paid` INT(14) NULL DEFAULT NULL,
  `zbst_date_completed` INT(14) NULL DEFAULT NULL,
  `zbst_created` INT(14) NOT NULL,
  `zbst_lastupdated` INT(14) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `status` (`zbst_status` ASC),
  INDEX `ref` (`zbst_ref` ASC),
  INDEX `transtype` (`zbst_type` ASC),
  INDEX `transorigin` (`zbst_origin` ASC),
  INDEX `parent` (`zbst_parent` ASC),
  INDEX `hash` (`zbst_hash` ASC),
  INDEX `date` (`zbst_date` ASC),
  INDEX `title` (`zbst_title` ASC),
  INDEX `created` (`zbst_created` ASC))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";";
  zeroBSCRM_db_runDelta($sql);

  // Security logs (used to stop repeat brute-forcing quote/inv hashes etc.)
  $sql = "CREATE TABLE IF NOT EXISTS ". $ZBSCRM_t['security_log'] ."(
  `ID` INT NOT NULL AUTO_INCREMENT,
  `zbs_site` INT NULL DEFAULT NULL,
  `zbs_team` INT NULL DEFAULT NULL,
  `zbs_owner` INT NOT NULL,
  `zbssl_reqtype` VARCHAR(20) NOT NULL,
  `zbssl_ip` VARCHAR(200) NULL DEFAULT NULL,
  `zbssl_reqhash` VARCHAR(128) NULL DEFAULT NULL,
  `zbssl_reqid` INT(11) NULL DEFAULT NULL,
  `zbssl_loggedin_id` INT(11) NULL DEFAULT NULL,
  `zbssl_reqstatus` INT(1) NULL DEFAULT NULL,
  `zbssl_reqtime` INT(14) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`))
  ".$storageEngineLine."
  DEFAULT CHARACTER SET = ".$characterSet."
  COLLATE = ".$collation.";"; 
  zeroBSCRM_db_runDelta($sql);

	// Add table to store automation workflows.
	// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
	$sql = 'CREATE TABLE IF NOT EXISTS ' . $ZBSCRM_t['automation-workflows'] . '(
	`id` INT NOT NULL AUTO_INCREMENT,
	`zbs_site` INT NOT NULL,
	`zbs_team` INT NOT NULL,
	`zbs_owner` INT NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`description` VARCHAR(600) NULL DEFAULT NULL,
	`category` VARCHAR(255) NOT NULL,
	`triggers` LONGTEXT NOT NULL,
	`initial_step` VARCHAR(255) NOT NULL,
	`steps` LONGTEXT NOT NULL,
	`active` TINYINT(1) NOT NULL DEFAULT 0,
	`version` INT(14) NOT NULL DEFAULT 1,
	`created_at` INT(14) DEFAULT NULL,
	`updated_at` INT(14) DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `name` (`name` ASC),
	INDEX `active` (`active` ASC),
	INDEX `category` (`category` ASC),
	INDEX `created_at` (`created_at` ASC)
	) ' . $storageEngineLine . '
	DEFAULT CHARACTER SET = ' . $characterSet . '
	COLLATE = ' . $collation . ';';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
	zeroBSCRM_db_runDelta( $sql );

  // As of v5.0, if we've created via the above SQL, we're at DAL3 :)
  // so on fresh installs, immitate the fact that we've 'completed' DAL1->DAL2->DAL3 Migration chain
  update_option( 'zbs_db_migration_253', array('completed'=>time(),'started'=>time()), false);
  update_option( 'zbs_db_migration_300', array('completed'=>time(),'started'=>time()), false);

  // if any errors, log to wp option (potentially can't save to our zbs settings table because may not exist)
  $errors = $zbsDB_creationErrors;
  if (is_array($errors)){
    if (count($errors) > 0) 
      update_option( 'zbs_db_creation_errors', array('lasttried' => time(),'errors' => $errors), false);
    else
      delete_option( 'zbs_db_creation_errors' ); // successful run kills the alert
  }

  // no longer needed
  unset($zbsDB_lastError,$zbsDB_creationErrors);

  // return any errors encountered
  return $errors;


}

#} Check existence & Create func
#} WH NOTE: This could be more efficient (once we have a bunch of tabs)
function zeroBSCRM_checkTablesExist(){

	global $ZBSCRM_t, $wpdb;

	$create = false;

	// then we cycle through our tables :) - means all keys NEED to be kept up to date :)
	// No need to add to this ever now :)
	if ( ! $create ) {
		foreach ( $ZBSCRM_t as $tableKey => $tableName ) {
			$tablesExist = $wpdb->get_results( "SHOW TABLES LIKE '" . $tableName . "'" );
			if ( count( $tablesExist ) < 1 ) {
				$create = true;
				break;
			}
		}
	}

	if ( $create ) {
		zeroBSCRM_createTables();
	}

	// hooked in by extensions
	do_action( 'zbs_db_check' );

	return $create;
}


/**
 * Attempts to run $sql through dbDelta, adding any errors to the stack as it encounters them
 *
 */
function zeroBSCRM_db_runDelta($sql=''){
  
    global $wpdb,$zbsDB_lastError,$zbsDB_creationErrors;
  
    // enact
    dbDelta($sql);

    // catch any (new) errors
    if (isset($wpdb->last_error) && $wpdb->last_error !== $zbsDB_lastError) {
      
      // add to the stack
      $zbsDB_creationErrors[] = $wpdb->last_error;

      // clock it as latest error
      $zbsDB_lastError = $wpdb->last_error;

    }

}
 
/**
 * returns availability of InnoDB MySQL Storage Engine
 *
 *  gh-470, some users on some installs did not have InnoDB
 *  Used in table creation to force InnoDB use where possible,
 *  ... and also used to expose availability via System Status UI
 *
 * @return bool (if InnoDB available)
 */
function zeroBSCRM_DB_canInnoDB(){

	if ( jpcrm_database_engine() === 'sqlite' ) {
		return false;
	}

    global $wpdb;

    // attempt to cycle through MySQL's ENGINES & discern InnoDB
    $availableStorageEngines = $wpdb->get_results('SHOW ENGINES');
    if (is_array($availableStorageEngines)) foreach ($availableStorageEngines as $engine){

        if (is_object($engine) && isset($engine->Engine) && $engine->Engine == 'InnoDB') return true;

    }

    return false;

}

/**
 * Get info about the database engine.
 *
 * @param boolean $pretty Retrieve a user-friendly label instead of a slug.
 *
 * @return string
 */
function jpcrm_database_engine( $pretty = false ) {
	global $zbs;

	if ( ! $zbs ) {
		return 'unknown';
	}

	if ( $pretty ) {
		return $zbs->database_server_info['db_engine_label'];
	}
	return $zbs->database_server_info['db_engine'];
}

/**
 * Get the database version.
 *
 * @return string
 */
function zeroBSCRM_database_getVersion() {
	global $zbs;
	return $zbs->database_server_info['raw_version'];
}

function jpcrm_database_server_has_ability( $ability_name ) {
	global $zbs;
	$db_server_version = zeroBSCRM_database_getVersion();
	$db_engine         = $zbs->database_server_info['db_engine'];

	if ( $ability_name === 'fulltext_index' ) {
		if ( $db_engine === 'sqlite' ) {
			return false;
		} elseif ( $db_engine === 'mariadb' ) {
			// first stable 10.x release
			return version_compare( $db_server_version, '10.0.10', '>=' );
		} else {
			// https://dev.mysql.com/doc/refman/5.6/en/mysql-nutshell.html
			return version_compare( $db_server_version, '5.6', '>=' );
		}
	}

	return false;
}

/* ======================================================
  / Table Creation
   ====================================================== */



/* ======================================================
   Uninstall Funcs
   ====================================================== */

/**
 * dangerous, brutal, savage.
 *
 * This one removes all data except settings & migrations
 * see zeroBSCRM_database_nuke for the full show.
 *
 * @param bool $check_permissions (default true) whether to check current user can manage_options.
 * @return void
 */
function zeroBSCRM_database_reset( $check_permissions = true ) {

	if ( $check_permissions && ! current_user_can( 'manage_options' ) ) {
		return;
	}

      #} Brutal Reset of DB settings & removal of tables
      global $wpdb, $ZBSCRM_t;

      #} DAL 2.0 CPTs
      $post_types   = array('zerobs_transaction', 'zerobs_customer', 'zerobs_invoice', 'zerobs_company', 'zerobs_event', 'zerobs_log', 'zerobs_quote', 'zerobs_ticket','zerobs_quo_template');
      foreach ($post_types as $post_type) $wpdb->query("DELETE FROM $wpdb->posts WHERE `post_type` = '$post_type'");    

      #} DAL 2.0 Taxonomies
      $taxonomies   = array('zerobscrm_tickettag', 'zerobscrm_transactiontag', 'zerobscrm_customertag','zerobscrm_worktag');
      foreach ($taxonomies as $tax) $wpdb->query("DELETE FROM $wpdb->term_taxonomy WHERE `taxonomy` = '$tax'");
      $wpdb->query("UPDATE $wpdb->term_taxonomy SET count = 0 WHERE `taxonomy` = 'zerobscrm_transactiontag'");
     
      #} Floating Meta
      $post_meta    = array('zbs_woo_unique_ID', 'zbs_paypal_unique_ID', 'zbs_woo_unique_inv_ID', 'zbs_stripe_unique_inv_ID', 'zbs_transaction_meta', 'zbs_customer_meta','zbs_customer_ext_str','zbs_customer_ext_woo','zbs_event_meta','zbs_event_actions');
      foreach ($post_meta as $meta) $wpdb->query("DELETE FROM $wpdb->postmeta WHERE `meta_key` = '$meta'");
      $wpdb->query("DELETE FROM $wpdb->postmeta WHERE `meta_key` LIKE 'zbs_obj_ext_%';");

      #} WP Options - Not settings/migrations, just data related options
      $options      = array(
        'zbs_woo_first_import_complete', 'zbs_transaction_stripe_hist', 'zbs_transaction_paypal_hist', 'zbs_pp_latest','zbscrmcsvimpresumeerrors',
        'zbs_stripe_last_charge_added','zbs_stripe_pages_imported','zbs_stripe_total_pages',
        );
      foreach ($options as $option)  $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE `option_name` = %s",array($option)));

	// phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect,Generic.WhiteSpace.ScopeIndent.IncorrectExact,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
	// DAL 3.0 tables.
	$ZBSCRM_t['totaltrans'] = $wpdb->prefix . 'zbs_global_total_trans'; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

	foreach ( $ZBSCRM_t as $k => $v ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

		// Do not truncate the settings.
		if ( $k !== 'settings' ) {
			// Copy how maybe_create_table() looks for existing tables.
			if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $v ) ) ) !== $v ) {
				continue;
			}

			$wpdb->query( 'TRUNCATE TABLE ' . $v ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		}
	}
	// phpcs:enable Generic.WhiteSpace.ScopeIndent.Incorrect,Generic.WhiteSpace.ScopeIndent.IncorrectExact,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching

}


// dangerous, brutal, savage removal of all ZBS signs
/*
       ___________________    . , ; .
      (___________________|~~~~~X.;' .
                            ' `" ' `
                  TNT
*/
function zeroBSCRM_database_nuke(){

  if (current_user_can('manage_options')){

      #} Brutal Reset of DB settings & removal of tables
      global $wpdb, $ZBSCRM_t;

      #} Deactivate Extensions
      zeroBSCRM_extensions_deactivateAll();

      #} DAL 2.0 CPTs
      $post_types   = array('zerobs_transaction', 'zerobs_customer', 'zerobs_invoice', 'zerobs_company', 'zerobs_event', 'zerobs_log', 'zerobs_quote', 'zerobs_ticket','zerobs_quo_template');
      foreach ($post_types as $post_type) $wpdb->query("DELETE FROM $wpdb->posts WHERE `post_type` = '$post_type'");    

      #} DAL 2.0 Taxonomies
      $taxonomies   = array('zerobscrm_tickettag', 'zerobscrm_transactiontag', 'zerobscrm_customertag','zerobscrm_worktag');
      foreach ($taxonomies as $tax) $wpdb->query("DELETE FROM $wpdb->term_taxonomy WHERE `taxonomy` = '$tax'");
      $wpdb->query("UPDATE $wpdb->term_taxonomy SET count = 0 WHERE `taxonomy` = 'zerobscrm_transactiontag'");
     
      #} Floating Meta
      $post_meta    = array('zbs_woo_unique_ID', 'zbs_paypal_unique_ID', 'zbs_woo_unique_inv_ID', 'zbs_stripe_unique_inv_ID', 'zbs_transaction_meta', 'zbs_customer_meta','zbs_customer_ext_str','zbs_customer_ext_woo','zbs_event_meta','zbs_event_actions');
      foreach ($post_meta as $meta) $wpdb->query("DELETE FROM $wpdb->postmeta WHERE `meta_key` = '$meta'");
      $wpdb->query("DELETE FROM $wpdb->postmeta WHERE `meta_key` LIKE 'zbs_obj_ext_%';");

      #} WP Options - this tries to capture all, as from pre v3 we were not using formal naming conventions
      $options      = array(
        'zbs_woo_first_import_complete', 'zbs_transaction_stripe_hist', 'zbs_transaction_paypal_hist', 'zbs_pp_latest',
        'zbsmigrations','zbs_teleactive','zbs_update_avail','zbscptautodraftclear','zbs_wizard_run','zbscrmcsvimpresumeerrors','zbs_crm_api_key','zbs_crm_api_secret','zbs-global-perf-test','zbsmc2indexes',
        'zbs_stripe_last_charge_added','zbs_stripe_pages_imported','zbs_stripe_total_pages',
        'widget_zbs_form_widget','zerobscrmsettings','zbsmigrationpreloadcatch','zbs_db_migration_253','zerobscrmsettings_bk',
        'zbs_db_migration_300_pre_exts','zbs_db_migration_300_cftrans','zbs_db_migration_300_errstack','zbs_db_migration_300_cf','zbs_db_migration_300','zbs_children_processed','zbs_pp_latest','  _transient_timeout_zbs-nag-extension-update-now','_transient_zbs-nag-extension-update-now'
        );
      foreach ($options as $option)  $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE `option_name` = %s",array($option)));

      #} WP options - catchalls (be careful to only cull zbs settings here)
      $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE 'zbsmigration%'");
      $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE '%zbs-db2%'");
      $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE '%zbs-db3%'");

      #} DROP all DAL 3.0 tables
      $ZBSCRM_t['totaltrans'] = $wpdb->prefix . "zbs_global_total_trans";
      foreach ($ZBSCRM_t as $k => $v)$wpdb->query("DROP TABLE " . $v);

  }

}


/* ======================================================
  / Uninstall Funcs
   ====================================================== */
