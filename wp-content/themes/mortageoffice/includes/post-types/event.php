<?php
namespace Skeletor_Event\Posttypes;

use Vital\Skeletor_Event;

class Event extends \Vital\Custom_Post_Type {

  static $name = 'event';
  static $slug = 'events';

  static $placeholder = 'Enter Event Name';

/** @var array */
    static $lables = [
        'singular' => 'Event',
    ];

    static $options = [
        'public' => true,
        'public_queryable' => true,
        'hierarchical' => false,
        'menu_postion' => 10,
        'has_archive' => 'events',
        'rewrite' => [
            'slug' =>'events'
        ],
        'show_in_admin_bar' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'supports' => [
            'title',
            'custom_fields',
            'excerpt',
            'editor',
            'thumbnail',
        ],
        'menu_icon' => 'dashicons-calendar-alt',
    ];
    static $taxonomies = [
        'event_type' => [
            'labels' => [
                'name' => 'Event Type',
                'singluar_name' => 'Event_Types',
                'menu_name' => 'Event Type',
            ],
            'rewrite' => [
                'slug' => 'event_types',
                'hierarchical' =>'false',
            ],
        ],
    ];
    static $field_group = [
        'key' => 'group_cpt_event',
        'title' => 'Event Fields',
        'fields' =>[
            [
                'key' => 'field_cpt_event_location',
                'label' => 'Location',
                'name' => 'location',
                'type' => 'text',
                'ui' => true,
            ],
            [
                'key' => 'field_cpt_event_start_date',
                'label' => 'Start Date',
                'name' => 'start_date',
                'type' => 'date_time_picker',
            ],
            [
                'key' => 'field_cpt_event_end_date',
                'label' => 'End Date',
                'name' => 'end_date',
                'type' => 'date_time_picker',
            ],
        ],
        'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'event',
                    ],
                ],
            ],
    ];
}
add_action('after_setup_theme', ['\\Skeletor_Event\\Posttypes\\Event', 'initialize']);