(function() {
	/*
	 * Global variable to share settings for the Roombooking GUI
	 */
	window.roombooking = {
		
	};
	
	requirejs.config({
		/*
		 * Hold the path for required JavaScript libraries
		 * here.
		 */
		paths : {
			"foundation" : "/js/foundation.min",
			"jquery" : "/js/vendor/jquery",
			"jqueryui" : "/js/vendor/jquery-ui-1.10.4.custom",
			"jqueryredirect" : "/js/vendor/jquery.redirect",
			"fullcalendar" : "/js/fullcalendar/fullcalendar",
			"foldtoascii" : "/js/vendor/fold-to-ascii",
			"tinycolor" : "/js/vendor/tinycolor"
		}
	});
	
	/*
	 * Require jQuery
	 */
	require(["jquery"], function() {
		
		/*
		 * Require Foundation
		 */
		require(["foundation"], function() {
			$(document).ready(function(){
				/*
				 * Overwrite the Foundation default password
				 * RegEx with a trivial one (non-empty strings) for
				 * a more failsave password validation on login.
				 */
				Foundation.libs.abide.settings.patterns.password = /\S/;
				
				/*
				 * Run foundation initialisation code,
				 * configure foundation
				 */
				$(document).foundation({
					/*
					 * Foundation config here
					 */
				});
			});
		});
	});
})();