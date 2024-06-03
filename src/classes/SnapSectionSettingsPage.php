<?php

namespace Cwss\Classes;

class SnapSectionSettingsPage {
    public $plugin;

    public function __construct() {
        $this->plugin = plugin_basename( PLUGIN_BASENAME );

        add_action( 'admin_menu', array( $this, 'create_settings_page' ));
        add_action( 'admin_init', array( $this, 'setup_sections' ));
        add_action( 'admin_init', array( $this, 'setup_fields' ));

        add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
    }

    public function settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=snapsection">' . __( 'Settings', 'snap-section' ) . '</a>';
        array_push( $links, $settings_link );

        return $links;
    }

    public function create_settings_page() {
        // 
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

        // add error/update messages

        // check if the user have submitted the settings
        // WordPress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET[ 'settings-updated' ] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error(
                'snapsection',
                'snapsection_message',
                __( 'Settings Saved', 'snap-section' ),
                'updated'
            );
        }

        // show error/update messages
        settings_errors( 'snapsection' );
        
        ?>
        <div class="wrap">
            <h2><?php echo __( 'SnapSection Settings', 'snap-section' ); ?></h2>
            <p><?php echo __( 'The plugin that makes it easier to share a section of your page, article or blog post.', 'snap-section' ); ?></p>
            <hr>
            <form method="POST" action="options.php">
                <?php
                settings_fields( 'snapsection_fields' );
                do_settings_sections( 'snapsection' );
                submit_button( 'Save Settings' );
                ?>
            </form>
        </div>
        <?php
    }

    public function setup_sections() {
        // add_settings_section(
        //     string $id,
        //     string $title,
        //     callable $callback,
        //     string $page,
        //     array $args = array()
        // )
        add_settings_section(
            'snapsection_section',
            __( 'Customize SnapSection','snap-section' ),
            false,
            'snapsection'
        );
    }

    public function setup_fields() {
        // add_settings_field(
        //     string $id,
        //     string $title,
        //     callable $callback,
        //     string $page,
        //     string $section = ‘default’,
        //     array $args = array()
        // )
        // https://developer.wordpress.org/reference/functions/add_settings_field/

        register_setting( 'snapsection_fields', 'snapsection_icon_image' );
        register_setting( 'snapsection_fields', 'snapsection_icon_color' );
        register_setting( 'snapsection_fields', 'snapsection_top' );
        register_setting( 'snapsection_fields', 'snapsection_icon' );

        // add_settings_field( 
        //     string $id,
        //     string $title,
        //     callable $callback,
        //     string $page,
        //     string $section = ‘default’,
        //     array $args = array()
        // )
        // https://developer.wordpress.org/reference/functions/add_settings_field/

        add_settings_field( 
            'snapsection_icon_image',
            __( 'Icon', 'snap-section' ),
            array( $this, 'snapsection_icon_image' ),
            'snapsection',
            'snapsection_section',
            $arguments = array( 
                'label_for' => 'snapsection_icon_image'
            )
        );

        add_settings_field( 
            'snapsection_icon_color',
            __( 'Icon Color', 'snap-section' ),
            array( $this, 'field_color_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array( 
                'label_for' => 'snapsection_icon_color'
            )
        );
        
        add_settings_field( 
            'snapsection_icon',
            __( 'Icon', 'snap-section' ),
            array( $this, 'field_icon_choice_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array( 
                'label_for' => 'snapsection_icon'
            )
        );
        
        add_settings_field( 
            'snapsection_top',
            __( 'Top position', 'snap-section' ),
            array( $this, 'field_top_position_callback' ),
            'snapsection',
            'snapsection_section',
            $arguments = array( 
                'label_for' => 'snapsection_top'
            )
        );

        
    }

    public function field_color_callback( $arguments ) {
        // Obtenha o valor da configuração que registramos com register_setting()
        $value = get_option($arguments['label_for']);

        // Saída do campo
        echo '<input class="color-picker" name="' . esc_attr($arguments['label_for']) . '" id="' . esc_attr($arguments['label_for']) . '" type="text" value="' . esc_attr($value) . '" />';
        // echo '<input class="color-code" name="' . esc_attr($arguments['label_for'] . '_code') . '" id="' . esc_attr($arguments['label_for'] . '_code') . '" type="text" value="' . esc_attr($value) . '" />';

        // Adicione o script para inicializar o seletor de cores
        echo '<script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".color-picker").wpColorPicker({
                    change: function(event, ui) {
                        $("#" + event.target.id + "_code").val(ui.color.toString());
                    }
                });
            });
        </script>';
    }

    public function field_icon_choice_callback( $arguments ) {
        echo '<input name="' . $arguments[ 'label_for' ] . '" id="' . $arguments[ 'label_for' ] . '" type="text" value="' . get_option( $arguments[ 'label_for' ] ) . '" />';
        ?>
        <p class="cwss-field-description">
		    <?php esc_html_e( 'Select your icon.', 'snap-section' ); ?>
	    </p>
        <?php
    }

    public function field_top_position_callback( $arguments ) {
        echo '<input name="' . $arguments[ 'label_for' ] . '" id="' . $arguments[ 'label_for' ] . '" type="number" value="' . get_option( $arguments[ 'label_for' ] ) . '" />';
        ?>
        <p class="cwss-field-description">
		    <?php esc_html_e( 'Adjust the top position. Values in pixels.', 'snap-section' ); ?>
	    </p>
        <?php
    }



    public function snapsection_icon_image( $arguments ) {
        // Obtenha o valor da configuração que registramos com register_setting()
        $value = get_option($arguments['label_for']);

        // Opções para o campo de botões de opção
        $options = array(
            'option1' => 'src/img/cwpl-copy-url-link.svg',
            'option2' => 'src/img/cwpl-copy-url-link.svg',
            'option3' => 'src/img/cwpl-copy-url-link.svg',
        );

        // Saída do campo
        foreach ( $options as $key => $label ) {
            echo '<div style="display:flex;align-items: center;margin-bottom:.5rem;" class="cwss-container-options">';
                // echo '<input id="' . esc_attr( $arguments[ 'label_for' ] . '_' . $key ) . '" name="' . esc_attr( $arguments[ 'label_for' ] ) . '" type="radio"' . esc_attr( $key ) . '" ' . checked( $value, $key, false ) . ' />';

                echo '<input id="' . esc_attr($arguments['label_for'] . '_' . $key) . '" name="' . esc_attr($arguments['label_for']) . '" type="radio" value="' . esc_attr($key) . '" ' . checked($value, $key, false) . ' />';
            
                echo '<label style="display:inline-block;padding:1rem;background:white;border:1px solid #CCC;margin-left:10px;border-radius:5px;width:20px;height:20px;" for="' . esc_attr($arguments['label_for'] . '_' . $key) . '">' . '<img width=22 height=22 src="' . PLUGIN_URL . $label . '"></label><br />';
            echo '</div>';
        }
    }

}

// wp_get_attachment_image( $attachment_id:integer, $size:string|array, $icon:boolean, $attr:string|array )
