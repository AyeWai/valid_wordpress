<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//======================================================================
// Frontend Class
//======================================================================

if ( !class_exists( 'Floating_Links_Frontend' ) ) {
    class Floating_Links_Frontend
    {
        /*
         * __construct initialize all function of this class.
         * Returns nothing. 
         * Used action_hooks to get things sequentially.
         */
        function __construct()
        {
            /*
             * wp_enqueue_scripts hook will include scripts in wp.
             */
            add_action( 'wp_enqueue_scripts', array( $this, 'fl_enqueue_front_files' ) );
            
            if ( is_customize_preview() ) {
                $fl_bar = get_option( 'fl_bar', false );
                if ( 'secondary' == $fl_bar ) {
                    add_action( 'wp_footer', array( $this, 'fl_secondary_func' ) );
                }
                if ( 'primary' == $fl_bar ) {
                    add_action( 'wp_footer', array( $this, 'fl_func' ) );
                }
            } else {
                /*
                 * wp_footer hook will show floating links to the footer.
                 */
                add_action( 'wp_footer', array( $this, 'fl_func' ) );
                /*
                 * wp_footer hook will show floating links to the footer.
                 */
                add_action( 'wp_footer', array( $this, 'fl_secondary_func' ) );
            }
        
        }
        
        /* __construct Method ends here. */
        /*
         * fl_enqueue_front_files will enqueue all css and js files to the WordPress system.
         */
        public function fl_enqueue_front_files()
        {
            $floating_links = new Floating_Links();
            /*
             * Font Awesome fonts.
             */
            wp_enqueue_style( 'floating_fonts', FLOATING_LINKS_URL . '/css/floating_fonts.css' );
            /*
             * Custom css file.
             */
            wp_enqueue_style( 'floating_style', FLOATING_LINKS_URL . '/css/floating_style.css' );
            /*
             * Custom js file.
             */
            wp_enqueue_script( 'floating_custom', FLOATING_LINKS_URL . 'js/floating_custom.js', array( 'jquery' ) );
            /*
             * Localizing script to get admin-ajax url dynamically.
             */
            wp_localize_script( 'floating_custom', 'fl', array(
                'is_primary_scroll_enabled'   => $floating_links->get_fl_value( 'fl_scroll' ),
                'primary_scroll_val'          => $floating_links->get_fl_value( 'fl_scroll_percent' ),
                'is_secondary_scroll_enabled' => $floating_links->get_fl_value()['fl_secondary']['fl_scroll'],
                'secondary_scroll_val'        => $floating_links->get_fl_value()['fl_secondary']['fl_scroll_percent'],
            ) );
            /*
             * Base js file.
             */
            wp_enqueue_script( 'materialize.min', FLOATING_LINKS_URL . 'js/materialize.min.js', array( 'jquery' ) );
            /*
             * Dashicons of wordpress.
             */
            wp_enqueue_style( 'dashicons' );
        }
        
        /* fl_enqueue_files Method ends here. */
        /*
         * fl_func Will add the floating links to the site.
         */
        public function fl_func( $content )
        {
            $floating_links = new Floating_Links();
            /*
             * Getting Gloabl wp variable.
             */
            global  $wp ;
            /*
             * Current URL of the page.
             */
            $current_page_url = home_url( $wp->request );
            /*
             * Getting the postion of floating bar.
             */
            $fl_position = $floating_links->get_fl_value( 'fl_position' );
            $fl_minimized = null;
            $fl_scroll_class = null;
            $fl_scroll = null;
            $fl_scroll_percent = null;
            $fl_pages_enabled = null;
            $content .= '<div class="floating_next_prev_wrap ' . $fl_scroll_class . ' fl_primary_bar fl_' . $fl_position . '">
									
							<div class="floating_links">';
            /**
             * Getting primary sorted
             */
            $fl_primary_sort = $floating_links->get_fl_value( 'fl_sort' );
            /**
             * Exploding the sorting 
             */
            $fl_primary_sort = explode( ",", $fl_primary_sort );
            /**
             * Getting Primary Icons 
             */
            $fl_primary_icons = $this->fl_primary_icons();
            $len_el = $this->fl_is_el_enabled( true );
            $fl_is_el_enabled = $this->fl_is_el_enabled();
            $is_minimizer_enabled = $fl_primary_icons['fl_minimizer']['value'];
            $i = 0;
            // $len = count($fl_primary_sort);
            $len = $len_el - 1;
            if ( 'false' == $is_minimizer_enabled ) {
                $len = $len_el;
            }
            /**
             * Showing items according to sorting
             */
            if ( $fl_primary_sort ) {
                foreach ( $fl_primary_sort as $fl_primary_sort_single ) {
                    /**
                     * Getting Specific icon Array
                     */
                    $fl_primary_icon = $fl_primary_icons[$fl_primary_sort_single];
                    if ( 'false' == $is_minimizer_enabled && $i == 0 ) {
                        $content .= '<div id="fl_inner_primary_wrap" class="fl_inner_wrap ' . $fl_minimized_class . '">';
                    }
                    
                    if ( 'true' == $fl_primary_icon['value'] && 'fl_minimizer' != $fl_primary_icon['id'] ) {
                        if ( $i == 0 && 'true' == $is_minimizer_enabled ) {
                            $content .= '<div id="fl_inner_primary_wrap" class="fl_inner_wrap ' . $fl_minimized_class . '">';
                        }
                        if ( !is_single() ) {
                            
                            if ( 'fl_next' == $fl_primary_icon['id'] or 'fl_prev' == $fl_primary_icon['id'] or 'fl_random' == $fl_primary_icon['id'] ) {
                                $i++;
                                continue;
                            }
                        
                        }
                        /*
                         * Getting Gloabl wp variable.
                         */
                        global  $wp ;
                        /*
                         * Current URL of the page.
                         */
                        $current_page_url = home_url( $wp->request );
                        /*
                         * If random post not found disable the link.
                         */
                        
                        if ( $fl_primary_icon['post_data'] ) {
                            /**
                             * Getting post URL
                             */
                            $post_url = get_permalink( $fl_primary_icon['post_data']->ID );
                            /**
                             * If it's random icon get the URL from that object
                             */
                            if ( 'fl_random' == $fl_primary_icon['id'] ) {
                                $post_url = $fl_primary_icon['random_post_url'];
                            }
                            $fl_href_html = 'href="' . $post_url . '"';
                            $disabled = null;
                        } else {
                            if ( $fl_primary_icon['has_post_data'] ) {
                                $disabled = 'disabled';
                            }
                        }
                        
                        if ( !$fl_primary_icon['has_post_data'] ) {
                            $fl_href_html = null;
                        }
                        $fl_el_id = null;
                        /**
                         * If Icon is not set chose from default one
                         */
                        
                        if ( empty($fl_primary_icon['icon']) ) {
                            switch ( $fl_primary_icon['id'] ) {
                                case 'fl_next':
                                    $icon = 'dashicons dashicons-arrow-right-alt';
                                    break;
                                case 'fl_prev':
                                    $icon = 'dashicons dashicons-arrow-left-alt';
                                    break;
                                case 'fl_random':
                                    $icon = 'dashicons dashicons-randomize';
                                    break;
                                case 'fl_home':
                                    $icon = 'home';
                                    $fl_el_id = 'id="fl_home"';
                                    $fl_href_html = 'href="' . esc_url( home_url( "/" ) ) . '"';
                                    break;
                                case 'fl_top':
                                    $icon = 'dashicons dashicons-arrow-up-alt';
                                    $fl_el_id = 'id="fl_to_top"';
                                    break;
                                case 'fl_bottom':
                                    $icon = 'dashicons dashicons-arrow-down-alt';
                                    $fl_el_id = 'id="fl_to_bottom"';
                                    break;
                                case 'fl_copy_url':
                                    $icon = 'copy';
                                    $fl_el_id = 'id="fl_copy_url"';
                                    $fl_clipboard = 'data-clipboard-text="' . $current_page_url . '"';
                                    break;
                                case 'fl_minimizer':
                                    $icon = 'close';
                                    $open_icon = 'crosshairs';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        } else {
                            $icon = $fl_primary_icon['icon'];
                        }
                        
                        /*
                         * if dashicon is selected use following html.
                         */
                        
                        if ( strpos( $icon, 'dashicons' ) !== false ) {
                            $icon = '<i class="' . $fl_primary_icon['id'] . '_icon ' . $icon . '"></i>';
                        } else {
                            $icon = '<i class="' . $fl_primary_icon['id'] . '_icon fa fa-' . $icon . '"></i>';
                        }
                        
                        $content .= '<a ' . $fl_el_id . ' ' . $fl_clipboard . ' title="' . $fl_primary_icon['label'] . '" ' . $fl_href_html . ' class="' . $disabled . ' ' . $fl_primary_icon['id'] . ' fl_icon_holder">' . $icon . '';
                        
                        if ( $fl_primary_icon['has_post_data'] ) {
                            /**
                             * Getting post Title
                             */
                            $post_title = $fl_primary_icon['post_data']->post_title;
                            /**
                             * Getting post content
                             */
                            $post_content = $fl_primary_icon['post_data']->post_content;
                            /**
                             * If it's random icon get the URL from that object
                             */
                            
                            if ( 'fl_random' == $fl_primary_icon['id'] ) {
                                /**
                                 * Getting post Title
                                 */
                                $post_title = $fl_primary_icon['post_data']['random_post_title'];
                                /**
                                 * Getting post content
                                 */
                                $post_content = $fl_primary_icon['post_data']['random_post_content'];
                            }
                            
                            $post_content = wp_trim_words( $post_content, 20 );
                            $featured_image = null;
                            $date = null;
                            $is_feat_img = null;
                            $date = get_the_date( get_option( 'date_format', false ), $fl_primary_icon['post_data']->ID );
                            // echo "<pre>"; print_r($featured_image);echo "</pre>";exit();
                            $content .= '<div class="fl_post_details ' . $is_feat_img . '">';
                            $content .= '<div class="fl_post_title"><small>' . $fl_primary_icon['label'] . '</small>';
                            if ( 'true' == $floating_links->get_fl_value( 'fl_post_data_date' ) ) {
                                $content .= '<span class="fl_post_date">' . $date . '</span>';
                            }
                            $content .= '</div>
									<div class="fl_post_description"><h6>' . $post_title . '</h6><p>' . $post_content . '</p></div>
								</div>';
                        }
                        
                        $content .= '</a>';
                        if ( $i == $len - 1 && 'true' == $is_minimizer_enabled ) {
                            $content .= '</div>';
                        }
                        $i++;
                    }
                    
                    if ( 'false' == $is_minimizer_enabled && $i == $len ) {
                        $content .= '</div>';
                    }
                    
                    if ( 'true' == $fl_primary_icon['value'] && 'fl_minimizer' == $fl_primary_icon['id'] && !empty($fl_is_el_enabled) ) {
                        
                        if ( 'true' == $fl_primary_icon['minimized_value'] ) {
                            $fl_minimized_class = 'fl-close';
                        } else {
                            $fl_minimized_class = null;
                        }
                        
                        
                        if ( empty($fl_primary_icon['icon']) ) {
                            $icon = 'close';
                        } else {
                            $icon = $fl_primary_icon['icon'];
                        }
                        
                        
                        if ( empty($fl_primary_icon['fl_slimer_open_icon']) ) {
                            $open_icon = 'crosshairs';
                        } else {
                            $open_icon = $fl_primary_icon['fl_slimer_open_icon'];
                        }
                        
                        /*
                         * if dashicon is selected use following html.
                         */
                        
                        if ( strpos( $icon, 'dashicons' ) !== false ) {
                            $icon = '<i class="fl_slimmer_icon ' . $fl_primary_icon['id'] . '_icon ' . $icon . '"></i>';
                        } else {
                            $icon = '<i class="fl_slimmer_icon ' . $fl_primary_icon['id'] . '_icon fa fa-' . $icon . '"></i>';
                        }
                        
                        /*
                         * if dashicon is selected use following html.
                         */
                        
                        if ( strpos( $open_icon, 'dashicons' ) !== false ) {
                            $open_icon = '<i class="fl_slimer_close_icon fl_hide ' . $fl_primary_icon['id'] . '_icon ' . $open_icon . '"></i>';
                        } else {
                            $open_icon = '<i class="fl_slimer_close_icon fl_hide ' . $fl_primary_icon['id'] . '_icon fa fa-' . $open_icon . '"></i>';
                        }
                        
                        /*
                         * Slimer html
                         */
                        $content .= '<div id="fl_slimer_primary_wrap" class="fl_slimer_Wrap ' . $fl_minimized_class . '" title="' . __( 'Floating Links', 'floating-links' ) . '">
											' . $icon . '
											' . $open_icon . '
										</div>';
                    }
                
                }
            }
            $content .= '</div>';
            if ( 'true' == $fl_primary_icons['fl_copy_url']['value'] ) {
                $content .= '<div class="fl_copied"><span>' . __( 'Copied!', 'floating-links' ) . '</span>';
            }
            $content .= '</div></div>';
            $content = apply_filters( 'fl_bar_html', $content );
            echo  $content ;
        }
        
        /* fl_func Method ends here. */
        /*
         * fl_secondary_func Will add the floating links to the site.
         */
        public function fl_secondary_func( $content )
        {
            $floating_links = new Floating_Links();
            /*
             * Getting Gloabl wp variable.
             */
            global  $wp ;
            /*
             * Current URL of the page.
             */
            $current_page_url = home_url( $wp->request );
            $fl_minimized = null;
            $fl_scroll_class = null;
            $fl_scroll = null;
            $fl_scroll_percent = null;
            $fl_pages_enabled = null;
            /*
             * Getting the postion of floating bar.
             */
            $fl_position = $floating_links->get_fl_value()['fl_secondary']['fl_position'];
            if ( empty($fl_position) ) {
                $fl_position = 'left';
            }
            $content = '<div class="floating_next_prev_wrap ' . $fl_scroll_class . ' fl_secondary_bar fl_' . $fl_position . '">
									
							<div class="floating_links">';
            /**
             * Getting primary sorted
             */
            $fl_secondary_sort = $floating_links->get_fl_value()['fl_secondary']['fl_sort'];
            /**
             * Exploding the sorting 
             */
            $fl_secondary_sort = explode( ",", $fl_secondary_sort );
            /**
             * Getting Primary Icons 
             */
            $fl_secondary_icons = $this->fl_secondary_icons();
            $fl_is_el_enabled = $this->fl_is_el_enabled_secondary();
            $len_el = $this->fl_is_el_enabled_secondary( true );
            $is_minimizer_enabled = $fl_secondary_icons['fl_minimizer']['value'];
            $i = 0;
            // $len = count($fl_secondary_sort);
            $len = $len_el - 1;
            if ( 'false' == $is_minimizer_enabled ) {
                $len = $len_el;
            }
            // echo "<pre>"; print_r($is_minimizer_enabled);exit();
            /**
             * Showing items according to sorting
             */
            if ( $fl_secondary_sort ) {
                foreach ( $fl_secondary_sort as $fl_secondary_sort_single ) {
                    /**
                     * Getting Specific icon Array
                     */
                    $fl_secondary_icon = $fl_secondary_icons[$fl_secondary_sort_single];
                    if ( 'false' == $is_minimizer_enabled && $i == 0 ) {
                        $content .= '<div id="fl_inner_secondary_wrap" class="fl_inner_wrap ' . $fl_minimized_class . '">';
                    }
                    
                    if ( 'true' == $fl_secondary_icon['value'] && 'fl_minimizer' != $fl_secondary_icon['id'] ) {
                        if ( $i == 0 && 'true' == $is_minimizer_enabled ) {
                            $content .= '<div id="fl_inner_secondary_wrap" class="fl_inner_wrap ' . $fl_minimized_class . '">';
                        }
                        if ( !is_single() ) {
                            
                            if ( 'fl_next' == $fl_secondary_icon['id'] or 'fl_prev' == $fl_secondary_icon['id'] or 'fl_random' == $fl_secondary_icon['id'] ) {
                                $i++;
                                continue;
                            }
                        
                        }
                        /*
                         * Getting Gloabl wp variable.
                         */
                        global  $wp ;
                        /*
                         * Current URL of the page.
                         */
                        $current_page_url = home_url( $wp->request );
                        /*
                         * If random post not found disable the link.
                         */
                        
                        if ( $fl_secondary_icon['post_data'] ) {
                            /**
                             * Getting post URL
                             */
                            $post_url = get_permalink( $fl_secondary_icon['post_data']->ID );
                            /**
                             * If it's random icon get the URL from that object
                             */
                            if ( 'fl_random' == $fl_secondary_icon['id'] ) {
                                $post_url = $fl_secondary_icon['random_post_url'];
                            }
                            $fl_href_html = 'href="' . $post_url . '"';
                            $disabled = null;
                        } else {
                            if ( $fl_secondary_icon['has_post_data'] ) {
                                $disabled = 'disabled';
                            }
                        }
                        
                        if ( !$fl_secondary_icon['has_post_data'] ) {
                            $fl_href_html = null;
                        }
                        $fl_el_id = null;
                        /**
                         * If Icon is not set chose from default one
                         */
                        
                        if ( empty($fl_secondary_icon['icon']) ) {
                            switch ( $fl_secondary_icon['id'] ) {
                                case 'fl_next':
                                    $icon = 'dashicons dashicons-arrow-right-alt';
                                    break;
                                case 'fl_prev':
                                    $icon = 'dashicons dashicons-arrow-left-alt';
                                    break;
                                case 'fl_random':
                                    $icon = 'dashicons dashicons-randomize';
                                    break;
                                case 'fl_home':
                                    $icon = 'home';
                                    $fl_el_id = 'id="fl_home"';
                                    $fl_href_html = 'href="' . esc_url( home_url( "/" ) ) . '"';
                                    break;
                                case 'fl_top':
                                    $icon = 'dashicons dashicons-arrow-up-alt';
                                    $fl_el_id = 'id="fl_to_top"';
                                    break;
                                case 'fl_bottom':
                                    $icon = 'dashicons dashicons-arrow-down-alt';
                                    $fl_el_id = 'id="fl_to_bottom"';
                                    break;
                                case 'fl_copy_url':
                                    $icon = 'copy';
                                    $fl_el_id = 'id="fl_copy_url"';
                                    $fl_clipboard = 'data-clipboard-text="' . $current_page_url . '"';
                                    break;
                                case 'fl_minimizer':
                                    $icon = 'close';
                                    $open_icon = 'crosshairs';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        } else {
                            $icon = $fl_secondary_icon['icon'];
                        }
                        
                        /*
                         * if dashicon is selected use following html.
                         */
                        
                        if ( strpos( $icon, 'dashicons' ) !== false ) {
                            $icon = '<i class="' . $fl_secondary_icon['id'] . '_icon ' . $icon . '"></i>';
                        } else {
                            $icon = '<i class="' . $fl_secondary_icon['id'] . '_icon fa fa-' . $icon . '"></i>';
                        }
                        
                        $content .= '<a ' . $fl_el_id . ' ' . $fl_clipboard . ' title="' . $fl_secondary_icon['label'] . '" ' . $fl_href_html . ' class="' . $disabled . ' ' . $fl_secondary_icon['id'] . ' fl_icon_holder">' . $icon . '';
                        
                        if ( $fl_secondary_icon['has_post_data'] ) {
                            /**
                             * Getting post Title
                             */
                            $post_title = $fl_secondary_icon['post_data']->post_title;
                            /**
                             * Getting post content
                             */
                            $post_content = $fl_secondary_icon['post_data']->post_content;
                            /**
                             * If it's random icon get the URL from that object
                             */
                            
                            if ( 'fl_random' == $fl_secondary_icon['id'] ) {
                                /**
                                 * Getting post Title
                                 */
                                $post_title = $fl_secondary_icon['post_data']['random_post_title'];
                                /**
                                 * Getting post content
                                 */
                                $post_content = $fl_secondary_icon['post_data']['random_post_content'];
                            }
                            
                            $post_content = wp_trim_words( $post_content, 20 );
                            $is_feat_img = null;
                            $date = get_the_date( get_option( 'date_format', false ), $fl_secondary_icon['post_data']->ID );
                            // echo "<pre>"; print_r($date); echo "</pre>"; exit();
                            $content .= '<div class="fl_post_details ' . $is_feat_img . '">';
                            $content .= '<div class="fl_post_title"><small>' . $fl_secondary_icon['label'] . '</small>';
                            if ( 'true' == $floating_links->get_fl_value()['fl_secondary']['fl_post_data_date'] ) {
                                $content .= '<span class="fl_post_date">' . $date . '</span>';
                            }
                            $content .= '</div>
									<div class="fl_post_description"><h6>' . $post_title . '</h6><p>' . $post_content . '</p></div>
								</div>';
                        }
                        
                        $content .= '</a>';
                        if ( $i == $len - 1 && 'true' == $is_minimizer_enabled ) {
                            $content .= '</div>';
                        }
                        $i++;
                    }
                    
                    if ( 'false' == $is_minimizer_enabled && $i == $len ) {
                        $content .= '</div>';
                    }
                    
                    if ( 'true' == $fl_secondary_icon['value'] && 'fl_minimizer' == $fl_secondary_icon['id'] && !empty($fl_is_el_enabled) ) {
                        
                        if ( 'true' == $fl_secondary_icon['minimized_value'] ) {
                            $fl_minimized_class = 'fl-close';
                        } else {
                            $fl_minimized_class = null;
                        }
                        
                        
                        if ( empty($fl_secondaryicon['icon']) ) {
                            $icon = 'close';
                        } else {
                            $icon = $fl_secondary_icon['icon'];
                        }
                        
                        
                        if ( empty($fl_secondary_icon['fl_slimer_open_icon']) ) {
                            $open_icon = 'crosshairs';
                        } else {
                            $open_icon = $fl_secondary_icon['fl_slimer_open_icon'];
                        }
                        
                        /*
                         * if dashicon is selected use following html.
                         */
                        
                        if ( strpos( $icon, 'dashicons' ) !== false ) {
                            $icon = '<i class="fl_slimmer_icon ' . $fl_secondary_icon['id'] . '_icon ' . $icon . '"></i>';
                        } else {
                            $icon = '<i class="fl_slimmer_icon ' . $fl_secondary_icon['id'] . '_icon fa fa-' . $icon . '"></i>';
                        }
                        
                        /*
                         * if dashicon is selected use following html.
                         */
                        
                        if ( strpos( $open_icon, 'dashicons' ) !== false ) {
                            $open_icon = '<i class="fl_slimer_close_icon fl_hide ' . $fl_secondary_icon['id'] . '_icon ' . $open_icon . '"></i>';
                        } else {
                            $open_icon = '<i class="fl_slimer_close_icon fl_hide ' . $fl_secondary_icon['id'] . '_icon fa fa-' . $open_icon . '"></i>';
                        }
                        
                        /*
                         * Slimer html
                         */
                        $content .= '<div id="fl_slimer_secondary_wrap" class="fl_slimer_Wrap ' . $fl_minimized_class . '" title="' . __( 'Floating Links', 'floating-links' ) . '">
											' . $icon . '
											' . $open_icon . '
										</div>';
                    }
                
                }
            }
            $content .= '</div>';
            if ( 'true' == $fl_secondary_icons['fl_copy_url']['value'] ) {
                $content .= '<div class="fl_copied"><span>' . __( 'Copied!', 'floating-links' ) . '</span>';
            }
            $content .= '</div></div>';
            $content = apply_filters( 'fl_secondary_bar_html', $content );
            echo  $content ;
        }
        
        /* fl_secondary_func Method ends here. */
        /*
         * fl_primary_icons shows the Primary Bar.
         */
        public function fl_primary_icons()
        {
            /**
             * Getting main class
             */
            $floating_links = new Floating_Links();
            /**
             * Array of all primary bar items
             */
            $fl_icons_front_array = array(
                'fl_next'      => array(
                'id'            => 'fl_next',
                'icon'          => $floating_links->get_fl_value( 'fl_right_icon' ),
                'is_dependent'  => false,
                'label'         => __( 'Next Up', 'floating-links' ),
                'value'         => $floating_links->get_fl_value( 'fl_next' ),
                'has_post_data' => true,
                'post_data'     => get_next_post( $floating_links->get_fl_value( 'fl_cat' ) ),
            ),
                'fl_prev'      => array(
                'id'            => 'fl_prev',
                'icon'          => $floating_links->get_fl_value( 'fl_left_icon' ),
                'is_dependent'  => false,
                'label'         => __( 'Previous', 'floating-links' ),
                'value'         => $floating_links->get_fl_value( 'fl_prev' ),
                'has_post_data' => true,
                'post_data'     => get_previous_post( $floating_links->get_fl_value( 'fl_cat' ) ),
            ),
                'fl_random'    => array(
                'id'            => 'fl_random',
                'icon'          => $floating_links->get_fl_value( 'fl_random_icon' ),
                'label'         => __( 'Random', 'floating-links' ),
                'value'         => $floating_links->get_fl_value( 'fl_random' ),
                'is_dependent'  => false,
                'has_post_data' => true,
                'post_data'     => $this->fl_random_post_url(),
            ),
                'fl_top'       => array(
                'id'            => 'fl_top',
                'icon'          => $floating_links->get_fl_value( 'fl_up_icon' ),
                'label'         => __( 'To Top', 'floating-links' ),
                'value'         => $floating_links->get_fl_value( 'fl_top' ),
                'post_data'     => null,
                'has_post_data' => false,
                'is_dependent'  => true,
            ),
                'fl_bottom'    => array(
                'id'            => 'fl_bottom',
                'icon'          => $floating_links->get_fl_value( 'fl_down_icon' ),
                'label'         => __( 'To Bottom', 'floating-links' ),
                'has_post_data' => false,
                'post_data'     => null,
                'value'         => $floating_links->get_fl_value( 'fl_bottom' ),
                'is_dependent'  => true,
            ),
                'fl_home'      => array(
                'id'            => 'fl_home',
                'icon'          => $floating_links->get_fl_value( 'fl_home_icon' ),
                'label'         => __( 'Home', 'floating-links' ),
                'value'         => $floating_links->get_fl_value( 'fl_home' ),
                'has_post_data' => false,
                'post_data'     => null,
                'is_dependent'  => true,
            ),
                'fl_copy_url'  => array(
                'id'            => 'fl_copy_url',
                'icon'          => $floating_links->get_fl_value( 'fl_copy_url_icon' ),
                'label'         => __( 'Copy Current URL', 'floating-links' ),
                'value'         => $floating_links->get_fl_value( 'fl_copy_url' ),
                'has_post_data' => false,
                'post_data'     => null,
                'is_dependent'  => true,
            ),
                'fl_minimizer' => array(
                'id'                  => 'fl_minimizer',
                'icon'                => $floating_links->get_fl_value( 'fl_slimer_close_icon' ),
                'has_post_data'       => false,
                'post_data'           => null,
                'label'               => __( 'Minimizer', 'floating-links' ),
                'value'               => $floating_links->get_fl_value( 'fl_minimizer' ),
                'minimized_value'     => $floating_links->get_fl_value( 'fl_default_minimized' ),
                'is_dependent'        => false,
                'fl_slimer_open_icon' => $floating_links->get_fl_value( 'fl_slimer_open_icon' ),
            ),
            );
            /**
             * Filter to add more items in primary bar
             */
            return $fl_icons_front_array = apply_filters( 'fl_primary_items_front', $fl_icons_front_array );
        }
        
        /* fl_primary_icons Method ends here. */
        /*
         * fl_secondary_icons shows the Primary Bar.
         */
        public function fl_secondary_icons()
        {
            /**
             * Getting main class
             */
            $floating_links = new Floating_Links();
            /**
             * Array of all primary bar items
             */
            $fl_icons_front_array = array(
                'fl_next'      => array(
                'id'            => 'fl_next',
                'icon'          => $floating_links->get_fl_value()['fl_secondary']['fl_right_icon'],
                'is_dependent'  => false,
                'label'         => __( 'Next Up', 'floating-links' ),
                'value'         => $floating_links->get_fl_value()['fl_secondary']['fl_next'],
                'has_post_data' => true,
                'post_data'     => get_next_post( $floating_links->get_fl_value()['fl_secondary']['fl_cat'] ),
            ),
                'fl_prev'      => array(
                'id'            => 'fl_prev',
                'icon'          => $floating_links->get_fl_value()['fl_secondary']['fl_left_icon'],
                'is_dependent'  => false,
                'label'         => __( 'Previous', 'floating-links' ),
                'value'         => $floating_links->get_fl_value()['fl_secondary']['fl_prev'],
                'has_post_data' => true,
                'post_data'     => get_previous_post( $floating_links->get_fl_value()['fl_secondary']['fl_cat'] ),
            ),
                'fl_random'    => array(
                'id'            => 'fl_random',
                'icon'          => $floating_links->get_fl_value()['fl_secondary']['fl_random_icon'],
                'label'         => __( 'Random', 'floating-links' ),
                'value'         => $floating_links->get_fl_value()['fl_secondary']['fl_random'],
                'is_dependent'  => false,
                'has_post_data' => true,
                'post_data'     => $this->fl_random_post_url(),
            ),
                'fl_top'       => array(
                'id'            => 'fl_top',
                'icon'          => $floating_links->get_fl_value()['fl_secondary']['fl_up_icon'],
                'label'         => __( 'To Top', 'floating-links' ),
                'value'         => $floating_links->get_fl_value()['fl_secondary']['fl_top'],
                'post_data'     => null,
                'has_post_data' => false,
                'is_dependent'  => true,
            ),
                'fl_bottom'    => array(
                'id'            => 'fl_bottom',
                'icon'          => $floating_links->get_fl_value()['fl_secondary']['fl_down_icon'],
                'label'         => __( 'To Bottom', 'floating-links' ),
                'has_post_data' => false,
                'post_data'     => null,
                'value'         => $floating_links->get_fl_value()['fl_secondary']['fl_bottom'],
                'is_dependent'  => true,
            ),
                'fl_home'      => array(
                'id'            => 'fl_home',
                'icon'          => $floating_links->get_fl_value()['fl_secondary']['fl_home_icon'],
                'label'         => __( 'Home', 'floating-links' ),
                'value'         => $floating_links->get_fl_value()['fl_secondary']['fl_home'],
                'has_post_data' => false,
                'post_data'     => null,
                'is_dependent'  => true,
            ),
                'fl_copy_url'  => array(
                'id'            => 'fl_copy_url',
                'icon'          => $floating_links->get_fl_value()['fl_secondary']['fl_copy_url_icon'],
                'label'         => __( 'Copy Current URL', 'floating-links' ),
                'value'         => $floating_links->get_fl_value()['fl_secondary']['fl_copy_url'],
                'has_post_data' => false,
                'post_data'     => null,
                'is_dependent'  => true,
            ),
                'fl_minimizer' => array(
                'id'                  => 'fl_minimizer',
                'icon'                => $floating_links->get_fl_value()['fl_secondary']['fl_slimer_close_icon'],
                'has_post_data'       => false,
                'post_data'           => null,
                'label'               => __( 'Minimizer', 'floating-links' ),
                'value'               => $floating_links->get_fl_value()['fl_secondary']['fl_minimizer'],
                'minimized_value'     => $floating_links->get_fl_value()['fl_secondary']['fl_default_minimized'],
                'is_dependent'        => false,
                'fl_slimer_open_icon' => $floating_links->get_fl_value()['fl_secondary']['fl_slimer_open_icon'],
            ),
            );
            /**
             * Filter to add more items in primary bar
             */
            return $fl_icons_front_array = apply_filters( 'fl_secondary_items_front', $fl_icons_front_array );
        }
        
        /* fl_secondary_icons Method ends here. */
        /**
         * Check if any option is enbaled
         */
        public function fl_is_el_enabled( $is_count = false )
        {
            /**
             * Getting all icons enabled
             */
            $fl_primary_icons = $this->fl_primary_icons();
            $i = 0;
            /**
             * Definifn an array
             */
            $fl_el_array = array();
            /**
             * Loop thorugh and save their enable options in array
             */
            if ( $fl_primary_icons ) {
                foreach ( $fl_primary_icons as $fl_primary_icon ) {
                    if ( 'fl_minimizer' != $fl_primary_icon['id'] ) {
                        $fl_el_array[] = $fl_primary_icon['value'];
                    }
                    if ( 'true' == $fl_primary_icon['value'] ) {
                        $i++;
                    }
                }
            }
            
            if ( $is_count ) {
                return $i;
            } else {
                return in_array( 'true', $fl_el_array );
            }
            
            // echo "<pre>"; print_r($fl_el_array);exit();
        }
        
        /* fl_is_el_enabled Method ends here. */
        /**
         * Check if any option is enbaled
         */
        public function fl_is_el_enabled_secondary( $is_count = false )
        {
            /**
             * Getting all icons enabled
             */
            $fl_primary_icons = $this->fl_secondary_icons();
            /**
             * Definifn an array
             */
            $fl_el_array = array();
            /**
             * Loop thorugh and save their enable options in array
             */
            if ( $fl_primary_icons ) {
                foreach ( $fl_primary_icons as $fl_primary_icon ) {
                    if ( 'fl_minimizer' != $fl_primary_icon['id'] ) {
                        $fl_el_array[] = $fl_primary_icon['value'];
                    }
                    if ( 'true' == $fl_primary_icon['value'] ) {
                        $i++;
                    }
                }
            }
            
            if ( $is_count ) {
                return $i;
            } else {
                return in_array( 'true', $fl_el_array );
            }
            
            // echo "<pre>"; print_r($fl_el_array);exit();
        }
        
        /* fl_is_el_enabled_secondary Method ends here. */
        /*
         * fl_random_post_url returns the post url randomaly.
         */
        public function fl_random_post_url()
        {
            /*
             * Gets current post's post type.
             */
            $post_type = get_post_type();
            /*
             * Gets random post with the same post type.
             */
            $rand = get_posts( array(
                'posts_per_page' => 1,
                'orderby'        => 'rand',
                'post_type'      => $post_type,
            ) );
            /*
             * Gets random URL.
             */
            $rand_url = get_permalink( $rand[0]->ID );
            /*
             * Gets random post title.
             */
            $rand_post_title = $rand[0]->post_title;
            /*
             * Gets random post title.
             */
            $rand_post_content = $rand[0]->post_content;
            /*
             * Returns random URL and Post title.
             */
            return array(
                'random_post_url'     => $rand_url,
                'random_post_title'   => $rand_post_title,
                'random_post_content' => $rand_post_content,
            );
        }
    
    }
    $Floating_Links_Frontend = new Floating_Links_Frontend();
}
