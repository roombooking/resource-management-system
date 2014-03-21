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
							resourceTreeElement.on(
								'changed.jstree', function (e, data) {
								    console.log('changed: ' + data.selected);
								  })
								.jstree({
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
								                    	console.log($node);
								                    	
								                    	var parentId = $node.id.split('_')[3];
								                    	
								                    	
								                    	var modal = $("<div/>", {
															"class": "content",
															"html" : '<div class="row"> <div class="large-6 columns"> <label>Resource Name <input type="text" placeholder="Resource Name" id="resourcename" /> </label> </div> <div class="medium-2 columns"> <label>Bookable</label> <input id="bookable" type="checkbox"><label for="bookable">Bookable</label> </div> <div class="medium-4 columns"> <label>Which type of resource do you want to add</label> <p> <input type="radio" name="resource" value="equipment" id="resourceequipment" checked> <label for="resourceequipment"><i class="fa fa-archive"></i> Equipment</label> <input type="radio" name="resource" value="room" id="resourceroom"><label for="resourceroom"><i class="fa fa-home"></i> Room</label> </p> </div> </div> <div class="row"> <div class="large-12 columns"> <label>Resource Description <small>optional</small> <textarea placeholder="Resource Description" id="resourcedescription"></textarea> </label> </div> </div> <div class="row"> <div class="large-12 columns"> <div data-alert class="alert-box warning resourcewarning" style="display: none;"> Please provide a resource name. </div> </div> </div> <div class="row"> <div class="large-12 columns"> <a href="#" id="resourceformbutton" class="button">Add Resource</a> </div> </div>'
														});
														
														$("#resourceModal .content").replaceWith(modal);
														
														$("#resourceModal .content #resourceformbutton").on("click", function() {
															var resourceName = $("#resourcename").val();
															var resourceDescription = $("#resourcedescription").val();
															var resourceType = $("#resourceroom").val();
															var bookable = $("#bookable").prop("checked");
															
															if (resourceName !== "" && resourceType !== "") {
																/*
																 * Make API call to add the node
																 */
																$.post("/hierarchies/" + hierarchyId + "/resources/add/api", {
																	"resourceName" : resourceName,
																	"resourceDescription" : resourceDescription,
																	"resourceType" : resourceType,
																	"bookable" : bookable,
																	"parent" : parentId
																}).done(function(data) {
																	var resourceid = data.resourceid;
																	
																	if (resourceid % 1 === 0) {
																		/*
																		 * We have received an Integer. Continue.
																		 * 
																		 * TODO Add node to tree
																		 */
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
								                    	alert('Not yet implemented.');
								                        console.log(obj);
								                    }
								                },
								                "Delete": {
								                    "label": "Delete an employee",
								                    "action": function (obj) {
								                        alert('Not yet implemented.');
								                        console.log(obj);
								                    }
								                }
								            };
								        }
								    }
								}).on('move_node.jstree', function (e, data) {
									for(var i in data) {
										console.log( i + ': ' + data[i]);
										
								    }
									console.log(data['node']['id']);
							    });
							
							$("a.addresourcebutton").on("click", function() {
								
							});
						});
					})();
					
				});
			});
		});
	});
})();