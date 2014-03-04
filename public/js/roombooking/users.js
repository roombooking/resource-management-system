/*
 * JavaScript for the user view.
 */
(function() {
	require([ "jquery" ], function() {
		require([ "foundation" ], function() {
			require([ "jqueryui" ], function() {
				$("table.users select").on("change", function() {
					var select = $(this);
					var userId = select.data("id");
					var roleId = this.value;
					
					var animationDuration = 1500;
					
					/*
					 * The parent row to attach success/failure messages to.
					 */
					var parentRow = select.closest("tr");
					
					/*
					 * Disable the select to prevent changes while submitting.
					 */
					select.prop("disabled", "disabled");
					
					parentRow.addClass("working");
					
					$.ajax({
						url : "users/update",
						type : "POST",
						data : {
							id : userId,
							role : roleId,
						},
						success : function(data) {
							parentRow.effect("highlight", {
								"duration" : animationDuration,
								"color" : "rgb(67,172,106)"
							});
						},
						error : function() {
							parentRow.effect("highlight", {
								"duration" : animationDuration,
								"color" : "rgb(240,65,36)"
							});
						},
						complete : function() {
							/*
							 * Release the select
							 */
							select.prop("disabled", false);
							parentRow.removeClass("working");
						}
					});
				});
			});
		});
	});
})();