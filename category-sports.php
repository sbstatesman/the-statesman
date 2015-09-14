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
			<?php $args = array( 'posts_per_page' => 1, 'tag' => '4th-and-goal' ); ?>
			<?php $myposts = new WP_Query( $args ); ?>
			<?php if ( $myposts->have_posts() ) : ?>
			<?php $myposts->the_post(); ?>
			<h6><a href="<?php echo get_tag_link(get_tag_id('4th-and-goal')); ?>">F and Goal</a></h6>
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
			<h6><a href="<?php echo get_category_link($sports); ?>">Sports</a></h6>
			<div class="twocolumn">
				<h5><a href="<?php echo get_tag_link(get_tag_id('mens-basketball')); ?>">Men's Basketball</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('womens-basketball')); ?>">Women's Basketball</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('baseball')); ?>">Baseball</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('softball')); ?>">Softball</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('mens-lacrosse')); ?>">Men's Lacrosse</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('womens-lacrosse')); ?>">Women's Lacrosse</a></h5>
			</div>
			<div class="twocolumn">
				<h5><a href="<?php echo get_tag_link(get_tag_id('mens-soccer')); ?>">Men's Soccer</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('womens-soccer')); ?>">Women's Soccer</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('volleyball')); ?>">Volleyball</a></h5>
				<h5><a href="<?php echo site_url('/tag/cross-country,track-and-field/'); ?>">XC / Track</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('football')); ?>">Football</a></h5>
				<h5><a href="<?php echo get_tag_link(get_tag_id('club-sports')); ?>">Club Sports</a></h5>
			</div>
		</sidebar>
		<main class="main vline-medium">
			<div class="main-threeeigth vline-medium">
				<?php $args = array( 'posts_per_page' => 3, 'offset' => 1, 'category__and' => array($top_story, $sports), 'tag__not_in' => array(get_tag_id('4th-and-goal'))); ?>
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
			<div class="main-fiveeigth">
				<?php $args = array( 'posts_per_page' => 1, 'category__and' => array($top_story, $sports), 'tag__not_in' => array(get_tag_id('4th-and-goal'))); ?>
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
				<?php $args = array( 'posts_per_page' => 5, 'cat' => $sports, 'category__not_in' => $top_story, 'tag__not_in' => array(get_tag_id('4th-and-goal')));?>
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