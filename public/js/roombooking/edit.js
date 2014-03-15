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
				 * Require jstree
				 */
				require([ "jstree" ], function() {
					/*
					 * The base tree element conatining all
					 * resources
					 */
					var resourceTreesContainer = $("#resourcetree");
					
					/*
					 * The maximum length of the name of a resource
					 * before it is truncated.
					 */
					var resourceNameMaxLenght = 20;
					
					$.get("/hierarchies/containment/api", function(data) {
						var hierachies = {};
						
						/*
						 * Prepare the hierarchies object tree in order to
						 * allow creation of multiple trees for different hierarchies
						 * later. 
						 */
						for (var i = 0; i < data.length; i++) {
							var hierarchyId = data[i]["h_hierarchyid"];
							
							if (hierachies[hierarchyId] === undefined) {
								hierachies[hierarchyId] = [];
							}
							
							hierachies[hierarchyId].push(data[i]);
						}
						
						for (var hierarchyId in hierachies) {
							var hierarchy = hierachies[hierarchyId];
							
							/*
							 * The data to build the current jsTree of.
							 */
							var jsTreeData = [];
							
							var treeContainer = $("<div/>", {
								"class": "hierarchy hierarchy_" + hierarchyId
							});
							
							resourceTreesContainer.prepend(treeContainer);
							
							for (var i = 0; i < hierarchy.length; i++) {
								var resource = hierarchy[i];
								
								var jsTreeNode = {
									"id" : ("hierarchy_" + hierarchyId + "_node_" + resource.r_resourceid),
									"parent" : (resource.c_parent === null ? "#" : ("hierarchy_" + hierarchyId + "_node_" + resource.c_parent)),
									"text" : (resource.r_name.length > 20 ? (resource.r_name.substring(0, resourceNameMaxLenght) + "...") : resource.r_name),
									"icon" : (resource.e_equipmentid !== null ? "fa fa-archive" : "fa fa-home"),
									"state" : {
									    /*
									     * Disable selecting non-bookables
									     */
										"disabled" : (resource.r_isbookable === "0" ? true : false),
										
										/*
										 * Open all non-bookables
										 */
									    "opened" : (resource.r_isbookable === "0" ? true : false)
									 },
									 "a_attr" : {
										 "resourceid" : resource.r_resourceid
									 }
								};
								
								jsTreeData.push(jsTreeNode);
							}
							
							/*
							 * Create JStree
							 */
							treeContainer.on(
								"select_node.jstree", function(event, data) {
									$("input[name=resourceid]").val($("#" + data.selected + ">a").attr("resourceid"));
									
									/*
									 * Triggert the validation process
									 */
									triggerValidation();
								}).jstree({
									"core" : {
										"data" : jsTreeData
									},
									"plugins": [
										"wholerow"
									]
							});
						}
					});
					
					$(".daterow :input").on("change", function() {
						copyDatesToTimestamps();
						triggerValidation();
					});
					
					/*
					 * Handle the "convert to booking" click
					 */
					$("#convertbookingtype").on("click", function() {
						if (window.roombooking.isPrebooking) {
							/*
							 * This booking is a pre-booking
							 * Convert to normal booking
							 */
							window.roombooking.isPrebooking = false;
							$("input[name=isprebooking]").val(window.roombooking.isPrebooking);
							$("div.bookingtime").show();
							$(this).html("<i class=\"fa fa-undo\"></i> Convert to pre-booking");
						} else {
							/*
							 * This booking is a normal booking
							 * Convert to pre-booking
							 */
							window.roombooking.isPrebooking = true;
							$("input[name=isprebooking]").val(window.roombooking.isPrebooking);
							
							$("div.bookingtime").hide();
							
							$("input[name=endtime], input[name=starttime]").val("00:00");
							
							copyDatesToTimestamps();
							
							$(this).html("<i class=\"fa fa-undo\"></i> Convert to authoritative booking");
						}
						
						triggerValidation();
					});
					
					var lockForm = function() {
						$("input[name=submit]").addClass("disabled").attr("disabled", "");
					};
					
					var unLockForm = function() {
						$("input[name=submit]").removeClass("disabled").removeAttr("disabled");
					};
					
					var createWarnings = function (errors) {
						console.log("errors");
						console.log(errors);

						var errorElements = {
							"endBeforeStart" : ".endbeforestart_warning",
							"invalidDateInput" : ".invaliddateinput_warning",
							"invalidResourceSelection" : ".invalideresourceselection_warning",
							"overLappingResourceBooking" : ".overlappingresourcebooking_wanrning"
						};
						
						/*
						 * Hide all errors
						 */
						for (var errorId in errorElements) {
							console.log("hide " + errorElements[errorId]);
							$(errorElements[errorId]).hide();
						}
						
						var hasError = false;
						
						/*
						 * Selectively display errros
						 */
						for (var errorId in errorElements) {
							if (errors[errorId]) {
								hasError = true;
								
								$(errorElements[errorId]).show();
								
								if (errorId === "overLappingResourceBooking") {
									$(".overlappingresourcebooking_wanrning .overlappingresourcebooking_name").text(errors.collidingBooking.collidingBookingName);
								}
							}
						}
						
						if (hasError) {
							lockForm();
						} else {
							unLockForm();
						}
					};
					
					var triggerValidation = function() {
						var errors = {
							"endBeforeStart" : false,
							"invalidDateInput" : false,
							"invalidResourceSelection" : false,
							"overLappingResourceBooking" : false
						};
						
						var isPrebooking = window.roombooking.isPrebooking;
						
						/*
						 * The following variables will be filled during validation
						 */
						var startDate = getValidDate($("input#startdate").val(), $("input#starttime").val());
						var endDate = getValidDate($("input#enddate").val(), $("input#endtime").val());
						var hierachyId = null;
						var resourceId = null;
						
						/*
						 * 1 - Check invalid date input
						 */
						if (startDate === null || endDate === null) {
							errors.invalidDateInput = true;
						} else {
							/*
							 * 2 - Check end before start
							 */
							if (endBeforeStart(startDate, endDate)) {
								errors.endBeforeStart = true;
							}
						}
						
						/*
						 * 3 - Check if exactly 1 resource is selected
						 */
						
						var selectedResources = getSelectedResources();
						
						if (selectedResources.length == 1) {
							hierachyId = selectedResources[0].hierachyId;
							resourceId = selectedResources[0].resourceId;
						} else {
							errors.invalidResourceSelection = true;
						}
						
						/*
						 * 4 - Check if bookings are overlapping
						 * Only check the overlap if there is no other error and
						 * it is nor a pre-booking (pre-bookings do not block)
						 */
						if(!errors.endBeforeStart && !errors.invalidDateInput && !errors.invalidResourceSelection && !window.roombooking.isPrebooking) {
							/*
							 * Lock form to prevent submits during AJAX request.
							 * (Form will be unlocked by createWarnings method)
							 */
							lockForm();
							
							$.get("/bookings/checkcollision/api", {
								"start" : (startDate.getTime() / 1000),
								"end" : (endDate.getTime() / 1000),
								"hierarchyid" : hierachyId,
								"resourceid" : resourceId
							}).done(function(data) {
								if (!data.validRequest || !data.validResource || data.collision) {
									errors.overLappingResourceBooking = true;
									errors.collidingBooking = data.collidingBooking;
									createWarnings(errors);
								} else {
									createWarnings(errors);
								}
							}).error(function(){
								errors.overLappingResourceBooking = true;
								createWarnings(errors);
							});
						} else {
							createWarnings(errors);
						}
					};
					
					/**
					 * Validation functions
					 */
					var getValidDate = function(date, time) {
						var matchDate = function(dateString) {
							var dateRegEx = new RegExp("(\\d+)(.)(\\d+)(.)(\\d+)", ["i"]);
							var dateMatch = dateRegEx.exec(dateString);
							
							if (dateMatch !== null) {
								return {
									"day" : dateMatch[5],
									"month" : (dateMatch[3] - 1),	// Integer value representing the month, beginning with 0 for January to 11 for December
																	// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date
									"year" : dateMatch[1]
								};
							} else {
								return null;
							}
						};
						
						var matchTime = function(timeString) {
						      var timeRegEx = new RegExp("(\\d+)(.)(\\d+)", ["i"]);
						      var timeMatch = timeRegEx.exec(timeString);
						      
						      if (timeMatch !== null) {
						          return {
						        	"hours" : timeMatch[1],
						        	"minutes" : timeMatch[3]
						          };
						      } else {
						    	  return null;
						      }
						};
						
						var matchedDate = matchDate(date);
						var matchedTime = matchTime(time);
						
						if (matchedDate !== null && matchedTime !== null) {
							try {
								var d = new Date(matchedDate.year, matchedDate.month, matchedDate.day, matchedTime.hours, matchedTime.minutes, 0, 0);
								return d;
							} catch (ignore) {
								/*
								 * Can't parse Date/Time
								 */
								return null;
							}
						} else {
							/*
							 * Invalid syntax for Date/Time
							 */
							return null;
						}
					};
					
					var endBeforeStart = function (start, end) {
						return (start.getTime() > end.getTime() ? true : false);
					};
					
					var getSelectedResources = function() {
						var resources = [];
						
						var elementIdRegEx = new RegExp("(hierarchy)(_)(\\d+)(_)(node)(_)(\\d+)", ["i"]); 
						
						resourceTreesContainer.find(".jstree").each(function(i) {
							var selected = $(this).jstree("get_selected");
							
							for (var i = 0; i < selected.length; i++) {
								var elementIdMatch = elementIdRegEx.exec(selected[i]);
								
								if (elementIdMatch !== null) {
									var resource = {
										"hierachyId" : elementIdMatch[3],
										"resourceId" : elementIdMatch[7]
									};
									
									resources.push(resource);
								}
							}
						});
						
						return resources;
					};
					
					var copyDatesToTimestamps = function () {
						var start = getValidDate($("input#startdate").val(), $("input#starttime").val());
						var end = getValidDate($("input#enddate").val(), $("input#endtime").val());
						
						var startTimeStampField = $("input#starttimestamp");
						var endTimeStampField = $("input#endtimestamp");
						
						if (start !== null && end !== null) {
							startTimeStampField.val(start.getTime() / 1000);
							endTimeStampField.val(end.getTime() / 1000);
						} else {
							startTimeStampField.val("-1");
							endTimeStampField.val("-1");
						}
					};
					
					copyDatesToTimestamps();
					
					/*
					 * Lock form when running first
					 */
					lockForm();
				});
			});
		});
	});
})();