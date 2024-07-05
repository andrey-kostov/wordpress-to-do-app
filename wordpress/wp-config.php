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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv("DB_DATABASE") );

/** Database username */
define( 'DB_USER', getenv("DB_USERNAME") );

/** Database password */
define( 'DB_PASSWORD', getenv("DB_PASSWORD"));

/** Database hostname */
define( 'DB_HOST', getenv("DB_HOSTNAME") );

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
define( 'AUTH_KEY',         '=+Da;@Iq;`oZf#%J,c&&Fp7oi+0+Oz{Op;$z~K0[Wch!fKdpV`5rk6*=)fBk(I$.' );
define( 'SECURE_AUTH_KEY',  'Cm.K$xWtr)|V$_n*L~^c4lr$Gil3}E0eP@H?9Wbw#sf0,~7D-2:yVN_8:/Yc>~,a' );
define( 'LOGGED_IN_KEY',    'D!fWYLfD<8[@:8O4$wRc [4W],L0eYl67&;Hp<3/]?,%0U.LOppJ2(0*IT^3B*bc' );
define( 'NONCE_KEY',        '/L;04)>gN+}bHP/=p~^E1tE%@AXJ.!i:5j6#26-0+)/FDVj9x/X>}&T89PbRgW+f' );
define( 'AUTH_SALT',        'yE:YO%nQ?lSUg#gL)6c.;^^!$cu6l3Vl<O~mGBlyq/a 8 b[_yRgwGyY8R]|_Ct ' );
define( 'SECURE_AUTH_SALT', 'V|i==N]20?seds9?r&AeknI&(IAt[J/la[U>dwc25rn|G7m`5Wpx]ark<$h~;0m_' );
define( 'LOGGED_IN_SALT',   '<HE!pB~SBjid@AMC; Y-T$i@%XCm}M)W~Z)QpATzcG u#{.!lmAaJ_iPdk}OhCK:' );
define( 'NONCE_SALT',       '12}E pu%)z2<L4uKt[s.Jio-1W|fl3h&dS2[l/o/<_|_h4gmem-,7g(LGwc||m2,' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
