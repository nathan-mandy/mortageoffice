<?php

namespace Vital\Custom_Post_Type\CustomerStoryCard;

use Vital\Custom_Post_Type\CustomerStoryCard;

if (! defined('ABSPATH')) {
	exit;
}

class Custom_Fields {
	/** @var array */
	static $options_field_group = [
		[
			'key'          => 'field_customer_story_options_archive_hero',
			'name'         => 'customer_story_archive_hero',
			'label'        => 'Archive Hero',
			'type'         => 'post_object',
			'post_type'    => 'wp_block',
			'allow_null'   => true,
			'instructions' => '
				Select a <a href="/wp-admin/edit.php?post_type=wp_block"
				target="_blank">Reusable Block</a>. The content from the
				selected post will be injected before the content of the Blog Post archive page.
			',
		],
		[
			'key'          => 'field_customer_story_options_after_archive_cta',
			'name'         => 'customer_story_after_archive_cta',
			'label'        => 'After Archive CTA',
			'type'         => 'post_object',
			'post_type'    => 'wp_block',
			'allow_null'   => true,
			'instructions' => '
				Select a <a href="/wp-admin/edit.php?post_type=wp_block"
				target="_blank">Reusable Block</a>. The content from the
				selected post will be injected after the content of the Blog Post archive page.
			',
		],
		[
			'key'           => 'field_customer_story_options_default_card_image',
			'label'         => 'Default Card Image',
			'name'          => 'default_card_image',
			'type'          => 'image',
			'return_format' => 'id',
			'instructions'  => 'Select an image to show on Customer Story Cards for posts that do not have a featured image.'
		],
		[
			'key'           => 'field_customer_story_options_default_detail_template',
			'label'         => 'Default Detail Template',
			'name'          => 'customer_story_single_template',
			'type'         	=> 'post_object',
			'post_type'    	=> 'wp_block',
			'return_format' => 'id',
			'allow_null'   	=> true,
			'instructions' 	=> '
				Select a <a href="/wp-admin/edit.php?post_type=wp_block"
				target="_blank">Block Pattern</a>. The content from the
				selected pattern will be injected into each new career.
			',
		],
		[
			'key'           => 'field_customer_story_options_related_articles_heading',
			'label'         => 'Related Articles Heading',
			'name'          => 'customer_story_opt_related_articles_heading',
			'type'          => 'text',
		],
		[
			'key'           => 'field_customer_story_options_related_articles_paragraph',
			'label'         => 'Related Articles Paragraph',
			'name'          => 'customer_story_opt_related_articles_paragraph',
			'type'          => 'text',
		]
	];

