<?php
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function conikal_pdo_settings_init() {
 // register a new setting for "product-outside" page
 register_setting( 'product-outside', 'conikal_pdo_url_option' );
 register_setting( 'product-outside', 'conikal_pdo_ck_option' );
 register_setting( 'product-outside', 'conikal_pdo_cs_option' );

 
 // register a new section in the "product-outside" page
 add_settings_section(
 'conikal_pdo_section_api',
 __( 'The Matrix has you.', 'product-outside' ),
 'conikal_pdo_section_developers_cb',
 'product-outside'
 );
 
 // register a new field in the "conikal_pdo_section_developers" section, inside the "product-outside" page
 add_settings_field(
	 'conikal_pdo_field_url', // as of WP 4.6 this value is used only internally
	 // use $args' label_for to populate the id inside the callback
	 __( 'Site URL', 'product-outside' ),
	 'conikal_pdo_field_url_cb',
	 'product-outside',
	 'conikal_pdo_section_api',
	 [
	 'label_for' => 'conikal_pdo_field_url',
	 'class' => 'conikal_pdo_row',
	 'conikal_pdo_custom_data' => 'custom',
	 ]
 );

 add_settings_field(
	 'conikal_pdo_field_ck', // as of WP 4.6 this value is used only internally
	 // use $args' label_for to populate the id inside the callback
	 __( 'Consumer key', 'product-outside' ),
	 'conikal_pdo_field_ck_cb',
	 'product-outside',
	 'conikal_pdo_section_api',
	 [
	 'label_for' => 'conikal_pdo_field_ck',
	 'class' => 'conikal_pdo_row',
	 'conikal_pdo_custom_data' => 'custom',
	 ]
 );

 add_settings_field(
	 'conikal_pdo_field_cs', // as of WP 4.6 this value is used only internally
	 // use $args' label_for to populate the id inside the callback
	 __( 'Consumer secret', 'product-outside' ),
	 'conikal_pdo_field_cs_cb',
	 'product-outside',
	 'conikal_pdo_section_api',
	 [
	 'label_for' => 'conikal_pdo_field_cs',
	 'class' => 'conikal_pdo_row',
	 'conikal_pdo_custom_data' => 'custom',
	 ]
 );
}
 
/**
 * register our conikal_pdo_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'conikal_pdo_settings_init' );
 
/**
 * custom option and settings:
 * callback functions
 */
 
// developers section cb
 
// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function conikal_pdo_section_developers_cb( $args ) {
 ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'product-outside' ); ?></p>
 <?php
}
 
// pill field cb
 
// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function conikal_pdo_field_url_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $options = get_option( 'conikal_pdo_url_option' );
 // output the field
 ?>
 <input id="title" type="url" name="conikal_pdo_url_option" size="55" value="<?php echo esc_attr($options); ?>">
 <p class="description">
 <?php esc_html_e( 'Website to connect and display products from here.', 'product-outside' ); ?>
 </p>
 <?php
}

function conikal_pdo_field_ck_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $options = get_option( 'conikal_pdo_ck_option' );
 // output the field
 ?>
    <input id="title" type="text" name="conikal_pdo_ck_option" size="55" value="<?php echo esc_attr($options); ?>">
 <p class="description">
 <?php esc_html_e( 'Generate API credentials (Consumer Key & Consumer Secret) following this', 'product-outside' ); ?>
 <a href="<?php echo esc_url('http://docs.woocommerce.com/document/woocommerce-rest-api/') ?>"><?php esc_html_e('instructions', 'product-outside') ?></a>
 </p>
 <?php
}

function conikal_pdo_field_cs_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $options = get_option( 'conikal_pdo_cs_option' );
 // output the field
 ?>
 	<input id="title" type="text" name="conikal_pdo_cs_option" size="55" value="<?php echo esc_attr($options); ?>">
 <p class="description">
<?php esc_html_e( 'Generate API credentials (Consumer Key & Consumer Secret) following this', 'product-outside' ); ?>
 <a href="<?php echo esc_url('http://docs.woocommerce.com/document/woocommerce-rest-api/') ?>"><?php esc_html_e('instructions', 'product-outside') ?></a>
 </p>
 <?php
}
 
/**
 * top level menu
 */
function conikal_pdo_options_page() {
 // add top level menu page
 add_submenu_page(
 'options-general.php', // top level menu page
 'Product Outside Settings',
 'Product Outside',
 'manage_options',
 'product-outside',
 'conikal_pdo_options_page_html'
 );
}
 
/**
 * register our conikal_pdo_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'conikal_pdo_options_page' );
 
/**
 * top level menu:
 * callback functions
 */
function conikal_pdo_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "product-outside"
 settings_fields( 'product-outside' );
 // output setting sections and their fields
 // (sections are registered for "product-outside", each field is registered to a specific section)
 do_settings_sections( 'product-outside' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
}