<?php get_header(); ?>
<main class="row">
	<main class="main">
		<header class="row">
			<span class="sectionhead-text"><?php bloginfo('name'); ?></span>
		</header>
		<div class="hline hline-strong"></div>
		<?php get_template_part( 'archive-list' ); ?>
	</main>
	<?php get_sidebar(); ?>
</main>
<div class="full-width">
	<div class="hline hline-medium"></div>
</div>
<?php get_footer(); ?>
