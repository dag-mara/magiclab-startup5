<?php

# Disable WordPress version reporting as a basic protection against attacks
	add_filter('the_generator', 'startup_remove_version' );
	function startup_remove_version(){ return ''; }