=== Instant Conversion Analytics - User Analytics Directly Inside Emails Sent From Your Website ===
Contributors: riseofweb
Donate link: https://riseofweb.com
Tags: Contact Form 7, WooCommerce, Ninja Forms, WPForms, User Tracking, User Journey, Referral Source, Lead Source, Email Marketing, Contact Form, Analytics, Marketing, Form Submission, Conversion
Requires at least: 5.4
Tested up to: 6.1.1
Requires PHP: 5.6
Stable tag: 1.4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
This plugin adds user's analytics in emails sent from Contact Form 7, Ninja Forms, WPForms, and WooCommerce.

Stop guessing where your leads and conversions are coming from and start knowing instantly in your email notifications. No longer do you have to stumble through your analytics software (e.g. Google Analytics) to try and guess where a conversion came from. This plugin will save you time, let you focus on your customers, and help guide your marketing towards generating new conversions.

This plugin is designed to be complementary to your existing analytics software (e.g. Google Analytics).

= Plugin Features =

**Optional Analytic Data Shown:**

- Referral Source
- Lead Source (e.g. Google Ads, Microsoft Ads, Facebook, utm_source, etc)
- User Journey (showing all pages the user has visited on your website)
- User's Time on Site
- User's Device (mobile, desktop, laptop/tablet)
- User's IP Address
- User-Agent Information (browser and operating system information)

**Further Options and Hints**

- Multiple options on JavaScript implementation
- Hints and tips about GDPR and CCPA compliance

= Plugin Compatibility =

This plugin works as an add-on currently with the following plugins:

- [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) (Version 4.5 and above) - Integration through either a mail-tag or the option to append all 1st "Message body" emails.
- [Ninja Forms](https://wordpress.org/plugins/ninja-forms/) - Integration through the option to append all notification emails.
- [WooCommerce](https://wordpress.org/plugins/woocommerce/) (Version 3.4.2 and above) - Integration through the option to append new order emails.
- [WPForms](https://wordpress.org/plugins/wpforms-lite/) - Integration through either a smart-tag or the option to append all "Message body" emails.
- Looking for integration with a different plugin? Please [contact me](https://www.riseofweb.com/#contact).

= Future Planning =

In the future, I am planning to make this plugin compatible with other popular contact form plugins.

== Installation and Configuration ==

1. Upload folder to '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. After installation you can configure its options under the 'Settings' menu by clicking on 'Instant Conversion Analytics'

== Frequently Asked Questions ==

= Does this plugin use a cookie? =
The plugin uses a first-party local cookie that is automatically deleted at the end of the user's session.

= Does this plugin share data with 3rd parties? =
No. This plugin does not communicate with any other websites or servers.

= Is this GDPR and/or CCPA compliant? =
It can be. It depends on your privacy statement. After installed you can refer to the plugin's Settings > Privacy Notes for more information.

= Can this be integrated with plugins not listed above? =
Yes, through PHP. Call the function `ica_report();` for plain text output, or `ica_report('html');` for HTML output. Other plugin integrations are planned for the future.

= Is this compatible with caching plugins? =
Yes, it is fully compatible will all caching plugins.

= Is this a stand-alone analytics solution? =
This plugin is a stand-alone solution, but it is recommended to have other analytics software installed as well such as Google Analytics or an equivalent.

= Does this plugin slow down the website? =
This plugin is very minimalistic. The total frontend load is a single JavaScript file that is less than 1 KB. The JavaScript file does not depend on any libraries and is designed to run asynchronously.

We did a Google PageSpeed Insights test on a website where this plugin was installed and got a mobile score of 99 (desktop score of 100). All of the suggested improvements were unrelated to this plugin.

= If this plugin has an error for any reason will I still receive my emails? =
Yes, you will still get your email. When this plugin adds to the content of the email it uses the Exception PHP method. If for any unforeseen reason there is an error in the code, it will be bypassed.

== Screenshots ==

1. Admin screen with plugin options shown
2. Example Contact Form 7 Submission Email
3. Example WooCommerce New Order Email

== Changelog ==

= 1.4.2 =
- Confirmed Compatibility with WordPress version 6.1.1

= 1.4.1 =
- Improvement: Added prefixes to everything to avoid any possible issues with other plugins
- Improvement: Changed some of the outputted HTML and plain text for better formatting and readability
- Improvement: For WooCommerce plain text output this plugins output was moved to the bottom if the email
- Fix: When using an WooCommerce payment gateway that leaves the website the cookie would sometimes not be read.

= 1.4.0 =
- Added: Ninja Forms Compatibility
- Added: Option for full URL or URI page path
- Improvement: Removed the domain name from the user journey URLs in the cookie to reduce the number of characters to reduce the cookie size
- Improvement: Lowered the maximum cookie size to further avoid possible browser Bad Request response
- Fix: Disabled this plugin's output for WooCommerce "Resend new order notification" when sent from within the WordPress admin interface
- Note: If you are using a caching solution, after updating it is recommended that you clear the cache for the ica.min.js file

= 1.3.1 =
- Fixed a bug (introduced in 1.3.0) that caused HTML formated Contact Form 7 emails to show plain text analytics report

= 1.3.0 =
- Optimization of PHP scripts for speed
- Improved security by sanitizing the User-Agent Information
- Added links to support and reviews on the plugins page

= 1.2.2 =
- Fixed the plugin's HTML output formatting to account for the URL properly line wrap
- Improved GDPR/CCPA cookie statement example

= 1.2.1 =
- Tweaked the JavaScript enqueue to ensure it runs as early as possible
- Fixed typo in plain text referral source output (missing space)

= 1.2.0 =
- Added WPForms Integration
- Improved the plugin's HTML output formating and insured that it is not covering other email content
- Improved the plugin's plain text output formating
- Fixed Manual JavaScript Option Typo
- Changed WooCommerce implementation logic to include non-HTML new orders as well

= 1.1.0 =
- Added an uninstall hook to remove plugin options
- Added the Exception method to bypass any unforeseen PHP errors.
- Improved plugin activation hook options
- Improved JavaScript cookie security
- Improved output if the cookie can not be read
- Fixed Undefined index PHP Notices on the admin screen
- Fixed bug with displaying the timezone
- Fixed spaces showing in URLs
- Changed the .js file name to include .min for standard naming convention

= 1.0.0 =
- Initial release