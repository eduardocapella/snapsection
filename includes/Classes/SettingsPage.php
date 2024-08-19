<?php
namespace Cwss\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
* Class for the Settings Page
*
* @since 1.0.0
*/
class SettingsPage {
    public $plugin;

    public function __construct() {
        $this->plugin = plugin_basename( CWSS_PLUGIN_BASENAME );

        add_action( 'admin_menu', array( $this, 'create_settings_page' ));
        add_action( 'admin_init', array( $this, 'setup_sections' ));
        add_action( 'admin_init', array( $this, 'setup_fields' ));
        
        add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
    }

    /**
     * Create the settings link for the plugin in the plugins list
     *
     * @param [array] $links
     * @return void
     */
    public function settings_link( $links ) {
        $url = admin_url( 'options-general.php?page=snapsection' );
        
        $settings_link = '<a href="'. $url .'">' . esc_html__( 'Settings', 'snapsection' ) . '</a>';
        array_push( $links, $settings_link );

        return $links;
    }

    /**
     * Creates the SnapSection settings page for the plugin under the Settings menu item in the Dashboard
     *
     * @since 1.0.0
     * @return void
     */
    public function create_settings_page() {
        add_options_page(
            'SnapSection',
            'SnapSection',
            'manage_options',
            'snapsection',
            array( $this, 'settings_page_content' )
            // 'dashicons-editor-textcolor'
        );
    }   

    /**
     * The content of the SnapSection settings page
     *
     * @since 1.0.0
     * @return void
     */
    public function settings_page_content() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        } ?>

        <div class="wrap">
            <h2><?php echo esc_html__( 'SnapSection Settings', 'snapsection' ); ?></h2>
            <p class="mw-620"><?php echo esc_html__( 'The plugin that makes it easier to share a section of your page, article or blog post.', 'snapsection' ); ?></p>
            <p class="mw-620"><?php echo esc_html__( 'SnapSection scans every &lt;h3&gt; (third-level heading) element across your website\'s pages and posts, and creates a button that allows your audience to copy a URL that points to this &lt;h3&gt;.', 'snapsection' ); ?></p>
            <hr>
            <form method="POST" action="options.php">
                <?php
                settings_fields( 'snapsection_fields' );
                do_settings_sections( 'snapsection' );
                submit_button( esc_html__( 'Save Settings', 'snapsection' ) );
                ?>
            </form>
        </div>

        <?php
    }

    /**
     * Settings Page Section
     *
     * @since 1.0.0
     * @return void
     */
    public function setup_sections() {
        add_settings_section(
            'snapsection_section',
            esc_html__( 'Customize SnapSection','snapsection' ),
            false,
            'snapsection'
        );
    }

    /**
     * Fields for the Settings Page
     *
     * @version 1.0.0
     * @return void
     */
    public function setup_fields() {
        register_setting( 
            'snapsection_fields',
            'snapsection_dynamic',
            'snapsection_sanitize_options'
        );

        /**
         * Settings for the Icon Image Field
         */
        add_settings_field(
            'snapsection_icon_image',
            esc_html__( 'Icon', 'snapsection' ),
            array( $this, 'snapsection_icon_image' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_icon_image'
            )
        );

        /**
         * Settings for the Icon Color Field
         */
        add_settings_field(
            'snapsection_icon_color',
            esc_html__( 'Icon Color', 'snapsection' ),
            array( $this, 'field_color_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_icon_color'
            )
        );

        /**
         * Settings for the Icon Size Field
         */
        add_settings_field(
            'snapsection_icon_size',
            esc_html__( 'Icon Size', 'snapsection' ),
            array( $this, 'field_icon_size_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_icon_size'
            )
        );

    }

    /**
     * Creates the field for the Icon Color
     *
     * @since 1.0.0
     * @param [array] $arguments
     * @return void
     */
    public function field_color_callback( $arguments ) { ?>
        <input
            class="color-picker"
            name="snapsection_dynamic[color]"
            id="snapsection_dynamic_color"
            type="text"
            value="<?php echo esc_html( snapSection()->options->getOption( 'color' ) ?? '#0099FF' ) ?>"
        />
    <?php }

    /**
     * Creates the field for the Icon Size
     *
     * @param [array] $arguments
     * @return void
     */
    public function field_icon_size_callback( $arguments ) { ?>
        <input
            name="snapsection_dynamic[size]"
            id="snapsection_dynamic_size"
            type="number"
            min="0.5"
            max="1"
            step="0.1"
            value="<?php echo esc_html( snapSection()->options->getOption( 'size' ) ?? '1' ) ?>" 
        />
        
        <p class="cwss-field-description">
            <?php esc_html_e( 'Fine adjustment of your icon size. From 0.5 to 1, 50-100%.', 'snapsection' ); ?>
        </p>
    <?php }

    /**
     * Creates the field for the Icon selection
     *
     * @since 1.0.0
     * 
     * @param [array] $arguments
     * @return void
     */
    public function snapsection_icon_image( $arguments ) {

        // Icons Available
        $iconsAvailable = array(
            'option1' => 'assets/img/icon1.svg',
            'option2' => 'assets/img/icon4.svg',
            'option3' => 'assets/img/icon8.svg'
        );
        
        ?>
        <div class="cwss-row">
            <?php $i = 0; ?>
            <?php foreach( $iconsAvailable as $iconValue => $iconPath ) { ?>
                <div class="cwss-col">
                    <input
                        id='snapsection_dynamic_icon<?php echo esc_html( $i ) ?>'
                        type='radio'
                        name='snapsection_dynamic[icon]'
                        value='<?php echo esc_html( $iconValue ) ?>'
                        <?php checked( esc_html( snapSection()->options->getOption( 'icon' ) ?? 'option1' ), esc_html( $iconValue ) ) ?>
                    >
                    <label for="snapsection_dynamic_icon<?php echo esc_html( $i ) ?>">
                        <img
                            width=22
                            height=22
                            src="<?php echo esc_html( CWSS_PLUGIN_URL . $iconPath ) ?>"
                        >
                    </label>
                </div>
                <?php $i++; ?>
            <?php } ?>
        </div>
    <?php }
}
