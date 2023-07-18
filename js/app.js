;(function ($, window, undefined) {
	'use strict';

	$(document).ready(function() {

		/* FOUNDATION */
		$(document).foundation();

		/* MASONRY */
		var maso_target = $('#startup-maso');
		if ( maso_target.length ) {
			var float_check_element = 'article';
			maso_target.imagesLoaded(function(){
				if ( 'none' == maso_target.find(float_check_element+':first').css('float') )
					return;
				maso_target.masonry({
					itemSelector : '.startup-maso-item',
					columnWidth: function( containerWidth ) {
						return containerWidth / su_masonry.columns;
					}
				});
			});
		}

		/* HIDE ADDRESS BAR ON IPHONE */
		window.scrollTo(0,1);

		// EXTERNAL LINKS
		$('body').on('click', 'a[rel="external"]', function() {
		    window.open($(this).attr('href'));
		    return false;
		});


		/* WORDPRESS NAV-BAR SUPPORT ------------- */
		/* Adds support for the nav-bar with flyouts in WordPress */

		$('.nav-bar li').has('ul').addClass("has-flyout");
		$('.nav-bar li ul').addClass("flyout");

		/* PLACEHOLDER FOR FORMS ------------- */
		/* Remove this and jquery.placeholder.min.js if you don't need :) */

		//$('input, textarea').placeholder();

		/* DISABLED BUTTONS ------------- */
		/* Gives elements with a class of 'disabled' a return: false; */

	}); // end of doc ready

})(jQuery, this);
