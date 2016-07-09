<sidebar class="sidebar">
  <?php
    if ( is_category( 'news' ) && is_active_sidebar( 'news-sidebar' ) ) {
      dynamic_sidebar( 'news-sidebar' );
    } elseif ( is_category( 'arts' ) && is_active_sidebar( 'arts-sidebar' ) ) {
      dynamic_sidebar( 'arts-sidebar' );
    } elseif ( is_category( 'opinions' ) && is_active_sidebar( 'opinions-sidebar' ) ) {
      dynamic_sidebar( 'opinions-sidebar' );
    } elseif ( is_category( 'sports' ) && is_active_sidebar( 'sports-sidebar' ) ) {
      dynamic_sidebar( 'sports-sidebar' );
    } elseif ( is_active_sidebar( 'article-sidebar' ) ) {
      dynamic_sidebar( 'article-sidebar' );
    }
  ?>
</sidebar>
