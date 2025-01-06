<?php

namespace Vital\Custom_Post_Type\CustomerStoryCard\Blocks;

use \Vital\Skeletor_Block;
use Vital\Custom_Post_Type\CustomerStoryCard;

if (!class_exists('\Vital\Skeletor_Block')) {
	return;
}

class Customer_Story_Slide extends Skeletor_Block {
	public static $title = 'Customer Story Slide';
	public static $name = 'customer_story_slide';

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
		'description' => 'A slide card for use within sliders to display customer success story info.',
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

	protected static function _get_featured_image($id, $size = 'large', $additional_container_classes = []) {
		$post_thumb_id = \get_post_thumbnail_id($id);
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

	public static function _get_card_logo($id) {
		$logo = get_post_meta($id, 'customer_story_company_logo', true);

		if (!$logo) {
			return false;
		}

		return \wp_get_attachment_image($logo, 'large', false, []);
	}

	public static function block_class($class_list, $block_data) {
		$class_list[] = 'alignwide';

		return $class_list;
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

		$block_data['card_label'] = apply_filters('customer_story_slide_label', __('Customer Success Story'));
		$block_data['quote'] = get_post_meta($id, 'customer_quote', true);
		$block_data['title'] = get_post_meta($id, 'customer_story_attributee_title', true);
		$block_data['name'] = get_post_meta($id, 'customer_story_attributee_name', true);
		$block_data['logo'] = self::_get_card_logo($id);
		$block_data['stats'] = get_field('customer_story_stats', $id);
		$block_data['cta'] = [
			'url'   => \is_admin() ? '#' : \get_the_permalink($id),
			'title' => __('View Success Story'),
			'class' => 'wp-block-button__link',
		];

		return $block_data;
	}
}

\add_action('after_setup_theme', ['\\Vital\\Custom_Post_Type\\CustomerStoryCard\\Blocks\\Customer_Story_Slide', 'init']);
