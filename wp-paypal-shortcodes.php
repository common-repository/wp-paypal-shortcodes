<?php
/*
Plugin Name: WP Paypal Shortcodes
Plugin URI: http://www.webtux.info/wordpress-plugins/
Description: Add paypal button with shortcodes.
Version: 0.3
Author: Michael DUMONTET
Author URI: http://www.webtux.info/wordpress-plugins/wp-paypal-shortcodes

Copyright 2011  Michael DUMONTET  (email : contact@webtux.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// SOURCE : 
// - help for create wordpress plugin http://codex.wordpress.org/Writing_a_Plugin
// - paypal manual : https://www.paypalobjects.com/WEBSCR-640-20110204-1/fr_FR/FR/pdf/PP_WebsitePaymentsStandard_IntegrationGuide.pdf

// Gestion lang (dossier lang dans le plugin, contenant les .mo)
load_plugin_textdomain("wp-paypal-shortcodes", false, dirname( plugin_basename( __FILE__ ) ) . '/lang');


/**
 * Shortcode example
 */
// [paypalBtn amount="30" item_name="product name"]


/**
 * Config plugin
 */
// your seller email
define("PAYPAL_EMAIL_SELLER",			"seller@yourSite.com");
// listing paypal logo : 
// - en : http://www.rocketgranny.com/codeclips/pp_button_images.php
// - fr : https://ppmts.custhelp.com/app/answers/detail/a_id/635
// ex: https://www.paypal.com/fr_FR/FR/i/btn/btn_buynow_LG.gif
define("PAYPAL_IMG_BUY",				"https://www.paypal.com/fr_FR/FR/i/btn/btn_buynow_LG.gif"); 
// return page (after buy)
define("PAYPAL_PAGE_RETURN",			get_bloginfo('template_url')."/paypal_return.php");	
// return if cancel
define("PAYPAL_PAGE_CANCEL",			get_bloginfo('template_url')."/paypal_cancel.php");
// return IPN : manage the information back here (ex : with bdd)
define("PAYPAL_PAGE_NOTIFY_URL",		get_bloginfo('template_url')."/paypal_notify_url.php");


/**
 * Shortcodes : add button paypal
 */ 
