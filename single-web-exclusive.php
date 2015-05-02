<?php get_header(); ?>
<div class="hline hline-medium"></div>
<main class="row">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php ?>
	<main class="main">

		
		<article class="row noscroll">
			<div class="multicontent">
				<?php $id = get_the_ID(); ?>
				<?php $content = get_post_meta($id, 'multimedia_content', true); ?>
				<?php echo embed_mm_content($content, 0); ?>
				<!--<audio controls="controls" style="width: 100%;">
					Your browser does not support the <code>audio</code> element.
					<source src="http://sbstatesman.com/wp-content/uploads/2015/02/Deadline-feb-23.mp3" type="audio/mp3">
				</audio>-->
			</div>
			<p class="excerpt"><?php get_excerpt(); ?></p>
			
		</article>
			
	</main>
	<sidebar class="sidebar">
		<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		<p class="metatext metatext-byline">
			By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a>
		</p>
		<p class="excerpt"><?php get_excerpt(); ?></p>
		share buttons
		<div class="hline hline-medium"></div>
	</sidebar>
</main>
<div class="hline hline-medium"></div>
<?php endwhile; ?>
<section class="row">
	<main class="main vline-medium">
		<h6>more <?php echo get_post_format($id);?></h6>
		posts filtered by format will appear here
	</main>
	
	<sidebar class="sidebar">
		<h6>play next</h6>
	</sidebar>
</section>

<section class="row">
	<section class="main">
		<?php while ( have_posts() ) : the_post(); ?>
		<?php comments_template(); ?>
		<?php endwhile; ?>
	</section>
</section>
<div class="hline hline-medium"></div>
<?php get_footer(); ?>