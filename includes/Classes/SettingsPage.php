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

        add_action( 'admin_menu', array( $this, 'create_settings_page' ) );
        add_action( 'admin_init', array( $this, 'setup_sections' ) );
        add_action( 'admin_init', array( $this, 'setup_fields' ) );
        
        add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
    }

    /**
     * Create the settings link for the plugin in the plugins list
     *
     * @param array $links
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
            <p class="mw-620"><?php echo esc_html__( 'SnapSection scans every SnapSection Element ( &lt;h2&gt; - second-level heading - by default) across your website\'s content, and creates a button that allows your audience to copy a URL that points to this element.', 'snapsection' ); ?></p>
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
         * Choose where SnapSection will appear
         */
        add_settings_field(
            'snapsection_where',
            esc_html__( 'Where', 'snapsection' ),
            array( $this, 'field_where_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_where'
            )
        );

        /**
         * Choose the element to have IDs created
         */
        add_settings_field(
            'snapsection_element',
            esc_html__( 'Element', 'snapsection' ),
            array( $this, 'field_element_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_element'
            )
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
     * Creates the Where field, so that users can should where SnapSection will appear
     *
     * @since 1.0.0
     * 
     * @param array $arguments
     * @return void
     */
    public function field_where_callback( $arguments ) {
        $args = array(
            'public'   => true,
            // '_builtin' => false
        );

        $post_types = get_post_types( $args, 'objects', 'and' );

        $post_types[ 'archive' ] = (object) array(
            'label' => 'Archives',
            'name'  => 'archive'
        );

        $post_types[ 'front_page' ] = (object) array(
            'label' => 'Front Page',
            'name'  => 'front_page'
        );

        // Get Where options
        $saved_options = snapSection()->options->getOption( 'where' );

        // If no options, set 'post' as default
        if ( empty( $saved_options ) ) {
            $saved_options = array( 'post' );
        }

        ?>
        <div class="cwss-row">
            <?php foreach( $post_types as $post_type ) {

                if( in_array( 
                    $post_type->label,
                    array( 'Attachment', 'elementor_library', 'Media' ) ) 
                ) {
                    continue;
                } 
                ?>
                <div class="cwss-col">
                    <input
                        type="checkbox"
                        name="snapsection_dynamic[where][]"
                        value="<?php echo esc_attr( $post_type->name ); ?>"
                        <?php checked( in_array( $post_type->name, $saved_options ) ); ?>
                        id="snapsection_dynamic_where_<?php echo $post_type->name ?>"
                    />

                    <label 
                        for="snapsection_dynamic_where_<?php echo $post_type->name ?>">
                            <?php echo esc_html_e( $post_type->label, 'snapsection' ) ?>
                    </label>
                </div>
                <?php
            } ?>
        </div>
    <?php }

    /**
     * Creates the Element field, so users can choose the element to have IDs created
     *
     * @since 1.1.0
     * 
     * @param array $arguments 
     * @return void
     */
    public function field_element_callback( $arguments ) { ?>
        <?php 
        $elementsAvailable = array(
            'option1' => '&lt;h1&gt;',
            'option2' => '&lt;h2&gt;',
            'option3' => '&lt;h3&gt;',
            'option4' => '&lt;h4&gt;',
            'option5' => '.cwss-element'
        );
        // Recupera o valor armazenado
        $selectedOption = esc_html( snapSection()->options->getOption( 'element' ) ?? '&lt;h2&gt;' );
        ?>
        <select
            class="element"
            name="snapsection_dynamic[element]"
            id="snapsection_dynamic_element">
        >
            <?php
                foreach ( $elementsAvailable as $elementOption => $element  ) { ?>
                    <option 
                        value="<?php echo esc_attr( $element ); ?>"
                        <?php selected( $selectedOption, $element ); ?>
                    >
                        <?php echo esc_html( $element ); ?>
                    </option>
                <?php }
            ?>
        </select>

        <p class="cwss-field-description">
            <?php echo wp_kses( 
                __( 'Please select the element you\'d like to have a SnapSection icon.<br>Options available are h1, h2, h3, h4, or the class .cwss-element.', 'snapsection' ), 
                array( 'br' => array() ) 
                ); 
            ?>
        </p>

    <?php }


    /**
     * Creates the field for the Icon Color
     *
     * @since 1.0.0
     * 
     * @param array $arguments
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
     * @since 1.0.0
     * 
     * @param array $arguments
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
     * @param array $arguments
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
                    <label for="snapsection_dynamic_icon<?php echo esc_html( $i ) ?>" class="label-image">
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
