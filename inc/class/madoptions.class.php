<?php

if ( ! defined("ABSPATH") ) exit;

if( !class_exists('MadOptions') ) {
    class MadOptions
    {
        public function __construct() {

        }

        public static function registerOptions () {
            $args = array(
                'type' => 'string', 
                'sanitize_callback' => 'sanitize_text_field',
                'default' => NULL,
                );
            register_setting('madseo_options', 'madseo_home_tpl_title', $args);

            $args = array(
                'type' => 'string', 
                'sanitize_callback' => 'sanitize_text_field',
                'default' => NULL,
                );
            register_setting('madseo_options', 'madseo_single_tpl_title', $args);

            $args = array(
                'type' => 'string', 
                'sanitize_callback' => 'sanitize_text_field',
                'default' => NULL,
                );
            register_setting('madseo_options', 'madseo_archive_tpl_title', $args);

            $args = array(
                'type' => 'string', 
                'sanitize_callback' => 'sanitize_text_field',
                'default' => NULL,
                );
            register_setting('madseo_options', 'madseo_category_tpl_title', $args);

            $args = array(
                'type' => 'string', 
                'sanitize_callback' => 'sanitize_text_field',
                'default' => NULL,
                );
            register_setting('madseo_options', 'madseo_author_tpl_title', $args);

            $args = array(
                'type' => 'string', 
                'sanitize_callback' => 'sanitize_text_field',
                'default' => NULL,
                );
            register_setting('madseo_options', 'madseo_default_og_image', $args);

            
            add_settings_section(
                'madseo_settings_section',
                'Title Format Template', 'MadOptions::tpl_settings_section_callback',
                'madseo_options_page'
            );

            add_settings_field(
                'madseo_settings_field_home_tpl_title',
                'Home Title Format', 'MadOptions::home_tpl_title_callback',
                'madseo_options_page',
                'madseo_settings_section'
            );

            add_settings_field(
                'wpals_settings_field_single_tpl_title',
                'Single Post/Page Title Format', 'MadOptions::single_tpl_title_callback',
                'madseo_options_page',
                'madseo_settings_section'
            );

            add_settings_field(
                'wpals_settings_field_archive_tpl_title',
                'Archive Title Format', 'MadOptions::archive_tpl_title_callback',
                'madseo_options_page',
                'madseo_settings_section'
            );

            add_settings_field(
                'wpals_settings_field_category_tpl_title',
                'Category/Tag Title Format', 'MadOptions::category_tpl_title_callback',
                'madseo_options_page',
                'madseo_settings_section'
            );

            add_settings_field(
                'wpals_settings_field_author_tpl_title',
                'Author Title Format', 'MadOptions::author_tpl_title_callback',
                'madseo_options_page',
                'madseo_settings_section'
            );

            add_settings_section(
                'madseo_settings_og_section',
                'OpenGraph Settings', 'MadOptions::og_settings_section_callback',
                'madseo_options_page'
            );

            add_settings_field(
                'wpals_settings_field_default_og_image',
                'Default Opengraph Image', 'MadOptions::default_og_image_callback',
                'madseo_options_page',
                'madseo_settings_og_section'
            );
        }

        public static function setting_page_html () {
            echo "<div style='margin-top: 20px'><img src='".esc_url_raw(plugins_url('madseo/assets/logo-madseo.png', 'madseo'))."' style='height: 45px;'></div>";
            echo "<div class='MadSeoBox'>
            <div class='MadSeoInnerBox'><span class='MadSeoTitle'>MADSEO Options</span>
            
            <form action='options.php' method='post'>
            ";

            settings_fields( 'madseo_options' );
            do_settings_sections( 'madseo_options_page' );
            submit_button( __( 'Save Settings', 'madseo' ) );

            echo "
            
            </form>
            
            </div>
            </div>
            ";
        }

        public static function tpl_settings_section_callback() {
            echo '<p>Title Format Configuration.</p>';
        }

        public static function og_settings_section_callback() {
            echo '<p>OpenGraph Settings.</p>';
        }

        public static function home_tpl_title_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_home_tpl_title');
            // output the field
            ?>
            <input type="text" name="madseo_home_tpl_title" class="MadSeoInput" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
                
            <?php
        }

        public static function single_tpl_title_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_single_tpl_title');
            // output the field
            ?>
            <input type="text" name="madseo_single_tpl_title" class="MadSeoInput"  value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
                
            <?php
        }

        public static function archive_tpl_title_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_archive_tpl_title');
            // output the field
            ?>
            <input type="text" name="madseo_archive_tpl_title" class="MadSeoInput" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
                
            <?php
        }

        public static function category_tpl_title_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_category_tpl_title');
            // output the field
            ?>
            <input type="text" name="madseo_category_tpl_title" class="MadSeoInput" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
                
            <?php
        }

        public static function author_tpl_title_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_author_tpl_title');
            // output the field
            ?>
            <input type="text" name="madseo_author_tpl_title" class="MadSeoInput" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
                
            <?php
        }

        public static function default_og_image_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_default_og_image');
            // output the field
            if( $setting != "" ) {
            ?>
            <div class="display-og-image" id="display-og-image">
                <img src="<?php echo esc_url($setting);?>" class="og-image" id="og-image">
            </div>
            <?php 
            }

            ?>
            <label for="upload_image">
                <input id="upload_image" type="text" size="36" name="madseo_default_og_image" value="<?php echo esc_url( $setting );?>" /> 
                <input id="upload_image_button" class="button" type="button" value="Upload Image" />
                <br />Enter a URL or upload an image
            </label>

        <?php  
            

        }

        public static function default_og_image_script() {
                wp_enqueue_media();
                wp_register_script('madseo-script', WP_PLUGIN_URL.'/madseo/js/madseo-script.js', array('jquery'));
                wp_enqueue_script('madseo-script');

        }

    }
}