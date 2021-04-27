<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'm2p_demo' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'VEk7>t<Dt8D7OHYa=mr-+)}NJ]_jf40pa7C_lUiEQxHnV{$S{L}rqLIAIoKmjT{Z' );
define( 'SECURE_AUTH_KEY',  'kR_rjw/&0TX-Az[ I=fOVJ7{M32c YiUq~6U]xDh-eRP^EOf=x~/Y^$jUVVrQnL=' );
define( 'LOGGED_IN_KEY',    '<Wdm%n~W+xuDG;jfSJe<5l9mq@@)2]=}Ul!9xLl%E_VmSkhYkp[ ++S$2E(T`iQ%' );
define( 'NONCE_KEY',        'zk@f&@p=BfT=ohj%=I)ej;y ^g)$ua8UENFb16A~={.f(Z2#+1dQ2^BL@^o?6Rhv' );
define( 'AUTH_SALT',        'Ooa9 vW]VtJNglTjrTbsS9U4mtM/?zA:r9rID7y6R}#LML}UuNqDQ`_xHa,q;](W' );
define( 'SECURE_AUTH_SALT', 'i,+ %L{_0?P#{:G:x|.db6,/*q-3s(2.ho;S2$k_PB`!2#KE!iPA`#y-N+Y&Z?T>' );
define( 'LOGGED_IN_SALT',   'Lj20LH%*@m%2hA|JOMc*%GIsT1PQJP&M`TDk-&zB{!Tc VP6U{;hqy7yWuM8y}_e' );
define( 'NONCE_SALT',       '=IhQ[Ll:1Q/|J H&eoDK#$#aSM>ds#kWmW$`1^z cC~1D@kE{)>g1&F7A#@E`lo|' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'm2p_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
