<?php

/**
 * Interface for Strobe shortcodes
 */
interface Strobe_Shortcode{


    /**
     * @return string name of shortcode
     */
    public function getName();


    /**
     * Shortcode entry point
     *
     * @param array $atts shortcode attributes
     * @param null $content
     * @return mixed
     */
    public function process($atts = [], $content = null);
}