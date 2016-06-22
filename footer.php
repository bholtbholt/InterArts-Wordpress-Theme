<?php echo do_shortcode('[get_contact_page]') ?>
<footer class="text-center">
	<div id="sponsors">
		<div class="container">
			<h3 class="title-lg">Our <strong>Sponsors</strong></h3>
			<h4>Making <strong>InterArts</strong> Possible</h4>
			<img src="<?php bloginfo('template_url'); ?>/images/logos/sponsors.svg">
		</div>
	</div><!--close sponsors-->
	<div id="main-footer">
	<?php echo do_shortcode('[double_slope_divider]') ?>
		<div class="container">
			<div class="logo-hex-badge"><img class="logo-badge" src="<?php bloginfo('template_url'); ?>/images/logos/InterArts-icon.svg"></div>

			<div class="row">
				<div class="footer-menu col-sm-5 col-sm-offset-1">
					<?php if ( ! dynamic_sidebar( 'Footer Menu 1' ) ) : ?>
						<ul class="col-sm-6">
							<li><strong>Contact</strong></li>
							<li>Blog</li>
							<li>FAQ</li>
							<li>Newsletter</li>
							<li>Workshop</li>
							<li>Ideas</li>
						</ul>
					<?php endif ?>
					<?php if ( ! dynamic_sidebar( 'Footer Menu 2' ) ) : ?>
						<ul class="col-sm-6">
							<li><strong>Friends</strong></li>
							<li>VIATEC</li>
							<li>Cinevic</li>
							<li>Makerspace</li>
							<li>ArtsVictoria</li>
						</ul>
					<?php endif ?>
				</div>
				<div class="footer-menu social-media col-sm-5 col-sm-offset-1">
					<?php if ( ! dynamic_sidebar( 'Footer Menu 3' ) ) : ?>
						<ul class="col-sm-6">
							<li>Facebook</li>
							<li>Twitter</li>
							<li>Vimeo</li>
							<li>Pinterest</li>
						</ul>
					<?php endif ?>
					<?php if ( ! dynamic_sidebar( 'Footer Menu 4' ) ) : ?>
						<ul class="col-sm-6">
							<li>Instagram</li>
							<li>Email Us</li>
							<li>Google+</li>
							<li>Flickr</li>
						</ul>
					<?php endif ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<h3 class="h2">Inter<strong class="yellow">Arts</strong> Centre for Makers</h3>
					<p class="small novecento">Design by <a href="#" target="_blank">J. MacDonald</a> • Built by <a href="http://www.brianholt.ca" target="_blank">Brian Holt</a> • &copy; <?php echo date("Y") ?></p>
				</div>
			</div>
		</div><!--close .container-->
	</div><!--close main-footer-->
</footer>

<?php wp_footer(); ?>
</body>
</html>