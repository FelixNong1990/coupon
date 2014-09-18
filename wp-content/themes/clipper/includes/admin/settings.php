<?php

class CLPR_Theme_Settings_General extends APP_Tabs_Page {

	function setup() {
		$this->textdomain = APP_TD;

		$this->args = array(
			'page_title' => __( 'Clipper Settings', APP_TD ),
			'menu_title' => __( 'Settings', APP_TD ),
			'page_slug' => 'app-settings',
			'parent' => 'app-dashboard',
			'screen_icon' => 'options-general',
			'admin_action_priority' => 10,
		);

		add_action( 'admin_notices', array( $this, 'admin_tools' ) );

	}


	public function admin_tools() {

		if ( isset( $_GET['prune-coupons'] ) && $_GET['prune-coupons'] == 1 ) {
			clpr_coupon_prune();
			echo scb_admin_notice( __( 'Expired coupons have been pruned.', APP_TD ) );
		}

		if ( isset( $_GET['reset-votes'] ) && $_GET['reset-votes'] == 1 ) {
			clpr_reset_votes();
			echo scb_admin_notice( __( 'Votes have been reseted.', APP_TD ) );
		}

		if ( isset( $_GET['reset-stats'] ) && $_GET['reset-stats'] == 1 ) {
			appthemes_reset_stats();
			echo scb_admin_notice( __( 'Statistics have been reseted.', APP_TD ) );
		}

		if ( isset( $_GET['reset-search-stats'] ) && $_GET['reset-search-stats'] == 1 ) {
			clpr_reset_search_stats();
			echo scb_admin_notice( __( 'Search statistics have been reseted.', APP_TD ) );
		}


	}


