<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

								//======================================================================
													// Floating links Customizer Class 
								//======================================================================
if(!class_exists('FLOATING_LINKS_CUSTOMIZER')):
class FLOATING_LINKS_CUSTOMIZER {

		/*
		* __construct initialize all function of this class.
		* Returns nothing. 
		* Used action_hooks to get things sequentially.
		*/ 
		function __construct(){

			/*
			* Will register settings and panel in cutomizer.
			*/ 
			add_action( 'customize_register', array ($this , 'fl_customizer' )); 
			
			/*
			* Print css in wp head.
			*/	
			add_action( 'wp_head', array($this, 'fl_customizer_css') );

			/*
			* Will enqueue scripts and css in customizer in cutomizer.
			*/ 
			add_action( 'customize_controls_enqueue_scripts', array ($this , 'fl_customizer_files' ) );
			
			/*
			* Load file on previewing in cutomizer.
			*/
			add_action( 'customize_preview_init', array ($this ,'fl_live_preview'));	

		}/* __construct Method ends here. */

								
		/*
		* fl_customizer Will register settings and panel in cutomizer.
		*/ 
		function fl_customizer( $wp_customize ) {

			if ( isset( $_GET['fl_bar'] ) ) {
            $skin_id = $_GET['fl_bar'];
            update_option( 'fl_bar', $skin_id );
        }
        
        /* Getting back the skin saved ID.*/
        $fl_bar = get_option( 'fl_bar', false );

			$setting = "fl_settings";

			if(isset($fl_bar) && 'secondary' == $fl_bar) $setting = "fl_settings[fl_secondary]";

			
			/*
			* Adding panel in customizer.
			*/ 
			$wp_customize->add_panel( 'fl_customizer_panel', array(
					'capability' => null,
					'priority'	=> 160,
					'theme_supports' => null,
					'title' => __( 'Floating Links Settings', 'floating-links' )
							
			) );

			/*
			* Adding icons section in panel.
			*/ 
			$wp_customize->add_section( 'fl_icons_section', array(
					'title' => __( 'Change icons ', 'floating-links' ),
					'description' => __('Chose any icon from the list below and see the magic live.', 'floating-links'),
					'priority' => 160,
					'panel' => 'fl_customizer_panel',	
						
			));

			/*
			* Adding desgin section in panel.
			*/		
			$wp_customize->add_section( 'fl_design_section', array(
					'title' => __( 'Design', 'floating-links' ),
					'description' => __('Customize design of your fancy floating links live.', 'floating-links'),
					'priority' => 160,
					'panel' => 'fl_customizer_panel'	
						
			));

			/*
			* Adding position section in panel.
			*/	
			$wp_customize->add_section( 'fl_position_section', array(
					'title' => __( 'Change position', 'floating-links' ),
					'description' => __('Show Floating Links on left, right, top and bottom side.', 'floating-links'),
					'priority' => 160,
					'panel' => 'fl_customizer_panel'	
						
			));



			  // echo "<pre>"; print_r($setting);exit();
			/*
			* Adding position setting.
			*/
			$wp_customize->add_setting( $setting.'[fl_position]', array(
					'default' => 'right',
					'transport' => 'postMessage',
					'type' => 'option'
						
			));
				
			/*
			* Adding position control.
			*/	
			$wp_customize->add_control( $setting.'[fl_position]', array(
				   'type' => 'radio',
				   'section' => 'fl_position_section', // Add a default or your own section
				   'label' => __( 'Position', 'floating-links'),
				   'choices' => array(
				    'left' => __( 'Left Center', 'floating-links'),
				    'left_top' => __( 'Left Top', 'floating-links'),
				    'left_bottom' => __( 'Left Bottom', 'floating-links'),
				    'right' => __( 'Right Center', 'floating-links'),
				    'right_top' => __( 'Right Top', 'floating-links'),
				    'right_bottom' => __( 'Right Bottom', 'floating-links'),
				    'top' => __( 'Top Center', 'floating-links'),
				    'top_left' => __( 'Top Left', 'floating-links'),
				    'top_right' => __( 'Top Right', 'floating-links'),
				    'bottom' => __( 'Bottom Center', 'floating-links'),
				    'bottom_left' => __( 'Bottom Left', 'floating-links'),
				    'bottom_right' => __( 'Bottom Right', 'floating-links')
				  ),
			) );

			/*
			* Adding background color setting.
			*/
			$wp_customize->add_setting($setting.'[fl_bg_color]', array(
					'default' => '#fff',
					'transport' => 'postMessage',
					'type' => 'option'
						
			));

			/*
			* Adding background color control.
			*/	
			$wp_customize->add_control( new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_bg_color]',
					$this->cutomizer_values(__( 'Background color', 'floating-links'), 'fl_design_section', $setting.'[fl_bg_color]', null)
					
			));

			/*
			* Adding color setting.
			*/
			$wp_customize->add_setting( $setting.'[fl_color]', array(
					'default' => '#000',
					'transport' => 'postMessage',
					'type' => 'option'
						
			));
			
			/*
			* Adding color control.
			*/	
			$wp_customize->add_control( new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_color]',
					$this->cutomizer_values(__( 'Icons color', 'floating-links'), 'fl_design_section', $setting.'[fl_color]', null)
				
			));

			/*
			* Adding icon hover color setting.
			*/
			$wp_customize->add_setting(
					$setting.'[fl_icon_hover_color]',
					array(
						'default' => '#fff',
						'transport' => 'postMessage',
						'type' => 'option'
						
			));	
			
			/*
			* Adding icon hover color control.
			*/	
			$wp_customize->add_control( new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_icon_hover_color]',
					$this->cutomizer_values(__( 'Icons hover color', 'floating-links'), 'fl_design_section', $setting.'[fl_icon_hover_color]', null)
			
			));
		
			/*
			* Adding icon hover background color setting.
			*/
			$wp_customize->add_setting( $setting.'[fl_hover_bg_color]', array(
					'default' => '#000',
					'transport' => 'postMessage',
					'type' => 'option'
						
			));
				
			/*
			* Adding icon hover background color control.
			*/	
			$wp_customize->add_control( new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_hover_bg_color]',
					$this->cutomizer_values(__( 'Icons hover background color.', 'floating-links'), 'fl_design_section', $setting.'[fl_hover_bg_color]', null)
				 
			));
			
			/*
			* Adding icon size setting.
			*/		
			$wp_customize->add_setting( $setting.'[fl_icon_size]', array(
					'default' => '18',
					'transport' => 'postMessage',
					'type' => 'option'
						
			));

			/*
			* Adding icon size control.
			*/	
			$wp_customize->add_control( new WP_Customize_Range_Control(
					$wp_customize,
					$setting.'[fl_icon_size]',
					 array(
						'label'       => __('Icons size.','floating-links'),
						'section'     => 'fl_design_section',
						'settings'    => $setting.'[fl_icon_size]',
						'input_attrs' => array(
						'max' => 100,
						),)
			 ));
			
			/*
			* Adding icon seprator color setting.
			*/
			$wp_customize->add_setting( $setting.'[fl_seprator_color]', array(
					'default' => '#000',
					'transport' => 'postMessage',
					'type' => 'option'
						
			));
			
			/*
			* Adding icon seprator color control.
			*/	
			$wp_customize->add_control(new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_seprator_color]',
					$this->cutomizer_values(__( 'Icons separator color.', 'floating-links'), 'fl_design_section', $setting.'[fl_seprator_color]', null)
			
			));

			

			/*
			* Adding shadow setting.
			*/
			$wp_customize->add_setting( $setting.'[fl_shadow]', array(
					'default' => '1',
					'transport' => 'postMessage',
					'type' => 'option'
						
			));

			/*
			* Adding shadow control.
			*/
			$wp_customize->add_control(
					$setting.'[fl_shadow]',
					$this->cutomizer_values(__( 'Enable shadow', 'floating-links'), 'fl_design_section', $setting.'[fl_shadow]', 'checkbox')
			
			);

			/*
			* Adding Hover Post data background Color.
			*/
			$wp_customize->add_setting( $setting.'[fl_hover_post_bg_color]', array(
					'default' => '#fff',
					'transport' => 'postMessage',
					'type' => 'option'
						
			)); 
			
			/*
			* Adding Hover Post data background Color control.
			*/	
			$wp_customize->add_control(new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_hover_post_bg_color]',
					$this->cutomizer_values(__( 'Hover post data background color.', 'floating-links'), 'fl_design_section', $setting.'[fl_hover_post_bg_color]', null)
			
			));

			/*
			* Adding Hover Post data Color.
			*/
			$wp_customize->add_setting( $setting.'[fl_hover_post_headings_color]', array(
					'default' => '#000',
					'transport' => 'postMessage',
					'type' => 'option'
						
			)); 
			
			/*
			* Adding Hover Post data background Color control.
			*/	
			$wp_customize->add_control(new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_hover_post_headings_color]',
					$this->cutomizer_values(__( 'Hover post data headings color.', 'floating-links'), 'fl_design_section', $setting.'[fl_hover_post_headings_color]', null)
			
			));

			/*
			* Adding Hover Post data Color.
			*/
			$wp_customize->add_setting( $setting.'[fl_hover_post_color]', array(
					'default' => '#000',
					'transport' => 'postMessage',
					'type' => 'option'
						
			)); 
			
			/*
			* Adding Hover Post data Color control.
			*/	
			$wp_customize->add_control(new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_hover_post_color]',
					$this->cutomizer_values(__( 'Hover post data text color.', 'floating-links'), 'fl_design_section', $setting.'[fl_hover_post_color]', null)
			
			));

			/*
			* Adding Hover Post data Color.
			*/
			$wp_customize->add_setting( $setting.'[fl_hover_post_seprator_color]', array(
					'default' => '#000',
					'transport' => 'postMessage',
					'type' => 'option'
						
			)); 
			
			/*
			* Adding Hover Post data Color control.
			*/	
			$wp_customize->add_control(new WP_Customize_Color_Control(
					$wp_customize, 
					$setting.'[fl_hover_post_seprator_color]',
					$this->cutomizer_values(__( 'Hover post data seprator color.', 'floating-links'), 'fl_design_section', $setting.'[fl_hover_post_seprator_color]', null)
			
			));


			/*
			* Making array of left icons to show in customizer.
			* Filter fl_left_icons used to add any custom icons to it.
			*/	
			$iconsleft = apply_filters ( 'fl_left_icons', array('dashicons dashicons-arrow-left-alt',
				'dashicons dashicons-arrow-left-alt2',
				'angle-left',
				'arrow-circle-left',
				'arrow-circle-o-left',
				'arrow-left',
				'caret-left',
				'caret-square-o-left',
				'chevron-circle-left',
				'chevron-left',
				'hand-o-left',
				'long-arrow-left'

			));									

			/*
			* adding left icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_left_icon]', array('transport' => 'postMessage','type' => 'option') );

			/*
			* adding left icons control.
			*/	
			$wp_customize->add_control(new Fl_Icons_Control(
				$wp_customize, $setting.'[fl_left_icon]', array(
				'section' => 'fl_icons_section',
				'label' => __( 'Select left icon.', 'floating-links' ),
				'type' => 'radio',
				'choices' => $iconsleft,

			) ) );


			/*
			* Making array of right icons to show in customizer.
			* Filter fl_right_icons used to add any custom icons to it.
			*/		
			$iconsright = apply_filters('fl_right_icons',array('dashicons dashicons-arrow-right-alt',
				'dashicons dashicons-arrow-right-alt2',
				'angle-right',
				'arrow-circle-right',
				'arrow-circle-o-right',
				'arrow-right',
				'caret-right',
				'caret-square-o-right',
				'chevron-circle-right',
				'chevron-right',
				'hand-o-right',
				'long-arrow-right'

			));							
			
			/*
			* adding right icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_right_icon]', array('transport' => 'postMessage','type' => 'option') );
			
			/*
			* adding right icons control.
			*/	
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_right_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
				'label' => __( 'Select right icon.', 'floating-links' ),
		    	'type' => 'radio',
		    	'choices' => $iconsright,
			)));
				
			/*
			* Making array of random icons to show in customizer.
			* Filter fl_random_icons used to add any custom icons to it.
			*/	
			$iconsrandom = apply_filters('fl_random_icons', array('dashicons dashicons-randomize', 'random'));

			/*
			* adding random icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_random_icon]', array('transport' => 'postMessage','type' => 'option') );
			
			/*
			* adding random icons control.
			*/	
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_random_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
				'label' => __( 'Select Random icon.', 'floating-links' ),
				'type' => 'radio',
				'choices' => $iconsrandom,

			)));
			
			/*
			* Making array of up icons to show in customizer.
			* Filter fl_up_icons used to add any custom icons to it.
			*/	
			$iconsup = apply_filters ('fl_up_icons', array('dashicons dashicons-arrow-up-alt',
				'dashicons dashicons-arrow-up-alt2',
				'angle-up',
				'arrow-circle-up',
				'arrow-circle-o-up',
				'arrow-up',
				'caret-up',
				'caret-square-o-up',
				'chevron-circle-up',
				'chevron-up','hand-o-up','long-arrow-up'
			));

			/*
			* adding up icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_up_icon]', array('transport' => 'postMessage','type' => 'option') );

			/*
			* adding up icons control.
			*/	
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_up_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
			    'label' => __( 'Select up icon.', 'floating-links' ),
			    'type' => 'radio',
				'choices' => $iconsup,

			)));	

			/*
			* Making array of down icons to show in customizer.
			* Filter fl_down_icons used to add any custom icons to it.
			*/		
			$iconsdown = apply_filters ('fl_down_icons', array('dashicons dashicons-arrow-down-alt',
				'dashicons dashicons-arrow-down-alt2',
				'angle-down',
				'arrow-circle-down',
				'arrow-circle-o-down',
				'arrow-down',
				'caret-down',
				'caret-square-o-down',
				'chevron-circle-down',
				'chevron-down',
				'hand-o-down',
				'long-arrow-down'

			));

			/*
			* adding down icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_down_icon]', array('transport' => 'postMessage','type' => 'option') );
			
			/*
			* adding down icons control.
			*/	 
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_down_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
				'label' => __( 'Select down icon.', 'floating-links' ),
				'type' => 'radio',
				'choices' => $iconsdown,

			)));	

			/*
			* Making array of home icons to show in customizer.
			* Filter fl_home_icons used to add any custom icons to it.
			*/		
			$iconshome = apply_filters ('fl_home_icons', array('dashicons dashicons-admin-home',
				'dashicons dashicons-store',
				'home',
				'h-square',
				'bank'

			));

			/*
			* adding down icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_home_icon]', array('transport' => 'postMessage','type' => 'option') );
			
			/*
			* adding down icons control.
			*/	 
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_home_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
				'label' => __( 'Select home icon.', 'floating-links' ),
				'type' => 'radio',
				'choices' => $iconshome,

			)));	

			/*
			* Making array of Copy URL icons to show in customizer.
			* Filter fl_copy_url_icons used to add any custom icons to it.
			*/		
			$icons_copy_url = apply_filters ('fl_copy_url_icons', array('dashicons dashicons-admin-page',
				'files-o',
				'clone',
				'clipboard'

			));

			/*
			* adding down icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_copy_url_icon]', array('transport' => 'postMessage','type' => 'option') );
			
			/*
			* adding down icons control.
			*/	 
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_copy_url_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
				'label' => __( 'Select copy URL icon.', 'floating-links' ),
				'type' => 'radio',
				'choices' => $icons_copy_url,

			)));	

			/*
			* Making array of down icons to show in customizer.
			* Filter fl_slimer_icons used to add any custom icons to it.
			*/		
			$iconsslimmer = apply_filters ('fl_slimer_close_icons', array('dashicons dashicons-no',
				'dashicons dashicons-no-alt',
				'dashicons dashicons-minus',
				'dashicons dashicons-dismiss',
				'close',
				'minus',
				'minus-circle',
				'minus-square',
				'minus-square-o',
				'search-minus'

			));

			/*
			* adding down icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_slimer_close_icon]', array('transport' => 'postMessage','type' => 'option') );
			
			/*
			* adding down icons control.
			*/	 
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_slimer_close_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
				'label' => __( 'Select close icon.', 'floating-links' ),
				'type' => 'radio',
				'choices' => $iconsslimmer,

			)));	


			/*
			* Making array of slimmer closes icons to show in customizer.
			* Filter fl_slimer_closed_icons used to add any custom icons to it.
			*/		
			$icons_slimmer_closed = apply_filters ('fl_slimer_open_icons', array('dashicons dashicons-yes',
				'dashicons dashicons-plus',
				'plus',
				'plus-circle',
				'plus-square',
				'plus-square-o',
				'search-plus',
				'crosshairs',
				'arrows',
				'arrows-alt',
				'check-square',
				'check-square-o',
				'plus-square'

			));

			/*
			* adding down icons setting.
			*/	
			$wp_customize->add_setting( $setting.'[fl_slimer_open_icon]', array('transport' => 'postMessage','type' => 'option') );
			
			/*
			* adding down icons control.
			*/	 
			$wp_customize->add_control(new Fl_Icons_Control( $wp_customize, $setting.'[fl_slimer_open_icon]', array(
				'section' => 'fl_icons_section',
				'priority' => 180,
				'label' => __( 'Select open icon.', 'floating-links' ),
				'type' => 'radio',
				'choices' => $icons_slimmer_closed,

			)));

			

		}/* fl_customizer Method ends here. */	

		/*
		* cutomizer_values holds the control values.
		*/ 
		function cutomizer_values($label, $section,  $settings, $type){
				
				/*
				* Controls indexes array.
				*/
				$array = array (
						'label' => __($label, 'floating-links' ),
						'section' => $section,
						'settings'   => $settings,
						'type' => $type,
				);

				/*
				* Returning back array.
				*/
				return $array;
			
		}/* cutomizer_values Method ends here. */	

		/*
		 * fl_live_preview will enqeue custom script in live preview.
		*/
		function fl_live_preview(){

			/*
			 * Enqueuing js for customizer live 
			*/
			wp_enqueue_script( 'floating_customizer_live', FLOATING_LINKS_URL . 'js/floating_customizer_live.js',array( 'jquery','customize-preview' ), true );

		}/* fl_live_preview Method ends here. */

		/*
		 * fl_customizer_files will enqeue custom script in customizer.
		*/
		function fl_customizer_files(){

			
			wp_enqueue_style('floating_fonts', FLOATING_LINKS_URL . 'css/floating_fonts.css' );

			wp_enqueue_style( 'dashicons' );	

			/*
			* Custom css file for customizer.
			*/
			wp_enqueue_style('floating_customizer', FLOATING_LINKS_URL . 'css/floating_customizer.css' );

			/*
			 * Enqueuing js for customizer. 
			*/
			wp_enqueue_script( 'floating_customizer_js', FLOATING_LINKS_URL . 'js/floating_customizer_js.js',array( 'jquery' ), true );


		}/* fl_customizer_files Method ends here. */

		/*
		 * fl_customizer_css will print css to the head of wp.
		*/
		function fl_customizer_css(){
				$floating_links = new Floating_Links();
				$position = $floating_links->get_fl_value('fl_position');	
			
		
			?>
			<style type="text/css">

				.floating_next_prev_wrap.fl_primary_bar.fl_primary_bar .floating_links .fl_slimer_Wrap {
					background-color: <?php echo $floating_links->get_fl_value('fl_bg_color') ?> ; 
					color: <?php echo $floating_links->get_fl_value('fl_color') ?>;
					border-color: <?php echo $floating_links->get_fl_value('fl_seprator_color') ?> !important;;
					 font-size: <?php echo $floating_links->get_fl_value('fl_icon_size') ?>px;
				}
				
				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					 background-color: <?php echo $floating_links->get_fl_value('fl_bg_color') ?> ; 
					 color: <?php echo $floating_links->get_fl_value('fl_color') ?>;
					 font-size: <?php echo $floating_links->get_fl_value('fl_icon_size') ?>px;
			   	     border-color: <?php echo $floating_links->get_fl_value('fl_seprator_color') ?> !important;;
				}
							
				.floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					 color: #ebebe4 !important;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a:hover, .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap:hover {
					 background-color: <?php echo $floating_links->get_fl_value('fl_hover_bg_color') ?> ;
					 color: <?php echo $floating_links->get_fl_value('fl_icon_hover_color') ?>;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
					 background-color: <?php echo $floating_links->get_fl_value('fl_hover_post_bg_color') ?> ;
					 border-color: <?php echo $floating_links->get_fl_value('fl_hover_post_seprator_color') ?> ;
				}
				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title{
					color: <?php echo $floating_links->get_fl_value('fl_hover_post_headings_color') ?> ;
					border-color: <?php echo $floating_links->get_fl_value('fl_hover_post_seprator_color') ?> ;
				}
				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title,.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description h6{
					color: <?php echo $floating_links->get_fl_value('fl_hover_post_headings_color') ?> ;
				}
				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description p{
					color: <?php echo $floating_links->get_fl_value('fl_hover_post_color') ?> ;
				}

				
				<?php 

					/*
					 * If shadow is enable show shadow
					*/	
					$fl_shadow = $floating_links->get_fl_value('fl_shadow');		
					if( isset($fl_shadow) && $fl_shadow  !='1' ) : 

				?>
					.floating_next_prev_wrap.fl_primary_bar .floating_links {
						box-shadow:none;
					}
									
				<?php endif;


					/*
					 * If shadow is enable show shadow
					*/	
					$fl_post_data = $floating_links->get_fl_value('fl_post_data');	

					if( isset($fl_post_data) && $fl_post_data  !='1' && $fl_post_data  =='true' ){

				?>
					.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
						display:block;
					}
				<?php 
				}
					else{ ?> .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
						display:none;
						}
				<?php }

				/*
				 * Checking the floating links position
				*/	
				$position = $floating_links->get_fl_value('fl_position');
			
				/*
				 * Checking the postion of floating links and showing them accordingly
				*/	
				switch ($position) {

					/*
					 * If floating links position is left.
					*/	
					case 'left': 
				?>
				
				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : 0;
				    transform : translate(0px, -50%);
					bottom : auto;
 				    right : auto;
					top : 50%;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
				left: 105%; 
				}

				<?php 	break;

				/*
					 * If floating links position is left top.
					*/	
					case 'left_top': 
				?>
				
				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : 0;
				    transform : translate(0, 0);
					bottom : auto;
 				    right : auto;
					top : 0;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
				left: 105%; 
				}

				<?php 	break;

					/*
					 * If floating links position is left bottom.
					*/	
					case 'left_bottom': 
				?>
				
				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : 0;
				    transform : translate(0px, 0px);
					top: auto;
 				    right : auto;
					bottom : 0;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
				left: 105%; 
				}

				<?php 	break;


					/*
					 * If floating links position is right.
					*/	
					case 'right': 
				?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : auto;
					transform : translate(0px, -50%);
					bottom : auto;
					right : 0;
					top : 50%;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				<?php 	break;


					/*
					 * If floating links position is right top.
					*/	
					case 'right_top': 
				?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : auto;
					transform : translate(0px, 0px);
					bottom : auto;
					right : 0;
					top : 0;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				<?php 	break;



					/*
					 * If floating links position is right bottom.
					*/	
					case 'right_bottom': 
				?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : auto;
					transform : translate(0px, 0px);
				
					right : 0;
					top : auto;
					bottom : 0;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				<?php 	break;

					/*
					 * If floating links position is bottom.
					*/	
					case 'bottom': ?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : 50%;
					display: inline-table;
					transform : translate(-50%, 0);
					bottom : 0;
					right : 0;
					top : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child{
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value('fl_seprator_color') ?>;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: -55px;
				}
										
				<?php 	break;

					/*
					 * If floating links position is bottom left.
					*/	
					case 'bottom_left': ?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : 0;
					display: inline-table;
					transform : translate(0, 0);
					bottom : 0;
					right : auto;
					top : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child{
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value('fl_seprator_color') ?>;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: -55px;
					        left: 0;
				}
										
				<?php 	break;

					/*
					 * If floating links position is bottom right.
					*/	
					case 'bottom_right': ?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links {
					left : auto;
					display: inline-table;
					transform : translate(0, 0);
					bottom : 0;
					right : 0;
					top : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child{
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value('fl_seprator_color') ?>;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: -55px;
				}
										
				<?php 	break;

					/*
					 * If floating links position is top.
					*/	
					case 'top': ?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links{
					left : 50%;
					display: inline-table;
					transform : translate(-50%, 0);
					bottom : auto;
					right : 0;
					top : 0;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child {
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value('fl_seprator_color') ?>;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap {
					float: left;
    				margin: 0px auto;
				}
				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: 0;
				}

			<?php 	break;

					/*
					 * If floating links position is top right.
					*/	
					case 'top_right': ?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links{
					left : auto;
					display: inline-table;
					transform : translate(0, 0);
					bottom : auto;
					right : 0;
					top : 0;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child {
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value('fl_seprator_color') ?>;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap {
					float: left;
    				margin: 0px auto;
				}
				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: 0;
				}

			<?php 	break;


					/*
					 * If floating links position is top left.
					*/	
					case 'top_left': ?>

				.floating_next_prev_wrap.fl_primary_bar .floating_links{
					left : 0;
					display: inline-table;
					transform : translate(0, 0);
					bottom : auto;
					right : auto;
					top : 0;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child {
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value('fl_seprator_color') ?>;
				}

				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap {
					float: left;
    				margin: 0px auto;
				}
				.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: 0;
					    left: 105%;
				}

			<?php 	break;

					
					default:
					# code...
					break;

			}/* Switch statement ends here. */

			if(!is_customize_preview()):
			/*
			* If floating links position is top and admin bar is showing take some margin.
			*/			
			if ( is_admin_bar_showing() && $position == 'top' or $position == 'left_top'  or $position == 'top_right' or $position == 'top_left' ) : ?>
					.floating_next_prev_wrap.fl_primary_bar .floating_links {
						top : 32px;
					}

			<?php endif; 
			endif;

			/*
			* Getting Minimizer feature option.
			*/
			$enable_minimizer = $floating_links->get_fl_value('fl_minimizer');

				/*
				* If floating minimizer is enable show last border.
				*/			
				if ( !isset($enable_minimizer) && 'true' != $enable_minimizer ) : ?>
						.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child {
							    border: none;
						}

			<?php endif; ?>	
				
				.floating_next_prev_wrap.fl_secondary_bar.fl_secondary_bar .floating_links .fl_slimer_Wrap {
					background-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_bg_color'] ?> ; 
					color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_color'] ?>;
					border-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?>;
					 font-size: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_icon_size'] ?>px;
				}
				
				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					 background-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_bg_color'] ?> ; 
					 color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_color'] ?>;
					 font-size: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_icon_size'] ?>px;
			   	     border-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?> !important;;
				}
							
				.floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					 color: #ebebe4 !important;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a:hover, .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap:hover {
					 background-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_hover_bg_color'] ?> ;
					 color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_icon_hover_color'] ?>;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
					 background-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_hover_post_bg_color'] ?> ;
					 border-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_hover_post_seprator_color'] ?> ;
				}
				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title{
					color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_hover_post_headings_color'] ?> ;
					border-color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_hover_post_seprator_color'] ?> ;
				}
				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title,.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description h6{
					color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_hover_post_headings_color'] ?> ;
				}
				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description p{
					color: <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_hover_post_color'] ?> ;
				}

				
				<?php 

					/*
					 * If shadow is enable show shadow
					*/	
					$fl_shadow = $floating_links->get_fl_value()['fl_secondary']['fl_shadow'];		
					if( isset($fl_shadow) && $fl_shadow  !='1' ) : 

				?>
					.floating_next_prev_wrap.fl_secondary_bar .floating_links {
						box-shadow:none;
					}
									
				<?php endif;

					/*
					 * If shadow is enable show shadow
					*/	
					$fl_post_data = $floating_links->get_fl_value()['fl_secondary']['fl_post_data'];	

					if( isset($fl_post_data) && $fl_post_data  !='1' && $fl_post_data  =='true' ){

				?>
					.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
						display:block;
					}
				<?php 
				}
					else{ ?> .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
						display:none;
						}
				<?php }

				/*
				 * Checking the floating links position
				*/	
				$position = $floating_links->get_fl_value()['fl_secondary']['fl_position'];
			
				/*
				 * Checking the postion of floating links and showing them accordingly
				*/	
				switch ($position) {

					/*
					 * If floating links position is left.
					*/	
					case 'left': 
				?>
				
				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : 0;
				    transform : translate(0px, -50%);
					bottom : auto;
 				    right : auto;
					top : 50%;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
				left: 105%; 
				}

				<?php 	break;

				/*
					 * If floating links position is left top.
					*/	
					case 'left_top': 
				?>
				
				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : 0;
				    transform : translate(0, 0);
					bottom : auto;
 				    right : auto;
					top : 0;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
				left: 105%; 
				}

				<?php 	break;

					/*
					 * If floating links position is left bottom.
					*/	
					case 'left_bottom': 
				?>
				
				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : 0;
				    transform : translate(0px, 0px);
					top: auto;
 				    right : auto;
					bottom : 0;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details {
				left: 105%; 
				}

				<?php 	break;


					/*
					 * If floating links position is right.
					*/	
					case 'right': 
				?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : auto;
					transform : translate(0px, -50%);
					bottom : auto;
					right : 0;
					top : 50%;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				<?php 	break;


					/*
					 * If floating links position is right top.
					*/	
					case 'right_top': 
				?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : auto;
					transform : translate(0px, 0px);
					bottom : auto;
					right : 0;
					top : 0;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				<?php 	break;



					/*
					 * If floating links position is right bottom.
					*/	
					case 'right_bottom': 
				?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : auto;
					transform : translate(0px, 0px);
				
					right : 0;
					top : auto;
					bottom : 0;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : both;
					width : 100%;
				}

				<?php 	break;

					/*
					 * If floating links position is bottom.
					*/	
					case 'bottom': ?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : 50%;
					display: inline-table;
					transform : translate(-50%, 0);
					bottom : 0;
					right : 0;
					top : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child{
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?>;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: -55px;
				}
										
				<?php 	break;

					/*
					 * If floating links position is bottom left.
					*/	
					case 'bottom_left': ?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : 0;
					display: inline-table;
					transform : translate(0, 0);
					bottom : 0;
					right : auto;
					top : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child{
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?>;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: -55px;
					        left: 0;
				}
										
				<?php 	break;

					/*
					 * If floating links position is bottom right.
					*/	
					case 'bottom_right': ?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links {
					left : auto;
					display: inline-table;
					transform : translate(0, 0);
					bottom : 0;
					right : 0;
					top : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child{
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?>;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: -55px;
				}
										
				<?php 	break;

					/*
					 * If floating links position is top.
					*/	
					case 'top': ?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links{
					left : 50%;
					display: inline-table;
					transform : translate(-50%, 0);
					bottom : auto;
					right : 0;
					top : 0;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child {
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?>;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap {
					float: left;
    				margin: 0px auto;
				}
				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: 0;
				}

			<?php 	break;

					/*
					 * If floating links position is top right.
					*/	
					case 'top_right': ?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links{
					left : auto;
					display: inline-table;
					transform : translate(0, 0);
					bottom : auto;
					right : 0;
					top : 0;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child {
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?>;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap {
					float: left;
    				margin: 0px auto;
				}
				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: 0;
				}

			<?php 	break;


					/*
					 * If floating links position is top left.
					*/	
					case 'top_left': ?>

				.floating_next_prev_wrap.fl_secondary_bar .floating_links{
					left : 0;
					display: inline-table;
					transform : translate(0, 0);
					bottom : auto;
					right : auto;
					top : 0;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled {
					float : left;
					clear : none;
					width : auto;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child {
					border-bottom : 1px solid <?php echo $floating_links->get_fl_value()['fl_secondary']['fl_seprator_color'] ?>;
				}

				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap {
					float: left;
    				margin: 0px auto;
				}
				.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details{
					    top: 0;
					    left: 105%;
				}

			<?php 	break;

					
					default:
					# code...
					break;

			}/* Switch statement ends here. */

			if(!is_customize_preview()):
			/*
			* If floating links position is top and admin bar is showing take some margin.
			*/			
			if ( is_admin_bar_showing() && $position == 'top' or $position == 'left_top'  or $position == 'top_right' or $position == 'top_left' ) : ?>
					.floating_next_prev_wrap.fl_secondary_bar .floating_links {
						top : 32px;
					}

			<?php endif; 
			endif;

			/*
			* Getting Minimizer feature option.
			*/
			$enable_minimizer = $floating_links->get_fl_value()['fl_secondary']['fl_minimizer'];

				/*
				* If floating minimizer is enable show last border.
				*/			
				if ( !isset($enable_minimizer) && 'true' != $enable_minimizer ) : ?>
						.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child {
							    border: none;
						}

			<?php endif; ?>	  

			</style>
			<?php

		}/* fl_customizer_css method ends here. */	

}/* FLOATING_LINKS_CUSTOMIZER class ends here. */	
$GLOBALS['FLOATING_LINKS_CUSTOMIZER'] = new FLOATING_LINKS_CUSTOMIZER();
endif;