<?php
/*
Plugin Name: Saisie Auteurs
Plugin URI: https://www.monpluginyoutubetropdestyle.fr/
Description: Ceci est mon premier plugin
Author: Chris SIMON
Version: 1.0
Author URI: http://mon-siteweb.com/
Text Domain: my-basics-plugin
Domain Path: /languages
*/

add_action('init','auteur_init_shortcode');

function auteur_init_shortcode()
{
    add_shortcode('auteurs','auteur_do_shortcode');
}

function auteur_do_shortcode($attrs)
{
    if(isset($attrs['auteur'])){
        $output = sprintf('<label for="name">Auteurs supplémentaires</label>
                      <input type="text" id="autor" name="autor" value="%s">',$attrs['auteur']);
        return $output;
    }
    else if(isset($attrs['post']) AND !isset($attrs['auteur'])){
        $post = get_post($attrs['post']);
        $auth_id = $post->post_author;
        $output = sprintf('<label for="name">Auteurs supplémentaires</label>
        <input type="text" id="autor" name="autor" value="%s">',$attrs['post']);;
        return $output;

    }
    
}

//[auteurs auteur="Wolfgang Amadeus Mozart"]
//[auteurs post=17]

?>


