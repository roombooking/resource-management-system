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
					$.get("/resources/containment/api", function(data) {
						var hierachies = {};
						var resourceTreeElement = $("#resourcetree");
						
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
							
							resourceTreeElement.append(treeContainer);
							
							var jsTreeData = [];
							
							for (var i = 0; i < hierachy.length; i++) {
								var resource = hierachy[i];
								
								var jsTreeNode = {
									"id" : ("hierachy_" + hierachyId + "_node_" + resource.r_resourceid),
									"parent" : (resource.c_parent === null ? "#" : ("hierachy_" + hierachyId + "_node_" + resource.c_parent)),
									"text" : resource.r_name
								};
								
								jsTreeData.push(jsTreeNode);
							}
							
							/*
							 * Create JStree
							 */
							resourceTreeElement.jstree({
								"core" : {
									"data" : jsTreeData
								}
							});
						}
					});
				});
			});
		});
	});
})();