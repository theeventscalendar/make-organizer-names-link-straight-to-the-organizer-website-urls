<?php
/**
 * Plugin Name: The Events Calendar — Make Organizer Names Link Straight to the Organizer Website URLs
 * Description: Make organizer names link straight to the organizer website URLs instead of to single organizer pages.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

function tribe_make_organizer_name_link_to_organizer_website( $link, $post_id, $full_link, $url ) {
	$website_url = tribe_get_organizer_website_url( $post_id );

	if ( ! is_string( $website_url ) || empty( $website_url ) ) {
		return $link;
	}

	return sprintf( '<a href="%s" target="_blank">%s</a>', $website_url, tribe_get_organizer( $post_id ) );
}

add_filter( 'tribe_get_organizer_link', 'tribe_make_organizer_name_link_to_organizer_website', 10, 4 );
