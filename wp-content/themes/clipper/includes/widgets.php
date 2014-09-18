<?php

// Most Commented Coupons Widget
class CLPR_Widget_Popular_Coupons extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Display the most commented on coupons.', APP_TD ), 'classname' => 'widget-custom-coupons' );
		parent::__construct( 'custom-coupons', __( 'Clipper Popular Coupons', APP_TD ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Popular Coupons', APP_TD ) : $instance['title'] );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		if ( strpos( $before_widget, 'customclass' ) !== false)
			$before_widget = str_replace( 'customclass', 'cut', $before_widget );
		else
			$before_widget = str_replace( 'customclass', '', $before_widget );

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;		

		$popular_posts = new WP_Query( array( 'post_type' => APP_POST_TYPE, 'posts_per_page' => $number, 'orderby' => 'comment_count', 'order' => 'DESC', 'no_found_rows' => true ) );
		$result = '';

		if ( $popular_posts->have_posts() ) {
			$result .= '<div class="coupon-ticker"><ul class="list">';
			while ( $popular_posts->have_posts() ) {
				$popular_posts->the_post();
				$comments_text = sprintf( _n( '%1$s comment', '%1$s comments', get_comments_number(), APP_TD ), get_comments_number() );
				$result .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a> - ' . $comments_text . '</li>';
			}
			$result .= '</ul></div>';
		}

		wp_reset_postdata();

		echo $result;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number' => 10 ) );
		$title = esc_attr( $instance['title'] );
		$number = absint( $instance['number'] );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of coupons to show:', APP_TD ); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
	<?php
	}
}


// Most Popular Stores Widget
class CLPR_Widget_Popular_Stores extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Display the most popular stores.', APP_TD ), 'classname' => 'widget-custom-stores' );
		parent::__construct( 'custom-stores', __( 'Clipper Popular Stores', APP_TD ), $widget_ops );
	}

	function widget($args, $instance) {
		global $wpdb;
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __( 'Popular Stores', APP_TD ) : $instance['title']);

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		if (strpos($before_widget, 'customclass') !== false)
			$before_widget = str_replace('customclass', 'cut', $before_widget);
		else
			$before_widget = str_replace('customclass', '', $before_widget);

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

			echo '<div class="store-widget"><ul class="list">';

			$hidden_stores = clpr_hidden_stores();
			$tax_array = get_terms( APP_TAX_STORE, array( 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => 1, 'show_count' => 1, 'pad_counts' => 0, 'app_pad_counts' => 1, 'exclude' => $hidden_stores ) );
			$i = 0;

			if ($tax_array && is_array($tax_array)):
				foreach ( $tax_array as $tax_val ) {
					if ( $i >= $number )
						continue;
					$link = get_term_link($tax_val, APP_TAX_STORE);
					echo '<li><a class="tax-link" href="' . $link . '">' . $tax_val->name . '</a> - ' . $tax_val->count . '&nbsp;' . __( 'coupons', APP_TD ) . '</li>';
					$i++;
				}
			endif;

			echo '</ul></div>';	

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number' => 10 ) );
		$title = esc_attr($instance['title']);
		$number = absint($instance['number']);
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of stores to show:', APP_TD ); ?></label>
				<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
			</p>
		<?php
	}
}


