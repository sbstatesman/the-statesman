<?php get_header(); ?>
<main class="row">
	
	<?php while ( have_posts() ) : the_post(); ?>

	<header class="row">
		<p class="headline"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
		<div class="hline hline-medium"></div>
	</header>
	<article class="row articletext large-text wp-content">
		<?php the_content(); ?>
	</article>
	<?php endwhile; ?>

</main>
<div class="hline hline-medium"></div>
<section class="row">
	<section class="main">
		<?php comments_template(); ?>
	</section>
</section>
<div class="hline hline-medium"></div>
<?php get_footer(); ?>