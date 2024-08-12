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


define('AUTH_KEY',         'byGsOB1mWkLprSVd9W+siUoyRnI3A4AkiKSmNlwFiciky+4tnrGHp2fbmmWOnJuKJCx2WI6pLai7vdsGdR3f7w==');
define('SECURE_AUTH_KEY',  'smsYP9WF7zCpGRXPzpcnwnLfYrJaWa3S3lGWjmHSG14bpkx+ylebpJJmh6XCTIlgqajoIwYd3eUC+jgaNc7wqA==');
define('LOGGED_IN_KEY',    'q6bndsfT9H9/NHsjgnLJT62g/06jtrcrbza16KDbL8e+D3x/jcMsxNYob4qKVcI4Y2HnMe+OYPkXahdK5/WnPA==');
define('NONCE_KEY',        'yX5TUyEPQRA3/DlgnS5OYLyGxJ57Gj6wwLYGvIC3Ge3gptI/LmVEcunQL0FLD6PkmmOkw9kgRcBWFOkoyjp18g==');
define('AUTH_SALT',        'VebPOTrZJ+HNgKSReZTJ7C/KvIEgnDCOdcJTd6NB9OZyePM/7GRq5QgH39t0+/i/giqkANeD91hVQUqPnNi9RQ==');
define('SECURE_AUTH_SALT', 'jO6NsnjFCEYGabueMP1HVbX8Il0krTBpp24MpThvUB9E01Ctf0L1z1zYRPgjzJNA/wYh1j2qFwD1jya8pkVsqg==');
define('LOGGED_IN_SALT',   'Yrx05uSiOVmqfe8aVe1uxbcETSBbnw1TZCnl0ZFrVG5KlYB3k0cmnWm8i0BnKoXYZ6sW4m/e6RR6mFkux6q+gA==');
define('NONCE_SALT',       'SPVMMV5ny9wkmV2YhrBjzgKFSBek4VanLeD42DuLAbSiaAeulP/mRIm2EHfp0/0q6bVERH9vavsmbARsZo4d5w==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
