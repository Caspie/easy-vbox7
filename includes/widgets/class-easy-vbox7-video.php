<?php
/**
 * Easy VBOX7 Video Widget
 */
defined( 'WPINC' ) or die;

class Easy_Vbox7_Video_Widget extends WP_Widget {
	/**
	 * Defaults
	 */
	private $defaults = array(
		'title'    => 'Video',
		'video'    => '89af3669',
		'width'    => '',
		'height'   => '',
		'autoplay' => false
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		// Widget options
		$widget_ops = array(
			'classname'   => 'widget_easy_vbox7',
			'description' => 'Add videos from VBOX7.com to your widget areas.'
		);

		// Widget controls
		$control_ops = array(
			'id_base' => 'easy-vbox7'
		);

		parent::__construct( 'easy-vbox7', 'Easy VBOX7', $widget_ops, $control_ops );
	}

	/**
	 * Display widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		// Merge with defaults
		$args = wp_parse_args( $args, $this->defaults );

		// Before widget
		$markup = $args['before_widget'];

		// Title
		if ( $title = apply_filters( 'widget_title', $instance['title'] ) ) {
			$markup .= $args['before_title'] . $title . $args['after_title'];
		}

		// Video markup
		$markup .= easy_vbox7_output( $instance );

		// After widget
		$markup .= $args['after_widget'];

		// Display markup
		echo $markup;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = ( isset( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['video']    = ( isset( $new_instance['video'] ) ) ? wp_strip_all_tags( $new_instance['video'] ) : '';
		$instance['width']    = ( isset( $new_instance['width'] ) && $new_instance['width'] ) ? (int) wp_strip_all_tags( $new_instance['width'] ) : '';
		$instance['height']   = ( isset( $new_instance['height'] ) && $new_instance['height'] ) ? (int) wp_strip_all_tags( $new_instance['height'] ) : '';
		$instance['autoplay'] = ( isset( $new_instance['autoplay'] ) ) ? true : false;

		return $instance;
	}

	function form( $instance ) {
		// Merge with defaults
		$atts = wp_parse_args( $instance, $this->defaults );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $atts['title']; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'video' ); ?>">Video: <input class="widefat" id="<?php echo $this->get_field_id( 'video' ); ?>" name="<?php echo $this->get_field_name( 'video' ); ?>" type="text" value="<?php echo $atts['video']; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'width' ); ?>">Width: <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $atts['width']; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'height' ); ?>">Height: <input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo $atts['height']; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'autoplay' ); ?>">Autoplay: <input class="checkbox" id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" type="checkbox" value="1"<?php checked( true, (bool) $atts['autoplay'] ); ?> /></label></p>
		<?php
	}
}