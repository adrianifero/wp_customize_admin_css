<?php
/**
 * Plugin Name: WP Customize Admin CSS
 * Description: Customize your Admin CSS with an admin file
 * Version: 0.0.4
 * Author: Adrian Toro

**/

/**
 * Enqueue Admin scripts and styles
 */
if ( ! function_exists( 'wpcustomizeadmin_scripts' ) ) :
	function wpcustomizeadmin_scripts() {

		global $wp_styles;
		wp_enqueue_style( 'default_admin_style', plugin_dir_url( __FILE__ ) . 'css/admin.css' , false );
		$wp_styles->add_data( 'default_theme_options', 'rtl', true );
	}
	add_action( 'admin_print_styles', 'wpcustomizeadmin_scripts'  );
endif; 

	function load_custom_wp_admin_style() {
        wp_register_script( 'custom_wp_admin_js', plugin_dir_url( __FILE__ ) . 'js/admin.js', array('jquery'), '1.0.0' );
        wp_enqueue_script( 'custom_wp_admin_js' );
	}
	add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


if ( ! function_exists( 'wpcustomizeadmin_setup' ) ) :
	function wpcustomizeadmin_setup() {
	   
		add_editor_style( plugin_dir_url( __FILE__ ).'css/editor-style.css' ); 
		
	}
	add_action( 'after_setup_theme', 'wpcustomizeadmin_setup' );
endif; // default_custom_theme_setup

/* Bottom admin bar in frontend: */
function wpcustomizeadmin_stick_admin_bar_to_bottom_css() {
	
	if ( is_user_logged_in() ):
        echo "
        <style type='text/css'>
        html {
                padding-bottom: 28px !important;
				margin-top: 0px !important;
        }
       
        body {
                margin-top: 0;
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
	endif; 
}

//add_action('admin_head', 'stick_admin_bar_to_bottom_css');
add_action('wp_footer', 'wpcustomizeadmin_stick_admin_bar_to_bottom_css');


add_action('admin_head', 'wpcustomizeadmin_setcustomlogo');
function wpcustomizeadmin_setcustomlogo() {
	$customicon = get_option('wpcustomizeadmin_adminicon');
	
	$customcss = get_option('wpcustomizeadmin_admincss');
	
	if ( !empty($customicon) ){
        echo "
        <style>
        #wpadminbar #wp-admin-bar-site-name > .ab-item {
			background-image: url('".$customicon."');
		}
		".$customcss."
        </style>
        ";
	}
}


/* Create menu user options under 'Settings'
------------------------------------------ */

function wpcustomizeadmin_menu() {
	add_options_page( 'Customize CSS Admin Options', 'Customize CSS Admin', 'manage_options', 'wpcustomizeadmin', 'wpcustomizeadmin_options' );

	//call register settings function
	add_action( 'admin_init', 'wpcustomizeadmin_register_settings' );
}
add_action( 'admin_menu', 'wpcustomizeadmin_menu' );

function wpcustomizeadmin_register_settings() {
	register_setting( 'wpcustomizeadmin_group_settings', 'wpcustomizeadmin_admincss'); 
	register_setting( 'wpcustomizeadmin_group_settings', 'wpcustomizeadmin_adminicon'); 
}

function wpcustomizeadmin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}	
	
	/* Save Content data */
	if (!empty($_POST)){
		if (isset($_POST["wpcustomizeadmin_input_css"])) { 
			update_option('wpcustomizeadmin_admincss', $_POST["wpcustomizeadmin_input_css"]);
		}
		if (isset($_POST["wpcustomizeadmin_input_icon"])) { 
			update_option('wpcustomizeadmin_adminicon', $_POST["wpcustomizeadmin_input_icon"]);
		}
	} 

	/* Display Options Page */ 
	?>   

	<div class="wrap">
        <div id="wpcustomizeadmin-header">
            <div id="wpcustomizeadmin-background">
                <h2><img src="<?php echo plugins_url( basename( dirname( __FILE__ ) ) . '/images/logo.png' ); ?>" width="40" height="auto"><?php _e('Customize Admin CSS','wpcustomizeadmin');?></h2>
            </div>
        </div>
        
        <div id="wpcustomizeadmin-content">
        
            <p><?php _e('From this screen you can enter your custom CSS lines and custom logo to change the way the admin looks. These modifications will only affect the admin part of wordpress so registered users with accesso to Dashboard will have a better user experience.','wpcustomizeadmin');?></p>
            
            <form method="post" action="">
                <?php settings_fields( 'wpcustomizeadmin_group_settings' ); ?>    
                   
                <div class="row wpcustomizeadmin">             
                	<h2><?php _e('Customize Admin','wpcustomizeadmin');?></h2>   
                    <table class="form-table">
                        <tr valign="top">
                        	<th scope="row"><?php _e('Icon File','wpcustomizeadmin');?>:</th>
                        	<td>
                        		<input class="customicon" type="text" name="wpcustomizeadmin_input_icon" value="<?php echo get_option('wpcustomizeadmin_adminicon'); ?>"/></td>
                        </tr>
                        <tr valign="top">
                        	<th scope="row"><?php _e('Custom CSS lines','wpcustomizeadmin');?>:</th>
							<td>
                      			<textarea class="customcss" name="wpcustomizeadmin_input_css"><?php echo get_option('wpcustomizeadmin_admincss');?></textarea>
                       		</td>
                        </tr>
                        
                    </table>
                
            	</div>
            	
            	
	                	<?php submit_button(); ?>
   
            </form>            
             
      	</div>
      	
      	<style>
      	div.row.wpcustomizeadmin {
      		padding: 6px 12px;
			margin:44px;
			border: 5px solid white;
      	}
      	div.row.wpcustomizeadmin div.option.box,
      	div.row.wpcustomizeadmin div.option.box p.submit {
      		text-align:right;
      	}
      	</style>
	</div>
    
	<?php
}