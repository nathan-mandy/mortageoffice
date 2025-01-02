<?php
namespace Vital\Custom_Post_Type;

class CustomerStoryCard {
        const SLUG = 'customer_stories';
    
    public function __construct() {
        add_action('init', [$this, 'register_customer_story_post_type']);
        add_action('init', [$this, 'register_customer_story_taxonomies']);
    }

    public function register_customer_story_post_type() {
        $labels = array(
            'name'                  => 'Customer Stories',
            'singular_name'         => 'Customer Story',
            'add_new'               => 'Add Customer Story',
            'add_new_item'          => 'Add New Customer Story',
            'edit_item'             => 'Edit Customer Story',
            'new_item'              => 'New Customer Story',
            'all_items'             => 'All Customer Stories',
            'view_item'             => 'View Customer Story',
            'search_items'          => 'Search Customer Stories',
            'not_found'             => 'No Customer Stories found',
            'not_found_in_trash'    => 'No Customer Stories found in Trash',
            'menu_name'             => 'Customer Stories',
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'has_archive'           => true,
            'show_ui'               => true,
            'capability_type'       => 'post',
            'hierarchical'          => false,
            'rewrite'               => array('slug' => 'customer_stories'),
            'query_var'             => true,
            'menu_icon'             => 'dashicons-text-page',
            'supports'              => array(
                'title',
                'editor',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'revisions',
                'comments',
                'thumbnail',
                'author',
                'page-attributes',
            ),
        );

        register_post_type('customer_stories', $args);
    }

    public function register_customer_story_taxonomies() {
        // Register 'story_category' taxonomy
        register_taxonomy('story_category', 'customer_stories', array(
            'hierarchical' => true,
            'label'        => 'Topic',
            'query_var'    => true,
            'rewrite'      => array('slug' => 'story-category'),
        ));

        // Register 'customer_industry' taxonomy
        register_taxonomy('customer_industry', 'customer_stories', array(
            'hierarchical' => true,
            'label'        => 'Industry',
            'query_var'    => true,
            'rewrite'      => array('slug' => 'customer-industry'),
        ));
    }
}

// Initialize the class
new CustomerStoryCard();
