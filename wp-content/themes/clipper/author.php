<?php
/**
 * Author profile page
 *
 */

//This sets the $curauth variable
$curauth = get_queried_object();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
?>


<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php printf( __( 'About %s', APP_TD ), $curauth->display_name ); ?></h1>

				<div class="text-box">

					<div id="user-photo"><?php appthemes_get_profile_pic( $curauth->ID, $curauth->user_email, 96 ); ?></div>

					<div class="author-main">

						<ul class="author-info">
							<li><strong><?php _e( 'Member Since:', APP_TD ); ?></strong> <?php echo date_i18n( get_option( 'date_format' ), strtotime( $curauth->user_registered ) ); ?></li>
							<li><strong><?php _e( 'Website:', APP_TD ); ?></strong> <a href="<?php echo esc_url( $curauth->user_url ); ?>"><?php echo strip_tags( $curauth->user_url ); ?></a></li>
							<li><div class="twitterico"></div><a href="http://twitter.com/<?php echo urlencode( $curauth->twitter_id ); ?>" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a></li>
							<li><div class="facebookico"></div><a href="<?php echo appthemes_make_fb_profile_url( $curauth->facebook_id ); ?>" target="_blank"><?php _e( 'Facebook', APP_TD ); ?></a></li>
						</ul>

					</div>

					<h3 class="dotted"><?php _e( 'Description', APP_TD ); ?></h3>
					<p><?php echo nl2br( $curauth->user_description ); ?></p>


					<div class="pad20"></div>

					<h3 class="dotted"><?php _e( 'Latest Coupons', APP_TD ); ?></h3>

					<div class="pad5"></div>

					<ul class="latest">

					<?php query_posts( array( 'post_type' => APP_POST_TYPE, 'author' => $curauth->ID, 'paged' => $paged ) ); ?>

					<?php if ( have_posts() ) : ?>

						<?php while( have_posts() ) : the_post(); ?>

							<li>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</li>

						<?php endwhile; ?>

					<?php else: ?>

						<li><?php _e( 'No coupons yet.', APP_TD ); ?></li>

					<?php endif; ?>

					</ul>


					<div class="pad20"></div>

					<h3 class="dotted"><?php _e( 'Recent Articles', APP_TD ); ?></h3>

					<div class="pad5"></div>

					<ul class="recent">

					<?php query_posts( array( 'post_type' => 'post', 'author' => $curauth->ID, 'paged' => $paged ) ); ?>

					<?php if ( have_posts() ) : ?>

						<?php while( have_posts() ) : the_post(); ?>

							<li>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</li>

						<?php endwhile; ?>

					<?php else: ?>

						<li><?php _e( 'No articles yet.', APP_TD ); ?></li>

					<?php endif; ?>

					</ul>

				</div> <!-- #text-box -->

			</div> <!-- #blog -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->

</div> <!-- #content -->

<?php get_sidebar( 'home' ); ?>
