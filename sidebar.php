<sidebar class="sidebar">
  <?php if ( is_active_sidebar( 'article-sidebar' ) ) : ?>

      <?php dynamic_sidebar( 'article-sidebar' ); ?>

  <?php endif; ?>
</sidebar>