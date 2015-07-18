<?php
/**
 * Plugin Name: WP Custom Buttons 
 * Plugin URI: 
 * Description: Allows you to create your own call to action buttons for your pages.
 * Version: 1.0.1
 * Author: Tricks Of IT
 * Author URI: http://www.tricksofit.com/
 */


 class toiWpCustomButtons {
	var $domain = 'wp-custom-buttons';
	
	function __construct() {
	
		if ( is_admin() ){
			add_action( 'admin_menu', array($this, 'wpcb_add_settings_menu'));
			add_filter( 'plugin_action_links', array($this, 'wpcb_add_settings_link'), 20, 2 );
		}
	}
	
	function wpcb_add_settings_menu(){
		add_options_page( __( 'WP Custom Buttons', $this->domain ), __( 'WP Custom Buttons', $this->domain ), 'manage_options', 'wp-custom-buttons', array($this,  'wpcb_settings_page') );
	}
	
	function wpcb_add_settings_link($links, $file){
		if ( plugin_basename( __FILE__ ) == $file ) {
			$settings_link = '<a href="' . add_query_arg( array( 'page' => 'wp-custom-buttons' ), admin_url( 'options-general.php' ) ) . '">' . __( 'Settings', $this->domain ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}
	
	function wpcb_settings_page(){
		if (!current_user_can('manage_options'))  {
			wp_die('You do not have sufficient permissions to access this page.');
		}
		
		if (!empty($_POST) && isset($_POST['wpcb_settings']) && check_admin_referer('wpcb_update_settings','wpcb_nonce_field'))
		{
			$wpcb_settings = $_POST['wpcb_settings'];
		}
		
		?>
		<div class="wrap">
		<?php if ( function_exists('screen_icon') ) screen_icon(); ?>
		<h2><?php _e( 'WP Custom Buttons Settings', $this->domain ); ?></h2>
		
		<form method="post" action="">
			<?php if (function_exists('wp_nonce_field') === true) wp_nonce_field('wpcb_update_settings','wpcb_nonce_field'); ?>
			
			<table class="form-table"><tbody>
				<tr valign="top">
					<th scope="row"><?php _e( 'Button Text', $this->domain ); ?></th>
					<td>
						<fieldset>
							<label for="wpcb-button_txt"><input name="wpcb_settings[button_txt]" type="text" id="wpcb-button_txt" value="<?php echo isset($wpcb_settings['button_txt'])?$wpcb_settings['button_txt']:'' ?>"  /> <span style="color:#aaa;"><?php _e( 'Button text will appear on button', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Target URL', $this->domain ); ?></th>
					<td>
						<fieldset>
							<label for="wpcb-target_url"><input name="wpcb_settings[target_url]" type="text" id="wpcb-target_url" value="<?php echo isset($wpcb_settings['target_url'])?$wpcb_settings['target_url']:'' ?>"  /> <span style="color:#aaa;"><?php _e( 'Target URL with http://', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Open New Window', $this->domain ); ?></th>
					<td>
						<fieldset>
							<label for="wpcb-open_new_window"><input name="wpcb_settings[open_new_window]" type="checkbox" id="wpcb-open_new_window" value="1" <?php echo isset($wpcb_settings['open_new_window'])?'checked':'' ?> /> <span style="color:#aaa;"><?php _e( 'To open the URL in new window', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Align Button', $this->domain ); ?></th>
					<td>
						<fieldset>
							<label for="wpcb-align_button">
							<select id="wpcb-align_button" name="wpcb_settings[align_button]">
								<option <?php echo (isset($wpcb_settings['align_button']) && $wpcb_settings['align_button'] == 'center')?'selected="selected"':'' ?> value="center">Center</option>
								<option <?php echo (isset($wpcb_settings['align_button']) && $wpcb_settings['align_button'] == 'left')?'selected="selected"':'' ?> value="left">Left</option>
								<option <?php echo (isset($wpcb_settings['align_button']) && $wpcb_settings['align_button'] == 'right')?'selected="selected"':'' ?> value="right">Right</option>
							</select> <span style="color:#aaa;"><?php _e( 'Align your button', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Button Class', $this->domain ); ?></th>
					<td>
						<fieldset>
							<label for="wpcb-button_class"><input name="wpcb_settings[button_class]" type="text" id="wpcb-button_class" value="<?php echo isset($wpcb_settings['button_class'])?$wpcb_settings['button_class']:'' ?>"  /> <span style="color:#aaa;"><?php _e( 'Enter the Button class name from your theme', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Background Color', $this->domain ); ?></th>
					<td>
						<fieldset>
							<label for="wpcb-background_color"><input name="wpcb_settings[background_color]" type="text" id="wpcb-background_color" value="<?php echo isset($wpcb_settings['background_color'])?$wpcb_settings['background_color']:'' ?>"  /> <span style="color:#aaa;"><?php _e( 'Enter the name of the color or color code with #', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Font', $this->domain ); ?></th>
					<td>
						<fieldset> <label for="wpcb-font"><input name="wpcb_settings[font]" type="text" id="wpcb-font" value="<?php echo isset($wpcb_settings['font'])?$wpcb_settings['font']:'' ?>" /> <span style="color:#aaa;"><?php _e( 'Enter font family name', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Font Color', $this->domain ); ?></th>
					<td>
						<fieldset> <label for="wpcb-color"><input name="wpcb_settings[color]" type="text" id="wpcb-color" value="<?php echo isset($wpcb_settings['color'])?$wpcb_settings['color']:'' ?>" /> <span style="color:#aaa;"><?php _e( 'Enter the name of the color or color code with #', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php _e( 'Font Size', $this->domain ); ?></th>
					<td>
						<fieldset> <label for="wpcb-font_size"><input name="wpcb_settings[font_size]" type="text" id="wpcb-font_size" value="<?php echo isset($wpcb_settings['font_size'])?$wpcb_settings['font_size']:'' ?>" />px <span style="color:#aaa;"><?php _e( 'Enter font size for button text', $this->domain ); ?></span></label>
						</fieldset>
					</td>
				</tr>
				
				
				</tbody>
			</table>
			<p class="submit">
			  <input type="hidden" name="action" value="wpcb_update_settings"/>
			  <input type="submit" name="wpcb_update_settings" class="button-primary" value="<?php _e('Generate Button', $this->domain); ?>"/>
			</p>
				
		</form>
		
		
		<?php
			if(isset($wpcb_settings['button_txt']) && $wpcb_settings['button_txt'] != ''){
			
				echo "<div style=''>";
				echo "<p>Copy the below shortcode and place into your WordPress site.";
				echo "</p>";
				echo "<textarea cols='60' rows='3' onclick='this.select();this.focus();'>";
				echo '[wpcbuttons button_txt="'.$wpcb_settings['button_txt'].'" target_url="'.$wpcb_settings['target_url'].'" open_new_window="'.$wpcb_settings['open_new_window'].'" align_button="'.$wpcb_settings['align_button'].'" button_class="'.$wpcb_settings['button_class'].'" background_color="'.$wpcb_settings['background_color'].'" font="'.$wpcb_settings['font'].'" color="'.$wpcb_settings['color'].'" font_size="'.$wpcb_settings['font_size'].'"  ]';
				echo "</textarea>";
				
				echo "</div>";
				
			}
		?>
		
	</div>
	
	
<?php
	}
	
	public static function wpcbuttons_display( $atts ) {
		
		$button_txt = $atts['button_txt'];
		$target_url = ($atts['target_url'])?$atts['target_url']:'#';
		$open_new_window = ($atts['open_new_window'])?'target="_blank"':'';
		$align_button = ($atts['align_button'])?'text-align:'.$atts['align_button'].';':'';
		$button_class = $atts['button_class'];
		$background_color = ($atts['background_color'])?'background:'.$atts['background_color'].';':'';
		$font = ($atts['font'])?'font-family:'.$atts['font'].';':'';
		$color = ($atts['color'])?'color:'.$atts['color'].';':'';
		$font_size = ($atts['font_size'])?'font-size:'.$atts['font_size'].'px;':'';
		
		
		$content = '<div style="clear: both;">';
		$content .= '<div style="'.$font_size.'padding:8px 0;'.$font.$align_button.'">';
		$content .= '<a href="'.$target_url.'" '.$open_new_window.' style="'.$font.$font_size.$background_color.' padding: 8px 15px;'.$color.'text-decoration: none; cursor: pointer;" class="'.$button_class.'">'.$button_txt.'</a>';
		$content .= '</div>';
		$content .= '</div>';
		
		return $content;
	}
	
}

new toiWpCustomButtons();

add_shortcode( 'wpcbuttons', array( 'toiWpCustomButtons', 'wpcbuttons_display' ) );
 
?>