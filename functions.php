<?php

add_action( 'after_setup_theme', 'statesman_setup' );

if ( ! function_exists( 'statesman_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
 * 	and backgrounds, and post formats.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since The Statesman 1.0
 */

function statesman_setup() {
	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );
	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5' );
	add_theme_support('post-formats', array('video','gallery','audio'));
}
endif;

if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

/* gobal variables for running queries */

$featured = get_category_by_slug('featured')->term_id;
$top_story = get_category_by_slug('top-story')->term_id;
$news = get_category_by_slug('news')->term_id;
$arts_and_entertainment = get_category_by_slug('arts-and-entertainment')->term_id;
$opinions = get_category_by_slug('opinions')->term_id;
$sports = get_category_by_slug('sports')->term_id;
$multimedia = get_category_by_slug('multimedia')->term_id;
$breaking = get_category_by_slug('breaking')->term_id;

function get_tag_id( $slug ) {
	return get_term_by('slug', $slug, 'post_tag')->term_id;
}

/* Pulls the post feature image for social media meta tags */
function get_ogimg() {
	/* try get a post thumbnail first */
    $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large', '' );
	if ( has_post_thumbnail($post->ID) ) {
		$ogimage = $src[0];
	} else { /* otherwise look in the post content for an img tag */
	   global $post, $posts;
	   $ogimage = '';
	   $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	   $ogimage = $matches [1] [0];
	}
	if(empty($ogimage)) { /* if there's no image after all that, just take a default */
		$ogimage = bloginfo('template_url') . '/images/og-logo.png';
	}
     return $ogimage;
}

function enqueue_and_register_scripts() {
  wp_register_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), null, true);
  wp_enqueue_script( 'match-height', get_template_directory_uri() . '/js/jquery.matchHeight.min.js', array('jquery'), null, true);
  wp_enqueue_script( 'footer-scripts', get_template_directory_uri() . '/js/footer.js', array('slick'), null, true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_and_register_scripts' );

/* Returns the featured multimedia content of post by id. */
function embed_mm_content($id) {
	$content = get_post($id)->post_content;  //Content of post
	$format  = get_post_format($id);         //Post format
	$matches = [];                           //Array to contain matches of regex
	$numMatches = 0;                         //Number of strings matched by regex
	$embed;                                   //Generic embedding function
	
	/* Video links are URLs, use the Wordpress function: "wp_oembed_get" */
	if($format == 'video') {
		$pattern = '/http(s*):\/\/.*(\s?)/';
		$embed = 'wp_oembed_get';
	/* Galleries are shortcodes, use the Wordpress function: "do_shortcode" */
	} else if($format == 'gallery') {
		$pattern = '/\[(gallery)(.*)\]/';
		$embed = 'do_shortcode';
	/* TODO: Need to show more for audio, also need to handle soundcloud */
	} else if($format == 'audio') {
		$pattern = '/https?:\/\/soundcloud.com(.*)(\s?)/';
		$embed = 'wp_oembed_get';
	/* Default case, just show featured image */
	} else {
		if(has_post_thumbnail($id)) {
			return get_the_post_thumbnail($id, 'large');
		} else {
			return 'No content found';
		}
	}

	$numMatches = preg_match_all($pattern, $content, $matches);
	for($i=0;$i<$numMatches;++$i) {
		$embedded = $embed($matches[0][$i], array('height'=>450));
		if($embedded && $format == 'video') {
			return '<div class="videowrapper">' . $embedded . '</div>';
		} else if($embedded && $format == 'audio') {
      return '<div class="videowrapper">' . $embedded . '</div>';
    } else if ($embedded) {
      return $embedded;
    }
	}
}

/* Selects the template based on the post format. */
function use_post_format_templates( $template ) {
  if (is_single() && (get_post_format() == 'video' || get_post_format() == 'gallery' || get_post_format() == 'audio')) {
    $post_format_template = locate_template( 'single-multimedia.php' );
    if ( $post_format_template ) {
      $template = $post_format_template;
    }
  }
  return $template;
}   
add_filter( 'template_include', 'use_post_format_templates' );

/* Adds Facebook XML namespaces to header */
function add_og_xml_ns($content) {
  return ' xmlns:og="http://ogp.me/ns#" ' . $content;
}
add_filter('language_attributes', 'add_og_xml_ns');

function add_fb_xml_ns($content) {
  return ' xmlns:fb="https://www.facebook.com/2008/fbml" ' . $content;
}
add_filter('language_attributes', 'add_fb_xml_ns');

/* adds an excerpt character counter into the new post page */
function excerpt_count_js(){
    echo
    '<script>
	    jQuery(document).ready(function(){
	    	var limit = 175;
			jQuery("#postexcerpt .handlediv").after("<div style=\"position:absolute;top:3px;right:30px;color:#666;\"><small>Characters left: </small><input type=\"text\" value=\"" + limit + "\" maxlength=\"3\" size=\"3\" id=\"excerpt_counter\" readonly=\"\" style=\"background:#fff;\"></div>");
	    	jQuery("#excerpt_counter").val(limit-jQuery("#excerpt").val().length);
	    	if (jQuery("#excerpt").val().length > limit) {
    			jQuery("#excerpt_counter").css("color", "#f00");
    		} else {
    			jQuery("#excerpt_counter").css("color", "#666");
    		}
	    	jQuery("#excerpt").keyup( function() {
	    		jQuery("#excerpt_counter").val(limit-jQuery("#excerpt").val().length);
	    		if (jQuery("#excerpt").val().length > limit) {
	    			jQuery("#excerpt_counter").css("color", "#f00");
	    		} else {
	    			jQuery("#excerpt_counter").css("color", "#666");
	    		}
	    	});
		});
	</script>';
}
add_action( 'admin_head-post.php', 'excerpt_count_js');
add_action( 'admin_head-post-new.php', 'excerpt_count_js');

/* adds headline character counter into the new post page */
function headline_count(){
    echo
    '<script>
	    jQuery(document).ready(function(){
	    	var limit = 70;
			jQuery("#titlediv #title-prompt-text").before("<div style=\"width:100%;text-align:right;margin-bottom:2px;\"><small>Characters left: </small><input type=\"text\" value=\"" + limit + "\" maxlength=\"3\" size=\"3\" id=\"headline_counter\" readonly=\"\" style=\"background:#fff;\"></div>");
	    	jQuery("#headline_counter").val(limit-jQuery("#title").val().length);
	    	if (jQuery("#title").val().length > limit) {
    			jQuery("#headline_counter").css("color", "#f00");
    		} else {
    			jQuery("#headline_counter").css("color", "#666");
    		}
	    	jQuery("#title").keyup( function() {
	    		jQuery("#headline_counter").val(limit-jQuery("#title").val().length);
	    		if (jQuery("#title").val().length > limit) {
	    			jQuery("#headline_counter").css("color", "#f00");
	    		} else {
	    			jQuery("#headline_counter").css("color", "#666");
	    		}
	    	});
		});
	</script>';
}
add_action( 'admin_head-post.php', 'headline_count');
add_action( 'admin_head-post-new.php', 'headline_count');

add_image_size( 'half-width', 300 );
add_image_size( 'full-width', 600 );

function statesman_sidebars() {
  register_sidebar(array(
    'id' => 'article-sidebar',
    'name' => __('Article Sidebar'),
    'description' => __('Displayed next to articles.'),
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div><div class="hline hline-medium"></div>',
    'before_title' => '<h6>',
    'after_title' => '</h6>',
  ));
  register_sidebar(array(
    'id' => 'home-sidebar',
    'name' => __('Home Sidebar'),
    'description' => __('Displayed on the home page.'),
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div><div class="hline hline-medium"></div>',
    'before_title' => '<h6>',
    'after_title' => '</h6>',
  ));
}
add_action( 'widgets_init', 'statesman_sidebars' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'half-width' => __( 'Half Width' ),
        'full-width' => __( 'Full Width' ),
    ) );
}
add_filter( 'image_size_names_choose', 'my_custom_sizes' );

