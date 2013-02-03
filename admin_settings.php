<?php

	if ( ! current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.', NKSC_TD ) );


	// update options
	if ( isset( $_POST['options_update'] ) ) {

		echo '<div class="updated"><p><strong>' . __( 'Settings saved', NKSC_TD ) . '</strong></p></div>';
	}


	// show announcement
	nksc_announcement();
?>
	<script type="text/javascript">
	// <![CDATA[
		jQuery(document).ready(function(){
			jQuery("#tabs-wrap").tabs( {
				fx: {
					opacity: 'toggle',
					duration: 200
				}
			} );
		} );
	// ]]>
	</script>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br /></div>
		<h2><?php _e( 'General Settings', NKSC_TD ); ?></h2>
		<form name="mainform" method="post" action="">
			<input type="hidden" value="1" name="options_update">

			<div id="tabs-wrap" class="">
				<ul class="tabs">
					<li class=""><a href="#tab1"><?php _e( 'General', NKSC_TD ); ?></a></li>
				</ul>

				<!-- General -->
				<div id="tab1" class="">
					<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
						<thead>
							<tr>
								<th width="200px" scope="col"><?php _e( 'General', NKSC_TD ); ?></th>
								<th scope="col">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php _e( 'Activate?', NKSC_TD ); ?></td>
								<td>
									<select name="nksc_active">
										<option value="no" <?php selected( get_option('nksc_active'), 'no' ); ?> ><?php _e( 'No', NKSC_TD ); ?></option>
										<option value="yes" <?php selected( get_option('nksc_active'), 'yes' ); ?> ><?php _e( 'Yes', NKSC_TD ); ?></option>
									</select>
									<br /><small><?php _e( 'If "YES" is selected, then plugin will add a login with NK button to login and register form.', NKSC_TD ); ?></small>
								</td>
							</tr>
						</tbody>
					</table>
				</div>


				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', NKSC_TD ); ?>" />
				</p>

			</div>
		</form>
	</div>
	<div class="clear"></div>
