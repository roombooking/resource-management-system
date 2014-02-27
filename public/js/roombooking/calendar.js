/*
 * JavaScript for the calendar view
 */
(function() {
	/*
	 * Require jQuery
	 */
	require([ "jquery" ], function() {

		/*
		 * Require Foundation
		 */
		require([ "foundation" ], function() {

			/*
			 * Require fullcalendar
			 */
			require([ "fullcalendar" ], function() {
				var calendar = $("#calendar");
				
				calendar.fullCalendar({
					/*
					 * Whether to automatically resize the calendar when the
					 * browser window resizes.
					 */
					handleWindowResize : true,
					
					/*
					 * Triggered when a new date-range is rendered, or when the
					 * view type switches.
					 */
					viewRender : function(view, element) {
					    if(view.name === "agendaWeek" || view.name === "agendaDay") {
					        /*
					         * Workaround as suggested in
					         * http://stackoverflow.com/questions/13862942/how-to-make-jquery-fullcalendars-height-fit-its-content#answer-13866473
					         * 
					         * TODO Doesn't work perfectly due to Foundation CSS. Fix it! 
					         */
					    	view.setHeight(10000);
					    }
					},
					
					/*
					 * When parsing ISO8601 dates, whether UTC offsets should be
					 * ignored while processing event source data.
					 */
					ignoreTimezone : false,
					
					/*
					 * Determines the time-text that will be displayed on each event.
					 */
					timeFormat : {
						agenda: "H:mm{ - H:mm}",
						"": "HH(:mm)"
					},
					
					/*
					 * Determines the time-text that will be displayed on the vertical
					 * axis of the agenda views.
					 */
					axisFormat : "H:mm",
					
					/*
					 * The day that each week begins.
					 */
					firstDay : 1,

					/*
					 * Defines the buttons and title at the top of the calendar.
					 */
					header : {
						left : "title",
						center : "",
						right : "today month,agendaWeek,agendaDay prev,next"
					},
					
					dayClick : function(data) {
						alert("Tagesdetailseite ausgeben für " + data);
					},
					
					/*
					 * You can put any number of event arrays, functions, JSON feed URLs, or
					 * full-out Event Source Objects into the eventSources array.
					 */
					eventSources : [
						{
							url : "/api/bookings"
						}
					],
					
					/*
					 * Transforms custom data into a standard Event Object.
					 * 
					 * This is called seperately for every element in the array.
					 */
					eventDataTransform : function(event) {
						/*
						 * FIXME Make this more robust.
						 */
						var fcEvent = {
							title : event.bookingname,
							start : event.bookingstart,
							end : event.bookingend,
							allDay : false,	// FIXME XXX Parse actual attribute
							url : ""
						};
						
						return fcEvent;
					}
				});
			});
		});
	});
})();