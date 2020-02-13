
jQuery( document ).ready(function($) {

	 $('select').material_select();

	 $('.modal').modal();
	function getUrlVars()
		{
		    var vars = [], hash;
		    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		    for(var i = 0; i < hashes.length; i++)
		    {
		        hash = hashes[i].split('=');
		        vars.push(hash[0]);
		        vars[hash[0]] = hash[1];
		    }
		    return vars;
		}

	jQuery( "#toplevel_page_floating_links ul li:nth-child(3)" ).addClass( "fl_pagination" );
		
	var mt_page = getUrlVars()["page"];

	if(mt_page ==  'mt-other-plugins'){

		jQuery(".fl_tabs_main li a").removeClass('active');
		jQuery(".fl_tabs_content .fl_tab_content").css('display', 'none');
		jQuery(".fl_tabs_content .fl_tab_content").removeClass('active');	
		jQuery(".fl_tabs_content #other-plugins").addClass('active');
		jQuery(".fl_tabs_main li .mt-other-tab").addClass('active');
		jQuery(".fl_tabs_content #other-plugins").css('display', 'block');

	}

	if(mt_page ==  'mt-feedback-suggestions'){
		jQuery(".fl_tabs_main li a").removeClass('active');
		jQuery(".fl_tabs_content .fl_tab_content").css('display', 'none');
		jQuery(".fl_tabs_content .fl_tab_content").removeClass('active');	
		jQuery(".fl_tabs_content #feedback-suggestions").addClass('active');
		jQuery(".fl_tabs_main li .mt-feedback-suggestions").addClass('active');
		jQuery(".fl_tabs_content #feedback-suggestions").css('display', 'block');
	}

	jQuery(document).on("click", ".fl_pagination a", function($) {
		jQuery(".fl_tabs_main li a").removeClass('active');
		jQuery(".fl_tabs_main .fl_pagination_tab").addClass('active'); 	
		jQuery(".fl_tabs_content .fl_tab_content").removeClass('active');	
		jQuery(".fl_tabs_content .fl_tab_content").css('display', 'none');
		jQuery(".fl_tabs_content .fl_pagination_content ").addClass('active');	
		jQuery(".fl_tabs_content .fl_pagination_content").css('display', 'block');

	 });

		

jQuery(document).on("click", ".fl_tabs_main li .fl_tab", function($) {
			var cuurent_tab = jQuery(this).attr('href');
	
			jQuery('.fl_tabs_content .fl_tab_content').removeClass('active');
			jQuery('.fl_tabs_content .fl_tab_content').css('display', 'none');
			jQuery(this).addClass('active');
			jQuery('.fl_tabs_content ' + cuurent_tab +'').css("display", "block");

	 });

jQuery(document).on("click", ".fl_bars_holder .fl_bar_gen", function($) {
	var id = jQuery(this).data('id');

	if(id === 'primary' ){
		jQuery('.fl_tab_content .fl_secondary_content').fadeOut();
		jQuery('.fl_tab_content .fl_primary_content').fadeIn();

		jQuery('.fl_bars_holder .fl_bar_gen').removeClass('active');

		jQuery('.fl_bars_holder .fl_bar_prim').addClass('active');
	}

	if(id === 'secondary' ){
		jQuery('.fl_tab_content .fl_primary_content').fadeOut();
		jQuery('.fl_tab_content .fl_secondary_content').fadeIn();

		jQuery('.fl_bars_holder .fl_bar_gen').removeClass('active');

		jQuery('.fl_bars_holder .fl_bar_sec').addClass('active');
	}
});	

/*
* Saving options values by ajax.
*/
jQuery(document).on("click", ".fl_options", function($) {

	Materialize.Toast.removeAll();

	/*
	* Show the dialog.
	*/
	Materialize.toast(fl.notification_string, 3000, null);	

	
	/*
	* Getting clicked option value.
	*/	
	var fl_option = jQuery(this).data('option');

	/*
	* Getting clicked option bar.
	*/	
	var fl_bar = null;
	fl_bar = jQuery(this).data('bar');

	/*
	* Intializing value variable.
	*/	
	var fl_value = null; 

	/*
	* Checking clicked option status.
	*/
	if(jQuery(this).is(":checked")) {

		/*
		* Value will be true if checked.
		*/	
	    fl_value = true;
   }
	else{

		/*
		* Value will be false if not checked.
		*/	
	   	fl_value = false;
   }
	
	/*
	* Collecting data for ajax call.
	*/
	var data = { action : 'fl_save_values',
				fl_option : fl_option,
				fl_value : fl_value,
				fl_bar : fl_bar
	}	
	/*
	* Making ajax request to save values.
	*/	
	jQuery.ajax({
		url : fl.ajax_url,
		type : 'post',
		data : data,
		dataType: 'json',
		success : function( response ) {

			Materialize.Toast.removeAll();

			/*
			* Show the dialog.
			*/
			Materialize.toast(response.data, 3000, null);	
			
		}

		});/* Ajax func ends here. */

 });/* fl_options func ends here. */

 
/* Premium Code Stripped by Freemius */

 });