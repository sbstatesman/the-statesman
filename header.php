<!DOCTYPE html>

<!--
Join The Statesman Web & Graphics Section: https://www.facebook.com/groups/statesmanweb
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
	<body <?php body_class( $class ); ?>>
		<nav id="nav" class="fixednav">
      <div class="container">
        <a class="help show" href="#nav" title="Show navigation">&#9776;</a>
        <a class="help hide" href="#" title="Hide navigation">&#9776;</a>
        <a class="logo" href="#"><img class="logo" width="162" height="20" alt="The Statesman" src="<?php bloginfo( 'template_url' ); ?>/images/nav-logo.png"></a>
        <ul class="nav-list">
          <li class="nav-item"><a class="nav-link" href="#">News</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Arts & Entertainment</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Opinions</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Sports</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Multimedia</a></li>
          <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        </ul>
      </div>
    </nav>
		<div class="container">