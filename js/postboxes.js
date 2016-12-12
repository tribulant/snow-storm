jQuery(document).ready(function() {
	jQuery(".if-js-closed").removeClass("if-js-closed").addClass("closed");
	//checking for pagenow assure that the toggle is added only on that page!
	if (typeof(postboxes) !== "undefined" && pagenow=="settings_page_snow-storm") { 
    		postboxes.add_postbox_toggles(pagenow); 
    	}
});
