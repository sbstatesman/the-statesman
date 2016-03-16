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
		<sidebar class="sidebar">
			<?php $args = array( 'posts_per_page' => 1, 'tag' => 'campus-briefing'); ?>
			<?php $myposts = new WP_Query( $args ); ?>
			<?php if ( $myposts->have_posts() ) : ?>
			<?php $myposts->the_post(); ?>
			<h6><a href="<?php echo get_tag_link(get_tag_id('campus-briefing')); ?>">Campus Briefing</a></h6>
			<article class="vmedia">
				<figure class="thumbnail">
					<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
				</figure>
				<div class="block">
					<h2 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h2>
					<p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a></p>
					<p class="excerpt"><?php get_excerpt(); ?></p>
				</div>
			</article>
			<div class="hline hline-medium"></div>
			<?php endif; ?>
			<?php $args = array( 'posts_per_page' => 1, 'tag' => 'under-the-microscope' ); ?>
			<?php $myposts = new WP_Query( $args ); ?>
			<?php if ( $myposts->have_posts() ) : ?>
			<?php $myposts->the_post(); ?>
			<h6><a href="<?php echo get_tag_link(get_tag_id('under-the-microscope')); ?>">Under the Microscope</a></h6>
			<article class="vmedia">
				<figure class="thumbnail">
					<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
				</figure>
				<div class="block">
					<h2 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h2>
					<p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a></p>
					<p class="excerpt"><?php get_excerpt(); ?></p>
				</div>
			</article>
			<div class="hline hline-medium"></div>
			<?php endif; ?>
			<h6><a href="<?php echo get_permalink(get_page_by_title('Police Blotter')); ?>">Police Blotter</a></h6>
			<article class="vmedia">
				<figure class="thumbnail">
					<?php echo get_the_post_thumbnail(get_page_by_title( 'Police Blotter' )->ID, 'medium'); ?>
				</figure>
			</article>
		</sidebar>
		<main class="main vline-medium">
			<div class="main-fiveeigth vline-medium">
				<?php $args = array( 'posts_per_page' => 3, 'category__and' => array($top_story, $news), 'tag__not_in' => array(get_tag_id('campus-briefing'), get_tag_id('under-the-microscope'))); ?>
				<?php $myposts = new WP_Query( $args ); ?>
				<?php if ( $myposts->have_posts() ) : ?>
				<?php $myposts->the_post(); ?>
				<article class="vmedia">
					<figure class="thumbnail">
						<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
					</figure>
					<div class="block">
						<h1 id="post-<?php the_ID(); ?>">
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
						</h1>
						<p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a></p>
						<p class="excerpt"><?php get_excerpt(); ?></p>
					</div>
				</article>
				<div class="hline hline-medium"></div>
				<?php endif; ?>
				<?php $args = array( 'posts_per_page' => 5, 'cat' => $news, 'category__not_in' => $top_story, 'tag__not_in' => array(get_tag_id('campus-briefing'), get_tag_id('under-the-microscope')));?>
				<?php $myposts = new WP_Query( $args ); ?>
				<?php if ( $myposts->have_posts() ) : ?>
				<?php while ( $myposts->have_posts() ) : ?>
				<?php $myposts->the_post(); ?>
				<article class="hmedia-list">
					<h4 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h4>
					<p class="metatext metatext-byline small-text">By <?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a></p>
					<p class="excerpt"><?php get_excerpt(); ?></p>
				</article>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="main-threeeigth">
				<?php $args = array( 'posts_per_page' => 3, 'offset' => 1, 'category__and' => array($top_story, $news), 'tag__not_in' => array(get_tag_id('campus-briefing'), get_tag_id('under-the-microscope'))); ?>
				<?php $myposts = new WP_Query( $args ); ?>
				<?php if ( $myposts->have_posts() ) : ?>
				<?php while ( $myposts->have_posts() ) : ?>
				<?php $myposts->the_post(); ?>
				<article class="vmedia">
					<figure class="thumbnail">
						<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
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
				<?php endif; ?>
			</div>			
		</main>
	</section>
	<div class="hline hline-medium"></div>
</main>
<?php get_footer(); ?>