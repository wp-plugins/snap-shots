<?php
/**********************************************************************
*					Admin Page							*
*********************************************************************/
function ssi_default_options() {
	$ssi_settings = 	Array (
						url => str_replace("http://", "", get_bloginfo('url')),	// Blog URL
						key => '',				// Snap Shots Key
						footer => true			// Add to blog theme footer?
						);
	
	return $ssi_settings;
}

function ssi_options() {
	
	$ssi_settings = ssi_read_options();

	if($_POST['ssi_save']){
		$ssi_settings[key] = $_POST['key'];
		if ($_POST['Footer']) {
			$ssi_settings[footer] = true;
		} else {
			$ssi_settings[footer] = false;
		}
				
		update_option('ald_ssi_settings', $ssi_settings);
		
		$str = '<div id="message" class="updated fade"><p>'. __('Options saved successfully.','ald_ssi_plugin') .'</p></div>';
		echo $str;
	}
	
	if ($_POST['ssi_default']){
	
		delete_option('ald_ssi_settings');
		$ssi_settings = ssi_default_options();
		update_option('ald_ssi_settings', $ssi_settings);
		
		$str = '<div id="message" class="updated fade"><p>'. __('Options set to Default.','ald_ssi_plugin') .'</p></div>';
		echo $str;
	}
?>


<div class="wrap">
  <h2>
    Snap Shots&trade; Integrator
  </h2>
  <div style="border: #ccc 1px solid; padding: 10px">
    <fieldset class="options">
    <legend>
    <h3>
      <?php _e('Support the Development','ald_ssi_plugin'); ?>
    </h3>
    </legend>
    <p><?php _e('If you find my','ald_ssi_plugin'); ?> <a href="http://ajaydsouza.com/wordpress/plugins/snap-shots/">Snap Shots&trade; Integrator</a> <?php _e('useful, please do','ald_ssi_plugin'); ?> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&amp;business=donate@ajaydsouza.com&amp;item_name=Snap%20Shots%20Integrator%20(From%20WP-Admin)&amp;no_shipping=1&amp;return=http://ajaydsouza.com/wordpress/plugins/snap-shots/&amp;cancel_return=http://ajaydsouza.com/wordpress/plugins/snap-shots/&amp;cn=Note%20to%20Author&amp;tax=0&amp;currency_code=USD&amp;bn=PP-DonationsBF&amp;charset=UTF-8" title="Donate via PayPal"><?php _e('drop in your contribution','ald_ssi_plugin'); ?></a>. (<a href="http://ajaydsouza.com/donate/"><?php _e('Some reasons why you should.','ald_ssi_plugin'); ?></a>)</p>
    </fieldset>
  </div>
  <form method="post" id="ssi_options" name="ssi_options" style="border: #ccc 1px solid; padding: 10px">
    <fieldset class="options">
    <legend>
    <h3>
      <?php _e('Options:','ald_ssi_plugin'); ?>
    </h3>
    </legend>
	<p>
		<label for="key"><strong><?php _e('Snap Shots Key:','ald_ssi_plugin'); ?></strong></label>
		<input type="text" name="key" id="key" value="<?php echo $ssi_settings[key]; ?>" size="40" maxlength="32" />
		<a href="http://ajaydsouza.com/snap-shots/#key"><?php _e('How to find your key','ald_ssi_plugin'); ?></a>
	</p>
	<p>
		<label><input type="checkbox" name="Footer" id="Footer" value="true" <?php if ($ssi_settings[footer]) { ?> checked="checked" <?php } ?> />
		<?php _e('Automatically add the code to your footer? (You\'re theme needs to have <code>wp_footer()</code> for this to work.)','ald_ssi_plugin'); ?></label>
	</p>
	<p><?php _e('If you deselect this option, you will need to manually add <code>do_action("echo_ssi");</code> before the <code>&lt;/body&gt;</code> tag.','ald_ssi_plugin'); ?></p>
	<p>
	    <input type="submit" name="ssi_save" id="ssi_save" value="Save Options" style="border:#00CC00 1px solid" />
        <input name="ssi_default" type="submit" id="ssi_default" value="Default Options" style="border:#FF0000 1px solid" onclick="if (!confirm('<?php _e('Do you want to set options to Default? If you don\'t have a copy of the Key, please hit Cancel and copy it first.','ald_ssi_plugin'); ?>')) return false;" />
	</p>
    </fieldset>
  </form>
</div>
<?php

}


function ssi_adminmenu() {
	if (function_exists('current_user_can')) {
		// In WordPress 2.x
		if (current_user_can('manage_options')) {
			$ssi_is_admin = true;
		}
	} else {
		// In WordPress 1.x
		global $user_ID;
		if (user_can_edit_user($user_ID, 0)) {
			$ssi_is_admin = true;
		}
	}

	if ((function_exists('add_options_page'))&&($ssi_is_admin)) {
		add_options_page(__("Snap Shots"), __("Snap Shots"), 9, 'ssi_options', 'ssi_options');
		}
}


add_action('admin_menu', 'ssi_adminmenu');

?>