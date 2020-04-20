<?php

/**
 * Plugin Name:       Yoast SEO sitemap fix
 * Plugin URI:        https://github.com/xemlock/wordpress-seo-sitemap-fix
 * Description:       Fixes Yoast SEO sitemap error: <a href="https://yoast.com/help/xml-sitemap-error/">XML declaration allowed only at the start of the document</a>
 * Version:           0.1.0
 * Author:            xemlock
 * Author URI:        https://github.com/xemlock
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined('WPINC') || die;

(function () {
    if (preg_match('#^/sitemap_index\.xml($|\?)#', $_SERVER['REQUEST_URI'])) {
        ob_start();
        add_action('init', function () {
            add_filter('wpseo_sitemap_index', function ($xml) {
                while (ob_end_clean());
                return $xml;
            });
        });
    } elseif (preg_match('#^/([-_a-z0-9]+)-sitemap\.xml($|\?)#', $_SERVER['REQUEST_URI'], $match)) {
        ob_start();
        $type = $match[1];
        add_action('init', function () use ($type) {
            add_filter("wpseo_sitemap_{$type}_content", function ($xml) {
                while (ob_end_clean());
                return $xml;
            });
        });
    }
})();