// Featured Stores Widget
class CLPR_Widget_Featured_Stores extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Display stores that are marked as featured.', APP_TD ), 'classname' => 'widget-featured-stores' );
		parent::__construct( 'featured-stores', __( 'Clipper Featured Stores', APP_TD ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Featured Stores', APP_TD ) : $instance['title'] );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		if ( strpos( $before_widget, 'customclass' ) !== false )
			$before_widget = str_replace( 'customclass', 'cut', $before_widget );
		else
			$before_widget = str_replace( 'customclass', '', $before_widget );

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

		echo '<div class="store-widget-slider"><ul class="list">';

		$hidden_stores = clpr_hidden_stores();
		$featured_stores = clpr_featured_stores();
		$featured_stores = array_diff( $featured_stores, $hidden_stores );
		$tax_array = get_terms( APP_TAX_STORE, array( 'orderby' => 'rand', 'order' => 'DESC', 'hide_empty' => 0, 'number' => $number, 'include' => $featured_stores ) );
		$i = 0;

		if ( $tax_array && is_array( $tax_array ) ) {
			foreach ( $tax_array as $tax_val ) {
				if ( $i >= $number )
					continue;
				$link = get_term_link( $tax_val, APP_TAX_STORE );
				echo '<li>';
				echo '<a href="' . $link . '"><img src="' . clpr_get_store_image_url( $tax_val->term_id, 'term_id', 160 ) . '" alt="" /><span>' . $tax_val->name . '</span></a>';
				echo '</li>';
				$i++;
			}
		}

		echo '</ul></div>';	

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number' => 10 ) );
		$title = esc_attr( $instance['title'] );
		$number = absint( $instance['number'] );
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of stores to rotate:', APP_TD ); ?></label>
				<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
			</p>
		<?php
	}
}


// Coupon Catetories Widget
class CLPR_Widget_Coupon_Categories extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Display the coupon categories.', APP_TD ), 'classname' => 'widget-coupon-cats' );
		parent::__construct( 'coupon-cats', __( 'Clipper Coupon Categories', APP_TD ), $widget_ops );
	}

	function widget($args, $instance) {
		global $wpdb;
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __( 'Coupon Categories', APP_TD ) : $instance['title']);

		if (strpos($before_widget, 'customclass') !== false)
			$before_widget = str_replace('customclass', 'cut', $before_widget);
		else
			$before_widget = str_replace('customclass', '', $before_widget);

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

			$tax_name = APP_TAX_CAT;
			echo '<div class="coupon-cats-widget"><ul class="list">';

			wp_list_categories("orderby=name&order=asc&hierarchical=1&show_count=1&pad_counts=0&app_pad_counts=1&use_desc_for_title=1&hide_empty=0&depth=1&number=&title_li=&taxonomy=$tax_name");

			echo '</ul></div>';	

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = esc_attr($instance['title']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<?php
	}
}


