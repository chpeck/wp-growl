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
  wp_register_script('buzzgrowl', 'http://buzzgrowl.com/embed/buzz.js');
  wp_enqueue_script('buzzgrowl');
}

function buzzgrowl_footer() {
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
?>
    <div id="message" class="updated fade"><p><strong><?php _e('Token saved.') ?></strong></p></div>
<?php
	}
?>
<div class="wrap">
<h2>BuzzGrowl Configuration</h2>
<div class="narrow">
<p>BuzzGrowl <?= get_option('buzzgrowl_token') ? 'Premium' : 'Free' ?> is installed and working!</p> 
<p>For more control and options, please visit <a href="http://buzzgrowl.com">BuzzGrowl</a> for your premium token.</p>
<form method="post" action="">
<h3><label for="token">BuzzGrowl Premium Token</label></h3>
<p style="padding: .5em; background-color: #aa0; color: #fff; font-weight: bold; width: 388px">Please enter your token. (<a href="http://buzzgrowl.com/" style="color:#fff">Get your token.</a>)</p>	
<input style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" type="text" id="token" name="token" value="<?php echo get_option('buzzgrowl_token'); ?>"> (<a href="http://buzzgrowl.com/">What is this?</a>)
<br/>
<p class="submit">
<input type="submit" name="submit" value="<?php _e('Update') ?>" />
</p>
</form>
</div>
</div>
<?php
}

add_action('admin_menu', 'buzzgrowl_menu');
add_action('init', 'buzzgrowl_init');
add_action('wp_footer', 'buzzgrowl_footer');

?>
