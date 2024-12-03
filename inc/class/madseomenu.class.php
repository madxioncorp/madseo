<?php

if ( ! defined("ABSPATH") ) exit;


if( !class_exists('MadSeoMenu')) {
    class MadSeoMenu
    {
        public function __construct(){

        }

        /**
         * Summary of create
         * 
         * $args = array(
         *  'title' => '',
         *  '' => '',
         * )
         * @param array $args
         * @return void
         */
        public static function create( $args ) {
            $page = add_menu_page(
                'MADSEO Settings',
                'MADSEO',
                'manage_options',
                'madseo',
                'MadOptions::setting_page_html',
                plugins_url('madseo/assets/icon-madseo.png'),
                20
            );


            add_action( "admin_print_styles-{$page}", 'MadSeo::admin_styles' );
        }
    }
}