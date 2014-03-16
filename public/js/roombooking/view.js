/*
 * JavaScript for the detail page in view mode.
 */
(function() {
	/*
	 * Require jQuery
	 */
	require([ "jquery" ], function() {
		$(".deletebooking").on("click", function() {
			var r = confirm("Are you sure?");

			if (r == true) {
				return true;
			} else {
				return false;
			}
		});
	});
})();