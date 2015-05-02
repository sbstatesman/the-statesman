<?php

add_action( 'after_setup_theme', 'thestatesman_setup' );

if ( ! function_exists( 'thestatesman_setup' ) ):
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
function thestatesman_setup() {

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// Add custom image sizes.
	// Used for large feature (header) images.
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	// Used for featured posts if a large-feature doesn't exist.
	add_image_size( 'small-feature', 500, 300 );

	add_theme_support( 'html5' );

	add_theme_support('post-formats', array('video','image','audio'));
}
endif;

if ( ! isset( $content_width ) ) {
	$content_width = 600;
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

/* GARRET ADDED THIS --------------------------------------------------------*/

/**
 * Returns the featured multimedia content of post by id.
 * Parameters: ID number of a post
 * Returns: String containing an iframe of the first multimedia object of the
 * posts format.
 */
function embed_mm_content($id) {
	$content = get_post($id)->post_content;  //Content of post
	$format  = get_post_format($id);         //Post format
	$matches = [];                           //Array to contain matches of regex
	$numMatches = 0;                         //Number of strings matched by regex
	$embed;                                   //Generic embedding function
	
	/* Video links are URLs, use the Wordpress function: "wp_oembed_get" */
	if($format == "video") {
		$pattern = "/http(s*):\/\/.*(\s?)/";
		$embed    = "wp_oembed_get";
	/*Images are shortcodes, use the Wordpress function: "do_shortcode" */
	} else if($format == "image") {
		$pattern = "/\[(gallery)(.*)\]/";
		$embed    = "do_shortcode";
	/* TODO: Need to show more for audio, also need to handle soundcloud */
	} else if($format == "audio") {
		$pattern = "/\[(audio)(.*)\]/";
		$embed    = "do_shortcode";
	/* Default case, just show featured image */
	} else {
		if(has_post_thumbnail($id)) {
			return get_the_post_thumbnail($id, "large");
		} else {
			return "No content found";
		}
	}
	/* Iterate through regex matches, if the embed function works, return.
	 * It is important to note that the first matched multimedia will be
	 * returned.
	 */
	$numMatches = preg_match_all($pattern, $content, $matches);
	for($i=0;$i<$numMatches;++$i) {
		$embedded = $embed($matches[0][$i], array('height'=>450));
		if($embedded!=false) {
			return $embedded;
		}
	}
}

/**
 * Filters post display, a post in a category is displayed with the template:
 * single-{category-name}.php
 */
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
		return TEMPLATEPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);

/* 
 * The slick gallery shortcode.
 *
 * This implements the functionality of the slick sliding gallery shortcode.
 * 
 * @param array $attr {
 *     Attributes of the slick gallery shortcode.
 *
 *     @type int    $id         Post ID.
 *     @type string $size       Size of the images to display. Default
 *                              'thumbnail'.
 *     @type string $ids        A comma-separated list of IDs of attachments
 *                              to display. Default empty.
 *     @type string $link       What to link each image to. Default empty
 *                              (links to the attachment page).
 *                              Accepts 'file', 'none'.
 * }
 * @return string HTML content to display gallery.
 */
function slicklist_shortcode($attr) {
	$post = get_post();
	
	//Create list of parameters, with defaults.
	$atts = shortcode_atts( array(
		'id'   => $post ? $post->ID : 0,
		'size' => 'large',
		'link' => '',
		'ids'  => ''
	), $attr, 'gallery' );
	
	$id = intval( $atts['id'] );
	/* retrieve properly sized images */
	//If the ids field is filled, use the ids there to populate the gallery
	if ( ! empty( $atts['ids'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['ids'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image') );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	//otherwise, retrieve all children of the current post
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image') );
	}
	//If those steps failed, return nothing now
	if ( empty( $attachments ) ) {
		return '';
	}
	
	//If we are in a feed, return unstyled list of images
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}
	
	/* insert images into a template */
	//Initial boilerplate
	$output = '<div class="gallery-container"><div class="arrows-container"><div id="prev" class="arrow-left"><img src="'.get_template_directory_uri().'/images/thin_left_arrow_333.png" /></div><div id="next" class="arrow-right"><img src="'.get_template_directory_uri().'/images/thin_right_arrow_333.png" /></div></div><div class="slickmebaby">';
	
	foreach($attachments as $id => $attachment) {
		
		if ( ! empty( $atts['link'] ) && $atts['link'] === 'file' ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false);
		} elseif ( ! empty( $atts['link'] ) && $atts['link'] === 'none' ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false);
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false);
		}
		
		// If image has an excerpt make room for it
		if($attachment->post_excerpt !== '') {
			$output .= '<div class="slick-item"><div class="imagearea">'.$image_output.'</div>';
			$output .= '<div class="textarea excerpt">'.$attachment->post_excerpt.'</div></div>';
		//If it doesn't don't
		} else {
			$output .= '<div class="slick-item">'.$image_output.'</div></div>';
		}
	}
	
	$output .= "</div></div>\n";
	
	return $output;
}
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'slicklist_shortcode');

/* AND ONLY THIS ------------------------------------------------------------*/

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
	$count = 0;
	$displayed_categories = '';
	$categories = get_the_category();
	foreach($categories as $category) {
		$count++;
		if ($category->cat_ID == 13592) {
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

require( get_template_directory() . '/inc/staff-shortcode.php' );
require( get_template_directory() . '/inc/issuu.php' );

?>