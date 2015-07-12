<sidebar class="sidebar">
  <?php if ( is_active_sidebar( 'article-sidebar' ) ) : ?>

      <?php dynamic_sidebar( 'article-sidebar' ); ?>

  <?php endif; ?>
  <!-- Sidebar -->
  <ins class="adsbygoogle"
        style="display:inline-block;width:300px;height:250px"
        data-ad-client="ca-pub-8107316404981446"
        data-ad-slot="1828551619">
      </ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  <div class="hline hline-medium"></div>
  <h6>Featured</h6>
  <a href="http://sbstatesman.com/title-ix-at-stony-brook-university/"><img src="http://sbstatesman.com/wp-content/themes/the-statesman/images/title-ix-banner.jpg" width="300" alt="Title IX at Stony Brook" /></a>
  <div class="hline hline-medium"></div>
  <?php $args = array( 'posts_per_page' => 6 ) ?>
  <?php $myposts = new WP_Query( $args ); ?>
  <h6>Latest Stories</h6>
  <?php if ( $myposts->have_posts() ) : ?>
  <?php while ( $myposts->have_posts() ) : ?>
  <?php $myposts->the_post(); ?>
  <article class="hmedia hmedia-list">
    <figure class="thumbnail thumbnail-xsmall">
      <?php if ( has_post_thumbnail()) {the_post_thumbnail('thumbnail');} ?>
    </figure>
    <div class="block">
      <h5 id="post-<?php the_ID(); ?>">
        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
      </h5>
    </div>
  </article>
  <?php endwhile; endif; ?>
  <?php wp_reset_postdata(); ?>
  <div class="hline hline-medium"></div>
  <!-- Sidebar - tall -->
  <ins class="adsbygoogle"
        style="display:inline-block;width:300px;height:600px"
        data-ad-client="ca-pub-8107316404981446"
        data-ad-slot="7064173217">
      </ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  <div class="hline hline-medium"></div>
  <h6>Follow</h6>
  <div class="iconbar iconbar-social">
    <a href="http://facebook.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/facebook.png" alt="Facebook" /></a>
    <a href="http://twitter.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/twitter.png" alt="Twitter" /></a>
    <a href="http://instagram.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/instagram.png" alt="Instagram" /></a>
    <a href="http://vimeo.com/sbstatesman"><img src="<?php bloginfo( 'template_url' ); ?>/images/vimeo.png" alt="Vimeo" /></a>
  </div>
</sidebar>