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
				require([ "fullcalendar", "jqueryui", "jqueryredirect" ], function() {
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
						ignoreTimezone : false,
						
						/*
						 * Determines the time-text that will be displayed on each event.
						 */
						timeFormat : {
							agenda: "H:mm{ - H:mm}",
							"": "H:mm"
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
						 * Triggered when the user clicks an event.
						 */
						eventClick : function(event, jsEvent, view) {
							/*
							 * Obtain the event databse ID from the classname of the HTML element 
							 */
							var eventId = (function() {
								var bookingClassRegEx = new RegExp("(booking)(_)(\\d+)", [ "i" ]); 
								
								for (var i = 0; i < event.className.length; i++) {
									var bookingMatch = bookingClassRegEx.exec(event.className[ i ]);
									
									if (bookingMatch !== null) {
										return bookingMatch[3];
									}
								}
								return null;
							})();
							
							$.get("bookings/" + eventId + "/details/api",function(data) {
								var event = data[0];
								
								var modal = $("<div/>", {
									"class": "content"
								})
									.append($("<row/>")
										.append($("<div/>", {
												"class": "large-12 column"
											})
											.append($("<h2/>", {
													"text": " "
												})
												.append($("<span/>", {
													"text": event.b_name
												}))
												.prepend($("<i/>", {
													"class": (event.p_placeid !== null ? "fa fa-home" : "fa fa-archive")
												})))))
									.append($("<row/>")
										.append($("<div/>", {
												"class": "large-12 column"
											})
											.append((event.b_description === null ? "" : $("<p/>", {
												"class": "lead",
												"text": event.b_description
											})))))
									.append($("<row/>")
										.append($("<div/>", {
											"class": "large-6 column",
											"html": "<p>Start:<br><strong>" + getNiceDate(new Date(event.b_start), (event.b_isprebooking === "1" ? true : false)) + "</strong></p>"
										}))
										.append($("<div/>", {
											"class": "large-6 column",
											"html": "<p>End:<br><strong>" + getNiceDate(new Date(event.b_end), (event.b_isprebooking === "1" ? true : false)) + "</strong></p>"
										})))
									.append($("<row/>")
										.append($("<div/>", {
											"class": "large-6 column",
											"id" : "u_b_userid_column_" + event.u_b_userid,
											"html": "<p>Reserved by:<br><i class=\"fa fa-user\"></i> <strong>" + event.u_b_firstname + " " + event.u_b_lastname + "</strong> (" + event.u_b_emailaddress + ")</p>"
										}))
										.append(

											(event.u_r_userid !== null ? $("<div/>", {
												"class": "large-6 column",
												"id" : "u_r_userid_column_" + event.u_r_userid,
												"html": "<p>Responsible:<br><i class=\"fa fa-user\"></i> <strong>" + event.u_r_firstname + " " + event.u_r_lastname + "</strong> (" + event.u_r_emailaddress + ")</p>"
											}) : "")

										))

								.append(

									(event.b_participant_description !== null ? $("<row/>")
										.append($("<div/>", {
											"class": "large-12 column",
											"html": "<p>Participants:<br><i class=\"fa fa-users\"></i> " + event.b_participant_description + "</p>"
										})) : "")


								)

								.append($("<row/>")
									.append($("<div/>", {
											"class": "large-12 column"
										})
										.append($("<ul/>", {
												"class": "button-group"
											})
											.append($("<li/>")
												.append($("<a/>", {
													"class": "button",
													"href": "/bookings/" + event.b_bookingid + "/show",
													"html": "View Booking"
												})))
											.append($("<li/>")
												.append($("<a/>", {
													"class": "button",
													"href": "/bookings/" + event.b_bookingid + "/edit",
													"html": "<i class=\"fa fa-pencil\"></i> Edit Booking"
												})))
											.append($("<li/>")
												.append($("<a/>", {
													"class": "button alert",
													"href": "/bookings/" + event.b_bookingid + "/delete",
													"html": "<i class=\"fa fa-eraser\"></i> Delete Booking"
												}).on( "click", function() {
													var r = confirm("Are you sure?");
													
													if (r == true) {
														return true;
													} else {
														return false;
													}
												}))))))
									.append($("<a/>", {
										"class": "close-reveal-modal",
										"html": "&#215;"
									}));
								
								$("#bookingModal .content").replaceWith(modal);
								
								$("#bookingModal").foundation("reveal", "open");
							});
						},
						
						/*
						 * Triggered when the user clicks on a day.
						 */
						dayClick : function(date, allDay, jsEvent, view) {
							
						},
						
						/*
						 * Triggered after an event has been placed on the calendar in its final position.
						 */
						eventAfterRender : function(event, element, view) {
							// TODO
						},
						
						/*
						 * Triggered when event resizing begins.
						 */
						eventResizeStart : function(event, jsEvent, ui, view) {
							
						},
						
						/*
						 * Triggered when event dragging begins.
						 */
						eventDragStart : function(event, jsEvent, ui, view) {
							
						},
						
						/*
						 * Called before an event's element is removed from the DOM.
						 */
						eventDestroy : function(event, element, view) {
							
						},
						
						/*
						 * You can put any number of event arrays, functions, JSON feed URLs, or
						 * full-out Event Source Objects into the eventSources array.
						 */
						eventSources : [
							{
								url : "/bookings/list/api"
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
								className : "booking booking_" + event.b_bookingid + " resource_" + event.b_resourceid,
								title : event.b_name,
								start : event.b_start,
								end : event.b_end,
								allDay : (event.b_isprebooking === "1" ? true : false),
								url : "",
								// editable : true	// TODO set editing permissions for the calendar
							};
							
							if (event.r_color !== null) {
								/*
								 * A specific color should be used for this resource.
								 * Build the colors for the border here.
								 */
								try {
									var basecolor = tinycolor(event.r_color);
									
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
						 * 
						 * TODO Enable changing appointments by dragging. 
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
						var startTime = $.fullCalendar.parseDate(startDate).getTime();
						var endTime = $.fullCalendar.parseDate(endDate).getTime();
						
						$().redirect("/bookings/edit", {
							/*
							 * Provide timestamps as "UNIX" timestamps (no milliseconds).
							 * Math.round the results (integer like string expected).
							 */
							"startTime": Math.round(startTime / 1000),
							"endTime": Math.round(endTime / 1000),
							"allDay" : allDay
						});
						
					};
					
					var editBooking = function (event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {			

						alert("editBooking");
					};
					
					/*
					 * http://www.webdevelopersnotes.com/tips/html/javascript_date_and_time.php3
					 */
					var getNiceDate = function(date, allDay) {
						var curr_date = date.getDate();
						
						var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						
						var sup = "";
						if (curr_date == 1 || curr_date == 21 || curr_date == 31) {
							sup = "st";
						} else if (curr_date == 2 || curr_date == 22) {
							sup = "nd";
						} else if (curr_date == 3 || curr_date == 23) {
							sup = "rd";
						} else {
							sup = "th";
						}
						
						if (allDay) {
							return (date.getDate() + "<sup>" + sup + "</sup> " + months[date.getMonth()] + " " + date.getFullYear());
						} else {
							var minutes = new String(date.getMinutes());
							
							if (minutes.length == 1) {
								minutes = "0" + minutes;
							}
							
							return (date.getDate() + "<sup>" + sup + "</sup> " + months[date.getMonth()] + " " + date.getFullYear() + " " + date.getHours() + ":" + minutes);
						}
					};
				});
			});
		});
	});
})();