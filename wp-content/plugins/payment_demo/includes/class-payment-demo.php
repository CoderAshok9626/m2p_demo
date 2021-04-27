<?php

class Payment_Demo {

	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {
		if ( defined( 'PAYMENT_DEMO_VERSION' ) ) {
			$this->version = PAYMENT_DEMO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'payment-demo';

		$this->load_dependencies();
		//$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-payment-demo-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-payment-demo-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-payment-demo-public.php';

		$this->loader = new Payment_Demo_Loader();

	}

	private function define_admin_hooks() {

		$plugin_admin = new Payment_Demo_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'payment_demo_menu' );

	}

	private function define_public_hooks() {

		$plugin_public = new Payment_Demo_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
