<?php
/*
Plugin Name: zig's Page Featured Image
Description: A widget to display a featured image of a page on multisite.
Version: 0.8

Author: zig
Date: 3Feb2020
Author URI: http://wwww.reachmaine.com
License: GPL3
*/




	add_action( 'widgets_init', 'load_zpfi');
	function load_zpfi() {
		register_widget( 'zpfi_widget' );
	}


class zpfi_widget extends WP_Widget {

  	public function __construct() {
  		// widget actual processes
  		parent::__construct(
  				'zpfi_wigdet', // Base ID
  				__("zig's page featured image widget", 'zpfi_text_domain'), // Name
  				array( 'description' => __( 'zigs Widget to display page featured image', 'zpfi_text_domain' ), ) // Args
  			);
    }

  	public function widget( $args, $instance ) {
  		// outputs the content of the widget

  	 	global $wpdb;
  		/* set up the args */
  		$title = apply_filters( 'widget_title',$instance['title']);
  		//$blogid = ($instance['blogid']>0?$instance['blogid']:12);
  		$page_number = ($instance['page_number']>0?$instance['page_number']:1);


  		$html = "";
  		//$html = '<nav class="widget widget_hcclist" >';

  		/* if ( is_multisite() ) {
  			$blog_details = get_blog_details($blogid);
  				if ($blog_details) {
  					$calendar_blog_url = $blog_details->siteurl;
  				}
  		} */

  		if ($page_number) {
  			$thumb_url = get_the_post_thumbnail($page_number, array(300, 250) );
  			if ($thumb_url){
          $html .=  $args['before_widget'];
      		if ( ! empty( $title ) ) {
      				$html.= $args['before_title'] . $title . $args['after_title'];
      		}

  				$html .= '<a href="'.esc_url(get_post_permalink($page_number)).'" >';
          	$html .= $thumb_url;
          $html .=  '</a>';
          $html .= $args['after_widget'];
  			}
  		}

  		//$html .= '</nav>';

  		echo $html;
  	}

   	public function form( $instance ) {
  		// outputs the options form on admin
  	//	$blogid = isset($instance['blogid']) ? esc_attr( $instance['blogid'] ) : 12;
  		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
  		$page_number    = isset( $instance['page_number'] ) ? absint( $instance['page_number'] ) : 6;
  		?>
  		<p>
  			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):' ); ?></label>
  			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
  		</p>
  	<?php /* <p>
          	<label for="<?php echo $this->get_field_id( 'blogid' ); ?>"><?php _e( 'Blog ID' ); ?></label>
  			<input id="<?php echo $this->get_field_id( 'blogid' ); ?>" name="<?php echo $this->get_field_name( 'blogid' ); ?>" type="text" value="<?php echo $blogid; ?>" size="3" />
  		</p> */ ?>
  		<p>
      	<label for="<?php echo $this->get_field_id( 'page_number' ); ?>"><?php _e( 'Page ID:' ); ?></label>
  			<input id="<?php echo $this->get_field_id( 'page_number' ); ?>" name="<?php echo $this->get_field_name( 'page_number' ); ?>" type="text" value="<?php echo $page_number; ?>" size="3" />
  		</p>

  		<?php
  	}

  	public function update( $new_instance, $old_instance ) {
  		// processes widget options to be saved

  		$instance = array();
  		$instance['title'] = strip_tags($new_instance['title']);
  		//$instance['blogid'] = strip_tags($new_instance['blogid']);
  		$instance['page_number'] = (int) $new_instance['page_number'];
  		return $instance;

  	}
  } /* end class */

 ?>
