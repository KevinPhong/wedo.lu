<?php
/**
 * The ability for other plugins to hook into the PuSH code
 * @param array $feed_urls a list of feed urls you want to publish
 */
function fsi_publish_to_hub( $feed_urls ) {
	FSI_Pubsubhubbub::publish_to_hub( $feed_urls );
}

/**
 * Get the endpoints from the WordPress options table
 * valid parameters are "publish" or "subscribe"
 *
 * @uses apply_filters() Calls 'fsi_hub_urls' filter
 */
function fsi_get_hubs() {
	return FSI_Pubsubhubbub::get_hubs();
}

/**
 * Check if link supports PubSubHubBub or WebSub
 *
 * @return boolean
 */
function fsi_show_discovery() {
	global $withcomments;

	if ( ! $withcomments ) {
		$withcomments = 0;
	}

	$show_discovery = false;

	$supported_feed_types = apply_filters( 'fsi_show_discovery_for_feed_types', array( 'atom', 'rss2', 'rdf' ) );
	$supported_comment_feed_types = apply_filters( 'fsi_show_discovery_for_comment_feed_types', array( 'atom', 'rss2' ) );

	if (
		( is_feed( $supported_feed_types ) && ! is_archive() && ! is_singular() && 0 == $withcomments ) ||
		( is_feed( $supported_comment_feed_types ) && 1 == $withcomments ) ||
		( is_home() && current_theme_supports( 'microformats2' ) )
	) {
		$show_discovery = true;
	}

	return apply_filters( 'fsi_show_discovery', $show_discovery );
}

/**
 * Get the correct self URL
 *
 * @return boolean
 */
function fsi_get_self_link() {
	return trailingslashit( home_url( add_query_arg( null, null ) ) );
}
