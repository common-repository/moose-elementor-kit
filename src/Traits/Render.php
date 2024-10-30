<?php

namespace MEK\Traits;

use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

trait Render {

	protected function get_elementor_icon( $icon, $attributes = [], $tag = 'i' ) {
		$output = '';

		if ( empty( $icon['library'] ) ) {
			return $output;
		}

		/**
		 * When the library value is svg it means that it's a SVG media attachment uploaded by the user.
		 * Otherwise, it's the name of the font family that the icon belongs to.
		 */
		if ( 'svg' === $icon['library'] ) {
			$output = Icons_Manager::render_uploaded_svg_icon( $icon['value'] );
		} else {
			$output = Icons_Manager::render_font_icon( $icon, $attributes, $tag );
		}

		return $output;
	}

	protected function render_image( $settings, $image_key, $size_key = null, $echo = true ) {
		if ( ! isset( $settings[ $image_key ] ) ) {
			return $echo ?: '';
		}
		$image     = $settings[ $image_key ];
		$image_url = $image['url'];
		if ( null !== $size_key ) {
			$url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], $size_key, $settings );
			if ( ! empty( $url ) ) {
				$image_url = $url;
			}
		}

		$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true );

		$output = '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $image_alt ) . '"/>';
		if ( $echo ) {
			echo wp_kses( $output, [ 'img' => [ 'src' => [], 'alt' => [] ] ] );
		} else {
			return $output;
		}
	}

	protected function render_link_item( $args ) {

		$default = [
			'key'             => '',
			'link'            => [ 'url' => '' ],
			'text'            => '',
			'icon'            => null,
			'default_tag'     => 'span',
			'default_classes' => [],
			'link_classes'    => [],
		];

		$args = array_merge( $default, $args );

		$url     = $args['link']['url'];
		$tag     = $args['default_tag'];
		$classes = $args['default_classes'];

		if ( ! empty( $url ) ) {
			$tag = 'a';
			$this->add_link_attributes( $args['key'], $args['link'] );
			$classes = array_merge( $classes, $args['link_classes'] );
		}

		$attrs = $this->get_render_attribute_string( $args['key'] );

		$content = esc_html( $args['text'] );
		if ( $args['icon'] ) {
			$content = $this->get_elementor_icon( $args['icon'], [ 'aria-hidden' => 'true' ] ) . $content;
		}

		$item_html = sprintf(
			'<%1$s class="%2$s" %3$s>%4$s</%1$s>',
			$tag,
			mek_clsx( $classes ),
			$attrs,
			$content
		);

		echo wp_kses_post( $item_html );
	}

}
