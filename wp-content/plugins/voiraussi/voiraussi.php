<?php
/*
Plugin Name: Voir Aussi
Plugin URI: https://www.monpluginyoutubetropdestyle.fr/
Description: Ceci est mon premier plugin
Author: Chris SIMON
Version: 1.0
Author URI: http://mon-siteweb.com/
Text Domain: my-basics-plugin
Domain Path: /languages
*/

add_action('init','voiraussi_init_shortcode');

function voiraussi_init_shortcode()
{
    add_shortcode('voiraussi','voiraussi_do_shortcode');
}

function voiraussi_do_shortcode($attrs)
{
    if(isset($attrs['id'])){
        $link = get_permalink($attrs['id']);
        $title = get_the_title($attrs['id']);      
        $output = sprintf('<a href=%s>Voir aussi : %s</a>',$link, $title);
        return $output;
    }    
}

?>


