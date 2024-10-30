<?php

/**
 * Moose Elementor kit global config file
 *
 * @since 1.0.0
 */

return [
	'element-categories' => [
		'static-widgets'      => __( 'Static Widgets', 'moose-elementor-kit' ),
		'dynamic-widgets'     => __( 'Dynamic Widgets', 'moose-elementor-kit' ),
		'posts-widgets'       => __( 'Posts Widgets', 'moose-elementor-kit' ),
		'wc-widgets'          => __( 'WooCommerce Widgets', 'moose-elementor-kit' ),
		'marketing-widgets'   => __( 'Marketing Widgets', 'moose-elementor-kit' ),
		'third-party-widgets' => __( 'Third Party Widgets', 'moose-elementor-kit' ),
	],
	'elements'           => [
		/**
		 * Content Widgets
		 */
		'button'        => [
			'category' => 'static-widgets',
			'class'    => \MEK\Widgets\Button::class,
			'label'    => __( 'Button', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-button-examples/',
		],
		'badge'         => [
			'category' => 'static-widgets',
			'class'    => \MEK\Widgets\Badge::class,
			'label'    => __( 'Badge', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-badge-examples/',
		],
		'card'          => [
			'category' => 'static-widgets',
			'class'    => \MEK\Widgets\Card::class,
			'label'    => __( 'Card', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-card-examples/',
		],
		'prose-editor'  => [
			'category' => 'static-widgets',
			'class'    => \MEK\Widgets\ProseEditor::class,
			'label'    => __( 'Prose Editor', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-prose-editor-examples/',
		],
		'table'         => [
			'category' => 'static-widgets',
			'class'    => \MEK\Widgets\Table::class,
			'label'    => __( 'Table', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-table-examples/',
		],
		'hero'          => [
			'category' => 'static-widgets',
			'class'    => \MEK\Widgets\Hero::class,
			'label'    => __( 'Hero', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-hero-examples/',
		],
		'slider'        => [
			'category' => 'static-widgets',
			'class'    => \MEK\Widgets\Slider::class,
			'label'    => __( 'Advanced Slider', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-slider-examples/',
		],
		/**
		 * Dynamic Widgets
		 */
		'post-grid'     => [
			'category' => 'dynamic-widgets',
			'pro'      => true,
			'class'    => \MEK\Pro\Widgets\PostGrid::class,
			'label'    => __( 'Post Grid', 'moose-elementor-kit' ),
		],
		'menu'          => [
			'category' => 'dynamic-widgets',
			'class'    => \MEK\Widgets\Menu::class,
			'label'    => __( 'Menu', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-menu-examples/',
		],
		'navbar'        => [
			'category' => 'dynamic-widgets',
			'class'    => \MEK\Widgets\Navbar::class,
			'label'    => __( 'Navbar', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-navbar-examples/',
		],
		'site-identity' => [
			'category' => 'dynamic-widgets',
			'class'    => \MEK\Widgets\SiteIdentity::class,
			'label'    => __( 'Site Identity', 'moose-elementor-kit' ),
		],
		/**
		 * Marketing Widgets
		 */
		'pricing-table' => [
			'category' => 'marketing-widgets',
			'class'    => \MEK\Widgets\PricingTable::class,
			'label'    => __( 'Pricing Table', 'moose-elementor-kit' ),
			'demo'     => 'https://kit.wpmoose.com/elementor-pricing-table-examples/',
		],
	],
	'extensions'         => [
		'particles'      => [
			'class'       => \MEK\Pro\Extensions\Particles::class,
			'label'       => __( 'Particles', 'moose-elementor-kit' ),
			'description' => __( "Enable amazing particle effects in the background for a section.", 'moose - elementor - kit' ),
			'pro'         => true,
			'video'       => 'https://kit.wpmoose.com/elementor-particles-extension-examples/',
		],
		'background'     => [
			'class'       => \MEK\Extensions\Background::class,
			'label'       => __( 'Background', 'moose-elementor-kit' ),
			'description' => __( "A convenient way to set backgrounds and borders (uniform styles) for a section.", 'moose - elementor - kit' ),
			'video'       => 'https://kit.wpmoose.com/elementor-background-extension-examples/',
		],
		'theme-switcher' => [
			'class'       => \MEK\Extensions\ThemeSwitcher::class,
			'label'       => __( 'Theme Switcher', 'moose-elementor-kit' ),
			'description' => __( "Apply a different theme to a section or a page's Moose Elementor Widgets.", 'moose - elementor - kit' ),
			'video'       => 'https://kit.wpmoose.com/elementor-theme-switcher-extension-examples/',
		],
		'nested-section' => [
			'class'       => \MEK\Pro\Extensions\NestedSection::class,
			'label'       => __( 'Nested Section', 'moose-elementor-kit' ),
			'description' => __( 'The missing feature of Elementor to help user create unlimited inner sections.', 'moose-elementor-kit' ),
			'pro'         => true,
			'video'       => 'https://kit.wpmoose.com/elementor-nested-section-extension-examples/',
		],
		'layout'         => [
			'class'       => \MEK\Pro\Extensions\Layout::class,
			'label'       => __( 'Advanced Layout', 'moose-elementor-kit' ),
			'description' => __( 'You can change column width (unlimited), column order and column wrapping.', 'moose-elementor-kit' ),
			'pro'         => true,
			'video'       => 'https://kit.wpmoose.com/elementor-layout-extension-examples/',
		],
	],
];
