<?php
/*
Plugin Name: Easy VBOX7
Plugin URI: http://blog.caspie.net/2009/02/14/easy-vbox7-wordpress-plugin/
Description: Quick and easy way to insert videos from VBOX7.com right into your WordPress blog posts, pages and sidebar.
Version: 1.4
Author: Caspie
Author URI: http://blog.caspie.net/
License: GPLv2 or later
Text Domain: easy-vbox7
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
defined( 'WPINC' ) or die;

if ( version_compare( $GLOBALS['wp_version'], '2.9', '>=' ) ) {
	add_action( 'widgets_init', 'easy_vbox7_widgets' );
} else {
	add_action( 'admin_notices', 'easy_vbox7_notice' );
}

/**
 * Include widgets
 */
include 'includes/widgets/class-easy-vbox7-video.php';

/**
 * Register widgets
 */
function easy_vbox7_widgets() {
	register_widget( 'Easy_Vbox7_Video_Widget' );
}

/**
 * Admin notice
 */
function easy_vbox7_notice() {
	echo '<div id="message" class="error notice is-dismissible"><p>' . __( 'WordPress 2.9 or newer is required for this plugin to work properly! Easy VBOX7 widgets were not initialized.', 'easy-vbox7' ) . '</p></div>';
}

/**
 * Output
 *
 * @param array $atts
 *
 * @return string
 */
function easy_vbox7_output( $atts ) {
	// Bail early if no video
	if ( ! $atts['video'] ) {
		return '';
	}

	// Sanitize input
	$atts['video']    = array_map( 'trim', explode( ',', ( isset( $atts['id'] ) ? $atts['id'] : $atts['video'] ) ) );
	$atts['width']    = (int) $atts['width'];
	$atts['height']   = (int) $atts['height'];
	$atts['autoplay'] = $atts['autoplay'] ? 1 : 0;

	// Additional class
	$class = ( ! $atts['width'] || ! $atts['height'] ) ? ' easy-vbox7-container' : '';

	// Return
	return '<p class="easy_vbox7' . $class . '"><iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://vbox7.com/emb/external.php?vid=' . $atts['video'][mt_rand( 0, count( $atts['video'] ) - 1 )] . '&amp;autoplay=' . $atts['autoplay'] . '" frameborder="0" allowfullscreen></iframe></p>';
}

/**
 * Filter content
 *
 * @param string $content
 *
 * @return mixed
 */
function easy_vbox7_content( $content ) {
	$pattern = '/\[play:([a-zA-Z0-9]{8,},?)+(:[1-9][0-9]{1,3})?(:[1-9][0-9]{1,3})?(:[0|1])?\]/';

	if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
		foreach ( $matches as $value ) {
			$atts['video']    = ( isset( $value[1][7] ) ) ? $value[1] : '';
			$atts['width']    = ( isset( $value[2][1] ) ) ? (int) str_replace( ':', '', $value[2] ) : '';
			$atts['height']   = ( isset( $value[3][1] ) ) ? (int) str_replace( ':', '', $value[3] ) : '';
			$atts['autoplay'] = ( isset( $value[4][1] ) ) ? 1 : 0;

			$content = str_replace( $value[0], easy_vbox7_output( $atts ), $content );
		}
	}
	return $content;
}
add_filter( 'the_content', 'easy_vbox7_content', 100 );

/**
 * Shortcode
 *
 * @param array $atts
 * @param null $content
 *
 * @return string
 */
function easy_vbox7_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array( 'id' => $content, 'video' => $content, 'width' => '', 'height' => '', 'autoplay' => 0 ), $atts );

	return easy_vbox7_output( $atts );
}
add_shortcode( 'vbox7', 'easy_vbox7_shortcode' );

/**
 * Additional styling
 */
function easy_vbox7_style() {
?>
<style>
	.easy_vbox7 {
		display: block;
	}
	.easy-vbox7-container {
		position: relative;
		padding-bottom: 56.25%;
		padding-top: 35px;
		height: 0;
		overflow: hidden;
	}
	.easy-vbox7-container iframe {
		position: absolute;
		top:0;
		left: 0;
		width: 100%;
		height: 100%;
	}
</style>
<?php
}
add_action( 'wp_head', 'easy_vbox7_style', 100 );