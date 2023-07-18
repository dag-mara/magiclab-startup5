<?php

	/**
	 * Get theme version
	 *
	 * @return string $version
	 */
	function startup_get_theme_version() {
		return '1.3.0';
	}

	/* Reword columns to class */
	function startup_reword_columns( $cols=1,$large=true ){
		$cols = absint( $cols ) ? ceil( 12/$cols ) : 12;
		$word = $large ? 'medium':'small';
		return "$word-$cols";
	}