	protected function init_tabs() {
		// Remove unwanted query args from urls
		$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'firstrun', 'prune-coupons', 'reset-votes', 'reset-stats', 'reset-search-stats' ), $_SERVER['REQUEST_URI'] );

		$this->tabs->add( 'general', __( 'General', APP_TD ) );
		$this->tabs->add( 'listings', __( 'Listings', APP_TD ) );
		$this->tabs->add( 'security', __( 'Security', APP_TD ) );
		$this->tabs->add( 'advertise', __( 'Advertising', APP_TD ) );
		$this->tabs->add( 'advanced', __( 'Advanced', APP_TD ) );

		$this->tab_sections['general']['configuration'] = array(
			'title' => __( 'Site Configuration', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Color Scheme', APP_TD ),
					'type' => 'select',
					'name' => 'stylesheet',
					'values' => array(
						'red.css' => __( 'Red Theme', APP_TD ),
						'blue.css' => __( 'Blue Theme', APP_TD ),
						'orange.css' => __( 'Orange Theme', APP_TD ),
						'green.css' => __( 'Green Theme', APP_TD ),
						'gray.css' => __( 'Gray Theme', APP_TD ),
					),
					'tip' => __( 'Select the color scheme you would like to use.', APP_TD ),
				),
				array(
					'title' => __( 'Enable Featured Slider', APP_TD ),
					'name' => 'featured_slider',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'This option turns on the home page featured coupons slider. To make an coupon appear in slider, check the "Featured Coupon" box on the WordPress edit post page under "Coupon Meta Fields".', APP_TD ),
				),
				array(
					'title' => __( 'Enable Logo', APP_TD ),
					'name' => 'use_logo',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'If you do not have a logo to use, uncheck the box and this will display the title and description of your web site instead.', APP_TD ),
				),
				array(
					'title' => __( 'Web Site Logo', APP_TD ),
					'desc' => $this->wrap_upload( 'logo_url', '<br />' . __( 'Upload a logo or paste an image URL directly.', APP_TD ) ),
					'type' => 'text',
					'name' => 'logo_url',
					'tip' => __( 'Paste the URL of your web site logo image here. It will replace the default header logo. (i.e. http://www.yoursite.com/logo.jpg)', APP_TD ),
				),
				array(
					'title' => __( 'Web Site Favicon', APP_TD ),
					'desc' => $this->wrap_upload( 'favicon_url', '<br />' . sprintf( __( '<a target="_new" href="%s">Create your own</a> favicon or paste an image URL directly. Must be a 16x16 .ico file.', APP_TD ), 'http://www.favicon.cc/' ) ),
					'type' => 'text',
					'name' => 'favicon_url',
					'tip' => __( 'Paste the URL of your web site favicon image here. It will replace the default favicon logo.(i.e. http://www.yoursite.com/favicon.ico)', APP_TD ),
				),
				array(
					'title' => __( 'Feedburner URL', APP_TD ),
					'desc' => '<br />' . sprintf( '%s' . __( 'Sign up for a free <a target="_new" href="%s">Feedburner account</a>.', APP_TD ), '<div class="feedburnerico"></div>', 'http://feedburner.google.com' ),
					'type' => 'text',
					'name' => 'feedburner_url',
					'tip' => __( 'Paste your Feedburner address here. It will automatically redirect your default RSS feed to Feedburner. You must have a Google Feedburner account setup first.', APP_TD ),
				),
				array(
					'title' => __( 'Twitter Username', APP_TD ),
					'desc' => '<br />' . sprintf( '%s' . __( 'Sign up for a free <a target="_new" href="%s">Twitter account</a>.', APP_TD ), '<div class="twitterico"></div>', 'http://twitter.com' ),
					'type' => 'text',
					'name' => 'twitter_id',
					'tip' => __( 'Paste your Twitter username here. It will automatically redirect people who click on your Twitter link to your Twitter page. You must have a Twitter account setup first.', APP_TD ),
				),
				array(
					'title' => __( 'Facebook Page ID', APP_TD ),
					'desc' => '<br />' . sprintf( '%s' . __( 'Sign up for a free <a target="_new" href="%s">Facebook account</a>.', APP_TD ), '<div class="facebookico"></div>', 'http://www.facebook.com' ),
					'type' => 'text',
					'name' => 'facebook_id',
					'tip' => __( 'Paste your Facebook Page ID or username here. It will display Facebook icon with URL to you page in the top bar. You must have a Facebook account and page setup first.', APP_TD ),
				),
				array(
					'title' => __( 'Tracking Code', APP_TD ),
					'desc' => '<br />' . sprintf( '%s' . __( 'Sign up for a free <a target="_new" href="%s">Google Analytics account</a>.', APP_TD ), '<div class="googleico"></div>', 'http://www.google.com/analytics/' ),
					'type' => 'textarea',
					'sanitize' => 'appthemes_clean',
					'name' => 'google_analytics',
					'extra' => array(
						'style' => 'width: 300px; height: 100px;'
					),
					'tip' => __( 'Paste your analytics tracking code here. Google Analytics is free and the most popular but you can use other providers as well.', APP_TD ),
				),
			),
		);

		$this->tab_sections['general']['search_settings'] = array(
			'title' => __( 'Search Settings', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Enable Search Stats', APP_TD ),
					'name' => 'search_stats',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Do you want to record all searches and results found on your website?', APP_TD ),
				),
				array(
					'title' => __( 'Exclude Pages', APP_TD ),
					'name' => 'search_ex_pages',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Should the pages be excluded from your website search results?', APP_TD ),
				),
				array(
					'title' => __( 'Exclude Blog Posts', APP_TD ),
					'name' => 'search_ex_blog',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Should the blog posts be excluded from your website search results?', APP_TD ),
				),
			),
		);


		$this->tab_sections['listings']['configuration'] = array(
			'title' => __( 'Coupons Configuration', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Moderate New Coupons', APP_TD ),
					'name' => 'coupons_require_moderation',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'This options allows you to control if new coupons should be manually approved before they go live.', APP_TD ),
				),
				array(
					'title' => __( 'Moderate New Stores', APP_TD ),
					'name' => 'stores_require_moderation',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'This options allows you to control if new stores submitted with coupons should be manually approved before they go live. Note: Moderate New Coupons must be enabled for this to work.', APP_TD ),
				),
				array(
					'title' => __( 'Prune Expired Coupons', APP_TD ),
					'name' => 'prune_coupons',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'A cron job runs once a day and automatically removes all expired coupons from your site (does not delete them, just changes the post status to draft). If this is disabled, the coupon will remain live on your site, marked as expired, and moved under the "unreliable coupons" section.', APP_TD ),
				),
				array(
					'title' => __( 'Require Registration', APP_TD ),
					'name' => 'reg_required',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Anyone submitting a coupon must first have a user account and be logged in. Note: If "Charge for coupons" option is enabled, disabling this option will not take effect.', APP_TD ),
				),
				array(
					'title' => __( 'Allow Coupon Editing', APP_TD ),
					'name' => 'coupon_edit',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Allows the coupon owner to edit and republish their existing coupons from their dashboard.', APP_TD ),
				),
				array(
					'title' => __( 'Hide Coupon Code', APP_TD ),
					'name' => 'coupon_code_hide',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Allows you to hide coupon codes on site, visitors will see the code only after clicking coupon link bar.', APP_TD ),
				),
				array(
					'title' => __( 'Home Exclude Unreliable', APP_TD ),
					'name' => 'exclude_unreliable',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Allows you to exclude unreliable coupons from displaying on homepage, visitors will see only the valid coupons.', APP_TD ),
				),
				array(
					'title' => __( 'Link Single Coupon Page', APP_TD ),
					'name' => 'link_single_page',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Allows you to hide links to single coupon pages, those pages will also not be indexed by search engines.', APP_TD ),
				),
				array(
					'title' => __( 'Cloak Links', APP_TD ),
					'name' => 'cloak_links',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Hides coupon and stores outgoing URLs, and count clicks for each link.', APP_TD ),
				),
				array(
					'title' => __( 'Allow HTML', APP_TD ),
					'name' => 'allow_html',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Turns on the TinyMCE editor on text area fields and allows the coupon owner to use html markup. Other fields do not allow html by default.', APP_TD ),
				),
				array(
					'title' => __( 'Show Views Counter', APP_TD ),
					'name' => 'stats_all',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( "This will show a 'total views' and 'today's views' at the bottom of each coupon and blog post.", APP_TD ),
				),
				array(
					'title' => __( 'Allowed File Types', APP_TD ),
					'type' => 'text',
					'name' => 'submit_file_types',
					'tip' => __( 'When submitting a printable coupon, only allow these file types to be uploaded (i.e. png,gif,jpg). Comma separated, no spaces.', APP_TD ),
				),
			),
		);

		$this->tab_sections['listings']['pricing'] = array(
			'title' => __( 'Pricing Options', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Charge for Coupons', APP_TD ),
					'desc' => __( 'Yes', APP_TD ),
					'type' => 'checkbox',
					'name' => 'charge_coupons',
					'tip' => __( 'This option activates the payment system so you can start charging for coupons on your site.', APP_TD ),
				),
				array(
					'title' => __( 'Coupon Price', APP_TD ),
					'desc' => __( 'Only enter numeric values or decimal points. Do not include a currency symbol or commas.', APP_TD ),
					'type' => 'text',
					'name' => 'coupon_price',
					'tip' => __( 'This is the amount you will charge visitors to post a coupon on your site.', APP_TD ),
				),
				array(
					'title' => __( 'Payments Settings', APP_TD ),
					'type' => '',
					'name' => '_blank',
					'desc' => sprintf( __( 'Set your currency and Payment Gateway settings in the <a href="%s">Payments Menu.</a>', APP_TD ), 'admin.php?page=app-payments-settings' ),
					'extra' => array(
						'style' => 'display: none;'
					),
					'tip' => __( 'Manage Payments Settings including currencies, enable/disable available payment gateways, and manage individual payment gateway\'s settings.', APP_TD ),
				),
			),
		);


		$this->tab_sections['security']['settings'] = array(
			'title' => __( 'Security Settings', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Back Office Access', APP_TD ),
					'desc' => '<br />' . sprintf( __( "View the WordPress <a target='_new' href='%s'>Roles and Capabilities</a> for more information.", APP_TD ), 'http://codex.wordpress.org/Roles_and_Capabilities' ),
					'type' => 'select',
					'name' => 'admin_security',
					'values' => array(
						'manage_options' => __( 'Admins Only', APP_TD ),
						'edit_others_posts' => __( 'Admins, Editors', APP_TD ),
						'publish_posts' => __( 'Admins, Editors, Authors', APP_TD ),
						'edit_posts' => __( 'Admins, Editors, Authors, Contributors', APP_TD ),
						'read' => __( 'All Access', APP_TD ),
						'disable' => __( 'Disable', APP_TD ),
					),
					'tip' => __( 'Allows you to restrict access to the WordPress Back Office (wp-admin) by specific role. Keeping this set to admins only is recommended. Select Disable if you have problems with this feature.', APP_TD ),
				),
			),
		);

		$this->tab_sections['security']['recaptcha'] = array(
			'title' => __( 'reCaptcha Settings', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Enable reCaptcha', APP_TD ),
					'name' => 'captcha_enable',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ) . '<br />' . sprintf( __( "reCaptcha is a free anti-spam service provided by Google. Learn more about <a target='_new' href='%s'>reCaptcha</a>.", APP_TD ), 'http://code.google.com/apis/recaptcha/' ),
					'tip' => __( 'Enables the reCaptcha service that will protect your site against spam registrations. It will show a verification box on your registration page that requires a human to read and enter the words.', APP_TD ),
				),
				array(
					'title' => __( 'reCaptcha Public Key', APP_TD ),
					'desc' => '<br />' . sprintf( '%s' . __( 'Sign up for a free <a target="_new" href="%s">Google reCaptcha</a> account.', APP_TD ), '<div class="captchaico"></div>', 'https://www.google.com/recaptcha/admin/create' ),
					'type' => 'text',
					'name' => 'captcha_public_key',
					'tip' => __( 'Enter your public key here to enable an anti-spam service on your new user registration page (requires a free Google reCaptcha account). Leave it blank if you do not wish to use this anti-spam feature.', APP_TD ),
				),
				array(
					'title' => __( 'reCaptcha Private Key', APP_TD ),
					'desc' => '<br />' . sprintf( '%s' . __( 'Sign up for a free <a target="_new" href="%s">Google reCaptcha</a> account.', APP_TD ), '<div class="captchaico"></div>', 'https://www.google.com/recaptcha/admin/create' ),
					'type' => 'text',
					'name' => 'captcha_private_key',
					'tip' => __( 'Enter your private key here to enable an anti-spam service on your new user registration page (requires a free Google reCaptcha account). Leave it blank if you do not wish to use this anti-spam feature.', APP_TD ),
				),
				array(
					'title' => __( 'Choose Theme', APP_TD ),
					'type' => 'select',
					'name' => 'captcha_theme',
					'values' => array(
						'red' => __( 'Red', APP_TD ),
						'white' => __( 'White', APP_TD ),
						'blackglass' => __( 'Black', APP_TD ),
						'clean' => __( 'Clean', APP_TD ),
					),
					'tip' => __( 'Select the color scheme you wish to use for reCaptcha.', APP_TD ),
				),
			),
		);


		$this->tab_sections['advertise']['content'] = array(
			'title' => __( 'Ad (336x280)', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Enable Ad', APP_TD ),
					'name' => 'adcode_336x280_enable',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Disable this option if you do not wish to have a 336x280 ads displayed on single ad, category, or search result pages.', APP_TD ),
				),
				array(
					'title' => __( 'Ad Code', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'Paste your ad code here. Supports many popular providers such as <a target="_new" href="%s">Google AdSense</a> and <a target="_new" href="%s">BuySellAds</a>.', APP_TD ), 'http://www.google.com/adsense/', 'http://www.buysellads.com/' ),
					'type' => 'textarea',
					'sanitize' => 'appthemes_clean',
					'name' => 'adcode_336x280',
					'extra' => array(
						'style' => 'width: 500px; height: 200px;'
					),
					'tip' => __( 'You may use html and/or javascript code provided by Google AdSense.', APP_TD ),
				),
				array(
					'title' => __( 'Ad Image URL', APP_TD ),
					'desc' => $this->wrap_upload( 'adcode_336x280_url', '<br />' . __( 'Upload your ad creative or paste the ad creative URL directly.', APP_TD ) ),
					'type' => 'text',
					'name' => 'adcode_336x280_url',
					'tip' => __( 'If you would rather use an image ad instead of code provided by your advertiser, use this field instead.', APP_TD ),
				),
				array(
					'title' => __( 'Ad Destination', APP_TD ),
					'desc' => '<br />' . __( 'Paste the destination URL of your custom ad creative here (i.e. http://www.yoursite.com/landing-page.html).', APP_TD ),
					'type' => 'text',
					'name' => 'adcode_336x280_dest',
					'tip' => __( 'When a visitor clicks on your ad image, this is the destination they will be sent to.', APP_TD ),
				),
			),
		);


		$this->tab_sections['advanced']['settings'] = array(
			'title' => __( 'Advanced Options', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Run Coupons Expired Check', APP_TD ),
					'name' => '_blank',
					'type' => '',
					'desc' => sprintf( __( 'Prune <a href="%s">Expired Coupons</a> now.', APP_TD ), 'admin.php?page=app-settings&prune-coupons=1' ),
					'extra' => array(
						'style' => 'display: none;'
					),
					'tip' => __( 'Click the link to manually run the function that checks all coupons expiration and prunes any coupons that are expired. This event will run only one time.', APP_TD ),
				),
				array(
					'title' => __( 'Reset Votes', APP_TD ),
					'name' => '_blank',
					'type' => '',
					'desc' => sprintf( __( '<a href="%s">Reset Votes</a> count now.', APP_TD ), 'admin.php?page=app-settings&reset-votes=1' ),
					'extra' => array(
						'style' => 'display: none;'
					),
					'tip' => __( 'Click the link to run the function that reset the votes count for all coupons.', APP_TD ),
				),
				array(
					'title' => __( 'Reset Stats', APP_TD ),
					'name' => '_blank',
					'type' => '',
					'desc' => sprintf( __( '<a href="%s">Reset Stats</a> count now.', APP_TD ), 'admin.php?page=app-settings&reset-stats=1' ),
					'extra' => array(
						'style' => 'display: none;'
					),
					'tip' => __( 'Click the link to run the function that reset the stats count for all coupons and posts.', APP_TD ),
				),
				array(
					'title' => __( 'Reset Search Stats', APP_TD ),
					'name' => '_blank',
					'type' => '',
					'desc' => sprintf( __( '<a href="%s">Reset Search Stats</a> count now.', APP_TD ), 'admin.php?page=app-settings&reset-search-stats=1' ),
					'extra' => array(
						'style' => 'display: none;'
					),
					'tip' => __( 'Click the link to run the function that reset the stats of using search engine on site.', APP_TD ),
				),
				array(
					'title' => __( 'Disable Core Stylesheets', APP_TD ),
					'name' => 'disable_stylesheet',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'If you are interested in creating a child theme or just want to completely disable the core Clipper styles, enable this option. (Note: this option is for advanced users. Do not change unless you know what you are doing.)', APP_TD ),
				),
				array(
					'title' => __( 'Enable Debug Mode', APP_TD ),
					'name' => 'debug_mode',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( "This will print out the query_vars and queries arrays (if <code>define('SAVEQUERIES', true);</code> is added to your wp-config.php) in the footer of your website. This should be used for debugging and will only be visible to logged in admins.", APP_TD ),
				),
				array(
					'title' => __( 'Use Google CDN jQuery', APP_TD ),
					'name' => 'google_jquery',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( "This will use Google's hosted jQuery files which are served from their global content delivery network. This will help your site load faster and save bandwidth.", APP_TD ),
				),
				array(
					'title' => __( 'Disable WordPress Login Page', APP_TD ),
					'name' => 'disable_wp_login',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'If someone tries to access <code>wp-login.php</code> directly, they will be redirected to Clipper themed login pages. If you want to use any "maintenance mode" plugins, you should enable the default WordPress login page.', APP_TD ),
				),
				array(
					'title' => __( 'Disable WordPress Version Meta Tag', APP_TD ),
					'name' => 'remove_wp_generator',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( "This will remove the WordPress generator meta tag in the source code of your site <code>< meta name='generator' content='WordPress 3.5' ></code>. It's an added security measure which prevents anyone from seeing what version of WordPress you are using. It also helps to deter hackers from taking advantage of vulnerabilities sometimes present in WordPress. (Yes is recommended)", APP_TD ),
				),
				array(
					'title' => __( 'Disable WordPress User Toolbar', APP_TD ),
					'name' => 'remove_admin_bar',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'This will remove the WordPress user toolbar at the top of your web site which is displayed for all logged in users.', APP_TD ),
				),
			),
		);

		$this->tab_sections['advanced']['permalinks'] = array(
			'title' => __( 'Custom Post Type & Taxonomy URLs', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Coupon Listing Base URL', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'IMPORTANT: You must <a target="_blank" href="%s">re-save your permalinks</a> for this change to take effect.', APP_TD ), 'options-permalink.php' ),
					'type' => 'text',
					'name' => 'coupon_permalink',
					'tip' => __( 'This controls the base name of your coupon listing urls. The default is coupon and will look like this: http://www.yoursite.com/coupons/coupon-title-here/. Do not include any slashes. This should only be alpha and/or numeric values. You should not change this value once you have launched your site otherwise you risk breaking urls of other sites pointing to yours, etc.', APP_TD ),
				),
				array(
					'title' => __( 'Coupon Category Base URL', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'IMPORTANT: You must <a target="_blank" href="%s">re-save your permalinks</a> for this change to take effect.', APP_TD ), 'options-permalink.php' ),
					'type' => 'text',
					'name' => 'coupon_cat_tax_permalink',
					'tip' => __( 'This controls the base name of your coupon category urls. The default is coupon-category and will look like this: http://www.yoursite.com/coupon-category/category-name/. Do not include any slashes. This should only be alpha and/or numeric values. You should not change this value once you have launched your site otherwise you risk breaking urls of other sites pointing to yours, etc.', APP_TD ),
				),
				array(
					'title' => __( 'Coupon Store Base URL', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'IMPORTANT: You must <a target="_blank" href="%s">re-save your permalinks</a> for this change to take effect.', APP_TD ), 'options-permalink.php' ),
					'type' => 'text',
					'name' => 'coupon_store_tax_permalink',
					'tip' => __( 'This controls the base name of your coupon store urls. The default is store and will look like this: http://www.yoursite.com/store/store-name/. Do not include any slashes. This should only be alpha and/or numeric values. You should not change this value once you have launched your site otherwise you risk breaking urls of other sites pointing to yours, etc.', APP_TD ),
				),
				array(
					'title' => __( 'Coupon Type Base URL', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'IMPORTANT: You must <a target="_blank" href="%s">re-save your permalinks</a> for this change to take effect.', APP_TD ), 'options-permalink.php' ),
					'type' => 'text',
					'name' => 'coupon_type_tax_permalink',
					'tip' => __( 'This controls the base name of your coupon type urls. The default is coupon-type and will look like this: http://www.yoursite.com/coupon-type/type-name/. Do not include any slashes. This should only be alpha and/or numeric values. You should not change this value once you have launched your site otherwise you risk breaking urls of other sites pointing to yours, etc.', APP_TD ),
				),
				array(
					'title' => __( 'Coupon Tag Base URL', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'IMPORTANT: You must <a target="_blank" href="%s">re-save your permalinks</a> for this change to take effect.', APP_TD ), 'options-permalink.php' ),
					'type' => 'text',
					'name' => 'coupon_tag_tax_permalink',
					'tip' => __( 'This controls the base name of your coupon tag urls. The default is coupon-tag and will look like this: http://www.yoursite.com/coupon-tag/tag-name/. Do not include any slashes. This should only be alpha and/or numeric values. You should not change this value once you have launched your site otherwise you risk breaking urls of other sites pointing to yours, etc.', APP_TD ),
				),
			),
		);

		$this->tab_sections['advanced']['redirects'] = array(
			'title' => __( 'Store & Coupon Redirect URLs', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Coupon Redirect Base URL', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'IMPORTANT: This value must be unique (not like any other base/path URLs).<br /> You must also <a target="_blank" href="%s">re-save your permalinks</a> for this change to take effect.', APP_TD ), 'options-permalink.php' ),
					'type' => 'text',
					'name' => 'coupon_redirect_base_url',
					'tip' => __( 'This controls the base name of your display url. If you have a destination url setup for a coupon, it will look something like this when you hover over the link: http://www.yoursite.com/go/coupon-name/23. The &quot;/go/&quot; is what is controlled here. Only enter alpha characters (no slashes, etc).', APP_TD ),
				),
				array(
					'title' => __( 'Store Redirect Base URL', APP_TD ),
					'desc' => '<br />' . sprintf( __( 'IMPORTANT: This value must be unique (not like any other base/path URLs).<br /> You must also <a target="_blank" href="%s">re-save your permalinks</a> for this change to take effect.', APP_TD ), 'options-permalink.php' ),
					'type' => 'text',
					'name' => 'store_redirect_base_url',
					'tip' => __( 'This controls the base name of your display url. If you have a destination url setup for a store, it will look something like this when you hover over the link: http://www.yoursite.com/go-store/store-name/23. The &quot;/go-store/&quot; is what is controlled here. Only enter alpha characters (no slashes, etc).', APP_TD ),
				),
			),
		);


	}


	private function wrap_upload( $field_name, $desc ) {
		$upload_button = html( 'input', array( 'class' => 'upload_button button', 'rel' => $field_name, 'type' => 'button', 'value' => __( 'Upload Image', APP_TD ) ) );
		$clear_button = html( 'input', array( 'class' => 'delete_button button', 'rel' => $field_name, 'type' => 'button', 'value' => __( 'Clear Image', APP_TD ) ) );
		$preview = html( 'div', array( 'id' => $field_name . '_image', 'class' => 'upload_image_preview' ), html( 'img', array( 'src' => scbForms::get_value( $field_name, $this->options->get() ) ) ) );

		return $upload_button . ' ' . $clear_button . $desc . $preview;
	}


	function page_footer() {
		parent::page_footer();
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	/* upload logo and images */
	jQuery('.upload_button').click(function() {
		formfield = jQuery(this).attr('rel');
		tb_show('', 'media-upload.php?type=image&amp;post_id=0&amp;TB_iframe=true');
		return false;
	});

	/* send the uploaded image url to the field */
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src'); // get the image url
		imgoutput = '<img src="' + imgurl + '" />'; //get the html to output for the image preview
		jQuery('#' + formfield).val(imgurl);
		jQuery('#' + formfield + '_image').html(imgoutput);
		tb_remove();
	}
});
</script>
<?php
	}


}



