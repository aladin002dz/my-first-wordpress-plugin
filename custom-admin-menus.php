<?php
/*
Plugin Name: Remove Admin Menus
Description: this my first plugin.
Author: Mahfoudh Arous
Version: 0.7
Author URI: https://aladindev.com
*/

function remove_admin_menus(){
	$options = get_option( 'ramdev' );

	if ( isset( $options['dashboard'] ) ) { 
		remove_menu_page( 'index.php' );
	}
	if ( isset( $options['posts'] ) ) { 
		remove_menu_page( 'edit.php' );
	}
	if ( isset( $options['media'] ) ) { 
		remove_menu_page( 'upload.php' );
	}
	if ( isset( $options['pages'] ) ) { 	
		remove_menu_page( 'edit.php?post_type=page' );
	}
	if ( isset( $options['comments'] ) ) { 
		remove_menu_page( 'edit-comments.php' );
	}
	if ( isset( $options['appearence'] ) ) { 
		remove_menu_page( 'themes.php' );
	}
	if ( isset( $options['plugins'] ) ) { 
		remove_menu_page( 'plugins.php' );
	}
	if ( isset( $options['users'] ) ) { 
		remove_menu_page( 'users.php' );
	}
	if ( isset( $options['tools'] ) ) { 
		remove_menu_page( 'tools.php' );
	}
}

add_action( 'admin_menu', 'remove_admin_menus' );


/* a function to write in the console */
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


/* initiate the plugin settings -------------------------------------------*/
function ramdev_init() {
	register_setting( 'ramdev_settings', 'ramdev', 'ramdev_validate' );
}
add_action( 'admin_init', 'ramdev_init' );


/* the plugin page --------------------------------------------------------*/
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


/* display the options and checkbox list */
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
							case 'dashboard' :
								if ( isset( $options['dashboard'] ) ) { 
									checked( 'on', $options['dashboard'] );
								}
								break;
							case 'posts' :
								if ( isset( $options['posts'] ) ) { 
									checked( 'on', $options['posts'] );
								}
								break;
							case 'media' :
								if ( isset( $options['media'] ) ) { 
									checked( 'on', $options['media'] );
								}
								break;
							case 'pages' :
								if ( isset( $options['pages'] ) ) { 
									checked( 'on', $options['pages'] );
								}
								break;
							case 'comments' :
								if ( isset( $options['comments'] ) ) { 
									checked( 'on', $options['comments'] );
								}
								break;
							case 'appearence' :
								if ( isset( $options['appearence'] ) ) { 
									checked( 'on', $options['appearence'] );
								}
								break;
							case 'plugins' :
								if ( isset( $options['plugins'] ) ) { 
									checked( 'on', $options['plugins'] );
								}
								break;
							case 'users' :
								if ( isset( $options['users'] ) ) { 
									checked( 'on', $options['users'] );
								}
								break;
							case 'tools' :
								if ( isset( $options['tools'] ) ) { 
									checked( 'on', $options['tools'] );
								}
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
		'dashboard' => array(
			'value' => 'dashboard',
			'label' => __( 'Dashboard', 'ram' )
		),
		'posts' => array(
			'value' => 'posts',
			'label' => __( 'Posts', 'ram' )
		),
		'media' => array(
			'value' => 'media',
			'label' => __( 'Media', 'ram' )
		),
		'pages' => array(
			'value' => 'pages',
			'label' => __( 'Pages', 'ram' )
		),
		'comments' => array(
			'value' => 'comments',
			'label' => __( 'Comments', 'ram' )
		),
		'appearence' => array(
			'value' => 'appearence',
			'label' => __( 'Appearence', 'ram' )
		),
		'plugins' => array(
			'value' => 'plugins',
			'label' => __( 'Plugins', 'ram' )
		),
		'users' => array(
			'value' => 'users',
			'label' => __( 'Users', 'ram' )
		),
		'tools' => array(
			'value' => 'tools',
			'label' => __( 'Tools', 'ram' )
		)
	);
	return $services;
}

/* adding the access to the plugin on the admin panel */
function ramdev_menu() {
	add_submenu_page( 'options-general.php', __( 'Remove Admin Menus', 'ram' ), __( 'Remove Admin Menus', 'ram' ), 'administrator', 'ram_dev', 'ram_options_page' );
}
add_action( 'admin_menu', 'ramdev_menu' );
