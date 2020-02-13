<?php
//require_once('include/myFunctions.php');

function register_navwalker(){
    require_once get_template_directory() . '/include/class-wp-bootstrap-navwalker.php';
}

add_action( 'after_setup_theme', 'register_navwalker' );

function valid_bootstrap_enqueue() {
  wp_enqueue_style( 'valid_bootstrapmin', get_template_directory_uri() . '/css/bootstrap.min.css' );
  wp_enqueue_style( 'valid_styles', get_template_directory_uri() . '/css/styles.min.css' );
}

// ACTIONS
add_action('wp_enqueue_scripts', 'valid_bootstrap_enqueue');

//
//add_theme_support( 'title-tag' );
//add_theme_support( 'post-thumbnails' );
register_nav_menus( array(
                      'header' => 'Custom Primary Menu',
                    ) );
//add_action( 'widgets_init', 'my_widgets_init' );