<?php
	global $CONFIG;

	require "{$CONFIG->pluginspath}elgg_social_login/settings.php";
	
	$plugin_base_url     = "{$CONFIG->url}/mod/elgg_social_login/";
	$hybridauth_base_url = "{$CONFIG->url}/mod/elgg_social_login/vendors/hybridauth/";
	$assets_base_url     = "{$vars['url']}mod/elgg_social_login/graphics/";

	echo '<div id="elgg_social_login_site_settings">';
?>
	<h2 style="border-bottom: 1px solid #CCCCCC;margin:10px;">1. User Guide</h2>
	<p>
		&nbsp;&nbsp;&nbsp;
		We recommend to read the plugin <b><a href="<?php echo $plugin_base_url ?>help/index.html#settings" target="_blank" >user guide</a></b> first. 
	</p>

	<br />
	<h2 style="border-bottom: 1px solid #CCCCCC;margin:10px;">2. Plugin Diagnostics</h2>
	<p>
		&nbsp;&nbsp;&nbsp;
		We also highly recommend to run the <b><a href="<?php echo $plugin_base_url ?>diagnostics.php?url=http://www.example.com" target="_blank" >Plugin Diagnostics</a></b>. 
	</p>

	<br />
	<h2 style="border-bottom: 1px solid #CCCCCC;margin:10px;">3. help and support</h2>
	<p>
		&nbsp;&nbsp;&nbsp; 
		If you run into any issue, the best way to reach me is at <b>hybridauth@gmail.com</b>
		
		<br />
		<br />
		&nbsp;&nbsp;&nbsp;
		Note: This is free software. Polite and descriptive questions will be given priority.
	</p>

	<br />
	<h2 style="border-bottom: 1px solid #CCCCCC;margin:10px;">4. General Settings</h2>
	<p>
		&nbsp;&nbsp;&nbsp; 
		This plugin is still in alpha stage. 
		<br />
		&nbsp;&nbsp;&nbsp; 
		We recommend to set <b>test mode</b> to <b style="color:green">YES</b> until you are sure you want to go live.

		<?php
			$test_mode = 1; 
			if( $vars['entity']->ha_settings_test_mode === 0 ){
				$test_mode = 0;
			}
		?>
		<div style="padding: 5px;margin: 5px;background: none repeat scroll 0 0 #F5F5F5;border-radius:3px;">
			<b>Plugin Test Mode Active?</b>
			<select style="height:22px;margin: 3px;" name="params[ha_settings_test_mode]">
				<option value="1" <?php if( $test_mode == 1 ) echo "selected"; ?> >YES</option>
				<option value="0" <?php if( $test_mode == 0 ) echo "selected"; ?> >NO</option>
			</select> 
		</div>
	</p>

	<br />
	<h2 style="border-bottom: 1px solid #CCCCCC;margin:10px;">5. Providers setup</h2>
	<ul style="list-style:circle inside;margin-left:10px;">
		<li>To correctly setup these Identity Providers please carefully follow the help section of each one.</li>
		<li>If <b>Provider Satus</b> is set to <b style="color:red">NO</b> then users will not be able to login with this provider on you website.</li>
	</ul>
