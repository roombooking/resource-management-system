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
					var resourceTreeElement = $("#resourcetreeditor");
					
					/*
					 * Use the gobal variable provided by the template
					 * in order to obtain the hierarchy id.
					 */
					var hierarchyId = window.roombooking.hierarchyId;
					
					/**
					 * Render the ressource Tree
					 */
					(function() {
						$.get("/hierarchies/" + hierarchyId + "/containment/api", function(data) {
							/*
							 * The array holding the tree in the appropriate jsTree format
							 * http://www.jstree.com/docs/json/
							 */
							var jsTreeData = [];
							
							/*
							 * Iterate Resources
							 */
							for (var i = 0; i < data.length; i++) {
								var resource = data[i];
								
								/*
								 * Parse the data from the API to a format suitable
								 * for jsTree
								 */
								var jsTreeNode = {
										"id" : ("hierarchy_" + hierarchyId + "_node_" + resource.r_resourceid),
										"parent" : (resource.c_parent === null ? "#" : ("hierarchy_" + hierarchyId + "_node_" + resource.c_parent)),
										"text" : resource.r_name,
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
							resourceTreeElement.jstree({
									"core": {
										"animation": 0,
										"check_callback": true,
										"data": jsTreeData,
										"multiple": false
									},
									"plugins": [
										"dnd", "contextmenu"
									],
									"contextmenu": {
								        "items": function ($node) {
								            return {
								                "Create": {
								                    "label": "Add a new resource",
								                    "action": function (obj) {
								                    	var parentId = $node.id.split('_')[3];
								                    	
								                    	var modal = $("<div/>", {
															"class": "content",
															"html" : '<div class="row"> <div class="large-6 columns"> <label>Resource Name <input type="text" placeholder="Resource Name" id="resourcename" /> </label> </div> <div class="medium-2 columns"> <label>Bookable</label> <input id="resourcebookable" type="checkbox"><label for="resourcebookable">Bookable</label> </div> <div class="medium-4 columns"> <label>Which type of resource do you want to add</label> <p> <input type="radio" name="resource" value="equipment" id="resourceequipment" checked> <label for="resourceequipment"><i class="fa fa-archive"></i> Equipment</label> <input type="radio" name="resource" value="room" id="resourceroom"><label for="resourceroom"><i class="fa fa-home"></i> Room</label> </p> </div> </div> <div class="row"> <div class="large-12 columns"> <label>Resource Description <small>optional</small> <textarea placeholder="Resource Description" id="resourcedescription"></textarea> </label> </div> </div> <div class="row"> <div class="large-12 columns"> <div data-alert class="alert-box warning resourcewarning" style="display: none;"> Please provide a resource name. </div> </div> </div> <div class="row"> <div class="large-12 columns"> <a href="#" id="resourceformbutton" class="button">Add Resource</a> </div> </div>'
														});
														
														$("#resourceModal .content").replaceWith(modal);
														
														$("#resourceModal .content #resourceformbutton").on("click", function() {
															var resourceName = $("#resourcename").val();
															var resourceDescription = $("#resourcedescription").val();
															var resourceType = $("input[name='resource']:checked").val();
															var resourceBookable = $("#resourcebookable").prop("checked") ? 1 : 0;
															var resourceColor = $("#resourcecolor").val();
															
															if (resourceName !== "" && resourceType !== "") {
																/*
																 * Make API call to add the node
																 */
																$.post("/hierarchies/" + hierarchyId + "/resources/add/api", {
																	"resourceName" : resourceName,
																	"resourceDescription" : resourceDescription,
																	"resourceType" : resourceType,
																	"resourceBookable" : resourceBookable,
																	"resourceColor" : resourceColor,
																	"parentId" : parentId
																}).done(function(data) {
																	var resourceid = data.resourceid;
																	
																	if (resourceid % 1 === 0 && data.success === true ) {
																		/*
																		 * We have received an Integer. Continue.
																		 * 
																		 * TODO Add node to tree
																		 */
																		var newTreeNode = {
																			"id" : ("hierarchy_" + hierarchyId + "_node_" + resourceid),
																			"parent" : $node.id,
																			"text" : resourceName,
																			"icon" : (resourceType ==="equipment" ? "fa fa-archive" : "fa fa-home"),
																			"state" : {
																			    /*
																			     * Disable selecting non-bookables
																			     */
																				"disabled" : (resourceBookable === "0" ? true : false),
																				
																				/*
																				 * Open all non-bookables
																				 */
																			    "opened" : (resourceBookable === "0" ? true : false)
																			 },
																			 "a_attr" : {
																				 "resourceid" : resourceid
																			 }
																		};
																		
																		resourceTreeElement.jstree("create_node", $node.id, newTreeNode, "last", false, false);
																		
																	} else {
																		alert('Error: node could not be correctly created, check the log');
																	}
																	
																	/*
																	 * Hide the modal
																	 */
																	$("#resourceModal").foundation("reveal", "close");
																});
															} else {
																$(".resourcewarning").show();
															}
														});
														
														$("#resourceModal").foundation("reveal", "open");
								                        
								                    	
								                    }
								                },
								                "Edit": {
								                    "label": "Edit resource",
								                    "action": function (obj) {					                    	
								                    	var hierarchyId = $node.id.split('_')[1];
								                    	var resourceId = $node.id.split('_')[3];
								                    	
								                    	$.get("/hierarchies/" + hierarchyId + "/resources/" + resourceId + "/api", function(data) {
								                    		var resource = data[0];
								                    		var modal = $("<div/>", {
																"class": "content",
																"html" : '<div class="row"> <div class="large-6 columns"> <label>Resource Name <input type="text" placeholder="Resource Name" id="resourcename" value="' + resource.r_name + '" /> </label> </div> <div class="medium-2 columns"> <label>Bookable</label> <input id="resourcebookable" type="checkbox" ' +  (resource.r_isbookable == 1 ? "checked" : "") + '><label for="resourcebookable">Bookable</label> </div> <div class="medium-4 columns"> <label>Which type of resource do you want to add</label> <p> <input type="radio" name="resource" value="equipment" id="resourceequipment" ' +  (resource.e_equipmentid !== null ? "checked" : "") + '> <label for="resourceequipment"><i class="fa fa-archive"></i> Equipment</label> <input type="radio" name="resource" value="room" id="resourceroom" ' +  (resource.p_placeid !== null ? "checked" : "") + '><label for="resourceroom"><i class="fa fa-home"></i> Room</label> </p> </div> </div> <div class="row"> <div class="large-12 columns"> <label>Resource Description <small>optional</small> <textarea placeholder="Resource Description" id="resourcedescription">' + (resource.r_description === null ? '' : resource.r_description) + '</textarea> </label> </div> </div> <div class="row"> <div class="large-12 columns"> <div data-alert class="alert-box warning resourcewarning" style="display: none;"> Please provide a resource name. </div> </div> </div> <div class="row"> <div class="large-12 columns"> <a href="#" id="resourceformbutton" class="button">Edit Resource</a> </div> </div>'
															});
															
															$("#resourceModal .content").replaceWith(modal);
															
															$("#resourceModal .content #resourceformbutton").on("click", function() {
																var resourceName = $("#resourcename").val();
																var resourceDescription = $("#resourcedescription").val();
																var resourceType = $("input[name='resource']:checked").val();
																var resourceBookable = $("#resourcebookable").prop("checked") ? 1 : 0;
																var resourceColor = $("#resourcecolor").val();
																
																
																if (resourceName !== "" && resourceType !== "") {
																	/*
																	 * Make API call to add the node
																	 */
																	$.post("/hierarchies/" + hierarchyId + "/resources/" + resourceId + "/edit/api", {
																		"resourceName" : resourceName,
																		"resourceDescription" : resourceDescription,
																		"resourceType" : resourceType,
																		"resourceBookable" : resourceBookable,
																		"resourceColor" : resourceColor
																	}).done(function(data) {
																		/*
																		 * Check the result
																		 * 
																		 */
																		if(data.success === true) {
																			/*
																			 * Hide the modal
																			 */
																			$("#resourceModal").foundation("reveal", "close");
																			//TODO edit just the node -> not force page to reload
																			window.location.reload();
																		} else {
																			alert('Resource could not be edited.');
																		}
																	});
																} else {
																	$(".resourcewarning").show();
																}
															});
															
															$("#resourceModal").foundation("reveal", "open");
								                    		
														});
								                    }
								                },
								                "Delete": {
								                    "label": "Delete a resource",
								                    "action": function (obj) {
								                    	var r = confirm("Are you sure?");
														
														if (r == true) {
									                    	var resourceId = $node.id.split('_')[3];
															$.get("/hierarchies/" + hierarchyId + "/resources/" + resourceId + "/delete/api", function(data) {
																if(data.success === true) {
																	resourceTreeElement.jstree("delete_node",$node.id);
																} else {
																	alert('Error: Resource could not be deleted!');
																}
															});
														} else {
															
														}
								                    }
								                }
								            };
								        }
								    }
								}).on('move_node.jstree', function (e, data) {
									var resourceId = data.node.a_attr.resourceid;
			                    	var newParentId = data.parent.split('_')[3];
			                    	//var oldParentId = data.old_parent.split('_')[3];
			                    	
			                    	$.post("/hierarchies/" + hierarchyId + "/resources/" + resourceId + "/update/api", {
										"newParentId" : newParentId
									}).done(function(data) {
										/*
										 * Check the result
										 * 
										 */
										if(data.success === false) {
											resourceTreeElement.jstree("refresh");
										}
										
										/*
										 * Hide the modal
										 */
										$("#resourceModal").foundation("reveal", "close");
									});			                    	
							    });
						});
					})();
				});
			});
		});
	});
})();