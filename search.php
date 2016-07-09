<?php get_header(); ?>
<main class="row">
	<main class="main">
		<header class="row">
			<span class="sectionhead-text">Search: <?php the_search_query(); ?></span>
		</header>
		<div class="hline hline-strong"></div>
		<?php get_template_part( 'archive-list' ); ?>
		<?php if (!have_posts()): ?>
		<h4>No results</h4>
		<?php endif; ?>
	</main>
	<?php get_sidebar(); ?>
</main>
<div class="full-width">
	<div class="hline hline-medium"></div>
</div>
<?php get_footer(); ?>
