var $ = jQuery;
$(document).ready(function($){ 

	if('true' === fl.is_primary_scroll_enabled){
		$(window).scroll(function() {

	    // calculate the percentage the user has scrolled down the page
	    var scrollPercent = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());

	    if(scrollPercent >= fl.primary_scroll_val){
	    	$('.fl_primary_bar').fadeIn('slow');
	    }
	    else{
			$('.fl_primary_bar').fadeOut('slow');
	    }

		});
	}	

	if('true' === fl.is_secondary_scroll_enabled){
		$(window).scroll(function() {

	    // calculate the percentage the user has scrolled down the page
	    var scrollPercent = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());

	    if(scrollPercent >= fl.secondary_scroll_val){
	    	$('.fl_secondary_bar').fadeIn('slow');
	    }
	    else{
			$('.fl_secondary_bar').fadeOut('slow');
	    }

		});
	}
	
	/*
	* scroll to Top with Animation
	*/ 
	 $('.fl_top.fl_icon_holder').click(function(){
	   $('html, body').animate({scrollTop:0}, 'slow');
	 });

	 /*
	* scroll to Bototm with Animation
	*/
	  $('.fl_bottom.fl_icon_holder').click(function(){
	   $("html, body").animate({ scrollTop: $(document).height() }, "slow");
	 });
	
	 /*
	* On Slimmer click changes Icons and show and hide bar
	*/
	$('#fl_slimer_primary_wrap').click(function(e){
		e.preventDefault();
		// console.log(e);
		$('#fl_inner_primary_wrap').slideToggle('slow');
		$('.fl_primary_bar .fl_slimer_Wrap').toggleClass('fl-close');
	});

	 /*
	* On Slimmer click changes Icons and show and hide bar
	*/
	 $('#fl_slimer_secondary_wrap').click(function(e){
		e.preventDefault();
		$('#fl_inner_secondary_wrap').slideToggle('slow');
		$('.fl_secondary_bar .fl_slimer_Wrap').toggleClass('fl-close');
	});

	 /*
	* Copy to Clipboard functions
	*/
	$.fn.CopyToClipboard = function() {
		    var textToCopy = false;
		    if(this.is('select') || this.is('textarea') || this.is('input')){
		        textToCopy = this.val();
		    }else {
		        textToCopy = this.text();
		    }
		    CopyToClipboard(textToCopy);
	};

	function CopyToClipboard( val ){
		    var hiddenClipboard = $('#_hiddenClipboard_');
		    if(!hiddenClipboard.length){
		        $('body').append('<textarea style="position:absolute;top: -9999px;" id="_hiddenClipboard_"></textarea>');
		        hiddenClipboard = $('#_hiddenClipboard_');
		    }
		    hiddenClipboard.html(val);
		    hiddenClipboard.select();
		    document.execCommand('copy');
		    document.getSelection().removeAllRanges();
	}

	$(function(){
		    $('[data-clipboard-target]').each(function(){
		        $(this).click(function() {
		            $($(this).data('clipboard-target')).CopyToClipboard();
		        });
		    });
		    $('[data-clipboard-text]').each(function(){
		        $(this).click(function(){
		            CopyToClipboard($(this).data('clipboard-text'));
		        });
		    });
	});

	/*
	* Show Copied Toast
	*/ 
	 $('.fl_copy_url').click(function(){
	   $(".fl_copied").slideDown();
	   setTimeout(function(){ $(".fl_copied").slideUp(); }, 3000);
	 });
	

});