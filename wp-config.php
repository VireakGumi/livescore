<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'livescore' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         ';{+Z;rnq}.Evp 1$,^ZS.sh1hjo@)ol-BPLKBG![?9pQ+=T- DO1L@;88zBYif}w' );
define( 'SECURE_AUTH_KEY',  '`TVc)2Q2tpOIpEa@wejfoo|v-bU?S. CcI0Bv`)yX%}#gD+Ys#1>|`c<B4VD 9_j' );
define( 'LOGGED_IN_KEY',    'WE_BeiY~,~+O2i8lMSO!@#7=Q2GV}wOF;vdV)op]Mm{o;jt#Z-3~bYbRh,[l~Ji$' );
define( 'NONCE_KEY',        'tDG,7f|KRM:yHO2:m2S57PZ$[p{lrS`Rjf%zxVI{=U.j]{4vn6p80EV[ir,CV7VO' );
define( 'AUTH_SALT',        '1cqxyi>FpZcIGb]jS_~:BF_&Z=h+C&,s~U{JNbsIw%?^oI8b*G53{i(O:YM:di.2' );
define( 'SECURE_AUTH_SALT', 'Z`Nb^$q+?y?-o_:U$4kGm(cAF|ALy@eNXZ5.1@34s;Lcvu~m@z!~R@mwA4S2NJaZ' );
define( 'LOGGED_IN_SALT',   'YMy/_3L><@%J.YooRhdxhH;s817: )A31eDQZ2Lzdu[eJwCW7+lzG.<qmA`2n&<O' );
define( 'NONCE_SALT',       ']bUG@uCR]i?KU};vMoft|Bk&_C;UtUNu#V$2*#uZ#ku%yz}[bZ-qcafEOFU@,6&o' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
