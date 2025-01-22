<?php

namespace Vital\Custom_Post_Type\Career_Post_Type\Blocks;

use \Vital\Skeletor_Block;
use Vital\Custom_Post_Type\Career_Post_Type;

if (!class_exists('\Vital\Skeletor_Block')) {
    return;
}

class Career_Card extends Skeletor_Block {
    public static $title = 'Career Card';
    public static $name = 'career_card';

    /** @var array */
    public static $field_group = [
        [
            'label'      => 'Career',
            'name'       => 'object',
            'type'       => 'post_object',
            'post_type'  => 'career',
            'allow_null' => 0,
        ],
    ];

    /** @var array */
    public static $inner_blocks = [];

    /** @var array */
    public static $block_settings = [
        'description' => 'A card to display details from a post in the Career Stories SLUG.',
    ];

    protected static function _get_post($block_data) {
        global $post;

        if (isset($block_data['object']) && $block_data['object']) {
            return $block_data['object'];
        }

        if (get_post_type($post) !== Career_Post_Type::SLUG) {
            return;
        }

        return $post;
    }

    protected static function _get_id($block_data) {
        $post_id = self::_get_post($block_data);
        if (!$post_id) {
            return null;
        }

        if (is_int($post_id)) {
            // Already an ID
        } elseif (is_object($post_id)) {
            $post_id = $post_id->ID;
        } else {
            $post_id = null;
        }

        return $post_id;
    }

    public static function block_class($class_list, $block_data) {
        $class_list[] = 'alignwide';

        $post = \get_post($block_data['object']);
        if (!$post) {
            return $class_list;
        }

        if ($post_type = \get_post_type($post)) {
            $class_list[] = sprintf('post-type-%s', $post_type);

            $pt_taxonomies = \get_object_taxonomies($post_type);
            foreach ($pt_taxonomies as $tax) {
                $post_terms = \wp_get_post_terms($post->ID, $tax);
                foreach ($post_terms as $term) {
                    $class_list[] = sprintf('%s-%s', $tax, $term->slug);
                }
            }
        }

        if (!\get_post_meta($post->ID, '_thumbnail_id', true)) {
            $class_list[] = 'no-thumbnail';
        }

        return $class_list;
    
    }

    public static function before_render($block_data): array {
        $id = self::_get_id($block_data);
        if (!$id) {
            return $block_data;
        }

        $post_type = \get_post_type($id);
        if ($post_type !== Career_Post_Type::SLUG) {
            return $block_data;
        }

        $block_data['has_object'] = true;
        $block_data['title'] = \get_the_title($id);
        $block_data['permalink'] = \is_admin() ? '#' : \get_the_permalink($id);
        $block_data['excerpt'] = self::_load_excerpt($id);
        $block_data['career_department'] = self::_get_story_terms($id, 'career_department');
        $block_data['career_emp_type'] = self::_get_story_terms($id, 'career_emp_type');
        $block_data['career_location'] = self::_get_story_terms($id, 'career_location');
        $block_data['cta'] = [
            'url'   => $block_data['permalink'],
            'title' => __('Read More'),
            'class' => 'wp-block-button__link',
        ];

        return $block_data;
    }

    private static function _load_excerpt($id) {
        $the_excerpt = \get_the_excerpt($id);
        $the_excerpt = \apply_filters('skeletor_blog_post_card_excerpt', $the_excerpt);
        return $the_excerpt ? \wpautop($the_excerpt) : '';
    }

    private static function _get_story_terms($id, $taxonomy) {
        $terms = \get_the_terms($id, $taxonomy);
        if (!is_wp_error($terms) && !empty($terms)) {
            return array_map(function ($term) {
                return [
                    'name'      => $term->name,
                ];
            }, $terms);
        }

        return [];
    }
}

\add_action('after_setup_theme', ['\\Vital\\Custom_Post_Type\\Career_Post_Type\\Blocks\\Career_Card', 'init']);
