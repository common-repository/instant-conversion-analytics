<?php
/*
Instant Conversion Analytics
Updated in Version 1.4.1
*/

//Prevent Direct Access
defined('Instant_Conversion_Analytics') or die();
global $wpdb;

/* ================== Contact Form 7 Integration ================== */
//CF7 Mail Tag Integration
add_filter( 'wpcf7_special_mail_tags', 'ica_wpcf7_mail_tag', 10, 3 );
function ica_wpcf7_mail_tag( $output, $name, $html ) {
	if ( '_ica' !== $name || ! $contact_form = WPCF7_ContactForm::get_current() ) {
		return $output;
	}
	if($html == 1){
		return ica_report('html');
	}else{
		return ica_report();
	}
}

//CF7 Append Content Intgration
function ica_wpcf7_append( $wpcf7 ) {
	$ica_options = get_option('ica');
    if ($wpcf7 && $ica_options['cf7_append'] === '1') {
		$mail = $wpcf7->prop('mail');
		$use_html = $mail['use_html'];
		if($use_html == '1'){$use_html = 'html';}
		$mail['body'] .= ica_report($use_html);
		$wpcf7->set_properties(array('mail' => $mail));
	}
}
add_action( 'wpcf7_before_send_mail', 'ica_wpcf7_append' );

/* ================== Ninja Forms Integration ================== */
//Ninja Forms Append Email Notifications
function ica_nf_append($message, $data, $action_settings) {
	$ica_options = get_option('ica');
	if($ica_options['nf_append'] === '1' && $action_settings['label'] == 'Email Notification'){
		if( 'html' == $action_settings[ 'email_format' ] ) {
			$message .= ica_report('html');
		}
		else{
			$message .= ica_report();
		}
	}
	return $message;
}
add_filter('ninja_forms_action_email_message', 'ica_nf_append', 10, 3);

/* ================== WooCommerce Integration ================== */
//WooCommerce Store the Cookie Value Before Order Processing
function ica_woocommerce_get_cookie($order_id) {
	$ica_options = get_option('ica');
	if($ica_options['woo_append'] === '1' && isset($_COOKIE['ica'])){
		$order = wc_get_order( $order_id );
		$order->update_meta_data( 'ica_cookie_value', sanitize_text_field($_COOKIE['ica']));
		$order->save();
	}
}
add_action( 'woocommerce_checkout_update_order_meta', 'ica_woocommerce_get_cookie', 10, 2 );

//WooCommerce Get the order id and email format
function ica_woocommerce_email_data(  $order, $sent_to_admin, $plain_text, $email ) {
	$ica_options = get_option('ica');
	if($ica_options['woo_append'] === '1'){
		$GLOBALS['ica_wc_email_data'] = array(
			'order_id' => $order->get_order_number(),
			'email_id' => $email->id,
			'sent_to_admin' => $sent_to_admin,
			'plain_text' => $plain_text
		);
	}
}
add_action( 'woocommerce_email_customer_details', 'ica_woocommerce_email_data', 10, 4 );

//WooCommerce Append the email footer for new orders HTML
function ica_woocommerce_append( $get_option ) {
	$ica_options = get_option('ica');
	$ica_globe = $GLOBALS;
	if(isset($ica_globe['ica_wc_email_data'])){
		$ica_email = $ica_globe['ica_wc_email_data'];
	}
	else{
		return;
	}
	if( $ica_email['email_id'] === 'new_order' && $ica_email['sent_to_admin'] === true && $ica_options['woo_append'] === '1' && !is_admin()) {
		if($ica_email['plain_text'] === true){
			echo ica_report('txt', 'woo', $ica_email['order_id']);
		}
		else{
			echo ica_report('html', 'woo', $ica_email['order_id']);
		}
		delete_post_meta($ica_email['order_id'], 'ica_cookie_value');
	}
}
add_action( 'woocommerce_email_footer_text', 'ica_woocommerce_append', 10, 1 );

/* ================== WPForms Integration ================== */
//WPForms Smart Tag Integration
function ica_wpf_register_smarttag( $tags ) {
    $tags['_ica'] = 'Instant Conversion Analytics Plugin';
     return $tags;
}
add_filter( 'wpforms_smart_tags', 'ica_wpf_register_smarttag' );
function ica_wpf_process_smarttag( $content, $tag ) {
	// Only run if it is our desired tag.
	if ( '_ica' === $tag ) {
		$ica_wpf_opt = get_option('wpforms_settings');
		if($ica_wpf_opt['email-template'] === 'none'){
			$ica_return = ica_report();
		}
		else{
			$ica_return = ica_report('html');
		}
		$content = str_replace( '{_ica}', $ica_return, $content );
	}
	return $content;
}
add_filter( 'wpforms_smart_tag_process', 'ica_wpf_process_smarttag', 10, 2 );
//WPForms Append Content Integration
function ica_wpf_append( $message, $emails ) {
	$ica_options = get_option('ica');
    if ($ica_options['wpf_append'] == '1') {
		$ica_wpf_opt = get_option('wpforms_settings');
		if($ica_wpf_opt['email-template'] === 'none'){
			$ica_return = ica_report();
		}
		else{
			$ica_return = ica_report('html');
		}
		$message = $message . $ica_return;
	}
    return $message;
}
add_filter( 'wpforms_email_message', 'ica_wpf_append', 10, 2 );