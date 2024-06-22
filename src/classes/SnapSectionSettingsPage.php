<?php

namespace Cwss\Classes;



class SnapSectionSettingsPage {
    public $plugin;

    public function __construct() {
        $this->plugin = plugin_basename( CWSS_PLUGIN_BASENAME );

        add_action( 'admin_menu', array( $this, 'create_settings_page' ));
        add_action( 'admin_init', array( $this, 'setup_sections' ));
        add_action( 'admin_init', array( $this, 'setup_fields' ));

    }


    public function settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=snapsection">' . esc_html__( 'Settings', 'snap-section' ) . '</a>';
        array_push( $links, $settings_link );

        return $links;
    }

    public function create_settings_page() {
        // add_menu_page()
        // https://developer.wordpress.org/reference/functions/add_menu_page/
        add_menu_page(
            'SnapSection',
            'SnapSection',
            'manage_options',
            'snapsection',
            array( $this, 'settings_page_content' ),
            'dashicons-editor-textcolor'
        );
    }

    public function settings_page_content() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        add_settings_error(
            'snapsection',
            'snapsection_message',
            esc_html__( 'Settings Saved', 'snap-section' ),
            'updated'
        );
        // }

        // show error/update messages
        settings_errors( 'snapsection' );

        ?>
        <div class="wrap">
            <h2><?php echo esc_html__( 'SnapSection Settings', 'snap-section' ); ?></h2>
            <p class="mw-620"><?php echo esc_html__( 'The plugin that makes it easier to share a section of your page, article or blog post.', 'snap-section' ); ?></p>
            <p class="mw-620"><?php echo esc_html__( 'SnapSection scans every &lt;h3&gt; (third-level heading) element across your website\'s pages and posts, and creates a button that allows your audience to copy a URL that points to this &lt;h3&gt;.', 'snap-section' ); ?></p>
            <hr>
            <form method="POST" action="options.php">
                <?php
                settings_fields( 'snapsection_fields' );
                do_settings_sections( 'snapsection' );
                wp_nonce_field( 'snapsection_update_settings', 'snapsection_settings_nonce' ); // Gera o nonce
                submit_button( 'Save Settings' );
                ?>
            </form>
        </div>
        <?php
    }

    public function setup_sections() {
        add_settings_section(
            'snapsection_section',
            esc_html__( 'Customize SnapSection','snap-section' ),
            false,
            'snapsection'
        );
    }

    public function setup_fields() {

        register_setting( 'snapsection_fields', 'snapsection_dynamic', 'snapsection_sanitize_options' );

        add_settings_field(
            'snapsection_icon_image',
            esc_html__( 'Icon', 'snap-section' ),
            array( $this, 'snapsection_icon_image' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_icon_image'
            )
        );

        add_settings_field(
            'snapsection_icon_color',
            esc_html__( 'Icon Color', 'snap-section' ),
            array( $this, 'field_color_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_icon_color'
            )
        );

        add_settings_field(
            'snapsection_icon_size',
            esc_html__( 'Icon Size', 'snap-section' ),
            array( $this, 'field_icon_size_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array(
                'label_for' => 'snapsection_icon_size'
            )
        );

        function snapsection_save_settings() {
            // Verifica se o formulário foi submetido
            if ( isset( $_POST['snapsection_settings_nonce'] ) && check_admin_referer( 'snapsection_update_settings', 'snapsection_settings_nonce' ) ) {
                // Aqui você salva as configurações, usando update_option() por exemplo
            }
        }

    }

    public function field_color_callback( $arguments ) { ?>
        
        <input
            class="color-picker"
            name="snapsection_dynamic[color]"
            id="snapsection_dynamic_color"
            type="text"
            value="<?php echo esc_html( cwss()->options->getOption( 'color' ) ?? '#0099FF' ) ?>"
        />


        <?php // Adicione o script para inicializar o seletor de cores ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".color-picker").wpColorPicker({
                    change: function(event, ui) {
                        $("#" + event.target.id + "_code").val(ui.color.toString());
                    }
                });
            });
        </script>

    <?php }

    public function field_icon_size_callback( $arguments ) { ?>

        <input
            name="snapsection_dynamic[size]"
            id="snapsection_dynamic_size"
            type="number"
            min="0.5"
            max="1"
            step="0.1"
            value="<?php echo esc_html( cwss()->options->getOption( 'size' ) ?? '1' ) ?>" 
        />
        
        <p class="cwss-field-description">
            <?php esc_html_e( 'Fine adjustment of your icon size. From 0.5 to 1.', 'snap-section' ); ?>
        </p>
    <?php }


    public function snapsection_icon_image( $arguments ) {

        // Opções para o campo de botões de opção
        $iconsAvailable = array(
            'option1' => 'src/img/icon1.svg',
            'option2' => 'src/img/icon4.svg',
            'option3' => 'src/img/icon8.svg',
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
                        <?php checked( esc_html( cwss()->options->getOption( 'icon' ) ?? 'option1' ), esc_html( $iconValue ) ) ?>
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

    // function snapsection_sanitize_options( $input ) {
    //     $new_input = array();
    //     $new_input[ 'image' ] = sanitize_text_field( $input[ 'image' ]);
    //     $new_input[ 'color' ] = sanitize_hex_color( $input[ 'color' ]);
    //     $new_input[ 'top' ] = sanitize_text_field( $input[ 'top' ]);
    //     $new_input[ 'size' ] = absint( $input[ 'size' ]);
    
    //     return $new_input;
    // }

}
