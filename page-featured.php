<?php
/*
Template Name: featured
*/
?>

<!-- ALTERNATE NAV -->
<?php get_header('alt'); ?>
<!-- /ALTERNATE NAV -->

<main>
  <?php $featured_tag = get_post_meta(get_the_ID(), 'featured-tag', true); ?>
	<?php $args = array( 'posts_per_page' => 10, 'tag' => $featured_tag); ?>
	<?php $myposts = new WP_Query( $args ); ?>
	<section class="row">
		<div class="slidecontainer">
			<div class="arrows-container">
				<div class="arrow-left">
					<img src="<?php echo get_template_directory_uri(); ?>/images/thin_left_arrow_333.png" />
				</div>
				<div class="arrow-right">
					<img src="<?php echo get_template_directory_uri(); ?>/images/thin_right_arrow_333.png" />
				</div>
			</div>
			<div class="slicktarget slidelist">
				<?php if ( $myposts->have_posts() ) : ?>
					<?php while ( $myposts->have_posts() ) : ?>
						<?php $myposts->the_post(); ?>
						<div class="slick-item featured">
							<div class="featured-image">
								<?php if ( has_post_thumbnail()) {the_post_thumbnail('medium');} ?>
							</div>
							<div class="textcontainer">						
								<div class="block">
									<h3 id="post-<?php the_ID(); ?>">
										<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
									</h3>
									<p class="metatext metatext-byline small-text"><?php the_author_posts_link(); ?> / <a href="<?php the_archive_date(); ?>"><?php the_time('F j, Y'); ?></a></p>
								</div>
							</div>
							<br>
			                <section class="container articletext large-text content-width wp-content">
			          	        <?php the_content(); ?>
			                </section>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/navmenu.js"></script>

<script type="text/javascript">
		$(document).ready(function() {
		$('img').each(function () {              // add data-lazy attribute for slick's lazy-loading
            $(this).attr('data-lazy', $(this).data('src'));
        });	
		$('.slidecontainer').each(function (i, element) {
			$('.arrow-left', element).attr('id', 'prev-' + i);
			$('.arrow-right', element).attr('id', 'next-' + i);
			$('.slicktarget', element).attr('id', 'slidelist-' + i);
		});

		$('.slidelist').each(function (i, element) {
			$('.slidelist').on('beforeChange', function(event, slick){ 
				$('html, body').scrollTop(0);            //jump to top when sliding
			}).slick({
				infinite: false,
				slidesToShow: 1,
				slidesToScroll: 1,
				prevArrow: '#prev-' + i,
				nextArrow: '#next-' + i,
				dots: true,
				draggable: false,
 			  lazyLoad: 'ondemand', // To use lazy loading, set a data-lazy attribute on your img tags and leave off the src
  			cssEase: 'linear',
				adaptiveHeight: true,   // this plus height change of .slick-slide in slick.css needed to change slicktarget heights
        appendDots: $('#nav'),
        customPaging: function(slider, i) {
          var title = $('#side-menu-item-'+i).html();
          //return '<li class="side-menu-item">'+title+'</li>';
          return title;
        }
			});
		});
		/* to cancel link redirects */
		$('.slicktarget').click(function() { 
      return false;
    });
	});
</script>
<?php get_footer(); ?>