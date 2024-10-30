<?php
/*
Instant Conversion Analytics
Updated in Version 1.4.1
*/

//Prevent Direct Access
defined('Instant_Conversion_Analytics') or die();

/*  ====================================  The Admin Settings Page  ====================================  */
function ica_settings_page() {
	$ica_options = get_option('ica');
?>
<style type="text/css">
#icaAdmin{background-color:#fff; margin:20px 20px 20px 0; padding:10px 20px; border:3px solid #093; border-radius:5px; position:relative; color:#000; box-shadow:0 0 5px rgba(0,204,51,0.5);}
#icaAdmin .topSection{border-bottom:3px solid #093; margin-bottom:20px; padding-bottom:20px; box-shadow:0 1px 0 rgba(0,204,51,0.5);}
#icaAdmin a{color:#093;}
#icaAdmin h2{font-size:1.5em; color:#093;}
#icaAdmin hr{border-top:3px solid #093; box-shadow:0 0 2px rgba(0,204,51,0.5);}
#icaAdmin .sub{border-top:2px solid #bbb; box-shadow:none;}
#icaAdmin .sub:nth-of-type(1){display:none;}
#icaAdmin .form-table tr{border-bottom:1px solid #efefef;}
#icaAdmin .form-table tr:last-child{border-bottom-color:transparent;}
#icaAdmin .form-table th{padding-top:13px; text-align:right;}
#icaAdmin .button-primary{background-color:#093; border-color:#0c3;}
#icaAdmin .updated,#icaAdmin h1.topTitle,#icaAdmin p.desc{padding-right:300px;}
#icaAdmin .shortcode{display:inline-block; text-align:center; width:auto;}
#icaAdmin .inputs, #icaAdmin textarea.shortcode{width:33%;}
#icaAdmin .warning{border:1px solid #c00; padding:10px 20px; color:#c00; border-radius:3px;}
#icaAdmin .caution{color:#c00;}
#icaAdmin .switch { position: relative; display: inline-block; width: 60px; height: 34px;}
#icaAdmin .switch input { opacity: 0; width: 0; height: 0;}
#icaAdmin .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; -webkit-transition: .4s; transition: .4s; border-radius: 34px;}
#icaAdmin .slider:before { position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; -webkit-transition: .4s; transition: .4s; border-radius: 50%;}
#icaAdmin input:checked + .slider { background-color: #093;}
#icaAdmin input:focus + .slider { box-shadow: 0 0 1px #093;}
#icaAdmin input:checked + .slider:before { -webkit-transform: translateX(26px); -ms-transform: translateX(26px); transform: translateX(26px);}
#icaAdmin .desc{font-style:italic;font-size:0.9em; margin-top:25px; cursor:help;}
#icaAdmin .desc:before{font-weight:bold; font-style:normal; content:'?';display:inline-block;border-radius:100%; background-color:#aaa;color:#fff; text-align:center; margin-right:5px; width:18px; height:18px; font-size:12px;}
#icaAdmin .firstOpt{margin-top:0;}
#icaAdmin .cookieEg{max-width:800px; background-color:#f5f5f5; border-radius:5px; padding:10px; margin-top:8px; box-shadow:0 0 5px #999; color:#666;}
#icaAdmin .cookieEg h3{margin-top:0; color:#666;}
#icaAdmin .cookieTbl{ border:1px solid #ccc; margin-top:20px;}
#icaAdmin .cookieTbl th{border-bottom:1px solid #ccc; text-align:left; color:#666;}
@media screen and (max-width:1199px){
	#icaAdmin .updated,#icaAdmin h1.topTitle,#icaAdmin p.desc{padding-right:0;}
}
@media screen and (max-width:720px){
	#icaAdmin{margin:10px 10px 10px 0;}
	#icaAdmin .updated,#icaAdmin h1.topTitle,#icaAdmin p.desc{padding-right:0;}
	#icaAdmin .inputs{width:100%;}
	#icaAdmin textarea.shortcode{width:100%;}
	#icaAdmin .form-table th{text-align:left; margin-top:10px;}
	#icaAdmin .desc{margin:13px 0;}
}
</style>
<form method="post" action="options.php">
<div class="wrap" id="icaAdmin">
<div class="topSection">
	<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/ica_logo.png" alt="Instant Conversion Analytics" title="Instant Conversion Analytics" width="300" height="112" /><br />
	<h1 class="topTitle"><em>Plugin Settings</em></h1>
	<a href="#ica_integration">How to integrate with other plugins</a> | 
	<a href="#ica_email">Email Output Options</a> | 
	<a href="#ica_tech">Technical Options</a> | 
	<a href="#ica_privacy">Privacy Notes</a>
</div>
	<?php settings_fields('ica_settings'); ?>
<h2 id="ica_integration">How to integrate with other plugins</h2>
<?php
$ica_integrat = false;//Test CF7 Active
if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) {
	$ica_integrat = true; ?>
	<hr class="sub" />
	<h3>Contact Form 7 Integration</h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Use this mail-tag inside of the "Message body" in the desired Contact Form(s)</th>
			<td><input class="shortcode" type="text" onclick="this.focus();this.select();" readonly="readonly" value="[_ica]" />
				<p class="desc">To learn more about how to use mail-tags in Contact Form 7, <a href="https://contactform7.com/tag-syntax/#mail_tag" target="_blank">click here</a>.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Append All Contact Forms' 1st "Message body"?</th>
			<td><input type="hidden" name="ica[cf7_append]" value="0">
			<label class="switch"><input type="checkbox" name="ica[cf7_append]" value="1"<?php
				if(!empty($ica_options['cf7_append']) && $ica_options['cf7_append'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">This will add the Instant Conversion Analytics Data automatically after each contact form's first message body. This does not affect the Mail (2) autoresponder.</p>
			</td>
        </tr>
	</table>
<?php }
//Test Ninja Forms Active
if ( is_plugin_active('ninja-forms/ninja-forms.php') ) {
	$ica_integrat = true; ?>
	<hr class="sub" />
	<h3>Ninja Forms Integration</h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Append All Email Notifications?</th>
			<td><input type="hidden" name="ica[nf_append]" value="0">
			<label class="switch"><input type="checkbox" name="ica[nf_append]" value="1"<?php
				if(!empty($ica_options['nf_append']) && $ica_options['nf_append'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">This will add the Instant Conversion Analytics Data automatically after each Email Notification's message. This does not affect the Email Confirmations (sent to the user).</p>
			</td>
        </tr>
	</table>
<?php }
//Test WooCommerce Active
if ( is_plugin_active('woocommerce/woocommerce.php') ) {
	$ica_integrat = true; ?>
	<hr class="sub" />
	<h3>WooCommerce Integration</h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Append All New Order Emails?</th>
			<td><input type="hidden" name="ica[woo_append]" value="0">
			<label class="switch"><input type="checkbox" name="ica[woo_append]" value="1"<?php
				if(!empty($ica_options['woo_append']) && $ica_options['woo_append'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">This will add the Instant Conversion Analytics Data automatically after each WooCommerce new order email. The new order email traditionally does not go to customers.</p>
			</td>
        </tr>
	</table>
<?php }
//Test WPF Active
if ( is_plugin_active('wpforms-lite/wpforms.php') || is_plugin_active('wpforms/wpforms.php') ) {
	$ica_integrat = true; ?>
	<hr class="sub" />
	<h3>WPForms Integration</h3>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Use this smart-tag inside of the Default Notification "Email Message" in the desired Form(s)</th>
			<td><input class="shortcode" type="text" onclick="this.focus();this.select();" readonly="readonly" value="{_ica}" />
				<p class="desc">To learn more about how to use smart-tags in WPForms, <a href="https://wpforms.com/docs/how-to-use-smart-tags-in-wpforms/" target="_blank">click here</a>.</p>
			</td>
			</tr>
		<tr valign="top">
			<th scope="row">Append All Forms' Default Notification "Email Message"?</th>
			<td><input type="hidden" name="ica[wpf_append]" value="0">
			<label class="switch"><input type="checkbox" name="ica[wpf_append]" value="1"<?php
				if(!empty($ica_options['wpf_append']) && $ica_options['wpf_append'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
				<p class="desc">This will add the Instant Conversion Analytics Data automatically after each form's Email Message.</p>
			</td>
		</tr>
	</table>
<?php }
//If no compatible plugins are active
if ($ica_integrat === false) { ?>
	<div class="warning"><strong>It is recommended that a compatible plugin that sends emails should be installed and activated for this plugin to function to its full ability.</strong></div>
		<p>A list of compatible plugins can be seen <a href="https://wordpress.org/plugins/instant-conversion-analytics/" target="_blank">here</a>.</p>
		<p>Or you can use a direct PHP integration using the function <code>ica_report();</code> for plain text output and <code>ica_report('html');</code> for HTML output.</p>
		<p>&nbsp;</p>
<?php
}
else{ ?>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">&nbsp;</th>
			<td class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
        </tr>
	</table>
<?php } ?>
	<hr />
	<h2 id="ica_email">Email Output Options</h2>
    <table class="form-table" style="width:100%;">
        <tr valign="top">
			<th scope="row">Show Referral Source?</th>
			<td><input type="hidden" name="ica[referral]" value="0">
			<label class="switch"><input type="checkbox" name="ica[referral]" value="1"<?php
				if(!empty($ica_options['referral']) && $ica_options['referral'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">See the linking website, if available.</p>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">Show Lead Source?</th>
			<td><input type="hidden" name="ica[query]" value="0">
			<label class="switch"><input type="checkbox" name="ica[query]" value="1"<?php
				if(!empty($ica_options['query']) && $ica_options['query'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">This is indicated by the landing page's URL query string parameters. The parameters this reads includes "utm_source=" and "ica_src=". Other systems this works with include Facebook, Google Ads, and Microsoft Ads. If there are no compatible paramenters, this will not display.</p>
			</td>
        </tr>
        <tr valign="top">
        <th scope="row">Show the User Journey?</th>
			<td><p class="firstOpt"><label><input type="radio" name="ica[journey]" id="ica_full" value="full"<?php
					if(!empty($ica_options['journey']) && $ica_options['journey'] === 'full'){ echo ' checked="checked"';}
				?>> Show the full user journey (all pages visited).</label></p>
				<p><label><input type="radio" name="ica[journey]" id="ica_minimal" value="minimal"<?php
					if(!empty($ica_options['journey']) && $ica_options['journey'] === 'minimal'){ echo ' checked="checked"';}
				?>> Only show the landing page and the conversion page.</label></p>
				<p><label><input type="radio" name="ica[journey]" id="ica_none" value="none"<?php
					if(!empty($ica_options['journey']) && $ica_options['journey'] === 'none'){ echo ' checked="checked"';}
				?>> Don't show any pages.</label></p>
			<p class="desc">See the URLs the user visited including the landing page, conversion page, etc.</p>
			</td>
        </tr>
        <tr valign="top">
        <th scope="row">User Journey: Show full URL?</th>
			<td><input type="hidden" name="ica[url]" value="0">
			<label class="switch"><input type="checkbox" name="ica[url]" value="1"<?php
				if(!empty($ica_options['url']) && $ica_options['url'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">This option will either show the full URL or only the local URI path.</p>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">Show the User's Time on Site?</th>
			<td><label class="switch"><input type="hidden" name="ica[user_time]" value="0">
			<input type="checkbox" name="ica[user_time]" value="1"<?php
				if(!empty($ica_options['user_time']) && $ica_options['user_time'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">See how much time the user spent on the website before the form submission.</p>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">Show if the Device is a Mobile or Desktop?</th>
			<td><label class="switch"><input type="hidden" name="ica[mobile]" value="0">
			<input type="checkbox" name="ica[mobile]" value="1"<?php
				if(!empty($ica_options['mobile']) && $ica_options['mobile'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">See if the user is using a desktop/laptop computer or a mobile device.</p>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">Show the User's IP Address?</th>
			<td><label class="switch"><input type="hidden" name="ica[ip]" value="0">
			<input type="checkbox" name="ica[ip]" value="1"<?php
				if(!empty($ica_options['ip']) && $ica_options['ip'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">See the user's IP (Internet Protocol) Address. This can be used to look up their approximate geolocation.</p>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">Show the User-Agent Information?</th>
			<td><label class="switch"><input type="hidden" name="ica[browser]" value="0">
			<input type="checkbox" name="ica[browser]" value="1"<?php
				if(!empty($ica_options['browser']) && $ica_options['browser'] === '1'){ echo ' checked="checked"';}
				?>><span class="slider"></span></label>
			<p class="desc">Show the user's Browser and Operating system information.</p>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">&nbsp;</th>
			<td class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
        </tr>
	</table>
	<hr />
	<h2 id="ica_tech">Technical Options</h2>
	<table class="form-table" style="width:100%;">
        <tr valign="top">
        <th scope="row">Frontend Script Integration</th>
        <td><p class="firstOpt"><label><input type="radio" name="ica[integration]" id="ica_standard" value="standard"<?php
					if(!empty($ica_options['integration']) && $ica_options['integration'] === 'standard'){ echo ' checked="checked"';}
				?>> Normal - in the &lt;head&gt;</label></p>
				<p><label><input type="radio" name="ica[integration]" id="ica_async" value="async"<?php
					if(!empty($ica_options['integration']) && $ica_options['integration'] === 'async'){ echo ' checked="checked"';}
				?>> Asynchronous - in the &lt;head&gt;</label></p>
				<p><label><input type="radio" name="ica[integration]" id="ica_manual" value="manual"<?php
					if(!empty($ica_options['integration']) && $ica_options['integration'] === 'manual'){ echo ' checked="checked"';}
				?>> Manual code embed (for advanced users)</label></p>
			<p class="desc">Decide how the JavaScript tracking code should be included on the frontend of the website. This JavaScript code is required for this plugin to function. Choose whichever method works best for your website and/or makes it GDPR and/or CCPA compliant.</p>
			</td>
        </tr>
<?php if($ica_options['integration'] === 'manual'){
	?>
		<tr valign="top">
			<td scope="row"><em>To manually integrate this plugin, please use this code:</em></td>
			<td><textarea rows="3" style="text-align:left;" class="shortcode" type="text" onclick="this.focus();this.select();" readonly="readonly">&lt;script src='<?php echo plugin_dir_url(dirname(__FILE__)) . 'js/ica.min.js'; ?>' id='instant-conversion-analytics-js'&gt;&lt;/script&gt;</textarea>
			</td>
		</tr><?php
} ?>
        <tr valign="top">
			<th scope="row">&nbsp;</th>
			<td class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
        </tr>
    </table>

</form>
<hr />
<h2 id="ica_privacy">Privacy Notes</h2>
<p><strong>GDPR and/or CCPA Compliance:</strong> You must first ask the user for consent before this plugin collects any data for analytics. There are many different plugins that that can help with making your website compliant. This plugin does not promise or guarantee that your website will be compliant.</p>
<h3>Example Cookie Statement</h3>
<p>If needed, you can use the following text to help shape your website's privacy policy or cookie statement. This is not a cookie-cutter cookie statement (no pun intended). If you are to use any part of it, please modify it to fit your policies. We make no promises that this statement will meet your website and/or company's policies, nor do we promise it will make you GDPR or CCPA compliant.</p>
<div class="cookieEg">
<h3><em>Instant Conversion Analytics Cookie</em></h3>
<p><em>This cookie is used purely for internal research on how we can improve the service we provide for all our users.</em></p>

<p><em>This cookie simply assesses how users interact with the website – as an anonymous user (the <strong>data gathered does not identify users personally</strong>).</em></p>

<p><em>This data is not collected or stored until the user completes an action such as submitting a contact form or placing an order.</em></p>

<p><em>This data is <strong>not shared with any third parties</strong> or used for any other purpose.</em></p>

<table class="cookieTbl" cellspacing="0" cellpadding="8">
<thead>
<tr><th>Cookie Name</th><th>Service</th><th>Purpose</th><th>Cookie type and duration</th></tr></thead>
<tbody>
<tr><td>ica</td><td>Web analytics service</td><td>It recognizes website visitor activity (<strong>anonymously</strong> – no personal information is collected on the user).</td><td>It is a first-party session cookie, deleted after you quit your browser.</td></tr></tbody>
</table>
</div>

<p>&nbsp;</p>

<p style="text-align:right;">Plugin by <a href="https://ica.riseofweb.com" target="_blank">Rise of the Web</a><br /><small><em>This plugin is not affiliated with Contact Form 7 or WooCommerce.</em></p></p>
</div>
<?php }

// validate data
function ica_validate($input) {
	return $input;
}