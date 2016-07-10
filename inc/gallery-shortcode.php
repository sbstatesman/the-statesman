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
function statesman_gallery_shortcode($attr) {
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
		$_attachments = get_posts( array(
			'include' => $atts['ids'],
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image'
		) );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	//otherwise, retrieve all children of the current post
	} else {
		$attachments = get_children( array(
			'post_parent' => $id,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image'
		) );
	}

	//If those steps failed, return nothing now
	if ( empty( $attachments ) ) {
		return '&nbsp;';
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
	$output = '<div class="gallery">';

	//Iterate through images
	foreach(explode(',',$atts['ids']) as $id) {
	  $attachment = $attachments[$id];
		$output .= '<a href="'. wp_get_attachment_url( $id ) . '" alt="' .
						get_post( $id )->post_excerpt . '">' . // caption
				'<div class="imagewrapper hovertext-container">' .
					wp_get_attachment_image( $id, $atts['size'] ) .
					'<h2 class="hovertext hovertext-small">' .
						'<i class="fa fa-expand"></i>&ensp;Gallery — ' . count($attachments) . ' images' .
					'</h2>' .
				'</div>' .
				'</a>';
	}

	$output .= '</div>';

	return $output;
}
remove_shortcode('gallery');
add_shortcode('gallery', 'statesman_gallery_shortcode');

?>
