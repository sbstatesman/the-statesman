<sidebar class="sidebar">
	<a href="http://sbstatesman.com/wp-content/themes/the-statesman/interactive/elections2015/"><img src="<?php bloginfo( 'template_url' ); ?>/images/2015-elections-banner.png" alt="2015 USG Elections Guide" width="300" /></a>
			<div class="hline hline-medium"></div>
	<?php $args = array( 'posts_per_page' => 6 ) ?>
	<?php $myposts = new WP_Query( $args ); ?>
	<h6>Latest Stories</h6>
	<?php if ( $myposts->have_posts() ) : ?>
	<?php while ( $myposts->have_posts() ) : ?>
	<?php $myposts->the_post(); ?>
	<article class="hmedia hmedia-list">
		<figure class="thumbnail thumbnail-xsmall">
			<?php if ( has_post_thumbnail()) {the_post_thumbnail('thumbnail');} ?>
		</figure>
		<div class="block">
			<h5 id="post-<?php the_ID(); ?>">
				<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</h5>
		</div>
	</article>
	<?php endwhile; endif; ?>
	<?php wp_reset_postdata(); ?>
	<div class="hline hline-medium"></div>
	<h6>Follow</h6>
	<div class="iconbar iconbar-social">
		<a href="http://facebook.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/facebook.png" alt="Facebook" /></a>
		<a href="http://twitter.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/twitter.png" alt="Twitter" /></a>
		<a href="http://instagram.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/instagram.png" alt="Instagram" /></a>
		<a href="http://vimeo.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/vimeo.png" alt="Vimeo" /></a>
	</div>
</sidebar>