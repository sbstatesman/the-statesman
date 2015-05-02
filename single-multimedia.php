<?php get_header(); ?>
<div class="hline hline-medium"></div>
<main class="row">
	<?php while ( have_posts() ) : the_post(); ?>
	<main class="main">
		<article class="articletext large-text content-width wp-content">
			<?php echo embed_mm_content(get_the_ID()); ?>
		</article>
		<br><br>
	</main>
	
	<sidebar class="sidebar">
		<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		<p class="metatext metatext-byline">
			By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a>
		</p>
		<p class="excerpt"><?php get_excerpt(); ?></p>
		<div class="hline hline-medium"></div>
	</sidebar>
</main>

<div class="hline hline-medium"></div>
<?php endwhile; ?>
<section class="row">
	<main class="main vline-medium">
		
		<?php $postsPerRow = 3?>
		<?php $rows = 4?>
		<?php $displays   = array('video' => 'video','image' => 'photo','audio' => 'audio');?>
		<?php $format  = get_post_format(get_the_ID());?>
		<?php $args = array( 'posts_per_page' => $postsPerRow*$rows, 'cat' => 163, 'tax_query' => array(array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array('post-format-'.$format)
			))); ?>
			<?php $myposts = new WP_Query( $args ); ?>
		
		<h6>more <?php echo $displays[$format];?></h6>
		<?php for($i=0;$i<$rows&&$myposts->have_posts();$i++): ?>
			<ul class="row slidelist">
				<?php $postnum = 1?>
				
				<?php for($j=0;$j<$postsPerRow&&$myposts->have_posts();$j++): ?>
					<?php $myposts->the_post();?>
					<li class="slideitem-small">
						<figure class="thumbnail-min thumbnail-small hovertext-container">
							<a href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
								<div class="hovertext hovertext-small">
									<img src="<?php echo get_template_directory_uri(); ?>	/images/playsmall.png"/>
								</div>
							</a>
						</figure>
						<div>
							<h4 id="post-<?php the_ID(); ?>" class="slideTitle">
								<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
							</h4>
						</div>
					</li>
					
					<?php $myposts->have_posts(); $postnum += 1;?>
				<?php endfor; ?>
			</ul>
		<?php endfor;?>
		
	</main>
	
	<sidebar class="sidebar">
		<h6>play next</h6>
		<?php $args = array( 'posts_per_page' => 6, 'cat' => 163 ) ?>
		<?php $myposts = new WP_Query( $args ); ?>
		<?php while ( $myposts->have_posts() ) : ?>
		<?php $myposts->the_post(); ?>
		<?php $format  = get_post_format(get_the_ID())?>
		<article class="hmedia hmedia-list">
			<figure class="thumbnail thumbnail-xsmall">
				<?php if ( has_post_thumbnail()) {the_post_thumbnail('thumbnail');} ?>
			</figure>
			
			<div class="block">
				<h5 id="post-<?php the_ID(); ?>">
					<div class="coloredtext uppercasetext"><?php echo $displays[$format] ?></div>
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