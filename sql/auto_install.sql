DROP TABLE IF EXISTS `civicrm_membership_period`;

-- /*******************************************************
-- *
-- * civicrm_membership_period
-- *
-- * FIXME
-- *
-- *******************************************************/
CREATE TABLE `civicrm_membership_period` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique MembershipPeriod ID',
     `contact_id` int unsigned    COMMENT 'FK to Contact',
     `contribution_id` int unsigned    COMMENT 'FK to Contribution',
     `start_date` date    COMMENT 'Date of start member period',
     `end_date` date    COMMENT 'Date end member period' 
,
        PRIMARY KEY (`id`)
 
 
,          CONSTRAINT FK_civicrm_membership_period_contact_id FOREIGN KEY (`contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE,          CONSTRAINT FK_civicrm_membership_period_contribution_id FOREIGN KEY (`contribution_id`) REFERENCES `civicrm_contribution`(`id`) ON DELETE CASCADE  
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;

  
