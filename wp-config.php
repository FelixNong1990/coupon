<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'coupon');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'e+O9Q6{f]L*-svbwpwsdl}GkWBJcw-slr@TBZ=vLH}17w~jJj|*ZLVB[lB+p$V9r');
define('SECURE_AUTH_KEY',  '2Xgrd7Dvr8PF!s/VnWy&yc54l5]kGghuQZL]BFm) ^s@!0Afc+@@/}^g|Qh^3-nv');
define('LOGGED_IN_KEY',    'R0P7E)`Ha$8:0=8aw: G;:<1[Ur-N;(HH;tWd-Bq%{7_C.#M-P2Q%.oB0:2^(V|[');
define('NONCE_KEY',        '#]xR-$>dzh;?nfUca&+P}(G9&mV*JD&%z1UCG2hmzrm|2~SU orR+EqbGt(2NHcB');
define('AUTH_SALT',        'lo~{JckD|T_()|QH$a&cA-{y@j/OY^T%:!F1nX0WKB5j=F5P$}|v70ZWVM`~+w?-');
define('SECURE_AUTH_SALT', 'r<Wr-XylKez|SJ@iQ=:~!NIo;meKgrpY3+I_7^Zf{2s>fp,i&BLfc)KZ}UMe.iqI');
define('LOGGED_IN_SALT',   'Zlm)-(r_ibCoz0YY$b[b~OV:k#,F>(K =Aq|e,BvOG[?&G[Kr-Sk)>/G+eh)xq2D');
define('NONCE_SALT',       'T|bDo#.:XvWd)}oKC{Y.&mIs?u0?f%EE6}M2DR 8#N_{<A>kT<(c~,m?J[!lW=L[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
