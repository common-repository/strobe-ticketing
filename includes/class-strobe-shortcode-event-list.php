<?php

/**
 * Event list shortcode
 *
 * @link       https://www.strobelabs.com
 * @since      1.0.0
 *
 * @package    Strobe
 * @subpackage Strobe/includes
 */
class Strobe_Shortcode_Event_List implements Strobe_Shortcode{

    private $plugin_name;
    private $version;

  private $api;
  private $events_template;

  public function __construct($plugin_name, $version){
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-strobe-ticketing-api.php';
    $this->api = new Strobe_Ticketing_Api($plugin_name, $version);
    $this->events_template = plugin_dir_path( dirname( __FILE__ ) ).'public/partials/strobe-public-events.php';
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action($this->getName(), array($this, 'show_events'));
  }


  public function process($attrs = [], $content = null){
        $attrs = shortcode_atts( array(
            'time_format' => "M d, h:ia"
        ), $attrs );

      try{
            ob_start();
            $org = $this->api->get_org_info();
            $sales = $this->api->get_sales();
            do_action($this->getName(), array(
                'attrs' => $attrs,
                'sales' => $sales,
                'org' => $org));
        }catch(Exception $error){
            do_action($this->plugin_name . "_error", $error);
        }

        return ob_get_clean();
  }

  public function show_events($arg){
      $sales = $arg['sales'];
        $org = $arg['org'];
        $attrs = $arg['attrs'];

        //handle sales org and attrs in template
        include($this->events_template);
    }

  public function getName(){
      return $this->plugin_name . "_event_list";
    }
}
