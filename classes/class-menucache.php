<?php
/**
 * Caches calls to wp_nav_menu().
 */

namespace theme_plugin\classes;

class MenuCache {

	public const CACHE_KEY = 'menu_cache';
	protected int $cache_time;

	public function __construct( $cache_time = 0 ) {
		$this->cache_time = $cache_time;
	}

	public function add_actions() {
		add_filter( 'pre_wp_nav_menu', [ $this, 'pre_wp_nav_menu' ], 10, 2 );
		add_filter( 'wp_nav_menu', [ $this, 'maybe_cache_nav_menu' ], 10, 2 );
		add_action( 'wp_update_nav_menu', [ $this, 'clear_caches' ],10 ,2 );
	}

	private function get_cache_key( $args ): string
    {
		return static::CACHE_KEY . md5( serialize( $args ) );
	}

	public function maybe_cache_nav_menu( string $menu, \stdClass $args ) {
		set_transient( $this->get_cache_key((array)$args), $menu, $this->cache_time );
		return $menu;
	}

	public function pre_wp_nav_menu( $return, $args ) {
		$menu = get_transient( $this->get_cache_key($args) );
		if ( $menu ) {
			return $menu . '<!-- cached -->';
		}
		return null;
	}

    /**
     * @param int|string $menu_id
     * @param array|null $menu_data
     * @return void
     */
	public function clear_caches( $menu_id = null, $menu_data = null ) {
		delete_option( '%'.static::CACHE_KEY.'%' );
	}
}