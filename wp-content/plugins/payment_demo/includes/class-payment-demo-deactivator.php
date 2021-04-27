<?php

class Payment_Demo_Deactivator {

	public static function deactivate() {
		global $wpdb;
		$tables = [   
			$wpdb->prefix . "payment_details",
			$wpdb->prefix . "user_details",
			$wpdb->prefix . "emi_types",
			$wpdb->prefix . "emi_details",
			$wpdb->prefix . "user_otp_verify",
       	];

      	foreach ($tables as $tablename) {
         	$wpdb->query("DROP TABLE IF EXISTS $tablename");
      	}
	}

}
