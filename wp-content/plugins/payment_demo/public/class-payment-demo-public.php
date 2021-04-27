<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Payment_Demo
 * @subpackage Payment_Demo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Payment_Demo
 * @subpackage Payment_Demo/public
 * @author     Ashok <ashok9626@gmail.com>
 */
class Payment_Demo_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {
		wp_enqueue_style( 'pd-bootstrap-css', plugin_dir_url( __FILE__ ) . 'bootstrap/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pd-style-css', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'pd-font-awesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );
		//wp_enqueue_style( 'pd-poppins','https://fonts.googleapis.com/css2?family=Poppins&display=swap', array(), $this->version, 'all' );
		wp_enqueue_style( 'pd-datepicker',plugin_dir_url( __FILE__ ) . 'datepicker/css/bootstrap-datepicker3.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'pd-jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pd-bootstrap-js', plugin_dir_url( __FILE__ ) . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pd-migrate-js', plugin_dir_url( __FILE__ ) . 'js/jquery-migrate.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pd-main-js', plugin_dir_url( __FILE__ ) . 'js/main.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pd-datepicker-js', plugin_dir_url( __FILE__ ) . 'datepicker/js/bootstrap-datepicker.min.js', array( 'jquery' ), $this->version, true );
	}

}