/* Makes all media files appear at 'large' size */
function get_attachment_link_filter( $content, $post_id, $size, $permalink ) {
    // Only do this if we're getting the file URL
    if (! $permalink) {
        // This returns an array of (url, width, height)
        $image = wp_get_attachment_image_src( $post_id, 'large' );
        $new_content = preg_replace('/href=\'(.*?)\'/', 'href=\'' . $image[0] . '\'', $content );
        return $new_content;
    } else {
        return $content;
    }
}
add_filter('wp_get_attachment_link', 'get_attachment_link_filter', 10, 4);

/* links thumbnails to their posts */
function my_post_image_html( $html, $post_id, $post_image_id ) {
	$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
	return $html;
}
add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );

/* displays categories with specified exclusions, i.e. featured and top story - displays breaking stories in red */
function the_excluded_category($excludedcats = array()){
	global $breaking;
	$count = 0;
	$displayed_categories = '';
	$categories = get_the_category();
	foreach($categories as $category) {
		$count++;
		if ($category->cat_ID == $breaking) {
			$displayed_categories = '<a href="' . get_category_link( $category->term_id ) . '" style="color: red;"' . ' title="' . $category->name . '" ' . '>' . $category->name.'</a>';
			break;
		}
		if ( !in_array($category->cat_ID, $excludedcats) ) {
			$displayed_categories .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . $category->name . '" ' . '>' . $category->name.'</a>';

			if( $count != count($categories) ){
				$displayed_categories .= " ";
			}

		}
	}
	echo $displayed_categories;
}

/* takes post meta and returns a link to the day it was posted */
function the_archive_date(){ 
	$archive_year  = get_the_time('Y'); 
	$archive_month = get_the_time('m'); 
	$archive_day   = get_the_time('d'); 
	echo get_day_link( $archive_year, $archive_month, $archive_day);
}

