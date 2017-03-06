<?php
/**
 * Plugin Name: Monkey Kode - Post Format Link Shortcode
 * Version:
 * Description: Display a list of Post Format Link Posts grabbing the link frlom the content.
 * Author:      Jull Weber
 * Author URI:  https://monkeykode.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mka_display_post_format_link_shortcode
 * Domain Path: /languages
 *
 * @package MKA
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if ( ! function_exists( 'mka_display_post_format_link_shortcode' ) ) {
	/**
	 * Display the html shortcode.
	 */
	function mka_display_post_format_link_shortcode() {
		/**
		 * Generate shortcode.
		 *
		 * @param object $atts attributes passed.
		 *
		 * @return string
		 */
		function mka_add_post_format_links( $atts ) {
			// Attributes.
			$atts = shortcode_atts(
				array(
					'catname' => '',
					'number'  => - 1,
				),
				$atts
			);
			ob_start();
			$args_links  = array(
				'category_name'  => $atts['catname'],
				'posts_per_page' => $atts['number'],
			);
			$links_query = new WP_Query( $args_links );
			if ( $links_query->have_posts() ) {
				echo '<ul>';
				while ( $links_query->have_posts() ) {
					global $post;
					$links_query->the_post();
					preg_match_all( '/href\s*=\s*[\"\']([^\"\']+)/', $post->post_content, $links );
					echo '<li>';
					echo '<a href="' . esc_url( $links[1][0] ) . '" target="_blank">';
					the_title();
					echo '</li>';
					echo '</a>';bnote

				}
				echo '</ul>';
			}
			wp_reset_postdata();

			return ob_get_clean();

		}

		add_shortcode( 'add_links', 'mka_add_post_format_links' );
	}

	mka_display_post_format_link_shortcode();
}

