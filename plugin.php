<?php
/**
 * Plugin Name: The Events Calendar Extension: Make Organizer Names Link Straight to the Organizer Website URLs
 * Description: Make organizer names link straight to the organizer website URLs instead of to single organizer pages.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Make_Organizer_Name_Link_to_Organizer_Website {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Tickets__Main'                     => '4.2',
        'Tribe__Events__Main'                      => '4.2',
        'Tribe__Tickets_Plus__Main'                => '4.2',
        'Tribe__Events__Pro__Main'                 => '4.2',
        'Tribe__Events__Community__Main'           => '4.2',
        'Tribe__Events__Community__Tickets__Main'  => '4.2',
        'Tribe__Events__Filterbar__View'           => '4.2',
        'Tribe__Events__Facebook__Importer'        => '4.2',
        'Tribe__Events__Ical_Importer__Main'       => null,
        'Tribe__Events__Tickets__Eventbrite__Main' => null,
        'Tribe_APM' => null,
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_filter( 'tribe_get_organizer_link', array( $this, 'make_organizer_name_link_to_organizer_website' ), 10, 4 );
    }

    /**
     * Make organizer names link straight to the organizer website URLs instead of to single organizer pages.
     *
     * @param string $link
     * @param int $post_id
     * @param string $full_link
     * @param string $url
     * @return string
     */
    public function make_organizer_name_link_to_organizer_website( $link, $post_id, $full_link, $url ) {
        
        $website_url = tribe_get_organizer_website_url( $post_id );

        if ( ! is_string( $website_url ) || empty( $website_url ) ) {
            return $link;
        }

        return sprintf( '<a href="%s" target="_blank">%s</a>', $website_url, tribe_get_organizer( $post_id ) );
    }
}

new Tribe__Extension__Make_Organizer_Name_Link_to_Organizer_Website();
