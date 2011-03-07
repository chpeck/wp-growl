<?php
/*
 * Plugin Name: BuzzGrowl for Websites
 * Plugin URI: http://buzzgrowl.com/
 * Description: Show social media post about your website on your website.
 * Version: 1.0
 * Author: Thingbuzz
 * Author URI: http://buzzgrowl.com
 * 
 * Copyright 2011 Thingbuzz (email : apps@thingbuzz.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 */

function buzzgrowl_menu() {
	add_submenu_page('plugins.php', 'BuzzGrowl Configuration', 'BuzzGrowl Configuration', 'manage_options', 'buzzgrowl-key-config', 'buzzgrowl_options');
}

function buzzgrowl_init() {
	wp_deregister_script('buzzgrowl');
	wp_register_script('buzzgrowl', 'http://buzzgrowl.com/embed/buzz.js');
}

function buzzgrowl_footer() {
	wp_print_scripts('buzzgrowl');
	$token = get_option('buzzgrowl_token');
	if (empty($token)) {
		echo '<script>new TBZZ.Growl();</script>';
	} else {
		echo '<script>new TBZZ.Growl({token:\''.$token.'\'});</script>';
	}	
}

function buzzgrowl_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	if(isset($_POST['submit'])) {
		update_option('buzzgrowl_token', $_POST['token']);
		
	}
?>
<div class="wrap">
<h2>BuzzGrowl Configuration</h2>
<form method="post" action="">
	<label>Token</label>	
	<input type="text" name="token" value="<?php echo get_option('buzzgrowl_token'); ?>"
	<br/>
    	<p class="submit">
    	<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    	</p>
</form>
</div>
<?php
}

add_action('admin_menu', 'buzzgrowl_menu');
add_action('init', 'buzzgrowl_init');
add_action('wp_footer', 'buzzgrowl_footer');

?>