/* takes wordpress excerpt and shaves it to 175 characters */
function get_excerpt(){
	$limit = 176; // set limit
	$excerpt = get_the_excerpt(); // get the excerpt provided by Wordpress
	$excerpt = preg_replace(' (\[.*?\])','',$excerpt); // get rid of any bracketed text i.e. [test]
	$excerpt = strip_shortcodes($excerpt); // remove shortcodes
	$excerpt = strip_tags($excerpt); // remove tags
	$excerpt = $excerpt . ' '; // add a space to the end in case there is a period with no trailing space
    	$excerpt = mb_substr($excerpt, 0, $limit, 'UTF-8'); // get the limited number of characters
    	$excerpt = substr($excerpt, 0, strripos($excerpt, ' ')); // cut off the string at the closest space to the end
    	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt)); // replace new lines with spaces
    	$excerpt = $excerpt.''; // add something to the end of the excerpt
	echo $excerpt;
}

/* sets excerpt length wordpress pulls from content */
function custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* allows excerpts on pages */
function my_add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'my_add_excerpts_to_pages' );

/* WIDGETS */

class statesman_latest_post extends WP_Widget {
   
  function __construct() {
    parent::__construct(
      // Base ID of your widget
      'statesman_latest_post',
      // Widget name will appear in UI
      __('Latest Post'),
      // Widget description
      array( 'description' => __('Displays one post from a given category.'), )
    );
  }
   
  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $cat_slug = apply_filters( 'widget_cat_slug', $instance['cat_slug'] );
    $cat_id = get_category_by_slug($cat_slug)->term_id;
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . '<a href="' . esc_url(get_category_link($cat_id)) . '">' . $title . '</a>' . $args['after_title'];

    $myposts = new WP_Query( array( 'posts_per_page' => 1, 'cat' => $cat_id) );
    if ( $myposts->have_posts() ) {
      $myposts->the_post();
      echo '<article class="vmedia">';
      echo '<figure class="thumbnail">';
      if ( has_post_thumbnail()) {
        the_post_thumbnail('medium');
      }
      echo '</figure>';
      echo '<div class="block">';
      echo '<h2 id="post-';
        the_ID();
      echo '">';
      echo '<a href="';
        the_permalink();
      echo '">';
        the_title();
      echo '</a>';
      echo '</h2>';
      echo '<p class="excerpt">';
        get_excerpt();
      echo '</p>';
      echo '</div>';
      echo '</article>';
    }

    echo $args['after_widget'];
  }
           
  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __('New title');
    }
    if ( isset( $instance[ 'cat_slug' ] ) ) {
      $cat_slug = $instance[ 'cat_slug' ];
    }
    else {
      $cat_slug = __('');
    }
    // Widget admin form
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e( 'Category slug:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" type="text" value="<?php echo esc_attr( $cat_slug ); ?>" />
      </p>
    <?php
  }
       
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['cat_slug'] = ( ! empty( $new_instance['cat_slug'] ) ) ? strip_tags( $new_instance['cat_slug'] ) : '';
    return $instance;
  }
} // Class wpb_widget ends here

class statesman_latest_stories extends WP_Widget {
   
  function __construct() {
    parent::__construct(
      // Base ID of your widget
      'statesman_latest_stories',
      // Widget name will appear in UI
      __('Latest Stories'),
      // Widget description
      array( 'description' => __('Lists the most recent posts.'), )
    );
  }
   
  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $num_stories = apply_filters( 'widget_num_stories', $instance['num_stories'] );
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

    $myposts = new WP_Query( array( 'posts_per_page' => (int)$num_stories ) );
    if ( $myposts->have_posts() ) {
      while ( $myposts->have_posts() ) {
        $myposts->the_post();
        echo '<article class="hmedia hmedia-list">';
        echo '<figure class="thumbnail thumbnail-xsmall">';
        if ( has_post_thumbnail()) {the_post_thumbnail('thumbnail');}
        echo '</figure>';
        echo '<div class="block">';
        echo '<h5 id="post-';
          the_ID();
        echo '">';
        echo '<a href="';
          the_permalink() ?>"><?php the_title();
        echo '</a>';
        echo '</h5>';
        echo '</div>';
        echo '</article>';
      }
    }
    wp_reset_postdata();

    echo $args['after_widget'];
  }
           
  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __('New title');
    }
    if ( isset( $instance[ 'num_stories' ] ) ) {
      $num_stories = $instance[ 'num_stories' ];
    }
    else {
      $num_stories = __('6');
    }
    // Widget admin form
    ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id( 'num_stories' ); ?>"><?php _e( 'Number to list:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'num_stories' ); ?>" name="<?php echo $this->get_field_name( 'num_stories' ); ?>" type="text" value="<?php echo esc_attr( $num_stories ); ?>" />
      </p>
    <?php
  }
       
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['num_stories'] = ( ! empty( $new_instance['num_stories'] ) ) ? strip_tags( $new_instance['num_stories'] ) : '';
    return $instance;
  }
} // Class wpb_widget ends here

// Register and load the widget
function statesman_load_widget() {
  register_widget( 'statesman_latest_stories' );
  register_widget( 'statesman_latest_post' );
}
add_action( 'widgets_init', 'statesman_load_widget' );


require( get_template_directory() . '/inc/staff-shortcode.php' );
require( get_template_directory() . '/inc/slick-shortcode.php' );
require( get_template_directory() . '/inc/issuu.php' );

?>