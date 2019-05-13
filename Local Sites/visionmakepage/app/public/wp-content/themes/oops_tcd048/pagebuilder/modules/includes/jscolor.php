<?php

/**
 * jscolor 管理画面用js
 */
function page_builder_jscolor_admin_scripts() {
	wp_enqueue_script('page_builder-jscolor', get_template_directory_uri().'/pagebuilder/assets/admin/js/jscolor.js', array('jquery'), PAGE_BUILDER_VERSION, true);
}
add_action('page_builder_admin_scripts', 'page_builder_jscolor_admin_scripts', 11);

