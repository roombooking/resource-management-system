/*
 * JavaScript for the calendar view.
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
			 * Require tinycolor
			 */
			require([ "tinycolor" ], function(tinycolor) {
				
				/*
				 * Require fullcalendar
				 */
				require([ "fullcalendar", "jqueryui" ], function() {
					var calendar = $("#calendar");
					
					calendar.fullCalendar({
						/*
						 * Sets the background color for all events on the calendar.
						 */
						eventBackgroundColor : "rgb(81, 217, 154)",
						
						/*
						 * Sets the border color for all events on the calendar.
						 */
						eventBorderColor : "rgb(78, 185, 142)",
						
						/*
						 * Sets the text color for all events on the calendar.
						 */
						eventTextColor : "rgb(10, 15, 10)",
						
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
						ignoreTimezone : true,
						
						/*
						 * Determines the time-text that will be displayed on each event.
						 */
						timeFormat : {
							agenda: "H:mm{ - H:mm}",
							"": "HH:mm"
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
							 * Properties: http://arshaw.com/fullcalendar/docs/event_data/Event_Object/
							 */
							var fcEvent = {
								className : "booking booking_" + event.bookingid + " resource_" + event.resourceid,
								title : event.bookingname,
								start : event.bookingstart,
								end : event.bookingend,
								allDay : (event.isprebooking === "1" ? true : false),
								url : "",
								editable : true	// FIXME
							};
							
							if (event.resourcecolor !== null) {
								/*
								 * A specific color should be used for this resource.
								 * Build the colors for the border here.
								 */
								try {
									var basecolor = tinycolor(event.resourcecolor);
									
									/*
									 * Possible text colors
									 */
									var textColors = ["rgb(10, 10, 10)", "rgb(245, 245, 245)"];
									
									/*
									 * Chosen text color
									 */
									var textColor = tinycolor.mostReadable(basecolor, textColors);
									
									var borderColor = tinycolor.darken(basecolor, 20);
									
									fcEvent.backgroundColor = basecolor.toRgbString();
									fcEvent.borderColor = borderColor.toRgbString();
									fcEvent.textColor = textColor.toRgbString();
								} catch (ignore) {
									 /*
									  * Something went wrong constructing the colors.
									  * Ignore it.
									  */
								}
								
							}
							return fcEvent;
						},
						
						/*
						 * Allows a user to highlight multiple days or timeslots by clicking and dragging.
						 * 
						 * Default settings for events is that they are not editable.
						 * This gets overwritten by JSON data.
						 */
						editable : false,
						
						/*
						 * Allows a user to highlight multiple days or timeslots by clicking and dragging.
						 */
						selectable : true,
						
						/*
						 * Whether to draw a "placeholder" event while the user is dragging.
						 */
						selectHelper : true,
						
						/*
						 * A callback that will fire after a selection is made.
						 */
						select: function(startDate, endDate, allDay, jsEvent, view) {
							createBooking(startDate, endDate, allDay, jsEvent, view);
//							var title = prompt("Event Title FIXME: render nice popup here");
//							
//							if (title) {
//								calendar.fullCalendar("renderEvent",
//									{
//										title: title,
//										start: start,
//										end: end,
//										allDay: allDay
//									},
//									true // make the event "stick"
//								);
//							}
//							calendar.fullCalendar("unselect");
						},
						/*
						 * Triggered when dragging stops and the event has moved to a _different_ day/time.
						 */
						eventDrop : function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
							editBooking(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view);
						}
					});
					
					var createBooking = function (startDate, endDate, allDay, jsEvent, view) {
						alert("createBooking (" + startDate + ", " + endDate + ", " + allDay + ")");
					};
					
					var editBooking = function (event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
						alert("editBooking");
					};
				});
			});
		});
	});
})();