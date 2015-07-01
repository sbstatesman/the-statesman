<?php
/*
Template Name: blank
*/ ?>
<?php get_header(); ?>
<main class="row">
  
  <?php while ( have_posts() ) : the_post(); ?>

  <article class="row articletext large-text wp-content">
    <?php the_content(); ?>
  </article>
  <?php endwhile; ?>

</main>
<div class="hline hline-medium"></div>
<section class="row">
    <?php comments_template(); ?>
</section>
<div class="hline hline-medium"></div>
<?php get_footer(); ?>