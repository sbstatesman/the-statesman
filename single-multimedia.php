<?php get_header(); ?>
<div class="hline hline-medium"></div>

<main class="row">
	<?php while ( have_posts() ) : the_post(); ?>
	<main class="main">
			<?php echo embed_mm_content(get_the_ID()); ?>
	</main>
	
	<sidebar class="sidebar">
		<h1><?php the_title(); ?></h1>
		<p class="metatext metatext-byline">
			By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a>
		</p>
		<p class="excerpt"><?php get_excerpt(500); ?></p>
	</sidebar>
	<?php endwhile; ?>
</main>

<div class="hline hline-medium"></div>
<section class="row">
	<main class="main vline-medium">
		<?php $displays = array('video' => 'videos','gallery' => 'galleries','audio' => 'audio');?>
		<?php $format  = get_post_format(get_the_ID());?>
		<?php $args = array( 'posts_per_page' => 12, 'tax_query' => array(array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array('post-format-'.$format)
			))); ?>
		<?php $myposts = new WP_Query( $args ); ?>
		<h6><a href="<?php echo esc_url(get_post_format_link($format)); ?>">More <?php echo $displays[$format];?></a></h6>
		<?php while( $myposts->have_posts() ): ?>
		<?php $myposts->the_post();?>
		<div class="threecolumn">
			<div class="vmedia" data-mh="thumbnails">
				<a href="<?php the_permalink(); ?>">
					<figure class="thumbnail hovertext-container">
							<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
							<div class="hovertext hovertext-small">
								<i class="fa fa-play"></i>
							</div>
					</figure>
					<div class="block">
						<h5 id="post-<?php the_ID(); ?>">
							<?php the_title(); ?>
						</h5>
					</div>
				</a>
			</div>
		</div>
		<?php endwhile;?>
	</main>
	
	<sidebar class="sidebar">
		<h6>Play next</h6>
		<?php $args = array( 'posts_per_page' => 6, 'tax_query' => array(array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => array('post-format-video', 'post-format-gallery', 'post-format-audio')
		))) ?>
		<?php $myposts = new WP_Query( $args ); ?>
		<?php while ( $myposts->have_posts() ) : ?>
		<?php $myposts->the_post(); ?>
		<?php $format  = get_post_format(get_the_ID())?>
		<article class="hmedia hmedia-list">
			<figure class="thumbnail thumbnail-xsmall">
				<?php if ( has_post_thumbnail()) {the_post_thumbnail('thumbnail');} ?>
			</figure>
			<div class="block">
				<div class="articletype small-text"><?php echo $format ?></div>
				<h5 id="post-<?php the_ID(); ?>">
					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
				</h5>
			</div>
		</article>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</sidebar>
</section>

<div class="hline hline-medium"></div>
<section class="row">
	<section class="main">
		<?php comments_template(); ?>
	</section>
</section>
<div class="hline hline-medium"></div>

<?php get_footer(); ?>