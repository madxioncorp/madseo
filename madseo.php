<?php
/**
 * @package MADSEO
 * @version 0.0.1
 */
/*
 * Plugin Name: MADSEO - Simple SEO Optimation for WP
 * Plugin URI: https://mad.xion.my.id/
 * Description: This plugins will help You to manage the SEO of your WordPress website.
 * Author: Madxion Corp
 * Version: 0.0.1
 * Author URI: http://profiles.wordpress.org/madxioncorp/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


include "autoload.php";
require "functions.php";

new MadSeo();

// add_filter( 'document_title', 'MadSeo::filterTitle', 100, 1 );

// apply_filters( 'wp_title', "Title", "-" );

function titleRemover () {
    return "";
}