class CLPR_Theme_Settings_Emails extends APP_Tabs_Page {

	function setup() {
		$this->textdomain = APP_TD;

		$this->args = array(
			'page_title' => __( 'Clipper Emails', APP_TD ),
			'menu_title' => __( 'Emails', APP_TD ),
			'page_slug' => 'app-emails',
			'parent' => 'app-dashboard',
			'screen_icon' => 'options-general',
			'admin_action_priority' => 10,
		);

	}


	protected function init_tabs() {
		$this->tabs->add( 'general', __( 'General', APP_TD ) );
		$this->tabs->add( 'new_user', __( 'New User Email', APP_TD ) );
		$this->tabs->add( 'new_coupon', __( 'New Coupon Email', APP_TD ) );

		$this->tab_sections['general']['notifications'] = array(
			'title' => __( 'Email Notifications', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Admin Notifications', APP_TD ),
					'name' => '_blank',
					'type' => '',
					'desc' => sprintf( __( 'Emails will be sent to: %s (<a href="%s">change</a>)', APP_TD ), get_option('admin_email'), 'options-general.php' ),
					'extra' => array(
						'style' => 'display: none;'
					),
				),
				array(
					'title' => __( 'New Coupon Email', APP_TD ),
					'name' => 'new_ad_email',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Send me an email once a new coupon has been submitted.', APP_TD ),
				),
				array(
					'title' => __( 'Prune Coupons Email', APP_TD ),
					'name' => 'prune_coupons_email',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Send me an email every time the system prunes expired coupons.', APP_TD ),
				),
				array(
					'title' => __( 'Admin New User Email', APP_TD ),
					'name' => 'nu_admin_email',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Send me an email when a new user registers on my site.', APP_TD ),
				),
			),
		);


