<?php
/*
Instant Conversion Analytics
Updated in Version 1.4.1
*/
 
//Prevent Direct Access
defined('Instant_Conversion_Analytics') or die();

/* ==================================== The Plugin Core ==================================== */

//prepare the data to show in contact form submission
function ica_report($format = 'txt', $integration = 0, $int_data = 0){
	try{
		$ica_options = get_option('ica');
		
		//Get the data
		$ica_cookie = false;
		if(isset($_COOKIE['ica'])){
			$ica_cookie = sanitize_text_field($_COOKIE['ica']);
		}
		else if($integration === 'woo' && $int_data !== 0){
			$ica_val = get_post_meta($int_data, 'ica_cookie_value', true);
			if (!empty($ica_val)){
				$ica_cookie = $ica_val;
			}
		}
		
		//Get values from server
		if($ica_options['browser'] === '1'){
			$ica_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']); //Browser/OS Data
		}
		if($ica_options['ip'] === '1'){
			$ica_ip = $_SERVER['REMOTE_ADDR']; //User IP Address
		}
		$ica_time = current_time('F d, Y \a\t g:i:s a T'); //Current Time
		
		//Error message
		$ica_error = "There was problem accessing this user's browsing data. Only limited data can be shown.";
		
		$ica_return;
		if($ica_cookie !== false){
			//Get values from cookie
			$ica_cookie = explode("|~|",$ica_cookie);
			$ica_journey = explode("|", $ica_cookie[1]); //User Journey URLs
			list($ica_time_final, $ica_time_start, $ica_referrer, $ica_mobile) = explode("|", $ica_cookie[0]);
			$ica_referrer = $ica_referrer ? str_replace(' ', '%20', $ica_referrer) : 'Unknown/Direct'; //Referrer

			//Calculating the time on site
			if($ica_options['user_time'] === '1'){
				if(isset($ica_time_final)){
					$ica_time_total = intval($ica_time_final) - intval($ica_time_start);
					$ica_time_total_display = gmdate('H:i:s', $ica_time_total); //Total Time on Site
				}else{
					$ica_time_total_display = false;
				}
			}
			$ica_leadsrc = false;
			if($ica_options['query'] === '1' && strpos($ica_journey[0],"?")){ //Checking Query String for Lead Sources
				$ica_query = parse_url(esc_url_raw($ica_journey[0]));
				parse_str($ica_query['query'], $query);
				if(isset($query['ica_src']) && $query['ica_src'] != null){
					$ica_leadsrc = $query['ica_src'];
					$ica_leadsrcType = 'ICA Source';
				}
				else if(isset($query['utm_source']) && $query['utm_source'] != null){
					$ica_leadsrc = $query['utm_source'];
					$ica_leadsrcType = 'UTM Source';
				}
				else if(isset($query['fbclid']) && $query['fbclid'] != null){
					$ica_leadsrc = 'Facebook';
					$ica_leadsrcType = 'Social Media';
				}
				else if(isset($query['gclid']) && $query['gclid'] != null){
					$ica_leadsrc = 'Google Ads';
					$ica_leadsrcType = 'Online Advertising';
				}
				else if(isset($query['msclkid']) && $query['msclkid'] != null){
					$ica_leadsrc = 'Microsoft Ads';
					$ica_leadsrcType = 'Online Advertising';
				}
			}
			if($ica_options['mobile'] === '1'){
				switch ($ica_mobile){
					case 'm':
						$ica_mobile = 'Mobile';
						break;
					case 't':
						$ica_mobile = 'Tablet/Laptop';
						break;
					default:
						$ica_mobile = 'Desktop';
				}
			}
			//If user journey if full path or local URI
			$ica_domain = '';
			if($ica_options['journey'] !== 'none'){
				$ica_journey = str_replace(' ', '%20', $ica_journey);
				if($ica_options['url'] === '1'){
					$ica_urlparts = parse_url(home_url());
					$ica_domain = $ica_urlparts['scheme'] . '://' . $ica_urlparts['host'];
				}
			}
		}
	/* =================== HTML Output ================== */
		if($format === 'html'){
			$ica_cell_css = 'padding:3px; border-top:1px solid #ccc; border-radius:0; font-size:14px; line-height:20px';
			$ica_row1 = '<tr><td style="' . $ica_cell_css . '; text-align:right; padding-right:10px;" valign="top"><b>';
			$ica_row1_no_border = '<tr><td style="' . $ica_cell_css . '; text-align:right; padding-right:10px; border:none;" valign="top"><b>';
			$ica_row2 = '</b></td><td style="' . $ica_cell_css . '; word-break:break-all;" valign="top">';
			$ica_row2_no_border = '</b></td><td style="' . $ica_cell_css . '; word-break:break-all; border:none;" valign="top">';
			$ica_row3 = '</td></tr>';
			$ica_return = '<div style="max-width:750px; position:relative; clear:both; display:block; text-align:left; font-size:14px; line-height:20px; padding:10px; margin:20px 0; background-color:#fff; color:#000; font-family:Arial,sans-serif; border:3px solid #aaa; border-radius:8px;">';
			if($ica_cookie === false){ //can't read cookie
				$ica_return .= '<h3 style="color:#333; text-align:center; margin-top:0;"><b>Instant Conversion Analytics (Limited Data)</b></h3>';
				$ica_return .= "<p><i>" . $ica_error . "</i></p>";
			}
			else{
				$ica_return .= '<h2 style="color:#093; text-align:center; margin-top:0; letter-spacing:1px"><b>Instant Conversion Analytics</b></h2>';
			}
			$ica_return .= '<table width="100%" border="0" cellspacing="0" cellpadding="3"><tbody>';
			$ica_return .= $ica_row1_no_border . 'Conversion Time' . $ica_row2_no_border . $ica_time . $ica_row3;
			if($ica_cookie !== false){
				//Show Lead Source
				if($ica_leadsrc !== false && $ica_options['query'] === '1'){
					$ica_return .= $ica_row1 . 'Lead Source' . $ica_row2 . $ica_leadsrc . '<br /><small><i>(' . $ica_leadsrcType . ')</i></small>' . $ica_row3;
				}
				//Show Referrer
				if($ica_options['referral'] === '1'){$ica_return .= $ica_row1 . 'Referrer' . $ica_row2 . $ica_referrer . $ica_row3;}
				//Loop through user journey
				if($ica_options['journey'] !== 'none'){
					$ica_return .= '<br />';
					$ica_return .= $ica_row1_no_border . '<span style="color:#093"><i>User Journey</i></span>' . $ica_row2_no_border . '&nbsp;' . $ica_row3;
					$i = 0;
					$len = count($ica_journey);
					foreach ($ica_journey as $url) {
						$i++;
						if(isset($url)){
							if ($i === 1 && $i !== $len) {
								$ica_return .= $ica_row1 . 'Page 1<br /><small><i>(Landing)</i></small>';
							} else if ($i === $len) {
								$ica_return .= $ica_row1 . 'Page ' . $i . '<br /><small><i>(Conversion)</i></small>';
							} else if ($ica_options['journey'] === 'full'){
								$ica_return .= $ica_row1 . 'Page ' . $i;
							}
							if(($i === 1 && $i !== $len) || ($i === $len) || ($ica_options['journey'] === 'full')){
								$ica_return .= $ica_row2 . $ica_domain . $url . $ica_row3;
							}
						}
					}
					$ica_return .= '<br />';
				}			
				//Show the time on site
				if($ica_options['user_time'] === '1' && $ica_time_total_display !== false){
					$ica_return .= $ica_row1 . 'Time On Site' . $ica_row2 . $ica_time_total_display . $ica_row3;
				}
				if($ica_options['mobile'] === '1'){$ica_return .= $ica_row1 . 'Device Type' . $ica_row2 . $ica_mobile . $ica_row3;}
			}
			if($ica_options['ip'] === '1'){$ica_return .= $ica_row1 . 'IP Address' . $ica_row2 . $ica_ip . $ica_row3;}
			if($ica_options['browser'] === '1'){$ica_return .= $ica_row1 . 'Web Browser/OS Info' . $ica_row2 . $ica_agent . $ica_row3;}
			$ica_return .= '</tbody></table></div><br />';
		}
	/* =================== Plain Text Output ================== */
		else{//Output in Plain Text Format
			$ica_lb = "\r\n";
			$ica_header = $ica_lb . '=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=' . $ica_lb;
			$ica_return = $ica_lb . $ica_header; 
			if($ica_cookie === false){ //can't read cookie
				$ica_return .= 'Instant Conversion Analytics (Limited Data)' . $ica_header . $ica_lb;
				$ica_return .= "*" . $ica_error . $ica_lb;
			} else{
				$ica_return .= 'Instant Conversion Analytics' .  $ica_header . $ica_lb;
			}
			$ica_return .= 'Conversion Time: ' . $ica_time . $ica_lb;
			if($ica_cookie !== false){
				//Show Lead Source
				if($ica_leadsrc !== false && $ica_options['query'] === '1'){
					$ica_return .= 'Lead Source: ' . $ica_leadsrc . ' (' . $ica_leadsrcType . ')' . $ica_lb;
				}
				//Show Referrer
				if($ica_options['referral'] === '1'){$ica_return .= 'Referrer: ' . $ica_referrer . $ica_lb;}
				//Loop through user journey
				if($ica_options['journey'] !== 'none'){
					$ica_return .= $ica_lb . '--- User Journey ---' . $ica_lb;
					$i = 0;
					$len = count($ica_journey);
					foreach ($ica_journey as $url) {
						$i++;
						if(isset($url)){
							if ($i === 1 && $i !== $len) {
								$ica_return .= 'Page 1 (Landing): ';
							} else if ($i === $len) {
								$ica_return .= 'Page ' . $i . ' (Conversion): ';
							} else if ($ica_options['journey'] === 'full'){
								$ica_return .= 'Page ' . $i . ': ';
							}
							if(($i === 1 && $i !== $len) || ($i === $len) || ($ica_options['journey'] === 'full')){
								$ica_return .=  $ica_domain . $url . $ica_lb;
							}
						}
					}
					$ica_return .=  $ica_lb;
				}
				//Show the time on site
				if($ica_options['user_time'] === '1' && $ica_time_total_display !== false){
					$ica_return .= 'Time On Site: ' . $ica_time_total_display . $ica_lb;
				}
				if($ica_options['mobile'] === '1'){$ica_return .= 'Device Type: ' . $ica_mobile . $ica_lb;}
			}
			if($ica_options['ip'] === '1'){$ica_return .= 'IP Address: ' . $ica_ip . $ica_lb;}
			if($ica_options['browser'] === '1'){$ica_return .= 'Web Browser/OS Info: ' . $ica_agent . $ica_lb;}
			$ica_return .=  $ica_lb . '-----------------------------------------' . $ica_lb . $ica_lb;
		}
		return $ica_return;
	} catch (Exception $e) {
		error_log("Instant Conversion Analytics - Caught $e");
	}
}