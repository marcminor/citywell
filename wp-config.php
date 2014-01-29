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
/*


// ** Alternate database settings if using different database credentials for a dev server vs. production.
if ($_SERVER['REMOTE_ADDR']=='127.0.0.1') {
    define('WP_ENV', 'development');
} else {
    define('WP_ENV', 'production');
}

// MySQL settings - You can get this info from your web host //
if (WP_ENV == 'development') {
    define('DB_NAME', 'mydb-dev');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');
} else {
    define('DB_NAME', 'mydb-prod');
    define('DB_USER', 'username');
    define('DB_PASSWORD', 'pasdword');
    define('DB_HOST', 'mysql.mysite.com');
} 
*/


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'feature2_citywell');

/** MySQL database username */
define('DB_USER', 'feature2');

/** MySQL database password */
define('DB_PASSWORD', 'azazel');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Added several definitions for local git setup */
define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/wordpress');
define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME']);
define('WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content');
define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '[kV+2n.5Q/^i$W-`K|p<^j3&ao2ekr]v{oda*(y}F)$}Pne@kBlh^^OISx3qD,/z');
define('SECURE_AUTH_KEY',  '}0+?l+6.X#:u]CG8UG*Wi.&v<F-37@,,nN-O@9Ld o|q}+x]LUy+#`IF# C-F|52');
define('LOGGED_IN_KEY',    'w|j)U_VzPEv~`~/ZA?y|XFtGhFBNlU^mSQj@J|hIS=#9f>VUq0&WxEN4 jdb{RH+');
define('NONCE_KEY',        'BC{z+tV!fc88hX pdcHZ-G>tj<:+lxeiTbEl%+- wmkYo0tuBnQXQ^B<5VFQY6/]');
define('AUTH_SALT',        'QX7i-}/tglMKx?dpn0%5SDf&Nv{(x)x,G3wo:Z){&$)ncx9QnI/C1h?.MXKFhb9(');
define('SECURE_AUTH_SALT', 'yif8!~-%3<C=<6x9w<q!Nj)%r3}l(-YtD?6^U6fGdku=UR6P6|ox`Gv)Z%=UO? >');
define('LOGGED_IN_SALT',   'Ln(U0W4AAe&}L+gI4rJo3t~;Er?Vo.nX/<N?9i50V@Or$+@lvoe0Di5_hF293e3/');
define('NONCE_SALT',       'gp+e/T?l,Oy/NU0/P<wT-UC_M+~q`Vw=yT|S9Ku`VWIv^%#nE&P7]=xQ0uSqDB*r');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
