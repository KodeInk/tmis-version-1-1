
CREATE TABLE IF NOT EXISTS census (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  teacher_id varchar(100) NOT NULL,
  start_date date NOT NULL,
  end_date date NOT NULL,
  weekly_workload_average varchar(100) NOT NULL,
  status enum('pending','active','inactive') NOT NULL DEFAULT 'pending',
  added_by varchar(100) NOT NULL,
  date_added datetime NOT NULL,
  last_updated_by varchar(100) NOT NULL,
  last_updated datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS census_responsibility (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  census_id varchar(100) NOT NULL,
  responsibility_id varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS census_training (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  census_id varchar(100) NOT NULL,
  training_id varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS responsibility (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  code varchar(100) NOT NULL,
  notes varchar(500) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS training (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  code varchar(100) NOT NULL,
  notes varchar(500) NOT NULL,
  type enum('physical','educational') NOT NULL DEFAULT 'educational',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



ALTER TABLE contact ADD is_primary ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'Y' AFTER date_added ;
ALTER TABLE address CHANGE is_primary is_primary ENUM( 'Y', 'N' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y';



ALTER TABLE message_exchange ADD attachment VARCHAR( 500 ) NOT NULL AFTER subject ;
ALTER TABLE message_status ADD UNIQUE INDEX unique_status (message_exchange_id, user_id, status);



ALTER TABLE user ADD teacher_status ENUM( 'unknown', 'pending', 'completed', 'approved', 'active', 'archived' ) NOT NULL DEFAULT 'unknown' AFTER status ;


ALTER TABLE person ADD marital_status ENUM( 'married', 'single', 'unknown' ) NOT NULL DEFAULT 'unknown' AFTER gender ;

ALTER TABLE academic_history ADD institution_type VARCHAR( 100 ) NOT NULL AFTER institution ;

ALTER TABLE grade CHANGE notes number VARCHAR( 10 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;

ALTER TABLE `person` ADD `file_number` VARCHAR( 200 ) NOT NULL AFTER `citizenship_type` ;







-- Remember to include the following tables: permission, query, message

















