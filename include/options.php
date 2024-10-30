<?php
add_action( 'admin_init', 'browser_options_init' );
add_action( 'admin_menu', 'browser_options_add_page' );
function browser_options_init(){
	register_setting( 'browser_options', 'browser_plugin_options', 'browser_options_validate' );
}
function browser_options_add_page() {
	add_theme_page( __( 'Browser Warning', 'sampletheme' ), __( 'Browser Warning', 'sampletheme' ), 'edit_theme_options', 'browser_warning', 'browser_options_do_page' );
}
function browser_options_do_page() {
	global $select_options, $radio_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	?>
<div class="wrap">
  <?php screen_icon(); echo "<h2>Browser Warning Options</h2>"; ?>
  <p>You can use this page to override the defaults for displaying the browser warning to your website users.</p>
  <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
  <div class="updated fade">
    <p><strong>
      <?php _e( 'Options saved', 'sampletheme' ); ?>
      </strong></p>
  </div>
  <?php endif; ?>
  <form method="post" action="options.php">
    <?php settings_fields( 'browser_options' ); ?>
    <?php $options = get_option( 'browser_plugin_options' ); ?>
    <h3>Minimum Compatability:</h3>
    <table class="form-table">
      <tr valign="top">
        <th scope="row"><?php _e( 'Chrome', 'sampletheme' ); ?></th>
        <td><input onKeyPress="return isNumber(event)" id="chrome" class="regular-text" type="text" name="browser_plugin_options[chrome]" value="<?php esc_attr_e( $options['chrome'] ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e( 'Firefox', 'sampletheme' ); ?></th>
        <td><input onKeyPress="return isNumber(event)" id="firefox" class="regular-text" type="text" name="browser_plugin_options[firefox]" value="<?php esc_attr_e( $options['firefox'] ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e( 'Safrari', 'sampletheme' ); ?></th>
        <td><input onKeyPress="return isNumber(event)" id="safari" class="regular-text" type="text" name="browser_plugin_options[safari]" value="<?php esc_attr_e( $options['safari'] ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e( 'Opera', 'sampletheme' ); ?></th>
        <td><input onKeyPress="return isNumber(event)" id="opera" class="regular-text" type="text" name="browser_plugin_options[opera]" value="<?php esc_attr_e( $options['opera'] ); ?>" /></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e( 'Internet Explorer', 'sampletheme' ); ?></th>
        <td><input onKeyPress="return isNumber(event)" id="ie" class="regular-text" type="text" name="browser_plugin_options[ie]" value="<?php esc_attr_e( $options['ie'] ); ?>" /></td>
      </tr>
				
    </table>
    <h3>Other options</h3>
    <table class="form-table">
          <tr valign="top"><th scope="row"><?php _e( 'Display "more info" link?', 'sampletheme' ); ?></th>

    	<td>
						<input id="info" name="browser_plugin_options[info]" type="checkbox" value="1" <?php checked( '1', $options['info'] ); ?> />
					</td>
				</tr>
    </table>
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'sampletheme' ); ?>" />
    </p>
  </form>
</div>
<script>
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
<?php
}
function browser_options_validate( $input ) {
	$input['chrome'] = wp_filter_nohtml_kses( $input['chrome'] );
	$input['firefox'] = wp_filter_nohtml_kses( $input['firefox'] );
	$input['safari'] = wp_filter_nohtml_kses( $input['safari'] );
	$input['opera'] = wp_filter_nohtml_kses( $input['opera'] );
	$input['ie'] = wp_filter_nohtml_kses( $input['ie'] );
	if ( ! isset( $input['info'] ) )
		$input['info'] = null;
		$input['info'] = ( $input['info'] == 1 ? 1 : 0 );
	return $input;
}