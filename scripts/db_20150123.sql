
-- Update the vacancy status to reflect the approval chain steps
-- ----------------------------------------------------------------

ALTER TABLE `vacancy` CHANGE `status` `status` ENUM( 'saved', 'verified', 'published', 'archived' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'saved';







-- Approval Chain DB tables
-- ----------------------------------------------------------------

CREATE TABLE approval_chain (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  chain_type varchar(100) NOT NULL,
  step_number varchar(10) NOT NULL,
  subject_id varchar(100) NOT NULL,
  originator_id varchar(100) NOT NULL,
  approver_id varchar(500) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  date_created datetime NOT NULL,
  last_updated datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE approval_chain_scope (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  approver varchar(100) NOT NULL,
  scope varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO approval_chain_scope (id, approver, scope) VALUES
(1, 'applicant', ''),
(2, 'teacher', 'self'),
(3, 'data', 'self'),
(4, 'manager', 'institution'),
(5, 'cao', 'county'),
(6, 'deo', 'district'),
(7, 'dsc', 'district'),
(8, 'mops', 'country'),
(9, 'moes', 'country'),
(10, 'psc', 'country'),
(11, 'hr', 'country'),
(12, 'tiet', 'country'),
(13, 'admin', 'system');



CREATE TABLE approval_chain_setting (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  chain_type varchar(100) NOT NULL,
  step_number int(11) NOT NULL,
  originators varchar(300) NOT NULL,
  approvers varchar(300) NOT NULL,
  step_actions varchar(500) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO approval_chain_setting (id, chain_type, step_number, originators, approvers, step_actions) VALUES
(1, 'vacancy', 1, '', 'admin,moes,deo', 'notify_next_chain_party'),
(2, 'vacancy', 2, 'admin,moes,deo', 'mops', 'notify_previous_and_next_chain_parties'),
(3, 'vacancy', 3, 'mops', 'admin,esc', 'publish_job_notice,notify_previous_chain_parties'),
(4, 'confirmation', 1, '', 'teacher', 'notify_next_chain_party'),
(5, 'confirmation', 2, 'teacher', 'moes,cao', 'issue_confirmation_letter,notify_previous_and_next_chain_parties'),
(6, 'confirmation', 3, 'moes,cao', 'esc,dsc', 'notify_previous_chain_parties'),
(7, 'registration', 1, '', 'admin,data,hr,teacher', 'notify_next_chain_party'),
(8, 'registration', 2, 'admin,data,hr,teacher', 'hr', 'issue_file_number,notify_previous_and_next_chain_parties'),
(9, 'registration', 3, 'hr', 'tiet', 'issue_registration_certificate,notify_previous_chain_parties'),
(10, 'transfer', 1, '', 'teacher,manager', 'notify_next_chain_party'),
(11, 'transfer', 2, 'teacher,manager', 'manager', 'notify_previous_and_next_chain_parties'),
(12, 'transfer', 3, 'manager', 'moes,cao', 'issue_transfer_letter,notify_previous_and_next_chain_parties'),
(13, 'transfer', 4, 'moes,cao', 'manager', 'submit_transfer_pca,notify_previous_and_next_chain_parties'),
(14, 'transfer', 5, 'manager', 'psc', 'confirm_transfer,notify_previous_chain_parties'),
(15, 'leave', 1, '', 'teacher,manager', 'notify_next_chain_party'),
(16, 'leave', 2, 'teacher,manager', 'moes,cao', 'notify_previous_and_next_chain_parties'),
(17, 'leave', 3, 'moes,cao', 'esc,dsc', 'notify_previous_and_next_chain_parties'),
(18, 'leave', 4, 'esc,dsc', 'moes,cao', 'send_verification_letter,notify_previous_chain_parties'),
(19, 'retirement', 1, '', 'teacher,manager', 'notify_next_chain_party'),
(20, 'retirement', 2, 'teacher,manager', 'manager', 'confirm_retirement,notify_previous_chain_parties'),
(21, 'secrecy', 1, '', 'teacher', 'notify_next_chain_party'),
(22, 'secrecy', 2, 'teacher', 'admin,esc,dsc', 'apply_data_secrecy,notify_previous_chain_parties'),
(23, 'data', 1, '', 'admin,data', 'notify_next_chain_party'),
(24, 'data', 2, 'admin,data', 'admin', 'activate_data_records,notify_previous_chain_parties'),
(25, 'recommendation', 1, '', 'manager', 'notify_next_chain_party'),
(26, 'recommendation', 2, 'manager', 'esc,dsc', 'notify_previous_chain_parties'),
(27, 'census', 1, '', 'manager', 'notify_next_chain_party'),
(28, 'census', 2, 'manager', 'moes,cao', 'notify_previous_chain_parties');




ALTER TABLE `approval_chain` ADD `actual_approver` VARCHAR( 100 ) NOT NULL AFTER `approver_id` ;
ALTER TABLE `approval_chain` ADD `comment` VARCHAR( 500 ) NOT NULL AFTER `status` ;


ALTER TABLE `person` ADD `is_visible` ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'Y' AFTER `citizenship_type` ;


ALTER TABLE `message_exchange` CHANGE `category` `subject` VARCHAR( 300 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE `sender_id` `sender` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;



--
-- Table structure for table 'carrier'
--

DROP TABLE IF EXISTS carrier;
CREATE TABLE carrier (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  displayed_name varchar(300) NOT NULL,
  country_code varchar(10) NOT NULL,
  sms_email_domain varchar(300) NOT NULL,
  mms_email_domain varchar(300) NOT NULL,
  number_stubs text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'carrier'
--

INSERT INTO carrier (id, name, displayed_name, country_code, sms_email_domain, mms_email_domain, number_stubs) VALUES
(1, 'mtn', 'MTN Uganda', '256', 'mtn.co.ug', 'mtn.co.ug', '0772,0784,0774'),
(2, 'airtel', 'Airtel Uganda', '256', '', '', ''),
(3, 'utl', 'Uganda Telecom', '256', '', '', ''),
(4, 'africell', 'Africell Telecom', '256', '', '', ''),
(5, 'smile', 'Smile Telecom', '256', '', '', ''),
(6, 'sure', 'Sure Telecom', '256', '', '', ''),
(7, 'k2', 'K2 Telecom', '256', '', '', ''),
(8, 'smart', 'Smart Telecom Uganda', '256', '', '', ''),
(9, 'vodafone', 'Vodafone Uganda', '256', '', '', '');


UPDATE `permission` SET `url` = 'user/add' WHERE `permission`.`id` =59;

ALTER TABLE `person` ADD `signature` VARCHAR( 300 ) NOT NULL AFTER `is_visible` ;

ALTER TABLE `user` CHANGE `status` `status` ENUM( 'pending', 'completed', 'active', 'inactive', 'blocked' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'pending';








-- Remember to include 'message' and 'query' tables in script