// Email Subscription Widget
class CLPR_Widget_Subscribe extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Display The Coupons in Your Inbox Box', APP_TD ), 'classname' => 'widget-newsletter-subscription' );
		$control_ops = array( 'width' => 500, 'height' => 350 );
		parent::__construct( 'newsletter-subscribe', __( 'Coupons in Your Inbox!', APP_TD ), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Coupons in Your Inbox!', APP_TD ) : $instance['title']);
		$text = ( empty( $instance['text'] ) ? __( 'Receive coupons by email, subscribe now!', APP_TD ) : $instance['text'] );
		$action = ( empty( $instance['action'] ) ? '#' : $instance['action'] );
		$email_name = ( empty( $instance['email_name'] ) ? 'email' : $instance['email_name'] );

?>
		<div class="sidebox subscribe-box">

			<div class="sidebox-content">
				<div class="sidebox-heading"><h2><?php echo $title; ?></h2></div>
				<div class="subscribe-holder">

					<div class="text-box">
					<p><?php echo $text; ?></p></div>

					<form method="post" action="<?php echo $action; ?>" class="subscribe-form">
						<fieldset>
							<div class="row">
								<div class="text"><input type="text" name="<?php echo $email_name; ?>" class="text" value="<?php _e( 'Enter Email Address', APP_TD ); ?>" onfocus="clearAndColor(this)" onblur="reText(this)"/></div>
							</div>
							<div class="row">
								<button name="submit" value="Submit" id="submit" title="<?php _e( 'Subscribe', APP_TD ); ?>" type="submit" class="btn-submit"><span><?php _e( 'Subscribe', APP_TD ); ?></span></button>
							</div>
						</fieldset>

						<input type="hidden" name="<?php echo $instance['hname1']; ?>" value="<?php echo $instance['hvalue1']; ?>" />
						<input type="hidden" name="<?php echo $instance['hname2']; ?>" value="<?php echo $instance['hvalue2']; ?>" />
						<input type="hidden" name="<?php echo $instance['hname3']; ?>" value="<?php echo $instance['hvalue3']; ?>" />
						<input type="hidden" name="<?php echo $instance['hname4']; ?>" value="<?php echo $instance['hvalue4']; ?>" />
						<input type="hidden" name="<?php echo $instance['hname5']; ?>" value="<?php echo $instance['hvalue5']; ?>" />
						<input type="hidden" name="<?php echo $instance['hname6']; ?>" value="<?php echo $instance['hvalue6']; ?>" />

					</form>
				</div>
			</div>
			<br clear="all" />
		</div>

<?php

	}

	function update($new_instance, $old_instance) {
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['action'] = strip_tags($new_instance['action']);
		$instance['email_name'] = strip_tags( $new_instance['email_name'] );
		$instance['hname1'] = strip_tags($new_instance['hname1']);
		$instance['hvalue1'] = strip_tags($new_instance['hvalue1']);
		$instance['hname2'] = strip_tags($new_instance['hname2']);
		$instance['hvalue2'] = strip_tags($new_instance['hvalue2']);
		$instance['hname3'] = strip_tags($new_instance['hname3']);
		$instance['hvalue3'] = strip_tags($new_instance['hvalue3']);
		$instance['hname4'] = strip_tags($new_instance['hname4']);
		$instance['hvalue4'] = strip_tags($new_instance['hvalue4']);
		$instance['hname5'] = strip_tags($new_instance['hname5']);
		$instance['hvalue5'] = strip_tags($new_instance['hvalue5']);
		$instance['hname6'] = strip_tags($new_instance['hname6']);
		$instance['hvalue6'] = strip_tags($new_instance['hvalue6']);

		return $instance;
	}

	function form($instance) {

		$defaults = array( 
			'title' => __( 'Coupons in Your Inbox!', APP_TD ),
			'text' => __( 'Receive coupons by email, subscribe now!', APP_TD ),
			'action' => '#',
			'email_name' => 'email',
			'hname1' => '',
			'hvalue1' => '',
			'hname2' => '',
			'hvalue2' => '',
			'hname3' => '',
			'hvalue3' => '',
			'hname4' => '',
			'hvalue4' => '',
			'hname5' => '',
			'hvalue5' => '',
			'hname6' => '',
			'hvalue6' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = esc_attr($instance['title']);
		$text = esc_attr($instance['text']);
		$action = esc_attr($instance['action']);
		$email_name = esc_attr( $instance['email_name'] );
		$hname1 = esc_attr($instance['hname1']);
		$hvalue1 = esc_attr($instance['hvalue1']);
		$hname2 = esc_attr($instance['hname2']);
		$hvalue2 = esc_attr($instance['hvalue2']);
		$hname3 = esc_attr($instance['hname3']);
		$hvalue3 = esc_attr($instance['hvalue3']);
		$hname4 = esc_attr($instance['hname4']);
		$hvalue4 = esc_attr($instance['hvalue4']);
		$hname5 = esc_attr($instance['hname5']);
		$hvalue5 = esc_attr($instance['hvalue5']);
		$hname6 = esc_attr($instance['hname6']);
		$hvalue6 = esc_attr($instance['hvalue6']);
?>

			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e( 'Text:', APP_TD ); ?> <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('action'); ?>"><?php _e( 'Form Post Action:', APP_TD ); ?> <input class="widefat" id="<?php echo $this->get_field_id('action'); ?>" name="<?php echo $this->get_field_name('action'); ?>" type="action" value="<?php echo $action; ?>" /></label>
			<small><?php _e( 'Enter the url where the email subscribe form should post to.<br /> i.e. http://www.aweber.com/', APP_TD ); ?></small>
			</p>

			<p><label for="<?php echo $this->get_field_id('email_name'); ?>"><?php _e( 'Email field name:', APP_TD ); ?> <input class="widefat" id="<?php echo $this->get_field_id('email_name'); ?>" name="<?php echo $this->get_field_name('email_name'); ?>" type="text" value="<?php echo $email_name; ?>" /></label>
			<small><?php _e( 'Enter the email field name. i.e. email-address', APP_TD ); ?></small>
			</p>

			<p style="margin-bottom:-1px;">
			<label><?php _e( 'Advanced Options:', APP_TD ); ?></label>
			</p>

			<p class="email-hidden-widget"><label><?php _e( 'Hidden Field 1:', APP_TD ); ?></label><br />
			<label for="<?php echo $this->get_field_id('hname1'); ?>"><?php _e( 'Name:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hname1'); ?>" name="<?php echo $this->get_field_name('hname1'); ?>" value="<?php echo $instance['hname1']; ?>" style="width:175px;" />&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id('hvalue1'); ?>"><?php _e( 'Value:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hvalue1'); ?>" name="<?php echo $this->get_field_name('hvalue1'); ?>" value="<?php echo $instance['hvalue1']; ?>" style="width:175px;" />
			</p>

			<p class="email-hidden-widget"><label><?php _e( 'Hidden Field 2:', APP_TD ); ?></label><br />
			<label for="<?php echo $this->get_field_id('hname2'); ?>"><?php _e( 'Name:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hname2'); ?>" name="<?php echo $this->get_field_name('hname2'); ?>" value="<?php echo $instance['hname2']; ?>" style="width:175px;" />&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id('hvalue2'); ?>"><?php _e( 'Value:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hvalue2'); ?>" name="<?php echo $this->get_field_name('hvalue2'); ?>" value="<?php echo $instance['hvalue2']; ?>" style="width:175px;" />
			</p>

			<p class="email-hidden-widget"><label><?php _e( 'Hidden Field 3:', APP_TD ); ?></label><br />
			<label for="<?php echo $this->get_field_id('hname3'); ?>"><?php _e( 'Name:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hname3'); ?>" name="<?php echo $this->get_field_name('hname3'); ?>" value="<?php echo $instance['hname3']; ?>" style="width:175px;" />&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id('hvalue3'); ?>"><?php _e( 'Value:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hvalue3'); ?>" name="<?php echo $this->get_field_name('hvalue3'); ?>" value="<?php echo $instance['hvalue3']; ?>" style="width:175px;" />
			</p>

			<p class="email-hidden-widget"><label><?php _e( 'Hidden Field 4:', APP_TD ); ?></label><br />
			<label for="<?php echo $this->get_field_id('hname4'); ?>"><?php _e( 'Name:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hname4'); ?>" name="<?php echo $this->get_field_name('hname4'); ?>" value="<?php echo $instance['hname4']; ?>" style="width:175px;" />&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id('hvalue4'); ?>"><?php _e( 'Value:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hvalue4'); ?>" name="<?php echo $this->get_field_name('hvalue4'); ?>" value="<?php echo $instance['hvalue4']; ?>" style="width:175px;" />
			</p>

			<p class="email-hidden-widget"><label><?php _e( 'Hidden Field 5:', APP_TD ); ?></label><br />
			<label for="<?php echo $this->get_field_id('hname5'); ?>"><?php _e( 'Name:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hname5'); ?>" name="<?php echo $this->get_field_name('hname5'); ?>" value="<?php echo $instance['hname5']; ?>" style="width:175px;" />&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id('hvalue5'); ?>"><?php _e( 'Value:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hvalue5'); ?>" name="<?php echo $this->get_field_name('hvalue5'); ?>" value="<?php echo $instance['hvalue5']; ?>" style="width:175px;" />
			</p>

			<p class="email-hidden-widget"><label><?php _e( 'Hidden Field 6:', APP_TD ); ?></label><br />
			<label for="<?php echo $this->get_field_id('hname6'); ?>"><?php _e( 'Name:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hname6'); ?>" name="<?php echo $this->get_field_name('hname6'); ?>" value="<?php echo $instance['hname6']; ?>" style="width:175px;" />&nbsp;&nbsp;&nbsp;
			<label for="<?php echo $this->get_field_id('hvalue6'); ?>"><?php _e( 'Value:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('hvalue6'); ?>" name="<?php echo $this->get_field_name('hvalue6'); ?>" value="<?php echo $instance['hvalue6']; ?>" style="width:175px;" />
			</p>

		<?php
	}
}

// Tabbed Blog Widget
class CLPR_Widget_Tabbed_Blog extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Display a tabbed widget for blog posts.', APP_TD ), 'classname' => 'widget-tabbed-blog' );
		parent::__construct( 'tabbed-blog', __( 'Clipper Tabbed Blog Widget', APP_TD ), $widget_ops );
	}

	function widget( $args, $instance ) {
		global $wpdb;

		extract( $args );

		echo $before_widget;

	?>
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	jQuery(document).ready(function() {
		jQuery('#blog_tab_controls li').first().addClass('active');
		jQuery('#blog-tabs .tab-content').first().show();

		jQuery( '#blog_tab_controls' ).on('click', 'a', function() {
			jQuery('#blog_tab_controls li').removeClass('active');
			jQuery('#blog-tabs .tab-content').hide();

			jQuery(this).parent().addClass('active');
			jQuery( jQuery(this).attr('href') ).show();
			return false;		
		});
	});
	//-->!]]>
	</script>

		<div class="blog-tabs" id="blog-tabs">

			<div class="sidebox-heading">

				<ul id="blog_tab_controls" class="tabset">
					<li><a href="#blogtab1"><span><?php _e( 'Recent', APP_TD ); ?></span><em class="bullet">&nbsp;</em></a></li>
					<li><a href="#blogtab2"><span><?php _e( 'Popular', APP_TD ); ?></span><em class="bullet">&nbsp;</em></a></li>
					<li><a href="#blogtab3"><span><?php _e( 'Comments', APP_TD ); ?></span><em class="bullet">&nbsp;</em></a></li>
				</ul>

			</div>

			<div class="tab-content" id="blogtab1">

				<ul>
				<?php
					$blog_posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 10, 'paged' => 1, 'no_found_rows' => true ) );
					if ( $blog_posts->have_posts() ) {
						while( $blog_posts->have_posts() ) {
							$blog_posts->the_post();
							$link = html_link( get_permalink(), get_the_title() );
							$date = html( 'span', get_the_date() );
							echo html( 'li', $link . ' ' . $date );
						}
					} else {
						echo html( 'li', __( 'There are no blog articles yet.', APP_TD ) );
					}
					wp_reset_postdata();
				?>
				</ul>

			</div>

			<div class="tab-content" id="blogtab2">

				<ul>
				<?php
					$popular_posts = new CLPR_Popular_Posts_Query( array( 'post_type' => 'post', 'posts_per_page' => 10, 'paged' => 1, 'no_found_rows' => true ) );
					if ( $popular_posts->have_posts() ) {
						while( $popular_posts->have_posts() ) {
							$popular_posts->the_post();
							$link = html_link( get_permalink(), get_the_title() );
							$date = html( 'span', get_the_date() );
							echo html( 'li', $link . ' ' . $date );
						}
					} else {
						echo html( 'li', __( 'There are no popular blog posts yet.', APP_TD ) );
					}
					wp_reset_postdata();
				?>
				</ul>

			</div>

			<div class="tab-content" id="blogtab3">

				<ul>
				<?php
					$comments = get_comments( array( 'number' => 10, 'post_type' => 'post', 'status' => 'approve', 'type' => '' ) );

					if ( ! $comments )
						echo html( 'li', __( 'There are no blog comments yet.', APP_TD ) );

					foreach ( $comments as $comment ) {
						$permalink = get_comment_link( $comment );
						$post_title = get_the_title( $comment->comment_post_ID );
						$link = html_link( $permalink, $post_title );
						echo html( 'li', sprintf( __( '%1$s on %2$s', APP_TD ), $comment->comment_author, $link ) );
					}
				?>
				</ul>

			</div>

		</div>

		<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
	}
}


