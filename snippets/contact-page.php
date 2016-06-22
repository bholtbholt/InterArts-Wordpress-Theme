<?php $contactPage = get_post(get_page_by_title('Contact')->ID);
			$bg_color = get_post_meta($contactPage->ID, 'bg_color', true);
			$half_bg = get_post_meta($contactPage->ID, 'half_bg', true); ?>
      	
<article class="page-article <?php echo $half_bg ?> <?php echo $bg_color ?>" id="contact">
	<div class="container">
		<div class="col-sm-6 col-sm-offset-6">
			<?php echo apply_filters( 'the_content', $contactPage->post_content ); ?>
		</div>
	</div>
</article>