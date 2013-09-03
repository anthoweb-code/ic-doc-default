/*
DoC admin scripts
*/

jQuery(document).ready(function($) {
	
	
	/****** ICONS FOR CUSTOM POST TYPES ******/ 
	// Sidebar
	$('.menu-icon-publication .wp-menu-image').append('<i class="icon-book"></i>');
	$('.menu-icon-project .wp-menu-image').append('<i class="icon-lightbulb"></i>');
	$('.menu-icon-person .wp-menu-image').append('<i class="icon-group"></i>');
	$('.menu-icon-grant .wp-menu-image').append('<i class="icon-folder-open"></i>');    
	$('#menu-posts-project').before('<li class="wp-not-current-submenu wp-menu-separator"><div class="separator"></div></li>');
	// List / Edit screens
	$('#icon-edit.icon32-posts-publication').append('<i class="icon-book"></i>');
	$('#icon-edit.icon32-posts-project').append('<i class="icon-lightbulb"></i>');
	$('#icon-edit.icon32-posts-person').append('<i class="icon-group"></i>');
	$('#icon-edit.icon32-posts-grant').append('<i class="icon-folder-open"></i>');
	
	/****** Auto-highlight cite key fields ******/
	//$("#citekey-input:input").focus(function() { $(this).select(); } );
	
}); /* end of as page load scripts */