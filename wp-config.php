<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('MY_API_KEY', 'AIzaSyC9bMgiY8WZca1N0K29fUS_V9Gvv81oNKU');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '6&Lv o6_;Y=:&4frV~$Mcw_|6*?il[OW3|[r@Ek@0So5]jfh^U<(q&I(9(#{TMKb' );
define( 'SECURE_AUTH_KEY',   'Bs+uk..sZrRN~7l?8J;kYPi.A:}J[=QM3[f!-Ev^6%7+5`!Rhrfq~xz;w!!S,hO9' );
define( 'LOGGED_IN_KEY',     '^;i<%`6jH^XwYOf D+h`!JR6Q$%h@BE8/sH_u!:KO>?xFE]vwV?G+*v/!Z2KzvR8' );
define( 'NONCE_KEY',         '}s*)xY,|tdh,95,n5 0ywq#(5&#d:gY/3Becd}-_~Mz`JE|ztc>q73,@bM^730x1' );
define( 'AUTH_SALT',         ';@iYhi2J.*O-+]yD=Va}}{Z8L|2Vf;P7MPM])Oa8pHhg AU&>|uq3c5RP`*7.ISz' );
define( 'SECURE_AUTH_SALT',  'v`:L47Q$?x.eHFv/{U$R7oay-BRwhZ>FE,{^Xw^ lPK1K`$L[tPD0k1Z~y;5!mb^' );
define( 'LOGGED_IN_SALT',    '_Uh&Bg{O9ms!5sxq*!Gq+Vp2=*5g=X[Im@;7VFX7v)4[`#/y4<I F(&GhWa#*_B[' );
define( 'NONCE_SALT',        'BXiw=~vfW3b?ZxH(RL>I<3gV?fo]fBIJ7$>t/OTxDn+Sdt>w&M8_mMrB@4/7@`A9' );
define( 'WP_CACHE_KEY_SALT', '<zKsEIrh.vSP[H|0l &lZvWaKeEgT:h08x@>(+RbXMcZ=lr`H}r9TlV)PUV:028b' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
