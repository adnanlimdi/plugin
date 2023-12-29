<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://techtic.com/
 * @since      1.0.0
 *
 * @package    Tax_calculator
 * @subpackage Tax_calculator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tax_calculator
 * @subpackage Tax_calculator/includes
 * @author     Techtic <techtic.adnan@gmail.com>
 */
class Tax_calculator {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tax_calculator_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TAX_CALCULATOR_VERSION' ) ) {
			$this->version = TAX_CALCULATOR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'tax_calculator';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tax_calculator_Loader. Orchestrates the hooks of the plugin.
	 * - Tax_calculator_i18n. Defines internationalization functionality.
	 * - Tax_calculator_Admin. Defines all hooks for the admin area.
	 * - Tax_calculator_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tax_calculator-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tax_calculator-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tax_calculator-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tax_calculator-public.php';

		$this->loader = new Tax_calculator_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tax_calculator_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tax_calculator_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Tax_calculator_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	    $this->loader->add_action( 'admin_menu', $plugin_admin, 'tc_booikng_menu_pages' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'tc_booking_register_settings' );

		$this->loader->add_filter( 'plugin_action_links_tax_calculator/tax_calculator.php', $plugin_admin, 'tc_add_link_to_settings', 9, 2 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Tax_calculator_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'tc_add_all_shortcode' );
	    $this->loader->add_action('wp_ajax_get_select_address_dropdown',$plugin_public, 'tc_select_dropdown');
	    $this->loader->add_action('wp_ajax_nopriv_get_select_address_dropdown',$plugin_public, 'tc_select_dropdown');
	    //Third steps ajax functions call.
	    $this->loader->add_action('wp_ajax_get_select_third_steps',$plugin_public, 'tc_third_steps_html');
	    $this->loader->add_action('wp_ajax_nopriv_get_select_third_steps',$plugin_public, 'tc_third_steps_html');
	    // Backe To second Step Ajax call
	    $this->loader->add_action('wp_ajax_back_to_second_steps_html',$plugin_public, 'tc_back_to_second_step_html');
	    $this->loader->add_action('wp_ajax_nopriv_back_to_second_steps_html',$plugin_public, 'tc_back_to_second_step_html');
	    
	    //forth steps ajax functions call.
	    $this->loader->add_action('wp_ajax_get_select_forth_steps',$plugin_public, 'tc_forth_step_html');
	    $this->loader->add_action('wp_ajax_nopriv_get_select_forth_steps',$plugin_public, 'tc_forth_step_html');

	    // Back To third step Ajax call.
   		$this->loader->add_action('wp_ajax_back_to_third_steps_html',$plugin_public, 'tc_back_to_third_steps_html');
	    $this->loader->add_action('wp_ajax_nopriv_back_to_third_steps_html',$plugin_public, 'tc_back_to_third_steps_html');

	    //wp_head actions 
	    $this->loader->add_action('wp_head',$plugin_public, 'wcpf_dev_process_complete',10);

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tax_calculator_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
