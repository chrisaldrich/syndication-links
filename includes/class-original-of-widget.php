<?php

add_action( 'widgets_init', 'sl_register_original_widget' );

function sl_register_original_widget() {
	register_widget( 'Original_Of_Widget' );
}

class Original_Of_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'Original_Of_Widget',                // Base ID
			__( 'Original Of', 'syndication-links' ),        // Name
			array(
				'classname'   => 'original_of_widget',
				'description' => __( 'Displays a search box to search for posts by their syndicated URLs', 'syndication-links' ),
			)
		);

	} // end constructor

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$kind = ifset( $instance['kind'], 'note' );
		// phpcs:ignore
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title']; // phpcs:ignore
		}
		get_original_of_form();
		// phpcs:ignore
		if ( isset( $args['after_widget'] ) ) {
			echo $args['after_widget']; // phpcs:ignore
		}
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		array_walk_recursive( $new_instance, 'sanitize_text_field' );
		return $new_instance;
	}


	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		?>
				<p><label for="title"><?php esc_html_e( 'Title: ', 'syndication-links' ); ?></label>
				<input type="text" size="30" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="
		<?php echo esc_html( ifset( $instance['title'] ) ); ?>" /></p>
		<?php
	}
}
