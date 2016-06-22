<?php //Template Name: Page Tree Template
			get_header();
			if ( have_posts() ) while ( have_posts() ) : the_post();
			$templatePID = $post->ID;
			$bg_color = get_post_meta($post->ID, 'bg_color', true); ?>

<div class="top-slider">
	<?php //echo do_shortcode('[rev_slider home_slider]') ?>
</div>

<article class="page-article <?php echo $bg_color ?>" id="<?php the_slug(); ?>">
<?php echo do_shortcode('[double_slope_divider]') ?>
	<div class="container">
		<?php the_content(); ?>
	</div>
</article>

<?php endwhile; ?>


<?php $page_query = query_posts(array(
				'post_parent' => $templatePID,
				'post__not_in' => array( $templatePID ),
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_type' => 'page',
				'posts_per_page' => -1
			));
			$pageCount = 0;
			if ( have_posts() ) while ( have_posts() ) : the_post();
			$thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
			$bg_color = get_post_meta($post->ID, 'bg_color', true);
			$half_bg = get_post_meta($post->ID, 'half_bg', true); ?>
      	
  <?php if ($thumbnail) : ?>
		<article class="page-article" id="<?php the_slug(); ?>" style="background: url(<?php echo $thumbnail ?>) center center no-repeat fixed; background-size: cover;">
  <?php else : ?>
		<article class="page-article <?php echo $half_bg ?> <?php echo $bg_color ?>" id="<?php the_slug(); ?>">
  <?php endif; ?>

	<?php //add top slashes if there's no background image, swap sides on pageCount
			if (!$half_bg && !$thumbnail) { echo $pageCount%2? do_shortcode('[left_slash_divider_top]') : do_shortcode('[right_slash_divider_top]');	} ?>

			<div class="container">
				<?php if ($half_bg) : ?>
					<div class="col-sm-6 col-sm-offset-6">
						<?php the_content(); ?>
					</div>
				<?php else : ?>
					<?php the_content(); ?>
				<?php endif; ?>
			</div> <!-- close container -->
			
			<?php // add bottom slash if there's no background image, swap sides on pageCount
			if (!$half_bg && !$thumbnail) { echo $pageCount%2? do_shortcode('[left_slash_divider_bottom]') : do_shortcode('[right_slash_divider_bottom]');	}
			$pageCount++; ?>

		</article>

<?php endwhile; wp_reset_postdata(); ?>

<?php get_footer(); ?>