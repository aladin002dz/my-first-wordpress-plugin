<?php
/*
Plugin Name: Remove Admin Menus
Description: this my first plugin.
Author: Mahfoudh Arous
Version: 0.1
Author URI: https://aladindev.com
*/

/*
function remove_admin_menus(){
	 //remove_menu_page( 'index.php' );                  //Dashboard
	 //remove_menu_page( 'jetpack' );                    //Jetpack* 
	 remove_menu_page( 'edit.php' );                   //Posts
	 //remove_menu_page( 'upload.php' );                 //Media
	 remove_menu_page( 'edit.php?post_type=page' );    //Pages
	 //remove_menu_page( 'edit-comments.php' );          //Comments
	 remove_menu_page( 'themes.php' );                 //Appearance
	 //remove_menu_page( 'plugins.php' );                //Plugins
	 remove_menu_page( 'users.php' );                  //Users
	 //remove_menu_page( 'tools.php' );                  //Tools
	 //remove_menu_page( 'options-general.php' );        //Settings
   }

add_action( 'admin_menu', 'remove_admin_menus' );
*/

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function ramdev_init() {
	register_setting( 'ramdev_settings', 'ramdev', 'ramdev_validate' );
}
add_action( 'admin_init', 'ramdev_init' );

function ram_options_page() {
	?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e( 'Remove Admin Menus', 'ram' ); ?></h2>
			<p><?php _e( 'This plugin helps you remove admin menus.', 'ram' ); ?></p>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'ramdev_settings' );
				?>
				<table class="form-table">
					<tbody>
						<?php ramdev_do_options(); ?>
					</tbody>
				</table>
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'ps-demo' ); ?>" />
				<input type="hidden" name="ps-plugindev-submit" value="Y" />
			</form>
		</div>
	<?php
}


function ramdev_do_options() {
	$options = get_option( 'ramdev' );
	console_log("reading options");
	console_log($options);

	ob_start();
	?>
		<tr valign="top"><th scope="row"><?php _e( 'What menus do you want to remove?', 'ram' ); ?></th>
			<td>
				<?php
					foreach ( ramdev_services() as $service ) {
						$label = $service['label'];
						$value = $service['value'];
						echo '<label><input type="checkbox" name="ramdev[' . $value . '] value="1" ';
						switch ($value) {
							case 'appearence' :
								if ( isset( $options['appearence'] ) ) { checked( 'on', $options['appearence'] ); }
								break;
						}
						echo '/> ' . esc_attr($label) . '</label><br />';
					}
				?>
			</td>
	<?php
}

function ramdev_services() {
	$services = array(
		'appearence' => array(
			'value' => 'appearence',
			'label' => __( 'Appearence', 'ram' )
		)
	);
	return $services;
}

function ramdev_menu() {
	add_submenu_page( 'options-general.php', __( 'Remove Admin Menus', 'ram' ), __( 'Remove Admin Menus', 'ram' ), 'administrator', 'ram_dev', 'ram_options_page' );
}
add_action( 'admin_menu', 'ramdev_menu' );
