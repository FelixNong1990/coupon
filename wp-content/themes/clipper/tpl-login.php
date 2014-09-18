<?php
// Template Name: Login
?>

<div id="content">

	<div class="content-box">
	
		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Login', APP_TD ); ?></h1>

				<div class="content-bar">

					<span><?php _e( 'Complete the fields below to login.', APP_TD ); ?></span>

				</div>

			</div>

			<div class="post-box">

				<?php do_action( 'appthemes_notices' ); ?>

				<form action="<?php echo appthemes_get_login_url( 'login_post' ); ?>" method="post" class="loginForm" id="loginForm">

					<fieldset>

						<ol>
							<li>
								<label for="login_username"><?php _e( 'Username:', APP_TD ); ?></label>
								<input type="text" name="log" class="text required" tabindex="1" id="login_username" value="<?php if (isset($_POST['login_username'])) echo esc_attr( $_POST['login_username'] ); ?>" />
							</li>

							<li>
								<label for="login_password"><?php _e( 'Password:', APP_TD ); ?></label>
								<input type="password" name="pwd" class="text required" tabindex="2" id="login_password" value="" />
							</li>

							<li>
								<button tabindex="4" type="submit" class="btn login" id="login" name="login" value="login"><?php _e( 'Login', APP_TD ); ?></button>
								<?php echo APP_Login::redirect_field(); ?>
								<input type="hidden" name="testcookie" value="1" />
							</li>

							<li id="rememberme">
								<input type="checkbox" name="rememberme" class="checkbox" tabindex="3" id="rememberme" value="forever" checked="checked" />
								<span><?php _e( 'Remember me', APP_TD ); ?></span>
							</li>

							<li id="lostpass">
								<a href="<?php echo appthemes_get_password_recovery_url(); ?>" title="<?php _e( 'Password Lost and Found', APP_TD ); ?>"><?php _e( 'Lost your password?', APP_TD ); ?></a>
							</li>

							<?php wp_register( '<li id="register">', '</li>' ); ?>

							<?php do_action( 'login_form' ); ?>

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
