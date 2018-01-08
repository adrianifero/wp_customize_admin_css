(function( $ ) {
    "use strict";
	$(function() {

		$('body').addClass('customizeadmin-js');
		
		
		if ( $('body.settings_page_wpcustomizeadmin').length > 0 ) {
			
			var selectedColor = $('input[name="wpcustomizeadmin_input_color"]').val();
			if ( selectedColor ){
				$('#wpcustomizeadmin-content .customize_colors span.'+selectedColor).addClass('selected');
			}
			
			$('#wpcustomizeadmin-content .customize_colors span').click(function(){
				$('#wpcustomizeadmin-content .customize_colors span').removeClass('selected');
				
				var newSelection = $(this).attr('data-color');
				$(this).addClass('selected');
				$('input[name="wpcustomizeadmin_input_color"]').val( newSelection );
			});
			
		}
	
									  
	});
}(jQuery));