<?php
/*
Template Name: featured
*/
?>

<?php get_header('featured'); ?>

<main>
	<section class="row">
		<div class="slidecontainer">
			<div class="arrows-container">
				<div class="arrow-left">
					<i class="fa fa-arrow-left fa-2x"></i>
				</div>
				<div class="arrow-right">
					<i class="fa fa-arrow-right fa-2x"></i>
				</div>
			</div>
			<div class="slicktarget slidelist">
				<div class="slick-item featured">
					<div class="featured-image">
						<div class="opacity-screen"></div>
						<?php if ( has_post_thumbnail()) {the_post_thumbnail('large');} ?>
						<div class="textcontainer">						
							<h1 id="post-<?php the_ID(); ?>" class="xlarge-text center"><?php the_title(); ?></h1>
						</div>
					</div>
					<br>
					<section class="articletext large-text featured-article wp-content">
						<?php the_content(); ?>
					</section>
				</div>
				<?php $featured_tag = get_post_meta(get_the_ID(), 'featured-tag', true); ?>
				<?php $args = array( 'posts_per_page' => 20, 'tag' => $featured_tag); ?>
				<?php $myposts = new WP_Query( $args ); ?>
				<?php if ( $myposts->have_posts() ) : ?>
				<?php while ( $myposts->have_posts() ) : ?>
				<?php $myposts->the_post(); ?>
				<div class="slick-item featured">
					<div class="featured-image">
						<div class="opacity-screen"></div>
						<?php if ( has_post_thumbnail()) {the_post_thumbnail('large');} ?>
						<div class="textcontainer">						
							<h1 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
							<p class="metatext metatext-byline">
								<?php the_author_posts_link(); ?> / 
								<a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a>
							</p>
						</div>
					</div>
					<br>
					<section class="articletext large-text featured-article wp-content">
						<?php the_content(); ?>
					</section>
				</div>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="adbox">
				<!-- featured page -->
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-8107316404981446"
				     data-ad-slot="6601435210"
				     data-ad-format="auto"></ins>
				<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>