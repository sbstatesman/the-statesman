<?php
/*
Template Name: featured
*/
?>

<!-- ALTERNATE NAV -->
<?php get_header('alt'); ?>
<!-- /ALTERNATE NAV -->

<main>
	<?php $args = array( 'posts_per_page' => 4, 'category__in' => array($featured), 'category__not_in' => array($opinions, $multimedia) ); ?>
	<?php $myposts = get_posts( $args ); ?>
	<section class="row">
			<?php if (!empty($myposts[0])) : ?>
			<?php $post = $myposts[0]; ?>
			<?php setup_postdata( $post ); ?>
			<div class="slidecontainer">
				<?php $myposts = new WP_Query( $args ); ?>
				<div class="slider">
					<div class="slick-item featured">
						<img src="https://s-media-cache-ak0.pinimg.com/originals/5f/61/2e/5f612ecd10d27cda787488136df3640e.jpg">
						<div class="textcontainer">
								Hi there
								By you
						</div>
						<div class="excerpt">
							Content
						</div>
					</div>
					<div class="slick-item featured">
						<img src="https://s-media-cache-ak0.pinimg.com/originals/5f/61/2e/5f612ecd10d27cda787488136df3640e.jpg">
						<div class="textcontainer">
								Hi there
								By me
						</div>
						<div class="excerpt">
							Content2
						</div>
					</div>
<!--have div, set img as background, add textbox pos absolute, have it fade in out 
-->
				</div>
			</div>
			<?php endif; ?>	

	</section>
		
</main>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/navmenu.js"></script>

	<script type="text/javascript">
	    $(document).ready(function(){
	      	$('.slider').slick({
	      		dots: true,
	  			infinite: true,
	  			slidesToShow: 1,
	  			slidesToScroll: 1
			});
	    });

</script>
<?php get_footer(); ?>