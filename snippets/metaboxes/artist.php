<?php $position = esc_html( get_post_meta( $post->ID, 'position', true ) );
			$email = esc_html( get_post_meta( $post->ID, 'email', true ) );
			$website = esc_html( get_post_meta( $post->ID, 'website', true ) ); ?>

<p class="meta-box-title">Biography:</p>
<textarea class="meta-box-textarea" name="content" id="content"><?php echo $post->post_content; ?></textarea>
<div class="column">
	<p class="meta-box-title">Artist's Position/Title:</p>
	<input type="text" class="meta-box-input full-width" name="position" value="<?php echo $position; ?>" />
</div>
<div class="column">
	<p class="meta-box-title">Email:</p>
	<input type="text" class="meta-box-input full-width" name="email" value="<?php echo $email; ?>" />
</div>
<div class="column">
	<p class="meta-box-title">Artist's Website:</p>
	<input type="text" class="meta-box-input full-width" name="website" value="<?php echo $website; ?>" />
</div>
<div style="clear:both"></div>