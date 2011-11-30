<?php
	register_elgg_event_handler( 'init', 'system', 'elgg_social_login_init' );

	function elgg_social_login_init()
	{
		elgg_extend_view( 'account/forms/login'   , 'elgg_social_login/login' );
		elgg_extend_view( 'account/forms/register', 'elgg_social_login/login' );
	}
