<?php

namespace MEK\Utils;

class Query {
	/**
	 * Get All Users
	 *
	 * @return array
	 */
	public static function users() {
		$users = [];

		foreach ( get_users() as $key => $user ) {
			$users[ $user->data->ID ] = $user->data->user_nicename;
		}

		wp_reset_postdata();

		return $users;
	}

	/**
	 * Get Posts of Post Type
	 *
	 * @param $slug
	 * @param int $per_page
	 *
	 * @return array
	 */
	public static function posts_by_post_type( $slug, $per_page = - 1 ) {
		$query = get_posts( [ 'post_type' => $slug, 'posts_per_page' => $per_page ] );
		$posts = [];

		foreach ( $query as $post ) {
			$posts[ $post->ID ] = $post->post_title;
		}

		wp_reset_postdata();

		return $posts;
	}

	/**
	 * Get Terms of Taxonomy
	 *
	 * @param $slug
	 * @param int $per_page
	 * @param bool $hide_empty
	 *
	 * @return array|null
	 */
	public static function terms_by_taxonomy( $slug, $per_page = - 1, $hide_empty = false ) {
		// Exclude WooCommerce product
		if ( ( 'product_cat' === $slug || 'product_tag' === $slug ) && ! class_exists( 'WooCommerce' ) ) {
			return [];
		}

		$query      = get_terms( $slug, [ 'hide_empty' => $hide_empty, 'posts_per_page' => $per_page ] );
		$taxonomies = [];

		foreach ( $query as $tax ) {
			$taxonomies[ $tax->term_id ] = $tax->name;
		}

		wp_reset_postdata();

		return $taxonomies;
	}

	/**
	 * Get Custom Meta Keys
	 *
	 * @return array[]
	 */
	public static function custom_meta_keys() {
		$data             = [];
		$options          = [];
		$merged_meta_keys = [];
		$post_types       = self::custom_post_types( 'post', false );

		foreach ( $post_types as $post_type_slug => $post_type_name ) {
			$data[ $post_type_slug ] = [];
			$posts                   = get_posts( [ 'post_type' => $post_type_slug ] );

			foreach ( $posts as $key => $post ) {
				$meta_keys = get_post_custom_keys( $post->ID );

				if ( ! empty( $meta_keys ) ) {
					for ( $i = 0; $i < count( $meta_keys ); $i ++ ) {
						if ( '_' !== substr( $meta_keys[ $i ], 0, 1 ) ) {
							array_push( $data[ $post_type_slug ], $meta_keys[ $i ] );
						}
					}
				}
			}

			$data[ $post_type_slug ] = array_unique( $data[ $post_type_slug ] );
		}

		foreach ( $data as $array ) {
			$merged_meta_keys = array_unique( array_merge( $merged_meta_keys, $array ) );
		}

		for ( $i = 0; $i < count( $merged_meta_keys ); $i ++ ) {
			$options[ $merged_meta_keys[ $i ] ] = $merged_meta_keys[ $i ];
		}

		return [ $data, $options ];
	}

	/**
	 * Get Available Custom Post Types or Taxonomies
	 *
	 * @param $query
	 * @param bool $exclude_defaults
	 *
	 * @return array
	 */
	public static function custom_post_types( $query, $exclude_defaults = true ) {
		// Taxonomies
		if ( 'tax' === $query ) {
			$custom_types = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );
			// Post Types
		} else {
			$custom_types = get_post_types( [ 'show_in_nav_menus' => true ], 'objects' );
		}

		$custom_type_list = [];

		foreach ( $custom_types as $key => $value ) {
			if ( $exclude_defaults ) {
				if ( $key != 'post' && $key != 'page' && $key != 'category' && $key != 'post_tag' ) {
					$custom_type_list[ $key ] = $value->label;
				}
			} else {
				$custom_type_list[ $key ] = $value->label;
			}
		}

		return $custom_type_list;
	}

	/**
	 * Query post list
	 *
	 * @param string $post_type
	 * @param int $limit
	 * @param string $search
	 *
	 * @return array
	 */
	public static function post_list( $post_type = 'any', $limit = - 1, $search = '' ) {

		global $wpdb;
		$where = '';
		$data  = [];

		if ( - 1 == $limit ) {
			$limit = '';
		} elseif ( 0 == $limit ) {
			$limit = "limit 0,1";
		} else {
			$limit = $wpdb->prepare( " limit 0,%d", esc_sql( $limit ) );
		}

		if ( 'any' === $post_type ) {
			$in_search_post_types = get_post_types( [ 'exclude_from_search' => false ] );
			if ( empty( $in_search_post_types ) ) {
				$where .= ' AND 1=0 ';
			} else {
				$where .= " AND {$wpdb->posts}.post_type IN ('" . join( "', '",
						array_map( 'esc_sql', $in_search_post_types ) ) . "')";
			}
		} elseif ( ! empty( $post_type ) ) {
			$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_type = %s", esc_sql( $post_type ) );
		}

		if ( ! empty( $search ) ) {
			$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_title LIKE %s", '%' . esc_sql( $search ) . '%' );
		}

		$query   = "select post_title,ID  from $wpdb->posts where post_status = 'publish' $where $limit";
		$results = $wpdb->get_results( $query );
		if ( ! empty( $results ) ) {
			foreach ( $results as $row ) {
				$data[ $row->ID ] = $row->post_title;
			}
		}

		return $data;
	}

	/**
	 * Get all elementor page templates
	 *
	 * @param null $type
	 *
	 * @return array
	 */
	public static function elementor_templates( $type = null ) {

		$options = [];

		if ( $type ) {
			$args              = [
				'post_type'      => 'elementor_library',
				'posts_per_page' => - 1,
			];
			$args['tax_query'] = [
				[
					'taxonomy' => 'elementor_library_type',
					'field'    => 'slug',
					'terms'    => $type,
				]
			];

			$page_templates = get_posts( $args );

			if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ) {
				foreach ( $page_templates as $post ) {
					$options[ $post->ID ] = $post->post_title;
				}
			}
		} else {
			$options = self::post_list( 'elementor_library' );
		}

		return $options;
	}
}