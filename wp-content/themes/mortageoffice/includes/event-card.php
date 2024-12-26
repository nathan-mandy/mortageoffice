<?php

use \Vital\Skeletor_Block;

if (!class_exists('\Vital\Skeletor_Block')) {
	return;
}

class Event_Post_Card extends Skeletor_Block {
	public static $title = 'Event Post Card';
	public static $name  = 'event_post_card';

	const POSTTYPE = 'event';

	/** @var array */
	public static $field_group = [
		[
			'label'      => 'Event Post',
			'name'       => 'object',
			'type'       => 'post_object',
			'post_type'  => 'event',
			'allow_null' => 0,
		],
		[
			'label'         => 'Show Excerpt?',
			'name'          => 'show_excerpt',
			'type'          => 'true_false',
			'default_value' => 1,
			'ui'            => 1,
		],
		[
			'label'         => 'Make Whole Card Clickable?',
			'name'          => 'card_clickable',
			'type'          => 'true_false',
			'default_value' => 1,
			'ui'            => 1,
		],
	];

	/** @var array */
	public static $inner_blocks = [];

	/** @var array */
	public static $block_settings = [
		'description' => 'A card to display details from a event in the Event Posts Posttype.',
	];

	/**
	 * get the 'post' from the object property
	 *
	 * if not set or empty, check if the global post
	 * is a 'post' posttype and if so use that
	 *
	 * @param array $block_data
	 * @return WP_Post|Integer
	 */
	protected static function _get_post($block_data) {
		global $post;
		if (isset($block_data['object']) && $block_data['object']) {
			return $block_data['object'];
		}

		if (get_post_type($post) !== self::POSTTYPE) {
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
		$terms = get_the_terms($id, 'event_type');
		if ($terms && !is_wp_error($terms)) {
			return $terms;
		}

		return [];
	}

	protected static function _is_card_clickable($block_data):bool {
		// if not set assume the default of true
		if (!isset($block_data['card_clickable'])) {
			return true;
		}

		return $block_data['card_clickable'];
	}

	public static function block_class($class_list, $block_data) {
		// add generic class so various cards can cascade
		$class_list[] = 'event-post-feed post-card';

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
    public static function before_render($block_data): array {
        global $wp_query;
    
        $id = self::_get_id($block_data);
    
        // If we have no post, bail
        if (!$id) {
            return $block_data;
        }
    
        // If the post type isn't an event, bail
        $post_type = \get_post_type($id);
        if ($post_type !== self::POSTTYPE) {
            return $block_data;
        }
    
        $block_data['has_object'] = true;
    
        $is_card_clickable = self::_is_card_clickable($block_data);
    
        if ($image = self::_get_featured_image($id)) {
            $block_data['image'] = $image;
        }
    
        $are_terms_clickable = '';
    
        if ($categories = self::_get_categories($id)) {
            $block_data['categories'] = array_map(function($category) use ($are_terms_clickable) {
                return [
                    'name'      => $category->name,
                    'permalink' => $are_terms_clickable ? get_category_link($category) : '',
                ];
            }, $categories);
        }
    
        if (!isset($block_data['show_excerpt'])) {
            $block_data['show_excerpt'] = true;
        }
        if ($block_data['show_excerpt']) {
            $block_data['excerpt'] = self::_load_excerpt($block_data);
        }
    
        $block_data['title'] = \get_the_title($id);
    
        $block_data['permalink'] = \is_admin() ? '#' : \get_the_permalink($id);
        $link_classes = ['wp-block-button__link'];
        if ($is_card_clickable) {
            $link_classes[] = 'wp-element-button';
        }
    
        // Fetch the start and end dates
        $start_date = get_post_meta($id, 'start_date', true);
        $end_date = get_post_meta($id, 'end_date', true);
        $location = get_post_meta($id, 'location', true);
        if ($location) {
            $block_data['location'] = $location;
        } else {
            error_log("Location meta key is missing or empty for post ID: $id");
        }
        

    
        // Format and add the dates to block data
        $block_data['event_start'] = $start_date ? date('F j, Y g:i A', strtotime($start_date)) : '';
        $block_data['event_end'] = $end_date ? date('F j, Y g:i A', strtotime($end_date)) : '';
    
        // Build out the button classes
        $button_classes = apply_filters('event_card_button_classes', ['wp-block-button', 'event-post-action-button', 'is-style-text']);
        if (!is_array($button_classes)) {
            $button_classes = [$button_classes];
        }
    
        $block_data['button_class_string'] = implode(' ', $button_classes);
    
        $btn_title = 'Register Now';
    
        $block_data['cta'] = [
            'url'   => $block_data['permalink'],
            'title' => $btn_title,
            'class' => implode(' ', $link_classes),
        ];
    
        return $block_data;
    }
	private static function _load_excerpt($block_data) {
		$the_post = self::_get_post($block_data);
		return \wpautop(\get_the_excerpt($the_post));
	}
}

add_action('after_setup_theme', ['Event_Post_Card', 'init']);
