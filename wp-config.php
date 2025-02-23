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
define( 'DB_NAME', 'products' );

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
define( 'AUTH_KEY',         '1@E#$MEA _rRqYK<:Ew1|3Jw$Y]Xf4raUO+C?Sea*`+F9]q^LqrhTcL%D^ACV*{c' );
define( 'SECURE_AUTH_KEY',  'G [RzE7(?ssC!*~>5u^C?,/iqly^Ow,2D@8KUTM0w3^P3;#=-]tCSHp0vAD[@yr_' );
define( 'LOGGED_IN_KEY',    ',qaAJ^wNOUIYqgoahOhZiJvK8Pf`u#kBp+i$`!iC/#$TAYnB7tQ$^4i2G_2.79AB' );
define( 'NONCE_KEY',        'b(rg#=_/2RQe!6Fu-h~LC1q{SLl*`=/:=mY,t>p]d#ZhNT`pC9#j`&)ct:rEo>7f' );
define( 'AUTH_SALT',        '$>f&R^,tp^{I4)?![Xqq78kG/W)J9[u1+b!5ncx:P.8PLQIqM[`TZ|UiOVANaXs#' );
define( 'SECURE_AUTH_SALT', '4>6y^%sy=U]<A}7IL&Y7C0Z)Z?tcU]ka|dCtmT&P=~^H#~Bx|w-.-nzyA/85o+Iy' );
define( 'LOGGED_IN_SALT',   'E>uu`;H=?0~hd(+9a1BB2`Ks0^[3u22su.uxE>dw5R`IO=UuNu)}U64s:.P*?(K>' );
define( 'NONCE_SALT',       '}0?QOy%F-{+o,69@-u0izGap5.=4*38!iT#/t?h3EPZ$!=g.X([56]C-^x]/5vZl' );

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