// facebook like box sidebar widget
class AppThemes_Widget_Facebook extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'This places a Facebook page Like Box in your sidebar to attract and gain Likes from visitors.', APP_TD ) );
		parent::__construct( false, __( 'Clipper Facebook Like Box', APP_TD ), $widget_ops );
	}

	function widget( $args, $instance ) {

		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );
		$fid = $instance['fid'];
		$connections = $instance['connections'];
		$width = $instance['width'];
		$height = $instance['height'];

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;

	?>
		<div class="pad5"></div>
		<iframe src="http://www.facebook.com/plugins/likebox.php?id=<?php echo $fid; ?>&amp;connections=<?php echo $connections; ?>&amp;stream=false&amp;header=true&amp;width=<?php echo $width; ?>&amp;height=<?php echo $height; ?>" scrolling="no" frameborder="0" style="border:none; background-color: transparent; overflow:hidden; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;"></iframe>
		<div class="pad5"></div>
	<?php

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fid'] = strip_tags( $new_instance['fid'] );
		$instance['connections'] = strip_tags($new_instance['connections']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);

		return $instance;
	}

	function form($instance) {

		$defaults = array( 'title' => __( 'Facebook Friends', APP_TD ), 'fid' => '137589686255438', 'connections' => '10', 'width' => '268', 'height' => '290' );
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('fid'); ?>"><?php _e( 'Facebook ID:', APP_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('fid'); ?>" name="<?php echo $this->get_field_name('fid'); ?>" value="<?php echo $instance['fid']; ?>" />
		</p>

		<p style="text-align:left;">
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('connections'); ?>" name="<?php echo $this->get_field_name('connections'); ?>" value="<?php echo $instance['connections']; ?>" style="width:50px;" />
			<label for="<?php echo $this->get_field_id('connections'); ?>"><?php _e( 'Connections', APP_TD ); ?></label>			
		</p>

		<p style="text-align:left;">
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" style="width:50px;" />
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e( 'Width', APP_TD ); ?></label>
		</p>

		<p style="text-align:left;">
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" style="width:50px;" />
			<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Height', APP_TD ); ?></label>
		</p>

	<?php
	}
}


