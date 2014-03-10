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
								"select_node.jstree", function (event, data) {
									/*
									 * TODO
									 */
								})
								.jstree({
									"core": {
										"animation": 0,
										"check_callback": true,
										"data": jsTreeData
									},
									"plugins": [
										"dnd"
									]
								});
							
							$("a#resourcebutton").on("click", function() {
								var modal = $("<div/>", {
									"class": "content",
									"html" : '<div class="row"> <div class="large-6 columns"> <label>Resource Name <input type="text" placeholder="Resource Name" id="resourcename" /> </label> </div> <div class="large-6 columns"> <label>Which type of resource do you want to add</label> <p> <input type="radio" name="resource" value="equipment" id="resourceequipment" checked> <label for="resourceequipment"><i class="fa fa-archive"></i> Equipment</label> <input type="radio" name="resource" value="room" id="resourceroom"><label for="resourceroom"><i class="fa fa-home"></i> Room</label> </p> </div> </div> <div class="row"> <div class="large-12 columns"> <label>Resource Description <textarea placeholder="Resource Description" id="resourcedescription"></textarea> </label> </div> </div> <div class="row"> <div class="large-12 columns"> <a href="#" id="resourceformbutton" class="button">Add Resource</a> </div> </div>'
								});
								
								$("#resourceModal .content").replaceWith(modal);
								
								$("#resourceModal .content #resourceformbutton").on("click", function() {
									var resourceName = $("#resourcename").val();
									var resourceDescription = $("#resourcedescription").val();
									var resourceType = $("#resourceroom").val();
									
									alert("TODO: Add node to tree");
									
									$("#resourceModal").foundation("reveal", "close");
								});
								
								$("#resourceModal").foundation("reveal", "open");
							});
						});
					})();
					
				});
			});
		});
	});
})();