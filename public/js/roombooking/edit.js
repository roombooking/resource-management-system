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
					var resourceTreeElement = $("#resourcetree");
					
					
					/**
					 * Prepare the ressource Tree
					 */
					(function() {
						$.get("/resources/containment/api", function(data) {
							var hierachies = {};
							
							/*
							 * Group ressources according to their hierachies
							 */
							for (var i = 0; i < data.length; i++) {
								var hierachyId = data[i]["h_hirachyid"];
								var resourceId = data[i]["r_resourceid"];
								
								if (hierachies[hierachyId] === undefined) {
									hierachies[hierachyId] = [];
								}
								
								hierachies[hierachyId].push(data[i]);
							}
							
							for (var hierachyId in hierachies) {
								var hierachy = hierachies[hierachyId];
								
								var treeContainer = $("<div/>", {
									"class": "hierachy_" + hierachyId
								});
								
								resourceTreeElement.prepend(treeContainer);
								
								var jsTreeData = [];
								
								for (var i = 0; i < hierachy.length; i++) {
									var resource = hierachy[i];
									
									var jsTreeNode = {
										"id" : ("hierachy_" + hierachyId + "_node_" + resource.r_resourceid),
										"parent" : (resource.c_parent === null ? "#" : ("hierachy_" + hierachyId + "_node_" + resource.c_parent)),
										"text" : resource.r_name,
										"icon" : (resource.e_equipmentid !== null ? "fa fa-suitcase" : "fa fa-home"),
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
								resourceTreeElement.on(
									"select_node.jstree", function(event, data) {
										$("input[name=resourceid]").val($("#" + data.selected + ">a").attr("resourceid"));
									}).jstree({
										"core" : {
											"data" : jsTreeData
										}
								});
							}
						});
					})();
					
					/*
					 * Form Validation
					 */
					(function() {
						var isPrebooking = false; // FIXME
						
						var validateDateTime = function() {
							/*
							 * TODO Lock Input
							 */
							
							var matchDate = function(dateString) {
								var dateRegEx = new RegExp("(\\d+)" + "(\\/)" + "(\\d+)" + "(\\/)" + "(\\d+)", ["i"]);
								var dateMatch = dateRegEx.exec(dateString);

								if (dateMatch !== null) {
									return {
										"day" : dateMatch[1],
										"month" : dateMatch[3],
										"year" : dateMatch[5]
									};
								} else {
									return null;
								}
							};
							
							var matchTime = function(timeString) {
							      var timeRegEx = new RegExp("(\\d+)" + "(:)" + "(\\d+)", ["i"]);
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
							
							/*
							 * TODO grab ID of selected resource
							 */
							
							var startDate = matchDate($("input#startdate").val());
							var startTime = matchTime($("input#starttime").val());
							
							var endDate = matchDate($("input#enddate").val());
							var endTime = matchTime($("input#endtime").val());
							
							if (startDate !== null && startTime !== null && endDate !== null && endTime !== null) {
								/*
								 * Pontentially valid input.
								 * Make the call to find out if it is not conflicting.
								 */
								
								alert("TODO Potentially valid input. Check for overlapping appointments with API");
							}
						};
						
						$(".daterow :input").on("change", function() {
							/*
							 * Only validate the timerange if it is
							 * not a pre-booking.
							 */
							if (!isPrebooking) {
								validateDateTime();
							}
						});
						
						resourceTreeElement.on("select_node.jstree", function(event, data) {
							if (!isPrebooking) {
								validateDateTime();
							}
						});
					})();
				});
			});
		});
	});
})();