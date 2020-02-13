<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//======================================================================
// Admin Class
//======================================================================

if ( !class_exists( 'Floating_Links_Admin' ) ) {
    class Floating_Links_Admin
    {
        /*
         * __construct initialize all function of this class.
         * Returns nothing. 
         * Used action_hooks to get things sequentially.
         */
        function __construct()
        {
            /*
             * admin_menu hooks fires on wp admin load.
             * Add the menu page in wp admin area.
             */
            add_action( 'admin_menu', array( $this, 'fl_menu' ) );
            /*
             * admin_enqueue_scripts hooks fires for enqueing custom script and styles.
             * Css file will be include in admin area.
             */
            add_action( 'admin_enqueue_scripts', array( $this, 'fl_admin_style' ) );
            /*
             * admin_notices hooks fires for displaying admin notice.
             * xo_admin_notice method will be call.
             */
            add_action( 'admin_notices', array( $this, 'fl_admin_notice' ) );
            /*
             * wp_ajax_xo_supported hooks fires on Ajax call.
             * fl_supported_func method will be call on click of supported button in admin notice.
             */
            add_action( 'wp_ajax_fl_supported', array( $this, 'fl_supported_func' ) );
            /*
             * wp_ajax_xo_supported hooks fires on Ajax call.
             * fl_supported_func method will be call on click of supported button in admin notice.
             */
            add_action( 'wp_ajax_fl_hide_up', array( $this, 'fl_hide_up' ) );
            /*
             * fl_save_values hooks fires on Ajax call.
             * fl_save_values method will save the Floating icon values.
             */
            add_action( 'wp_ajax_fl_save_values', array( $this, 'fl_save_values' ) );
        }
        
        /* __construct Method ends here. */
        /*
         * fl_admin_style will enqueue style and js files.
         * Returns hook name of the current page in admin.
         * $hook will contain the hook name.
         */
        public function fl_admin_style( $hook )
        {
            /*
             * Custom css file for admin area.
             */
            wp_enqueue_style( 'floating_admin_notice', FLOATING_LINKS_URL . 'css/floating_admin_notice.css' );
            /*
             * Load only on ?page=floating_links
             */
            
            if ( 'toplevel_page_floating_links' == $hook or 'floating-links_page_mt-other-plugins' == $hook ) {
                /*
                 * Base css file.
                 */
                wp_enqueue_style( 'materialize.min', FLOATING_LINKS_URL . '/css/materialize.min.css' );
                /*
                 * Custom css file for admin area.
                 */
                wp_enqueue_style( 'floating_admin_style', FLOATING_LINKS_URL . 'css/floating_admin_style.css' );
                /*
                 * Base js file.
                 */
                wp_enqueue_script( 'materialize.min', FLOATING_LINKS_URL . 'js/materialize.min.js', array( 'jquery' ) );
                // wp_enqueue_script('my_jquery_ui', "http://code.jquery.com/ui/1.10.3/jquery-ui.js", array('jquery'), '1.0');
                wp_enqueue_script( 'jquery-ui-sortable' );
                /*
                 * Custom js file for admin area.
                 */
                wp_enqueue_script( 'floating_admin_js', FLOATING_LINKS_URL . 'js/floating_admin_js.js', array( 'jquery' ) );
                /*
                 * Localizing script to get admin-ajax url dynamically.
                 */
                wp_localize_script( 'floating_admin_js', 'fl', array(
                    'ajax_url'            => admin_url( 'admin-ajax.php' ),
                    'notification_string' => __( 'Updating Values', 'floating-links' ),
                ) );
            }
        
        }
        
        /* fl_admin_style Method ends here. */
        /*
         * fl_menu will add admin page.
         * Returns nothing.
         */
        public function fl_menu()
        {
            /*
             * URL of the plugin icon.
             */
            $icon_url = FLOATING_LINKS_URL . '/images/plugin_icon.png';
            /*
             * add_menu_page will add menu into the page.
             * string $page_title 
             * string $menu_title 
             * string $capability 
             * string $menu_slug
             * callable $function 
             */
            $fl_page_title = __( 'Floating Links', 'floating-links' );
            $fl_ver = fl_fs()->is_premium();
            $fl_version = ( $fl_ver ? 'pro' : 'free' );
            if ( $fl_version == 'pro' ) {
                $fl_page_title = __( 'Floating Links Pro', 'floating-links' );
            }
            add_menu_page(
                __( 'Floating Links Settings', 'floating-links' ),
                $fl_page_title,
                'administrator',
                'floating_links',
                array( $this, 'fl_func' ),
                $icon_url
            );
        }
        
        /* fl_menu Method ends here. */
        /*
         * fl_func contains the html/markup of the page.
         * Returns html of page.
         */
        public function fl_func()
        {
            $floating_links = new Floating_Links();
            // echo "<pre>"; print_r($floating_links->get_fl_value());exit();
            global  $fl_fs ;
            $fl_upgrade_url = $fl_fs->get_upgrade_url();
            $fl_ver = fl_fs()->is_premium();
            $fl_version = ( $fl_ver ? 'pro' : 'free' );
            /*
             * Intializing the variable.
             */
            $returner = null;
            /*
             * Html of page.
             */
            $returner = '<div class="fl_wrap  z-depth-1">

						<!-- Main row of page<!-->
						<div class="row">

						<!-- Tabs menu starts here<!-->
					    <div class="col s12 fl_tabs_header">

					    <!-- Sliders starts here<!-->
					    <div class="fl_sliders_wrap">
						 <div id="fl_sliders">
						      <span>
						        <div class="box"></div>
						      </span>
						      <span>
						        <div class="box"></div>
						      </span>
						      <span>
						        <div class="box"></div>
						      </span>
						    </div>

					  </div> <!-- Sliders ends here<!-->

					  	<div class="fl_tabs_main">	
					      <ul class="tabs">
					        <li class="tab"><a class="active tooltipped fl_general_tab fl_tab" data-position="bottom" data-tooltip="' . __( 'General', 'floating-links' ) . '" href="#general"><i class="material-icons dp48">settings_applications</i></a></li>
					         <li class="tab"><a class="tooltipped fl_display_tab fl_tab" data-position="bottom" data-tooltip="' . __( 'Display Settings', 'floating-links' ) . '" href="#fl_display_tab"><i class="material-icons dp48">settings_overscan</i></a></li>

					         <li class="tab"><a class="tooltipped fl_design_tab fl_tab" data-position="bottom" data-tooltip="' . __( 'Design', 'floating-links' ) . '" href="#fl_design_tab"><i class="material-icons dp48">brush</i></a></li>
 				
					   		  
					      </ul>

					      

					      </div> <!-- fl_tabs_main ends here<!-->   
					    </div> <!-- Tabs menu ends here<!-->

						<!-- Tabs content wrapper<!-->
					    <div class="fl_tabs_content col s12">	
					   	 <div id="general" class="col s12 fl_general_content fl_tab_content">
					   	 	<div class="fl_bars_holder">
					   	 		<ul>
					   	 		<li class="fl_bar_gen active fl_bar_prim" data-id="primary">' . __( 'Primary Bar', 'floating-links' ) . '</li>
					   	 		<li class="fl_bar_gen fl_bar_sec" data-id="secondary">' . __( 'Secondary Bar', 'floating-links' ) . '</li>
					   	 		</ul>
					   	 	</div>
					   	 	<div class="fl_primary_content">	
					   	 	<h5>' . __( 'Want to show selective icons in Primary Bar?', 'floating-links' ) . '</h5>

					   	 	<p>' . __( 'No problem at all. Simply enable or disable icons from particular tab/section below.', 'floating-links' ) . '</p>
					   	 	<i class="material-icons fl_down pulse">arrow_downward</i>
					   	 
					   	 <!-- collapsible content wrapper<!-->

					   	 <div class="fl_collapsible_wrap col s12 fl_primary_wrap">	

					   	 	<ul id="fl_collapsible" class="collapsible" data-collapsible="expandable">';
            $returner .= $this->fl_primary_icons_html();
            $returner .= '</ul>


				          </div><!-- collapsible content wrapper ends<!-->

				          </div>

				          <div class="fl_secondary_content">

					   	 	<h5>' . __( 'Want to show selective icons in Secondary Bar?', 'floating-links' ) . '</h5>

					   	 	<p>' . __( 'No problem at all. Simply enable or disable icons from particular tab/section below.', 'floating-links' ) . '</p>
					   	 	<i class="material-icons fl_down pulse">arrow_downward</i>
					   	 
					   	 <!-- collapsible content wrapper<!-->

					   	 <div class="fl_collapsible_wrap col s12">	
					   	 	<ul id="fl_collapsible_secondary" class="collapsible" data-collapsible="expandable">';
            $returner .= $this->fl_secondary_icons_html();
            $returner .= '</ul>
				            </div> </div>';
            if ( 'free' == $fl_version ) {
                $returner .= '<div class="fl_drag_holder"><a href="#fl-drag-drop-upgrade" class="modal-trigger"><img src="' . FLOATING_LINKS_URL . '/images/drag-and-drop.png" /></a></div>';
            }
            $returner .= '</div>';
            $returner .= $this->fl_display_tab_html();
            $returner .= '<!-- Display ends here<!-->';
            $returner .= $this->fl_design_tab_html();
            $returner .= '</div> <!-- Tabs content wrapper ends<!-->
					    
					  </div> <!-- Main row of page ends<!-->
					<!-- Popup starts<!-->
					   <div id="fl-minimized-upgrade" class="modal">
						    <div class="modal-content">
					    	<span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
					     	<div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
								<h5>' . __( 'Premium Feature', 'floating-links' ) . '</h5>
								<p>' . __( "We are sorry hide on load feature is not available in the free version. Please upgrade to pro version to unlock this and all other cool features.", 'floating-links' ) . '</p>
								
								<a href="' . $fl_upgrade_url . '" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i>' . __( 'Upgrade to pro', 'floating-links' ) . '</a> 
								<i class="fl_cupon_code">' . __( 'Get 10% off using coupon code: ', 'floating-links' ) . '<code>fl10</code> <br>' . __( 'Exclusive offer for lite users for limited time', 'floating-links' ) . ' </i>
					     	</div>
					    </div>

						</div>
					    <!-- Popup ends<!-->


					    <!-- Popup starts<!-->
					   <div id="fl-scroll-upgrade" class="modal">
						    <div class="modal-content">
					    	<span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
					     	<div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
								<h5>' . __( 'Premium Feature', 'floating-links' ) . '</h5>
								<p>' . __( "We are sorry show on scroll feature is not available in the free version. Please upgrade to pro version to unlock this and all other cool features.", 'floating-links' ) . '</p>
								
								<a href="' . $fl_upgrade_url . '" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i>' . __( 'Upgrade to pro', 'floating-links' ) . '</a> 
								<i class="fl_cupon_code">' . __( 'Get 10% off using coupon code: ', 'floating-links' ) . '<code>fl10</code> <br>' . __( 'Exclusive offer for lite users for limited time', 'floating-links' ) . ' </i>
					     	</div>
					    </div>

						</div>
					    <!-- Popup ends<!-->


					    <!-- Popup starts<!-->
					   <div id="fl-page-upgrade" class="modal">
						    <div class="modal-content">
					    	<span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
					     	<div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
								<h5>' . __( 'Premium Feature', 'floating-links' ) . '</h5>
								<p>' . __( "We are sorry show on specific pages feature is not available in the free version. Please upgrade to pro version to unlock this and all other cool features.", 'floating-links' ) . '</p>
								
								<a href="' . $fl_upgrade_url . '" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i>' . __( 'Upgrade to pro', 'floating-links' ) . '</a> 
								<i class="fl_cupon_code">' . __( 'Get 10% off using coupon code: ', 'floating-links' ) . '<code>fl10</code> <br>' . __( 'Exclusive offer for lite users for limited time', 'floating-links' ) . ' </i>
					     	</div>
					    </div>

						</div>
					    <!-- Popup ends<!-->

					     <!-- Popup starts<!-->
					   <div id="fl-post-upgrade" class="modal">
						    <div class="modal-content">
					    	<span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
					     	<div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
								<h5>' . __( 'Premium Feature', 'floating-links' ) . '</h5>
								<p>' . __( "We are sorry show on specific posts feature is not available in the free version. Please upgrade to pro version to unlock this and all other cool features.", 'floating-links' ) . '</p>
								
								<a href="' . $fl_upgrade_url . '" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i>' . __( 'Upgrade to pro', 'floating-links' ) . '</a> 
								<i class="fl_cupon_code">' . __( 'Get 10% off using coupon code: ', 'floating-links' ) . '<code>fl10</code> <br>' . __( 'Exclusive offer for lite users for limited time', 'floating-links' ) . ' </i>
					     	</div>
					    </div>

						</div>
					    <!-- Popup ends<!-->

					     <!-- Popup starts<!-->
					   <div id="fl-drag-drop-upgrade" class="modal">
						    <div class="modal-content">
					    	<span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
					     	<div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
								<h5>' . __( 'Premium Feature', 'floating-links' ) . '</h5>
								<p>' . __( "We are sorry sorting the icons feature is not available in the free version. Please upgrade to pro version to unlock this and all other cool features.", 'floating-links' ) . '</p>
								
								<a href="' . $fl_upgrade_url . '" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i>' . __( 'Upgrade to pro', 'floating-links' ) . '</a> 
								<i class="fl_cupon_code">' . __( 'Get 10% off using coupon code: ', 'floating-links' ) . '<code>fl10</code> <br>' . __( 'Exclusive offer for lite users for limited time', 'floating-links' ) . ' </i>
					     	</div>
					    </div>

						</div>
					    <!-- Popup ends<!-->

					  <!-- Popup starts<!-->
					   <div id="fl-feat-upgrade" class="modal">
						    <div class="modal-content">
					    	<span class="mif-close-modal modal-close"><i class="material-icons dp48">close</i></span>
					     	<div class="mif-modal-content"> <span class="mif-lock-icon"><i class="material-icons dp48">lock_outline</i> </span>
								<h5>' . __( 'Premium Feature', 'floating-links' ) . '</h5>
								<p>' . __( "We are sorry showing featured image feature is not available in the free version. Please upgrade to pro version to unlock this and all other cool features.", 'floating-links' ) . '</p>
								
								<a href="' . $fl_upgrade_url . '" class="waves-effect waves-light btn"><i class="material-icons right">lock_open</i>' . __( 'Upgrade to pro', 'floating-links' ) . '</a> 
								<i class="fl_cupon_code">' . __( 'Get 10% off using coupon code: ', 'floating-links' ) . '<code>fl10</code> <br>' . __( 'Exclusive offer for lite users for limited time', 'floating-links' ) . ' </i>
					     	</div>
					    </div>

						</div>
					    <!-- Popup ends<!-->

					</div>';
            /*
             * Our Plugins tab html.
             * mif_other_plugins_html filter can be used to customize our plugins tab html.
             */
            $mt_op_html = null;
            $mt_op_html .= '<div class="mt_other_plugins_holder"><div id="mt-other-plugins" class="">
						 <!-- Our Plugins  HTML-->
						 <iframe src="https://maltathemes.com/our-plugins/" height="400" width="680"  style="border:0px;float:left;" id="mt-our-plugins" name="Our Plugins"></iframe>
						<!-- Our Plugins  HTML Ends-->	
						</div></div>';
            $mt_op_html = apply_filters( 'mt_op_html', $mt_op_html );
            /*
             * Returning back the html.
             */
            echo  $returner . $mt_op_html ;
        }
        
        /* fl_func Method ends here. */
        public function fl_display_tab_html()
        {
            $fl_ver = fl_fs()->is_premium();
            $fl_version = ( $fl_ver ? 'pro' : 'free' );
            /**
             * Getting main class
             */
            $floating_links = new Floating_Links();
            // echo "<pre>"; print_r($fl_version);exit();
            $fl_scroll_enabled = null;
            $fl_selected_pages = array();
            $fl_selected_pages_sec = array();
            $fl_selected_posts = array();
            $fl_selected_posts_sec = array();
            /*
             * Display Settings tab html.
             * fl_display_html filter can be used to customize skins tab html.
             */
            $fl_display_html = null;
            $fl_display_html .= '<div id="fl_display_tab" class="col s12 fl_display_tab fl_tab_content">

       						 <div class="fl_bars_holder">
					   	 		<ul>
					   	 		<li class="fl_bar_gen active fl_bar_prim" data-id="primary">' . __( 'Primary Bar', 'floating-links' ) . '</li>
					   	 		<li class="fl_bar_gen fl_bar_sec" data-id="secondary">' . __( 'Secondary Bar', 'floating-links' ) . '</li>
					   	 		</ul>
					   	 	</div>

        			<div class="fl_primary_content">	
					<h5>' . __( "Want to customize display settings of primary floating bar?", "floating-links" ) . '</h5>
					<p>' . __( 'No problem at all, You can easily customize display settings of floating bar below.', 'floating-links' ) . '</p><i class="material-icons fl_down pulse">arrow_downward</i>

					 <div class="fl_collapsible_wrap col s12 fl_display_wrap">	
						<ul id="fl_display_collapsible" class="collapsible" data-collapsible="expandable">

						 <li>
							<div class="collapsible-header"><i class="material-icons">toys</i>
							            <b>' . __( 'Navigate in same category', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">
						              <input ' . checked( 'true', $floating_links->get_fl_value( 'fl_cat' ), false ) . ' type="checkbox" id="fl_cat" data-option="fl_cat" class="fl_options">
		      					<label for="fl_cat">' . __( 'Enable', 'floating-links' ) . '</label>
		      				</div>     									
				            <p>' . __( 'Enable this option to navigate Floating Links in same category', 'floating-links' ) . '</p>
				            
				        </li>

				        <li>
							<div class="collapsible-header"><i class="material-icons">description</i>
							            <b>' . __( 'Enable post data', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">
						              <input ' . checked( 'true', $floating_links->get_fl_value( 'fl_post_data' ), false ) . ' type="checkbox" id="fl_post_data" data-option="fl_post_data" class="fl_options">
		      					<label for="fl_post_data">' . __( 'Enable', 'floating-links' ) . '</label>
		      				</div>     									
				            <p>' . __( 'Enable this option to show post data which displays on hover of next and previous icon.', 'floating-links' ) . '</p>
				            
				             <div class="fl_post_feat_img_holder_p ' . $fl_post_data_enabled . '">
				            	<h5>' . __( 'Featured Image', 'floating-links' ) . '</h5>
				            	<div class="fl_checkbox_holder col s12">';
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-feat-upgrade" id="fl_post_data_f_free">

								<label for="fl_post_data_f_free">' . __( 'Enable', 'floating-links' ) . '</label>';
            }
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to show post featured image on hover of next, previous and random icon.', 'floating-links' ) . '</p>

				            </div>

				            <h5>' . __( 'Post Date', 'floating-links' ) . '</h5>
				            	<div class="fl_checkbox_holder col s12">';
            $fl_display_html .= '<input ' . checked( 'true', $floating_links->get_fl_value( 'fl_post_data_date' ), false ) . ' type="checkbox" id="fl_post_data_date" data-option="fl_post_data_date" class="fl_options">
		      					<label for="fl_post_data_date">' . __( 'Enable', 'floating-links' ) . '</label>';
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to show post date on hover of next, previous and random icon.', 'floating-links' ) . '</p>

				            </div>
				        </li>

						<li>
							<div class="collapsible-header"><i class="material-icons">add</i>
							            <b>' . __( 'Hide on Load', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-minimized-upgrade" id="fl_mini_free">

								<label for="fl_mini_free">' . __( 'Enable', 'floating-links' ) . '</label>';
            }
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to make the floating bar minimized on page load.', 'floating-links' ) . '</p></div>
				        </li>
						
						<li>
							<div class="collapsible-header"><i class="material-icons">web</i>
							            <b>' . __( 'Show on % scroll from top.', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-scroll-upgrade" id="fl_scroll_free">

								<label for="fl_scroll_free">' . __( 'Enable', 'floating-links' ) . '</label>';
                $fl_scroll_enabled = null;
            }
            
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to display the floating bar after the page is scroll down. For example, after 70% of the page is scrolled down.', 'floating-links' ) . '</p>
				            <div class="fl_scroll_percent_wrap ' . $fl_scroll_enabled . '">
				            	<div class="input-field">
					            	<div class="fl_scroll_percent_field">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input id="fl_scrol_perc" type="number" disabled min="0" max="100">
							            <label for="fl_scrol_perc">' . __( 'Enter values in percentage', 'floating-links' ) . '</label>';
                $fl_scroll_enabled = null;
            }
            
            $fl_display_html .= '</div>    
					          </div>
				            </div>
				            </div>
				        </li>

				        <li>
							<div class="collapsible-header"><i class="material-icons">pages</i>
							            <b>' . __( 'Show on specific pages', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-page-upgrade" id="fl_page_free">

								<label for="fl_page_free">' . __( 'Enable', 'floating-links' ) . '</label>';
                $fl_pages_enabled = null;
            }
            
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to make the floating bar show on selected pages only. If a page is not checked, it would not show on all those pages. If no page is selected, it would not display on any page on your site.', 'floating-links' ) . '</p>
				            <div class="fl_pages_select_wrap ' . $fl_pages_enabled . '">
				            	<div class="input-field">
					            	<div class="fl_pages_select_field">';
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<select multiple id="fl_selected_p_free" disabled>
									      <option value="" disabled selected>' . __( 'Select Pages', 'floating-links' ) . '</option>
									    </select>';
            }
            $fl_display_html .= '</div>    
					          </div>
				            </div>
				            </div>
				        </li>

				         <li>
							<div class="collapsible-header"><i class="material-icons">pages</i>
							            <b>' . __( 'Show on specific posts', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-post-upgrade" id="fl_post_free">

								<label for="fl_post_free">' . __( 'Enable', 'floating-links' ) . '</label>';
                $fl_posts_enable = null;
            }
            
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to make the floating bar show on selected posts only. If a post is not checked, it would not show on all those posts. If no post is selected, it would not display on any post on your site', 'floating-links' ) . '</p>
				            <div class="fl_posts_select_wrap ' . $fl_posts_enable . '">
				            	<div class="input-field">
					            	<div class="fl_pages_select_field">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<select multiple id="fl_selected_po_free" disabled>
									      <option value="" disabled selected>' . __( 'Select Posts', 'floating-links' ) . '</option>
									    </select>';
                $fl_post_data_enable_sec = null;
            }
            
            $fl_display_html .= '</div>    
					          </div>
				            </div>
				            </div>
				        </li>

				        
					 	</ul>
					 </div>	
					</div>   
					<div class="fl_secondary_content">
					<h5>' . __( 'Want to customize display settings of secondary floating bar?', 'floating-links' ) . '</h5>
					<p>' . __( 'No problem at all, You can easily customize display settings of floating bar below.', 'floating-links' ) . '</p><i class="material-icons fl_down pulse">arrow_downward</i>

					 <div class="fl_collapsible_wrap col s12 fl_display_wrap">	
						<ul id="fl_display_collapsible" class="collapsible" data-collapsible="expandable">
						<li>
							<div class="collapsible-header"><i class="material-icons">toys</i>
							            <b>' . __( 'Navigate in same category', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">
						              <input ' . checked( 'true', $floating_links->get_fl_value()['fl_secondary']['fl_cat'], false ) . ' type="checkbox" id="fl_cat_secondary" data-option="fl_cat" data-bar="secondary" class="fl_options">
		      					<label for="fl_cat_secondary">' . __( 'Enable', 'floating-links' ) . '</label>
		      				</div>     									
				            <p>' . __( 'Enable this option to navigate Floating Links in same category', 'floating-links' ) . '</p>
				            
				        </li>

				         <li>
							<div class="collapsible-header"><i class="material-icons">description</i>
							            <b>' . __( 'Enable post data', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">
						              <input ' . checked( 'true', $floating_links->get_fl_value()['fl_secondary']['fl_post_data'], false ) . ' data-bar="secondary" type="checkbox" id="fl_post_data_sec" data-option="fl_post_data" class="fl_options">
		      					<label for="fl_post_data_sec">' . __( 'Enable', 'floating-links' ) . '</label>
		      				</div>     									
				            <p>' . __( 'Enable this option to show post data which displays on hover of next, previous and random icon.', 'floating-links' ) . '</p>

				            <div class="fl_post_feat_img_holder ' . $fl_post_data_enable_sec . '">
				            	<h5>' . __( 'Featured Image', 'floating-links' ) . '</h5>
				            	<div class="fl_checkbox_holder col s12">';
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-feat-upgrade" id="fl_post_data_f_free">

								<label for="fl_post_data_f_free">' . __( 'Enable', 'floating-links' ) . '</label>';
            }
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to show post featured image on hover of next, previous and random icon.', 'floating-links' ) . '</p>

				            </div>

				            <h5>' . __( 'Post Date', 'floating-links' ) . '</h5>
				            	<div class="fl_checkbox_holder col s12">';
            $fl_display_html .= '<input ' . checked( 'true', $floating_links->get_fl_value()['fl_secondary']['fl_post_data_date'], false ) . ' data-bar="secondary" type="checkbox" id="fl_post_data_date_sec" data-option="fl_post_data_date" class="fl_options">
		      					<label for="fl_post_data_date_sec">' . __( 'Enable', 'floating-links' ) . '</label>';
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to show post date on hover of next, previous and random icon.', 'floating-links' ) . '</p>

				            </div>
				            
				        </li>
						<li>
							<div class="collapsible-header"><i class="material-icons">add</i>
							            <b>' . __( 'Hide on Load', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-minimized-upgrade" id="fl_mini_free">

								<label for="fl_mini_free">' . __( 'Enable', 'floating-links' ) . '</label>';
            }
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to make the floating bar minimized on page load.', 'floating-links' ) . '</p></div>
				        </li>
						
						<li>
							<div class="collapsible-header"><i class="material-icons">web</i>
							            <b>' . __( 'Show on % scroll from top.', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-scroll-upgrade" id="fl_scroll_free">

								<label for="fl_scroll_free">' . __( 'Enable', 'floating-links' ) . '</label>';
                $fl_scroll_enabled_sec = null;
            }
            
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to display the floating bar after the page is scroll down. For example, after 70% of the page is scrolled down.', 'floating-links' ) . '</p>
				            <div class="fl_scroll_percent_wrap_sec  ' . $fl_scroll_enabled_sec . '">
				            	<div class="input-field">
					            	<div class="fl_scroll_percent_field">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input id="fl_scrol_perc" type="number" disabled min="0" max="100">
								            <label for="fl_scrol_perc">' . __( 'Enter values in percentage', 'floating-links' ) . '</label>';
                $fl_scroll_enabled = null;
            }
            
            $fl_display_html .= '</div>    
					          </div>
				            </div>
				            </div>
				        </li>

				        <li>
							<div class="collapsible-header"><i class="material-icons">pages</i>
							            <b>' . __( 'Show on specific pages', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-page-upgrade" id="fl_page_free">

								<label for="fl_page_free">' . __( 'Enable', 'floating-links' ) . '</label>';
                $fl_pages_enabled_sec = null;
            }
            
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to make the floating bar show on selected pages only. If a page is not checked, it would not show on all those pages. If no page is selected, it would not display on any page on your site.', 'floating-links' ) . '</p>
				            <div class="fl_pages_select_wrap_sec ' . $fl_pages_enabled_sec . '">
				            	<div class="input-field">
					            	<div class="fl_pages_select_field">';
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<select multiple id="fl_selected_p_free" disabled>
									      <option value="" disabled selected>' . __( 'Select Pages', 'floating-links' ) . '</option>
									    </select>';
            }
            $fl_display_html .= '</div>    
					          </div>
				            </div>
				            </div>
				        </li>

				         <li>
							<div class="collapsible-header"><i class="material-icons">pages</i>
							            <b>' . __( 'Show on specific posts', 'floating-links' ) . '</b>
							            </div>
							<div class="collapsible-body">
							<div class="fl_checkbox_holder col s12">';
            
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<input type="checkbox" class="modal-trigger" href="#fl-post-upgrade" id="fl_post_free">

								<label for="fl_post_free">' . __( 'Enable', 'floating-links' ) . '</label>';
                $fl_posts_enable_sec = null;
            }
            
            $fl_display_html .= '</div>     									
				            <p>' . __( 'Enable this option to make the floating bar show on selected posts only. If a post is not checked, it would not show on all those posts. If no post is selected, it would not display on any post on your site', 'floating-links' ) . '</p>
				            <div class="fl_posts_select_wrap_sec ' . $fl_posts_enable_sec . '">
				            	<div class="input-field">
					            	<div class="fl_pages_select_field">';
            if ( 'free' == $fl_version ) {
                $fl_display_html .= '<select multiple id="fl_selected_po_free" disabled>
									      <option value="" disabled selected>' . __( 'Select Posts', 'floating-links' ) . '</option>
									    </select>';
            }
            $fl_display_html .= '</div>    
					          </div>
				            </div>
				            </div>
				        </li>

				         
					 	</ul>
					</div> 
					</div>   	 	
				</div>';
            return $fl_display_html = apply_filters( 'fl_display_html', $fl_display_html );
        }
        
        public function fl_design_tab_html()
        {
            /*
             * Getting recent posts.
             */
            $recent_posts = wp_get_recent_posts( array(
                'posts_per_page' => 1,
            ) );
            /*
             * Getting first post from object's URL.
             */
            $first_post_url = get_permalink( $recent_posts['0']['ID'] );
            /*
             * Encoding URL.
             */
            $c_post_url = urlencode( $first_post_url );
            /*
             * Making the customizer area URL.
             */
            $c_post_url_sec = 'customize.php?url=' . $c_post_url . '&autofocus[panel]=fl_customizer_panel&fl_bar=secondary';
            /*
             * Making the customizer area URL.
             */
            $c_post_url = 'customize.php?url=' . $c_post_url . '&autofocus[panel]=fl_customizer_panel&fl_bar=primary';
            /*
             * Display Design tab html.
             * fl_design_tab_html filter can be used to customize skins tab html.
             */
            $fl_design_tab_html = null;
            $fl_design_tab_html .= sprintf(
                '<div id="fl_design_tab" class="col s12 fl_design_tab fl_tab_content">	
  	 				<div class="col s12 m5">
				    <div class="card horizontal">
				      <div class="card-stacked">
				        <div class="card-content">
				        <h5>%1$s</h5>
				         <p>%9$s</p>
				          <p>%2$s</p>
				        </div>
				        <div class="card-action">
				          <a href="%4$s">%3$s</a>
				        </div>
				      </div>
				    </div>
				  </div>

				  <div class="col s12 m5">
				    <div class="card horizontal">
				      <div class="card-stacked">
				        <div class="card-content">
				        <h5>%5$s</h5>
				        <p>%9$s</p>
				          <p>%6$s</p>
				        </div>
				        <div class="card-action">
				          <a href="%8$s">%7$s</a>
				        </div>
				      </div>
				    </div>
				  </div>
				</div>',
                /* Variables starts here. */
                __( "Primary Bar", 'floating-links' ),
                __( "No worries, you can change the design, colours, backgrounds, select icons and also select different position of the bar. All can be done in the real time. Yesss!", 'floating-links' ),
                __( "Take me there", 'floating-links' ),
                admin_url( $c_post_url ),
                __( "Secondary Bar", 'floating-links' ),
                __( "No worries, you can change the design, colours, backgrounds, select icons and also select different position of the bar. All can be done in the real time. Yesss!", 'floating-links' ),
                __( "Take me there", 'floating-links' ),
                admin_url( $c_post_url_sec ),
                __( "Want to change the look and feel of the icons?", 'floating-links' )
            );
            return $fl_design_tab_html = apply_filters( 'fl_design_tab_html', $fl_design_tab_html );
        }
        
        /*
         * Save Floating Links icon option value
         */
        public function fl_save_values()
        {
            /* Saving ajax value in variable. */
            $fl_value = $_POST['fl_value'];
            $fl_option = $_POST['fl_option'];
            $fl_bar = $_POST['fl_bar'];
            $fl_settings = get_option( 'fl_settings', false );
            
            if ( 'secondary' == $fl_bar ) {
                $fl_settings['fl_secondary'][$fl_option] = $fl_value;
            } else {
                $fl_settings[$fl_option] = $fl_value;
            }
            
            /*
             * Saving value in wp options table.
             */
            $fl_saved = update_option( 'fl_settings', $fl_settings );
            /*
             * Checking if option is saved successfully.
             */
            
            if ( isset( $fl_saved ) ) {
                /*
                 * Return success message and die.
                 */
                echo  wp_send_json_success( __( 'Successfully Updated', 'floating-links' ) ) ;
                die;
            } else {
                /*
                 * Return error message and die.
                 */
                echo  wp_send_json_error( __( 'Something went wrong', 'floating-links' ) ) ;
                die;
            }
        
        }
        
        /* fl_save_values Method ends here. */
        /*
         * Save Floating Links icon position
         */
        public function fl_save_sort()
        {
        }
        
        /* fl_save_sort Method ends here. */
        /**
         * Display a thank you nag when the plugin has been installed/upgraded.
         */
        public function fl_admin_notice()
        {
            if ( !current_user_can( 'install_plugins' ) ) {
                return;
            }
            $floating_links = new Floating_Links();
            $install_date = $floating_links->get_fl_value( 'fl_installDate' );
            $display_date = date( 'Y-m-d h:i:s' );
            $datetime1 = new DateTime( $install_date );
            $datetime2 = new DateTime( $display_date );
            $diff_intrval = round( ($datetime2->format( 'U' ) - $datetime1->format( 'U' )) / (60 * 60 * 24) );
            
            if ( $diff_intrval >= 6 && get_site_option( 'fl_supported' ) != "yes" ) {
                $html = sprintf(
                    '<div class="update-nag fl_msg fl_review">
					    <p>%s<b>%s</b>%s</p>
					    <p>%s<b>%s</b>%s</p>
					    <p>%s</p>
					    <p>%s</p>
					   ~Danish Ali Malik (@danish-ali)
					   <div class="fl_support_btns">
					<a href="https://wordpress.org/support/plugin/floating-links/reviews/?filter=5#new-post" class="fl_HideRating button button-primary" target="_blank">
						%s	
					</a>
					<a href="javascript:void(0);" class="fl_HideRating button" >
					%s	
					</a>
					<br>
					<a href="javascript:void(0);" class="fl_HideRating" >
					%s	
					</a>
					    </div>
					    </div>',
                    __( 'Awesome, you have been using ', 'floating-links' ),
                    __( 'Floating Links ', 'floating-links' ),
                    __( 'for more than 1 week.', 'floating-links' ),
                    __( 'May I ask you to give it a ', 'floating-links' ),
                    __( '5-star ', 'floating-links' ),
                    __( 'rating on Wordpress? ', 'floating-links' ),
                    __( 'This will help to spread its popularity and to make this plugin a better one.', 'floating-links' ),
                    __( 'Your help is much appreciated. Thank you very much. ', 'floating-links' ),
                    __( 'I Like Floating Links - It increased engagement on my site', 'floating-links' ),
                    __( 'I already rated it', 'floating-links' ),
                    __( 'No, not good enough, I do not like to rate it', 'floating-links' )
                );
                $script = ' <script>
			    jQuery( document ).ready(function( $ ) {

			    jQuery(\'.fl_HideRating\').click(function(){
			       var data={\'action\':\'fl_supported\'}
			             jQuery.ajax({
			        
			        url: "' . admin_url( 'admin-ajax.php' ) . '",
			        type: "post",
			        data: data,
			        dataType: "json",
			        async: !0,
			        success: function(e ) {
			        	
			            if (e=="success") {
			             	jQuery(\'.fl_msg.fl_review\').slideUp(\'fast\');
						   
			            }
			        }
			         });
			        })
			    
			    });
    </script>';
                echo  $html . $script ;
            }
            
            
            if ( $diff_intrval >= 7 && get_site_option( 'fl_hide_up' ) != "yes" ) {
                global  $fl_fs ;
                $fl_upgrade_url = $fl_fs->get_upgrade_url();
                $up_html = sprintf(
                    '<div class="update-nag fl_msg fl_up_msg">
					    <p>%s</p>
					    <a href="%s" class="button button-primary fl_up">%s</a>
					    <div class="dashicons dashicons-no-alt fl_hide_up"></div>
					    </div>',
                    __( 'Need more features? Upgrade to pro version to unlock all the pro plan features. See a full list of plan features here. ', 'floating-links' ),
                    $fl_upgrade_url,
                    __( 'Upgrade to pro', 'floating-links' ),
                    __( 'May I ask you to give it a ', 'floating-links' ),
                    __( '5-star ', 'floating-links' ),
                    __( 'rating on Wordpress? ', 'floating-links' ),
                    __( 'This will help to spread its popularity and to make this plugin a better one.', 'floating-links' ),
                    __( 'Your help is much appreciated. Thank you very much. ', 'floating-links' ),
                    __( 'I Like Floating Links - It increased engagement on my site', 'floating-links' ),
                    __( 'I already rated it', 'floating-links' ),
                    __( 'No, not good enough, I do not like to rate it', 'floating-links' )
                );
                $up_script = ' <script>
			    jQuery( document ).ready(function( $ ) {

			    jQuery(\'.fl_hide_up\').click(function(){
	
			       var data={\'action\':\'fl_hide_up\'}
			             jQuery.ajax({
			        
			        url: "' . admin_url( 'admin-ajax.php' ) . '",
			        type: "post",
			        data: data,
			        dataType: "json",
			        async: !0,
			        success: function(e ) {
			        	
			            if (e=="success") {
			             	jQuery(\'.fl_msg.fl_up_msg\').slideUp(\'fast\');
						   
			            }
			        }
			         });
			        })
			    
			    });
    </script>';
                echo  $up_html . $up_script ;
            }
        
        }
        
        /* fl_admin_notice Method ends here. */
        /**
         * Save the notice closed option.
         */
        public function fl_supported_func()
        {
            update_site_option( 'fl_supported', 'yes' );
            echo  json_encode( array( "success" ) ) ;
            exit;
        }
        
        /* fl_supported_func Method ends here. */
        /**
         * Save the notice closed option.
         */
        public function fl_hide_up()
        {
            update_site_option( 'fl_hide_up', 'yes' );
            echo  json_encode( array( "success" ) ) ;
            exit;
        }
        
        /* fl_supported_func Method ends here. */
        /**
         * Holds primary Icons
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
            $fl_icons_array = array(
                'fl_next'      => array(
                'id'           => 'fl_next',
                'icon'         => 'arrow_forward',
                'title'        => 'Next',
                'label'        => __( 'Next Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_next' ),
                'is_dependent' => false,
            ),
                'fl_prev'      => array(
                'id'           => 'fl_prev',
                'title'        => 'Previous',
                'icon'         => 'arrow_back',
                'label'        => __( 'Previous Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_prev' ),
                'is_dependent' => false,
            ),
                'fl_random'    => array(
                'id'           => 'fl_random',
                'title'        => 'Random',
                'icon'         => 'repeat',
                'label'        => __( 'Random Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_random' ),
                'is_dependent' => false,
            ),
                'fl_top'       => array(
                'id'           => 'fl_top',
                'icon'         => 'arrow_upward',
                'title'        => 'Top',
                'label'        => __( 'To Top Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_top' ),
                'is_dependent' => true,
            ),
                'fl_bottom'    => array(
                'id'           => 'fl_bottom',
                'title'        => 'Bottom',
                'icon'         => 'arrow_downward',
                'label'        => __( 'To Bottom Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_bottom' ),
                'is_dependent' => true,
            ),
                'fl_home'      => array(
                'id'           => 'fl_home',
                'icon'         => 'home',
                'title'        => 'Home',
                'label'        => __( 'Home Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_home' ),
                'is_dependent' => true,
            ),
                'fl_copy_url'  => array(
                'id'           => 'fl_copy_url',
                'icon'         => 'content_copy',
                'title'        => 'Next',
                'label'        => __( 'Copy Current URL', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_copy_url' ),
                'is_dependent' => true,
            ),
                'fl_cat'       => array(
                'id'           => 'fl_cat',
                'icon'         => 'toys',
                'title'        => 'Category',
                'label'        => __( 'Navigate in same category', 'floating-links' ),
                'value'        => $floating_links->get_fl_value( 'fl_cat' ),
                'is_dependent' => false,
            ),
                'fl_minimizer' => array(
                'id'              => 'fl_minimizer',
                'icon'            => 'close',
                'title'           => 'Minimizer',
                'label'           => __( 'Enable Minimizer', 'floating-links' ),
                'value'           => $floating_links->get_fl_value( 'fl_minimizer' ),
                'is_dependent'    => false,
                'minimized_value' => $floating_links->get_fl_value( 'fl_default_minimized' ),
            ),
                'fl_post_data' => array(
                'id'    => 'fl_post_data',
                'icon'  => 'description',
                'title' => 'Post Data',
                'label' => __( 'Enable post data', 'floating-links' ),
                'value' => $floating_links->get_fl_value( 'fl_post_data' ),
            ),
            );
            /**
             * Filter to add more items in primary bar
             */
            return $fl_icons_array = apply_filters( 'fl_primary_items', $fl_icons_array );
        }
        
        /* fl_primary_icons Method ends here. */
        public function fl_primary_icons_html()
        {
            /**
             * Getting main class
             */
            $floating_links = new Floating_Links();
            $fl_ver = fl_fs()->is_premium();
            $fl_version = ( $fl_ver ? 'pro' : 'free' );
            /**
             * Getting primary sorted
             */
            $fl_primary_sort = $floating_links->get_fl_value( 'fl_sort' );
            /**
             * Exploding the sorting 
             */
            $fl_primary_sort = explode( ",", $fl_primary_sort );
            if ( 'free' == $fl_version ) {
                $fl_drag_drop_icon = '<i class="drag_drop material-icons tooltipped modal-trigger" href="#fl-drag-drop-upgrade" data-position="bottom"  data-tooltip="' . __( 'Reorder', 'floating-links' ) . '">reorder</i>';
            }
            $returner = null;
            /**
             * Showing items according to sorting
             */
            if ( $fl_primary_sort ) {
                foreach ( $fl_primary_sort as $fl_primary_sort_single ) {
                    $fl_icons_array = $this->fl_primary_icons();
                    $fl_primary_icon = $fl_icons_array[$fl_primary_sort_single];
                    // echo "<pre>"; print_r($fl_primary_icon);exit();
                    $fl_primary_icon_value = $fl_primary_icon['value'];
                    $returner .= '<li class="ui-state-default" id="' . $fl_primary_icon['id'] . '">
					<div class="collapsible-header">' . $fl_drag_drop_icon . '<i class="material-icons">' . $fl_primary_icon['icon'] . '</i>
					            <b>' . $fl_primary_icon['label'] . '</b>
					            </div>
					<div class="collapsible-body" style="display: none;">';
                    $returner .= '<div class="fl_checkbox_holder col s12">
				              <input ' . checked( 'true', $fl_primary_icon_value, false ) . ' type="checkbox" id="' . $fl_primary_icon['id'] . '_icon" data-option="' . $fl_primary_icon['id'] . '" class="fl_options"/>
      					<label for="' . $fl_primary_icon['id'] . '_icon">' . __( 'Enable', 'floating-links' ) . '</label>
      				</div>
      									
				            <p>' . __( 'Enable this option to show ' . $fl_primary_icon['title'] . ' icon.', 'floating-links' ) . '</p>';
                    /**
                     * If item depend on posts and pages
                     */
                    if ( $fl_primary_icon['is_dependent'] ) {
                        $returner .= '<h5>' . __( 'Show On Posts / Pages (Deprecated)', 'floating-links' ) . ' </h5>
      									
				        <p>' . __( 'This option is deprecated but you can select specific pages and posts to show floating bar from display settings page.', 'floating-links' ) . '</p>';
                    }
                    $returner .= '</div>
				          </li>';
                }
            }
            /**
             * Returning back the HTML
             */
            return $returner;
        }
        
        /* fl_primary_icons_html Method ends here. */
        /**
         * Holds primary Icons
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
            $fl_icons_array = array(
                'fl_next'      => array(
                'id'           => 'fl_next',
                'icon'         => 'arrow_forward',
                'title'        => 'Next',
                'label'        => __( 'Next Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_next'],
                'is_dependent' => false,
            ),
                'fl_prev'      => array(
                'id'           => 'fl_prev',
                'title'        => 'Previous',
                'icon'         => 'arrow_back',
                'label'        => __( 'Previous Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_prev'],
                'is_dependent' => false,
            ),
                'fl_random'    => array(
                'id'           => 'fl_random',
                'title'        => 'Random',
                'icon'         => 'repeat',
                'label'        => __( 'Random Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_random'],
                'is_dependent' => false,
            ),
                'fl_top'       => array(
                'id'           => 'fl_top',
                'icon'         => 'arrow_upward',
                'title'        => 'Top',
                'label'        => __( 'To Top Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_top'],
                'is_dependent' => true,
            ),
                'fl_bottom'    => array(
                'id'           => 'fl_bottom',
                'title'        => 'Bottom',
                'icon'         => 'arrow_downward',
                'label'        => __( 'To Bottom Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_bottom'],
                'is_dependent' => true,
            ),
                'fl_home'      => array(
                'id'           => 'fl_home',
                'icon'         => 'home',
                'title'        => 'Home',
                'label'        => __( 'Home Icon', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_home'],
                'is_dependent' => true,
            ),
                'fl_copy_url'  => array(
                'id'           => 'fl_copy_url',
                'icon'         => 'content_copy',
                'title'        => 'Next',
                'label'        => __( 'Copy Current URL', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_copy_url'],
                'is_dependent' => true,
            ),
                'fl_cat'       => array(
                'id'           => 'fl_cat',
                'icon'         => 'toys',
                'title'        => 'Category',
                'label'        => __( 'Navigate in same category', 'floating-links' ),
                'value'        => $floating_links->get_fl_value()['fl_secondary']['fl_cat'],
                'is_dependent' => false,
            ),
                'fl_minimizer' => array(
                'id'              => 'fl_minimizer',
                'icon'            => 'close',
                'title'           => 'Minimizer',
                'label'           => __( 'Enable Minimizer', 'floating-links' ),
                'value'           => $floating_links->get_fl_value()['fl_secondary']['fl_minimizer'],
                'is_dependent'    => false,
                'minimized_value' => $floating_links->get_fl_value()['fl_secondary']['fl_default_minimized'],
            ),
                'fl_post_data' => array(
                'id'    => 'fl_post_data',
                'icon'  => 'description',
                'title' => 'Post Data',
                'label' => __( 'Enable post data', 'floating-links' ),
                'value' => $floating_links->get_fl_value()['fl_secondary']['fl_post_data'],
            ),
            );
            /**
             * Filter to add more items in primary bar
             */
            return $fl_icons_array = apply_filters( 'fl_secondary_items', $fl_icons_array );
        }
        
        /* fl_secondary_icons Method ends here. */
        /**
         * Returning back the HTML of secondary items
         */
        public function fl_secondary_icons_html()
        {
            /**
             * Getting main class
             */
            $floating_links = new Floating_Links();
            $fl_ver = fl_fs()->is_premium();
            $fl_version = ( $fl_ver ? 'pro' : 'free' );
            /**
             * Getting primary sorted
             */
            $fl_secondary_sort = $floating_links->get_fl_value()['fl_secondary']['fl_sort'];
            /**
             * Exploding the sorting 
             */
            $fl_secondary_sort = explode( ",", $fl_secondary_sort );
            if ( 'free' == $fl_version ) {
                $fl_drag_drop_icon = '<i class="drag_drop material-icons tooltipped modal-trigger" href="#fl-drag-drop-upgrade" data-position="bottom"  data-tooltip="' . __( 'Reorder', 'floating-links' ) . '">reorder</i>';
            }
            /**
             * Showing items according to sorting
             */
            $returner = null;
            if ( $fl_secondary_sort ) {
                foreach ( $fl_secondary_sort as $fl_secondary_sort_single ) {
                    $fl_icons_array = $this->fl_secondary_icons();
                    $fl_primary_icon = $fl_icons_array[$fl_secondary_sort_single];
                    // echo "<pre>"; print_r($fl_primary_icon['value']);exit();
                    $fl_primary_icon_value = $fl_primary_icon['value'];
                    $returner .= '<li class="ui-state-default" id="' . $fl_primary_icon['id'] . '">
					<div class="collapsible-header">' . $fl_drag_drop_icon . '<i class="material-icons">' . $fl_primary_icon['icon'] . '</i>
					            <b>' . $fl_primary_icon['label'] . '</b>
					            </div>
					<div class="collapsible-body" style="display: none;">';
                    $returner .= '<div class="fl_checkbox_holder col s12">
				              <input ' . checked( 'true', $fl_primary_icon_value, false ) . ' type="checkbox" id="' . $fl_primary_icon['id'] . '_icon_secondary" data-option="' . $fl_primary_icon['id'] . '" data-bar="secondary" class="fl_options"/>
      					<label for="' . $fl_primary_icon['id'] . '_icon_secondary">' . __( 'Enable', 'floating-links' ) . '</label>
      				</div>
      									
				            <p>' . __( 'Enable this option to show ' . $fl_primary_icon['title'] . ' icon.', 'floating-links' ) . '</p>';
                    /**
                     * If item depend on posts and pages
                     */
                    if ( $fl_primary_icon['is_dependent'] ) {
                        $returner .= '<h5>' . __( 'Show On Posts / Pages (Deprecated)', 'floating-links' ) . ' </h5>
      									
				        <p>' . __( 'This option is deprecated but you can select specific pages and posts to show floating bar from display settings page.', 'floating-links' ) . '</p>';
                    }
                    $returner .= '</div>
				          </li>';
                }
            }
            /**
             * Returning back the HTML
             */
            return $returner;
        }
    
    }
    $Floating_Links_Admin = new Floating_Links_Admin();
}
