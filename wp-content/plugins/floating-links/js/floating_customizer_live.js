
/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	//Icon left
	wp.customize( 'fl_settings[fl_left_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_left_icon');
			if($('.fl_prev_icon').hasClass('disabled')){
				//alert('hello');

					if(newval.indexOf("dashicons") > -1){
					$('.floating_next_prev_wrap.fl_primary_bar.fl_primary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon disabled " + newval);
						}
					else{
					$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon fa  disabled  fa-" + newval);
					}	
			
			}
			else if(newval.indexOf("dashicons") > -1){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon  " + newval);
			}
			else{
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon fa  fa-" + newval);
			}
			
			

		} );
	} );

	//Icon right
	wp.customize( 'fl_settings[fl_right_icon]', function( value ) {
		
		value.bind( function( newval ) {
			if($('.fl_next_icon').hasClass('disabled')){
				//alert('hello');

					if(newval.indexOf("dashicons") > -1){
					$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon disabled " + newval);
						}
					else{
					$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon fa  disabled  fa-" + newval);
					}	
			
			}
			else if(newval.indexOf("dashicons") > -1){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon  " + newval);
			}
			else{
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon fa  fa-" + newval);
			}
			
		} );
	} );


	//Icon Random
	wp.customize( 'fl_settings[fl_random_icon]', function( value ) {
		
		value.bind( function( newval ) {
				if(newval.indexOf("dashicons") > -1){
					$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_random_icon').removeAttr('class').addClass("fl_random_icon " + newval);
						}
					else{
					$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_random_icon').removeAttr('class').addClass("fl_random_icon fa fa-" + newval);
					}	
			
		} );
	} );

	//Icon top
	wp.customize( 'fl_settings[fl_up_icon]', function( value ) {
		
		value.bind( function( newval ) {
		if(newval.indexOf("dashicons") > -1){
		$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_top_icon').removeAttr('class').addClass("fl_top_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_top_icon').removeAttr('class').addClass("fl_top_icon fa  fa-" + newval);
		}	
		} );
	} );

	//Icon bottom
	wp.customize( 'fl_settings[fl_down_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_bottom_icon').removeAttr('class').addClass("fl_bottom_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_bottom_icon').removeAttr('class').addClass("fl_bottom_icon fa  fa-" + newval);
		}

		} );
	} );

	//Icon home
	wp.customize( 'fl_settings[fl_home_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_home_icon').removeAttr('class').addClass("fl_home_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_home_icon').removeAttr('class').addClass("fl_home_icon fa  fa-" + newval);
		}

		} );
	} );


	//Icon copy url
	wp.customize( 'fl_settings[fl_copy_url_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_copy_url_icon').removeAttr('class').addClass("fl_copy_url_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_copy_url_icon').removeAttr('class').addClass("fl_copy_url_icon fa  fa-" + newval);
		}

		} );
	} );


	//Icon Slimmer
	wp.customize( 'fl_settings[fl_slimer_close_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimmer_icon').removeAttr('class').addClass("fl_slimmer_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimmer_icon').removeAttr('class').addClass("fl_slimmer_icon fa  fa-" + newval);
		}

		} );
	} );


	//Icon open
	wp.customize( 'fl_settings[fl_slimer_open_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_close_icon ').removeAttr('class').addClass("fl_slimer_close_icon  " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_close_icon ').removeAttr('class').addClass("fl_slimer_close_icon  fa  fa-" + newval);
		}

		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_bg_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap').css('background-color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_position]', function( value ) {
		
		value.bind( function( newval ) {

			jQuery('.floating_next_prev_wrap.fl_primary_bar').attr('class', 'floating_next_prev_wrap fl_primary_bar');

			jQuery('.floating_next_prev_wrap.fl_primary_bar').addClass('fl_'+newval);

			if(newval == 'left'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'left' : '0',
				   'transform' : 'translate(0px, -50%)',
				   'bottom' : 'auto',
				   'right' : 'auto',
				   'top' : '50%',
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'left' : '105%'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				
			}

			else if(newval == 'left_top'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'left' : '0',
				   'transform' : 'translate(0, 0)',
				   'bottom' : 'auto',
				   'right' : 'auto',
				   'top' : '0',
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'left' : '105%'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				
			}

			else if(newval == 'left_bottom'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'left' : '0',
				   'transform' : 'translate(0, 0)',
				   'bottom' : '0',
				   'right' : 'auto',
				   'top' : 'auto',
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'left' : '105%'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				
			}

			else if(newval == 'right'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'right' : '0',
				   'left' : 'auto',
				   'transform' : 'translate(0px, -50%)',
				   'bottom' : 'auto',
				   'top' : '50%',
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'right' : '105%',
				   'left' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});

			}

			else if(newval == 'right_top'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'right' : '0',
				   'left' : 'auto',
				   'transform' : 'translate(0, 0)',
				   'bottom' : 'auto',
				   'top' : '0',
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});

			}


			else if(newval == 'right_bottom'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'right' : '0',
				   'left' : 'auto',
				   'transform' : 'translate(0, 0)',
				   'bottom' : '0',
				   'top' : 'auto',
				});
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});


			}

			else if(newval == 'bottom'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'bottom' : '0',
				   'left' : '50%',
				   'right' : '0',
				   'transform' : 'translate(-50%, 0)',
				   'display' : 'inline-table',
				   'top' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '-55px'
				});
			}

			else if(newval == 'bottom_left'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'bottom' : '0',
				   'left' : '0',
				   'right' : 'auto',
				   'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'top' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '-55px',
				   'left' : '0'
				});
			}

			else if(newval == 'bottom_right'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'bottom' : '0',
				   'left' : 'auto',
				   'right' : '0',
				   'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'top' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '-55px'
				});
			}

			else if(newval == 'top'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'top' : '0',
				    'transform' : 'translate(-50%, 0)',
				   'display' : 'inline-table',
				   'bottom' : 'auto',
				   'left' : '50%',
				   'right' : '0'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'margin' : '0px auto',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '0'
				});

			}

			else if(newval == 'top_right'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'left' : 'auto',
				    'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'bottom' : 'auto',
				   'top' : '0',
				   'right' : '0'
				});
					
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'margin' : '0px auto',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '0'
				});

			}

			else if(newval == 'top_left'){
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css({
				   'left' : '0',
				    'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'bottom' : 'auto',
				   'top' : '0',
				   'right' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'margin' : '0px auto',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '0',
				   'left' : '105%'
				});

			}

			
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_hover_bg_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('<style>.floating_next_prev_wrap.fl_primary_bar .floating_links a:hover, .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap:hover{background-color:' + newval + ' !important;}</style>').appendTo('head');
		} );
	} );

	
	//Update site link color in real time...
	wp.customize( 'fl_settings[fl_color]', function( value ) {
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap').css('color', newval );
		} );
	} );

	//Update site link color in real time...
	wp.customize( 'fl_settings[fl_icon_hover_color]', function( value ) {
		value.bind( function( newval ) {
			$('<style>.floating_next_prev_wrap.fl_primary_bar .floating_links a:hover{color:' + newval + ' !important;}</style>').appendTo('head');
		} );
	} );

	//Update site link color in real time...
	wp.customize( 'fl_settings[fl_icon_size]', function( value ) {
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap').css('font-size', newval + 'px' );
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_seprator_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_primary_bar .floating_links a, .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_slimer_Wrap').css('border-color', newval + '!important');
		} );
	} );
	
	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_shadow]', function( value ) {
		
		value.bind( function( newval ) {
			
			if(newval == false){
				newval = 'none';
			}
			else 
			{
				newval =  '-6px 4px 20px 0px rgba(0,0,0,0.75)';
			}
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links').css('box-shadow', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_hover_post_bg_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder:hover').trigger('mouseenter');
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css('background-color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_hover_post_headings_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title,.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description h6').css('color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_hover_post_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description p').css('color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_hover_post_seprator_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details, .floating_next_prev_wrap.fl_primary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title').css('border-color', newval);
		} );
	} );

																	//Secondary Bar

		//Icon left
	wp.customize( 'fl_settings[fl_secondary][fl_left_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_left_icon');
			if($('.fl_prev_icon').hasClass('disabled')){
				//alert('hello');

					if(newval.indexOf("dashicons") > -1){
					$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon disabled " + newval);
						}
					else{
					$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon fa  disabled  fa-" + newval);
					}	
			
			}
			else if(newval.indexOf("dashicons") > -1){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon  " + newval);
			}
			else{
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_prev_icon').removeAttr('class').addClass("fl_prev_icon fa  fa-" + newval);
			}
			
			

		} );
	} );

	//Icon right
	wp.customize( 'fl_settings[fl_secondary][fl_right_icon]', function( value ) {
		
		value.bind( function( newval ) {
			if($('.fl_next_icon').hasClass('disabled')){
				//alert('hello');

					if(newval.indexOf("dashicons") > -1){
					$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon disabled " + newval);
						}
					else{
					$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon fa  disabled  fa-" + newval);
					}	
			
			}
			else if(newval.indexOf("dashicons") > -1){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon  " + newval);
			}
			else{
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_next_icon').removeAttr('class').addClass("fl_next_icon fa  fa-" + newval);
			}
			
		} );
	} );


	//Icon Random
	wp.customize( 'fl_settings[fl_secondary][fl_random_icon]', function( value ) {
		
		value.bind( function( newval ) {
				if(newval.indexOf("dashicons") > -1){
					$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_random_icon').removeAttr('class').addClass("fl_random_icon " + newval);
						}
					else{
					$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_random_icon').removeAttr('class').addClass("fl_random_icon fa fa-" + newval);
					}	
			
		} );
	} );

	//Icon top
	wp.customize( 'fl_settings[fl_secondary][fl_up_icon]', function( value ) {
		
		value.bind( function( newval ) {
		if(newval.indexOf("dashicons") > -1){
		$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_top_icon').removeAttr('class').addClass("fl_top_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_top_icon').removeAttr('class').addClass("fl_top_icon fa  fa-" + newval);
		}	
		} );
	} );

	//Icon bottom
	wp.customize( 'fl_settings[fl_secondary][fl_down_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_bottom_icon').removeAttr('class').addClass("fl_bottom_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_bottom_icon').removeAttr('class').addClass("fl_bottom_icon fa  fa-" + newval);
		}

		} );
	} );

	//Icon home
	wp.customize( 'fl_settings[fl_secondary][fl_home_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_home_icon').removeAttr('class').addClass("fl_home_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_home_icon').removeAttr('class').addClass("fl_home_icon fa  fa-" + newval);
		}

		} );
	} );


	//Icon copy url
	wp.customize( 'fl_settings[fl_secondary][fl_copy_url_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_copy_url_icon').removeAttr('class').addClass("fl_copy_url_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_copy_url_icon').removeAttr('class').addClass("fl_copy_url_icon fa  fa-" + newval);
		}

		} );
	} );


	//Icon Slimmer
	wp.customize( 'fl_settings[fl_secondary][fl_slimer_close_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimmer_icon').removeAttr('class').addClass("fl_slimmer_icon " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimmer_icon').removeAttr('class').addClass("fl_slimmer_icon fa  fa-" + newval);
		}

		} );
	} );


	//Icon open
	wp.customize( 'fl_settings[fl_secondary][fl_slimer_open_icon]', function( value ) {
		
		value.bind( function( newval ) {
			//console.log(newval);
			//$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_left_icon');
		if(newval.indexOf("dashicons") > -1){	
		$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_close_icon ').removeAttr('class').addClass("fl_slimer_close_icon  " + newval);
		}
		else{
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_close_icon ').removeAttr('class').addClass("fl_slimer_close_icon  fa  fa-" + newval);
		}

		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_bg_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap').css('background-color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_position]', function( value ) {
		
		value.bind( function( newval ) {

			jQuery('.floating_next_prev_wrap.fl_secondary_bar').attr('class', 'floating_next_prev_wrap fl_secondary_bar');

			jQuery('.floating_next_prev_wrap.fl_secondary_bar').addClass('fl_'+newval);

			if(newval == 'left'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'left' : '0',
				   'transform' : 'translate(0px, -50%)',
				   'bottom' : 'auto',
				   'right' : 'auto',
				   'top' : '50%',
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'left' : '105%'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				
			}

			else if(newval == 'left_top'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'left' : '0',
				   'transform' : 'translate(0, 0)',
				   'bottom' : 'auto',
				   'right' : 'auto',
				   'top' : '0',
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'left' : '105%'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				
			}

			else if(newval == 'left_bottom'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'left' : '0',
				   'transform' : 'translate(0, 0)',
				   'bottom' : '0',
				   'right' : 'auto',
				   'top' : 'auto',
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'left' : '105%'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				
			}

			else if(newval == 'right'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'right' : '0',
				   'left' : 'auto',
				   'transform' : 'translate(0px, -50%)',
				   'bottom' : 'auto',
				   'top' : '50%',
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'right' : '105%',
				   'left' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});
				

			}

			else if(newval == 'right_top'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'right' : '0',
				   'left' : 'auto',
				   'transform' : 'translate(0, 0)',
				   'bottom' : 'auto',
				   'top' : '0',
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});

				
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});

			}


			else if(newval == 'right_bottom'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'right' : '0',
				   'left' : 'auto',
				   'transform' : 'translate(0, 0)',
				   'bottom' : '0',
				   'top' : 'auto',
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'both',
				   'width' : '100%'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'none'
				});


			}

			else if(newval == 'bottom'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'bottom' : '0',
				   'left' : '50%',
				   'right' : '0',
				   'transform' : 'translate(-50%, 0)',
				   'display' : 'inline-table',
				   'top' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '-55px'
				});
			}

			else if(newval == 'bottom_left'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'bottom' : '0',
				   'left' : '0',
				   'right' : 'auto',
				   'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'top' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '-55px',
				   'left' : '0'
				});
			}

			else if(newval == 'bottom_right'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'bottom' : '0',
				   'left' : 'auto',
				   'right' : '0',
				   'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'top' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '-55px'
				});
			}

			else if(newval == 'top'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'top' : '0',
				    'transform' : 'translate(-50%, 0)',
				   'display' : 'inline-table',
				   'bottom' : 'auto',
				   'left' : '50%',
				   'right' : '0'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'margin' : '0px auto',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '0'
				});

			}

			else if(newval == 'top_right'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'left' : 'auto',
				    'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'bottom' : 'auto',
				   'top' : '0',
				   'right' : '0'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'margin' : '0px auto',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '0'
				});

			}

			else if(newval == 'top_left'){
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css({
				   'left' : '0',
				    'transform' : 'translate(0, 0)',
				   'display' : 'inline-table',
				   'bottom' : 'auto',
				   'top' : '0',
				   'right' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .fl_slimer_Wrap').css({
				   'float' : 'left',
				    'width': 'auto',
				    'clear' : 'none'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'clear' : 'none',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a:last-child').css({
				   'border-bottom' : '1px solid'
				});

				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled').css({
				   'float' : 'left',
				   'margin' : '0px auto',
				   'width' : 'auto'
				});
				$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css({
				   'top' : '0',
				   'left' : '105%'
				});

			}

			
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_hover_bg_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('<style>.floating_next_prev_wrap.fl_secondary_bar .floating_links a:hover, .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap:hover{background-color:' + newval + ' !important;}</style>').appendTo('head');
		} );
	} );

	
	//Update site link color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_color]', function( value ) {
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap').css('color', newval );
		} );
	} );

	//Update site link color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_icon_hover_color]', function( value ) {
		value.bind( function( newval ) {
			$('<style>.floating_next_prev_wrap.fl_secondary_bar .floating_links a:hover{color:' + newval + ' !important;}</style>').appendTo('head');
		} );
	} );

	//Update site link color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_icon_size]', function( value ) {
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap').css('font-size', newval + 'px' );
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_seprator_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .disabled, .floating_next_prev_wrap.fl_secondary_bar .floating_links a, .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_slimer_Wrap').css('border-color', newval + '!important');
		} );
	} );
	
	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_shadow]', function( value ) {
		
		value.bind( function( newval ) {
			
			if(newval == false){
				newval = 'none';
			}
			else 
			{
				newval =  '-6px 4px 20px 0px rgba(0,0,0,0.75)';
			}
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links').css('box-shadow', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_hover_post_bg_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder:hover').trigger('mouseenter');
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details').css('background-color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_hover_post_headings_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title,.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description h6').css('color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_hover_post_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_description p').css('color', newval);
		} );
	} );

	//Update Bg color in real time...
	wp.customize( 'fl_settings[fl_secondary][fl_hover_post_seprator_color]', function( value ) {
		
		value.bind( function( newval ) {
			$('.floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_details, .floating_next_prev_wrap.fl_secondary_bar .floating_links .fl_inner_wrap .fl_icon_holder .fl_post_title').css('border-color', newval);
		} );
	} );																

} )( jQuery );
