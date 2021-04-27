<?php

class Payment_Demo_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'payment-demo',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
