<?php
/*
Plugin Name: WP Content Crawler
Plugin URI: http://wpcontentcrawler.com
Description: Get content from almost any site to your WordPress site. Requires PHP >= 5.6, mbstring
Author: Turgut Sarıçam
Text Domain: wp-content-crawler
Version: 1.8.0
Author URI: http://turgutsaricam.com
*/

require 'app/vendor/autoload.php';

// Define a path to be able to get the plugin directory. By this way, we'll be able to get the path no matter what names
// the user defined for the WordPress directory names.
if(!defined('WP_CONTENT_CRAWLER_PATH')) {
    /**
     * The plugin path with a trailing slash.
     */
    define('WP_CONTENT_CRAWLER_PATH', str_replace("/", DIRECTORY_SEPARATOR, trailingslashit(plugin_dir_path(__FILE__))));
}

// Initialize everything.
\WPCCrawler\WPCCrawler::getInstance();