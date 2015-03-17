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
			<?php $args = array( 'posts_per_page' => 1, 'tag_id' => 13105 ); ?>
			<?php $myposts = new WP_Query( $args ); ?>
			<?php if ( $myposts->have_posts() ) : ?>
			<?php $myposts->the_post(); ?>
			<h6><a href="<?php echo get_tag_link(18); ?>">Points in the Paint</a></h6>
			<article class="vmedia">
				<figure class="thumbnail thumbnail-sidebar">
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
			<h6><a href="<?php echo get_category_link(14); ?>">Sports</a></h6>
			<div class="twocolumn">
				<h5><a href="<?php echo get_tag_link(1252); ?>">Men's Basketball</a></h5>
				<h5><a href="<?php echo get_tag_link(17); ?>">Women's Basketball</a></h5>
				<h5><a href="<?php echo get_tag_link(739); ?>">Baseball</a></h5>
				<h5><a href="<?php echo get_tag_link(98); ?>">Softball</a></h5>
				<h5><a href="<?php echo get_tag_link(1621); ?>">Men's Lacrosse</a></h5>
				<h5><a href="<?php echo get_tag_link(2413); ?>">Women's Lacrosse</a></h5>
			</div>
			<div class="twocolumn">
				<h5><a href="<?php echo get_tag_link(1385); ?>">Men's Soccer</a></h5>
				<h5><a href="<?php echo get_tag_link(1376); ?>">Women's Soccer</a></h5>
				<h5><a href="<?php echo site_url('/tag/cross-country,track-and-field/'); ?>">XC / Track</a></h5>
				<h5><a href="<?php echo get_tag_link(212); ?>">Football</a></h5>
				<h5><a href="<?php echo get_tag_link(8976); ?>">Club Sports</a></h5>
			</div>
		</sidebar>
		<main class="main vline-medium">
			<div class="main-threeeigth vline-medium">
				<?php $args = array( 'posts_per_page' => 3, 'offset' => 1, 'category__and' => array(883, 14), 'tag__not_in' => array(13105)); ?>
				<?php $myposts = new WP_Query( $args ); ?>
				<?php if ( $myposts->have_posts() ) : ?>
				<?php while ( $myposts->have_posts() ) : ?>
				<?php $myposts->the_post(); ?>
				<article class="vmedia">
					<figure class="thumbnail thumbnail-large">
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
			<div class="main-fiveeigth">
				<?php $args = array( 'posts_per_page' => 1, 'category__and' => array(883, 14), 'tag__not_in' => array(13105)); ?>
				<?php $myposts = new WP_Query( $args ); ?>
				<?php if ( $myposts->have_posts() ) : ?>
				<?php $myposts->the_post(); ?>
				<article class="vmedia">
					<figure class="thumbnail thumbnail-lede">
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
				<?php $args = array( 'posts_per_page' => 5, 'cat' => 14, 'category__not_in' => 883, 'tag__not_in' => array(13105));?>
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
		</main>
	</section>
	<div class="hline hline-medium"></div>
</main>
<?php get_footer(); ?>