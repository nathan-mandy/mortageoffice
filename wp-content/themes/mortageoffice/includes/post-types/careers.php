<?php

function career_init() {
    // set up product labels
    $labels = array(
        'name' => 'Careers',
        'singular_name' => 'Career',
        'add_new' => 'Add New Career',
        'add_new_item' => 'Add New Career',
        'edit_item' => 'Edit Career',
        'new_item' => 'New Career',
        'all_items' => 'All Careers',
        'view_item' => 'View Career',
        'search_items' => 'Search Careers',
        'not_found' =>  'No Careers Found',
        'not_found_in_trash' => 'No Careers found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Careers',
    );
    
    // register post type
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'career'),
        'query_var' => true,
        'menu_icon' => 'dashicons-clipboard',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes'
        )
    );
    register_post_type( 'career', $args );
    
    // register taxonomy
    register_taxonomy('career_department', 'career', array('hierarchical' => true, 'label' => 'Department', 'query_var' => true, 'rewrite' => array( 'slug' => 'career_department' )));
    register_taxonomy('career_emp_type', 'career', array('hierarchical' => true, 'label' => 'Employment Type', 'query_var' => true, 'rewrite' => array( 'slug' => 'career_emp_type' )));
    register_taxonomy('career_location', 'career', array('hierarchical' => true, 'label' => 'Location', 'query_var' => true, 'rewrite' => array( 'slug' => 'career_location' )));
}
add_action( 'init', 'career_init' );