// ad tags and categories cloud widget
class CLPR_Widget_Coupons_Tag_Cloud extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Your most used coupon tags in cloud format', APP_TD ) );
		parent::__construct( 'coupon_tag_cloud', __( 'Clipper Coupon Tag Cloud', APP_TD ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( APP_POST_TYPE == $current_taxonomy ) {
				$title = __( 'Coupon Tags', APP_TD );
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div class="tagcloud">';
		wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy) ) );
		echo "</div>\n";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		return $instance;
	}

	function form( $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e( 'Taxonomy:', APP_TD ); ?></label>

			<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
			<?php foreach ( get_object_taxonomies(APP_POST_TYPE) as $taxonomy ) :
					$tax = get_taxonomy($taxonomy);
					if ( !$tax->show_tagcloud || empty($tax->labels->name) )
						continue;
			?>
				<option value="<?php echo esc_attr($taxonomy); ?>" <?php selected($taxonomy, $current_taxonomy); ?>><?php echo $tax->labels->name; ?></option>
			<?php endforeach; ?>
			</select>
		</p>
	<?php
	}

	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}


// footer contact form widget
class WP_Widget_Contact_Footer extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_contact_form', 'description' => __( 'A simple contact form designed for the footer.', APP_TD ) );
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'contact_form', __( 'Footer Contact Form', APP_TD ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? __( 'Contact Form', APP_TD ) : $instance['title'], $instance, $this->id_base);
		$action = (empty($instance['action']) ? '#' : $instance['action']);
		$class = empty($instance['class']) ? '' : $instance['class'];
		if ($class)
			$before_widget = str_replace('customclass', $class, $before_widget);
		else
			$before_widget = str_replace('customclass', 'contact', $before_widget);

		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>				
			<form class="contact-form" action="<?php echo $instance['action']; ?>" method="post">
				<fieldset>
					<input type="text" name="full_name" value="<?php _e( 'Your name', APP_TD ); ?>" class="text">
					<input type="text" name="email_address" value="<?php _e( 'Your email address', APP_TD ); ?>" class="text">
					<input type="hidden" name="submitted" value="submitted" class="text">
					<textarea rows="10" cols="30" class="text-area" name="comments"></textarea>
					<div class="row">
						<button onsubmit="this.where.reset();return false;" name="submit" value="Submit" id="submit" title="<?php _e( 'Send', APP_TD ); ?>" type="submit" class="btn-submit"><span style="margin-top: -1px;"><?php _e( 'Send', APP_TD ); ?></span></button>
					</div>
				</fieldset>
			</form>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['class'] = strip_tags($new_instance['class']);
		$instance['action'] = strip_tags($new_instance['action']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'class' => '', 'action' => '' ) );
		$title = strip_tags($instance['title']);
		$class = strip_tags($instance['class']);
		$action = strip_tags($instance['action']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('class'); ?>"><?php _e( 'Class:', APP_TD ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($class); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('action'); ?>"><?php _e( 'Post Action:', APP_TD ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('action'); ?>" name="<?php echo $this->get_field_name('action'); ?>" type="text" value="<?php echo esc_attr($action); ?>" /></p>


		<?php
	}
}


