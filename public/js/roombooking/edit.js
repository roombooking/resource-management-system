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
					 * The base tree element
					 */
					var resourceTreeElement = $("#resourcetree");
					
					/*
					 * An array of tree elements (one per hierarchy)
					 */
					var trees = [];
					
					/*
					 * Reasosn for why the form should be locked.
					 */
					var formlock = {
						"endBeforeStart" : false,
						"invalidDateInput" : false,
						"invalidResourceSelection" : false,
						"overLappingResourceBooking" : false
					};
					
					var validateDateTime = function() {							
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
						
						var startDate = matchDate($("input#startdate").val());
						var startTime = matchTime($("input#starttime").val());
						
						var endDate = matchDate($("input#enddate").val());
						var endTime = matchTime($("input#endtime").val());
						
						var start;
						var end;
						
						if (startDate !== null && startTime !== null && endDate !== null && endTime !== null) {
							try {
								start = new Date(startDate.year, startDate.month, startDate.day, startTime.hours, startTime.minutes, 0, 0);
								end = new Date(endDate.year, endDate.month, endDate.day, endTime.hours, endTime.minutes, 0, 0);
								
								return {
									"start" : start,
									"end" : end
								};
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
					
					
					var createTimestampfromInput = function(dateTime) {
						var startTimestampField = $("input[name=starttimestamp]");
						var endTimestampField = $("input[name=endtimestamp]");
						
						var start = dateTime.start.getTime() / 1000;
						var end = dateTime.end.getTime() / 1000;
						
						startTimestampField.val(start);
						endTimestampField.val(end);
						
						return {
							"start" : start,
							"end" : end
						};
					};
					
					var startBeforeEndHandling = function(times) {
						formlock.endBeforeStart = (times.start < times.end ? false : true);
						lockUnlockForm();
						return (times.start < times.end ? true : false);
					};
					
					var ressourceTreeElementHandling = function(selectedElements) {
						if (selectedElements.length !== 1) {
							formlock.invalidResourceSelection = true;
						} else {
							formlock.invalidResourceSelection = false;
						}
						
						lockUnlockForm();
					};
					
					var overlapHandling = function(selectedElement) {
						/*
						 * Lock the form until response is positive
						 */
						formlock.overLappingResourceBooking = true;
						lockUnlockForm();
						
						var elementIdRegEx = new RegExp("(hierarchy)(_)(\\d+)(_)(node)(_)(\\d+)", ["i"]); 
						var elementIdMatch = elementIdRegEx.exec(selectedElement);

						if (elementIdMatch != null) {
							var hierarchy = elementIdMatch[3];
							var node = elementIdMatch[7];
							var start = Number($("input[name=starttimestamp]").val());
							var end = Number($("input[name=endtimestamp]").val());
					          
							$.get("/bookings/checkcollision/api", {
								"start" : start,
								"end" : end,
								"hierarchyid" : hierarchy,
								"resourceid" : node
							}).done(function(data) {
								console.log(data);
								
								if(data.validRequest && data.validResource && !data.collision) {
									formlock.overLappingResourceBooking = false;
									lockUnlockForm();
								}
							});
						}
					};
					
					var lockUnlockForm = function() {
						console.log("TODO");
						console.log(formlock);
						
						if (formlock.endBeforeStart === false &&
								formlock.invalidDateInput === false &&
								formlock.invalidResourceSelection === false &&
								formlock.overLappingResourceBooking === false) {
							/*
							 * No lock. Unlock form.
							 */
						} else {
							/*
							 * Some lock. Lock form
							 */
						}
					};
					
					/**
					 * Prepare the ressource Tree
					 */
					(function() {
						$.get("/hierarchies/containment/api", function(data) {
							var hierachies = {};
							
							/*
							 * Group ressources according to their hierachies
							 */
							for (var i = 0; i < data.length; i++) {
								var hierarchyId = data[i]["h_hierarchyid"];
								var resourceId = data[i]["r_resourceid"];
								
								if (hierachies[hierarchyId] === undefined) {
									hierachies[hierarchyId] = [];
								}
								
								hierachies[hierarchyId].push(data[i]);
							}
							
							for (var hierarchyId in hierachies) {
								var hierarchy = hierachies[hierarchyId];
								
								var treeContainer = $("<div/>", {
									"class": "hierarchy hierarchy_" + hierarchyId
								});
								
								resourceTreeElement.prepend(treeContainer);
								
								var jsTreeData = [];
								
								for (var i = 0; i < hierarchy.length; i++) {
									var resource = hierarchy[i];
									
									var resourceNameMaxLenght = 20;
									
									var jsTreeNode = {
										"id" : ("hierarchy_" + hierarchyId + "_node_" + resource.r_resourceid),
										"parent" : (resource.c_parent === null ? "#" : ("hierarchy_" + hierarchyId + "_node_" + resource.c_parent)),
										"text" : (resource.r_name.length > 20 ? (resource.r_name.substring(0, 20) + "...") : resource.r_name),
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
										 * Validate the tree selection
										 */
										ressourceTreeElementHandling(data.selected);
										
										/*
										 * Check if the ressource is overlapping.
										 */
										overlapHandling(data.selected[0]);
									}).jstree({
										"core" : {
											"data" : jsTreeData
										},
										"plugins": [
											"wholerow"
										]
								});
								
								trees.push(treeContainer);
							}
						});
					})();
					
					$(".daterow :input").on("change", function() {
						/*
						 * Populate the timestamp fields
						 */
						var dateTime = validateDateTime();
						
						if (dateTime !== null) {
							startBeforeEndHandling(createTimestampfromInput(dateTime));
							
							/*
							 * Iterate over selected nodes
							 * TODO make this more robust
							 */
							resourceTreeElement.find(".hierarchy").find(".jstree-wholerow-clicked").each(function(i) {
								overlapHandling($(this).parent().attr("id"));
							});
						} else {
							formlock.invalidDateInput = true;
							lockUnlockForm();
						}
					});
				});
			});
		});
	});
})();