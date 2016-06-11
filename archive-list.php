<nav class="row">
  <span class="metatext metatext-colored left"><?php previous_posts_link( '< NEWER' ); ?></span>
  <span class="metatext metatext-colored right"><?php next_posts_link( 'OLDER >' ); ?></span>
</nav>
<div class="hline hline-medium"></div>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<article class="hmedia hmedia-list">
  <figure class="thumbnail thumbnail-small">
    <?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
  </figure>
  <div class="block">
    <h3 id="post-<?php the_ID(); ?>">
      <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
    </h3>
    <p class="metatext metatext-byline small-text">By <?php if ( function_exists( 'coauthors_posts_links' ) ) { coauthors_posts_links(); } else { the_author_posts_link(); } ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a></p>
    <p class="excerpt"><?php get_excerpt(); ?></p>
  </div>
</article>
<?php endwhile; ?>
<?php endif; ?>
<div class="hline hline-medium"></div>
<nav class="row">
  <span class="metatext metatext-colored left"><?php previous_posts_link( '< NEWER' ); ?></span>
  <span class="metatext metatext-colored right"><?php next_posts_link( 'OLDER >' ); ?></span>
</nav>
