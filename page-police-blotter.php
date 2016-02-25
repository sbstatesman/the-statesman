<?php get_header(); ?>
<main class="row">
	<main class="main vline-medium">
	<head>
		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/interactive/policeblotter/style.css"/>
		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/interactive/policeblotter/classic-min.css"/>
		<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script src="<?php bloginfo( 'template_url' ); ?>/interactive/policeblotter/jQDateRangeSlider-min.js"></script>
		<script type="text/javascript" src="//www.google.com/jsapi"></script>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
	</head>
	<header class="row">
		<p class="headline"><?php the_title(); ?></p>
		<div class="hline hline-medium"></div>
	</header>

	<?php while ( have_posts() ) : the_post(); ?>
	<article class="row articletext large-text wp-content">
		<?php the_content(); ?>
	</article>
	<?php endwhile; ?>
	
	<article class="row articletext large-text content-width wp-content">
	<div class="map-container">
		<div id="map"></div>
	</div>
	<div id="slider"></div>
	<div class="table-container">
		<div id="table"></div>
	</div>
    	</article>
   
	</main>
	<?php get_sidebar(); ?>
</main>
<div class="hline hline-medium"></div>
<section class="row">
	<section class="main">
		<?php comments_template(); ?>
	</section>
</section>
<div class="hline hline-medium"></div>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/interactive/policeblotter/app.js"></script>
<?php get_footer(); ?>