<?php get_header(); ?>

<header class="row">
	<div class="full-width">
	<div class="sectionhead">
		<div class="hline hline-background"></div>
		<span class="sectionhead-text sectionhead-text-centered"><?php single_cat_title(); ?></span>
	</div>
	</div>
</header>

<main>
	<div class="full-width">
		<div class="hline hline-strong"></div>
	</div>
	<section class="row">

		<?php if ( ! is_paged() ) : ?>

		<main class="main">

			<?php 
				$args = array(
					'posts_per_page' => 1,
					'category__and'  => array( get_category_by_slug( 'top-story' )->term_id, get_query_var( 'cat' ) )
				);
				$myposts = new WP_Query( $args );
				if ( $myposts->have_posts() ) :
					$myposts->the_post();
			?>

			<article class="hmedia">
				<figure class="thumbnail thumbnail-lede">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'medium' ); ?>
					<?php endif; ?>
				</figure>
				<div class="block">
					<h1 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h1>
					<p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time( 'F j, Y' ); ?></a></p>
					<p class="excerpt"><?php get_excerpt(); ?></p>
				</div>
			</article>
			<div class="hline hline-medium"></div>

			<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>

			<article class="hmedia hmedia-list">
			  <figure class="thumbnail thumbnail-small">
			    <?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'medium' ); ?>
					<?php endif; ?>
			  </figure>
			  <div class="block">
			    <h3 id="post-<?php the_ID(); ?>">
			      <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			    </h3>
			    <p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a></p>
			    <p class="excerpt"><?php get_excerpt(); ?></p>
			  </div>
			</article>

			<?php endwhile; ?>
			<div class="hline hline-medium"></div>
			<?php endif; ?>

			<span class="metatext metatext-colored uppercase"><?php next_posts_link( single_cat_title( 'More ', false ) . ' >' ); ?></span>
		</main>

		<?php else : ?>

		<main class="main">
			<?php get_template_part( 'archive-list' ); ?>
		</main>

		<?php endif ?>

		<?php get_sidebar(); ?>

	</section>
	<div class="full-width">
		<div class="hline hline-medium"></div>
	</div>
</main>

<?php get_footer(); ?>