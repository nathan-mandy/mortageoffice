<?php
namespace Vital\Custom_Post_Type;

class Career_Post_Type {
    const SLUG = 'career'; // Add SLUG constant for consistent usage

    public function __construct() {
        // Hook into WordPress 'init' action
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomies']);
    }

    /**
     * Register the custom post type.
     */
    public function register_post_type() {
        $labels = array(
            'name'               => 'Careers',
            'singular_name'      => 'Career',
            'add_new'            => 'Add New Career',
            'add_new_item'       => 'Add New Career',
            'edit_item'          => 'Edit Career',
            'new_item'           => 'New Career',
            'all_items'          => 'All Careers',
            'view_item'          => 'View Career',
            'search_items'       => 'Search Careers',
            'not_found'          => 'No Careers Found',
            'not_found_in_trash' => 'No Careers found in Trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Careers',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => 'careers',
            'show_ui'            => true,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'rewrite'            => array('slug' => self::SLUG), // Use the SLUG constant here
            'query_var'          => true,
            'menu_icon'          => 'dashicons-clipboard',
            'supports'           => array(
                'title',
                'editor',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'comments',
                'revisions',
                'thumbnail',
                'author',
                'page-attributes',
            ),
            'show_in_rest' => true,
        );

        register_post_type(self::SLUG, $args); // Use the SLUG constant here
    }

    /**
     * Register custom taxonomies for the post type.
     */
    public function register_taxonomies() {
        $taxonomies = [
            'career_department' => [
                'label' => 'Department',
                'slug'  => 'career_department',
            ],
            'career_emp_type' => [
                'label' => 'Employment Type',
                'slug'  => 'career_emp_type',
            ],
            'career_location' => [
                'label' => 'Location',
                'slug'  => 'career_location',
            ],
        ];

        foreach ($taxonomies as $taxonomy => $data) {
            register_taxonomy(
                $taxonomy,
                self::SLUG, // Use the SLUG constant here
                [
                    'hierarchical' => true,
                    'label'        => $data['label'],
                    'query_var'    => true,
                    'rewrite'      => ['slug' => $data['slug']],
                ]
            );
        }
    }
}

// Instantiate the class
new Career_Post_Type();
