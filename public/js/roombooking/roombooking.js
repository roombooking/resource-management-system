(function() {
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
			"tinycolor" : "/js/vendor/tinycolor",
			"jstree" : "/js/jstree/dist/jstree"
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
				 * 
				 * TODO Use the same RegEx the application uses to
				 * validate passwords.
				 */
				Foundation.libs.abide.settings.patterns.password = /\S/;
				
				
				/*
				 * Get rid of the seconds for the time validation.
				 */
				Foundation.libs.abide.settings.patterns.time = /(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])/;
				
				/*
				 * Custom fields for form validation
				 */
				Foundation.libs.abide.settings.patterns.shortfield = /^.{0,256}$/;
				Foundation.libs.abide.settings.patterns.shortfieldrequired = /^.{4,256}$/;
				
				Foundation.libs.abide.settings.patterns.longfield = /^.{0,2048}$/;
				Foundation.libs.abide.settings.patterns.longfieldrequired = /^.{4,2048}$/;
				
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
