<?php

namespace Vital\Custom_Post_Type\CustomerStoryCard\Blocks;

use \Vital\Skeletor_Block;
use Vital\Custom_Post_Type\CustomerStoryCard;

if (!class_exists('\Vital\Skeletor_Block')) {
	return;
}

class Customer_Story_Card extends Skeletor_Block {
	public static $title = 'Customer Story Card';
	public static $name = 'customer_story_card';

	/** @var array */
	public static $field_group = [
		[
			'label'      => 'Story',
			'name'       => 'object',
			'type'       => 'post_object',
			'post_type'  => 'customer_stories',
			'allow_null' => 0,
		],
	];

	/** @var array */
	public static $inner_blocks = [];

	/** @var array */
	public static $block_settings = [
		'description' => 'A card to display details from a post in the Customer Stories SLUG.',
	];

	/**
	 * get the 'post' from the object property
	 * 
	 * if not set or empty, check if the global post
	 * is a 'post' SLUG and if so use that
	 *
	 * @param array $block_data
	 * @return WP_Post|Integer
	 */
	protected static function _get_post($block_data) {
		global $post;
		if (isset($block_data['object']) && $block_data['object']) {
			return $block_data['object'];
		}

		if (get_post_type($post) !== CustomerStoryCard::SLUG) {
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
			// do nothing we're good
		} elseif (is_object($post_id)) {
			$post_id = $post_id->ID;
		} else {
			// what even is it?!?
			$post_id = null;
		}

		return $post_id;
	}

	/**
	 * get the categories
	 * associated with the post
	 *
	 * @param int $id
	 * @return Array
	 */
	protected static function _get_categories($id) {
		$taxonomy = apply_filters('customer_story_card_taxonomy', 'category', $id);

		$terms = \get_the_terms($id, $taxonomy);
		if ($terms && !\is_wp_error($terms)) {
			return $terms;
		}

		return [];
	}

	protected static function _is_card_clickable($block_data): bool {
		// if not set assume the default of true
		if (!isset($block_data['card_clickable'])) {
			return true;
		}

		return $block_data['card_clickable'];
	}

	protected static function _are_terms_clickable($block_data): bool {
		// can't be clickable if the card as a whole is clickable
		if (self::_is_card_clickable($block_data)) {
			return false;
		}

		// if not set, assume the default of true
		if (!isset($block_data['terms_clickable'])) {
			return true;
		}

		return $block_data['terms_clickable'];
	}

	public static function block_class($class_list, $block_data) {
		// add generic class so various cards can cascade
		$class_list[] = 'post-card';

		if (isset($block_data['display_horizontal']) && $block_data['display_horizontal']) {
			$class_list[] = 'is-style-horizontal';
		}

		if (self::_is_card_clickable($block_data)) {
			$class_list[] = 'has-full-card-cta';
		}

		// if we don't have the post, then bail
		if (!isset($block_data['object']) || empty($block_data['object'])) {
			return $class_list;
		}

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

	/**
	 * retrieves the image id to use for the card image
	 * 
	 * this could be the featured image of the post or
	 * the default card image as set in the options
	 *
	 * @param int $post_id
	 * @return int|false
	 */
	public static function _get_image_id($post_id) {
		$post_thumb_id = \get_post_thumbnail_id($post_id);
		if ($post_thumb_id) {
			return $post_thumb_id;
		}

		// try to read from options to get default card id
		return \get_option('customer-story-options_default_card_image');
	}

	protected static function _get_featured_image($id, $size = 'large', $additional_container_classes = []) {
		$post_thumb_id = self::_get_image_id($id);
		$post_thumb_atts = [];
		$focal_point = false;

		if (class_exists('\Vital\SkeletorFeaturedImageFocalPoint')) {
			$focal_point = \get_post_meta($id, \Vital\SkeletorFeaturedImageFocalPoint::FOCAL_POINT, true);
			if ($focal_point) {
				$post_thumb_atts['style'] = sprintf(
					'object-position: %s%% %s%%',
					100 * $focal_point['x'],
					100 * $focal_point['y']
				);
			}
		}

		$container_classes = array_merge(
			['wp-block-image'],
			$additional_container_classes
		);
		$container_classes[] = sprintf('size-%s', $size);

		$img = sprintf(
			'<figure class="%s">%s</figure>',
			implode(' ', $container_classes),
			\wp_get_attachment_image($post_thumb_id, $size, false, $post_thumb_atts)
		);

		return \render_block([
			'blockName'    => 'core/image',
			'attrs'        => [
				'id'         => $post_thumb_id,
				'sizeSlug'   => $size,
				'focalPoint' => $focal_point,
			],
			'innerHTML'    => $img,
			'innerContent' => [$img],
		]);
	}

	public static function before_render($block_data): array {
		$id = self::_get_id($block_data);
		// if we have no post, bail
		if (!$id) {
			return $block_data;
		}

		$post_type = \get_post_type($id);
		if ($post_type !== CustomerStoryCard::SLUG) {
			return $block_data;
		}

		$block_data['has_object'] = true;

		if ($image = self::_get_featured_image($id)) {
			$block_data['image'] = $image;
		}

		$block_data['categories'] = self::_get_story_terms($id);
		$block_data['show_excerpt'] = true;
		$block_data['excerpt'] = self::_load_excerpt($block_data);
		$block_data['title'] = \get_the_title($id);
		$block_data['permalink'] = \is_admin() ? '#' : \get_the_permalink($id);
		$block_data['button_class_string'] = 'wp-block-button is-style-text';
		$block_data['cta'] = [
			'url'   => $block_data['permalink'],
			'title' => __('Read More'),
			'class' => 'wp-block-button__link',
		];

		return $block_data;
	}

	private static function _load_excerpt($block_data) {
		$the_post = self::_get_post($block_data);
		$the_excerpt = \get_the_excerpt($the_post);
		$the_excerpt = \apply_filters('skeletor_blog_post_card_excerpt', $the_excerpt);
		if (!$the_excerpt) {
			return '';
		}

		return \wpautop($the_excerpt);
	}

	private static function _get_story_terms($id) {
        $story_categories = \get_the_terms($id, 'story_category');
        $customer_industry = \get_the_terms($id, 'customer_industry');
    
        $terms = array_merge(
            $story_categories && !is_wp_error($story_categories) ? $story_categories : [],
            $customer_industry && !is_wp_error($customer_industry) ? $customer_industry : []
        );
    
        if ($terms) {
            return array_map(function ($term) {
                return [
                    'name'      => $term->name,
                    'permalink' => \get_term_link($term),
                ];
            }, $terms);
        }
    
        return [];
    }
    
}

\add_action('after_setup_theme', ['\\Vital\\Custom_Post_Type\\CustomerStoryCard\\Blocks\\Customer_Story_Card', 'init']);
