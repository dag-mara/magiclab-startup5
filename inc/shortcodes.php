<?php

# [email] Shortcode
	add_shortcode( 'email', 'startup_email_shortcode' );
	function startup_email_shortcode($atts,$email='') {
		if ( empty($email) || ! is_email( $email ) )
			return $email;
		return '<a class="startup-email-link" rel="external" href="mailto:'.antispambot($email).'">'.antispambot($email).'</a>';
	}

# [phone] Shortcode
	add_shortcode( 'phone', 'startup_phone_shortcode' );
	function startup_phone_shortcode($atts,$phone='') {
		if ( empty($phone) )
			return '';
		if ( wp_is_mobile() )
			return '<a class="startup-phone-link" rel="external" href="tel:'.$phone.'">'.$phone.'</a>';
		else
			return $phone;
	}