// share coupon button widget
class CLPR_Widget_Share_Coupon extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Share a coupon button for use in sidebar', APP_TD ) );
		parent::__construct( 'share_coupon_button', __( 'Clipper Share Coupon Button', APP_TD ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __( 'Share a Coupon', APP_TD ) : $instance['title'] );
		$description = apply_filters('widget_title', $instance['description'] );

?>
		<a href="<?php echo clpr_get_submit_coupon_url(); ?>" class="share-box">
			<img src="<?php echo appthemes_locate_template_uri('images/share_icon.png'); ?>" title="" alt="" />
			<span class="lgheading"><?php echo $title; ?></span>
			<span class="smheading"><?php echo $description; ?></span>
		</a>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description']);
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __( 'Share a Coupon', APP_TD ), 'description' => __( 'Spread the Savings with Everyone!', APP_TD ) );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = strip_tags($instance['title']);
		$description = strip_tags($instance['description']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('description'); ?>"><?php _e( 'Description:', APP_TD ); ?><input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo esc_attr($description); ?>" /></label></p>
<?php
	}
}


// Most Searched Phrases Widget
class CLPR_Widget_Popular_Searches extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => __( 'Display the most searched phrases.', APP_TD ), 'classname' => 'widget-coupon-searches' );
		parent::__construct('popular-searches', __( 'Clipper Popular Searches', APP_TD ), $widget_ops);
	}

	function widget($args, $instance) {
		global $wpdb;
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __( 'Popular Searches', APP_TD ) : $instance['title']);

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

		$sql = "SELECT terms, SUM(count) as total_count FROM $wpdb->clpr_search_total WHERE last_hits > 0 GROUP BY terms ORDER BY total_count DESC LIMIT %d";
		$popular_searches = $wpdb->get_results( $wpdb->prepare( $sql, $number ) );
		$result = '';

		if ( $popular_searches ) {
			$result .= '<div class="coupon-searches-widget"><ul class="list">';
			foreach ($popular_searches as $searched) {
				$url = add_query_arg( array( 's' => urlencode($searched->terms), 'Search' => __( 'Search', APP_TD ) ), home_url('/') );
				$count = sprintf( _n( '%s time', '%s times', $searched->total_count, APP_TD ), $searched->total_count );
				$result .= '<li><a href="'. $url .'">'. $searched->terms .'</a> - '. $count. '</li>';
			}
			$result .= '</ul></div>';
		}

		echo $result;

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number' => 10 ) );
		$title = esc_attr($instance['title']);
		$number = absint($instance['number']);
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of phrases to show:', APP_TD ); ?></label>
				<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
			</p>
		<?php
	}
}


