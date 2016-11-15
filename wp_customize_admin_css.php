<?php
/**
 * Plugin Name: WP Customize Admin CSS
 * Description: Customize your Admin CSS with an admin file
 * Version: 0.0.2
 * Author: Adrian Toro

**/

/**
 * Enqueue Admin scripts and styles
 */
if ( ! function_exists( 'default_custom_theme_setup' ) ) :
	function default_theme_admin_name_scripts() {

		global $wp_styles;
		wp_enqueue_style( 'default_admin_style', plugin_dir_url( __FILE__ ).'/css/admin.css' , false );
		wp_enqueue_style( 'child_admin_style_if_any', plugin_dir_url( __FILE__ ).'/css/admin.css' , false );
		$wp_styles->add_data( 'default_theme_options', 'rtl', true );
	}
	add_action( 'admin_print_styles', 'default_theme_admin_name_scripts'  );
endif; 


if ( ! function_exists( 'default_custom_theme_setup' ) ) :
	function default_custom_theme_setup() {
	   
		add_editor_style( plugin_dir_url( __FILE__ ).'css/editor-style.css' ); 
		
	}
	add_action( 'after_setup_theme', 'default_custom_theme_setup' );
endif; // default_custom_theme_setup

/* Bottom admin bar in frontend: */
function stick_admin_bar_to_bottom_css() {
        echo "
        <style type='text/css'>
        html {
                padding-bottom: 28px !important;
				margin-top: 0px !important;
        }
       
        body {
                margin-top: -28px;
        }
       
        #wpadminbar {
                top: auto !important;
                bottom: 0;
        }

        #wpadminbar .quicklinks .menupop ul {
                bottom: 148px;
				background:black;
        }
        </style>
        ";
}

//add_action('admin_head', 'stick_admin_bar_to_bottom_css');
add_action('wp_footer', 'stick_admin_bar_to_bottom_css');