		$this->tab_sections['new_user']['settings'] = array(
			'title' => __( 'New User Registration Email', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Enable Custom Email', APP_TD ),
					'name' => 'nu_custom_email',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Sends a custom new user notification email to your customers by using the fields you complete below. If this is disabled, the default WordPress new user notification email will be sent. This is useful for debugging if your custom emails are not being sent.', APP_TD ),
				),
				array(
					'title' => __( 'From Name', APP_TD ),
					'type' => 'text',
					'name' => 'nu_from_name',
					'tip' => __( 'This is what your customers will see as the &quot;from&quot; when they receive the new user registration email. Use plain text only.', APP_TD ),
				),
				array(
					'title' => __( 'From Email', APP_TD ),
					'type' => 'text',
					'name' => 'nu_from_email',
					'tip' => __( 'This is what your customers will see as the &quot;from&quot; email address (also the reply to) when they receive the new user registration email. Use only a valid and existing email address with no html or variables.', APP_TD ),
				),
				array(
					'title' => __( 'Email Subject', APP_TD ),
					'type' => 'text',
					'name' => 'nu_email_subject',
					'tip' => __( 'This is the subject line your customers will see when they receive the new user registration email. Use text and variables only.', APP_TD ),
				),
				array(
					'title' => __( 'Allow HTML in Body', APP_TD ),
					'name' => 'nu_email_type',
					'type' => 'radio',
					'values' => array(
						'text/HTML' => __( 'Yes', APP_TD ),
						'text/plain' => __( 'No', APP_TD ),
					),
					'tip' => __( 'This option allows you to use html markup in the email body below. It is recommended to keep it disabled to avoid problems with delivery. If you turn it on, make sure to test it and make sure the formatting looks ok and gets delivered properly.', APP_TD ),
				),
				array(
					'title' => __( 'Email Body', APP_TD ),
					'desc' => '<br />' . __( 'You may use the following variables within the email body and/or subject line.', APP_TD )
						. '<br />' . sprintf( __( '%s - prints out the username', APP_TD ), '<code>%username%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the users email address', APP_TD ), '<code>%useremail%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the users text password', APP_TD ), '<code>%password%</code>' )
						. '<br />' . sprintf( __( '%s - prints out your website url', APP_TD ), '<code>%siteurl%</code>' )
						. '<br />' . sprintf( __( '%s - prints out your site name', APP_TD ), '<code>%blogname%</code>' )
						. '<br />' . sprintf( __( '%s - prints out your sites login url', APP_TD ), '<code>%loginurl%</code>' )
						. '<br /><br />' . __( 'Each variable MUST have the percentage signs wrapped around it with no spaces.', APP_TD )
						. '<br />' . __( 'Always test your new email after making any changes to make sure it is working and formatted correctly. If you do not receive an email, chances are something is wrong with your email body.', APP_TD ),
					'type' => 'textarea',
					'sanitize' => 'appthemes_clean',
					'name' => 'nu_email_body',
					'extra' => array(
						'style' => 'width: 500px; height: 200px;'
					),
					'tip' => __( 'Enter the text you would like your customers to see in the new user registration email. Make sure to always at least include the %username% and %password% variables otherwise they might forget later.', APP_TD ),
				),
			),
		);


		$this->tab_sections['new_coupon']['settings'] = array(
			'title' => __( 'New Coupon Submission Email', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Enable Custom Email', APP_TD ),
					'name' => 'nc_custom_email',
					'type' => 'checkbox',
					'desc' => __( 'Yes', APP_TD ),
					'tip' => __( 'Sends a custom email to your customers whenever they submit a new coupon. If you do not require user registration to submit coupons, no email will be sent out.', APP_TD ),
				),
				array(
					'title' => __( 'From Name', APP_TD ),
					'type' => 'text',
					'name' => 'nc_from_name',
					'tip' => __( 'This is what your customers will see as the &quot;from&quot; when they receive the new coupon submission email. Use plain text only.', APP_TD ),
				),
				array(
					'title' => __( 'From Email', APP_TD ),
					'type' => 'text',
					'name' => 'nc_from_email',
					'tip' => __( 'This is what your customers will see as the &quot;from&quot; email address (also the reply to) when they receive the new coupon submission email. Use only a valid and existing email address with no html or variables.', APP_TD ),
				),
				array(
					'title' => __( 'Email Subject', APP_TD ),
					'type' => 'text',
					'name' => 'nc_email_subject',
					'tip' => __( 'This is the subject line your customers will see when they receive the new coupon submission email. Use text and variables only.', APP_TD ),
				),
				array(
					'title' => __( 'Allow HTML in Body', APP_TD ),
					'name' => 'nc_email_type',
					'type' => 'radio',
					'values' => array(
						'text/HTML' => __( 'Yes', APP_TD ),
						'text/plain' => __( 'No', APP_TD ),
					),
					'tip' => __( 'This option allows you to use html markup in the email body below. It is recommended to keep it disabled to avoid problems with delivery. If you turn it on, make sure to test it and make sure the formatting looks ok and gets delivered properly.', APP_TD ),
				),
				array(
					'title' => __( 'Email Body', APP_TD ),
					'desc' => '<br />' . __( 'You may use the following variables within the email body and/or subject line.', APP_TD )
						. '<br />' . sprintf( __( '%s - prints out the username', APP_TD ), '<code>%username%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the users email address', APP_TD ), '<code>%useremail%</code>' )
						. '<br />' . sprintf( __( '%s - prints out your website url', APP_TD ), '<code>%siteurl%</code>' )
						. '<br />' . sprintf( __( '%s - prints out your site name', APP_TD ), '<code>%blogname%</code>' )
						. '<br />' . sprintf( __( '%s - prints out your sites login url', APP_TD ), '<code>%loginurl%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the coupon title', APP_TD ), '<code>%title%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the coupon code', APP_TD ), '<code>%code%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the coupon category', APP_TD ), '<code>%category%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the coupon store name', APP_TD ), '<code>%store%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the coupon description', APP_TD ), '<code>%description%</code>' )
						. '<br />' . sprintf( __( '%s - prints out the dashboard url', APP_TD ), '<code>%dashurl%</code>' )
						. '<br /><br />' . __( 'Each variable MUST have the percentage signs wrapped around it with no spaces.', APP_TD )
						. '<br />' . __( 'Always test your new email after making any changes to make sure it is working and formatted correctly. If you do not receive an email, chances are something is wrong with your email body.', APP_TD ),
					'type' => 'textarea',
					'sanitize' => 'appthemes_clean',
					'name' => 'nc_email_body',
					'extra' => array(
						'style' => 'width: 500px; height: 200px;'
					),
					'tip' => __( 'Enter the text you would like your customers to see in the new user registration email. Make sure to always at least include the %username% and %password% variables otherwise they might forget later.', APP_TD ),
				),
			),
		);

	}

}


