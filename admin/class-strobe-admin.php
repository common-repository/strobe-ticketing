<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.strobelabs.com
 * @since      1.0.0
 *
 * @package    Strobe
 * @subpackage Strobe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Strobe
 * @subpackage Strobe/admin
 * @author     Strobe Labs
 */
class Strobe_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;


	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'strobe';

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_filter( 'plugin_action_links', array($this,$this->option_name . '_add_action_plugin'), 10, 5 );
	}



  public function strobe_add_action_plugin( $actions, $plugin_file ) {

		if ('strobe/strobe.php' == $plugin_file) {
			$settings = array('settings' => '<a href="'.admin_url( 'options-general.php?page=strobe' ).'">' . __('Settings', 'General') . '</a>');
			$actions = array_merge($settings, $actions);
		}

		return $actions;
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Strobe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Strobe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/strobe-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/strobe-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Strobe Settings', 'strobe' ),
			__( 'Strobe', 'strobe' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}


	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/strobe-admin-display.php';
	}


	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		add_settings_section($this->option_name . '_general',	__( 'General', 'strobe' ),	array( $this, $this->option_name . '_general_label' ),	$this->plugin_name);

		add_settings_field(
			$this->option_name . '_org_token',
			__( 'Access Token', 'strobe' ),
			array( $this, $this->option_name . '_org_token_input' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_org_token' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_org_token' );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function strobe_general_label() {
		echo '<div>
			<p>' . __( 'A widget access token is required in order to display your events. You can find one in your ', 'strobe')
			. '<a href="//dashboard.strobelabs.com/org#ticketing" title="Strobe Org Settings">' . __('org settings', 'strobe') . '</a>'
			. __(' on the Strobe Dashboard. If you have any questions, please contact support.', 'strobe') . '</p>';
	}


	/**
	 * Render the org token input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function strobe_org_token_input() {
		$org_id = get_option( $this->option_name . '_org_token' );
		echo '<input type="text" name="' . $this->option_name . '_org_token' . '" id="' . $this->option_name . '_org_token' . '" value="' . $org_id . '"> ';
	}

}
