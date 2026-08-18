<?php
	
	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

	/* create custom post for new form category */
	add_action( 'init', 'kbcf_create_Form_Post', 0 );
	function kbcf_create_Form_Post() {
		$labels = array(
		'name'               => _x( 'Forms Categories', 'forms categories', 'contact_form_plugin' ),
		'singular_name'      => _x( 'Form', 'form category', 'contact_form_plugin' ),
		'menu_name'          => _x( 'Form Categories', 'admin menu', 'contact_form_plugin' ),
		'name_admin_bar'     => _x( 'Form Categories', 'add new on admin bar', 'contact_form_plugin' ),
		'add_new'            => _x( 'Add New', 'contact_form_plugin' ),
		'add_new_item'       => __( 'Add New Category', 'contact_form_plugin' ),
		'new_item'           => __( 'New Form Category', 'contact_form_plugin' ),
		'edit_item'          => __( 'Edit Form Category', 'contact_form_plugin' ),
		'view_item'          => __( 'View Form Category', 'contact_form_plugin' ),
		'all_items'          => __( 'Categories', 'contact_form_plugin' ),
		'search_items'       => __( 'Search Form Categories', 'contact_form_plugin' ),
		'parent_item_colon'  => __( 'Parent Form:', 'contact_form_plugin' ),
		'not_found'          => __( 'No Form found.', 'contact_form_plugin' ),
		'not_found_in_trash' => __( 'No Form found in Trash.', 'contact_form_plugin' )
		);

		$args = array(
		'label'               => __( 'formcategories', 'contact_form_plugin' ),
		'labels'              => $labels,
		'description'         => __( 'Description.', 'contact_form_plugin' ),
		'public'              => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'exclude_from_search' => true,
		'show_in_nav_menus'   => false,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'formcategories' ),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'supports'            => array( 'title'),
		'show_in_menu' => 'edit.php?post_type=formcategories',
		);

		register_post_type( 'formcategories', $args );
	}
	
?>