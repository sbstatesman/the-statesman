<!DOCTYPE html>

<!--
Join The Statesman Web & Graphics Section: https://www.facebook.com/groups/statesmanweb
-->

<?php
	/* pull in category variables from functions.php */
	global $featured;
	global $top_story;
	global $news;
	global $arts;
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
	<body <?php body_class($class); ?>>
	    <div class="side-menu" id="nav">
	      <ul class="side-menu-list">
	      	<li id="side-menu-item-0" class="side-heading side-menu-item">
	        	<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	        </li>
          <?php $i = 1;?>
          <?php $featured_tag = get_post_meta(get_the_ID(), 'featured-tag', true); ?>
          <?php $args = array( 'posts_per_page' => 20, 'tag' => $featured_tag); ?>
          <?php $myposts = new WP_Query( $args ); ?>
          <?php if ( $myposts->have_posts() ) : ?>
          <?php while ( $myposts->have_posts() ) : ?>
          <?php $myposts->the_post(); ?>
	        <li id="side-menu-item-<?php echo $i?>" class="side-menu-item">
	        	<a href="<?php the_permalink() ?>" class="metatext"><?php the_title(); ?></a>
	        </li>
          <?php $i++; ?>
	        <?php endwhile; ?>
          <?php endif; ?>
          <?php wp_reset_query(); ?>
	      </ul>
	    </div>
		<nav class="fixednav center">
	    <a id="nav-menu" class="left" href="#nav"><i class="fa fa-bars fa-lg side-menu-icon"></i></a>
	    <a href="<?php echo site_url(); ?>"><img src="<?php bloginfo( 'template_url' ); ?>/images/nav-logo.png" alt="The Statesman" width="162" height="20" /></a>
		</nav>
