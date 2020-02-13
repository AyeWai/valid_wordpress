<?php

/*
Plugin Name: Floating Links
Plugin URI: https://wordpress.org/plugins/floating-links/
Description: Displays fancy floating top, bottom, next post, previous post, random post links and Pagination with custom post types support.
Author: Danish Ali Malik
Version: 3.5.3
Author URI: https://maltathemes.com/danish-ali-malik
Text Domain: floating-links
*/
//======================================================================
// Floating links Class
//======================================================================

if ( function_exists( 'fl_fs' ) ) {
    fl_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'fl_fs' ) ) {
        // Create a helper function for easy SDK access.
        function fl_fs()
        {
            global  $fl_fs ;
            
            if ( !isset( $fl_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $fl_fs = fs_dynamic_init( array(
                    'id'             => '3479',
                    'slug'           => 'floating-links',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_c912abe4e683b224482915ad39d6c',
                    'is_premium'     => false,
                    'premium_suffix' => 'Premium',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                    'slug' => 'floating_links',
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $fl_fs;
        }
        
        // Init Freemius.
        fl_fs();
        // Signal that SDK was initiated.
        do_action( 'fl_fs_loaded' );
    }
    
    class Floating_Links
    {
        /*
         * Plugin Version variable.
         */
        public  $fl_version = '3.5.3' ;
        /*
         * __construct initialize all function of this class.
         * Returns nothing. 
         * Used action_hooks to get things sequentially.
         */
        function __construct()
        {
            /*
             * init hooks fires on wp load.
             * Intialize all constants.
             */
            add_action( 'init', array( $this, 'fl_constants' ) );
            /*
             * init hooks fires on wp load.
             * Includes all files.
             */
            add_action( 'init', array( $this, 'fl_includes' ) );
            /*
             * register_activation_hook fires plugin install.
             */
            register_activation_hook( __FILE__, array( $this, 'fl_activate' ) );
            /*
             * register_uninstall_hook fires plugin delete.
             */
            register_uninstall_hook( __FILE__, array( 'Floating_Links', 'fl_uninstall' ) );
        }
        
        /* __construct Method ends here. */
        /*
         * fl_includes will add floating links files to the WordPress system.
         */
        public function fl_includes()
        {
            /*
             * Holds admin area's code.
             */
            include plugin_dir_path( __FILE__ ) . 'admin/admin.php';
            /*
             * Holds frontend area's code.
             */
            include plugin_dir_path( __FILE__ ) . 'frontend/frontend.php';
            /*
             * Extened customizer classes.
             */
            include plugin_dir_path( __FILE__ ) . 'admin/customizer-extend.php';
            /*
             * Holds customizer area's code.
             */
            include plugin_dir_path( __FILE__ ) . 'admin/customizer.php';
        }
        
        /* fl_includes Method ends here. */
        /*
         * fl_constants will define all the constants.
         */
        public function fl_constants()
        {
            /*
             * FLOATING_LINKS_VERSION constant will be defined.
             * Holds the version of the floating links.
             */
            if ( !defined( 'FLOATING_LINKS_VERSION' ) ) {
                define( 'FLOATING_LINKS_VERSION', $this->fl_version );
            }
            /*
             * FLOATING_LINKS_DIR constant will be defined.
             * Holds the directory path.
             */
            if ( !defined( 'FLOATING_LINKS_DIR' ) ) {
                define( 'FLOATING_LINKS_DIR', plugin_dir_path( __FILE__ ) );
            }
            /*
             * FLOATING_LINKS_URL constant will be defined.
             * Holds the main directory URL.
             */
            if ( !defined( 'FLOATING_LINKS_URL' ) ) {
                define( 'FLOATING_LINKS_URL', plugin_dir_url( __FILE__ ) );
            }
            /*
             * FLOATING_LINKS_FILE constant will be defined.
             * Holds the main floating links file.
             */
            if ( !defined( 'FLOATING_LINKS_FILE' ) ) {
                define( 'FLOATING_LINKS_FILE', __FILE__ );
            }
        }
        
        /* fl_constants Method ends here. */
        /*
         * fl_activate will call on plugin activation.
         * adds the installation date and version of the plugin to Database.
         */
        public function fl_activate()
        {
            $fl_options = array();
            $old_version = get_option( 'fl_version', false );
            
            if ( !empty($old_version) ) {
                $old_install_date = get_option( 'fl_installDate' );
                $fl_options['fl_installDate'] = $old_install_date;
                update_option( 'fl_settings', $fl_options );
                delete_option( 'fl_installDate' );
                delete_option( 'fl_version' );
                /*
                 * Update the version of the plugin.
                 */
                $fl_options['fl_version'] = $this->fl_version;
                $fl_options['fl_installDate'] = date( 'Y-m-d h:i:s' );
            }
            
            $left_icon = get_option( 'fl_left_icon', false );
            $right_icon = get_option( 'fl_right_icon', false );
            $random_icon = get_option( 'fl_random_icon', false );
            $top_icon = get_option( 'fl_up_icon', false );
            $bottom_icon = get_option( 'fl_down_icon', false );
            $bg_color = get_option( 'fl_bg_color', false );
            $color = get_option( 'fl_color', false );
            $size = get_option( 'fl_icon_size', false );
            $bcolor = get_option( 'fl_seprator_color', false );
            $hbcolor = get_option( 'fl_hover_bg_color', false );
            $hcolor = get_option( 'fl_icon_hover_color', false );
            $shadow = get_option( 'fl_shadow', false );
            $position = get_option( 'fl_position', false );
            $enable_random = get_option( 'fl_random', false );
            $enable_np = get_option( 'fl_next', false );
            $enable_p = get_option( 'fl_prev', false );
            $enable_top = get_option( 'fl_top_posts', false );
            $enable_top_pages = get_option( 'fl_top_pages', false );
            $enable_bottom = get_option( 'fl_bottom_posts', false );
            $enable_bottom_pages = get_option( 'fl_bottom_pages', false );
            $enable_cat = get_option( 'fl_cat', false );
            $enable_minimzer = get_option( 'fl_minimizer', false );
            $enable_post_data = get_option( 'fl_post_data', false );
            $enable_fl_copy_url = get_option( 'fl_copy_url', false );
            $fl_home_posts = get_option( 'fl_home_posts', false );
            $fl_home_pages = get_option( 'fl_home_pages', false );
            $fl_copy_url_posts = get_option( 'fl_copy_url_posts', false );
            $fl_copy_url_pages = get_option( 'fl_copy_url_pages', false );
            $fl_hover_post_bg_color = get_option( 'fl_hover_post_bg_color', false );
            $fl_hover_post_headings_color = get_option( 'fl_hover_post_headings_color', false );
            $fl_hover_post_color = get_option( 'fl_hover_post_color', false );
            $fl_hover_post_color = get_option( 'fl_hover_post_seprator_color', false );
            $fl_home_icon = get_option( 'fl_home_icon', false );
            $fl_copy_url_icon = get_option( 'fl_copy_url_icon', false );
            $fl_slimer_close_icon = get_option( 'fl_slimer_close_icon', false );
            $fl_slimer_close_icon = get_option( 'fl_slimer_open_icon', false );
            
            if ( !empty($old_version) ) {
                $fl_options['fl_left_icon'] = $left_icon;
                $fl_options['fl_right_icon'] = $right_icon;
                $fl_options['fl_random_icon'] = $random_icon;
                $fl_options['fl_up_icon'] = $top_icon;
                $fl_options['fl_down_icon'] = $bottom_icon;
                $fl_options['fl_bg_color'] = $bg_color;
                $fl_options['fl_position'] = $position;
                $fl_options['fl_color'] = $color;
                $fl_options['fl_icon_size'] = $size;
                $fl_options['fl_seprator_color'] = $bcolor;
                $fl_options['fl_hover_bg_color'] = $hbcolor;
                $fl_options['fl_icon_hover_color'] = $hcolor;
                $fl_options['fl_shadow'] = $shadow;
                $fl_options['fl_home_posts'] = $fl_home_posts;
                $fl_options['fl_home_pages'] = $fl_home_pages;
                $fl_options['fl_copy_url_posts'] = $fl_copy_url_posts;
                $fl_options['fl_copy_url_pages'] = $fl_copy_url_pages;
                $fl_options['fl_hover_post_bg_color'] = $fl_hover_post_bg_color;
                $fl_options['fl_hover_post_headings_color'] = $fl_hover_post_headings_color;
                $fl_options['fl_hover_post_color'] = $fl_hover_post_color;
                $fl_options['fl_hover_post_seprator_color'] = $fl_hover_post_seprator_color;
                $fl_options['fl_home_icon'] = $fl_home_icon;
                $fl_options['fl_copy_url_icon'] = $fl_copy_url_icon;
                $fl_options['fl_slimer_close_icon'] = $fl_slimer_close_icon;
                $fl_options['fl_slimer_open_icon'] = $fl_slimer_open_icon;
                $fl_options['fl_next'] = $enable_np;
                $fl_options['fl_prev'] = $enable_p;
                $fl_options['fl_random'] = $enable_random;
                $fl_options['fl_top'] = $enable_top;
                $fl_options['fl_bottom'] = $enable_bottom;
                $fl_options['fl_cat'] = $enable_cat;
                $fl_options['fl_minimizer'] = $enable_minimzer;
                $fl_options['fl_post_data'] = $enable_post_data;
                $fl_options['fl_copy_url'] = $enable_fl_copy_url;
                $fl_options['fl_home'] = $fl_home_posts;
                $fl_options['fl_sort'] = 'fl_next,fl_prev,fl_random,fl_top,fl_bottom,fl_home,fl_copy_url,fl_minimizer';
                $fl_options['fl_secondary']['fl_sort'] = 'fl_next,fl_prev,fl_random,fl_top,fl_bottom,fl_home,fl_copy_url,fl_minimizer';
                $fl_options['fl_secondary']['fl_prev'] = 'true';
                $fl_options['fl_secondary']['fl_minimizer'] = 'true';
                $fl_options['fl_secondary']['fl_post_data'] = 'true';
                update_option( 'fl_settings', $fl_options );
            }
            
            delete_option( 'fl_next' );
            delete_option( 'fl_prev' );
            delete_option( 'fl_random' );
            delete_option( 'fl_top_posts' );
            delete_option( 'fl_top_pages' );
            delete_option( 'fl_bottom_posts' );
            delete_option( 'fl_bottom_pages' );
            delete_option( 'fl_cat' );
            delete_option( 'fl_minimizer' );
            delete_option( 'fl_post_data' );
            delete_option( 'fl_left_icon' );
            delete_option( 'fl_right_icon' );
            delete_option( 'fl_random_icon' );
            delete_option( 'fl_up_icon' );
            delete_option( 'fl_down_icon' );
            delete_option( 'fl_bg_color' );
            delete_option( 'fl_position' );
            delete_option( 'fl_color' );
            delete_option( 'fl_icon_size' );
            delete_option( 'fl_seprator_color' );
            delete_option( 'fl_hover_bg_color' );
            delete_option( 'fl_icon_hover_color' );
            delete_option( 'fl_shadow' );
            delete_option( 'fl_slimer_open_icon' );
            delete_option( 'fl_slimer_close_icon' );
            delete_option( 'fl_copy_url_icon' );
            delete_option( 'fl_home_icon' );
            delete_option( 'fl_hover_post_seprator_color' );
            delete_option( 'fl_hover_post_color' );
            delete_option( 'fl_hover_post_headings_color' );
            delete_option( 'fl_hover_post_bg_color' );
            delete_option( 'fl_copy_url_pages' );
            delete_option( 'fl_copy_url_posts' );
            delete_option( 'fl_home_pages' );
            delete_option( 'fl_home_posts' );
            /*
             * By Default all options are true
             */
            
            if ( !$old_version ) {
                $fl_options = get_option( 'fl_settings', false );
                
                if ( empty($fl_options['fl_installDate']) ) {
                    $fl_options['fl_next'] = 'true';
                    $fl_options['fl_prev'] = 'false';
                    $fl_options['fl_random'] = 'true';
                    $fl_options['fl_top'] = 'true';
                    $fl_options['fl_minimizer'] = 'true';
                    $fl_options['fl_post_data'] = 'true';
                    $fl_options['fl_bottom'] = 'true';
                    $fl_options['fl_home'] = 'true';
                    $fl_options['fl_shadow'] = 1;
                    $fl_options['fl_installDate'] = date( 'Y-m-d h:i:s' );
                    $fl_options['fl_default_minimized'] = 'false';
                    $fl_options['fl_sort'] = 'fl_next,fl_prev,fl_random,fl_top,fl_bottom,fl_home,fl_copy_url,fl_minimizer';
                    $fl_options['fl_secondary']['fl_prev'] = 'true';
                    $fl_options['fl_secondary']['fl_minimizer'] = 'true';
                    $fl_options['fl_secondary']['fl_post_data'] = 'true';
                    $fl_options['fl_secondary']['fl_sort'] = 'fl_next,fl_prev,fl_random,fl_top,fl_bottom,fl_home,fl_copy_url,fl_minimizer';
                    update_option( 'fl_settings', $fl_options );
                }
                
                // echo '<pre>'; print_r($fl_options);exit();
            }
        
        }
        
        /* fl_activate Method ends here. */
        /*
         * fl_uninstall will call on plugin deletion.
         * Removes the values from database.
         */
        public function fl_uninstall()
        {
            /*
             * Making array of deletion keys.
             */
            $deletion_keys = array(
                'floating_left',
                'floating_right',
                'floating_random',
                'floating_up',
                'floating_down',
                'jws_floating_c_bg_color',
                'jws_floating_c_color',
                'jws_floating_c_size',
                'jws_floating_c_b_color',
                'jws_floating_c_h_bgcolor',
                'jws_floating_c_h_color',
                'jws_floating_c_shadow',
                'jws_floating_c_pos',
                'jws_floating_random',
                'jws_floating_np',
                'jws_floating_top',
                'jws_floating_bottom',
                'jws_floating_cat',
                'fl_next',
                'fl_prev',
                'fl_random',
                'fl_top_posts',
                'fl_top_pages',
                'fl_bottom_posts',
                'fl_bottom_pages',
                'fl_cat',
                'fl_minimizer',
                'fl_left_icon',
                'fl_right_icon',
                'fl_random_icon',
                'fl_up_icon',
                'fl_down_icon',
                'fl_bg_color',
                'fl_position',
                'fl_color',
                'fl_icon_size',
                'fl_seprator_color',
                'fl_hover_bg_color',
                'fl_icon_hover_color',
                'fl_shadow' . 'fl_settings',
                'fl_slimer_open_icon',
                'fl_slimer_close_icon',
                'fl_copy_url_icon',
                'fl_home_icon',
                'fl_hover_post_seprator_color',
                'fl_hover_post_color',
                'fl_hover_post_headings_color',
                'fl_hover_post_bg_color',
                'fl_copy_url_pages',
                'fl_copy_url_posts',
                'fl_home_pages',
                'fl_home_posts'
            );
            /*
             * Remove all options from db by loop.
             */
            foreach ( $deletion_keys as $key ) {
                delete_option( $key );
            }
            delete_option( 'fl_settings' );
        }
        
        /* fl_uninstall Method ends here. */
        public function get_fl_value( $key = null )
        {
            /*
             * Getting the options from database.
             */
            $fl_settings = get_option( 'fl_settings', false );
            if ( isset( $key ) ) {
                $fl_settings = $fl_settings[$key];
            }
            /*
             * Returning back the specific key values.
             */
            return $fl_settings;
        }
    
    }
    // End Class
    $floating_links = new Floating_Links();
}
