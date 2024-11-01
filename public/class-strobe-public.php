<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Strobe
 * @subpackage Strobe/public
 */
class Strobe_Public {

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
     * @var string error template file name
     */
    private $error_template;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function init( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->error_template = plugin_dir_path( dirname( __FILE__ ) ).'public/partials/strobe-public-error.php';
	}

	public static function Instance(){
	    static $instance = null;
        if(is_null($instance)){
            $instance = new Strobe_Public();
        }
        return $instance;
    }

    private function __construct(){
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

        global $post;
        if(has_shortcode( $post->post_content, 'strobe_event_list')){
            wp_enqueue_style( $this->plugin_name . "-events", plugin_dir_url( __FILE__ ) . 'css/strobe-events.css', array(), $this->version, 'all' );
            wp_enqueue_style( $this->plugin_name . "-venobox", plugin_dir_url( __FILE__ ) . 'css/venobox.css', array(), $this->version, 'all' );
        }

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

        global $post;
        if(has_shortcode( $post->post_content, 'strobe_event_list')){
            wp_enqueue_script( $this->plugin_name . "-events", plugin_dir_url( __FILE__ ) . 'js/strobe-events.js', array('jquery'), $this->version, false );
            wp_enqueue_script( $this->plugin_name . "-venobox", plugin_dir_url( __FILE__ ) . 'js/venobox.min.js', array('jquery'), $this->version, true );
        }

	}

    public function show_error($error) {
        //handle $error in template
        include($this->error_template);
    }

}
