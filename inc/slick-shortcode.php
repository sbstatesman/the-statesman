<?php

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
function slick_shortcode($attr) {
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
	$output = '<div class="gallery-container"><div class="arrows-container"><div id="prev" class="arrow-left"><img src="'.get_template_directory_uri().'/images/thin_left_arrow_333.png" /></div><div id="next" class="arrow-right"><img src="'.get_template_directory_uri().'/images/thin_right_arrow_333.png" /></div></div><div class="slicktarget">';
	
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
			$output .= '<div class="slick-item">'.$image_output.'</div>';
		}
	}
	
	$output .= "</div></div>\n";
	
	return $output;
}
remove_shortcode('gallery');
add_shortcode('gallery', 'slick_shortcode');

?>