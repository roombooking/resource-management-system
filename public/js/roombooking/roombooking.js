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
			"jquery" : "js/vendor/jquery",
			"foundation" : "js/foundation.min",
			"fullcalendar" : "js/fullcalendar/fullcalendar",
			"foldtoascii" : "js/vendor/fold-to-ascii.js"
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
			/*
			 * Run foundation initialisation code
			 */
			$(document).foundation();
		});
	});
})();