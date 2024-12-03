<?php

if ( ! defined("ABSPATH") ) exit;

if( !class_exists('MadSeo') ) {
    class MadSeo
    {
        public function __construct() {
            register_activation_hook(
                __FILE__,
                'MadSeo::activate'
            );
            
            register_deactivation_hook(
                __FILE__,
                'MadSeo::deactivate'
            );
            
            add_action( 'admin_menu', 'MadSeoMenu::create' );

            add_action( 'admin_init', 'MadSeo::admin_init' );
            // add_action( 'init', 'MadSeo::executeInit' );
            // add_filter( 'wp_title', 'MadSeo::filterTitle', 10, 2 );
            add_filter( 'document_title', 'MadSeo::filterTitle', 10, 2 );
            add_filter( 'wp_head', 'MadSeo::filterHead', 1, 0 );
            
        }

        public static function activate () {
            echo "activate";

        }

        public static function deactivate () {

        }

        public static function admin_init () {
            wp_register_style( 'MadSeoPluginStylesheet', plugins_url( 'madseo/css/style.css', 'madseo' ), [], true );

            MadOptions::registerOptions();
        }

        public static function admin_styles() {
            wp_enqueue_style( 'MadSeoPluginStylesheet' );
        }

        public static function executeInit ($title) {
            echo "execute Init";
            // global $title, $sep;

            $title = self::filterTitle($title);
            // echo $title;
            // apply_filters('wp_title', $title);
            // add_filter( 'wp_title', 'MadSeo::filterTitle', 0, 2 );
            return $title;
        }

        public static function filterTitle ($title) {
            // global $paged, $page;
            // echo "Apply Filter TItle";

            // Add the site name.
            // $title = get_bloginfo( 'name' );

            if ( is_home() || is_front_page() ) {
                $title = self::formatHomeTitle($title);
                // echo $title;
            }

            if ( is_single() || is_page() ) {
                $title = self::formatSingleTitle($title);
                // echo $title;
            }

            if ( is_category() || is_tag() ) {
                $title = self::formatCategoryTitle($title);
                // echo $title;
            }

            if ( is_author() && ! is_post_type_archive() ) {
                $title = self::formatAuthorTitle($title);
                // echo $title;
            }

            // Add the site description for the home/front page.
            // $site_description = get_bloginfo( 'description' );
            // if ( $site_description && ( is_home() || is_front_page() ) )
            //     $title = "|| $title $site_description";

            // Add a page number if necessary.
            // if ( $paged >= 2 || $page >= 2 )
            //     $title = "$title " . sprintf( __( 'Page %s', 'madseo' ), max( $paged, $page ) );

            // $title = preg_replace('/title>(.*)<\/title/is',$newtitle, $title);

            return $title;
        }

        public static function filterHead () {
            
            return "";
        }

        public static function formatHomeTitle ($title) {
            $newtitle = get_option("madseo_home_tpl_title");
            preg_match_all("/{([A-Za-z_]+)}/Uis",$newtitle, $m);
            // print_r($m[1]);
            foreach ( $m[1] as $v ) {
                if( $v == 'site_name' ) {
                    $site_title = get_bloginfo('name');
                    $newtitle = str_replace('{site_name}', $site_title, $newtitle);
                }
                // echo $title;
                if( $v == 'tagline' ) {
                    $site_tagline = get_bloginfo('description');
                    $newtitle = str_replace('{tagline}', $site_tagline, $newtitle);
                }
            }
            return $newtitle;
        }

        public static function formatSingleTitle ($title) {
            global $post;
            
            $newtitle = get_option("madseo_single_tpl_title");
            // echo $madseo_single_tpl_title;
            preg_match_all("/{([A-Za-z_]+)}/Uis",$newtitle, $m);
            // print_r($m);
            foreach ( $m[1] as $v ) {
                if( $v == 'site_name' ) {
                    $site_title = get_bloginfo('name');
                    $newtitle = str_replace('{site_name}', $site_title, $newtitle);
                }
                // echo $title;
                if( $v == 'post_title' ) {
                    $post_title = the_title('','', false);
                    $newtitle = str_replace('{post_title}', $post_title, $newtitle);
                }

                if( $v == 'post_type' ) {
                    $post_title = ucfirst(get_post_type());
                    $newtitle = str_replace('{post_type}', $post_title, $newtitle);
                }

                if( $v == 'category' ) {
                    $post_title = get_the_terms($post->ID,'category');
                    // print_r($post_title);
                    $newtitle = str_replace('{category}', $post_title[0]->name, $newtitle);
                }

                if( $v == 'author' ) {
                    $author_id = $post->post_author;
                    $post_title = get_the_author_meta( 'nicename', $author_id );;
                    // print_r($post_title);
                    $newtitle = str_replace('{author}', $post_title, $newtitle);
                }
            }
            return $newtitle;
        }

        public static function formatCategoryTitle ($title) {
            global $post;

            $terms = is_category() ? 'category': 'post_tag';

            $newtitle = get_option("madseo_category_tpl_title");
            // echo $madseo_single_tpl_title;
            preg_match_all("/{([A-Za-z_]+)}/Uis",$newtitle, $m);
            // print_r($m);
            foreach ( $m[1] as $v ) {
                if( $v == 'site_name' ) {
                    $site_title = get_bloginfo('name');
                    $newtitle = str_replace('{site_name}', $site_title, $newtitle);
                }
                // echo $title;
                if( $v == 'post_title' ) {
                    $post_title = the_title('','', false);
                    $newtitle = str_replace('{post_title}', $post_title, $newtitle);
                }

                if( $v == 'taxonomy' ) {
                    $post_title = get_the_terms($post->ID,$terms);
                    $taxonomy = is_tag() ? "Tag": $post_title[0]->taxonomy;
                    $newtitle = str_replace('{taxonomy}', ucfirst( $taxonomy ), $newtitle);
                }

                if( $v == 'category' ) {
                    $post_title = get_the_terms($post->ID,$terms);
                    $newtitle = str_replace('{category}', $post_title[0]->name, $newtitle);
                }
                
            }
            return $newtitle;
        }

        public static function formatAuthorTitle ($title) {
            global $post;
            
            $newtitle = get_option("madseo_author_tpl_title");
            // echo $madseo_single_tpl_title;
            preg_match_all("/{([A-Za-z_]+)}/Uis",$newtitle, $m);
            // print_r($m);
            foreach ( $m[1] as $v ) {
                if( $v == 'site_name' ) {
                    $site_title = get_bloginfo('name');
                    $newtitle = str_replace('{site_name}', $site_title, $newtitle);
                }

                if( $v == 'author' ) {
                    $author_id = $post->post_author;
                    $post_title = get_the_author_meta( 'nicename', $author_id );;
                    // print_r($post_title);
                    $newtitle = str_replace('{author}', $post_title, $newtitle);
                }
                
            }
            return $newtitle;
        }

        public static function theOpengraph () {
            $meta = "";

            return $meta;
        }

    }
}