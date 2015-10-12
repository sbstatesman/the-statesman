<?php
/*
Template Name: featured
*/
?>
<!DOCTYPE html>

<!--
Join The Statesman Web & Graphics Section: https://www.facebook.com/groups/1481474198792246/
-->

<?php
	/* pull in category variables from functions.php */
	global $featured;
	global $top_story;
	global $news;
	global $arts_and_entertainment;
	global $opinions;
	global $sports;
	global $multimedia;
	global $breaking;
?>

<html <?php language_attributes(); ?>>
	<head>
		<link rel="shortcut icon" href="<?php bloginfo( 'template_url' ); ?>/favicon.ico" />
		<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo( 'template_url' ); ?>/apple-touch-icon.png" />
		<meta name="viewport" content="width=device-width">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title>
		<?php
				// Print the <title> tag based on what is being viewed.
				global $page, $paged;

				wp_title( '|', true, 'right' );

				// Add the blog name.
				bloginfo( 'name' );

				// Add the blog description for the home/front page.
				$site_description = get_bloginfo( 'description', 'display' );
				if ( $site_description && ( is_home() || is_front_page() ) )
					echo " | $site_description";

				// Add a page number if necessary:
				if ( $paged >= 2 || $page >= 2 )
					echo ' | ' . sprintf( 'Page %s', max( $paged, $page ) );
		?>
		</title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style-featured.css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/slick.css"/>
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
		<![endif]-->

		<!--Twitter meta tags-->
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@sbstatesman">
		<meta name="twitter:title" content="<?php the_title(); ?>">
		<meta name="twitter:description" content="<?php get_excerpt(); ?>">
		<meta name="twitter:image" content="<?php echo get_ogimg(); ?>">
		<!--Facebook meta tags-->
		<meta property="og:title" content="<?php the_title(); ?>"/>
		<meta property="og:type" content="<?php if (is_single() || is_page()) { echo 'article'; } else { echo 'website';} ?>"/>
		<meta property="og:image" content="<?php echo get_ogimg(); ?>"/>
		<meta property="og:url" content="<?php the_permalink(); ?>"/>
		<meta property="og:description" content="<?php get_excerpt(); ?>"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
		<meta property="article:publisher" content="https://www.facebook.com/sbstatesman" />
		<meta property="article:author" content="<?php echo get_author_posts_url($post->post_author); ?>"/>
		<meta property="fb:app_id" content="240206602837517" />
		<!--General meta tags-->
		<meta name="description" content="<?php get_excerpt(); ?>"/>
		<meta name="application-name" content="The Statesman" />
		<meta name="author" content="<?php the_author_meta('display_name',$post->post_author); ?>"/>

		<?php wp_head(); ?>
	</head>
<body>
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
					<div class="slick-item">
						<img src="https://s-media-cache-ak0.pinimg.com/originals/5f/61/2e/5f612ecd10d27cda787488136df3640e.jpg">
						<div class="textcontainer">						
								Hi there
								By you
						</div>
						<div class="excerpt">
							Content
						</div>
					</div>
					<div class="slick-item">
						<img src="https://s-media-cache-ak0.pinimg.com/originals/5f/61/2e/5f612ecd10d27cda787488136df3640e.jpg">
						<div class="textcontainer">						
								Hi there
								By you
						</div>
						<div class="excerpt">
							Content
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