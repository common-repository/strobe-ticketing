<?php

/**
 * Ticketing api
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Strobe
 * @subpackage Strobe/includes
 */
class Strobe_Ticketing_Api {

  const IS_PRODUCTION = true;

  const API_URL_DEV = "https://staging.api.ticketing.strobelabs.com/v1";

  const API_URL_PROD = "https://api.ticketing.strobelabs.com/v1";

  private $plugin_name;
  private $version;

  private $base_url;
  private $app_key;
  private $org_token;

  public function __construct($plugin_name, $version){
    $this->plugin_name = $plugin_name;
    $this->version = $version;

    $this->org_token = get_option($this->plugin_name . '_org_token');

    if (self::IS_PRODUCTION){
      $this->base_url = self::API_URL_PROD;
    }
    else{
      $this->base_url = self::API_URL_DEV;
    }
  }

  public function get_sales(){
    return $this->ticketing_request("/sales");
  }

  public function get_org_info(){
    $results = $this->ticketing_request("/orgs");
    if (isset($results->id)){
      return $results;
    }
    return null;
  }

  private function ticketing_request($endpoint, $params = [], $args = []){
    $url = $this->base_url . $endpoint;
    $params = array_merge($params, ['widget_token'=>$this->org_token]);

    if (!isset($args['method']) or $args['method'] == 'GET'){
      $url .= '?' . http_build_query($params);
    }
    else{
      $args['body'] = $params;
    }

    $response = wp_remote_request($url, $args);

    if (is_wp_error($response)){
      throw new Exception($response->get_error_message(), 500);
    }
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code != 200){
      throw new Exception(wp_remote_retrieve_response_message($response), $response_code);
    }
    $body = json_decode(wp_remote_retrieve_body($response));
    if (isset($body->response->error)){
      throw new Exception($body->response->error->error_message, $body->response->error->status);
    }
    return $body->response->results;
  }

}