// expiring soon coupons widget
class CLPR_Widget_Expiring_Coupons extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'Display the expiring soon coupons.', APP_TD ), 'classname' => 'widget-custom-coupons' );
		parent::__construct( 'expiring-coupons', __( 'Clipper Expiring Coupons', APP_TD ), $widget_ops );

		// allows to order by date from meta_value
		add_filter( 'posts_orderby', array( $this, 'orderby_meta_date' ), 10, 2 );
	}

	function orderby_meta_date( $orderby, $wp_query ) {
		global $wpdb;

		if ( $wp_query->get( 'orderby_meta_date' ) )
			$orderby = " CAST( $wpdb->postmeta.meta_value AS DATE ) " . $wp_query->get( 'order' );

		return $orderby;
	}

	function widget( $args, $instance ) {
		global $post;

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Expiring Coupons', APP_TD ) : $instance['title'] );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		if ( strpos( $before_widget, 'customclass' ) !== false)
			$before_widget = str_replace( 'customclass', 'cut', $before_widget );
		else
			$before_widget = str_replace( 'customclass', '', $before_widget );

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;		

		$expiring_args = array(
			'post_type' => APP_POST_TYPE,
			'posts_per_page' => $number,
			'meta_query' => array(
				array(
					'key' => 'clpr_expire_date',
					'value' => date( 'Y-m-d', current_time( 'timestamp' ) ),
					'type' => 'date',
					'compare' => '>='
				),
			),
			'no_found_rows' => true,
			'orderby_meta_date' => true,
			'orderby' => 'meta_value',
			'order' => 'ASC',
		);

		$coupons = new WP_Query( $expiring_args );
		$result = '';

		if ( $coupons->have_posts() ) {
			$result .= '<div class="coupon-ticker"><ul class="list">';

			while ( $coupons->have_posts() ) {
				$coupons->the_post();

				$expire_date = clpr_get_expire_date( $post->ID, 'raw' );

				if ( appthemes_days_between_dates( $expire_date ) > 0 ) {
					$time = clpr_get_expire_date( $post->ID, 'time' );
					$time_left = human_time_diff( $time + ( 24*3600 ), current_time( 'timestamp' ) );

					$expires_text = sprintf( __( 'expires in %s', APP_TD ), $time_left );
				} else {
					$expires_text = __( 'expires today', APP_TD );
				}

				$result .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a> - ' . $expires_text . '</li>';
			}

			$result .= '</ul></div>';
		}

		wp_reset_postdata();

		echo $result;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'number' => 10 ) );
		$title = esc_attr( $instance['title'] );
		$number = absint( $instance['number'] );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of coupons to show:', APP_TD ); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
	<?php
	}
}


