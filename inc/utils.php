<?php

	/* CUSTOM EXCERPT */
	function mau_get_the_excerpt( $post_ID = 0, $excerpt_length = 55 , $excerpt_more = '[...]', $allowed_tags = '<a>' ) {

		//global $post;
		$post_obj = get_post($post_ID);
		if ( !$post_obj )
			return false;

	    $text = empty( $post_obj->post_excerpt ) ? $post_obj->post_content : $post_obj->post_excerpt;

	    $text = strip_shortcodes( $text );
	    $text = apply_filters('the_content', $text);
	    $text = str_replace(']]>', ']]&gt;', $text);
	    $text = strip_tags($text,$allowed_tags);

	    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	    if ( count($words) > $excerpt_length ) {
	        array_pop($words);
	        $text = implode(' ', $words);
	        $text = $text . $excerpt_more;
	    } else {
	        $text = implode(' ', $words);
	    }

	    $text = force_balance_tags($text);

	    $text = wpautop($text);

		return $text;

	}

?>