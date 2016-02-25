<?php
/*
Template Name: post
*/
?>

<?php get_header(); ?>
<main class="row">
  <main class="main vline-medium">

    <header class="row content-width">
      <p class="headline"><?php the_title(); ?></p>
      <div class="hline hline-medium"></div>
    </header>

    <?php while ( have_posts() ) : the_post(); ?>
    <article class="row articletext large-text content-width wp-content">
      <?php the_content(); ?>
    </article>
    <?php endwhile; ?>

  </main>
  <?php get_sidebar(); ?>
</main>

<div class="hline hline-medium"></div>
<?php get_footer(); ?>