// register the custom sidebar widgets
function clpr_widgets_init() {

	register_widget( 'AppThemes_Widget_Facebook' );
	register_widget( 'CLPR_Widget_Subscribe' );
	register_widget( 'CLPR_Widget_Coupons_Tag_Cloud' );
	register_widget( 'CLPR_Widget_Popular_Stores' );
	register_widget( 'CLPR_Widget_Featured_Stores' );
	register_widget( 'CLPR_Widget_Popular_Coupons' );
	register_widget( 'CLPR_Widget_Coupon_Categories' );
	register_widget( 'CLPR_Widget_Share_Coupon' );
	register_widget( 'CLPR_Widget_Popular_Searches' );
	register_widget( 'CLPR_Widget_Expiring_Coupons' );
	register_widget( 'CLPR_Widget_Tabbed_Blog' );
	//register_widget( 'WP_Widget_Contact_Footer' );

}
add_action( 'widgets_init', 'clpr_widgets_init' );


// remove some of the default sidebar widgets
function clpr_unregister_widgets() {

	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'P2P_Widget' );
	//unregister_widget( 'WP_Widget_Pages' );
	//unregister_widget( 'WP_Widget_Archives' );
	//unregister_widget( 'WP_Widget_Links' );
	//unregister_widget( 'WP_Widget_Categories' );
	//unregister_widget( 'WP_Widget_Recent_Posts' );
	//unregister_widget( 'WP_Widget_Tag_Cloud' );

}
add_action( 'widgets_init', 'clpr_unregister_widgets', 11 );

