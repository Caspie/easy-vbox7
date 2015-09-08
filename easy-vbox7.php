<?php
/*
Plugin Name: Easy VBOX7
Plugin URI: http://blog.caspie.net/2009/02/14/easy-vbox7-wordpress-plugin/
Description: Quick and easy way to insert videos from VBOX7.com right into your WordPress blog posts, pages and sidebar.
Version: 1.3
Author: Casper
Author URI: http://blog.caspie.net/
*/

/*
** Easy VBOX7 Core
*/

add_filter( 'the_content', 'easy_vbox7_content', 100 );

if ( version_compare( $wp_version, '2.9', '>=' ) )
    add_action( 'widgets_init', 'widget_easy_vbox7_init' );
else
    add_action( 'after_plugin_row', 'easy_vbox7_plugin_notice' );

function easy_vbox7_plugin_notice( $plugin ) {
    if( $plugin == 'easy-vbox7/easy-vbox7.php' )
        echo '<tr class="plugin-update-tr"><td class="plugin-update" colspan="3"><div class="update-message" style="background-color:#ffebe8;border-color:#cc0000;color:#cc0000;">WordPress 2.9+ is required for this plugin to work properly! The Easy VBOX7 Widget was not initialized.</div></td></tr>';
}

function easy_vbox7_output( $v = '89af3669', $w = 450, $h = 403, $a = 0 ) {
    $vbox7 = '<object style="outline:none;" type="application/x-shockwave-flash" data="http://i.vbox7.com/player/ext.swf?vid=' . $v . '&amp;autoplay=' . $a . '" width="' . $w . '" height="' . $h . '"><param name="movie" value="http://i.vbox7.com/player/ext.swf?vid=' . $v . '&amp;autoplay=' . $a . '" /></object>';
    return $vbox7;
}

function easy_vbox7_content( $the_content ) {
	$pattern = '/\[play:([a-z0-9]{8})(:[1-9][0-9]{1,2})?(:[1-9][0-9]{1,2})?(:1)?\]/';
	if ( preg_match_all( $pattern, $the_content, $matches, PREG_SET_ORDER ) ) {
		foreach ( $matches as $value ) {
            $video = $value[1];
			$width = $value[2] ? str_replace( ':', '', $value[2] ) : '450';
			$height = $value[3] ? str_replace( ':', '', $value[3] ) : '403';
            $autoplay = $value[4] ? 1 : 0;
			$the_content = str_replace( $value[0], easy_vbox7_output( $video, $width, $height, $autoplay ), $the_content );
		}
	}
	return $the_content;
}

/*
** Easy VBOX7 Widget
*/

function widget_easy_vbox7_init() {
    register_widget( 'Easy_Vbox7_Widget' );
}

if ( class_exists( 'WP_Widget' ) ) {

    class Easy_Vbox7_Widget extends WP_Widget {

        function Easy_Vbox7_Widget() {
            $widget_ops = array( 'classname' => 'widget_easy_vbox7', 'description' => 'Add VBOX7 Videos to your sidebar' );
            $control_ops = array( 'id_base' => 'easy-vbox7', 'video' => '89af3669', 'width' => 190, 'height' => 180, 'autoplay' => false );
            $this->WP_Widget( 'easy-vbox7', 'Easy VBOX7', $widget_ops, $control_ops );
        }

        function widget( $args, $instance ) {
            extract( $args );
            echo $before_widget;
            $title = apply_filters( 'widget_title', $instance['title'] );
            if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
            $videos = explode( ',', $instance['video'] );
            $vid = array_rand( $videos );
            $video = trim( $videos[$vid] );
            $width = $instance['width'];
            $height = $instance['height'];
            $autoplay = $instance['autoplay'] ? 1 : 0;
            echo '<span class="easy_vbox7" style="display:block;">' . easy_vbox7_output( $video, $width, $height, $autoplay ) . '</span>';
            echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = wp_strip_all_tags( $new_instance['title'] );
            $instance['video'] = wp_strip_all_tags( $new_instance['video'] );
            $instance['width'] = (int) wp_strip_all_tags( $new_instance['width'] );
            $instance['height'] = (int) wp_strip_all_tags( $new_instance['height'] );
            $instance['autoplay'] = (bool) $new_instance['autoplay'];
            return $instance;
        }

        function form( $instance ) {
            $autoplay = $instance['autoplay'];
            
            if ( !$title = $instance['title'] )
                $title = 'Video';
            else
                $title = esc_attr( $instance['title'] );

            if ( !$video = $instance['video'] )
                $video = '89af3669';
            else
                $video = esc_attr( $instance['video'] );

            if ( !$width = (int) $instance['width'] )
                $width = 190;
            else
                $width = esc_attr( $instance['width'] );

            if ( !$height = (int) $instance['height'] )
                $height = 180;
            else
                $height = esc_attr( $instance['height'] );
        ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id( 'video' ); ?>">Video: <input class="widefat" id="<?php echo $this->get_field_id( 'video' ); ?>" name="<?php echo $this->get_field_name( 'video' ); ?>" type="text" value="<?php echo $video; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id( 'width' ); ?>">Width: <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id( 'height' ); ?>">Height: <input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo $height; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id( 'autoplay' ); ?>">Autoplay: <input class="checkbox" id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" type="checkbox" value="1"<?php checked( true, $autoplay ); ?> /></label></p>
   <?php
	   }
    }
}

/*
** Easy VBOX7 Shortcode
*/

add_shortcode( 'vbox7', 'vbox7_shortcode' );

function vbox7_shortcode( $atts, $video ) {
    $video = $video ? $video : '89af3669';
    $atts = shortcode_atts( array( 'id' => $video, 'width' => 450, 'height' => 403, 'autoplay' => 0 ), $atts );
    return easy_vbox7_output( $atts['id'], $atts['width'], $atts['height'], $atts['autoplay'] );
}

?>