<?php   
	foreach( $HA_SOCIAL_LOGIN_PROVIDERS_CONFIG AS $item ){
		$provider_id                = @ $item["provider_id"];
		$provider_name              = @ $item["provider_name"];

		$require_client_id          = @ $item["require_client_id"];
		$provide_email              = @ $item["provide_email"];
		
		$provider_new_app_link      = @ $item["new_app_link"];
		$provider_userguide_section = @ $item["userguide_section"];

		$provider_callback_url      = "" ;

		if( isset( $item["callback"] ) && $item["callback"] ){
			$provider_callback_url  = '<span style="color:green">' . $hybridauth_base_url . '?hauth.done=' . $provider_id . '</span>';
		}
	?> 
	<div> 
		<div class="cfg">
			<div style="padding: 5px;margin: 5px;background: none repeat scroll 0 0 #F5F5F5;border-radius:3px;">
				<h2 style="margin-left:18px;"><img alt="<?php echo $provider_name ?>" title="<?php echo $provider_name ?>" src="<?php echo $assets_base_url . "16x16/" . strtolower( $provider_id ) . '.png' ?>" /> <?php echo $provider_name ?></h2> 
				<ul>
					 <li><b>Allow users to sign on with <?php echo $provider_name ?>?</b>
						<select name="params[<?php echo 'ha_settings_' . $provider_id . '_enabled' ?>]" style="height:22px;margin: 3px;" >
							<option value="1" <?php $entitykey = 'ha_settings_' . $provider_id . '_enabled'; if( $vars['entity']->$entitykey == 1 ) echo "selected"; ?> >YES</option>
							<option value="0" <?php $entitykey = 'ha_settings_' . $provider_id . '_enabled'; if( $vars['entity']->$entitykey == 0 ) echo "selected"; ?> >NO</option>
						</select>
					</li>
					
					<?php if ( $provider_new_app_link ){ ?>
						<?php if ( $require_client_id ){ // key or id ? ?>
							<li><b>Application ID</b>
							<input type="text" style="width: 350px;margin: 3px;"
							value="<?php $entitykey = 'ha_settings_' . $provider_id . '_app_id'; echo $vars['entity']->$entitykey; ?>"
							name="params[<?php echo 'ha_settings_' . $provider_id . '_app_id' ?>]" ></li>
						<?php } else { ?>
							<li><b>Application Key</b>
							<input type="text" style="width: 350px;margin: 3px;"
								value="<?php $entitykey = 'ha_settings_' . $provider_id . '_app_key'; echo $vars['entity']->$entitykey; ?>"
								name="params[<?php echo 'ha_settings_' . $provider_id . '_app_key' ?>]" ></li>
						<?php }; ?>	 

						<li><b>Application Secret</b>
						<input type="text" style="width: 350px;margin: 3px;"
							value="<?php $entitykey = 'ha_settings_' . $provider_id . '_app_secret'; echo $vars['entity']->$entitykey; ?>"
							name="params[<?php echo 'ha_settings_' . $provider_id . '_app_secret' ?>]" ></li>
					<?php } // if require registration ?>
				</ul> 
			</div>
			<div style="padding: 12px;margin: 5px;background: none repeat scroll 0 0 white;border-radius:3px;">
				<b>How to setup <?php echo $provider_name ?>:</b> 
				<br />
				<br />
				<?php if ( $provider_new_app_link  ) : ?>
					<p>In order to set up <?php echo $provider_name ?>, <b>you need to register your website with <?php echo $provider_name ?></b></p>
					
					<p>- Go to <a href="<?php echo $provider_new_app_link ?>" target ="_blanck"><?php echo $provider_new_app_link ?></a></p>

					<?php if ( $provider_id == "myspace" ) : ?>
						<p>- Make sure to put your correct website adress in the "External Url" and "External Callback Validation" fields. This adresse must match with the current hostname "<em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>".</p>
					<?php endif; ?> 

					<?php if ( $provider_id == "live" ) : ?>
						<p>- Make sure to put your correct website adress in the "Redirect Domain" field. This adresse must match with the current hostname "<em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>".</p>
					<?php endif; ?> 

					<?php if ( $provider_id == "facebook" ) : ?>
						<p>- Make sure to put your correct website adress in the "Site Url" field. This adresse must match with the current hostname "<em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>".</p>
						<p>- Once you have registered, copy the created application ID and Secret into this setup page.</p> 
					<?php elseif ( $provider_id == "google" ) : ?>
						<p>- On the <b>"Create Client ID"</b> popup switch to advanced settings by clicking on <b>(more options)</b>.</p>
						<p>- Once you have registered, copy the created application client ID and client secret into this setup page.</p> 
					<?php else: ?>	
						<p>- Once you have registered, copy the created application consumer key and Secret into this setup page.</p> 
					<?php endif; ?>
				<?php else: ?>	
					<p>- No registration required for OpenID based providers</p> 
				<?php endif; ?> 

				<?php if ( $provider_callback_url ) : ?>
					<p>- Provide this URL as the <b>Callback URL</b> for your application: <br /><?php echo $provider_callback_url ?></p>
				<?php endif; ?>  

		   </div>
		</div>   
	</div> 
	<br />  
	<?php
	}

	echo '</div>';
