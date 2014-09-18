<?php
// Template Name: Password Recovery
?>

<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Password Recovery', APP_TD ); ?></h1>

				<div class="content-bar">

					<span><?php _e( 'Please enter your username or email address. A new password will be emailed to you.', APP_TD ); ?></span>

				</div>

			</div>

			<div class="post-box">

				<?php do_action( 'appthemes_notices' ); ?>

				<form action="<?php echo appthemes_get_password_recovery_url( 'login_post' ); ?>" method="post" class="loginForm password-recovery-form" name="lostpassform" id="loginForm">

					<fieldset>

						<ol>
							<li>
								<label for="login_username"><?php _e( 'Username or Email:', APP_TD ); ?></label>
								<input type="text" class="text required" name="user_login" tabindex="1" id="login_username" />
							</li>

							<li>
								<button tabindex="2" type="submit" class="btn forgot" id="lostpass" name="lostpass" value="lostpass"><?php _e( 'Reset Password', APP_TD ); ?></button>
								<?php do_action( 'lostpassword_form' ); ?>
							</li>
						</ol>

					</fieldset>

					<!-- autofocus the field -->
					<script type="text/javascript">try{document.getElementById('login_username').focus();}catch(e){}</script>

				</form>

			</div>

		</div><!--/box-holder -->

	</div>

</div><!-- /content -->

<?php get_sidebar( 'login' ); ?>
