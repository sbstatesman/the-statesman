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

	add_theme_support('post-formats', array('gallery','video','image','audio'));
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

/* GARRET ADDED THIS --------------------------------------------------------*/
/**
 * 
 */
function get_thumb_src($size) {
	echo wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size, '' )[0];
	
}

/**
 * Returns a boolean value, indicating whether a post has multimedia content.
 */
function has_multimedia($id) {
	$hasmm = false;
	//$type = get_post_meta($id, 'multimedia_type', true);
	//$source = get_post_meta($id, 'multimedia_source', true);
	$content = get_post_meta($id, 'multimedia_content', true);
	//$hasmm = ($type != '') && ($content != '');
	return $content != '';
}

/**
 * Returns a string for embedding youtube/soundcloud/vimeo content
 */
function embed_mm_content($url, $src) {
	return '<iframe width="100%" height="100%" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
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

require( get_template_directory() . '/inc/staff-shortcode.php' );
require( get_template_directory() . '/inc/issuu.php' );

?>