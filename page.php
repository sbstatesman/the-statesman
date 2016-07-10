<?php get_header(); ?>
<main class="row">
	<div class="full-width">
		<?php while ( have_posts() ) : the_post(); ?>
		<header class="row">
			<p class="headline"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
			<div class="hline hline-medium"></div>
		</header>
		<article class="row articletext large-text wp-content">
			<?php the_content(); ?>
		</article>
		<?php endwhile; ?>
	</div>
</main>
<div class="full-width">
	<div class="hline hline-medium"></div>
</div>
<section class="row">
	<section class="full-width">
		<?php comments_template(); ?>
	</section>
</section>
<div class="full-width">
	<div class="hline hline-medium"></div>
</div>
<?php get_footer(); ?>
