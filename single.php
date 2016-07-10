<?php get_header(); ?>

<main class="row">
	<main class="main vline-medium">

		<?php while ( have_posts() ) : the_post(); ?>

		<header class="row">
			<div class="content-width">
				<p class="articletype"><?php the_excluded_category(array($featured, $top_story)); ?></p>
				<p class="headline"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
				<p class="metatext metatext-byline">
					By <?php if ( function_exists( 'coauthors_posts_links' ) ) { coauthors_posts_links(); } else { the_author_posts_link(); } ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a>
				</p>
				<div class="hline hline-medium"></div>
			</div>
		</header>
		<article class="row articletext large-text wp-content">
			<div class="content-width">
				<?php the_content(); ?>
			</div>
		</article>
		<?php endwhile; ?>

	</main>
	<?php get_sidebar(); ?>
</main>
<div class="full-width">
	<div class="hline hline-medium"></div>
</div>
<section class="row">
	<section class="full-width">
		<?php while ( have_posts() ) : the_post(); ?>
		<?php comments_template(); ?>
		<?php endwhile; ?>
	</section>
</section>
<div class="full-width">
	<div class="hline hline-medium"></div>
</div>
<?php get_footer(); ?>
