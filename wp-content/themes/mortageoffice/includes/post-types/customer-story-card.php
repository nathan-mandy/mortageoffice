<?php

/**
 * create a custom post type for the customer-story-card
 * create a custom taxonomies for the customer-story-card
 */

function customer_story_card(){
    $lables = array(
        'name' => 'Customer Story',
        'singullar_name' => 'Customer Stories',
        'add_new' => 'Add Customer Story',
        'add_new_item' => 'Add Customer Story',
        'edit_item' => 'Edit Customer Story',
        'new_item' => 'New Customer Story',
        'all_items' => 'All Customer Stories',
        'view_item' => 'View Customer Stories',
        'search_items' => 'Search Customer Story',
        'not_found' => 'No Customer Story found',
        'not_found_in_trash' => 'No Customer Story found in trash',
        'parent_item_colon' => '',
        'menu_name' => 'Customer Story',
    );

    $args = array(
        'labels' => $lables,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capablity_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'customer_-stories'),
        'query_var' => true,
        'menu_icon' => 'dashicons-text-page',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'throwbacks',
            'custom-fields',
            'revisions',
            'comments',
            'thumbnail',
            'author',
            'page_attributes'
        )
    );
    register_post_type('customer_stories',$args);

    register_taxonomy('story_category', 'customer_stories', array(
        'hierarchical' => true,
        'label' => 'Topic',
        'query_var' => true,
        'rewrite' => array('slug' => 'story-category')
    ));

    register_taxonomy('customer_industry', 'customer_stories', array(
        'hierarchical' => true,
        'label' => 'Industry',
        'query_var' => true,
        'rewrite' => array('slug' => 'customer-industry')
    ));
}
add_action( 'init', 'customer_story_card' );