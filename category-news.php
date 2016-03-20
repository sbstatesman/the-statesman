<?php get_header(); ?>

<header class="row">
	<div class="sectionhead">
		<div class="hline hline-background"></div>
		<span class="sectionhead-text sectionhead-text-centered"><?php single_cat_title(); ?></span>
	</div>
</header>

<main>
	<div class="hline hline-strong"></div>
	<section class="row">

		<?php if ( ! is_paged() ) : ?>

		<main class="main">

			<?php 
				$args = array(
					'posts_per_page' => 1,
					'category__and'  => array( $top_story, $news ),
					'tag__not_in'    => array( get_tag_id( 'campus-briefing' ), get_tag_id( 'under-the-microscope' ) )
				);
				$myposts = new WP_Query( $args );
				if ( $myposts->have_posts() ) :
					$myposts->the_post();
					$top_story_ID = array( get_the_ID() );
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

			<?php endif; ?>

			<?php 
				$args = array( 
					'posts_per_page'   => 7,
					'cat'              => $news,
					'post__not_in'     => $top_story_ID,
					'tag__not_in'      => array( get_tag_id( 'campus-briefing' ), get_tag_id( 'under-the-microscope' ) )
				);
				$myposts = new WP_Query( $args );
				if ( $myposts->have_posts() ) :
					while ( $myposts->have_posts() ) : $myposts->the_post();
			?>

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

			<span class="metatext metatext-colored"><?php next_posts_link( 'MORE NEWS >' ); ?></span>	

		</main>

		<sidebar class="sidebar">

			<?php
				$args = array(
					'posts_per_page' => 1,
					'tag'            => 'campus-briefing'
				);
				$myposts = new WP_Query( $args );
				if ( $myposts->have_posts() ) : $myposts->the_post();
			?>

			<h6><a href="<?php echo get_tag_link( get_tag_id( 'campus-briefing' ) ); ?>">Campus Briefing</a></h6>
			<article class="vmedia">
				<figure class="thumbnail">
			    <?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'medium' ); ?>
					<?php endif; ?>
				</figure>
				<div class="block">
					<h2 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h2>
					<p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time( 'F j, Y' ); ?></a></p>
					<p class="excerpt"><?php get_excerpt(); ?></p>
				</div>
			</article>
			<div class="hline hline-medium"></div>

			<?php endif; ?>

			<?php
				$args = array(
					'posts_per_page' => 1,
					'tag' => 'under-the-microscope'
				);
				$myposts = new WP_Query( $args );
				if ( $myposts->have_posts() ) :
					$myposts->the_post();
			?>

			<h6><a href="<?php echo get_tag_link( get_tag_id( 'under-the-microscope' ) ); ?>">Under the Microscope</a></h6>
			<article class="vmedia">
				<figure class="thumbnail">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'medium' ); ?>
					<?php endif; ?>
				</figure>
				<div class="block">
					<h2 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h2>
					<p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time( 'F j, Y' ); ?></a></p>
					<p class="excerpt"><?php get_excerpt(); ?></p>
				</div>
			</article>
			<div class="hline hline-medium"></div>

			<?php endif; ?>

			<h6><a href="<?php echo get_permalink( get_page_by_title( 'Police Blotter' ) ); ?>">Police Blotter</a></h6>
			<article class="vmedia">
				<figure class="thumbnail">
					<?php echo get_the_post_thumbnail( get_page_by_title( 'Police Blotter' )->ID, 'medium' ); ?>
				</figure>
			</article>

		</sidebar>

		<?php else : ?>

		<main class="main">
			<?php get_template_part( 'archive-list' ); ?>
		</main>

		<?php get_sidebar(); ?>

		<?php endif ?>

	</section>
	<div class="hline hline-medium"></div>
</main>

<?php get_footer(); ?>