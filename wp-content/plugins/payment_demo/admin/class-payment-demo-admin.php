<?php

class Payment_Demo_Admin {

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/payment-demo-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pd-bootstrap-css', plugin_dir_url( __FILE__ ) . 'bootstrap/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pd-style-css', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/payment-demo-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'pd-jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pd-bootstrap-js', plugin_dir_url( __FILE__ ) . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pd-migrate-js', plugin_dir_url( __FILE__ ) . 'js/jquery-migrate.min.js', array( 'jquery' ), $this->version, true );

	}

	public function payment_demo_menu() {
		add_menu_page('Payment Demo', 'Payment Demo', 'manage_options', 'payment-demo', array($this,"payment_demo_dashboard"));

	}
	public function payment_demo_dashboard() {
		global $wpdb;
		$user_details = $wpdb->get_results ( "SELECT * FROM `m2p_user_details` u JOIN m2p_payment_details p ON u.user_id = p.user_id INNER JOIN m2p_user_otp_verify otp ON otp.user_id = u.user_id LEFT JOIN m2p_emi_details emi ON emi.emi_id = p.emi_id LEFT JOIN m2p_emi_types emt ON emt.emi_type_id = emi.emi_type_id");
		$content = '<div class="wrap"><h1>Payment Demo</h1>';
		$content .= '<table class="form-table" role="presentation"><tbody><tr><th scope="row"><label for="blogname">ShortCode</td><td><input type="text" class="regular-text" value="[payment_demo_process]" readonly></td></tr></tbody></table>';
		$content .= "Copy the ShortCode and Place it on a page to view the payment demo<br/><br/>";
		if(isset($user_details)) {
		$content .= '<h1>Payment Details Log</h1>><table class="wp-list-table widefat striped"> <thead> <tr> <th width="5%">No.</th> <th width="25%">User Details</th> <th width="25%">Product Details</th> <th width="25%">Payment Details</th> <th width="20%">EMI Details</th> </tr> </thead> <tbody>'; 
		foreach($user_details as $k=>$detail) {$k++;
        	$content .= '<tr> <td>'.$k.'</td> <td> <table class="form-table form-table1" role="presentation"> <tbody> <tr> <td width="40%">Full Name</td> <td>'.$detail->full_name.'</td> </tr> <tr> <td width="40%">Mobile Number</td> <td>'.$detail->mobile_no.'</td> </tr> <tr> <td width="40%">DOB</td> <td>'.$detail->dob.'</td> </tr> <tr> <td width="40%">PAN</td> <td>'.$detail->pan.'</td> </tr> </tbody> </table> </td> <td> <table class="form-table form-table1" role="presentation"> <tbody> <tr> <td width="40%">Name</td> <td>Laptop</td> </tr> <tr> <td width="40%">Category</td> <td>Electronics</td> </tr> <tr> <td width="40%">Price</td> <td>50000</td> </tr> <tr> <td width="40%">Vendor</td> <td>Electronics Store</td> </tr> </tbody> </table> </td> <td> <table class="form-table form-table1" role="presentation"> <tbody> <tr> <td width="40%">Payment Date</td> <td>'.$detail->payment_date.'</td> </tr> <tr> <td width="40%">Payment Mode</td> <td>'.strtoupper($detail->payment_type).'</td> </tr> <tr> <td width="40%">Status</td> <td>'.ucfirst($detail->payment_status).'</td> </tr> <tr> <td width="40%">Total Amount</td> <td>'.$detail->total_amount.'</td> </tr> </tbody> </table> </td> <td> <table class="form-table form-table1" role="presentation"> <tbody> <tr> <td width="40%">EMI Type</td> <td>'.$detail->emi_type_name.'</td> </tr> <tr> <td width="40%">EMI Period</td> <td>'.$detail->emi_period.'</td> </tr> <tr> <td width="40%">EMI Interest</td> <td>'.$detail->emi_interest.'%</td> </tr> <tr> <td width="40%">EMI Lender</td> <td>'.$detail->emi_lender.'</td> </tr> <tr> <td width="40%">EMI Amount </td> <td>'.$detail->emi_amount.'/mo.</td> </tr> </tbody> </table> </td> </tr>'; }
        $content .= '</tbody> </table> </div>'; 
    	}
        echo $content;

	}
}