function getPaypalBtn( $atts='' ){
	
	// shortcode field
	extract( shortcode_atts(array(
		"production"	=> "false",						// true : production, false : test phase (=sandbox) 
	
		"cmd"			=> "_xclick",					// _xclick : A Buy Now or Donations button. _cart : cart (panier)
		
		"amount"		=> "10",						// price product
		"item_name"		=> "product A",					// name product
		"currency_code"	=> "EUR",						// currency
		"shipping"		=> "0.00",						// price shipping
		"tax"			=> "0.00",						// price tax
		"return"		=> PAYPAL_PAGE_RETURN,			// page return after payment
		"cancel_return"	=> PAYPAL_PAGE_CANCEL,			// page cancel
		"notify_url"	=> PAYPAL_PAGE_NOTIFY_URL,		// URL return transaction information after paymentURL (with IPN)
		"on0"			=> "",							// option 0 : key (char max : 64)
		"os0"			=> "",							// option 0 : value (char max : 64)
		"optiontype0"	=> "",							// select
		"on1"			=> "",							// option 1 : key (char max : 64)
		"os1"			=> "",							// option 1 : value (char max : 64)
		"optiontype1"	=> "",							// select
		"on2"			=> "",							// option 2 : key (char max : 64)
		"os2"			=> "",							// option 2 : value (char max : 64)
		"optiontype2"	=> "",							// select
		"business"		=> PAYPAL_EMAIL_SELLER,			// seller email
		"no_note"		=> "0",							// 0 : le client est invité à ajouter une remarque. 1 : le client n’est pas invité à ajouter une remarque.
		"no_shipping"	=> "0",							// Invite le client à saisir l’adresse de livraison. Par défaut ou sur 0 : le client est invité à saisir une adresse de livraison. 1 : le client n’est pas invité à entrer une adresse de livraison. 2 : le client doit fournir une adresse de livraison.
		"lc"			=> "FR",						// location (FR)
		"bn"			=> "PP-BuyNowBF",				// button
		"custom"		=> ""							// custom field
	), $atts ));
	
	/*
	// for security
	$id = (int)$id;
	if( $id == 0 ){
		return '';
	}//fin if
	*/
	
	// State : production or Test
	if( $production == "false" ){	$urlPaypal = "https://www.sandbox.paypal.com/cgi-bin/webscr"; }
	else{							$urlPaypal = "https://www.paypal.com/cgi-bin/webscr"; }

	// START - paypal button
	?>
	<form action="<?php echo $urlPaypal; ?>" method="post">
		<input name="amount" type='hidden' value="<?php echo $amount; ?>" />
		<input name="currency_code" type="hidden" value="<?php echo $currency_code; ?>" />
		<input name="shipping" type="hidden" value="<?php echo $shipping; ?>" />
		<input name="tax" type="hidden" value="<?php echo $tax; ?>" />
				
		<?php // adresse de retour, après le paiement ?>
		<input name="return" type="hidden" value="<?php echo $return; ?>" />
		<?php // adresse d'annulation du paiement ?>
		<input name="cancel_return" type="hidden" value="<?php echo $cancel_return; ?>" />
		<?php // adresse de notification d'achat réalisé (IPN) ?>
		<input name="notify_url" type="hidden" value="<?php echo $notify_url; ?>" />
				
		<?php // OPTION 0 : ?>
		<?php if( !empty($on0) && !empty($os0) ):?>
			<input name="on0" type="hidden" value="<?php echo $on0;?>" />
			<?php if( $optiontype0 == "select" && stripos($os0, ";") !== false ):?>
				<select name="os0">
					<?php 
					$tbl_os = explode(";", $os0);
					foreach( $tbl_os as $k){ ?>
						<option value="<?php echo $k; ?>"><?php echo $k; ?></option>
					<?php } ?>
				</select><br />
			<?php else:?>
				<input name="os0" type="hidden" value="<?php echo $os0; ?>" />
			<?php endif; ?>
		<?php endif; ?>
		
		<?php // OPTION 1 : ?>
		<?php if( !empty($on1) && !empty($os1) ):?>
			<input name="on1" type="hidden" value="<?php echo $on1;?>" />
			<?php if( $optiontype1 == "select" && stripos($os1, ";") !== false ):?>
				<select name="os1">
					<?php 
					$tbl_os = explode(";", $os1);
					foreach( $tbl_os as $k){ ?>
						<option value="<?php echo $k; ?>"><?php echo $k; ?></option>
					<?php } ?>
				</select><br />
			<?php else:?>
				<input name="os1" type="hidden" value="<?php echo $os1; ?>" />
			<?php endif; ?>
		<?php endif; ?>
		
		<?php // OPTION 2 : ?>
		<?php if( !empty($on2) && !empty($os2) ):?>
			<input name="on2" type="hidden" value="<?php echo $on2;?>" />
			<?php if( $optiontype2 == "select" && stripos($os2, ";") !== false ):?>
				<select name="os2">
					<?php 
					$tbl_os = explode(";", $os2);
					foreach( $tbl_os as $k){ ?>
						<option value="<?php echo $k; ?>"><?php echo $k; ?></option>
					<?php } ?>
				</select><br />
			<?php else:?>
				<input name="os2" type="hidden" value="<?php echo $os2; ?>" />
			<?php endif; ?>
		<?php endif; ?>

		<input name="cmd" type="hidden" value="<?php echo $cmd; ?>" />
		<input name="business" type="hidden" value="<?php echo $business; ?>" />
		<input name="item_name" type="hidden" value="<?php echo $item_name; ?>" />
		<input name="no_note" type="hidden" value="<?php echo no_note; ?>" />
		<input name="lc" type="hidden" value="<?php echo $lc; ?>" />
		<input name="bn" type="hidden" value="<?php echo $bn; ?>" />
		<?php if( !empty($custom) ):?>
			<input name="custom" type="hidden" value="<?php echo $custom; ?>" />
		<?php endif; ?>
		<!-- Effectuez vos paiements via PayPal : une solution rapide, gratuite et sécurisée -->
		<input alt="<?php _e("Make payments with PayPal: it's fast, free and secure!", "wp-paypal-shortcodes"); ?>" name="submit" src="<?php echo PAYPAL_IMG_BUY; ?>" type="image" /><img src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
	</form>
	<?php // END - paypal button ?>

<?php 				
}//end function
add_shortcode('paypalBtn', 'getPaypalBtn');