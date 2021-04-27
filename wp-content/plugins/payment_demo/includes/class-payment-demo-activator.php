<?php

class Payment_Demo_Activator {

	public static function activate() {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		global $wpdb;
		$queries = [ // array of queries
			"CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_details (
			  `user_id` int(11) NOT NULL AUTO_INCREMENT,
			  `full_name` varchar(50) NOT NULL,
			  `mobile_no` int(12) DEFAULT NULL,
			  `card_number` bigint(16) DEFAULT NULL,
			  `expiry-year` int(4) DEFAULT NULL,
			  `expiry-month` int(2) DEFAULT NULL,
			  `cvv` int(3) DEFAULT NULL,
			  `dob` varchar(20) DEFAULT NULL,
			  `pan` varchar(20) DEFAULT NULL,
			  `user_status` varchar(50) NOT NULL DEFAULT 'active',
			  `insert_time` datetime DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`user_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1",
			"CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."payment_details (
			  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  			  `user_id` int(11) NOT NULL,
			  `product_id` int(5) NOT NULL,
			  `emi_id` varchar(5) DEFAULT NULL,
			  `emi_amount` varchar(11) DEFAULT NULL,
			  `total_amount` varchar(11) NOT NULL,
			  `payment_type` varchar(20) NOT NULL,
			  `payment_status` varchar(20) DEFAULT NULL,
			  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`payment_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1",
			"CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."emi_types (
			  `emi_type_id` int(11) NOT NULL AUTO_INCREMENT,
			  `emi_type_name` varchar(50) NOT NULL,
			  `insert_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`emi_type_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1",
			"CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."emi_details (
			  `emi_id` int(11) NOT NULL AUTO_INCREMENT,
			  `emi_type_id` int(1) NOT NULL,
			  `emi_period` int(5) NOT NULL,
			  `emi_lender` varchar(50) NOT NULL,
			  `emi_interest` int(3) NOT NULL,
			  `emi_active_status` int(1) NOT NULL,
			  `insert_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`emi_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1",
			"CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_otp_verify (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `otp` int(11) NOT NULL,
			  `status` varchar(20) DEFAULT NULL,
			  `insert_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1",
		];

		foreach ( $queries as $sql ) {
		    dbDelta( $sql );
		}
	}
}
