<?php

/**
 * Loads all strobe shortcodes from 'includes' folder.
 * Shortcode php file name should start with 'class-strobe-shortcode-'.
 * Shortcode class should be in snake case without 'class-' prefix and implement Strobe_Shortcode interface.
 * e.g. Shortcode in file 'class-strobe-shortcode-foo-bar.php' should contain class with name 'Strobe_Shortcode_Foo_Bar'
 *
 * @package    Strobe
 * @subpackage Strobe/includes
 */
class Strobe_Shortcodes_Loader {

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

    private $shortcodes = array();

	private function __construct() {
	}

	public static function Instance(){
	    static $instance = null;
        if($instance === null){
            $instance = new Strobe_Shortcodes_Loader();
        }
        return $instance;
    }

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
	public function init( $plugin_name, $version ){
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->load_dependencies();
    }
	
	private function load_dependencies(){
        foreach (glob(plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-strobe-shortcode-*.php') as $file) {
            require_once $file;
            $class_name = preg_replace("/^class-/", "", basename($file, ".php"), 1);
            $class_name = ucwords(str_replace("-", "_", $class_name), "_");
            if(class_exists($class_name) && in_array('Strobe_Shortcode', class_implements($class_name))){
                $rClass = new ReflectionClass($class_name);
                array_push($this->shortcodes, $rClass->newInstance($this->plugin_name, $this->version));
            }
        }
	}

	/**
	 * Initialize all shortcodes
	 */
	public function add_shortcodes(){
	    foreach($this->shortcodes as $sc){
            add_shortcode($sc->getName(), array( $sc, 'process' ) );
        }
	}

	public function get_shortcode($name){
	    foreach($this->shortcodes as $sc){
	        if($name === $sc->getName()){
	            return $sc;
            }
        }
    }

}
