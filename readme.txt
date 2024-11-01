=== WP Paypal Shortcodes ===
Contributors: webtux
Donate link: http://www.webtux.info/wordpress-plugins/
Tags: paypal, shortcode
Requires at least: 2.6
Tested up to: 3.1
Stable tag: 0.3

This plugin insert Paypal button (pages, posts).

== Description ==

Add a paypal button (using shortcode) into your pages/posts
Edit the wp-content/plugins/wp-paypal-shortcodes/wp-paypal-shortcodes.php for configure the plugin.

= Shortcode =
Add the following shortcodes to integrate PayPal into your pages / posts of wordpress.

`[paypalBtn production="true" amount="55" item_name="ProduitB"]`
Insert the button in your pages or posts with this shortcode

`[paypalBtn production="true" amount="55" item_name="ProduitB" business="seller@yourSite.com"]`
with the merchant email

`[paypalBtn production="true" amount="55" item_name="t-shirt" optiontype0="select" on0="color" os0="red;green;blue;orange;yellow"]`
with option select

* See the [Changelog](http://wordpress.org/extend/plugins/wp-paypal-shortcodes/changelog/) for what's new.

== Installation ==

1. Download the plugin Zip archive.
1. Upload 'paypal-shortcodes' folder to your '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Edit wp-paypal-shortcodes.php and define your settings.

== Frequently Asked Questions ==

= how use the plugin =

With the shortcode "paypalBtn" into your pages/posts.
Ex: [paypalBtn amount="30" item_name="product name" amount="50"]
You can create multiple shortcode.

== Screenshots ==

1. Active the extension wordpress admin.
1. Page integration shortcode [more informations](http://wwww.webtux.info) French web agency.
1. With option select (ex: Color: reg, green, blue, orange, ...)

== Changelog ==

= 0.3 =
* add option with select (Color: red, blue, green, orange. Size: S, M, L, XL)

= 0.2 =
* add condition if you not use field
* add language management with .mo (use .po into lang file)

= 0.1 =
* Original version released to wordpress.org repository

== Upgrade Notice ==

= 1.0 =
nothing

== Arbitrary section ==

Buy a product with a shortcode
* @param production			: choose if you are test phase, or production
* @param amount				: price for your product/service
* @param currency_code		: devise
* @param shipping			: shipping price
* @param tax				: tax price
* @param return				: url for the return (after buy)
* @param cancel_return		: url for the cancel (during the payment phase)
* @param notify_url			: url for the return (after payment validation IPN)
* @param on0				: nom option 1
* @param os0				: value option 1
* @param on1				: nom option 2
* @param os1				: value option 2
* @param on2				: nom option 3
* @param os2				: value option 3
* @param on3				: nom option 4
* @param os3				: value option 4
* @param on4				: nom option 5
* @param os4				: value option 5
* @param business			: email address of your paypal account 
* @param item_name			: name of your product/service
* @param no_note			: autorized to file a note or not
* @param lc					: location
* @param bn					: button type
* @param custom				: custom field

= Usage =
[paypalBtn production="false" amount="55" currency_code="EUR" shipping="0.00" tax="0.00" on0="optionD" os0="ddd" on1="optionE" os1="eee" on2="optionF" os2="fff" business="xxx@xxx.fr" item_name="ProduitB" no_note="0" lc="FR" bn="PP-BuyNowBF" custom="abc"]