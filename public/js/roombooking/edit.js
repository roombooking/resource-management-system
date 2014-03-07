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
				var resourceTreeElement = $("#resourcetree");
				
				$.get("/resources/containment/api", function(data) {
					var hierachies = {};
					var tree = {};
					
					/*
					 * Group ressources according to their hierachies
					 */
					for (var i = 0; i < data.length; i++) {
						var hierachyId = data[i]["h_hirachyid"];
						var resourceId = data[i]["r_resourceid"];
						
						if (hierachies[hierachyId] === undefined) {
							hierachies[hierachyId] = {};
						}
						
						hierachies[hierachyId][resourceId] = data[i];
						hierachies[hierachyId][resourceId]["children"] = {};
					}
					
					var populateTree = function () {
						var empty = true;
						
						for (var hierachyId in hierachies) {
							empty = false;
							var hierachy = hierachies[hierachyId];
							
							var hierachyEmpty = true;
							for (var resourceId in hierachy) {
								hierachyEmpty = false;
								var resource = hierachy[resourceId];
								
								if (resource["c_parent"] === null) {
									/*
									 * Parent Node
									 */
									tree[resource.r_resourceid] = resource;
									
									/*
									 * Remove copied reccources
									 */
									delete hierachies[hierachyId][resourceId];
								} else {
									/*
									 * Non-parent node. Try to find a parent
									 */
									console.log(resource.c_parent);
								}
							}
							
							if (hierachyEmpty) {
								delete hierachies[hierachyId];
							}
						}
						
						if (!emtpy) {
							populateTree();
						}
					};
					
					populateTree();
					
					console.log(tree);
				});
			});
		});
	});
})();