	/**
	 * Passed into acf_add_local_field_group() during the acf/init action.
	 * Leave the location paramter out, it will automatically be set for you!
	 *
	 * @var array
	 */
	static $field_group = [
		'key'      => 'group_cpt_customer_story_options',
		'title'    => 'Customer Story Information',
		'style'    => 'seamless',
		'fields' => [
			[
				'key'     => 'field_cpt_customer_story_description',
				'label'   => 'Short Description',
				'name'    => 'customer_story_description',
				'type'    => 'textarea',
			],
			[
				'key'     => 'field_cpt_customer_story_description',
				'label'   => 'Customer Quote',
				'name'    => 'customer_quote',
				'type'    => 'textarea',
			],
			[
				'key'     => 'field_cpt_customer_attributee_name',
				'label'   => 'Attributee Name',
				'name'    => 'customer_story_attributee_name',
				'type'    => 'text',
			],
			[
				'key'     => 'field_cpt_customer_story_attributee_title',
				'label'   => 'Attributee Title',
				'name'    => 'customer_story_attributee_title',
				'type'    => 'text',
			],
			[
				'key'     => 'field_cpt_customer_story_company_link',
				'label'   => 'Company Link',
				'name'    => 'customer_story_company_link',
				'type'    => 'url',
			],
			[
				'key'     => 'field_cpt_customer_story_company_logo',
				'label'   => 'Company Logo',
				'name'    => 'customer_story_company_logo',
				'type'    => 'image',
			],
			[
				'key'     => 'field_cpt_customer_story_company_size',
				'label'   => 'Company Size',
				'name'    => 'customer_story_company_size',
				'type'    => 'text',
			],
			[
				'key'        => 'field_cpt_customer_story_stats',
				'label'      => 'Stats',
				'name'       => 'customer_story_stats',
				'type'       => 'repeater',
				'sub_fields' => [
					[
						'key'        => 'field_cpt_customer_story_stats_number',
						'label'      => 'Statistic Number',
						'name'       => 'stat_number',
						'type'       => 'text',
					],
					[
						'key'        => 'field_cpt_customer_story_stats_label',
						'label'      => 'Statistic Label',
						'name'       => 'stat_label',
						'type'       => 'textarea',
					],
				]
			],
			[
				'key'           => 'field_customer_story_has_sidebar',
				'type'          => 'true_false',
				'ui'            => 1,
				'name'          => 'display_sidebar_menu',
				'label'         => 'Display Sidebar Menu',
				'default_value' => 1,
				'instructions'  => '
					Display a floating sticky sidebar alongside the page content.
				',
			],
			[
				'key'               => 'field_customer_story_sidebar_type',
				'type'              => 'select',
				'name'              => 'sidebar_menu_type',
				'label'             => 'Sidebar Menu Type',
				'default_value'     => 'automatic',
				'choices'           => [
					'automatic' => 'Automatic',
					'manual'    => 'Manual',
				],
				'instructions'      => '
					Select the manner to display the sidebar:<br>
					Automatic: Links will be populated based on headings from within the content that are level 2 that have anchors<br />
					Manual: Links will have to be populated by hand
				',
				'conditional_logic' => [
					[
						[
							'field'    => 'field_customer_story_has_sidebar',
							'operator' => '==',
							'value'    => 1,
						],
					],
				],
			],
			[
				'key'               => 'field_customer_story_sidebar_links',
				'type'              => 'repeater',
				'name'              => 'sidebar_menu_links',
				'label'             => 'Sidebar Menu Links',
				'sub_fields'        => [
					[
						'key'   => 'field_customer_story_sidebar_links_link',
						'type'  => 'link',
						'name'  => 'sidebar_link',
						'label' => 'Sidebar Link',
					],
				],
				'conditional_logic' => [
					[
						[
							'field'    => 'field_customer_story_has_sidebar',
							'operator' => '==',
							'value'    => 1,
						],
						[
							'field'    => 'field_customer_story_sidebar_type',
							'operator' => '==',
							'value'    => 'manual',
						],
					],
				],
			],
			[
				'key'          => 'field_customer_story_post_content_block',
				'type'         => 'post_object',
				'post_type'    => 'wp_block',
				'name'         => 'post_content_block',
				'label'        => 'Post Content Block',
				'instructions' => '
					Select a <a href="/wp-admin/edit.php?post_type=wp_block"
					target="_blank">Reusable Block</a>. The content from the selected post will be injected
					below the post content but prior to the Related Blog Posts.
				',
			],
			[
				'key'           => 'field_customer_story_post_related_post',
				'label'         => 'Related customer story Posts',
				'name'          => 'related_customer_storys',
				'type'          => 'relationship',
				'post_type'     => 'customer_stories',
				'filters'       => [
					'search',
					'taxonomy',
				],
				'return_format' => 'id',
				'instructions'  => 'Select a list of posts to relate to this post. Only published posts will show. The number of viewable posts is dependent upon where they are shown. Typcially it is only 2 or 3 posts. Drag posts in the order in which you would like them to display.',
			]
		],
	];

	public static function setup() {
		\add_action('acf/init', [__CLASS__, 'add_options_page']);
		\add_action('acf/init', [__CLASS__, 'add_field_group']);
	}

	public static function get_options_field_group() {
		return \apply_filters('vital_cpt_options_field_group', static::$options_field_group, CustomerStoryCard::SLUG);
	}

	public static function add_options_page() {
		$posttype = \get_post_type_object(CustomerStoryCard::SLUG);
		if (!$posttype) {
			return;
		}

		$options_page_title = sprintf('%s Options', $posttype->labels->singular_name);
		$options_post_id = sprintf('%s-options', CustomerStoryCard::SLUG);
		$options_parent_slug = sprintf('edit.php?post_type=%s', CustomerStoryCard::SLUG);

		$field_group = self::get_options_field_group();
		if (!$field_group) {
			return;
		}

		if (!class_exists('Vital\SkeletorThemeOptions')) {
			return;
		}

		\Vital\SkeletorThemeOptions::add_skeletor_options_page(
			$options_page_title,
			$field_group,
			$options_post_id,
			$options_parent_slug,
			'edit_posts'
		);
	}

	static function add_field_group() {
		\acf_add_local_field_group(static::get_field_group());
	}

	protected static function get_field_group() {
		return array_merge(self::$field_group, [
			'location' => [
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => CustomerStoryCard::SLUG,
					],
				],
			],
		]);
	}
}

\add_action('after_setup_theme', ['\\Vital\\Custom_Post_Type\\CustomerStoryCard\\Custom_Fields', 'setup']);
