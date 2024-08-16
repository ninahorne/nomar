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
define('DB_NAME', 'local');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', 'root');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',          '33^?(n2L7@d87<UL0opGO!y2KBf4m+qjd8TZiDP7EoR#y2/uhNIqSgAmy.=P=[L+');
define('SECURE_AUTH_KEY',   '0MC/i/XJhI_WW*M5v cH~5Ji+C#3+FxQ.`ge{<$7*#{l_:6TbZ&&geAqxeLN^9[z');
define('LOGGED_IN_KEY',     'zV3zjyX6z%d aOx6:i&i~SVWc=j@W)1j2^#K1XOUZOtsLI|<b>kiiM#w))p$,&hZ');
define('NONCE_KEY',         'xyV2|a98%#a~nhK1qpfp>,&!&>0~HXkj^W+ULWv#jXP*cDL^h$0|IEggE>/U41_0');
define('AUTH_SALT',         'TmL>%dNMz85F.T-FSqb;kR{f</:t6SF4,qyk3xWA!Cy En]U$e[yMFm_n.Ga;`jE');
define('SECURE_AUTH_SALT',  'Szqoe<Axwl:kbSk ih3&QeUP8ZP}Uo4y6@ooC%3ZD@{D[?Ho?TvY.{+8Atwu_&.@');
define('LOGGED_IN_SALT',    'I`N.m~HzYu%nKOW<!1{@o.zw;9FX,-2U#qryoPy$s3iFWrI|>{R(_v8Y_p6v>G/r');
define('NONCE_SALT',        'VgH9iz,g_;]rt3Fp~{RtvV|IMQx]?(mJ-<GoesdTyK[:o,`1X%0ao4y41P2{~~_j');
define('WP_CACHE_KEY_SALT', 'lbeNW``PCJY jGR:^$we~Z|vv7?S~mTpV*&B= JfEO8.TGWjpn+xi!pWZheiEs&|');


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

define('WP_DEBUG', false);

define('WP_ENVIRONMENT_TYPE', 'local');
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
