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

            add_settings_field(
                'wpals_settings_field_default_og_image',
                'Default Opengraph Image', 'MadOptions::default_og_image_callback',
                'madseo_options_page',
                'madseo_settings_section'
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

        public static function home_tpl_title_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_home_tpl_title');
            // output the field
            ?>
            <input type="text" name="madseo_home_tpl_title" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
                
            <?php
        }

        public static function single_tpl_title_callback() {
            // get the value of the setting we've registered with register_setting()
            $setting = get_option('madseo_single_tpl_title');
            // output the field
            ?>
            <input type="text" name="madseo_single_tpl_title" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
                
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

        wp_enqueue_media();
        wp_enqueue_script( 'madseo-default-og-image' );

        $classes_for_upload_button = 'upload-button button-add-media button-add-site-icon';
        $classes_for_update_button = 'button';
        $classes_for_wrapper       = '';

        if ( has_site_icon() ) {
            $classes_for_wrapper         .= ' has-site-icon';
            $classes_for_button           = $classes_for_update_button;
            $classes_for_button_on_change = $classes_for_upload_button;
        } else {
            $classes_for_wrapper         .= ' hidden';
            $classes_for_button           = $classes_for_upload_button;
            $classes_for_button_on_change = $classes_for_update_button;
        }

        // Handle alt text for site icon on page load.
        $site_icon_id           = (int) get_option( 'madseo_default_og_image' );
        $app_icon_alt_value     = '';
        $browser_icon_alt_value = '';

        $site_icon_url = get_site_icon_url();

        if ( $site_icon_id ) {
            $img_alt            = get_post_meta( $site_icon_id, '_wp_attachment_image_alt', true );
            $filename           = wp_basename( $site_icon_url );
            $app_icon_alt_value = sprintf(
                /* translators: %s: The selected image filename. */
                __( 'App icon preview: The current image has no alternative text. The file name is: %s' ),
                $filename
            );

            $browser_icon_alt_value = sprintf(
                /* translators: %s: The selected image filename. */
                __( 'Browser icon preview: The current image has no alternative text. The file name is: %s' ),
                $filename
            );

            if ( $img_alt ) {
                $app_icon_alt_value = sprintf(
                    /* translators: %s: The selected image alt text. */
                    __( 'App icon preview: Current image: %s' ),
                    $img_alt
                );

                $browser_icon_alt_value = sprintf(
                    /* translators: %s: The selected image alt text. */
                    __( 'Browser icon preview: Current image: %s' ),
                    $img_alt
                );
            }
        }
        ?>

        <style>
        :root {
            --site-icon-url: url( '<?php echo esc_url( $site_icon_url ); ?>' );
        }
        </style>

        <div id="site-icon-preview" class="site-icon-preview settings <?php echo esc_attr( $classes_for_wrapper ); ?>">
            <div class="direction-wrap">
                <img id="app-icon-preview" src="<?php echo esc_url( $site_icon_url ); ?>" class="app-icon-preview" alt="<?php echo esc_attr( $app_icon_alt_value ); ?>" />
                <div class="site-icon-preview-browser">
                    <svg role="img" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" class="browser-buttons"><path fill-rule="evenodd" clip-rule="evenodd" d="M0 20a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm18 0a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm24-6a6 6 0 1 0 0 12 6 6 0 0 0 0-12Z" /></svg>
                    <div class="site-icon-preview-tab">
                        <img id="browser-icon-preview" src="<?php echo esc_url( $site_icon_url ); ?>" class="browser-icon-preview" alt="<?php echo esc_attr( $browser_icon_alt_value ); ?>" />
                        <div class="site-icon-preview-site-title" id="site-icon-preview-site-title" aria-hidden="true"><?php bloginfo( 'name' ); ?></div>
                            <svg role="img" aria-hidden="true" fill="none" xmlns="http://www.w3.org/2000/svg" class="close-button">
                                <path d="M12 13.0607L15.7123 16.773L16.773 15.7123L13.0607 12L16.773 8.28772L15.7123 7.22706L12 10.9394L8.28771 7.22705L7.22705 8.28771L10.9394 12L7.22706 15.7123L8.28772 16.773L12 13.0607Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="site_icon" id="site_icon_hidden_field" value="<?php form_option( 'site_icon' ); ?>" />
        <div class="site-icon-action-buttons">
            <button type="button"
                id="choose-from-library-button"
                type="button"
                class="<?php echo esc_attr( $classes_for_button ); ?>"
                data-alt-classes="<?php echo esc_attr( $classes_for_button_on_change ); ?>"
                data-size="512"
                data-choose-text="<?php esc_attr_e( 'Choose a Default Opengraph Image' ); ?>"
                data-update-text="<?php esc_attr_e( 'Change Default Opengraph Image' ); ?>"
                data-update="<?php esc_attr_e( 'Set as Default Opengraph Image' ); ?>"
                data-state="<?php echo esc_attr( has_site_icon() ); ?>"

            >
                <?php if ( has_site_icon() ) : ?>
                    <?php _e( 'Change Default Opengraph Image' ); ?>
                <?php else : ?>
                    <?php _e( 'Choose a Default Opengraph Image' ); ?>
                <?php endif; ?>
            </button>
            <button
                id="js-remove-site-icon"
                type="button"
                <?php echo has_site_icon() ? 'class="button button-secondary reset remove-site-icon"' : 'class="button button-secondary reset hidden"'; ?>
            >
                <?php _e( 'Remove Default Opengraph Image' ); ?>
            </button>
        </div>

        <p class="description">
            <?php
                printf(
                    /* translators: 1: pixel value for icon size. 2: pixel value for icon size. */
                    __( 'The Default Opengraph Image is what you see in browser tabs, bookmark bars, and within the WordPress mobile apps. It should be square and at least <code>%1$s by %2$s</code> pixels.' ),
                    512,
                    512
                );
            ?>
        </p>
        <?php
        }


    }
}